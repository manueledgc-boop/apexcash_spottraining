<?php

namespace App\Http\Controllers;

use App\Services\FreemiumTrainingAccessService;
use App\Services\SpotTrainingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class SpotTrainingController extends Controller
{
    public function index(
        Request $request,
        SpotTrainingService $service,
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

        if ($concept) {
            session(['spot_training.current_concept' => $concept]);
        } elseif ($module || $spotId) {
            session()->forget('spot_training.current_concept');
        }

        $freeLimitReached = $freemium->hasReachedFreeLimit('preflop');
        $freeLimitMessage = $freeLimitReached
            ? $freemium->freeLimitMessage('preflop')
            : null;

        if ($freeLimitReached) {
            session()->forget('spot_training.current_spot');

            return view('spot-training.index', [
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
            $initialSpot = $spotId
                ? $service->nextSpot($module, $mode, 'gto', $spotId, $concept)
                : (
                    $module || $mode === 'leak' || $concept
                        ? $service->nextSpot($module, $mode, 'gto', null, $concept)
                        : ($service->currentSpot() ?? $service->nextSpot())
                );
        } catch (RuntimeException $e) {
            if ($e->getMessage() !== 'FREE_LIMIT_REACHED') {
                throw $e;
            }

            session()->forget('spot_training.current_spot');

            $initialSpot = null;
            $freeLimitReached = true;
            $freeLimitMessage = $freemium->freeLimitMessage('preflop');
        }

        return view('spot-training.index', [
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
        SpotTrainingService $service,
        FreemiumTrainingAccessService $freemium
    ): JsonResponse {
        if ($freemium->hasReachedFreeLimit('preflop')) {
            session()->forget('spot_training.current_spot');

            return response()->json([
                'success' => false,
                'code' => 'FREE_LIMIT_REACHED',
                'message' => $freemium->freeLimitMessage('preflop'),
            ]);
        }

        $module = $request->query('module');
        $mode = $request->query('mode');
        $spotId = $request->query('spot_id');
        $concept = $request->query('concept');

        $module = is_string($module) && $module !== '' ? $module : null;
        $mode = is_string($mode) && $mode !== '' ? $mode : 'normal';
        $spotId = is_string($spotId) && $spotId !== '' ? $spotId : null;

        $concept = is_string($concept) && $concept !== ''
            ? $concept
            : session('spot_training.current_concept');

        if ($module) {
            session()->forget('spot_training.current_concept');
            $concept = null;
        } elseif ($concept) {
            session(['spot_training.current_concept' => $concept]);
        }

        try {
            $spot = $service->nextSpot(
                $module,
                $mode,
                'gto',
                $spotId,
                $concept
            );
        } catch (RuntimeException $e) {
            if ($e->getMessage() === 'FREE_LIMIT_REACHED') {
                session()->forget('spot_training.current_spot');

                return response()->json([
                    'success' => false,
                    'code' => 'FREE_LIMIT_REACHED',
                    'message' => $freemium->freeLimitMessage('preflop'),
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
        SpotTrainingService $service,
        FreemiumTrainingAccessService $freemium
    ): JsonResponse {
        if ($freemium->hasReachedFreeLimit('preflop')) {
            session()->forget('spot_training.current_spot');

            return response()->json([
                'success' => false,
                'code' => 'FREE_LIMIT_REACHED',
                'message' => $freemium->freeLimitMessage('preflop'),
            ]);
        }

        $validated = $request->validate([
            'answer' => ['required', 'string', 'max:20'],
        ]);

        $result = $service->evaluateAnswer($validated['answer']);
        $result['summary'] = $service->summary();

        return response()->json($result);
    }

    public function reset(SpotTrainingService $service): RedirectResponse
    {
        $service->reset();

        return redirect()->route('spot-training.index');
    }
}