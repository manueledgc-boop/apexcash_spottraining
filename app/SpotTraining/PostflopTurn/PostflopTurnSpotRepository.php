<?php

namespace App\SpotTraining\PostflopTurn;

use App\SpotTraining\Concerns\BuildsSpotPlayers;
use App\SpotTraining\PostflopTurn\Modules\TurnBarrelSpots;
use App\SpotTraining\PostflopTurn\Modules\TurnCheckRaiseSpots;
use App\SpotTraining\PostflopTurn\Modules\TurnDefenseSpots;
use App\SpotTraining\PostflopTurn\Modules\TurnProbeBetSpots;
use App\SpotTraining\PostflopTurn\Modules\TurnProbeSpots;
use App\SpotTraining\PostflopTurn\Modules\TurnValueBetSpots;

class PostflopTurnSpotRepository
{
    use BuildsSpotPlayers;

    public function all(): array
    {
        return array_merge(
            TurnBarrelSpots::all(),
            TurnProbeSpots::all(),
            TurnProbeBetSpots::all(),
            TurnDefenseSpots::all(),
            TurnValueBetSpots::all(),
            TurnCheckRaiseSpots::all(),
        );
    }

    public function findById(string $spotId): ?array
    {
        foreach ($this->all() as $spot) {
            if (($spot['id'] ?? null) === $spotId) {
                return $this->normalize($spot);
            }
        }

        return null;
    }

    public function random(?string $module = null, ?string $concept = null): array
    {
        $spots = array_values(array_filter($this->all(), function (array $spot) use ($module, $concept): bool {
            if ($module && ($spot['module'] ?? null) !== $module) {
                return false;
            }

            if ($concept && ($spot['concept'] ?? null) !== $concept) {
                return false;
            }

            return true;
        }));

        if (empty($spots)) {
            $spots = $this->all();
        }

        $poolKey = 'postflop_turn_training.seen_spot_ids.' . md5(($module ?? 'all') . '|' . ($concept ?? 'all'));
        $seen = session($poolKey, []);

        $available = array_values(array_filter($spots, function (array $spot) use ($seen): bool {
            return ! in_array($spot['id'] ?? null, $seen, true);
        }));

        if (empty($available)) {
            $seen = [];
            $available = $spots;
        }

        $spot = $available[array_rand($available)];
        $seen[] = $spot['id'];

        session([
            $poolKey => array_values(array_unique($seen)),
        ]);

        return $this->normalize($spot);
    }

    public function normalize(array $spot): array
    {
        $spot['spot_id'] = $spot['id'];
        $spot['street'] = $spot['street'] ?? 'turn';
        $spot['difficulty'] = $spot['difficulty'] ?? 'Turn V1';
        $spot['confidence'] = $spot['confidence'] ?? 75;

        $spot['table_players'] = self::defaultPlayers(
            $spot['hero_position'] ?? 'BTN',
            $spot['villain_position'] ?? null
        );

        $spot['actions'] = $this->withEffectiveStackAction($spot);

        $spot['insights'] = $spot['insights'] ?? [
            'gto' => null,
            'low_stakes' => null,
        ];

        return $spot;
    }

    protected function withEffectiveStackAction(array $spot): array
    {
        $actions = $spot['actions'] ?? [];

        if (! isset($spot['effective_stack_bb'])) {
            return $actions;
        }

        foreach ($actions as $action) {
            if (str_starts_with($action, 'Stack efectivo:')) {
                return $actions;
            }
        }

        array_splice($actions, 2, 0, ['Stack efectivo: ' . $spot['effective_stack_bb'] . ' BB']);

        return $actions;
    }
}