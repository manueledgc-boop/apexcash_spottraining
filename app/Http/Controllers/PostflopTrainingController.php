<?php

namespace App\Http\Controllers;

use App\Services\PostflopTrainingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostflopTrainingController extends Controller
{
    public function index(Request $request, PostflopTrainingService $service): View
    {
        $module = $request->query('module');
        $module = is_string($module) && $module !== '' ? $module : null;

        $mode = $request->query('mode');
        $mode = is_string($mode) && $mode !== '' ? $mode : 'normal';

        $spotId = $request->query('spot_id');
        $spotId = is_string($spotId) && $spotId !== '' ? $spotId : null;

        $concept = $request->query('concept');
        $concept = is_string($concept) && $concept !== '' ? $concept : null;

        return view('spot-training.postflop', [
            'initialModule' => $module,
            'initialMode' => $mode,
            'initialSpot' => ($spotId || $module || $concept)
                ? $service->nextSpot($module, $mode, $spotId, $concept)
                : ($service->currentSpot() ?? $service->nextSpot($module, $mode, null, $concept)),
            'summary' => $service->summary(),
            'leaks' => $service->leakSummary(),
            'lifetime' => $service->lifetimeSummary(),
        ]);
    }

    public function next(Request $request, PostflopTrainingService $service): JsonResponse
    {
        $module = $request->query('module');
        $module = is_string($module) && $module !== '' ? $module : null;

        $mode = $request->query('mode');
        $mode = is_string($mode) && $mode !== '' ? $mode : 'normal';

        $spotId = $request->query('spot_id');
        $spotId = is_string($spotId) && $spotId !== '' ? $spotId : null;

        $concept = $request->query('concept');
        $concept = is_string($concept) && $concept !== '' ? $concept : null;

        return response()->json([
            'success' => true,
            'spot' => $service->nextSpot($module, $mode, $spotId, $concept),
            'summary' => $service->summary(),
            'leaks' => $service->leakSummary(),
            'lifetime' => $service->lifetimeSummary(),
        ]);
    }

    public function answer(Request $request, PostflopTrainingService $service): JsonResponse
    {
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
