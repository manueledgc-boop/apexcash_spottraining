<?php

namespace App\Http\Controllers;

use App\Services\FreemiumTrainingAccessService;
use App\Services\MasteryTrainingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class MasteryTrainingController extends Controller
{
    public function __construct(protected MasteryTrainingService $training)
    {
    }

    public function index(
        Request $request,
        FreemiumTrainingAccessService $freemium
    ): View {
        $initialModule = $request->query('module');
        $initialModule = is_string($initialModule) && $initialModule !== '' ? $initialModule : null;

        $initialMode = $request->query('mode', 'normal');
        $initialMode = is_string($initialMode) && $initialMode !== '' ? $initialMode : 'normal';

        $spotId = $request->query('spot_id');
        $spotId = is_string($spotId) && $spotId !== '' ? $spotId : null;

        $concept = $request->query('concept');
        $concept = is_string($concept) && $concept !== '' ? $concept : null;

        $freeLimitReached = $freemium->hasReachedFreeLimit('mastery');
        $freeLimitMessage = $freeLimitReached
            ? $freemium->freeLimitMessage('mastery')
            : null;

        if ($freeLimitReached) {
            session()->forget('mastery_training.current_spot');

            return view('spot-training.mastery', [
                'initialSpot' => null,
                'summary' => $this->training->summary(),
                'leaks' => $this->training->leakSummary(),
                'lifetime' => $this->training->lifetimeSummary(),
                'initialModule' => $initialModule,
                'initialMode' => $initialMode,
                'freeLimitReached' => true,
                'freeLimitMessage' => $freeLimitMessage,
            ]);
        }

        try {
            $initialSpot = $this->training->nextSpot(
                $initialModule,
                $initialMode,
                $spotId,
                $concept
            );
        } catch (RuntimeException $e) {
            if ($e->getMessage() !== 'FREE_LIMIT_REACHED') {
                throw $e;
            }

            session()->forget('mastery_training.current_spot');

            $initialSpot = null;
            $freeLimitReached = true;
            $freeLimitMessage = $freemium->freeLimitMessage('mastery');
        }

        return view('spot-training.mastery', [
            'initialSpot' => $initialSpot,
            'summary' => $this->training->summary(),
            'leaks' => $this->training->leakSummary(),
            'lifetime' => $this->training->lifetimeSummary(),
            'initialModule' => $initialModule,
            'initialMode' => $initialMode,
            'freeLimitReached' => $freeLimitReached,
            'freeLimitMessage' => $freeLimitMessage,
        ]);
    }

    public function next(
        Request $request,
        FreemiumTrainingAccessService $freemium
    ): JsonResponse {
        if ($freemium->hasReachedFreeLimit('mastery')) {
            session()->forget('mastery_training.current_spot');

            return response()->json([
                'success' => false,
                'code' => 'FREE_LIMIT_REACHED',
                'message' => $freemium->freeLimitMessage('mastery'),
            ]);
        }

        try {
            $spot = $this->training->nextSpot(
                $request->query('module'),
                $request->query('mode', 'normal'),
                $request->query('spot_id'),
                $request->query('concept')
            );
        } catch (RuntimeException $e) {
            if ($e->getMessage() === 'FREE_LIMIT_REACHED') {
                session()->forget('mastery_training.current_spot');

                return response()->json([
                    'success' => false,
                    'code' => 'FREE_LIMIT_REACHED',
                    'message' => $freemium->freeLimitMessage('mastery'),
                ]);
            }

            throw $e;
        }

        return response()->json([
            'success' => true,
            'spot' => $spot,
            'summary' => $this->training->summary(),
            'leaks' => $this->training->leakSummary(),
            'lifetime' => $this->training->lifetimeSummary(),
        ]);
    }

    public function answer(
        Request $request,
        FreemiumTrainingAccessService $freemium
    ): JsonResponse {
        if ($freemium->hasReachedFreeLimit('mastery')) {
            session()->forget('mastery_training.current_spot');

            return response()->json([
                'success' => false,
                'code' => 'FREE_LIMIT_REACHED',
                'message' => $freemium->freeLimitMessage('mastery'),
            ]);
        }

        $validated = $request->validate([
            'answer' => ['required', 'string'],
        ]);

        return response()->json($this->training->evaluateAnswer($validated['answer']));
    }

    public function reset(): RedirectResponse
    {
        $this->training->reset();

        return redirect()->route('mastery-training.index');
    }
}