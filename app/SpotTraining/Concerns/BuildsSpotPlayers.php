<?php

namespace App\SpotTraining\Concerns;

trait BuildsSpotPlayers
{
    protected static function defaultPlayers(string $heroPosition, ?string $villainPosition): array
    {
        $positions = ['UTG', 'HJ', 'CO', 'BTN', 'SB', 'BB'];

        return array_map(function (string $position) use ($heroPosition, $villainPosition) {
            return [
                'position' => $position,
                'name' => $position === $heroPosition ? 'Hero' : self::botNameForPosition($position),
                'is_hero' => $position === $heroPosition,
                'is_villain' => $villainPosition !== null && $position === $villainPosition,
                'stack_bb' => 100,
            ];
        }, $positions);
    }

    protected static function botNameForPosition(string $position): string
    {
        return match ($position) {
            'UTG' => 'MadridReg',
            'HJ' => 'BilbaoTAG',
            'CO' => 'ValenciaPro',
            'BTN' => 'RiverKing',
            'SB' => 'SevillaNit',
            'BB' => 'BoardHunter',
            default => 'Villain',
        };
    }
}