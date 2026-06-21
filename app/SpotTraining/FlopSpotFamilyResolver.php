<?php

namespace App\SpotTraining;

class FlopSpotFamilyResolver
{
    public static function fromConcept(string $concept): string
    {
        return match ($concept) {

            'range_advantage_cbet',
            'range_advantage_air',
            'paired_dry_range_advantage',
            'paired_board_cbet' =>
                'flop_cbet_range',

            'thin_value_protection',
            'thin_value_protection_dynamic',
            'top_pair_value',
            'top_pair_good_kicker',
            'top_pair_protection_dynamic',
            'tptk_3bet_pot',
            'value_position_sb',
            'value_when_checked_to' =>
                'flop_top_pair_value',

            'overpair_value',
            'overpair_dynamic_board' =>
                'flop_overpair_value',

            'set_value_dry_board',
            'set_wet_board',
            'two_pair_value_dynamic' =>
                'flop_strong_made_hand_value',

            'bad_low_board_overcards',
            'medium_board_overcards',
            'avoid_cbet_wet_board',
            'bad_bluff_texture',
            'wet_board_air_control',
            'low_connected_check' =>
                'flop_check_back_giveup',

            'showdown_value_control',
            'showdown_value_medium_pair',
            'medium_pair_control',
            'medium_pair_bad_texture',
            'underpair_showdown_value',
            'pot_control_dynamic_board',
            'future_street_plan' =>
                'flop_check_back_showdown_value',

            'call_top_pair',
            'middle_pair_defense',
            'bottom_pair_vs_small_cbet',
            'clean_gutshot_continue',
            'draw_with_backdoors',
            'overcards_backdoor_float',
            'pair_draw_continue',
            'weak_flush_draw_defense',
            'nut_flush_draw_aggression',
            'slowplay_set_dry_board' =>
                'flop_defense_vs_cbet',

            'fold_no_equity',
            'backdoor_air_fold' =>
                'flop_fold_no_equity',

            'value_raise_set',
            'value_raise_set_wet_board',
            'value_raise_two_pair' =>
                'flop_check_raise_value',

            'semi_bluff_equity',
            'open_ended_pressure',
            'pair_plus_draw_pressure',
            'nut_draw_blockers',
            'combo_draw_aggression',
            'nut_draw_pressure',
            'nut_flush_draw',
            'overcards_nfd',
            'overcards_gutshot',
            'pair_plus_draw',
            'draw_plus_backdoors',
            'backdoor_barrel_plan',
            'nut_blocker_monotone' =>
                'flop_aggressive_draw',

            'avoid_overplaying_second_pair',
            'avoid_overplaying_top_pair',
            'avoid_pure_air_bluff',
            'avoid_weak_gutshot_raise',
            'weak_draw_control',
            'low_flush_draw_control' =>
                'flop_avoid_overplay',

            default =>
                'flop_uncategorized',
        };
    }

    public static function labelFromFamily(string $family): string
    {
        return match ($family) {
            'flop_cbet_range' => 'C-bet por ventaja de rango',
            'flop_value_bet' => 'Apuesta de valor en flop',
            'flop_check_back_giveup' => 'Check back / abandonar',
            'flop_check_back_showdown_value' => 'Check back con showdown value',
            'flop_defense_vs_cbet' => 'Defensa contra c-bet',
            'flop_fold_no_equity' => 'Fold sin equity suficiente',
            'flop_check_raise_value' => 'Check-raise por valor',
            'flop_aggressive_draw' => 'Draw agresivo / semi-bluff',
            'flop_avoid_overplay' => 'Evitar sobrejugar',
            'flop_top_pair_value' => 'Top pair por valor',
            'flop_overpair_value' => 'Overpair por valor',
            'flop_strong_made_hand_value' => 'Set / dobles por valor',
            default => 'Flop sin categorizar',
        };
    }

    public static function labelFromConcept(string $concept): string
    {
        return self::labelFromFamily(self::fromConcept($concept));
    }
}