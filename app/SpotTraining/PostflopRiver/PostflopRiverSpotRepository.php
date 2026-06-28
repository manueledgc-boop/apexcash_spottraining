<?php

namespace App\SpotTraining\PostflopRiver;

use App\SpotTraining\Concerns\BuildsSpotPlayers;
use App\SpotTraining\PostflopRiver\Modules\RiverBluffCatchSpots;
use App\SpotTraining\PostflopRiver\Modules\RiverBluffSpots;
use App\SpotTraining\PostflopRiver\Modules\RiverThinValueSpots;
use App\SpotTraining\PostflopRiver\Modules\RiverOverbetSpots;
use App\SpotTraining\PostflopRiver\Modules\RiverValueBetSpots;
use Illuminate\Support\Facades\Auth;
use App\Services\SpotPoolProgressService;

class PostflopRiverSpotRepository
{
    use BuildsSpotPlayers;

    public function all(): array
    {
        $spots = array_merge(
            RiverValueBetSpots::all(),
            RiverBluffCatchSpots::all(),
            RiverBluffSpots::all(),
            RiverThinValueSpots::all(),
            RiverOverbetSpots::all(),
        );

        return $spots;
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

        $spot = app(SpotPoolProgressService::class)->pick(
            $spots,
            'river',
            $module,
            $concept
        );

        return $this->normalize($spot);
    }

    public function normalize(array $spot): array
    {
        $spot['spot_id'] = $spot['id'];
        $spot['street'] = $spot['street'] ?? 'river';
        $spot['difficulty'] = $spot['difficulty'] ?? 'River V1';
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
