<?php

namespace App\SpotTraining\PostflopTurn\Modules;

use App\SpotTraining\PostflopTurn\Concerns\BuildsPostflopTurnSpots;

class TurnProbeBetSpots
{
    use BuildsPostflopTurnSpots;

    public static function all(): array
    {
        return [
            self::probeTopPairAfterFlopChecks(),
            self::probeSecondPairForValueProtection(),
            self::probeCompletedStraight(),
            self::probeFlushCompletesWithNutBlocker(),
            self::checkWeakShowdownValue(),
            self::probeScareAceCard(),
            self::probePairedBoardTrips(),
            self::checkBadTurnForRange(),
            self::probeComboDrawTurn(),
            self::probeThinValueVsMissedCbet(),
        ];
    }

    protected static function probeTopPairAfterFlopChecks(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_k72r_k9_turn_4',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_value',
            'Probe por valor con top pair',
            'BB vs BTN · K9 en K72r · Turn 4',
            'BB',
            'BTN',
            ['Kh', '9h'],
            ['Ks', '7c', '2d', '4h'],
            5.5,
            8.2,
            45.0,
            'K-high seco, turn blank',
            'BTN conserva ventaja de rango preflop, pero su check back debilita su rango.',
            'BTN tiene Kx fuertes ocasionales; BB tiene más 7x, 2x y algunos Kx defendidos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♣ 2♦', 'BB checks', 'BTN checks back', 'Turn: 4♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'Después del check back de BTN, K9 suele ir por delante. Apostar medio cobra a pares peores, floats con A-high y proyectos backdoor que mejoraron algo.',
            'GTO simplificado: cuando el agresor preflop no apuesta flop, BB puede liderar turns blank con parte de su valor medio-fuerte.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 86, 'feedback' => 'Correcto. Apuestas por valor sin aislarte demasiado contra Kx mejores.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 74, 'feedback' => 'Check es defendible, pero pierde valor contra manos peores que pagan.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 18, 'ev_score' => 62, 'feedback' => 'Demasiado grande con top pair kicker medio. Foldeas demasiada basura y te aíslas.'],
            ],
            'El probe bet aparece cuando el agresor preflop chequea flop y el defensor lidera turn.',
            'En NL2-NL10 apuesta por valor. Mucha gente chequea detrás Ax, pares y Kx débiles y luego paga turn.',
            86
        );
    }

    protected static function probeSecondPairForValueProtection(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_q83r_8s_turn_2',
            'turn_probe',
            'Turn Probe Bet',
            'turn_value_protection',
            'Segunda pareja y protección',
            'BB vs BTN · 8♠7♠ en Q83r · Turn 2',
            'BB',
            'BTN',
            ['8s', '7s'],
            ['Qh', '8c', '3d', '2s'],
            5.5,
            8.0,
            44.0,
            'Q-high seco, turn bajo con backdoor spade',
            'BTN tiene Qx fuertes, pero su check back reduce combos de valor fuerte.',
            'BB tiene muchas parejas medias y algunas dobles/set bajos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♥ 8♣ 3♦', 'BB checks', 'BTN checks back', 'Turn: 2♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'Segunda pareja puede apostar pequeño/medio para cobrar a A-high, pares bajos y proteger contra overcards. No necesita sizing grande.',
            'GTO simplificado: los probes de protección usan sizings medios con manos vulnerables que no quieren dar carta gratis.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 80, 'feedback' => 'Bien. Sacas valor/protección sin inflar demasiado el bote.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 40, 'ev_score' => 72, 'feedback' => 'Check también es posible, pero permite realizar equity gratis.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 42, 'feedback' => 'Sizing grande convierte una mano media en farol innecesario.'],
            ],
            'Con valor vulnerable, la idea es cobrar y proteger, no polarizar.',
            'En microlímites, apuesta medio: te pagan A-high y pares peores, pero no quemes dinero apostando grande.',
            80
        );
    }

    protected static function probeCompletedStraight(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_987r_t6_turn_5',
            'turn_probe',
            'Turn Probe Bet',
            'turn_straight_value',
            'Escalera completada en turn',
            'BB vs BTN · T6s en 987r · Turn 5',
            'BB',
            'BTN',
            ['Ts', '6s'],
            ['9h', '8c', '7d', '5s'],
            5.5,
            8.0,
            44.0,
            'Board muy conectado, turn completa escalera',
            'BB conecta más con cartas bajas y conectores defendidos.',
            'BB tiene muchas escaleras; BTN tiene overpairs y broadways más a menudo.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♥ 8♣ 7♦', 'BB checks', 'BTN checks back', 'Turn: 5♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Hero tiene escalera fuerte y el board es muy dinámico. Hay que apostar grande por valor contra pares, dobles, sets y proyectos.',
            'GTO simplificado: cuando el turn mejora mucho al defensor y este tiene nuts, puede liderar con sizing grande.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 94, 'feedback' => 'Excelente. Construyes bote con una mano muy fuerte.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 45, 'ev_score' => 82, 'feedback' => 'Correcto, pero puedes sacar más valor.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 8, 'ev_score' => 22, 'feedback' => 'Slowplay malo en board mojado. Das carta gratis y pierdes valor.'],
            ],
            'Los turns que cambian la ventaja de nuts hacia BB justifican probes fuertes.',
            'En NL2-NL10 apuesta grande tus manos fuertes. La gente paga demasiado con overpair, pair+draw y dobles.',
            92
        );
    }

    protected static function probeFlushCompletesWithNutBlocker(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_k72ss_as5c_turn_4s',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_draw',
            'Probe bluff con blocker al color',
            'BB vs BTN · A♠5♣ en K72ss · Turn 4♠',
            'BB',
            'BTN',
            ['As', '5c'],
            ['Ks', '7s', '2d', '4s'],
            5.5,
            8.0,
            44.0,
            'Turn completa color',
            'BTN tiene Kx y overcards; BB tiene muchos suited defendidos.',
            'BB representa colores; Hero bloquea el color máximo con A♠.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♠ 2♦', 'BB checks', 'BTN checks back', 'Turn: 4♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'A♠ bloquea el nut flush y Hero puede representar muchos colores tras defender BB. El sizing medio presiona Kx sin invertir demasiado.',
            'GTO simplificado: los blockers al nut flush permiten algunos probes de farol cuando la carta favorece al defensor.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 46, 'ev_score' => 76, 'feedback' => 'Buen farol con blocker relevante y carta favorable para BB.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 48, 'ev_score' => 70, 'feedback' => 'Check es estándar muchas veces; no hay obligación de farolear.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 16, 'ev_score' => 56, 'feedback' => 'Demasiado caro sin mano hecha. Mejor no sobrefarolear.'],
            ],
            'Los probes de farol necesitan blockers o equity, no se hacen con aire al azar.',
            'En microlímites úsalo con cuidado. Si el rival es calling station, check es mejor que intentar representar demasiado.',
            74
        );
    }

    protected static function checkWeakShowdownValue(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_a72r_77_turn_9',
            'turn_probe',
            'Turn Probe Bet',
            'turn_showdown_value_check',
            'Check con showdown value',
            'BB vs BTN · 77 en A72r · Turn 9',
            'BB',
            'BTN',
            ['7h', '7d'],
            ['As', '7c', '2h', '9d'],
            5.5,
            8.0,
            44.0,
            'A-high seco, turn blank',
            'BTN tiene muchos Ax aunque haya chequeado flop.',
            'BB tiene algunos 7x fuertes, pero BTN conserva Ax mejores.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♣ 2♥', 'BB checks', 'BTN checks back', 'Turn: 9♦', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            '77 tiene showdown value, pero no quiere construir un bote grande contra Ax. Apostar convierte una mano media en thin value dudoso.',
            'GTO simplificado: no todos los checks back del agresor significan debilidad; en A-high aún conserva mucho Ax.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 78, 'feedback' => 'Correcto. Controlas bote y realizas showdown value.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 60, 'feedback' => 'Puede cobrar algo, pero te pagan demasiados Ax mejores.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 30, 'feedback' => 'Demasiado grande para una mano media en A-high.'],
            ],
            'El probe bet no debe usarse automáticamente: primero pregunta si peor paga o mejor foldea.',
            'En NL2-NL10 evita apostar por información. Con valor medio, controla bote.',
            78
        );
    }

    protected static function probeScareAceCard(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_t83r_qj_turn_a',
            'turn_probe',
            'Turn Probe Bet',
            'turn_bad_barrel_card',
            'Probe en scare card',
            'BB vs BTN · QJ en T83r · Turn A',
            'BB',
            'BTN',
            ['Qh', 'Jh'],
            ['Ts', '8c', '3d', 'Ah'],
            5.5,
            8.0,
            44.0,
            'A turn sobre board medio',
            'El A favorece más al rango preflop de BTN, pero su check back reduce Ax fuertes.',
            'BTN tiene Ax; BB tiene dobles/sets bajos y proyectos de escalera.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 8♣ 3♦', 'BB checks', 'BTN checks back', 'Turn: A♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'Aunque QJ tiene gutshot, el A favorece demasiado al rango de BTN. Liderar aquí se mete contra muchos Ax que no foldean.',
            'GTO simplificado: no conviene atacar todas las scare cards si pertenecen más al agresor preflop.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 76, 'feedback' => 'Bien. No representes una carta que golpea más al rival.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 24, 'ev_score' => 40, 'feedback' => 'Farol flojo: BTN tiene demasiados Ax que pagan.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 6, 'ev_score' => 18, 'feedback' => 'Bluff caro en carta mala para tu rango.'],
            ],
            'Una scare card solo se ataca si mejora suficientemente tu rango percibido o bloqueas manos fuertes.',
            'En microlímites no intentes hacer foldear top pair. El A no es buena carta para farolear contra gente que paga.',
            76
        );
    }

    protected static function probePairedBoardTrips(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_962r_9t_turn_9',
            'turn_probe',
            'Turn Probe Bet',
            'turn_trips_value',
            'Trips en board emparejado',
            'BB vs BTN · T9 en 962r · Turn 9',
            'BB',
            'BTN',
            ['Th', '9h'],
            ['9s', '6c', '2d', '9d'],
            5.5,
            8.0,
            44.0,
            'Board emparejado con trips para Hero',
            'BB defiende muchos 9x; BTN chequea bastante aire y pares medios.',
            'BB tiene gran ventaja de trips en esta secuencia.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♠ 6♣ 2♦', 'BB checks', 'BTN checks back', 'Turn: 9♦', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Hero tiene trips y el rival puede pagar con overpairs, 6x, pares medios y A-high curioso. Sizing grande maximiza valor.',
            'GTO simplificado: en boards emparejados donde BB tiene más trips, puede liderar fuerte por valor.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 92, 'feedback' => 'Excelente. Valor grande contra un rango que paga demasiado.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 48, 'ev_score' => 82, 'feedback' => 'También correcto, pero menos valor.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 44, 'feedback' => 'Demasiado pasivo con trips.'],
            ],
            'Cuando el turn empareja una carta que BB tiene más, el probe grande gana valor.',
            'En NL2-NL10 apuesta fuerte: muchos rivales no foldean overpair ni pares medios.',
            90
        );
    }

    protected static function checkBadTurnForRange(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_kq4r_54_turn_a',
            'turn_probe',
            'Turn Probe Bet',
            'turn_bad_barrel_card',
            'Check en carta mala para BB',
            'BB vs BTN · 54s en KQ4r · Turn A',
            'BB',
            'BTN',
            ['5c', '4c'],
            ['Kh', 'Qs', '4d', 'Ah'],
            5.5,
            8.0,
            44.0,
            'Broadway alto, turn A',
            'BTN tiene enorme ventaja de broadways y Ax.',
            'BTN tiene nuts de broadway; BB tiene pocas manos muy fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♥ Q♠ 4♦', 'BB checks', 'BTN checks back', 'Turn: A♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'La A♥ es pésima para BB. Aunque Hero ligó pareja en flop, ahora el rango de BTN domina con Ax, broadways y manos con J/T.',
            'GTO simplificado: el defensor debe chequear mucho en turns que impactan muy fuerte al agresor preflop.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 80, 'feedback' => 'Correcto. No ataques una carta que destruye tu rango.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 16, 'ev_score' => 34, 'feedback' => 'Apuesta débil contra un rango que mejora muchísimo.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 12, 'feedback' => 'Blunder. Sizing grande en una carta terrible para BB.'],
            ],
            'Antes de probe bet, evalúa si la turn mejora más al defensor o al agresor.',
            'En límites bajos, no farolees cartas que el rival ama. Te pagan con Ax y broadways.',
            82
        );
    }

    protected static function probeComboDrawTurn(): array
    {
        return self::spot(
            'turn_probe_bb_vs_btn_j82ss_qs9s_turn_ts',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_draw',
            'Probe con combo draw',
            'BB vs BTN · Q♠9♠ en J82ss · Turn T♦',
            'BB',
            'BTN',
            ['Qs', '9s'],
            ['Js', '8s', '2d', 'Td'],
            5.5,
            8.0,
            44.0,
            'Board dinámico con open-ended + flush draw',
            'BB tiene muchos conectores y proyectos fuertes.',
            'BB gana equity con T♦; BTN tiene overpairs/Jx.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 8♠ 2♦', 'BB checks', 'BTN checks back', 'Turn: T♦', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Q♠9♠ tiene open-ended, flush draw y mucha fold equity tras el check back de BTN. Un sizing grande presiona A-high, pares medios y algunas Jx débiles.',
            'GTO simplificado: los proyectos con mucha equity pueden apostar agresivo en turn como semi-bluff.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 52, 'ev_score' => 84, 'feedback' => 'Muy bien. Semi-bluff potente con muchísima equity.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 46, 'ev_score' => 78, 'feedback' => 'También válido, pero presiona menos.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 62, 'feedback' => 'Check realiza equity, pero pierdes fold equity con un combo draw fuerte.'],
            ],
            'Los mejores faroles de turn tienen equity fuerte cuando reciben call.',
            'En NL2-NL10 este semi-bluff es bueno contra rivales que foldean algo; contra calling stations puedes apostar menos o tomar carta.',
            84
        );
    }

    protected static function probeThinValueVsMissedCbet(): array
    {
        return self::spot(
            'turn_probe_sb_vs_btn_t64r_at_turn_a',
            'turn_probe',
            'Turn Probe Bet',
            'turn_probe_value',
            'Thin value tras missed c-bet',
            'SB vs BTN · ATo en T64r · Turn A',
            'SB',
            'BTN',
            ['Ah', 'Td'],
            ['Ts', '6c', '4h', 'Ad'],
            6.0,
            7.5,
            45.0,
            'Turn A mejora a Hero a dobles',
            'BTN tiene Ax, Tx y overpairs; su check back capea parte del rango.',
            'Hero tiene dobles; BTN conserva sets y algunas dobles mejores.',
            ['BTN opens 2.5 BB', 'SB calls', 'Flop: T♠ 6♣ 4♥', 'SB checks', 'BTN checks back', 'Turn: A♦', 'Action on Hero SB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Hero mejora a dobles. Debe apostar por valor contra Ax, Tx, overpairs y proyectos que el rival chequeó detrás.',
            'GTO simplificado: cuando el defensor mejora fuerte en turn tras missed c-bet, puede liderar grande por valor.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 90, 'feedback' => 'Excelente. Dobles quiere construir bote ya.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 48, 'ev_score' => 82, 'feedback' => 'Correcto, aunque algo pequeño contra rivales que pagan.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 42, 'feedback' => 'Demasiado pasivo. Hay valor claro contra muchas manos peores.'],
            ],
            'Cuando mejoras a valor fuerte en turn, liderar evita que el rival tome carta gratis.',
            'En microlímites apuesta grande por valor: Ax y Tx pagan muchísimo.',
            88
        );
    }
}
