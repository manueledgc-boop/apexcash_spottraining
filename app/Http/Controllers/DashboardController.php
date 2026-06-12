<?php

namespace App\Http\Controllers;

use App\Models\TrainingResult;
use App\Models\TrainingSession;
use App\Models\UserLeak;
use App\Models\UserTrainingStat;
use Illuminate\View\View;
use App\Models\UserSpotStat;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $global = UserTrainingStat::query()
            ->where('user_id', $userId)
            ->where('module', 'global')
            ->first();

        $preflopGlobal = UserTrainingStat::query()
            ->where('user_id', $userId)
            ->where('module', 'preflop_global')
            ->first();

        $flopGlobal = UserTrainingStat::query()
            ->where('user_id', $userId)
            ->where('module', 'postflop_flop')
            ->first();

        $turnGlobal = UserTrainingStat::query()
            ->where('user_id', $userId)
            ->where('module', 'postflop_turn')
            ->first();

        $riverGlobal = UserTrainingStat::query()
            ->where('user_id', $userId)
            ->where('module', 'postflop_river')
            ->first();

        $xp = (int) ($global->xp ?? 0);

        $preflopAccuracy = (float) ($preflopGlobal->accuracy ?? 0);
        $flopAccuracy = (float) ($flopGlobal->accuracy ?? 0);
        $turnAccuracy = (float) ($turnGlobal->accuracy ?? 0);
        $riverAccuracy = (float) ($riverGlobal->accuracy ?? 0);

        $flopUnlocked =
            $xp >= 1000 &&
            $preflopAccuracy >= 70;

        $turnUnlocked =
            $xp >= 3000 &&
            $flopAccuracy >= 70;

        $riverUnlocked =
            $xp >= 6000 &&
            $turnAccuracy >= 70;

        $masteryUnlocked =
            $xp >= 10000 &&
            $riverAccuracy >= 70;

        $nextGoal = 'Desbloquear Flop';

        if ($flopUnlocked) {
            $nextGoal = 'Desbloquear Turn';
        }

        if ($turnUnlocked) {
            $nextGoal = 'Desbloquear River';
        }

        if ($riverUnlocked) {
            $nextGoal = 'Mastery';
        }

        if ($masteryUnlocked) {
            $nextGoal = 'Completado';
        }

        $stageModules = [
            'global',
            'preflop_global',
            'postflop_flop',
            'postflop_turn',
            'postflop_river',
        ];

        $postflopModules = [
            // FLOP
            'cbet_ip',
            'check_back_ip',
            'defense_vs_cbet',
            'check_raise',
            'value_bet',
            'semi_bluff',

            // TURN
            'turn_barrel',
            'turn_probe',
            'turn_defense',
            'turn_check_raise',
            'turn_value_bet',
        ];

        $moduleStats = UserTrainingStat::query()
            ->where('user_id', $userId)
            ->whereNotIn('module', $stageModules)
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
            ->where('total', '>=', 2)
            ->orderBy('accuracy')
            ->orderByDesc('wrong')
            ->limit(5)
            ->get();

        $conceptLeaks = UserSpotStat::query()
            ->where('user_id', $userId)
            ->whereNotNull('concept')
            ->where('total', '>=', 2)
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
            ->orderBy('accuracy')
            ->orderByDesc('wrong')
            ->limit(5)
            ->get();

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
            'postflopModules',

            'nextGoal'
        ));
    }
}
