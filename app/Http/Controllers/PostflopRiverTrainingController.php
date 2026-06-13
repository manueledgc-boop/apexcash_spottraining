<?php

namespace App\Http\Controllers;

use App\Services\PostflopRiverTrainingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostflopRiverTrainingController extends Controller
{
    public function __construct(protected PostflopRiverTrainingService $training)
    {
    }

    public function index(Request $request): View
    {
        $initialModule = $request->query('module');
        $initialMode = $request->query('mode', 'normal');
        $spotId = $request->query('spot_id');
        $concept = $request->query('concept');

        $initialSpot = $this->training->nextSpot($initialModule, $initialMode, $spotId, $concept);

        return view('spot-training.river', [
            'initialSpot' => $initialSpot,
            'summary' => $this->training->summary(),
            'leaks' => $this->training->leakSummary(),
            'lifetime' => $this->training->lifetimeSummary(),
            'initialModule' => $initialModule,
            'initialMode' => $initialMode,
        ]);
    }

    public function next(Request $request): JsonResponse
    {
        $spot = $this->training->nextSpot(
            $request->query('module'),
            $request->query('mode', 'normal'),
            $request->query('spot_id'),
            $request->query('concept')
        );

        return response()->json([
            'success' => true,
            'spot' => $spot,
            'summary' => $this->training->summary(),
            'leaks' => $this->training->leakSummary(),
            'lifetime' => $this->training->lifetimeSummary(),
        ]);
    }

    public function answer(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'answer' => ['required', 'string'],
        ]);

        return response()->json($this->training->evaluateAnswer($validated['answer']));
    }

    public function reset(): RedirectResponse
    {
        $this->training->reset();

        return redirect()->route('postflop-river.index');
    }
}
