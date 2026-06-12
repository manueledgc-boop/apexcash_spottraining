<?php

namespace App\SpotTraining\Postflop\Modules;

use App\SpotTraining\Postflop\Concerns\BuildsPostflopSpots;

class DefenseVsCbetSpots
{
    use BuildsPostflopSpots;

    public static function all(): array
    {
        return [
            self::defendVsCbetTopPair(),
            self::defendVsCbetAirNoBackdoors(),
            self::defendVsCbetSet77(),
            self::defendVsCbetMiddlePair(),
            self::defendVsCbetPairDraw(),
            self::defendVsCbetWheelDraw(),
        ];
    }

    protected static function defendVsCbetTopPair(): array
    {
        return self::spot(
            'pf_defend_vs_cbet_q72r_bb_vs_btn_qj',
            'defense_vs_cbet',
            'Defensa vs C-Bet',
            'call_top_pair',
            'Pagar top pair',
            'BB vs BTN · Top pair vs c-bet',
            'BB',
            'BTN',
            ['Qh', 'Jc'],
            ['Qs', '7d', '2c'],
            7.3,
            6.7,
            49.0,
            'Board seco con top pair',
            'BTN tiene ventaja de rango; BB tiene muchos pares y defensas medias.',
            'BB puede tener sets; BTN tiene Qx mejores.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♦ 2♣', 'BB checks', 'BTN bets 2 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Top pair con kicker medio es demasiado fuerte para foldear y normalmente no necesita subir. Call mantiene bluffs y Qx peores dentro.',
            'GTO simplificado: call estándar con top pair media.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 86, 'ev_score' => 88, 'feedback' => 'Correcto. Mantienes el rango del rival amplio.'],
                'RAISE' => ['grade' => 'marginal', 'frequency' => 12, 'ev_score' => 58, 'feedback' => 'Subir top pair media suele aislarte contra mejores.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Fold demasiado débil.'],
            ],
            'Top pair media defiende casi siempre contra sizing pequeño.',
            'No foldees demasiado vs c-bets pequeñas. Muchos jugadores apuestan automático con aire.',
            90
        );
    }

    protected static function defendVsCbetAirNoBackdoors(): array
    {
        return self::spot(
            'pf_defend_vs_cbet_a72r_bb_vs_btn_j9',
            'defense_vs_cbet',
            'Defensa vs C-Bet',
            'fold_no_equity',
            'Foldear sin equity',
            'BB vs BTN · Aire sin backdoors',
            'BB',
            'BTN',
            ['Jc', '9d'],
            ['As', '7h', '2c'],
            7.3,
            6.7,
            49.0,
            'A-high seco rainbow',
            'BTN tiene clara ventaja de rango.',
            'BTN tiene más Ax fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♥ 2♣', 'BB checks', 'BTN bets 2 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'J9o sin backdoor relevante, sin pareja y sin proyecto no tiene suficiente equity ni jugabilidad.',
            'GTO simplificado: foldea aire sin backdoors ante c-bet en A-high seco.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 92, 'ev_score' => 80, 'feedback' => 'Correcto. No defiendas manos sin equity.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 30, 'feedback' => 'Call flotando sin plan.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 12, 'feedback' => 'Bluff malo: sin blockers fuertes ni equity.'],
            ],
            'Defiende manos con pareja, backdoors o equity. Aire total se foldea.',
            'En microlímites no intentes outplayear con aire. Ahorras mucho foldeando basura sin equity.',
            86
        );
    }

    protected static function defendVsCbetSet77(): array
    {
        return self::spot(
            'pf_defend_vs_cbet_k72_bb_vs_btn_77',
            'defense_vs_cbet',
            'Defensa vs C-Bet',
            'slowplay_set_dry_board',
            'Set en board seco',
            'BB vs BTN · Set medio vs c-bet',
            'BB',
            'BTN',
            ['7c', '7h'],
            ['Ks', '7d', '2c'],
            7.3,
            6.7,
            49.0,
            'K-high seco',
            'BTN tiene ventaja de rango, pero BB tiene sets.',
            'BB tiene nut advantage con sets.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♦ 2♣', 'BB checks', 'BTN bets 2 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Set en board seco puede pagar mucho para mantener bluffs y Kx dentro. Raise también existe, pero call es muy fuerte.',
            'GTO simplificado: call frecuente con sets en boards secos.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 90, 'feedback' => 'Excelente. Mantienes el rango rival dentro.'],
                'RAISE' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 84, 'feedback' => 'También válido contra rivales que pagan Kx.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Nunca foldees set aquí.'],
            ],
            'Los sets pueden mezclar call y raise; en board seco el call protege tu rango.',
            'En NL2-NL10 raise puede imprimir valor contra Kx, pero call también deja que sigan faroleando.',
            88
        );
    }

    protected static function defendVsCbetMiddlePair(): array
    {
        return self::spot(
            'pf_defend_vs_cbet_a83_bb_vs_btn_87',
            'defense_vs_cbet',
            'Defensa vs C-Bet',
            'middle_pair_defense',
            'Defender pareja media',
            'BB vs BTN · Pareja media vs c-bet',
            'BB',
            'BTN',
            ['8h', '7h'],
            ['As', '8c', '3d'],
            7.3,
            6.7,
            49.0,
            'A-high seco',
            'BTN tiene ventaja clara.',
            'BTN tiene más Ax fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 8♣ 3♦', 'BB checks', 'BTN bets 2 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Pareja media contra c-bet pequeña tiene suficiente equity para pagar. Fold sería demasiado débil.',
            'GTO simplificado: call con pares medios ante sizing pequeño.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 76, 'feedback' => 'Correcto. Tienes showdown value y puedes mejorar.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 40, 'feedback' => 'Demasiado nit ante apuesta pequeña.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 20, 'feedback' => 'Raise convierte una mano media en farol sin necesidad.'],
            ],
            'Los pares medios defienden mucho contra c-bets pequeñas.',
            'No foldees todo lo que no sea top pair. Contra sizing pequeño, paga y juega turns.',
            78
        );
    }

    protected static function defendVsCbetPairDraw(): array
    {
        return self::spot(
            'pf_defend_vs_cbet_t98_bb_vs_btn_j9',
            'defense_vs_cbet',
            'Defensa vs C-Bet',
            'pair_draw_continue',
            'Pagar con pareja + proyecto',
            'BB vs BTN · Pareja + draw',
            'BB',
            'BTN',
            ['Jh', '9c'],
            ['Ts', '9s', '8d'],
            8.5,
            6.5,
            49.0,
            'Board dinámico con muchos proyectos',
            'BB conecta fuerte.',
            'BB tiene más dobles y escaleras.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♠ 8♦', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Par + gutshot tiene demasiada equity para foldear. Call mantiene bluffs y proyectos peores.',
            'GTO simplificado: continuar con par + equity.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 82, 'feedback' => 'Correcto. Tienes equity real y buena jugabilidad.'],
                'RAISE' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 76, 'feedback' => 'Raise también puede existir como semi-bluff/protección.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 8, 'feedback' => 'Fold demasiado débil.'],
            ],
            'Par + proyecto continúa casi siempre en boards dinámicos.',
            'En límites bajos no foldees equity real; paga y realiza tu mano.',
            82
        );
    }

    protected static function defendVsCbetWheelDraw(): array
    {
        return self::spot(
            'pf_defend_vs_cbet_642_bb_vs_btn_a5s',
            'defense_vs_cbet',
            'Defensa vs C-Bet',
            'draw_with_backdoors',
            'Defender proyecto claro',
            'BB vs BTN · A5s en 642',
            'BB',
            'BTN',
            ['Ah', '5h'],
            ['6c', '4d', '2s'],
            7.3,
            6.7,
            49.0,
            'Board bajo conectado',
            'BB conecta bien con la textura.',
            'BB tiene sets, dobles y escaleras.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 6♣ 4♦ 2♠', 'BB checks', 'BTN bets 2 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'A5s tiene gutshot, overcard y backdoors. Call es estándar; raise puede mezclarse.',
            'GTO simplificado: continuar con proyectos claros.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 78, 'feedback' => 'Bien. Tienes equity y realizas barato.'],
                'RAISE' => ['grade' => 'good', 'frequency' => 24, 'ev_score' => 72, 'feedback' => 'Raise semi-bluff también puede ser válido.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 35, 'feedback' => 'Demasiado débil con proyecto real.'],
            ],
            'A5s en 642 tiene equity suficiente para continuar.',
            'En NL2-NL10 paga proyectos baratos; evita foldear manos con equity clara.',
            78
        );
    }
}
