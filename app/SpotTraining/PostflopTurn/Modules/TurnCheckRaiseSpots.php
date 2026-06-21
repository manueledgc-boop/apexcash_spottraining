<?php

namespace App\SpotTraining\PostflopTurn\Modules;

use App\SpotTraining\PostflopTurn\Concerns\BuildsPostflopTurnSpots;

class TurnCheckRaiseSpots
{
    use BuildsPostflopTurnSpots;

    public static function all(): array
    {
        return [
            self::setVsDelayedBarrelDryTurn(),
            self::twoPairProtectionDynamicTurn(),
            self::comboDrawVsSecondBarrel(),
            self::nutFlushDrawOvercardSemiBluff(),
            self::blockerBluffOnBroadwayTurn(),
            self::exploitWeakDoubleBarrel(),
            self::valueOnPairedTurn(),
            self::connectedBoardStraightPressure(),
            self::microlimitValueVsStation(),
            self::polarizedRaiseRiverSetup(),
            self::straightValueVsSecondBarrel(),
            self::comboDrawCheckRaiseOnScareCard(),
            self::avoidCheckRaiseTopPairWeakKicker(),
            self::avoidCheckRaiseWeakFlushDraw(),
            self::checkRaiseTripsPairedBoard(),
            self::checkRaiseNutBlockerBluff(),
            self::checkCallOesdBetterThanRaise(),
            self::checkRaiseTurnCardFavorsBb(),
            self::avoidSpewVsOverbet(),
            self::checkRaiseSmallValueVsStation(),
        ];
    }

