<?php

namespace App\SpotTraining;

class TurnSpotFamilyResolver
{
    public static function fromConcept(string $concept): string
    {
        return match ($concept) {

            // Second barrel por ventaja / presión
            'turn_second_barrel_range',
            'turn_range_advantage_barrel',
            'turn_high_card_barrel',
            'turn_overcard_barrel',
            'turn_scare_card_barrel' =>
                'turn_barrel_range_pressure',

            // Value claro
            'turn_top_pair_value',
            'turn_tptk_value',
            'turn_overpair_value',
            'turn_two_pair_value',
            'turn_set_value',
            'turn_trips_value',
            'turn_straight_value',
            'turn_flush_value' =>
                'turn_value_bet',

            // Valor + protección
            'turn_value_protection',
            'turn_vulnerable_overpair',
            'turn_vulnerable_top_pair',
            'turn_dynamic_board_value',
            'turn_charge_draws' =>
                'turn_value_protection',

            // Check / pot control con showdown value
            'turn_showdown_value_check',
            'turn_medium_pair_control',
            'turn_second_pair_control',
            'turn_underpair_control',
            'turn_weak_top_pair_control',
            'turn_pot_control' =>
                'turn_pot_control_showdown',

            // Semi-bluff / draws
            'turn_flush_draw_barrel',
            'turn_oesd_barrel',
            'turn_combo_draw_barrel',
            'turn_pair_plus_draw',
            'turn_nut_draw_pressure',
            'turn_blocker_barrel',
            'turn_double_barrel_draw' =>
                'turn_semibluff_pressure',

            // Defensa vs second barrel
            'turn_call_top_pair',
            'turn_call_second_pair',
            'turn_call_pair_draw',
            'turn_call_strong_draw',
            'turn_call_showdown_value',
            'turn_defend_vs_barrel' =>
                'turn_defense_vs_barrel',

            // Fold / give up
            'turn_give_up_air',
            'turn_fold_no_equity',
            'turn_failed_float',
            'turn_bad_barrel_card',
            'turn_no_fold_equity' =>
                'turn_give_up',

            // Probe bet
            'turn_probe_missed_cbet',
            'turn_probe_value',
            'turn_probe_draw',
            'turn_probe_range_advantage' =>
                'turn_probe_bet',

            // Donk / lead turn
            'turn_donk_range_shift',
            'turn_lead_completed_draw',
            'turn_lead_nut_advantage',
            'turn_lead_dynamic_card' =>
                'turn_lead_donk',

            // Overbet turn
            'turn_overbet_nut_advantage',
            'turn_overbet_polar_value',
            'turn_overbet_blocker_bluff',
            'turn_overbet_completed_draw' =>
                'turn_overbet_polar',

            // Evitar sobrejugar
            'turn_avoid_overplaying_top_pair',
            'turn_avoid_overplaying_second_pair',
            'turn_avoid_bad_bluff',
            'turn_avoid_weak_draw_barrel',
            'turn_avoid_thin_value' =>
                'turn_avoid_overplay',

            default =>
                'turn_uncategorized',
        };
    }

    public static function labelFromFamily(string $family): string
    {
        return match ($family) {
            'turn_barrel_range_pressure' => 'Second barrel por presión de rango',
            'turn_value_bet' => 'Apuesta de valor en turn',
            'turn_value_protection' => 'Valor y protección en turn',
            'turn_pot_control_showdown' => 'Control con showdown value',
            'turn_semibluff_pressure' => 'Semi-bluff en turn',
            'turn_defense_vs_barrel' => 'Defensa vs second barrel',
            'turn_give_up' => 'Abandonar / no continuar',
            'turn_probe_bet' => 'Probe bet en turn',
            'turn_lead_donk' => 'Lead / donk en turn',
            'turn_overbet_polar' => 'Overbet polar en turn',
            'turn_avoid_overplay' => 'Evitar sobrejugar turn',
            default => 'Turn sin categorizar',
        };
    }

    public static function labelFromConcept(string $concept): string
    {
        return self::labelFromFamily(self::fromConcept($concept));
    }
}