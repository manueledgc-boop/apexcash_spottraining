<?php

namespace App\Http\Controllers;

use App\Models\TrainingResult;
use App\Models\TrainingSession;
use App\Models\UserLeak;
use App\Models\UserSpotStat;
use App\Models\UserTrainingStat;
use App\Services\TrainingProgressionService;
use Illuminate\View\View;
use App\Models\FounderApplication;

class DashboardController extends Controller
{
    public function index(TrainingProgressionService $progression): View
    {
        $user = auth()->user();
        $userId = $user->id;

        $global = $progression->globalStats($user);
        $preflopGlobal = $progression->stageStats($user, 'preflop');
        $flopGlobal = $progression->stageStats($user, 'flop');
        $turnGlobal = $progression->stageStats($user, 'turn');
        $riverGlobal = $progression->stageStats($user, 'river');
        $masteryGlobal = $progression->stageStats($user, 'mastery');

        $progress = $progression->summary($user);

        $flopUnlocked = (bool) $progress['flop']['unlocked'];
        $turnUnlocked = (bool) $progress['turn']['unlocked'];
        $riverUnlocked = (bool) $progress['river']['unlocked'];
        $masteryUnlocked = (bool) $progress['mastery']['unlocked'];
        $certificationUnlocked = (bool) $progress['certification']['unlocked'];
        $nextGoal = $progression->nextGoal($user);
        $founderApplication = FounderApplication::query()
            ->where('user_id', $userId)
            ->latest()
            ->first();

        $stageModules = $progression->stageAggregateModules();

        $moduleStats = UserTrainingStat::query()
            ->where('user_id', $userId)
            ->whereNotIn('module', $stageModules)
            ->orderBy('accuracy')
            ->orderByDesc('total_spots')
            ->get();

        $rankedModules = $moduleStats
            ->where('total_spots', '>=', 10)
            ->values();

        $bestModule = null;
        $worstModule = null;

        if ($rankedModules->count() >= 1) {

            $bestModule = $rankedModules
                ->sortByDesc('accuracy')
                ->first();

            if ($rankedModules->count() >= 2) {

                $candidateWorst = $rankedModules
                    ->where('accuracy', '<', 75)
                    ->sortBy('accuracy')
                    ->first();

                if (
                    $candidateWorst &&
                    $bestModule &&
                    $candidateWorst->module !== $bestModule->module
                ) {
                    $worstModule = $candidateWorst;
                }
            }
        }

        $leaks = UserLeak::query()
            ->where('user_id', $userId)
            ->where('total', '>=', 5)
            ->where('accuracy', '<', 75)
            ->orderByDesc('weakness_score')
            ->orderBy('accuracy')
            ->limit(5)
            ->get();

        $criticalLeak = UserLeak::query()
            ->where('user_id', $userId)
            ->where('total', '>=', 5)
            ->where('accuracy', '<', 65)
            ->orderByDesc('weakness_score')
            ->orderBy('accuracy')
            ->first();

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

        $worstSpots = UserSpotStat::query()
            ->where('user_id', $userId)
            ->where('total', '>=', 5)
            ->where('accuracy', '<', 75)
            ->orderBy('accuracy')
            ->orderByDesc('wrong')
            ->limit(5)
            ->get();

        $conceptLeaks = UserSpotStat::query()
            ->where('user_id', $userId)
            ->whereNotNull('concept')
            ->where('total', '>=', 5)
            ->selectRaw('
                module,
                concept,
                concept_label,
                family_label,
                SUM(total) as total,
                SUM(correct) as correct,
                SUM(wrong) as wrong,
                ROUND((SUM(correct) / NULLIF(SUM(total), 0)) * 100, 2) as accuracy
            ')
            ->groupBy('module', 'concept', 'concept_label', 'family_label')
            ->havingRaw('accuracy < 75')
            ->orderBy('accuracy')
            ->orderByDesc('wrong')
            ->limit(5)
            ->get();

        $routeForModule = fn (?string $module): string => $progression->routeForModule($module);

        return view('dashboard', compact(
            'global',
            'moduleStats',
            'bestModule',
            'worstModule',
            'leaks',
            'criticalLeak',
            'recentResults',
            'recentSessions',
            'worstSpots',
            'conceptLeaks',
            'preflopGlobal',
            'flopGlobal',
            'turnGlobal',
            'riverGlobal',
            'flopUnlocked',
            'turnUnlocked',
            'riverUnlocked',
            'masteryUnlocked',
            'nextGoal',
            'masteryGlobal',
            'certificationUnlocked',
            'routeForModule',
            'founderApplication',
        ));
    }
}
