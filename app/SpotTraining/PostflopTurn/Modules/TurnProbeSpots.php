<?php

namespace App\SpotTraining\PostflopTurn\Modules;

use App\SpotTraining\PostflopTurn\Concerns\BuildsPostflopTurnSpots;

class TurnProbeSpots
{
    use BuildsPostflopTurnSpots;

    public static function all(): array
    {
        return [
            self::probeTopPairAfterCheckBack(),
            self::probeMiddlePairForValue(),
            self::probeScareAce(),
            self::probeNutFlushDraw(),
            self::probeOpenEndedDraw(),
            self::probeGutshotOvercard(),
            self::probeTurnKingPressure(),
            self::probeTwoPairValue(),
            self::avoidProbeAirNoEquity(),
            self::avoidProbeWeakShowdown(),
            self::probeCompletedFlushBlocker(),
            self::avoidProbeCompletedFlushBadCard(),
            self::probePairedBoardTrips(),
            self::probeDoubleGutshotPressure(),
            self::probeBottomPairPlusDraw(),
            self::probeOverpairSlowplayed(),
            self::probeSecondPairProtection(),
            self::avoidProbeWeakDrawDominated(),
            self::probeRiverSetupWithNutBlocker(),
            self::avoidProbeIntoStrongCheckingRange(),
        ];
    }

