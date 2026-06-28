<?php

namespace App\Http\Controllers;

use App\Services\FreemiumTrainingAccessService;
use App\Services\PostflopTurnTrainingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class PostflopTurnTrainingController extends Controller
{
    public function __construct(protected PostflopTurnTrainingService $training)
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

        $freeLimitReached = $freemium->hasReachedFreeLimit('turn');
        $freeLimitMessage = $freeLimitReached
            ? $freemium->freeLimitMessage('turn')
            : null;

        if ($freeLimitReached) {
            session()->forget('postflop_turn_training.current_spot');

            return view('spot-training.turn', [
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

            session()->forget('postflop_turn_training.current_spot');

            $initialSpot = null;
            $freeLimitReached = true;
            $freeLimitMessage = $freemium->freeLimitMessage('turn');
        }

        return view('spot-training.turn', [
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
        if ($freemium->hasReachedFreeLimit('turn')) {
            session()->forget('postflop_turn_training.current_spot');

            return response()->json([
                'success' => false,
                'code' => 'FREE_LIMIT_REACHED',
                'message' => $freemium->freeLimitMessage('turn'),
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
                session()->forget('postflop_turn_training.current_spot');

                return response()->json([
                    'success' => false,
                    'code' => 'FREE_LIMIT_REACHED',
                    'message' => $freemium->freeLimitMessage('turn'),
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
        if ($freemium->hasReachedFreeLimit('turn')) {
            session()->forget('postflop_turn_training.current_spot');

            return response()->json([
                'success' => false,
                'code' => 'FREE_LIMIT_REACHED',
                'message' => $freemium->freeLimitMessage('turn'),
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

        return redirect()->route('postflop-turn.index');
    }
}