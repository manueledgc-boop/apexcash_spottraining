<?php

namespace App\HandLab\Library\Preflop;

class BlindDefenseSpots
{
    public static function all(): array
    {
        return [

            [
                'id' => 'hl_blind_def_bb_vs_btn_kto',
                'street' => 'preflop',
                'hero_position' => 'BB',
                'villain_position' => 'BTN',
                'hero_cards' => ['Ks', 'Td'],
                'pot_type' => 'srp',
                'spot_type' => 'blind_defense',
                'best_action' => 'Call',
                'gto_explanation' => 'KTo en BB frente a open de BTN suele defenderse por el precio y por la amplitud del rango del botón. Tiene blockers y suficiente equity contra un rango amplio.',
                'exploit_explanation' => 'En microlímites puedes defender KTo contra opens normales de BTN, pero no debes pagar de forma automática contra tamaños grandes o rivales muy tight.',
                'leak_label' => 'Foldear demasiado la BB contra robos de BTN',
                'hand_class' => 'offsuit_broadway',
                'concepts' => ['blind_defense', 'bb_vs_btn', 'call_vs_open'],
            ],

            [
                'id' => 'hl_blind_def_bb_vs_btn_q9s',
                'street' => 'preflop',
                'hero_position' => 'BB',
                'villain_position' => 'BTN',
                'hero_cards' => ['Qs', '9s'],
                'pot_type' => 'srp',
                'spot_type' => 'blind_defense',
                'best_action' => 'Call',
                'gto_explanation' => 'Q9s es una defensa razonable desde BB contra BTN. Tiene jugabilidad suited, puede ligar top pair, proyectos de color y algunas escaleras.',
                'exploit_explanation' => 'Contra jugadores pasivos puedes defender Q9s y realizar equity barato. Contra rivales agresivos postflop, evita sobrejugar top pair débil.',
                'leak_label' => 'Sobrejugar manos suited dominadas fuera de posición',
                'hand_class' => 'suited_broadway',
                'concepts' => ['blind_defense', 'bb_vs_btn', 'suited_defense'],
            ],

            [
                'id' => 'hl_blind_def_bb_vs_co_a8s',
                'street' => 'preflop',
                'hero_position' => 'BB',
                'villain_position' => 'CO',
                'hero_cards' => ['As', '8s'],
                'pot_type' => 'srp',
                'spot_type' => 'blind_defense',
                'best_action' => 'Call',
                'gto_explanation' => 'A8s tiene suficiente equity y jugabilidad para defender BB contra un open de CO. El suitedness y el blocker al A mejoran su rentabilidad.',
                'exploit_explanation' => 'En microlímites A8s puede defenderse contra tamaños razonables. No conviertas cualquier top pair en tres calles de valor si el rival muestra mucha fuerza.',
                'leak_label' => 'Sobrevalorar top pair con kicker medio',
                'hand_class' => 'suited_ace',
                'concepts' => ['blind_defense', 'bb_vs_co', 'suited_ace'],
            ],

            [
                'id' => 'hl_blind_def_bb_vs_utg_qto',
                'street' => 'preflop',
                'hero_position' => 'BB',
                'villain_position' => 'UTG',
                'hero_cards' => ['Qs', 'Td'],
                'pot_type' => 'srp',
                'spot_type' => 'blind_defense',
                'best_action' => 'Fold',
                'gto_explanation' => 'QTo frente a open de UTG suele ser demasiado débil para defender. Está dominada por muchas broadways mejores del rango temprano.',
                'exploit_explanation' => 'En microlímites los opens UTG suelen ser fuertes. Foldear QTo evita problemas de dominación y spots difíciles fuera de posición.',
                'leak_label' => 'Defender demasiado loose contra UTG',
                'hand_class' => 'offsuit_broadway',
                'concepts' => ['blind_defense', 'bb_vs_utg', 'dominated_hand'],
            ],

            [
                'id' => 'hl_blind_def_bb_vs_sb_k7s',
                'street' => 'preflop',
                'hero_position' => 'BB',
                'villain_position' => 'SB',
                'hero_cards' => ['Ks', '7s'],
                'pot_type' => 'srp',
                'spot_type' => 'blind_defense',
                'best_action' => 'Call',
                'gto_explanation' => 'K7s en BB contra SB puede defenderse por posición y por el rango amplio de la SB. Tiene blocker al K y jugabilidad suited.',
                'exploit_explanation' => 'Contra SB que roba demasiado, K7s es defensa rentable. Contra tamaños grandes o rivales muy tight, ajusta y foldea más manos marginales.',
                'leak_label' => 'Foldear demasiado BB contra SB',
                'hand_class' => 'suited_king',
                'concepts' => ['blind_defense', 'bb_vs_sb', 'blind_vs_blind'],
            ],

            [
                'id' => 'hl_blind_def_bb_vs_btn_54s',
                'street' => 'preflop',
                'hero_position' => 'BB',
                'villain_position' => 'BTN',
                'hero_cards' => ['5s', '4s'],
                'pot_type' => 'srp',
                'spot_type' => 'blind_defense',
                'best_action' => 'Call',
                'gto_explanation' => '54s puede defenderse desde BB contra BTN por precio, conectividad y potencial para ligar proyectos fuertes.',
                'exploit_explanation' => 'En microlímites 54s puede defenderse contra tamaños pequeños, pero evita pagar grandes raises o continuar postflop con equity débil.',
                'leak_label' => 'Defender suited connectors sin plan postflop',
                'hand_class' => 'suited_connector',
                'concepts' => ['blind_defense', 'bb_vs_btn', 'suited_connector'],
            ],

            [
                'id' => 'hl_blind_def_sb_vs_btn_a5s',
                'street' => 'preflop',
                'hero_position' => 'SB',
                'villain_position' => 'BTN',
                'hero_cards' => ['As', '5s'],
                'pot_type' => 'srp',
                'spot_type' => 'blind_defense',
                'best_action' => 'Raise',
                'gto_explanation' => 'A5s en SB contra BTN suele funcionar bien como 3bet por blockers y jugabilidad. Pagar desde SB es menos atractivo por jugar fuera de posición y sin cerrar acción.',
                'exploit_explanation' => 'Contra BTN que abre mucho, 3betear A5s desde SB es rentable. Contra jugadores tight puedes foldear más y reducir los bluffs.',
                'leak_label' => 'Pagar demasiado desde SB fuera de posición',
                'hand_class' => 'suited_ace',
                'concepts' => ['blind_defense', 'sb_vs_btn', 'three_bet_bluff'],
            ],

            [
                'id' => 'hl_blind_def_sb_vs_co_kqo',
                'street' => 'preflop',
                'hero_position' => 'SB',
                'villain_position' => 'CO',
                'hero_cards' => ['Ks', 'Qd'],
                'pot_type' => 'srp',
                'spot_type' => 'blind_defense',
                'best_action' => 'Raise',
                'gto_explanation' => 'KQo en SB contra CO suele preferir 3bet o fold antes que call. Jugar cold call desde SB es difícil por posición y porque BB aún puede actuar.',
                'exploit_explanation' => 'En microlímites, 3betear KQo contra CO loose puede ser rentable. Contra CO tight, foldear puede ser mejor que pagar fuera de posición.',
                'leak_label' => 'Cold call excesivo desde SB',
                'hand_class' => 'offsuit_broadway',
                'concepts' => ['blind_defense', 'sb_vs_co', 'three_bet_or_fold'],
            ],

        ];
    }
}