<?php

namespace App\HandLab\Library;

class HandLabSpotRepository
{
    public static function all(): array
    {
        return array_merge(
            PreflopSpotRepository::all(),
            FlopSpotRepository::all(),
            TurnSpotRepository::all(),
            RiverSpotRepository::all(),
        );
    }
}