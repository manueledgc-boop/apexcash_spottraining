<?php

namespace App\Http\Controllers;

use App\Services\SpotTrainingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpotTrainingController extends Controller
{
    public function index(Request $request, SpotTrainingService $service): View
    {
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

        return view('spot-training.index', [
            'initialModule' => $module,
            'initialMode' => $mode,

            'initialSpot' => $spotId
                ? $service->nextSpot($module, $mode, 'gto', $spotId, $concept)
                : (
                    $module || $mode === 'leak' || $concept
                        ? $service->nextSpot($module, $mode, 'gto', null, $concept)
                        : ($service->currentSpot() ?? $service->nextSpot())
                ),

            'summary' => $service->summary(),
            'leaks' => $service->leakSummary(),
            'lifetime' => $service->lifetimeSummary(),
        ]);
    }

    public function next(Request $request, SpotTrainingService $service): JsonResponse
    {
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

        return response()->json([
            'success' => true,

            'spot' => $service->nextSpot(
                $module,
                $mode,
                'gto',
                $spotId,
                $concept
            ),

            'summary' => $service->summary(),
            'leaks' => $service->leakSummary(),
            'lifetime' => $service->lifetimeSummary(),
        ]);
    }

    public function answer(Request $request, SpotTrainingService $service): JsonResponse
    {
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