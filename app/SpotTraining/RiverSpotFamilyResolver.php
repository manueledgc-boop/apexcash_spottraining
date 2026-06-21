<?php

namespace App\SpotTraining;

class RiverSpotFamilyResolver
{
    public static function fromConcept(string $concept): string
    {
        return match ($concept) {

            // Value bet
            'river_top_pair_value',
            'river_overpair_value',
            'river_two_pair_value',
            'river_set_value',
            'river_trips_value',
            'river_straight_value',
            'river_flush_value',
            'river_full_house_value',
            'river_thin_value' =>
                'river_value_bet',

            // Overbet / polar
            'river_overbet_nuts',
            'river_overbet_polar_value',
            'river_overbet_blocker_bluff',
            'river_polar_bluff',
            'river_nut_advantage_pressure' =>
                'river_polar_overbet',

            // Bluff
            'river_missed_draw_bluff',
            'river_blocker_bluff',
            'river_range_pressure_bluff',
            'river_scare_card_bluff' =>
                'river_bluff',

            // Check / showdown
            'river_showdown_value_check',
            'river_medium_pair_showdown',
            'river_top_pair_pot_control',
            'river_check_back_showdown',
            'river_avoid_thin_value' =>
                'river_showdown_control',

            // Bluffcatch / defense
            'river_call_bluffcatcher',
            'river_call_top_pair',
            'river_call_overpair',
            'river_call_blocker',
            'river_fold_bluffcatcher',
            'river_fold_top_pair',
            'river_fold_overpair',
            'river_fold_no_blocker' =>
                'river_defense',

            // Raise river
            'river_raise_nuts',
            'river_raise_full_house',
            'river_raise_flush',
            'river_raise_blocker_bluff' =>
                'river_raise',

            // Give up
            'river_give_up_air',
            'river_missed_draw_give_up',
            'river_no_fold_equity',
            'river_bad_bluff_card' =>
                'river_give_up',

            // Avoid overplay
            'river_avoid_overplaying_top_pair',
            'river_avoid_overplaying_overpair',
            'river_avoid_bad_raise',
            'river_avoid_bad_call',
            'river_avoid_hero_call' =>
                'river_avoid_overplay',

            default =>
                'river_uncategorized',
        };
    }

    public static function labelFromFamily(string $family): string
    {
        return match ($family) {
            'river_value_bet' => 'Apuesta de valor en river',
            'river_polar_overbet' => 'Overbet / línea polar en river',
            'river_bluff' => 'Farol en river',
            'river_showdown_control' => 'Check con showdown value',
            'river_defense' => 'Defensa / bluffcatch en river',
            'river_raise' => 'Raise en river',
            'river_give_up' => 'Abandonar river',
            'river_avoid_overplay' => 'Evitar sobrejugar river',
            default => 'River sin categorizar',
        };
    }

    public static function labelFromConcept(string $concept): string
    {
        return self::labelFromFamily(self::fromConcept($concept));
    }
}