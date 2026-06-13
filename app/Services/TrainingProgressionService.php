<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserTrainingStat;
use Illuminate\Support\Collection;

class TrainingProgressionService
{
    public const FLOP_XP_REQUIRED = 1000;
    public const TURN_XP_REQUIRED = 3000;
    public const RIVER_XP_REQUIRED = 6000;
    public const MASTERY_XP_REQUIRED = 10000;

    public const PREFLOP_ACCURACY_REQUIRED = 70.0;
    public const FLOP_ACCURACY_REQUIRED = 70.0;
    public const TURN_ACCURACY_REQUIRED = 70.0;
    public const RIVER_ACCURACY_REQUIRED = 75.0;

    /*
     * Evita el bug clásico:
     * 1 acierto de 1 spot = 100% y desbloquea demasiado pronto.
     */
    public const MIN_STAGE_SAMPLE = 30;

    public function preflopModules(): array
    {
        return [
            'open_raise',
            'bb_vs_btn',
            'bb_vs_sb',
            'sb_vs_btn',
            'btn_vs_3bet',
            'three_bet_vs_open',
            '3bet_vs_open',
        ];
    }

    public function flopModules(): array
    {
        return [
            'cbet_ip',
            'check_back_ip',
            'defense_vs_cbet',
            'check_raise',
            'value_bet',
            'semi_bluff',
        ];
    }

    public function turnModules(): array
    {
        return [
            'turn_barrel',
            'turn_probe',
            'turn_defense',
            'turn_value_bet',
            'turn_check_raise',
        ];
    }

    public function riverModules(): array
    {
        return [
            'river_value_bet',
            'river_bluff_catch',
            'river_bluff',
            'river_thin_value',
            'river_overbet',
        ];
    }

    public function aggregateModuleForStage(string $stage): ?string
    {
        return match ($stage) {
            'preflop' => 'preflop_global',
            'flop' => 'postflop_flop',
            'turn' => 'postflop_turn',
            'river' => 'postflop_river',
            default => null,
        };
    }

    public function allTrainingModules(): array
    {
        return array_values(array_unique(array_merge(
            $this->preflopModules(),
            $this->flopModules(),
            $this->turnModules(),
            $this->riverModules(),
        )));
    }

    public function stageAggregateModules(): array
    {
        return [
            'global',
            'preflop_global',
            'postflop_flop',
            'postflop_turn',
            'postflop_river',
        ];
    }

    public function routeForModule(?string $module): string
    {
        if (in_array($module, $this->flopModules(), true)) {
            return 'postflop-training.index';
        }

        if (in_array($module, $this->turnModules(), true)) {
            return 'postflop-turn.index';
        }

        if (in_array($module, $this->riverModules(), true)) {
            return 'postflop-river.index';
        }

        return 'spot-training.index';
    }

    public function stageForModule(?string $module): string
    {
        if (in_array($module, $this->flopModules(), true)) {
            return 'flop';
        }

        if (in_array($module, $this->turnModules(), true)) {
            return 'turn';
        }

        if (in_array($module, $this->riverModules(), true)) {
            return 'river';
        }

        return 'preflop';
    }

    public function globalXp(User $user): int
    {
        return (int) ($this->globalStats($user)->xp ?? 0);
    }

    public function globalStats(User $user): object
    {
        $global = UserTrainingStat::query()
            ->where('user_id', $user->id)
            ->where('module', 'global')
            ->first();

        if ($global) {
            return $global;
        }

        $stats = UserTrainingStat::query()
            ->where('user_id', $user->id)
            ->whereIn('module', $this->allTrainingModules())
            ->get();

        return $this->aggregateStats($stats);
    }

    public function stageStats(User $user, string $stage): object
    {
        $aggregateModule = $this->aggregateModuleForStage($stage);

        if ($aggregateModule) {
            $aggregate = UserTrainingStat::query()
                ->where('user_id', $user->id)
                ->where('module', $aggregateModule)
                ->first();

            if ($aggregate) {
                return $aggregate;
            }
        }

        $modules = match ($stage) {
            'preflop' => $this->preflopModules(),
            'flop' => $this->flopModules(),
            'turn' => $this->turnModules(),
            'river' => $this->riverModules(),
            default => [],
        };

        if (empty($modules)) {
            return $this->emptyStats();
        }

        $stats = UserTrainingStat::query()
            ->where('user_id', $user->id)
            ->whereIn('module', $modules)
            ->get();

        return $this->aggregateStats($stats);
    }

