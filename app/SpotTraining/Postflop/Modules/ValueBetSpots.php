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
            8.6,
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
}
