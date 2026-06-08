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

        return view('spot-training.index', [
            'initialModule' => $module,
            'initialSpot' => $module ? $service->nextSpot($module) : ($service->currentSpot() ?? $service->nextSpot()),
            'summary' => $service->summary(),
            'leaks' => $service->leakSummary(),
            'lifetime' => $service->lifetimeSummary(),
        ]);
    }

    public function next(Request $request, SpotTrainingService $service): JsonResponse
    {
        $module = $request->query('module');

        return response()->json([
            'success' => true,
            'spot' => $service->nextSpot(is_string($module) ? $module : null),
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