    public function summary(User $user): array
    {
        $xp = $this->globalXp($user);

        $preflop = $this->stageStats($user, 'preflop');
        $flop = $this->stageStats($user, 'flop');
        $turn = $this->stageStats($user, 'turn');
        $river = $this->stageStats($user, 'river');

        $flopUnlocked = $this->passes($xp, self::FLOP_XP_REQUIRED, $preflop, self::PREFLOP_ACCURACY_REQUIRED);
        $turnUnlocked = $this->passes($xp, self::TURN_XP_REQUIRED, $flop, self::FLOP_ACCURACY_REQUIRED);
        $riverUnlocked = $this->passes($xp, self::RIVER_XP_REQUIRED, $turn, self::TURN_ACCURACY_REQUIRED);
        $masteryUnlocked = $this->passes($xp, self::MASTERY_XP_REQUIRED, $river, self::RIVER_ACCURACY_REQUIRED);

        return [
            'xp' => $xp,

            'preflop' => [
                'stats' => $preflop,
                'unlocked' => true,
            ],

            'flop' => [
                'stats' => $flop,
                'previous_stats' => $preflop,
                'unlocked' => $flopUnlocked,
                'required_xp' => self::FLOP_XP_REQUIRED,
                'required_accuracy' => self::PREFLOP_ACCURACY_REQUIRED,
                'required_stage' => 'Preflop',
            ],

            'turn' => [
                'stats' => $turn,
                'previous_stats' => $flop,
                'unlocked' => $turnUnlocked,
                'required_xp' => self::TURN_XP_REQUIRED,
                'required_accuracy' => self::FLOP_ACCURACY_REQUIRED,
                'required_stage' => 'Flop',
            ],

            'river' => [
                'stats' => $river,
                'previous_stats' => $turn,
                'unlocked' => $riverUnlocked,
                'required_xp' => self::RIVER_XP_REQUIRED,
                'required_accuracy' => self::TURN_ACCURACY_REQUIRED,
                'required_stage' => 'Turn',
            ],

            'mastery' => [
                'stats' => $river,
                'unlocked' => $masteryUnlocked,
                'required_xp' => self::MASTERY_XP_REQUIRED,
                'required_accuracy' => self::RIVER_ACCURACY_REQUIRED,
                'required_stage' => 'River',
            ],
        ];
    }

    public function canAccess(User $user, string $stage): bool
    {
        $summary = $this->summary($user);

        return match ($stage) {
            'preflop' => true,
            'flop' => (bool) $summary['flop']['unlocked'],
            'turn' => (bool) $summary['turn']['unlocked'],
            'river' => (bool) $summary['river']['unlocked'],
            'mastery' => (bool) $summary['mastery']['unlocked'],
            default => false,
        };
    }

    public function lockedMessage(User $user, string $stage): string
    {
        $summary = $this->summary($user);

        if (! isset($summary[$stage])) {
            return 'Este módulo no existe.';
        }

        if ($stage === 'flop') {
            $current = $this->stageStats($user, 'preflop');

            return sprintf(
                'Flop bloqueado. Necesitas %d XP global, mínimo %d spots de Preflop y %.1f%% de precisión en Preflop. Ahora tienes %d XP, %d spots y %.1f%%.',
                self::FLOP_XP_REQUIRED,
                self::MIN_STAGE_SAMPLE,
                self::PREFLOP_ACCURACY_REQUIRED,
                $summary['xp'],
                $current->total_spots,
                $current->accuracy
            );
        }

        if ($stage === 'turn') {
            $current = $this->stageStats($user, 'flop');

            return sprintf(
                'Turn bloqueado. Necesitas %d XP global, mínimo %d spots de Flop y %.1f%% de precisión en Flop. Ahora tienes %d XP, %d spots y %.1f%%.',
                self::TURN_XP_REQUIRED,
                self::MIN_STAGE_SAMPLE,
                self::FLOP_ACCURACY_REQUIRED,
                $summary['xp'],
                $current->total_spots,
                $current->accuracy
            );
        }

        if ($stage === 'river') {
            $current = $this->stageStats($user, 'turn');

            return sprintf(
                'River bloqueado. Necesitas %d XP global, mínimo %d spots de Turn y %.1f%% de precisión en Turn. Ahora tienes %d XP, %d spots y %.1f%%.',
                self::RIVER_XP_REQUIRED,
                self::MIN_STAGE_SAMPLE,
                self::TURN_ACCURACY_REQUIRED,
                $summary['xp'],
                $current->total_spots,
                $current->accuracy
            );
        }

        return 'Todavía no has desbloqueado este módulo.';
    }

    public function nextGoal(User $user): string
    {
        if (!$this->canAccess($user, 'flop')) {
            return $this->lockedMessage($user, 'flop');
        }

        if (!$this->canAccess($user, 'turn')) {
            return $this->lockedMessage($user, 'turn');
        }

        if (!$this->canAccess($user, 'river')) {
            return $this->lockedMessage($user, 'river');
        }

        if (!$this->canAccess($user, 'mastery')) {
            return 'Siguiente objetivo: Mastery. Mejora tu precisión en River y acumula más XP.';
        }

        return 'Mastery desbloqueado. Sigue entrenando tus leaks más caros.';
    }

    private function passes(int $xp, int $requiredXp, object $stageStats, float $requiredAccuracy): bool
    {
        return $xp >= $requiredXp
            && (int) ($stageStats->total_spots ?? 0) >= self::MIN_STAGE_SAMPLE
            && (float) ($stageStats->accuracy ?? 0) >= $requiredAccuracy;
    }

    private function aggregateStats(Collection $stats): object
    {
        $total = (int) $stats->sum('total_spots');
        $correct = (int) $stats->sum('correct_spots');
        $wrong = (int) $stats->sum('wrong_spots');
        $xp = (int) $stats->sum('xp');

        $accuracy = $total > 0
            ? round(($correct / $total) * 100, 1)
            : 0.0;

        return (object) [
            'total_spots' => $total,
            'correct_spots' => $correct,
            'wrong_spots' => $wrong,
            'accuracy' => $accuracy,
            'xp' => $xp,
            'level' => $this->levelForXp($xp),
        ];
    }

    private function emptyStats(): object
    {
        return (object) [
            'total_spots' => 0,
            'correct_spots' => 0,
            'wrong_spots' => 0,
            'accuracy' => 0.0,
            'xp' => 0,
            'level' => 1,
        ];
    }

    private function levelForXp(int $xp): int
    {
        return max(1, intdiv($xp, 250) + 1);
    }
}
