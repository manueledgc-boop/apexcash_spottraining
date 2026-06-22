<?php

namespace App\HandLab\Library\Preflop;

class ThreeBetSpots
{
    public static function all(): array
    {
        return [

            [
                'id' => 'hl_3bet_sb_vs_btn_qq',
                'street' => 'preflop',
                'hero_position' => 'SB',
                'villain_position' => 'BTN',
                'hero_cards' => ['Qs', 'Qh'],
                'pot_type' => '3bp',
                'spot_type' => 'three_bet',
                'best_action' => 'Raise',
                'gto_explanation' => 'QQ es una mano de valor clara para 3betear contra la apertura del BTN. Domina gran parte del rango de call y puede jugar botes grandes con ventaja.',
                'exploit_explanation' => 'En microlímites muchos jugadores pagan demasiadas manos peores. Construir el bote desde preflop suele ser más rentable que solo pagar.',
                'leak_label' => 'No extraer valor con premiums preflop',
                'hand_class' => 'premium_pair',
                'concepts' => ['three_bet', 'value_3bet'],
            ],

            [
                'id' => 'hl_3bet_bb_vs_btn_aks',
                'street' => 'preflop',
                'hero_position' => 'BB',
                'villain_position' => 'BTN',
                'hero_cards' => ['As', 'Ks'],
                'pot_type' => '3bp',
                'spot_type' => 'three_bet',
                'best_action' => 'Raise',
                'gto_explanation' => 'AKs es una de las mejores manos para 3betear. Tiene blockers fuertes y excelente equity contra el rango de continuación del rival.',
                'exploit_explanation' => 'En microlímites muchos jugadores pagan con Ax dominados y broadways peores. El valor principal está en construir un bote grande.',
                'leak_label' => 'Jugar AK demasiado pasivo',
                'hand_class' => 'premium_broadway',
                'concepts' => ['three_bet', 'value_3bet'],
            ],

            [
                'id' => 'hl_3bet_sb_vs_btn_a5s',
                'street' => 'preflop',
                'hero_position' => 'SB',
                'villain_position' => 'BTN',
                'hero_cards' => ['As', '5s'],
                'pot_type' => '3bp',
                'spot_type' => 'three_bet',
                'best_action' => 'Raise',
                'gto_explanation' => 'A5s es un candidato clásico de 3bet bluff gracias a sus blockers y buena jugabilidad cuando recibe call.',
                'exploit_explanation' => 'Contra jugadores que abren demasiado desde BTN, el 3bet con A5s suele ser muy rentable.',
                'leak_label' => 'No utilizar blockers para 3bet bluff',
                'hand_class' => 'suited_ace',
                'concepts' => ['three_bet', 'bluff_3bet'],
            ],

            [
                'id' => 'hl_3bet_bb_vs_co_kqs',
                'street' => 'preflop',
                'hero_position' => 'BB',
                'villain_position' => 'CO',
                'hero_cards' => ['Ks', 'Qs'],
                'pot_type' => '3bp',
                'spot_type' => 'three_bet',
                'best_action' => 'Raise',
                'gto_explanation' => 'KQs puede mezclarse entre call y 3bet dependiendo de posiciones y frecuencias.',
                'exploit_explanation' => 'Contra rivales que foldean demasiado a 3bet, aumentar la frecuencia de 3bet con KQs suele funcionar bien.',
                'leak_label' => 'No presionar opens amplios',
                'hand_class' => 'suited_broadway',
                'concepts' => ['three_bet'],
            ],

            [
                'id' => 'hl_3bet_sb_vs_btn_tt',
                'street' => 'preflop',
                'hero_position' => 'SB',
                'villain_position' => 'BTN',
                'hero_cards' => ['Ts', 'Th'],
                'pot_type' => '3bp',
                'spot_type' => 'three_bet',
                'best_action' => 'Raise',
                'gto_explanation' => 'TT suele preferir 3bet por valor frente a rangos amplios de apertura.',
                'exploit_explanation' => 'Muchos jugadores continúan con pares peores y broadways dominados, permitiendo extraer valor.',
                'leak_label' => 'Limitar el valor de parejas fuertes',
                'hand_class' => 'medium_pair',
                'concepts' => ['three_bet', 'value_3bet'],
            ],

        ];
    }
}