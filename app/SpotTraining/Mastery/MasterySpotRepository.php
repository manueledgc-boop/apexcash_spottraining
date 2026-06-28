<?php

namespace App\SpotTraining\Mastery;

use App\SpotTraining\Mastery\Modules\BlindVsBlindAdvancedSpots;
use App\SpotTraining\Mastery\Modules\FourBetPotSpots;
use App\SpotTraining\Mastery\Modules\MultiwaySpots;
use App\SpotTraining\Mastery\Modules\ShortStackSpots;
use App\SpotTraining\Mastery\Modules\ThreeBetPotSpots;
use App\SpotTraining\Mastery\Modules\TournamentSpots;
use RuntimeException;

class MasterySpotRepository
{
    public function all(?string $module = null, ?string $concept = null): array
    {
        $spots = array_merge(
            ThreeBetPotSpots::all(),
            FourBetPotSpots::all(),
            BlindVsBlindAdvancedSpots::all(),
            MultiwaySpots::all(),
            ShortStackSpots::all(),
            TournamentSpots::all(),
        );

        if ($module) {
            $spots = array_values(array_filter(
                $spots,
                fn (array $spot) => ($spot['module'] ?? null) === $module
            ));
        }

        if ($concept) {
            $spots = array_values(array_filter(
                $spots,
                fn (array $spot) => ($spot['concept'] ?? null) === $concept
            ));
        }

        return $spots;
    }

    public function random(?string $module = null, ?string $concept = null): array
    {
        $spots = $this->all($module, $concept);

        if (empty($spots)) {
            throw new RuntimeException('No hay spots disponibles para el filtro seleccionado.');
        }

        return $spots[array_rand($spots)];
    }

    public function findById(string $id): ?array
    {
        foreach ($this->all() as $spot) {
            if (($spot['id'] ?? null) === $id) {
                return $spot;
            }
        }

        return null;
    }

    public function normalize(array $spot): array
    {
        $spot['table_players'] ??= [];
        $spot['board_cards'] ??= [];
        $spot['actions'] ??= [];
        $spot['options'] ??= [];

        $spot['family'] ??= 'mastery';
        $spot['family_label'] ??= 'Mastery';

        $spot['street'] ??= 'river';
        $spot['confidence'] ??= 75;
        $spot['difficulty'] ??= 'Mastery';

        return $spot;
    }
}