<?php

namespace App\HandLab\Library\Flop;

class Air
{
    public static function all(): array
    {
        return [
            [
                'id' => 'hl_flop_srp_co_vs_btn_kq_678_two_tone_air',
                'title' => 'CO KQ en 6h7h8c sin equity clara',
                'street' => 'flop',
                'spot_type' => 'srp_air_wet_board',
                'pot_type' => 'srp',
                'hero_position' => 'CO',
                'villain_position' => 'BTN',
                'hero_cards' => ['Ks', 'Qd'],
                'board_cards' => ['6h', '7h', '8c'],
                'hand_class' => 'air',
                'draws' => [],
                'board_texture' => ['low_medium_high', 'unpaired', 'two_tone', 'connected'],
                'effective_stack_bb' => 100,
                'best_action' => 'Check',
                'gto_explanation' => 'KQ sin backdoors fuertes en 678 two-tone tiene poca equity y poca fold equity. El board impacta demasiado el rango del caller.',
                'exploit_explanation' => 'En microlímites esto no es un buen farol. Check y abandona muchas veces ante apuesta.',
                'leak_label' => 'C-bet automática en board malo',
                'concepts' => ['air', 'bad_cbet', 'wet_board'],
            ],
        ];
    }
}
