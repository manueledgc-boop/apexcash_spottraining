<?php

namespace App\SpotTraining\Postflop\Modules;

use App\SpotTraining\Postflop\Concerns\BuildsPostflopSpots;

class ValueBetSpots
{
    use BuildsPostflopSpots;

    public static function all(): array
    {
        return [
            self::valueBetVsMissedCbet(),
            self::valueBetAjA72(),
            self::valueBetAqQ83(),
            self::valueBetKqK95(),
            self::valueBetOverpairAAQ72(),
            self::valueBetTwoPairA9A98(),
            self::valueBetSetDryBoard(),
            self::valueBetTopPairDynamicBoard(),
        ];
    }

    protected static function valueBetVsMissedCbet(): array
    {
        return self::spot(
            'pf_value_vs_check_co_vs_bb_kj_k72',
            'value_bet',
            'Value Bet Flop',
            'value_when_checked_to',
            'Valor cuando chequean',
            'CO vs BB · Top pair vs check',
            'CO',
            'BB',
            ['Kc', 'Jc'],
            ['Kd', '7s', '2h'],
            5.5,
            8.8,
            48.5,
            'K-high seco',
            'Hero tiene ventaja de rango.',
            'Hero tiene mejores Kx; BB tiene sets ocasionales.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: K♦ 7♠ 2♥', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'Top pair buen kicker debe apostar por valor contra Kx peores, 7x y pares.',
            'GTO simplificado: bet pequeño por valor.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 86, 'feedback' => 'Correcto. Valor claro sin expulsar manos peores.'],
                'BET_66' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 77, 'feedback' => 'Puede estar bien vs calling station, pero estándar pequeño.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 48, 'feedback' => 'Pierdes valor contra muchas manos peores.'],
            ],
            'Apuesta top pair buen kicker por valor en board seco.',
            'La gente paga demasiado con pares y K peores. No hagas slowplay innecesario.',
            86
        );
    }

    protected static function valueBetAjA72(): array
    {
        return self::spot(
            'pf_value_btn_vs_bb_a72_aj',
            'value_bet',
            'Value Bet Flop',
            'top_pair_value',
            'Top pair por valor',
            'BTN vs BB · A72r con AJ',
            'BTN',
            'BB',
            ['Ah', 'Jd'],
            ['As', '7c', '2h'],
            5.5,
            8.5,
            47.5,
            'A-high seco',
            'BTN tiene ventaja clara.',
            'BTN tiene más Ax fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♣ 2♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'AJ quiere valor de Ax peores, 7x y pares. Sizing pequeño mantiene rango peor dentro.',
            'GTO simplificado: apuesta pequeña por valor.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 82, 'ev_score' => 88, 'feedback' => 'Excelente. Valor claro y bajo riesgo.'],
                'BET_66' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 76, 'feedback' => 'Jugable vs calling station, pero puede aislar.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 45, 'feedback' => 'Pierdes valor de manos peores.'],
            ],
            'Top pair fuerte apuesta mucho en A-high seco.',
            'En NL2-NL10 apuesta por valor. Pagan Ax peores y pares.',
            88
        );
    }

    protected static function valueBetAqQ83(): array
    {
        return self::spot(
            'pf_value_co_vs_bb_q83_aq',
            'value_bet',
            'Value Bet Flop',
            'top_pair_good_kicker',
            'Top pair buen kicker',
            'CO vs BB · Q83r con AQ',
            'CO',
            'BB',
            ['As', 'Qh'],
            ['Qd', '8c', '3s'],
            5.5,
            8.8,
            48.5,
            'Q-high seco',
            'Hero tiene ventaja de rango.',
            'Hero tiene mejores Qx.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: Q♦ 8♣ 3♠', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'AQ domina muchas Qx peores. La apuesta pequeña cobra valor sin expulsar manos peores.',
            'GTO simplificado: bet pequeño con top pair fuerte.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 86, 'feedback' => 'Muy buen value bet.'],
                'BET_66' => ['grade' => 'good', 'frequency' => 32, 'ev_score' => 78, 'feedback' => 'Bueno contra rivales que pagan demasiado.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 46, 'feedback' => 'Demasiado pasivo con mano fuerte.'],
            ],
            'AQ en Q-high seco apuesta por valor y protección.',
            'En microlímites te pagan Q peores y 8x. Apuesta.',
            86
        );
    }

    protected static function valueBetKqK95(): array
    {
        return self::spot(
            'pf_value_btn_vs_sb_k95_kq',
            'value_bet',
            'Value Bet Flop',
            'value_position_sb',
            'Valor vs SB',
            'BTN vs SB · K95r con KQ',
            'BTN',
            'SB',
            ['Kh', 'Qd'],
            ['Ks', '9c', '5h'],
            6.5,
            7.8,
            50.0,
            'K-high semi seco',
            'BTN tiene mejores Kx.',
            'SB tiene sets ocasionales y algunos Kx.',
            ['BTN opens 2.5 BB', 'SB calls', 'Flop: K♠ 9♣ 5♥', 'SB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_66',
            'KQ puede apostar más grande contra SB, que tiene muchos Kx peores y pares que pagan.',
            'GTO simplificado: value bet más grande en textura que recibe calls peores.',
            [
                'BET_66' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 86, 'feedback' => 'Muy bien. Extraes valor de Kx y pares.'],
                'BET_33' => ['grade' => 'good', 'frequency' => 46, 'ev_score' => 78, 'feedback' => 'También válido, pero algo pequeño contra pool pagador.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 42, 'feedback' => 'Demasiado pasivo.'],
            ],
            'Top pair buen kicker puede usar sizing mayor cuando hay mucho valor peor.',
            'En NL2-NL10 apuesta más fuerte cuando esperas calls de K peores y pares.',
            82
        );
    }

    protected static function valueBetOverpairAAQ72(): array
    {
        return self::spot(
            'pf_value_btn_vs_bb_q72_aa',
            'value_bet',
            'Value Bet Flop',
            'overpair_value',
            'Overpair por valor',
            'BTN vs BB · Q72r con AA',
            'BTN',
            'BB',
            ['Ah', 'Ad'],
            ['Qs', '7c', '2h'],
            5.5,
            8.5,
            47.5,
            'Q-high seco',
            'Hero tiene ventaja de rango.',
            'Hero tiene overpairs fuertes y mejores Qx.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♣ 2♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'AA es valor claro contra Qx, 7x y pares medios. En board seco, apostar pequeño mantiene dentro muchas manos peores.',
            'GTO simplificado: overpair apuesta por valor con sizing pequeño frecuente.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 82, 'ev_score' => 90, 'feedback' => 'Excelente. Sacas valor sin expulsar manos peores.'],
                'BET_66' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 80, 'feedback' => 'También válido contra rivales que pagan mucho.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 42, 'feedback' => 'Demasiado pasivo con una mano muy fuerte.'],
            ],
            'Las overpairs fuertes apuestan por valor en boards secos.',
            'En NL2-NL10 apuesta por valor. Te pagan Qx, 7x y pares peores.',
            90
        );
    }

    protected static function valueBetTwoPairA9A98(): array
    {
        return self::spot(
            'pf_value_btn_vs_bb_a98_a9',
            'value_bet',
            'Value Bet Flop',
            'two_pair_value_dynamic',
            'Dobles por valor',
            'BTN vs BB · A98 two-tone con A9',
            'BTN',
            'BB',
            ['Ah', '9c'],
            ['As', '9s', '8d'],
            5.5,
            8.5,
            47.5,
            'A-high conectado con flush draw',
            'Hero tiene Ax fuertes, pero BB conecta con muchas parejas y proyectos.',
            'Hero tiene mejores Ax; BB tiene más proyectos y algunas dobles.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 9♠ 8♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_66',
            'Dobles en board dinámico quieren construir bote y proteger contra proyectos. Sizing grande cobra a Ax, 9x, 8x y draws.',
            'GTO simplificado: apostar grande por valor en boards dinámicos.',
            [
                'BET_66' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 92, 'feedback' => 'Muy bien. Sacas valor y niegas equity.'],
                'BET_33' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 78, 'feedback' => 'Bueno, pero das demasiado precio a proyectos.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 18, 'feedback' => 'Slowplay malo en board con demasiados proyectos.'],
            ],
            'Las dobles en boards dinámicos quieren apostar fuerte.',
            'En microlímites apuesta grande por valor: te pagan Ax, proyectos y pares.',
            92
        );
    }

    protected static function valueBetSetDryBoard(): array
    {
        return self::spot(
            'pf_value_co_vs_bb_k72_77',
            'value_bet',
            'Value Bet Flop',
            'set_value_dry_board',
            'Set por valor',
            'CO vs BB · Set medio en K72r',
            'CO',
            'BB',
            ['7h', '7d'],
            ['Ks', '7c', '2h'],
            5.5,
            8.8,
            48.5,
            'K-high seco',
            'Hero tiene ventaja de rango.',
            'Hero tiene sets y Kx fuertes; BB tiene Kx peores y pares.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♣ 2♥', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'Set en board seco puede apostar pequeño para mantener Kx, 7x y pares dentro. No hace falta asustar al rival con sizing grande siempre.',
            'GTO simplificado: value bet pequeño frecuente con manos muy fuertes en boards secos.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 90, 'feedback' => 'Excelente. Construyes bote sin expulsar demasiadas manos.'],
                'BET_66' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 82, 'feedback' => 'También válido contra rivales que pagan Kx.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 46, 'feedback' => 'Pierdes valor contra Kx y pares.'],
            ],
            'Las manos muy fuertes también apuestan pequeño en boards secos.',
            'En NL2-NL10 no hagas slowplay eterno: apuesta y deja que te paguen Kx.',
            88
        );
    }

    protected static function valueBetTopPairDynamicBoard(): array
    {
        return self::spot(
            'pf_value_btn_vs_bb_jt7ss_kj',
            'value_bet',
            'Value Bet Flop',
            'top_pair_protection_dynamic',
            'Top pair vulnerable',
            'BTN vs BB · JT7ss con KJ',
            'BTN',
            'BB',
            ['Kh', 'Jc'],
            ['Js', 'Ts', '7d'],
            5.5,
            8.5,
            47.5,
            'Board conectado con flush draw',
            'BB conecta mucho con este board.',
            'BB tiene dobles, proyectos y muchas manos con equity.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ T♠ 7♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_66',
            'Top pair buen kicker en board dinámico necesita valor y protección. Hay muchos proyectos, Tx y Jx peores que pagan.',
            'GTO simplificado: apostar más grande en boards dinámicos con valor vulnerable.',
            [
                'BET_66' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 84, 'feedback' => 'Correcto. Cobras y proteges tu mano.'],
                'BET_33' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 74, 'feedback' => 'Válido, pero das buen precio a muchos proyectos.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 42, 'feedback' => 'Demasiado pasivo en un board peligroso.'],
            ],
            'Top pair en boards dinámicos quiere más protección.',
            'En NL2-NL10 apuesta por valor fuerte. Te pagan proyectos y pares peores.',
            84
        );
    }
}