    protected static function setVsDelayedBarrelDryTurn(): array
    {
        return self::spot(
            'turn_xr_bb_vs_btn_k72r_77_turn_4_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_set_value',
            'Set contra second barrel',
            'BB vs BTN · 77 en K72r · Turn 4',
            'BB',
            'BTN',
            ['7s', '7c'],
            ['Kh', '7d', '2c', '4s'],
            10.5,
            4.0,
            42.0,
            'K-high seco, turn blank',
            'BTN tiene ventaja de rango, pero BB conserva sets y dobles escondidas.',
            'BB tiene 77, 22 y algunas K7s/K2s; BTN tiene AK, KQ, AA y faroles de backdoor.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♥ 7♦ 2♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 4♠', 'BB checks', 'BTN bets 7 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'Con set en turn blank, Hero puede subir por valor. BTN sigue apostando muchos Kx fuertes, overpairs y algunos barrels automáticos. Solo pagar es rentable, pero contra rangos que pagan demasiado, subir captura más valor.',
            'GTO simplificado: los sets mezclan call y check-raise. En un turn que no cambia la textura, el check-raise protege el rango de call flop y construye bote con nuts.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 91, 'feedback' => 'Excelente. Tienes una mano muy fuerte y aún hay muchas peores que pagan.'],
                'CALL' => ['grade' => 'good', 'frequency' => 44, 'ev_score' => 82, 'feedback' => 'Call es correcto, pero en microlímites pierdes valor contra Kx que no foldea.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Nunca puedes foldear set aquí.'],
            ],
            'El check-raise turn no debe ser solo farol: necesitas suficientes manos fuertes para que tu rango sea creíble.',
            'En NL2-NL10, si el rival apuesta fuerte top pair, suele pagar demasiado ante raise. Sube por valor y no hagas slowplay sin razón.',
            91
        );
    }

    protected static function twoPairProtectionDynamicTurn(): array
    {
        return self::spot(
            'turn_xr_bb_vs_co_q98tt_q9_turn_2_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_two_pair_value',
            'Dobles por valor y protección',
            'BB vs CO · Q9 en Q98tt · Turn 2',
            'BB',
            'CO',
            ['Qs', '9s'],
            ['Qh', '9d', '8h', '2c'],
            12.0,
            3.7,
            44.0,
            'Board conectado con proyectos de color y escalera',
            'CO tiene overpairs y AQ/KQ, pero BB conecta más con dobles, pares + draw y escaleras.',
            'BB tiene más T7, JT, Q9, 98 y sets bajos; CO tiene manos fuertes de rango alto.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: Q♥ 9♦ 8♥', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 2♣', 'BB checks', 'CO bets 8 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'Top two en un board tan dinámico quiere cobrar y proteger. Hay muchos rivers malos: corazones, T, J, 7 o cartas que cortan acción. Subir ahora extrae valor de Qx, overpairs, combo draws y pares + draw.',
            'GTO simplificado: en boards donde BB tiene más nuts locales, sus dobles y sets pueden check-raisear turn con frecuencia relevante.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 89, 'feedback' => 'Muy bien. Valor y protección se combinan perfectamente aquí.'],
                'CALL' => ['grade' => 'good', 'frequency' => 36, 'ev_score' => 77, 'feedback' => 'Call gana, pero permite demasiadas rivers complicadas.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Folding top two en este spot es un error enorme.'],
            ],
            'Las dobles fuertes suben más cuando el board es dinámico y el rival todavía tiene muchas manos peores que continúan.',
            'En microlímites no esperes al river con dobles en boards cargados. Cobra ahora: te pagan top pair, proyectos y overpairs.',
            89
        );
    }

    protected static function comboDrawVsSecondBarrel(): array
    {
        return self::spot(
            'turn_xr_bb_vs_btn_j76tt_t9hh_turn_2_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_combo_draw_barrel',
            'Combo draw como semi-bluff',
            'BB vs BTN · T9hh en J76hh · Turn 2',
            'BB',
            'BTN',
            ['Th', '9h'],
            ['Jh', '7h', '6c', '2s'],
            11.0,
            4.1,
            45.0,
            'Board muy dinámico con flush draw y straight draw',
            'BTN tiene ventaja preflop, pero BB conecta mucho con esta textura.',
            'BB tiene más escaleras, dobles y sets bajos; BTN tiene overpairs, Jx fuertes y draws altos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♥ 7♥ 6♣', 'BB checks', 'BTN bets 3.5 BB', 'BB calls', 'Turn: 2♠', 'BB checks', 'BTN bets 7.5 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'T9hh tiene mucha equity: flush draw, gutshot/straight outs y capacidad de tirar manos mejores como A-high, pockets y algunos Jx débiles. El check-raise presiona el rango de barrel y prepara shove en rivers favorables.',
            'GTO simplificado: los mejores semi-bluffs de check-raise turn combinan equity real, blockers y buena jugabilidad river.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 48, 'ev_score' => 86, 'feedback' => 'Correcto. Es un semi-bluff fuerte con mucha equity y fold equity.'],
                'CALL' => ['grade' => 'good', 'frequency' => 46, 'ev_score' => 78, 'feedback' => 'Call es viable por equity, pero realizas peor fuera de posición.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 35, 'feedback' => 'Demasiado tight. Tu mano tiene demasiada equity para abandonar.'],
            ],
            'No todos los proyectos deben raisear: elige los que tienen equity suficiente y pueden seguir presionando rivers buenas.',
            'En NL2-NL10 usa este raise contra rivales que foldean turns. Contra calling stations, prefiere call y cobra cuando ligues.',
            86
        );
    }

    protected static function nutFlushDrawOvercardSemiBluff(): array
    {
        return self::spot(
            'turn_xr_sb_vs_btn_q84tt_ahjh_turn_6_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_combo_draw_barrel',
            'Nut flush draw con overcards',
            'SB vs BTN · AhJh en Q84hh · Turn 6',
            'SB',
            'BTN',
            ['Ah', 'Jh'],
            ['Qh', '8h', '4c', '6d'],
            18.0,
            2.9,
            52.0,
            'Bote 3bet con flush draw y turn bajo',
            'SB conserva overpairs y AQ; BTN tiene Qx, pares medios y proyectos.',
            'SB tiene AA/KK/AQ y algunos sets; BTN tiene más suited connectors y floats con equity.',
            ['BTN opens 2.5 BB', 'SB 3bets 10 BB', 'BTN calls', 'Flop: Q♥ 8♥ 4♣', 'SB bets 6 BB', 'BTN calls', 'Turn: 6♦', 'SB checks', 'BTN bets 11 BB', 'Action on Hero SB'],
            ['CALL', 'CHECK_RAISE_ALL_IN', 'FOLD'],
            'CHECK_RAISE_ALL_IN',
            'AhJh bloquea nut flushes futuros y tiene muchísima equity contra Qx y pares. Con SPR bajo, el check-raise all-in aplica máxima presión y evita jugar river fuera de posición sin iniciativa.',
            'GTO simplificado: en SPR bajo, los proyectos nut con overcards pueden convertirse en semi-bluff all-in cuando bloquean calls fuertes y conservan equity contra el rango de call.',
            [
                'CHECK_RAISE_ALL_IN' => ['grade' => 'best', 'frequency' => 42, 'ev_score' => 84, 'feedback' => 'Muy buena línea. Maximizas fold equity y tienes equity cuando pagan.'],
                'CALL' => ['grade' => 'good', 'frequency' => 50, 'ev_score' => 77, 'feedback' => 'Call es correcto, pero realizas peor equity OOP.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 30, 'feedback' => 'Demasiado débil con nut draw y overcards.'],
            ],
            'Los proyectos a las nuts son los mejores candidatos para líneas agresivas porque no temen estar dominados cuando completan.',
            'Contra rivales pasivos que apuestan fuerte solo valor, baja la agresividad. Contra regulares que stabbean demasiado, el all-in imprime dinero.',
            84,
            'three_bet_pot',
            '3Bet Pot'
        );
    }

    protected static function blockerBluffOnBroadwayTurn(): array
    {
        return self::spot(
            'turn_xr_bb_vs_btn_aq5r_kt_turn_j_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_combo_draw_barrel',
            'Farol con blockers a nuts',
            'BB vs BTN · KT en AQ5r · Turn J',
            'BB',
            'BTN',
            ['Ks', 'Tc'],
            ['Ah', 'Qd', '5c', 'Js'],
            9.5,
            4.6,
            44.0,
            'Broadway turn que completa escalera',
            'BTN tiene ventaja de rango en A-high, pero BB puede tener KT suited y algunos combos de nuts.',
            'KT es la escalera máxima; BB tiene menos combos, pero cuando los tiene puede presionar fuerte.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♥ Q♦ 5♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: J♠', 'BB checks', 'BTN bets 6 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'Con KT tienes la escalera máxima. Subir es valor claro contra dobles, sets, AK, AQ y faroles con equity. Además, tu rango necesita representar esta carta cuando el turn cambia radicalmente las nuts.',
            'GTO simplificado: cuando una carta de turn cambia las nuts a favor del caller, el check-raise gana importancia con valor y algunos bluffs con blockers.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 93, 'feedback' => 'Excelente. Tienes nuts y el rival puede pagar muchas manos fuertes peores.'],
                'CALL' => ['grade' => 'good', 'frequency' => 32, 'ev_score' => 82, 'feedback' => 'Call mantiene faroles dentro, pero pierde valor contra manos fuertes.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'No puedes foldear la escalera máxima.'],
            ],
            'Cuando el turn completa una mano que tu rango puede tener y el agresor sigue apostando, tus nuts deben subir con frecuencia.',
            'En NL2-NL10, la gente no foldea dobles ni top pair fuerte. Sube por valor, no te pongas creativo haciendo solo call siempre.',
            93
        );
    }

    protected static function exploitWeakDoubleBarrel(): array
    {
        return self::spot(
            'turn_xr_bb_vs_btn_983r_a5s_turn_2_raise_bluff',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_combo_draw_barrel',
            'XR exploitativo vs barrel débil',
            'BB vs BTN · A5s en 983r · Turn 2',
            'BB',
            'BTN',
            ['As', '5s'],
            ['9h', '8d', '3c', '2s'],
            8.5,
            5.1,
            43.0,
            'Board medio-bajo donde BB conecta más que BTN',
            'BTN tiene overcards y overpairs, pero BB tiene muchas parejas, dobles y sets.',
            'BB tiene más 98, 88, 33, 22 y 76; BTN tiene overpairs y barrels con aire.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♥ 8♦ 3♣', 'BB checks', 'BTN bets 2.5 BB', 'BB calls', 'Turn: 2♠', 'BB checks', 'BTN bets 4 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'A5s no tiene showdown value suficiente, pero bloquea algunos Ax que siguen barreleando y tiene gutshot al 4. En esta textura BB representa muchas manos fuertes y puede atacar barrels pequeños.',
            'GTO simplificado: los check-raises de bluff funcionan mejor cuando el caller tiene ventaja de nuts y el candidato conserva equity o blockers útiles.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 36, 'ev_score' => 80, 'feedback' => 'Buena presión si el rival barrelea demasiado.'],
                'CALL' => ['grade' => 'marginal', 'frequency' => 22, 'ev_score' => 55, 'feedback' => 'Call realiza algo de equity, pero sigues OOP con poca claridad.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 68, 'feedback' => 'Fold es correcto contra rivales pasivos o muy value-heavy.'],
            ],
            'El farol de check-raise turn no es automático: depende mucho de si el rival apuesta demasiadas manos débiles.',
            'En microlímites este raise solo va contra rivales que apuestan y foldean. Contra calling stations es quemar fichas.',
            80
        );
    }

    protected static function valueOnPairedTurn(): array
    {
        return self::spot(
            'turn_xr_bb_vs_btn_t62r_22_turn_t_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_trips_value',
            'Full house en turn emparejado',
            'BB vs BTN · 22 en T62r · Turn T',
            'BB',
            'BTN',
            ['2h', '2d'],
            ['Ts', '6c', '2s', 'Th'],
            10.0,
            4.3,
            43.0,
            'Board emparejado, trips visibles',
            'BTN tiene Tx fuertes y overpairs; BB tiene full houses y algunos Tx defendidos.',
            'BB tiene 22/66 y T6s/T2s ocasionales; BTN tiene AT, KT, QT, JJ-AA.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 6♣ 2♠', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: T♥', 'BB checks', 'BTN bets 7 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'Con full house, el check-raise es valor puro. BTN no va a foldear muchos Tx, overpairs tercos ni proyectos de color que creen tener equity. Pagar demasiado a menudo deja escapar valor.',
            'GTO simplificado: en paired turns, los full houses son parte esencial del rango de check-raise para castigar apuestas de trips y overpairs.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 95, 'feedback' => 'Perfecto. Es una mano para construir bote grande.'],
                'CALL' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 83, 'feedback' => 'Call atrapa faroles, pero pierdes valor contra Tx.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Foldear full house es imposible.'],
            ],
            'Cuando bloqueas muy poco el rango de call del rival y tienes una mano casi invulnerable, subir imprime valor.',
            'En NL2-NL10, trips casi nunca foldea. Haz raise fuerte y deja que el rival se equivoque pagando.',
            95
        );
    }

    protected static function connectedBoardStraightPressure(): array
    {
        return self::spot(
            'turn_xr_bb_vs_co_987tt_t6_turn_5_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_straight_value',
            'Escalera en board conectado',
            'BB vs CO · T6 en 987tt · Turn 5',
            'BB',
            'CO',
            ['Ts', '6s'],
            ['9h', '8h', '7c', '5d'],
            13.5,
            3.2,
            43.0,
            'Board extremadamente conectado',
            'CO tiene overpairs y sets, pero BB conecta mucho más con escaleras y dobles.',
            'BB tiene más T6, 64, JT y two pairs; CO tiene sets, overpairs y algunos draws fuertes.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: 9♥ 8♥ 7♣', 'BB checks', 'CO bets 4.5 BB', 'BB calls', 'Turn: 5♦', 'BB checks', 'CO bets 9 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_ALL_IN', 'FOLD'],
            'CHECK_RAISE_ALL_IN',
            'T6 liga escalera. El board es tan mojado que muchas rivers cortan acción o completan manos mejores. Con SPR bajo-medio, subir all-in captura valor de sets, dobles, overpairs con draw y proyectos grandes.',
            'GTO simplificado: en boards muy dinámicos, las escaleras vulnerables empujan mucho valor/protección antes de que el river cambie la textura.',
            [
                'CHECK_RAISE_ALL_IN' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 92, 'feedback' => 'Excelente. No dejes river barato en esta textura.'],
                'CALL' => ['grade' => 'marginal', 'frequency' => 34, 'ev_score' => 66, 'feedback' => 'Call puede inducir, pero demasiadas rivers son malas.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'No puedes foldear escalera aquí.'],
            ],
            'Las nuts actuales no siempre son invulnerables; en boards dinámicos, proteger valor es tan importante como extraerlo.',
            'En microlímites los sets y proyectos pagan muchísimo. Empuja valor antes de que una carta de miedo mate la acción.',
            92
        );
    }

    protected static function microlimitValueVsStation(): array
    {
        return self::spot(
            'turn_xr_bb_vs_btn_a95tt_99_turn_3_raise_station',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_set_value',
            'Check-raise por valor vs pagador',
            'BB vs BTN · 99 en A95tt · Turn 3',
            'BB',
            'BTN',
            ['9c', '9d'],
            ['Ah', '9h', '5s', '3c'],
            11.5,
            3.8,
            44.0,
            'A-high con flush draw fallido en turn',
            'BTN tiene Ax fuertes y proyectos; BB tiene sets y dobles defendidas.',
            'BB tiene 99/55/A9s/A5s; BTN tiene AK-AJ, Ax suited y corazones.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♥ 9♥ 5♠', 'BB checks', 'BTN bets 3.5 BB', 'BB calls', 'Turn: 3♣', 'BB checks', 'BTN bets 8 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'Set de 9 contra un rival pagador es raise claro. BTN tendrá muchos Ax que no foldean, flush draws y manos tipo AK/AQ que se sienten demasiado fuertes.',
            'GTO simplificado: set fuerte puede mezclar call y raise; contra rangos que apuestan/callean demasiado, el raise gana EV.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 94, 'feedback' => 'Correcto. Castigas Ax y proyectos que pagan demasiado.'],
                'CALL' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 81, 'feedback' => 'Call gana, pero es menos explotativo contra pagadores.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Nunca foldees set en este punto.'],
            ],
            'La teoría mezcla líneas, pero la explotación manda cuando el rival comete errores claros pagando de más.',
            'En NL2-NL10 este es raise por valor sin drama. El pool paga Ax demasiado y no encuentra folds grandes.',
            94
        );
    }

    protected static function polarizedRaiseRiverSetup(): array
    {
        return self::spot(
            'turn_xr_bb_vs_btn_kq4tt_asxs_turn_9_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_combo_draw_barrel',
            'XR polarizado para preparar river',
            'BB vs BTN · AsXs en KQ4ss · Turn 9',
            'BB',
            'BTN',
            ['As', '5s'],
            ['Ks', 'Qd', '4s', '9c'],
            10.5,
            4.2,
            44.0,
            'KQ alto con flush draw y muchas rivers dinámicas',
            'BTN tiene ventaja de rango, pero BB tiene proyectos fuertes y algunos combos de dobles/sets.',
            'BTN tiene AK/KQ/AA; BB tiene KQ, 44, Q9s, proyectos de color y escaleras.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ Q♦ 4♠', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 9♣', 'BB checks', 'BTN bets 7 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'A5s con nut flush draw bloquea muchos calls fuertes de color y puede seguir presionando spades en river. Además, el 9 añade dobles y escaleras al rango de BB. Es buen candidato polarizado.',
            'GTO simplificado: los check-raises polarizados de turn combinan valor fuerte con proyectos nut que pueden barrellear rivers favorables.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 40, 'ev_score' => 83, 'feedback' => 'Buena selección de bluff: nut draw, blocker y presión river.'],
                'CALL' => ['grade' => 'good', 'frequency' => 54, 'ev_score' => 78, 'feedback' => 'Call también es rentable por equity directa.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 28, 'feedback' => 'Demasiado tight con nut flush draw.'],
            ],
            'Para farolear turn necesitas un plan de river. Este tipo de mano puede seguir apostando en cartas que mejoran tu rango percibido.',
            'En microlímites no abuses del farol grande contra jugadores que no foldean top pair. Úsalo contra rivales capaces de tirar manos medias.',
            83
        );
    }

    protected static function straightValueVsSecondBarrel(): array
    {
        return self::spot(
            'turn_xr_bb_vs_btn_jt8r_q_9t_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_straight_value',
            'Escalera por valor contra second barrel',
            'BB vs BTN · T9 en JT8r · Turn Q',
            'BB',
            'BTN',
            ['Ts', '9s'],
            ['Jh', 'Td', '8c', 'Qs'],
            10.5,
            4.1,
            43.0,
            'Turn completa muchas escaleras',
            'BTN puede apostar overpairs, top pair fuerte y proyectos, pero BB conecta mucho con T9 y K9.',
            'BB tiene más combos de escaleras defendidas; BTN conserva ventaja de overpairs y broadways fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♥ T♦ 8♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: Q♠', 'BB checks', 'BTN bets 7 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'Hero tiene escalera y el board es dinámico. Solo pagar deja demasiado valor contra dobles, sets, overpairs con draw y Kx que no foldean. El check-raise cobra y protege contra rivers que cortan acción.',
            'GTO simplificado: en turns que completan una parte importante del rango de BB, las escaleras pueden subir por valor y equilibrarse con algunos proyectos fuertes.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 93, 'feedback' => 'Correcto. Tu mano es muy fuerte y el rival aún puede pagar con muchas peores.'],
                'CALL' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 80, 'feedback' => 'Call gana, pero deja valor y permite rivers incómodos.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Fold imposible con escalera.'],
            ],
            'Las manos muy fuertes en boards dinámicos prefieren construir bote antes de que el river frene la acción.',
            'En NL2-NL10 sube por valor. Te pagan dobles, sets, top pair fuerte y proyectos más de lo que deberían.',
            93
        );
    }

    protected static function comboDrawCheckRaiseOnScareCard(): array
    {
        return self::spot(
            'turn_xr_bb_vs_co_q97ss_k_jts_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_combo_draw_barrel',
            'Combo draw en scary card',
            'BB vs CO · JTs en Q97ss · Turn K',
            'BB',
            'CO',
            ['Js', 'Ts'],
            ['Qs', '9d', '7s', 'Kh'],
            11.0,
            4.0,
            45.0,
            'Turn K aumenta presión y equity',
            'CO puede seguir apostando KQ, AQ, overpairs y faroles, pero BB gana muchos proyectos fuertes.',
            'BB tiene escaleras, dobles y proyectos de color; CO mantiene manos altas que no siempre soportan un raise.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: Q♠ 9♦ 7♠', 'BB checks', 'CO bets 3.5 BB', 'BB calls', 'Turn: K♥', 'BB checks', 'CO bets 7.5 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'Hero tiene proyecto de color, gutshot y buena presión sobre una carta alta. Es un semi-bluff natural: cuando foldea ganas ya, y cuando paga aún tienes muchas outs.',
            'GTO simplificado: los combo draws con equity alta pueden entrar en la parte de bluff del check-raise turn.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 46, 'ev_score' => 84, 'feedback' => 'Buen semi-bluff. Tienes equity real y fold equity.'],
                'CALL' => ['grade' => 'good', 'frequency' => 50, 'ev_score' => 78, 'feedback' => 'Call también realiza equity, pero presiona menos.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 4, 'ev_score' => 18, 'feedback' => 'Demasiado tight con un proyecto tan fuerte.'],
            ],
            'Los mejores faroles de check-raise turn no son aire: tienen equity y buenas cartas de river para continuar.',
            'En microlímites úsalo mejor contra rivales capaces de foldear. Contra calling stations, call puede ser más estable.',
            84
        );
    }

    protected static function avoidCheckRaiseTopPairWeakKicker(): array
    {
        return self::spot(
            'turn_no_xr_bb_vs_btn_a83r_6_a5_call',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_avoid_overplaying_top_pair',
            'No sobrejugar top pair kicker débil',
            'BB vs BTN · A5 en A83r · Turn 6',
            'BB',
            'BTN',
            ['Ah', '5h'],
            ['As', '8d', '3c', '6s'],
            9.5,
            4.4,
            41.0,
            'Board A-high seco',
            'BTN tiene muchos Ax mejores y puede apostar thin value o protección.',
            'BB tiene Ax débiles defendidos, pero no domina suficientes calls peores ante un raise.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 8♦ 3♣', 'BB checks', 'BTN bets 2.5 BB', 'BB calls', 'Turn: 6♠', 'BB checks', 'BTN bets 6.5 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CALL',
            'A5 tiene showdown value, pero subir convierte una mano media en un bote enorme contra mejores Ax. El plan estándar es pagar y evaluar river.',
            'GTO simplificado: top pair kicker débil suele defender como call, no como check-raise de valor.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 78, 'feedback' => 'Correcto. Controlas el bote con showdown value.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 18, 'ev_score' => 50, 'feedback' => 'Demasiado tight ante tamaños normales, aunque no es desastre contra nit extremo.'],
                'CHECK_RAISE_3X' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 25, 'feedback' => 'Sobrejuegas una mano dominada por muchos Ax mejores.'],
            ],
            'No todo top pair merece check-raise. Valor fuerte significa cobrar a peores, no aislarse contra mejores.',
            'En NL2-NL10 muchos rivales no foldean Ax mejor. Paga y evita inflar el bote sin necesidad.',
            78
        );
    }

    protected static function avoidCheckRaiseWeakFlushDraw(): array
    {
        return self::spot(
            'turn_no_xr_bb_vs_co_k94ss_2_65s_call',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_avoid_weak_draw_barrel',
            'No check-raise con draw débil dominado',
            'BB vs CO · 65s en K94ss · Turn 2',
            'BB',
            'CO',
            ['6s', '5s'],
            ['Ks', '9d', '4s', '2h'],
            10.0,
            4.2,
            43.0,
            'Flush draw bajo sin overcards',
            'CO puede barrelear Kx, overpairs y proyectos mejores.',
            'BB tiene draws, pero los colores bajos sufren reverse implied odds.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: K♠ 9♦ 4♠', 'BB checks', 'CO bets 3 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'CO bets 7 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CALL',
            'El proyecto de color existe, pero es bajo y no bloquea los mejores calls del rival. Subir genera un bote grande con equity vulnerable. Call con odds razonables es mejor.',
            'GTO simplificado: no todos los draws son buenos faroles de raise; los mejores tienen blockers, overcards o equity robusta.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 56, 'ev_score' => 70, 'feedback' => 'Bien. Realizas equity sin convertir un draw vulnerable en farol grande.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 64, 'feedback' => 'Aceptable si el tamaño es grande o el rival no paga implícitas.'],
                'CHECK_RAISE_3X' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 32, 'feedback' => 'Mal candidato de raise: color bajo y pocos blockers.'],
            ],
            'Los draws bajos pueden parecer bonitos, pero no siempre soportan agresión grande.',
            'En microlímites, evita semi-bluffs caros con draws dominados. Juega más directo.',
            70
        );
    }

    protected static function checkRaiseTripsPairedBoard(): array
    {
        return self::spot(
            'turn_xr_bb_vs_btn_884r_8_a8_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_trips_value',
            'Trips en board emparejado',
            'BB vs BTN · A8 en 884r · Turn 8',
            'BB',
            'BTN',
            ['Ah', '8h'],
            ['8s', '8d', '4c', '8c'],
            8.5,
            4.8,
            45.0,
            'Board muy emparejado y rango del rival capeado',
            'BTN puede apostar overpairs, A-high y faroles pensando que BB tiene pocas manos fuertes.',
            'BB tiene más 8x defendidos; BTN tiene overpairs pero pocos trips.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 8♠ 8♦ 4♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 8♣', 'BB checks', 'BTN bets 5 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'Con poker/trips máximo relativo, Hero debe construir bote. Muchos rivales no creen el raise en boards emparejados y pagan overpairs o A-high por curiosidad.',
            'GTO simplificado: BB puede tener más 8x en defensa, así que el check-raise por valor es natural.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 94, 'feedback' => 'Correcto. Mano enorme y rango percibido poco creíble: cobra.'],
                'CALL' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 82, 'feedback' => 'Call atrapa, pero puede perder valor contra overpairs.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Nunca puedes foldear aquí.'],
            ],
            'Los boards emparejados permiten trampas, pero en límites bajos el valor directo suele ganar más.',
            'En NL2-NL10 apuesta/sube tus monstruos. La gente paga por incredulidad.',
            94
        );
    }

    protected static function checkRaiseNutBlockerBluff(): array
    {
        return self::spot(
            'turn_xr_bb_vs_btn_aq7ss_3_as5c_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_combo_draw_barrel',
            'Bluff con blocker al nut flush',
            'BB vs BTN · A5 con As en Q7xss · Turn 3',
            'BB',
            'BTN',
            ['As', '5c'],
            ['Qs', '7s', '2d', '3h'],
            10.5,
            4.0,
            42.0,
            'Turn blank con proyecto de color presente',
            'BTN apuesta mucho valor medio y draws, pero Hero bloquea el nut flush draw.',
            'BB puede representar sets, dobles y algunos proyectos fuertes; As bloquea continuaciones fuertes del rival.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♠ 2♦', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 3♥', 'BB checks', 'BTN bets 7 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'A♠ bloquea los proyectos de color más fuertes que continuarían. Hero no tiene gran showdown value, así que puede convertir la mano en bluff contra rivales capaces de foldear Qx débil.',
            'GTO simplificado: los blockers al nut draw son candidatos razonables para la parte de bluff del check-raise.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 34, 'ev_score' => 76, 'feedback' => 'Buen bluff selectivo con blocker relevante.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 44, 'ev_score' => 66, 'feedback' => 'Fold es prudente contra rivales calling station.'],
                'CALL' => ['grade' => 'marginal', 'frequency' => 18, 'ev_score' => 48, 'feedback' => 'Call sin equity suficiente puede ser débil.'],
            ],
            'Los bluffs de check-raise deben bloquear continuaciones fuertes y tener historia creíble.',
            'En microlímites este bluff no es automático. Úsalo contra rivales que sí foldean second pair/top pair débil.',
            76
        );
    }

    protected static function checkCallOesdBetterThanRaise(): array
    {
        return self::spot(
            'turn_no_xr_bb_vs_btn_t98r_2_qj_call',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_call_strong_draw',
            'OESD: call mejor que raise',
            'BB vs BTN · QJ en T98r · Turn 2',
            'BB',
            'BTN',
            ['Qh', 'Jc'],
            ['Ts', '9d', '8c', '2h'],
            11.5,
            4.1,
            44.0,
            'Board muy conectado con proyecto fuerte',
            'BTN puede tener overpairs, sets, dobles y escaleras; BB tiene muchos proyectos.',
            'QJ tiene muchas outs, pero algunas pueden estar dominadas o partir bote.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♦ 8♣', 'BB checks', 'BTN bets 3.5 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'BTN bets 7.5 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CALL',
            'QJ tiene proyecto fuerte, pero subir puede aislar contra escaleras hechas, sets y manos que no foldean. Call conserva implícitas y evita inflar con equity no realizada.',
            'GTO simplificado: algunos proyectos fuertes prefieren call cuando el rango rival continúa demasiado bien contra raise.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 76, 'feedback' => 'Correcto. Realizas equity sin sobreexponerte.'],
                'CHECK_RAISE_3X' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 70, 'feedback' => 'Puede mezclarse, pero no es obligatorio.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 24, 'feedback' => 'Demasiado tight con OESD fuerte.'],
            ],
            'No todos los proyectos buenos deben raisear. A veces call captura más EV y evita varianza innecesaria.',
            'En NL2-NL10, si el rival no foldea overpair ni set, toma odds y cobra cuando completes.',
            76
        );
    }

    protected static function checkRaiseTurnCardFavorsBb(): array
    {
        return self::spot(
            'turn_xr_bb_vs_co_765r_4_a5_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_lead_dynamic_card',
            'Carta de turn favorece muchísimo a BB',
            'BB vs CO · A5 en 765r · Turn 4',
            'BB',
            'CO',
            ['Ah', '5h'],
            ['7s', '6d', '5c', '4h'],
            12.0,
            3.8,
            46.0,
            'Turn 4 completa muchas escaleras de BB',
            'CO tiene overpairs, pero BB defiende muchos 8x, 3x, 65, 54 y pares + draw.',
            'El 4 mejora más al rango de BB que al de CO.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: 7♠ 6♦ 5♣', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'CO bets 8 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'Hero tiene escalera y la carta de turn golpea muy fuerte la defensa de BB. Check-raise castiga overpairs y sets que no quieren creer la historia.',
            'GTO simplificado: cuando una carta favorece mucho al caller preflop, el rango de check-raise aumenta con valor y algunos bluffs.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 95, 'feedback' => 'Excelente. Valor fuerte en carta que favorece tu rango.'],
                'CALL' => ['grade' => 'good', 'frequency' => 26, 'ev_score' => 82, 'feedback' => 'Call gana, pero deja valor contra overpairs.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Fold absurdo con escalera.'],
            ],
            'Reconocer cartas que favorecen tu rango permite subir por valor con más confianza.',
            'En microlímites, los overpairs pagan demasiado en boards bajos. Sube fuerte por valor.',
            95
        );
    }

    protected static function avoidSpewVsOverbet(): array
    {
        return self::spot(
            'turn_no_xr_bb_vs_btn_kq6ss_2_qj_overbet_call',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_avoid_bad_bluff',
            'No hacer spew contra overbet',
            'BB vs BTN · QJ en KQ6ss · Turn 2',
            'BB',
            'BTN',
            ['Qh', 'Jh'],
            ['Ks', 'Qd', '6s', '2c'],
            11.0,
            8.0,
            40.0,
            'BTN overbetea turn',
            'La overbet polariza el rango de BTN hacia valor fuerte y faroles con equity.',
            'BB tiene segunda pareja, pero no quiere convertirla en raise grande.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ Q♦ 6♠', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♣', 'BB checks', 'BTN bets 11 BB into 8 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CALL',
            'QJ bloquea parte de valor y tiene showdown value, pero check-raise contra overbet es spew: solo te pagan mejores o proyectos fuertes. Call o fold según rival es mejor.',
            'GTO simplificado: contra overbets, las manos medias defienden con call o fold; el raise se reserva para rangos muy polarizados.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 42, 'ev_score' => 68, 'feedback' => 'Call es razonable si el rival overbetea de más.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 64, 'feedback' => 'Fold es correcto contra rivales muy honestos.'],
                'CHECK_RAISE_3X' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 8, 'feedback' => 'Spew caro. No conviertas una mano media en farol gigante.'],
            ],
            'El check-raise contra overbet necesita una mano muy fuerte o un bluff excelente. No improvises con pares medios.',
            'En NL2-NL10 las overbets suelen estar cargadas de valor. No te inmoles por orgullo.',
            68
        );
    }

    protected static function checkRaiseSmallValueVsStation(): array
    {
        return self::spot(
            'turn_xr_bb_vs_btn_a86hh_8_a8_raise',
            'turn_check_raise',
            'Turn Check Raise',
            'turn_set_value',
            'Raise pequeño por valor contra calling station',
            'BB vs BTN · A8 en A86hh · Turn 8',
            'BB',
            'BTN',
            ['Ad', '8d'],
            ['Ah', '8h', '6c', '8s'],
            10.0,
            3.9,
            50.0,
            'Turn mejora a full house',
            'BTN puede seguir apostando Ax, proyectos de color, 6x y faroles automáticos.',
            'BB tiene full y trips; BTN tiene Ax fuertes que pagarán demasiado.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♥ 8♥ 6♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 8♠', 'BB checks', 'BTN bets 7 BB', 'Action on Hero BB'],
            ['CALL', 'CHECK_RAISE_3X', 'FOLD'],
            'CHECK_RAISE_3X',
            'Contra rivales pagadores, full house quiere subir ya. Hay Ax, proyectos y manos curiosas que pagan demasiado. Call es rentable, pero deja mucho dinero en la mesa.',
            'GTO simplificado: las manos muy fuertes mezclan call y raise; explotativamente el raise gana contra jugadores que pagan Ax en exceso.',
            [
                'CHECK_RAISE_3X' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 96, 'feedback' => 'Perfecto. Máximo valor contra un rango que paga demasiado.'],
                'CALL' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 84, 'feedback' => 'Call atrapa, pero en micro pierdes valor.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Nunca foldees full house.'],
            ],
            'La explotación clara contra calling stations es subir más por valor y farolear menos.',
            'En NL2-NL10 este spot es imprimir valor: sube y deja que el rival cometa el error pagando.',
            96
        );
    }

}
