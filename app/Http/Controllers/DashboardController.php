<?php

namespace App\Http\Controllers;

use App\Models\TrainingResult;
use App\Models\TrainingSession;
use App\Models\UserLeak;
use App\Models\UserTrainingStat;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $global = UserTrainingStat::query()
            ->where('user_id', $userId)
            ->where('module', 'global')
            ->first();

        $moduleStats = UserTrainingStat::query()
            ->where('user_id', $userId)
            ->where('module', '!=', 'global')
            ->orderBy('accuracy')
            ->orderByDesc('total_spots')
            ->get();

        $bestModule = (clone $moduleStats)
            ->where('total_spots', '>=', 3)
            ->sortByDesc('accuracy')
            ->first();

        $worstModule = (clone $moduleStats)
            ->where('total_spots', '>=', 3)
            ->sortBy('accuracy')
            ->first();

        $leaks = UserLeak::query()
            ->where('user_id', $userId)
            ->where('total', '>=', 1)
            ->orderByDesc('weakness_score')
            ->orderBy('accuracy')
            ->limit(5)
            ->get();

        $recentResults = TrainingResult::query()
            ->where('user_id', $userId)
            ->latest()
            ->limit(8)
            ->get();

        $recentSessions = TrainingSession::query()
            ->where('user_id', $userId)
            ->latest()
            ->limit(4)
            ->get();

        return view('dashboard', compact(
            'global',
            'moduleStats',
            'bestModule',
            'worstModule',
            'leaks',
            'recentResults',
            'recentSessions'
        ));
    }
}