    protected static function probeTopPairAfterCheckBack(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_q72_q_qj',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_value',
            'Probe por valor con top pair',
            'BB vs BTN · Q72r → QJ',
            'BB',
            'BTN',
            ['Qh', 'Jc'],
            ['Qs', '7d', '2c', '4h'],
            5.5,
            8.0,
            48.0,
            'Turn blank tras check back flop',
            'BTN mostró debilidad al chequear flop.',
            'BB tiene muchas Qx defendidas y valor claro.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♦ 2♣', 'BB checks', 'BTN checks back', 'Turn: 4♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'Después del check back de BTN, QJ tiene valor claro contra pares, 7x y floats. Probe medio cobra valor sin aislarse demasiado.',
            'GTO simplificado: cuando el agresor chequea flop, BB puede liderar turn con top pair.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 84, 'feedback' => 'Correcto. Sacas valor de manos peores tras debilidad del agresor.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 76, 'feedback' => 'También válido contra rivales pagadores.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 46, 'feedback' => 'Demasiado pasivo. Pierdes valor claro.'],
            ],
            'Probe turn por valor cuando el agresor muestra debilidad.',
            'En NL2-NL10 apuesta por valor: muchos rivales pagan pares y manos medias.',
            84
        );
    }

    protected static function probeMiddlePairForValue(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_k83_2_8x',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_value',
            'Probe fino con pareja media',
            'BB vs BTN · K83r → 2 con 8x',
            'BB',
            'BTN',
            ['8h', '7h'],
            ['Ks', '8d', '3c', '2h'],
            5.5,
            8.0,
            48.0,
            'Turn blank bajo',
            'BTN chequeó flop y reduce manos fuertes.',
            'BB puede tener valor medio y protección.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 8♦ 3♣', 'BB checks', 'BTN checks back', 'Turn: 2♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'Pareja media puede apostar por valor fino y protección contra overcards. El check back flop de BTN reduce la fuerza de su rango.',
            'GTO simplificado: probe pequeño/medio con valor medio cuando el agresor no apuesta flop.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 76, 'feedback' => 'Bien. Cobras a peores y proteges contra overcards.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 40, 'ev_score' => 68, 'feedback' => 'Check también es jugable por control.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 14, 'ev_score' => 52, 'feedback' => 'Demasiado grande para valor fino.'],
            ],
            'La probe no siempre es polarizada; también hay valor fino.',
            'En microlímites apuesta medio si esperas calls de pares peores, pero no infles demasiado.',
            76
        );
    }

    protected static function probeScareAce(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_k72_a_76',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_range_advantage',
            'Probe en scary card A',
            'BB vs BTN · K72r → A con 76s',
            'BB',
            'BTN',
            ['7h', '6h'],
            ['Ks', '7d', '2c', 'As'],
            5.5,
            8.0,
            48.0,
            'Turn A cambia mucho la textura',
            'BTN tiene Ax, pero al chequear flop capea parte de su rango.',
            'BB puede presionar pares medios y floats.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♦ 2♣', 'BB checks', 'BTN checks back', 'Turn: A♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'El As es una carta que permite representar Ax y presionar manos medias. Además Hero tiene pareja de 7 como equity de respaldo.',
            'GTO simplificado: probe en scary cards con algo de equity es razonable.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 74, 'feedback' => 'Buena probe. Tienes equity y aprovechas una carta que cambia el board.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 66, 'feedback' => 'Check también es viable por showdown value.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 16, 'ev_score' => 50, 'feedback' => 'Algo grande para una mano media.'],
            ],
            'Las scary cards permiten probes, pero mejor con equity real.',
            'En NL2-NL10 no farolees cualquier As; hazlo cuando tengas algo de respaldo.',
            74
        );
    }

    protected static function probeNutFlushDraw(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_q72_9_as5s',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_draw',
            'Probe con nut draw',
            'BB vs BTN · Q72ss → 9 con A5s',
            'BB',
            'BTN',
            ['As', '5s'],
            ['Qs', '7s', '2d', '9h'],
            5.5,
            8.0,
            48.0,
            'Turn blank con nut flush draw',
            'BTN mostró debilidad al chequear flop.',
            'BB tiene equity fuerte con nut draw.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♠ 2♦', 'BB checks', 'BTN checks back', 'Turn: 9♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Nut flush draw con blocker al As tiene mucha equity y fold equity. Probe grande presiona pares medios y construye bote cuando completa.',
            'GTO simplificado: draws fuertes pueden probe-bet agresivo en turn.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 82, 'feedback' => 'Excelente semi-bluff. Tienes equity premium.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 74, 'feedback' => 'También válido con menos presión.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 26, 'ev_score' => 60, 'feedback' => 'Check realiza equity, pero pierde fold equity.'],
            ],
            'Nut draws son buenos candidatos para probe turn.',
            'En microlímites semi-bluffea con equity real, no con aire.',
            82
        );
    }

    protected static function probeOpenEndedDraw(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_t86_2_97',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_draw',
            'Probe con OESD',
            'BB vs BTN · T86r → 2 con 97s',
            'BB',
            'BTN',
            ['9h', '7h'],
            ['Ts', '8d', '6c', '2s'],
            5.5,
            8.0,
            48.0,
            'Board conectado con turn blank',
            'BTN chequeó flop en una textura que conecta mucho con BB.',
            'BB tiene muchas escaleras y proyectos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 8♦ 6♣', 'BB checks', 'BTN checks back', 'Turn: 2♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'OESD tiene equity fuerte y buena fold equity tras el check back flop. Apostar grande presiona overcards, pares débiles y floats.',
            'GTO simplificado: proyectos fuertes pueden liderar turn cuando el agresor se frena.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 56, 'ev_score' => 80, 'feedback' => 'Buena probe agresiva con mucha equity.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 44, 'ev_score' => 72, 'feedback' => 'También correcto, con menor riesgo.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 58, 'feedback' => 'Check no es grave, pero pierdes fold equity.'],
            ],
            'Los OESD pueden probe-bet con fuerza.',
            'En NL2-NL10 presiona draws fuertes, porque si pagan aún tienes outs.',
            80
        );
    }

    protected static function probeGutshotOvercard(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_a94_t_jt',
            'turn_probe',
            'Turn Probe Bet',
            'turn_value_protection',
            'Probe con gutshot + overcard',
            'BB vs BTN · A94r → T con JT',
            'BB',
            'BTN',
            ['Jh', 'Tc'],
            ['As', '9d', '4c', 'Th'],
            5.5,
            8.0,
            48.0,
            'Turn mejora Hero a pareja + equity',
            'BTN chequeó flop y puede tener muchas manos medias.',
            'BB gana showdown value y puede presionar.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 9♦ 4♣', 'BB checks', 'BTN checks back', 'Turn: T♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'Hero liga pareja de T y conserva algo de equity. Probe medio cobra a floats y protege contra overcards/river difíciles.',
            'GTO simplificado: cuando mejoras en turn tras check back, puedes liderar por valor/protección.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 74, 'feedback' => 'Correcto. Tu mano mejoró y puede apostar por valor/protección.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 66, 'feedback' => 'Check también es jugable por control.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 12, 'ev_score' => 48, 'feedback' => 'Grande es demasiado fino.'],
            ],
            'Si el turn mejora tu mano después de check back, probe es natural.',
            'En límites bajos apuesta cuando ligas valor medio, pero evita tamaños exagerados.',
            74
        );
    }

    protected static function probeTurnKingPressure(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_q83_k_jt',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_range_advantage',
            'Probe en K favorable',
            'BB vs BTN · Q83r → K con JT',
            'BB',
            'BTN',
            ['Jh', 'Tc'],
            ['Qs', '8d', '3c', 'Kh'],
            5.5,
            8.0,
            48.0,
            'Turn K cambia la presión del board',
            'BTN chequeó flop y reduce muchas manos fuertes.',
            'BB puede representar Kx y gana equity con gutshot.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 8♦ 3♣', 'BB checks', 'BTN checks back', 'Turn: K♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'El K permite representar valor y JT gana gutshot a escalera. Es una buena carta para probe agresivo con equity.',
            'GTO simplificado: scary card + equity permite probe grande.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 48, 'ev_score' => 76, 'feedback' => 'Buen semi-bluff. Tienes historia y equity.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 70, 'feedback' => 'También válido, con menos presión.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 32, 'ev_score' => 58, 'feedback' => 'Check no es horrible, pero desaprovecha una carta útil.'],
            ],
            'Las cartas altas que cambian rangos permiten probes con equity.',
            'En NL2-NL10 úsalo con proyecto o blockers, no como farol vacío.',
            76
        );
    }

    protected static function probeTwoPairValue(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_k84_8_84',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_value',
            'Probe por valor fuerte',
            'BB vs BTN · K84r → 8 con 84s',
            'BB',
            'BTN',
            ['8h', '4h'],
            ['Ks', '8d', '4c', '8c'],
            5.5,
            8.0,
            48.0,
            'Turn empareja y mejora Hero a full/dobles fuertes',
            'BTN chequeó flop y puede tener showdown medio.',
            'BB tiene valor fuerte y debe construir bote.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 8♦ 4♣', 'BB checks', 'BTN checks back', 'Turn: 8♣', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Hero tiene una mano muy fuerte y escondida. Debe apostar grande por valor contra Kx, pares y floats que no creen la historia.',
            'GTO simplificado: manos fuertes tras check back pueden liderar grande turn.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 92, 'feedback' => 'Excelente. Construyes bote con una mano enorme.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 80, 'feedback' => 'También correcto, aunque dejas valor.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 38, 'feedback' => 'Slowplay innecesario. Pierdes valor.'],
            ],
            'Cuando ligas fuerte tras check back, liderar turn cobra mucho valor.',
            'En microlímites apuesta fuerte por valor. Te pagan Kx y manos curiosas.',
            90
        );
    }

    protected static function avoidProbeAirNoEquity(): array
    {
        return self::spot(
            'turn_no_probe_bb_vs_btn_k72_4_j5',
            'turn_probe',
            'Turn Probe Bet',
            'turn_give_up_air',
            'No probe con aire total',
            'BB vs BTN · K72r → 4 con J5o',
            'BB',
            'BTN',
            ['Jh', '5c'],
            ['Ks', '7d', '2c', '4h'],
            5.5,
            8.0,
            48.0,
            'Turn blank sin equity',
            'BTN chequeó flop, pero Hero no tiene equity suficiente.',
            'BB no bloquea valor ni tiene proyecto.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♦ 2♣', 'BB checks', 'BTN checks back', 'Turn: 4♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'J5o no tiene pareja, proyecto ni blockers. Probe aquí es apostar por apostar y recibirá demasiados calls de pares.',
            'GTO simplificado: no liderar turn con aire sin equity.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 82, 'ev_score' => 74, 'feedback' => 'Correcto. No quemas dinero con aire total.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 28, 'feedback' => 'Probe sin equity ni buen plan.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 10, 'feedback' => 'Farol caro sin sentido.'],
            ],
            'La debilidad del rival no basta: necesitas valor, equity o blockers.',
            'En NL2-NL10 no intentes robar todos los turns. Te pagan demasiadas manos medias.',
            80
        );
    }

    protected static function avoidProbeWeakShowdown(): array
    {
        return self::spot(
            'turn_no_probe_bb_vs_btn_a72_5_66',
            'turn_probe',
            'Turn Probe Bet',
            'turn_showdown_value_check',
            'No convertir showdown value en farol',
            'BB vs BTN · A72r → 5 con 66',
            'BB',
            'BTN',
            ['6h', '6c'],
            ['As', '7d', '2c', '5h'],
            5.5,
            8.0,
            48.0,
            'A-high con pareja media baja',
            'BTN chequeó flop, pero aún tiene muchos Ax débiles y pares.',
            'BB tiene showdown value modesto.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♦ 2♣', 'BB checks', 'BTN checks back', 'Turn: 5♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            '66 tiene algo de showdown value pero no quiere inflar bote. Apostar no cobra muchas peores ni foldea suficientes mejores.',
            'GTO simplificado: manos medias con showdown value pueden chequear turn.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 76, 'feedback' => 'Correcto. Controlas bote y realizas showdown value.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 26, 'ev_score' => 56, 'feedback' => 'Puede mezclarse, pero no hace falta como estándar.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 24, 'feedback' => 'Demasiado grande para una mano media.'],
            ],
            'No conviertas manos con showdown value en faroles innecesarios.',
            'En microlímites check con manos medias evita meterte en problemas.',
            78
        );
    }

    protected static function probeCompletedFlushBlocker(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_qs7s2d_4s_as5h',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_range_advantage',
            'Probe bluff cuando se completa color con blocker',
            'BB vs BTN · Q72ss → 4♠ con A♠5x',
            'BB',
            'BTN',
            ['As', '5h'],
            ['Qs', '7s', '2d', '4s'],
            5.5,
            8.0,
            48.0,
            'Turn completa el color',
            'BTN chequeó flop y reduce parte de sus manos fuertes.',
            'BB bloquea nut flush y puede representar muchos suited calls.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♠ 2♦', 'BB checks', 'BTN checks back', 'Turn: 4♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'El A♠ bloquea el color máximo y permite presionar Qx sin pica, pares medios y floats. El size grande polariza mejor la historia.',
            'GTO simplificado: en cartas que completan draws, los blockers fuertes permiten probes polarizadas.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 48, 'ev_score' => 78, 'feedback' => 'Buen farol con blocker premium. Representas color y bloqueas el nut flush.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 68, 'feedback' => 'Correcto, aunque presiona menos manos medias.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 34, 'ev_score' => 58, 'feedback' => 'Check realiza algo de equity, pero desaprovecha un buen blocker.'],
            ],
            'Los blockers importan mucho cuando el draw se completa.',
            'En NL2-NL10 usa este farol con cuidado: mejor contra rivales que sí foldean pares medios.',
            78
        );
    }

    protected static function avoidProbeCompletedFlushBadCard(): array
    {
        return self::spot(
            'turn_no_probe_bb_vs_btn_qs7s2d_4s_8h7c',
            'turn_probe',
            'Turn Probe Bet',
            'turn_showdown_value_check',
            'No probe cuando se completa color sin blocker',
            'BB vs BTN · Q72ss → 4♠ con 87o',
            'BB',
            'BTN',
            ['8h', '7c'],
            ['Qs', '7s', '2d', '4s'],
            5.5,
            8.0,
            48.0,
            'Turn completa color y Hero no bloquea nada',
            'BTN puede chequear flop con picas medias, pares y manos que no foldean fácil.',
            'BB tiene pareja débil con showdown value, pero mal blocker.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♠ 2♦', 'BB checks', 'BTN checks back', 'Turn: 4♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'Hero no bloquea colores fuertes y su pareja de 7 tiene algo de showdown. Apostar convierte una mano media en farol malo.',
            'GTO simplificado: sin blocker relevante, muchas parejas medias prefieren check en cartas que completan color.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 76, 'feedback' => 'Correcto. Controlas bote y evitas farolear con malos blockers.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 22, 'ev_score' => 52, 'feedback' => 'Puede funcionar contra rivales muy débiles, pero no es estándar.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 28, 'feedback' => 'Demasiado ambicioso sin blocker ni ventaja clara.'],
            ],
            'No todas las scary cards son buenas para apostar.',
            'En microlímites no farolees colores completados sin blocker: te pagan demasiado.',
            78
        );
    }

    protected static function probePairedBoardTrips(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_j72_7_76',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_value',
            'Probe fuerte con trips en board emparejado',
            'BB vs BTN · J72r → 7 con 76s',
            'BB',
            'BTN',
            ['7h', '6h'],
            ['Js', '7d', '2c', '7c'],
            5.5,
            8.0,
            48.0,
            'Turn empareja carta baja favorable para BB',
            'BTN chequeó flop y puede tener Jx, pares medios y overcards.',
            'BB tiene muchos 7x defendidos y ahora trips.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 7♦ 2♣', 'BB checks', 'BTN checks back', 'Turn: 7♣', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Trips está muy escondido y necesita construir bote. El check back de BTN invita a liderar por valor contra Jx y pares que pagan.',
            'GTO simplificado: cuando BB mejora en una carta que favorece su rango, puede probe grande por valor.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 92, 'feedback' => 'Excelente. Mano fuerte y escondida: apuesta grande por valor.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 80, 'feedback' => 'Correcto, aunque algo pequeño contra calling stations.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 34, 'feedback' => 'Slowplay malo. Pierdes valor de Jx y pares.'],
            ],
            'Cuando ligas trips en turn tras check back, no regales carta.',
            'En NL2-NL10 apuesta grande por valor: muchos rivales pagan Jx sin pensarlo.',
            92
        );
    }

    protected static function probeDoubleGutshotPressure(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_q95_j_t8',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_draw',
            'Probe con doble gutshot',
            'BB vs BTN · Q95r → J con T8s',
            'BB',
            'BTN',
            ['Th', '8h'],
            ['Qs', '9d', '5c', 'Jh'],
            5.5,
            8.0,
            48.0,
            'Turn abre mucha equity para Hero',
            'BTN chequeó flop y queda capado en muchas Qx medias o pares.',
            'BB gana doble gutshot y puede representar Jx/QJ/T8/KT.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 9♦ 5♣', 'BB checks', 'BTN checks back', 'Turn: J♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'T8 gana doble gutshot y buena presión sobre pares medios. Apostar grande maximiza fold equity y prepara barrels en rivers buenos.',
            'GTO simplificado: los proyectos con mucha equity y buena cobertura de nuts pueden liderar turn.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 80, 'feedback' => 'Buen semi-bluff. Tienes equity y representas una carta muy dinámica.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 70, 'feedback' => 'También válido con menos varianza.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 58, 'feedback' => 'Demasiado pasivo con tanta equity.'],
            ],
            'Los buenos draws del turn deben generar fold equity.',
            'En microlímites semi-bluffea cuando tienes outs reales, no por orgullo.',
            80
        );
    }

    protected static function probeBottomPairPlusDraw(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_t63_4_65',
            'turn_probe',
            'Turn Probe Bet',
            'turn_value_protection',
            'Probe con bottom pair + proyecto',
            'BB vs BTN · T63r → 4 con 65s',
            'BB',
            'BTN',
            ['6h', '5h'],
            ['Ts', '6d', '3c', '4h'],
            5.5,
            8.0,
            48.0,
            'Turn mejora equity de Hero',
            'BTN chequeó flop en board bajo que conecta más con BB.',
            'BB tiene pareja + gutshot y puede cobrar/proteger.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 6♦ 3♣', 'BB checks', 'BTN checks back', 'Turn: 4♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'Pareja de 6 más gutshot tiene valor, protección y equity. Probe medio cobra a overcards y evita regalar river.',
            'GTO simplificado: manos mixtas de valor/protección pueden usar probe medio.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 76, 'feedback' => 'Bien. Cobras/proteges sin inflar demasiado el bote.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 36, 'ev_score' => 68, 'feedback' => 'Check también es jugable, pero das carta gratis.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 12, 'ev_score' => 50, 'feedback' => 'Demasiado grande para una mano media.'],
            ],
            'Las manos con pareja + draw suelen querer apostar medio.',
            'En NL2-NL10 apuesta por protección cuando la mano aún puede cobrar a peores.',
            76
        );
    }

    protected static function probeOverpairSlowplayed(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_842_2_99',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_value',
            'Probe grande con overpair slowplayeada',
            'BB vs BTN · 842r → 2 con 99',
            'BB',
            'BTN',
            ['9h', '9c'],
            ['8s', '4d', '2c', '2h'],
            5.5,
            8.0,
            48.0,
            'Turn empareja carta baja',
            'BTN chequeó flop y muchas overpairs fuertes apuestan flop.',
            'BB tiene overpair fuerte para esta línea.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 8♠ 4♦ 2♣', 'BB checks', 'BTN checks back', 'Turn: 2♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            '99 va muy por delante de overcards, 8x y pares peores. El turn bajo permite apostar grande por valor y protección.',
            'GTO simplificado: overpairs fuertes en boards bajos pueden probe turn tras check back.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 84, 'feedback' => 'Correcto. Hay valor claro y protección contra overcards.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 76, 'feedback' => 'También válido, con menos presión.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 48, 'feedback' => 'Muy pasivo. Regalas equity y pierdes valor.'],
            ],
            'Las overpairs vulnerables no deben regalar demasiadas cartas.',
            'En microlímites apuesta por valor: te pagan 8x, 55-77 y overcards tercas.',
            84
        );
    }

    protected static function probeSecondPairProtection(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_a83_2_8x',
            'turn_probe',
            'Turn Probe Bet',
            'turn_value_protection',
            'Probe pequeño con second pair vulnerable',
            'BB vs BTN · A83r → 2 con 8x',
            'BB',
            'BTN',
            ['8h', '6h'],
            ['As', '8d', '3c', '2s'],
            5.5,
            8.0,
            48.0,
            'Turn blank y mano vulnerable',
            'BTN chequeó flop, pero aún puede tener Ax débiles y pares.',
            'BB tiene second pair con valor/protección.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 8♦ 3♣', 'BB checks', 'BTN checks back', 'Turn: 2♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            '8x cobra a floats, 3x, pares bajos y protege contra overcards. El tamaño medio evita aislarse contra Ax.',
            'GTO simplificado: second pair puede probe pequeño/medio cuando necesita protección.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 52, 'ev_score' => 74, 'feedback' => 'Bien. Valor fino y protección con tamaño controlado.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 44, 'ev_score' => 68, 'feedback' => 'Check también es razonable por control de bote.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 36, 'feedback' => 'Demasiado grande. Te aíslas contra mejores.'],
            ],
            'Second pair puede apostar, pero no necesita polarizar.',
            'En NL2-NL10 apuesta pequeño/medio; grande solo consigue que paguen mejores.',
            74
        );
    }

    protected static function avoidProbeWeakDrawDominated(): array
    {
        return self::spot(
            'turn_no_probe_bb_vs_btn_ks9s4d_2s_6s5h',
            'turn_probe',
            'Turn Probe Bet',
            'turn_give_up_air',
            'No probe con draw débil dominado',
            'BB vs BTN · K94ss → 2♠ con 6♠5x',
            'BB',
            'BTN',
            ['6s', '5h'],
            ['Ks', '9s', '4d', '2s'],
            5.5,
            8.0,
            48.0,
            'Turn completa color, pero Hero tiene pica baja',
            'BTN puede tener muchas picas mejores tras check back.',
            'BB tiene blocker muy débil y casi nada de showdown.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 9♠ 4♦', 'BB checks', 'BTN checks back', 'Turn: 2♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'La pica baja no es un blocker suficiente. Si recibes call, muchas veces estarás contra Kx con pica, 9x con pica o colores mejores.',
            'GTO simplificado: blockers débiles no justifican probe grande en cartas que completan nuts del rival.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 72, 'feedback' => 'Correcto. No conviertas un blocker débil en farol caro.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 18, 'ev_score' => 44, 'feedback' => 'Solo contra rivales muy fit-or-fold.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 22, 'feedback' => 'Farol malo: blocker débil y mala realización.'],
            ],
            'Un blocker bajo no equivale a blocker fuerte.',
            'En microlímites este farol se quema mucho porque pagan cualquier pareja con pica.',
            76
        );
    }

    protected static function probeRiverSetupWithNutBlocker(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_j82_t_aks',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_draw',
            'Probe para preparar river con blocker fuerte',
            'BB vs BTN · J82ss → T con A♠Kx',
            'BB',
            'BTN',
            ['As', 'Kh'],
            ['Js', '8s', '2d', 'Th'],
            5.5,
            8.0,
            48.0,
            'Turn dinámico abre escalera y mantiene draw de color',
            'BTN chequeó flop y muchas manos fuertes quedan reducidas.',
            'BB tiene overcards, gutshot y blocker al nut flush.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 8♠ 2♦', 'BB checks', 'BTN checks back', 'Turn: T♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'AK con A♠ tiene blockers y equity: gutshot a Q, overcards y bloqueo al nut flush. Es buen candidato para apostar y preparar barrels en rivers favorables.',
            'GTO simplificado: manos con blockers fuertes y equity futura pueden usar probe grande.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 46, 'ev_score' => 78, 'feedback' => 'Buen probe agresivo. Tienes blockers, equity y plan de river.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 70, 'feedback' => 'Correcto, aunque genera menos presión.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 32, 'ev_score' => 58, 'feedback' => 'Pasivo. No aprovechas blockers ni fold equity.'],
            ],
            'Un buen probe tiene plan para el river.',
            'En NL2-NL10 úsalo solo si sabes qué rivers vas a seguir apostando y cuáles abandonar.',
            78
        );
    }

    protected static function avoidProbeIntoStrongCheckingRange(): array
    {
        return self::spot(
            'turn_no_probe_bb_vs_btn_aq7_2_54',
            'turn_probe',
            'Turn Probe Bet',
            'turn_give_up_air',
            'No probe contra rango de check back fuerte',
            'BB vs BTN · AQ7r → 2 con 54s',
            'BB',
            'BTN',
            ['5h', '4h'],
            ['As', 'Qd', '7c', '2s'],
            5.5,
            8.0,
            48.0,
            'Board alto muy favorable al agresor preflop',
            'BTN puede chequear manos fuertes medias como Ax débil, Qx y slowplays.',
            'BB no tiene showdown ni buenos blockers.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ Q♦ 7♣', 'BB checks', 'BTN checks back', 'Turn: 2♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'Aunque BTN chequeó flop, su rango sigue teniendo mucho Ax/Qx que no foldea. 54s no bloquea valor ni tiene equity suficiente.',
            'GTO simplificado: en boards muy favorables al agresor, BB debe seleccionar muy bien sus probes.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 82, 'ev_score' => 74, 'feedback' => 'Correcto. El board sigue favoreciendo demasiado al BTN.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 30, 'feedback' => 'Farol pobre contra un rango que aún paga mucho.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 12, 'feedback' => 'Apuesta cara sin equity ni blockers.'],
            ],
            'No todo check back del agresor significa debilidad real.',
            'En microlímites este probe recibe calls de Ax y Qx constantemente. Mejor rendirse.',
            80
        );
    }

}