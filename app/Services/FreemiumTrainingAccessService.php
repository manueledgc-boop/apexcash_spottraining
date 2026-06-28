<?php

namespace App\Services;

use App\Models\TrainingResult;
use Illuminate\Support\Facades\Auth;

class FreemiumTrainingAccessService
{
    public function limitForStage(string $stage): ?int
    {
        if (Auth::user()?->hasPremiumAccess()) {
            return null;
        }

        return match ($stage) {
            'preflop' => 20,
            'flop' => 10,
            'turn' => 10,
            'river' => 10,
            'mastery' => 10,
            default => null,
        };
    }

    public function hasReachedFreeLimit(string $stage): bool
    {
        $userId = Auth::id();

        if (! $userId || Auth::user()?->hasPremiumAccess()) {
            return false;
        }

        $limit = $this->limitForStage($stage);

        if ($limit === null) {
            return false;
        }

        $query = TrainingResult::query()
            ->where('user_id', $userId);

        if ($stage === 'preflop') {
            $query->whereIn('module', [
                'open_raise',
                'btn_vs_3bet',
                'bb_vs_btn',
                'threebet_vs_open',
                'sb_vs_btn',
                'bb_vs_sb',
            ]);
        }

        if ($stage === 'flop') {
            $query->whereIn('module', [
                'cbet_ip',
                'check_back_ip',
                'defense_vs_cbet',
                'check_raise',
                'value_bet',
                'semi_bluff',
                'overbet',
                'donk_bet',
                'float',
            ]);
        }

        if ($stage === 'turn') {
            $query->whereIn('module', [
                'turn_barrel',
                'turn_probe',
                'turn_defense',
                'turn_value_bet',
                'turn_check_raise',
            ]);
        }

        if ($stage === 'river') {
            $query->whereIn('module', [
                'river_value_bet',
                'river_bluff_catch',
                'river_bluff',
                'river_thin_value',
                'river_overbet',
            ]);
        }

        if ($stage === 'mastery') {
            $query->whereIn('module', [
                'three_bet_pots',
                'four_bet_pots',
                'blind_vs_blind_advanced',
                'multiway',
                'short_stack_lab',
                'tournament_lab',
            ]);
        }

        $answered = $query
            ->where('created_at', '>=', now()->subDay())
            ->distinct('spot_id')
            ->count('spot_id');

        return $answered >= $limit;
    }

    public function freeLimitMessage(string $stage): string
    {
        return match ($stage) {
            'preflop' => 'Has completado el límite gratuito de Preflop por hoy. Actualiza a Premium para continuar.',
            'flop' => 'Has completado el límite gratuito de Flop por hoy. Actualiza a Premium para continuar.',
            'turn' => 'Has completado el límite gratuito de Turn. Actualiza a Premium para continuar.',
            'river' => 'Has completado el límite gratuito de River. Actualiza a Premium para continuar.',
            'mastery' => 'Has completado el límite gratuito de Mastery. Actualiza a Premium para continuar.',
            default => 'Has completado el límite gratuito de este módulo. Actualiza a Premium para continuar.',
        };
    }
}