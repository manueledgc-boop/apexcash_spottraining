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
    public function all(): array
    {
        return array_merge(
            ThreeBetPotSpots::all(),
            FourBetPotSpots::all(),
            BlindVsBlindAdvancedSpots::all(),
            MultiwaySpots::all(),
            ShortStackSpots::all(),
            TournamentSpots::all(),
        );
    }

    public function random(?string $module = null, ?string $concept = null): array
    {
        $spots = $this->filtered($module, $concept);

        if (empty($spots)) {
            throw new RuntimeException('No hay spots disponibles para el filtro seleccionado.');
        }

        $poolKey = $this->poolKey($module, $concept);
        $seenIds = session($poolKey, []);

        $available = array_values(array_filter(
            $spots,
            fn (array $spot) => ! in_array($spot['id'] ?? null, $seenIds, true)
        ));

        if (empty($available)) {
            $seenIds = [];
            $available = $spots;
        }

        $spot = $available[array_rand($available)];
        $spotId = $spot['id'] ?? null;

        if ($spotId) {
            $seenIds[] = $spotId;
            session([$poolKey => array_values(array_unique($seenIds))]);
        }

        return $spot;
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

    protected function filtered(?string $module = null, ?string $concept = null): array
    {
        $spots = $this->all();

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

    protected function poolKey(?string $module = null, ?string $concept = null): string
    {
        $moduleKey = $module ?: 'all';
        $conceptKey = $concept ?: 'all';

        return "mastery_training.seen.{$moduleKey}.{$conceptKey}";
    }
}