<?php

namespace App\Http\Controllers;

use App\Models\CertificationAttempt;
use App\Services\TrainingProgressionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CertificationController extends Controller
{
    public function index(TrainingProgressionService $progression): View
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

        return view('certification.index', [
            'progress' => $progress,
            'certificationUnlocked' => $certificationUnlocked,
            'latestAttempt' => $latestAttempt,
            'passedAttempt' => $passedAttempt,
        ]);
    }

    public function start(TrainingProgressionService $progression): RedirectResponse
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

        return redirect()
            ->route('certification.index')
            ->with('success', 'El inicio del examen quedará implementado en el siguiente paso.');
    }
}