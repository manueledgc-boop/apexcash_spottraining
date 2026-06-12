<?php

namespace App\SpotTraining\Postflop\Modules;

use App\SpotTraining\Postflop\Concerns\BuildsPostflopSpots;

class CheckRaiseSpots
{
    use BuildsPostflopSpots;

    public static function all(): array
    {
        return [
            self::checkRaiseComboDraw(),
            self::checkRaiseOpenEnder(),
            self::checkRaiseSet(),
            self::checkRaiseNutBackdoor(),
        ];
    }

    protected static function checkRaiseComboDraw(): array
    {
        return self::spot(
            'pf_xraise_combo_draw_bb_vs_btn_t98ss_qsjs',
            'check_raise',
            'Check-Raise Flop',
            'semi_bluff_equity',
            'Semi-bluff con equity',
            'BB vs BTN · Combo draw',
            'BB',
            'BTN',
            ['Qs', 'Js'],
            ['Ts', '9s', '2d'],
            8.5,
            6.5,
            49.0,
            'Board dinámico con proyectos',
            'BTN tiene ventaja general; BB conecta fuerte.',
            'BB tiene más dobles, sets y escaleras ocultas.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♠ 2♦', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'RAISE',
            'QJs con proyecto de color, gutshot y overcards tiene mucha equity y fold equity.',
            'GTO simplificado: subir draws fuertes en boards donde BB tiene nuts.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 90, 'feedback' => 'Excelente. Presionas con mucha equity.'],
                'CALL' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 78, 'feedback' => 'Call también es jugable, pero pierdes fold equity.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Nunca foldees un combo draw tan fuerte.'],
            ],
            'Los draws fuertes mezclan call y raise.',
            'Contra rivales que pagan demasiado, sube draws fuertes con equity real, no faroles vacíos.',
            82
        );
    }

    protected static function checkRaiseOpenEnder(): array
    {
        return self::spot(
            'pf_xraise_864ss_bb_vs_btn_75s',
            'check_raise',
            'Check-Raise Flop',
            'open_ended_pressure',
            'Check-raise con OESD',
            'BB vs BTN · 864ss con 75s',
            'BB',
            'BTN',
            ['7s', '5s'],
            ['8s', '6d', '4s'],
            8.5,
            6.5,
            49.0,
            'Board bajo dinámico',
            'BB conecta muy fuerte con esta textura.',
            'BB tiene más escaleras y dobles.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 8♠ 6♦ 4♠', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'RAISE',
            '75s tiene escalera abierta y proyecto de color. Es una mano excelente para check-raise agresivo.',
            'GTO simplificado: subir draws muy fuertes.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 92, 'feedback' => 'Excelente. Mucha equity y fold equity.'],
                'CALL' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 78, 'feedback' => 'Call es jugable, pero menos agresivo.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Fold imposible con tanta equity.'],
            ],
            'OESD + flush draw es candidato premium para check-raise.',
            'En NL2-NL10 sube proyectos fuertes: aunque paguen, tienes muchas outs.',
            90
        );
    }

    protected static function checkRaiseSet(): array
    {
        return self::spot(
            'pf_xraise_k72_bb_vs_btn_22',
            'check_raise',
            'Check-Raise Flop',
            'value_raise_set',
            'Check-raise por valor',
            'BB vs BTN · Set bajo en K72',
            'BB',
            'BTN',
            ['2c', '2d'],
            ['Ks', '7h', '2s'],
            8.5,
            6.5,
            49.0,
            'K-high seco',
            'BTN tiene ventaja de rango.',
            'BB tiene sets escondidos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♥ 2♠', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'RAISE',
            'Set bajo puede subir por valor, especialmente con color draw presente. Queremos cobrar Kx y proyectos.',
            'GTO simplificado: raise por valor con sets en boards donde hay draws.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 90, 'feedback' => 'Muy bien. Construyes bote con una mano enorme.'],
                'CALL' => ['grade' => 'good', 'frequency' => 46, 'ev_score' => 82, 'feedback' => 'Call también es fuerte, pero dejas barato a proyectos.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Nunca foldees set aquí.'],
            ],
            'Sets pueden raisear por valor cuando hay proyectos que cobran equity.',
            'En NL2-NL10 resube por valor: te pagan Kx y draws.',
            88
        );
    }

    protected static function checkRaiseNutBackdoor(): array
    {
        return self::spot(
            'pf_xraise_qj4ss_bb_vs_btn_asTs',
            'check_raise',
            'Check-Raise Flop',
            'nut_draw_blockers',
            'Presión con nut draw',
            'BB vs BTN · A♠T♠ en QJ4ss',
            'BB',
            'BTN',
            ['As', 'Ts'],
            ['Qs', 'Jh', '4s'],
            8.5,
            6.5,
            49.0,
            'Board broadway con flush draw',
            'BTN tiene ventaja de broadways.',
            'BB tiene draws fuertes y algunas dobles.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ J♥ 4♠', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'RAISE',
            'A♠T♠ tiene nut flush draw, gutshot y blockers. Es una mano excelente para check-raise semi-bluff.',
            'GTO simplificado: agresión con draws premium.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 88, 'feedback' => 'Excelente semi-bluff con mucha equity.'],
                'CALL' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 76, 'feedback' => 'Call también es viable, pero menos presión.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Nunca foldees un draw tan fuerte.'],
            ],
            'Nut draw + gutshot + blockers puede jugar agresivo.',
            'Contra jugadores de límites bajos, raisea draws fuertes; no bluffs vacíos.',
            86
        );
    }
}
