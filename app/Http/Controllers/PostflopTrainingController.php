<?php

namespace App\Http\Controllers;

use App\Services\FreemiumTrainingAccessService;
use App\Services\PostflopTrainingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class PostflopTrainingController extends Controller
{
    public function index(
        Request $request,
        PostflopTrainingService $service,
        FreemiumTrainingAccessService $freemium
    ): View {
        $module = $request->query('module');
        $module = is_string($module) && $module !== '' ? $module : null;

        $mode = $request->query('mode');
        $mode = is_string($mode) && $mode !== '' ? $mode : 'normal';

        $spotId = $request->query('spot_id');
        $spotId = is_string($spotId) && $spotId !== '' ? $spotId : null;

        $concept = $request->query('concept');
        $concept = is_string($concept) && $concept !== '' ? $concept : null;

        $freeLimitReached = $freemium->hasReachedFreeLimit('flop');
        $freeLimitMessage = $freeLimitReached
            ? $freemium->freeLimitMessage('flop')
            : null;

        if ($freeLimitReached) {
            session()->forget('postflop_training.current_spot');

            return view('spot-training.postflop', [
                'initialModule' => $module,
                'initialMode' => $mode,
                'initialSpot' => null,
                'summary' => $service->summary(),
                'leaks' => $service->leakSummary(),
                'lifetime' => $service->lifetimeSummary(),
                'freeLimitReached' => true,
                'freeLimitMessage' => $freeLimitMessage,
            ]);
        }

        try {
            $initialSpot = ($spotId || $module || $concept)
                ? $service->nextSpot($module, $mode, $spotId, $concept)
                : ($service->currentSpot() ?? $service->nextSpot($module, $mode, null, $concept));
        } catch (RuntimeException $e) {
            if ($e->getMessage() !== 'FREE_LIMIT_REACHED') {
                throw $e;
            }

            session()->forget('postflop_training.current_spot');

            $initialSpot = null;
            $freeLimitReached = true;
            $freeLimitMessage = $freemium->freeLimitMessage('flop');
        }

        return view('spot-training.postflop', [
            'initialModule' => $module,
            'initialMode' => $mode,
            'initialSpot' => $initialSpot,
            'summary' => $service->summary(),
            'leaks' => $service->leakSummary(),
            'lifetime' => $service->lifetimeSummary(),
            'freeLimitReached' => $freeLimitReached,
            'freeLimitMessage' => $freeLimitMessage,
        ]);
    }

    public function next(
        Request $request,
        PostflopTrainingService $service,
        FreemiumTrainingAccessService $freemium
    ): JsonResponse {
        if ($freemium->hasReachedFreeLimit('flop')) {
            session()->forget('postflop_training.current_spot');

            return response()->json([
                'success' => false,
                'code' => 'FREE_LIMIT_REACHED',
                'message' => $freemium->freeLimitMessage('flop'),
            ]);
        }

        $module = $request->query('module');
        $module = is_string($module) && $module !== '' ? $module : null;

        $mode = $request->query('mode');
        $mode = is_string($mode) && $mode !== '' ? $mode : 'normal';

        $spotId = $request->query('spot_id');
        $spotId = is_string($spotId) && $spotId !== '' ? $spotId : null;

        $concept = $request->query('concept');
        $concept = is_string($concept) && $concept !== '' ? $concept : null;

        try {
            $spot = $service->nextSpot($module, $mode, $spotId, $concept);
        } catch (RuntimeException $e) {
            if ($e->getMessage() === 'FREE_LIMIT_REACHED') {
                session()->forget('postflop_training.current_spot');

                return response()->json([
                    'success' => false,
                    'code' => 'FREE_LIMIT_REACHED',
                    'message' => $freemium->freeLimitMessage('flop'),
                ]);
            }

            throw $e;
        }

        return response()->json([
            'success' => true,
            'spot' => $spot,
            'summary' => $service->summary(),
            'leaks' => $service->leakSummary(),
            'lifetime' => $service->lifetimeSummary(),
        ]);
    }

    public function answer(
        Request $request,
        PostflopTrainingService $service,
        FreemiumTrainingAccessService $freemium
    ): JsonResponse {
        if ($freemium->hasReachedFreeLimit('flop')) {
            session()->forget('postflop_training.current_spot');

            return response()->json([
                'success' => false,
                'code' => 'FREE_LIMIT_REACHED',
                'message' => $freemium->freeLimitMessage('flop'),
            ]);
        }

        $validated = $request->validate([
            'answer' => ['required', 'string', 'max:20'],
        ]);

        $result = $service->evaluateAnswer($validated['answer']);
        $result['summary'] = $service->summary();

        return response()->json($result);
    }

    public function reset(PostflopTrainingService $service): RedirectResponse
    {
        $service->reset();

        return redirect()->route('postflop-training.index');
    }
}