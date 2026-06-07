<?php

namespace App\Http\Controllers;

use App\Services\SpotTrainingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpotTrainingController extends Controller
{
    public function index(SpotTrainingService $service): View
    {
        return view('spot-training.index', [
            'initialSpot' => $service->currentSpot() ?? $service->nextSpot(),
            'summary' => $service->summary(),
        ]);
    }

    public function next(Request $request, SpotTrainingService $service): JsonResponse
    {
        $module = $request->query('module');

        return response()->json([
            'success' => true,
            'spot' => $service->nextSpot(is_string($module) ? $module : null),
            'summary' => $service->summary(),
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
