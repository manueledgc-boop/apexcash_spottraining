<?php

namespace App\SpotTraining;

use App\SpotTraining\Modules\BbVsBtnSpots;
use App\SpotTraining\Modules\BtnVs3BetSpots;
use App\SpotTraining\Modules\OpenRaiseSpots;
use App\SpotTraining\Modules\ThreeBetVsOpenSpots;

class SpotRepository
{
    public function all(): array
    {
        return array_merge(
            BtnVs3BetSpots::all(),
            OpenRaiseSpots::all(),
            BbVsBtnSpots::all(),
            ThreeBetVsOpenSpots::all(),
        );
    }

    public function byModule(string $module): array
    {
        return array_values(array_filter(
            $this->all(),
            fn (array $spot) => $spot['module'] === $module
        ));
    }
}