<?php

namespace App\HandLab\Library\Preflop;

class VsThreeBetSpots
{
    public static function all(): array
    {
        return [

            [
                'id' => 'hl_vs3bet_co_k9s_vs_sb',
                'street' => 'preflop',
                'hero_position' => 'CO',
                'villain_position' => 'SB',
                'hero_cards' => ['Ks', '9s'],
                'pot_type' => '3bp',
                'spot_type' => 'vs_three_bet',
                'best_action' => 'Fold',
                'gto_explanation' => 'K9s desde CO frente a un 3bet de SB suele ser demasiado débil para continuar. Aunque tiene jugabilidad suited, queda dominada con frecuencia por Kx mejores y suited broadways del rango de 3bet.',
                'exploit_explanation' => 'En microlímites los 3bets desde SB suelen estar cargados de valor. Foldear K9s evita pagar dominado y jugar un bote grande con una mano marginal.',
                'leak_label' => 'Pagar demasiados 3bets con suited kings dominados',
                'hand_class' => 'suited_king',
                'concepts' => ['vs_three_bet', 'dominated_hand', 'fold_vs_3bet'],
            ],

            [
                'id' => 'hl_vs3bet_btn_aqs_vs_sb',
                'street' => 'preflop',
                'hero_position' => 'BTN',
                'villain_position' => 'SB',
                'hero_cards' => ['As', 'Qs'],
                'pot_type' => '3bp',
                'spot_type' => 'vs_three_bet',
                'best_action' => 'Call',
                'gto_explanation' => 'AQs en BTN frente a 3bet de SB es suficientemente fuerte para continuar. Tiene buena equity, blockers y jugabilidad postflop en posición.',
                'exploit_explanation' => 'En microlímites puedes pagar AQs en posición contra tamaños razonables. Si el rival 3betea muy tight y grande, se puede jugar con más cautela, pero foldear por defecto sería demasiado nit.',
                'leak_label' => 'Foldear demasiado contra 3bets desde ciegas',
                'hand_class' => 'suited_broadway',
                'concepts' => ['vs_three_bet', 'call_3bet_ip'],
            ],

            [
                'id' => 'hl_vs3bet_utg_qq_vs_btn',
                'street' => 'preflop',
                'hero_position' => 'UTG',
                'villain_position' => 'BTN',
                'hero_cards' => ['Qs', 'Qh'],
                'pot_type' => '3bp',
                'spot_type' => 'vs_three_bet',
                'best_action' => 'Call',
                'gto_explanation' => 'QQ frente a un 3bet contra UTG es una mano muy fuerte, pero no siempre necesita 4betear. Pagar mantiene dentro manos peores y protege el rango de call.',
                'exploit_explanation' => 'En microlímites contra rivales muy tight, pagar QQ puede ser mejor que 4betear y aislarse contra KK+. Contra jugadores agresivos, 4bet por valor también puede ser válido.',
                'leak_label' => 'Convertir QQ en una mano demasiado face-up',
                'hand_class' => 'premium_pair',
                'concepts' => ['vs_three_bet', 'premium_pair', 'call_or_4bet'],
            ],

            [
                'id' => 'hl_vs3bet_co_ako_vs_sb',
                'street' => 'preflop',
                'hero_position' => 'CO',
                'villain_position' => 'SB',
                'hero_cards' => ['As', 'Kd'],
                'pot_type' => '3bp',
                'spot_type' => 'vs_three_bet',
                'best_action' => 'Call',
                'gto_explanation' => 'AKo frente a 3bet de SB tiene blockers muy importantes y suficiente equity para continuar. Puede mezclarse entre call y 4bet según rangos y tamaños.',
                'exploit_explanation' => 'En microlímites AKo no debe foldearse automáticamente ante un 3bet de SB. Contra rivales tight puedes pagar; contra rivales que 3betean amplio puedes 4betear por valor.',
                'leak_label' => 'Foldear demasiado AK ante 3bets',
                'hand_class' => 'premium_broadway',
                'concepts' => ['vs_three_bet', 'ako', 'call_or_4bet'],
            ],

            [
                'id' => 'hl_vs3bet_btn_76s_vs_bb',
                'street' => 'preflop',
                'hero_position' => 'BTN',
                'villain_position' => 'BB',
                'hero_cards' => ['7s', '6s'],
                'pot_type' => '3bp',
                'spot_type' => 'vs_three_bet',
                'best_action' => 'Fold',
                'gto_explanation' => '76s puede abrirse desde BTN, pero frente a un 3bet de BB no siempre tiene suficiente equity realizable. Depende mucho del tamaño y de la profundidad efectiva.',
                'exploit_explanation' => 'En microlímites muchos 3bets de BB son fuertes. Pagar 76s sin profundidad ni plan postflop suele quemar dinero.',
                'leak_label' => 'Defender demasiados suited connectors contra 3bet',
                'hand_class' => 'suited_connector',
                'concepts' => ['vs_three_bet', 'fold_vs_3bet'],
            ],

            [
                'id' => 'hl_vs3bet_btn_a5s_vs_sb',
                'street' => 'preflop',
                'hero_position' => 'BTN',
                'villain_position' => 'SB',
                'hero_cards' => ['As', '5s'],
                'pot_type' => '3bp',
                'spot_type' => 'vs_three_bet',
                'best_action' => 'Call',
                'gto_explanation' => 'A5s tiene blockers y jugabilidad suited, por lo que puede continuar contra algunos 3bets desde SB. Su valor depende del tamaño y de la frecuencia de 3bet rival.',
                'exploit_explanation' => 'Contra rivales agresivos puede pagarse o incluso mezclarse como 4bet bluff. Contra jugadores tight de microlímites, foldear también puede ser correcto.',
                'leak_label' => 'Continuar suited aces bajos sin mirar perfil rival',
                'hand_class' => 'suited_ace',
                'concepts' => ['vs_three_bet', 'suited_ace', 'blocker'],
            ],

            [
                'id' => 'hl_vs3bet_hj_tt_vs_btn',
                'street' => 'preflop',
                'hero_position' => 'HJ',
                'villain_position' => 'BTN',
                'hero_cards' => ['Ts', 'Th'],
                'pot_type' => '3bp',
                'spot_type' => 'vs_three_bet',
                'best_action' => 'Call',
                'gto_explanation' => 'TT frente a 3bet del BTN puede continuar, especialmente si el tamaño es razonable. Tiene valor de showdown y juega bien contra rangos no extremadamente tight.',
                'exploit_explanation' => 'En microlímites, si el rival solo 3betea premiums, TT pierde valor y puede foldearse ante tamaños grandes. Contra rivales agresivos, pagar es estándar.',
                'leak_label' => 'No ajustar parejas medias contra rangos tight',
                'hand_class' => 'medium_pair',
                'concepts' => ['vs_three_bet', 'medium_pair'],
            ],

            [
                'id' => 'hl_vs3bet_co_ajo_vs_sb',
                'street' => 'preflop',
                'hero_position' => 'CO',
                'villain_position' => 'SB',
                'hero_cards' => ['As', 'Jd'],
                'pot_type' => '3bp',
                'spot_type' => 'vs_three_bet',
                'best_action' => 'Fold',
                'gto_explanation' => 'AJo frente a 3bet de SB suele estar dominada por AQ, AK y pares fuertes. Sin posición clara ni suited equity, continuar puede ser problemático.',
                'exploit_explanation' => 'En microlímites AJo offsuit suele ser un fold muy sano contra 3bets tight. Pagarla demasiado genera spots dominados postflop.',
                'leak_label' => 'Pagar 3bets con Ax offsuit dominados',
                'hand_class' => 'offsuit_broadway',
                'concepts' => ['vs_three_bet', 'dominated_hand'],
            ],

        ];
    }
}