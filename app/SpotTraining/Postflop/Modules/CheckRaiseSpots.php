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
            self::checkRaiseTopTwoPair(),
            self::checkRaiseMiddleSetWetBoard(),
            self::avoidCheckRaiseWeakGutshot(),
            self::checkRaiseHiddenTwoPair(),
            self::avoidCheckRaisePureAir(),
            self::avoidCheckRaiseWeakTopPair(),
            self::checkRaisePairPlusFlushDraw(),
            self::avoidCheckRaiseSecondPairNoBackdoor(),
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
            'Los combo draws fuertes combinan equity real y fold equity. En boards dinámicos donde la BB conecta bien, el check-raise presiona al agresor y permite construir un bote cuando completamos.',
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
            'Los proyectos muy fuertes, como escalera abierta combinada con proyecto de color, son excelentes candidatos a check-raise porque mantienen mucha equity incluso cuando reciben call.',
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

    protected static function checkRaiseTopTwoPair(): array
    {
        return self::spot(
            'pf_xraise_q84r_bb_vs_btn_q8_two_pair',
            'check_raise',
            'Check-Raise Flop',
            'value_raise_two_pair',
            'Check-raise por valor con dobles',
            'BB vs BTN · Top two pair',
            'BB',
            'BTN',
            ['Qh', '8c'],
            ['Qs', '8d', '4c'],
            8.5,
            6.5,
            49.0,
            'Board seco con top two pair',
            'BTN tiene ventaja de rango, pero BB conecta bien con dobles y sets.',
            'BB tiene más dobles inesperadas; BTN tiene mejores Qx.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 8♦ 4♣', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'RAISE',
            'Top two pair es una mano muy fuerte que quiere construir bote y cobrar a Qx, overpairs ocasionales y floats con backdoors.',
            'GTO simplificado: check-raise por valor con dobles fuertes.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 90, 'feedback' => 'Excelente. Construyes bote contra Qx y manos que no foldean fácil.'],
                'CALL' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 78, 'feedback' => 'Call también es jugable, pero pierdes valor contra Qx que paga raise.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Nunca foldees top two pair en este spot.'],
            ],
            'Las dobles fuertes pueden jugar check-raise por valor.',
            'En NL2-NL10 sube por valor: muchos rivales pagan con top pair y no foldean Qx.',
            88
        );
    }

    protected static function checkRaiseMiddleSetWetBoard(): array
    {
        return self::spot(
            'pf_xraise_j87ss_bb_vs_btn_88',
            'check_raise',
            'Check-Raise Flop',
            'value_raise_set_wet_board',
            'Set en board mojado',
            'BB vs BTN · Set medio en board mojado',
            'BB',
            'BTN',
            ['8h', '8c'],
            ['Js', '8s', '7d'],
            8.5,
            6.5,
            49.0,
            'Board conectado con flush draw',
            'BTN tiene ventaja general, pero BB conecta muy fuerte con J87.',
            'BB tiene sets, dobles y escaleras con más frecuencia.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 8♠ 7♦', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'RAISE',
            'Set medio en un board mojado debe subir con mucha frecuencia. Hay demasiados proyectos, top pairs y manos con equity que pueden pagar.',
            'GTO simplificado: check-raise fuerte por valor y protección en boards dinámicos.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 94, 'feedback' => 'Muy bien. Cobras a proyectos y construyes bote con una mano enorme.'],
                'CALL' => ['grade' => 'marginal', 'frequency' => 26, 'ev_score' => 68, 'feedback' => 'Call no es horrible, pero das precio a demasiados proyectos.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Nunca foldees set aquí.'],
            ],
            'En boards mojados, los sets suben más para cobrar equity.',
            'En límites bajos no slowplayees sets en boards con proyectos: te pagan draws, Jx y pares + gutshot.',
            92
        );
    }

    protected static function avoidCheckRaiseWeakGutshot(): array
    {
        return self::spot(
            'pf_no_xraise_a97r_bb_vs_btn_jt',
            'check_raise',
            'Check-Raise Flop',
            'avoid_weak_gutshot_raise',
            'No subir gutshot débil',
            'BB vs BTN · Gutshot débil',
            'BB',
            'BTN',
            ['Jh', 'Tc'],
            ['As', '9d', '7c'],
            8.5,
            6.5,
            49.0,
            'A-high conectado medio',
            'BTN tiene ventaja de Ax y manos fuertes.',
            'BTN tiene más Ax fuertes; BB tiene algunas dobles y proyectos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 9♦ 7♣', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'JT tiene gutshot, pero no enough equity para convertirlo siempre en check-raise. Call realiza equity y evita inflar un bote contra un rango fuerte.',
            'GTO simplificado: algunos gutshots pagan; no todos son check-raise.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 52, 'ev_score' => 72, 'feedback' => 'Correcto. Realizas equity sin convertir la mano en farol caro.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 32, 'ev_score' => 58, 'feedback' => 'Fold puede ser aceptable contra rivales muy fuertes, pero es algo tight ante sizing estándar.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 34, 'feedback' => 'Demasiado agresivo. Tienes poca equity y no bloqueas suficientes manos fuertes.'],
            ],
            'No todos los proyectos débiles son buenos check-raise.',
            'En NL2-NL10 evita check-raise con gutshots débiles: te pagan demasiado y terminas quemando dinero.',
            76
        );
    }

    protected static function checkRaiseHiddenTwoPair(): array
    {
        return self::spot(
            'pf_no_xraise_k84r_bb_vs_btn_84',
            'check_raise',
            'Check-Raise Flop',
            'value_raise_two_pair',
            'Check-raise por valor con dobles',
            'BB vs BTN · Bottom pair contra c-bet',
            'BB',
            'BTN',
            ['8h', '4c'],
            ['Ks', '8d', '4h'],
            8.5,
            6.5,
            49.0,
            'K-high seco con dobles bajas',
            'BTN tiene ventaja de rango con Kx.',
            'BB tiene algunas dobles escondidas; BTN tiene Kx fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 8♦ 4♥', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'RAISE',
            'Con dobles bajas, Hero tiene una mano fuerte y escondida. En este spot sí puede hacer check-raise por valor contra Kx y pares que no creen la historia.',
            'GTO simplificado: las dobles escondidas pueden subir por valor incluso en K-high seco.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 56, 'ev_score' => 86, 'feedback' => 'Correcto. Tu mano está muy escondida y puedes cobrar a Kx.'],
                'CALL' => ['grade' => 'good', 'frequency' => 46, 'ev_score' => 78, 'feedback' => 'Call también es fuerte; mantiene bluffs dentro.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Nunca foldees dobles aquí.'],
            ],
            'Las dobles escondidas son buenas candidatas a check-raise por valor.',
            'En microlímites sube por valor cuando ligas dobles escondidas: muchos rivales pagan con Kx.',
            84
        );
    }

    protected static function avoidCheckRaisePureAir(): array
    {
        return self::spot(
            'pf_no_xraise_k72r_bb_vs_btn_j5o',
            'check_raise',
            'Check-Raise Flop',
            'avoid_pure_air_bluff',
            'No check-raise con aire total',
            'BB vs BTN · Aire total en K72r',
            'BB',
            'BTN',
            ['Jh', '5c'],
            ['Ks', '7d', '2c'],
            8.5,
            6.5,
            49.0,
            'K-high seco rainbow',
            'BTN tiene una ventaja clara de rango.',
            'BTN tiene muchos Kx fuertes y overpairs.',
            [
                'BTN opens 2.5 BB',
                'BB calls',
                'Flop: K♠ 7♦ 2♣',
                'BB checks',
                'BTN bets 3 BB',
                'Action on Hero BB'
            ],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'J5o no tiene pareja, proyecto, backdoor relevante ni blockers importantes. Es una mano perfecta para abandonar.',
            'GTO simplificado: aire total se foldea. No todo necesita convertirse en farol.',
            [
                'FOLD' => [
                    'grade' => 'best',
                    'frequency' => 92,
                    'ev_score' => 82,
                    'feedback' => 'Correcto. Ahorras fichas abandonando una mano sin equity.'
                ],
                'CALL' => [
                    'grade' => 'mistake',
                    'frequency' => 6,
                    'ev_score' => 24,
                    'feedback' => 'Call sin plan. Vas a foldear demasiados turns.'
                ],
                'RAISE' => [
                    'grade' => 'blunder',
                    'frequency' => 2,
                    'ev_score' => 8,
                    'feedback' => 'Check-raise muy malo. No tienes equity ni blockers suficientes.'
                ],
            ],
            'Los mejores folds también son parte del buen póker.',
            'En NL2-NL10 muchos jugadores pierden dinero intentando farolear con aire total. Simplemente foldea.',
            84
        );
    }

    protected static function avoidCheckRaiseWeakTopPair(): array
    {
        return self::spot(
            'pf_no_xraise_q72r_bb_vs_btn_q8',
            'check_raise',
            'Check-Raise Flop',
            'avoid_overplaying_top_pair',
            'No sobrejugar top pair débil',
            'BB vs BTN · Top pair kicker débil',
            'BB',
            'BTN',
            ['Qh', '8c'],
            ['Qs', '7d', '2c'],
            8.5,
            6.5,
            49.0,
            'Q-high seco rainbow',
            'BTN tiene ventaja de rango general.',
            'BTN tiene mejores Qx con frecuencia.',
            [
                'BTN opens 2.5 BB',
                'BB calls',
                'Flop: Q♠ 7♦ 2♣',
                'BB checks',
                'BTN bets 3 BB',
                'Action on Hero BB'
            ],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Top pair con kicker débil es demasiado fuerte para foldear, pero normalmente no necesita check-raise. Call mantiene bluffs y manos peores dentro.',
            'GTO simplificado: muchas top pairs medias o débiles prefieren call.',
            [
                'CALL' => [
                    'grade' => 'best',
                    'frequency' => 82,
                    'ev_score' => 86,
                    'feedback' => 'Correcto. Mantienes el rango del rival amplio.'
                ],
                'RAISE' => [
                    'grade' => 'mistake',
                    'frequency' => 14,
                    'ev_score' => 52,
                    'feedback' => 'Te aíslas contra mejores Qx y haces foldear bluffs.'
                ],
                'FOLD' => [
                    'grade' => 'blunder',
                    'frequency' => 0,
                    'ev_score' => 5,
                    'feedback' => 'Top pair no puede foldearse ante una c-bet estándar.'
                ],
            ],
            'No todas las manos fuertes quieren construir un bote grande.',
            'En NL2-NL10 mucha gente sobrejuega top pair. Call suele ser la línea más rentable.',
            88
        );
    }


    protected static function checkRaisePairPlusFlushDraw(): array
    {
        return self::spot(
            'pf_xraise_973ss_bb_vs_btn_9s8s_pair_fd',
            'check_raise',
            'Check-Raise Flop',
            'pair_plus_draw_pressure',
            'Pareja + proyecto fuerte',
            'BB vs BTN · Pareja media + flush draw',
            'BB',
            'BTN',
            ['9s', '8s'],
            ['9h', '7s', '3s'],
            8.5,
            6.5,
            49.0,
            'Board medio con flush draw',
            'BTN tiene ventaja general, pero BB conecta muchas parejas, dobles y proyectos.',
            'BB tiene más dobles, sets bajos y proyectos fuertes.',
            [
                'BTN opens 2.5 BB',
                'BB calls',
                'Flop: 9♥ 7♠ 3♠',
                'BB checks',
                'BTN bets 3 BB',
                'Action on Hero BB'
            ],
            ['FOLD', 'CALL', 'RAISE'],
            'RAISE',
            'Pareja + flush draw tiene mucha equity contra overpairs, top pairs y overcards. El check-raise cobra fold equity y protege contra cartas altas del turn.',
            'GTO simplificado: manos con pareja + draw fuerte pueden mezclar call y raise, especialmente en boards donde BB conecta bien.',
            [
                'RAISE' => [
                    'grade' => 'best',
                    'frequency' => 58,
                    'ev_score' => 86,
                    'feedback' => 'Muy bien. Tienes equity real y haces difícil que BTN realice gratis sus overcards.'
                ],
                'CALL' => [
                    'grade' => 'good',
                    'frequency' => 48,
                    'ev_score' => 78,
                    'feedback' => 'Call también es correcto; realizas equity y mantienes bluffs dentro.'
                ],
                'FOLD' => [
                    'grade' => 'blunder',
                    'frequency' => 0,
                    'ev_score' => 4,
                    'feedback' => 'Fold es demasiado tight con pareja y proyecto de color.'
                ],
            ],
            'Pareja + proyecto fuerte es una mano excelente para presionar sin depender solo del farol.',
            'En NL2-NL10 este raise funciona mejor cuando el rival c-betea demasiado o paga con overcards. Si es calling station extremo, sigue siendo bueno porque tienes equity.',
            84
        );
    }

    protected static function avoidCheckRaiseSecondPairNoBackdoor(): array
    {
        return self::spot(
            'pf_no_xraise_a84r_bb_vs_btn_8c7c_second_pair',
            'check_raise',
            'Check-Raise Flop',
            'avoid_overplaying_second_pair',
            'No sobrejugar segunda pareja',
            'BB vs BTN · Segunda pareja sin backdoors',
            'BB',
            'BTN',
            ['8c', '7c'],
            ['As', '8d', '4h'],
            8.5,
            6.5,
            49.0,
            'A-high seco rainbow',
            'BTN tiene ventaja clara de Ax y broadways fuertes.',
            'BTN tiene más top pairs fuertes; BB tiene algunas dobles y sets bajos.',
            [
                'BTN opens 2.5 BB',
                'BB calls',
                'Flop: A♠ 8♦ 4♥',
                'BB checks',
                'BTN bets 3 BB',
                'Action on Hero BB'
            ],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Segunda pareja tiene valor de showdown y puede pagar una c-bet, pero hacer check-raise convierte una mano media en farol caro contra un rango lleno de Ax.',
            'GTO simplificado: las parejas medias suelen defender pagando; subirlas sin backdoors ni blockers fuertes es sobrejugar la mano.',
            [
                'CALL' => [
                    'grade' => 'best',
                    'frequency' => 74,
                    'ev_score' => 82,
                    'feedback' => 'Correcto. Pagas una vez y evalúas turn sin inflar el bote.'
                ],
                'FOLD' => [
                    'grade' => 'marginal',
                    'frequency' => 18,
                    'ev_score' => 58,
                    'feedback' => 'Fold puede ser aceptable contra un rival muy tight, pero en BTN vs BB suele ser demasiado conservador.'
                ],
                'RAISE' => [
                    'grade' => 'mistake',
                    'frequency' => 8,
                    'ev_score' => 30,
                    'feedback' => 'Mala subida. Haces foldear manos peores y te aíslas contra Ax, dobles, sets y proyectos mejores.'
                ],
            ],
            'Las manos medias ganan más dinero controlando el bote que intentando representar fuerza máxima.',
            'En microlímites no conviertas segunda pareja en farol: pagan demasiado con Ax y no foldean lo suficiente.',
            86
        );
    }

}
