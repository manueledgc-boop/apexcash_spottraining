<?php

namespace App\Http\Controllers;

use App\Models\CertificationAttempt;
use App\Services\CertificationService;
use App\Services\TrainingProgressionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificationController extends Controller
{
    public function index(TrainingProgressionService $progression, CertificationService $certification): View
    {
        $user = auth()->user();

        $progress = $progression->summary($user);
        $certificationUnlocked = (bool) ($progress['certification']['unlocked'] ?? false);

        $latestAttempt = CertificationAttempt::query()
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        $passedAttempt = CertificationAttempt::query()
            ->where('user_id', $user->id)
            ->where('passed', true)
            ->latest('completed_at')
            ->first();

        $activeAttempt = $certification->activeAttempt($user);

        return view('certification.index', [
            'progress' => $progress,
            'certificationUnlocked' => $certificationUnlocked,
            'latestAttempt' => $latestAttempt,
            'passedAttempt' => $passedAttempt,
            'activeAttempt' => $activeAttempt,
        ]);
    }

    public function start(TrainingProgressionService $progression, CertificationService $certification): RedirectResponse
    {
        $user = auth()->user();

        $progress = $progression->summary($user);
        $certificationUnlocked = (bool) ($progress['certification']['unlocked'] ?? false);

        if (! $certificationUnlocked) {
            return redirect()
                ->route('certification.index')
                ->with('error', 'La certificación todavía está bloqueada por progreso.');
        }

        $latestAttempt = CertificationAttempt::query()
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        if ($latestAttempt && $latestAttempt->isLockedForRetry()) {
            return redirect()
                ->route('certification.index')
                ->with('error', 'Debes esperar hasta la próxima fecha disponible para volver a presentar la certificación.');
        }

        $attempt = $certification->startAttempt($user);

        return redirect()->route('certification.exam', $attempt);
    }

    public function exam(CertificationAttempt $attempt, CertificationService $certification): View|RedirectResponse
    {
        $this->authorizeAttempt($attempt);

        if ($attempt->completed_at) {
            return redirect()->route('certification.result', $attempt);
        }

        if ($certification->isExpired($attempt)) {
            $attempt = $certification->finishAttempt($attempt);

            return redirect()
                ->route('certification.result', $attempt)
                ->with('error', 'Tiempo agotado. Tu examen ha sido enviado automáticamente.');
        }

        $question = $certification->currentQuestion($attempt);

        if (! $question) {
            $attempt = $certification->finishAttempt($attempt);

            return redirect()->route('certification.result', $attempt);
        }

        return view('certification.exam', [
            'attempt' => $attempt,
            'question' => $question,
            'questionNumber' => $certification->currentQuestionNumber($attempt),
            'totalQuestions' => CertificationService::TOTAL_QUESTIONS,
            'secondsRemaining' => max(0, now()->diffInSeconds($attempt->expires_at, false)),
        ]);
    }

    public function answer(Request $request, CertificationAttempt $attempt, CertificationService $certification): RedirectResponse
    {
        $this->authorizeAttempt($attempt);

        $validated = $request->validate([
            'answer' => ['required', 'string'],
        ]);

        $attempt = $certification->answerCurrentQuestion($attempt, $validated['answer']);

        if ($attempt->completed_at) {
            return redirect()->route('certification.result', $attempt);
        }

        return redirect()->route('certification.exam', $attempt);
    }

    public function finish(CertificationAttempt $attempt, CertificationService $certification): RedirectResponse
    {
        $this->authorizeAttempt($attempt);

        $answersCount = count($attempt->answers_snapshot ?? []);
        $canFinish = $certification->isExpired($attempt) || $answersCount >= CertificationService::TOTAL_QUESTIONS;

        if (! $canFinish) {
            return redirect()
                ->route('certification.exam', $attempt)
                ->with('error', 'Debes responder todas las preguntas antes de finalizar el examen.');
        }

        $attempt = $certification->finishAttempt($attempt);

        return redirect()->route('certification.result', $attempt);
    }

    public function result(CertificationAttempt $attempt): View
    {
        $this->authorizeAttempt($attempt);

        if (! $attempt->completed_at) {
            abort(404);
        }

        return view('certification.result', [
            'attempt' => $attempt,
        ]);
    }

    protected function authorizeAttempt(CertificationAttempt $attempt): void
    {
        abort_unless((int) $attempt->user_id === (int) auth()->id(), 403);
    }
}
