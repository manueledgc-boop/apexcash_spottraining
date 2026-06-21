<?php

namespace App\SpotTraining\PostflopTurn\Modules;

use App\SpotTraining\PostflopTurn\Concerns\BuildsPostflopTurnSpots;

class TurnDefenseSpots
{
    use BuildsPostflopTurnSpots;

    public static function all(): array
    {
        return [
            self::callTopPairVsSecondBarrel(),
            self::foldWeakPairBadKicker(),
            self::raiseTurnTwoPairForValue(),
            self::callNutFlushDrawVsBarrel(),
            self::foldGutshotNoOdds(),
            self::callSecondPairVsSmallBet(),
            self::raiseSetOnWetTurn(),
            self::foldTopPairOnFourStraight(),
            self::callOverpairVsPolarBarrel(),
            self::foldAceHighNoEquity(),
            self::callTopPairWeakKickerVsSmallBarrel(),
            self::foldTopPairWeakKickerVsLargeBarrel(),
            self::callOverpairOnCoordinatedTurn(),
            self::callFlushDrawVsSeventyFivePot(),
            self::foldGutshotWithoutImpliedOdds(),
            self::callOesdOvercardsVsBarrel(),
            self::raiseTwoPairOnDangerousTurn(),
            self::callSetWhenFlushCompletes(),
            self::foldPureBluffCatcherNoBlocker(),
            self::foldTptkOnWorstRunout(),
        ];
    }

    protected static function callTopPairVsSecondBarrel(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_k72r_kj_turn_4_call',
            'turn_defense',
            'Turn Defense',
            'turn_call_top_pair',
            'Top pair vs segunda barrel',
            'BB vs BTN · KJ en K72r · Turn 4',
            'BB',
            'BTN',
            ['Kh', 'Jc'],
            ['Ks', '7d', '2c', '4h'],
            12.5,
            3.6,
            45.0,
            'K-high seco, turn blank',
            'BTN conserva ventaja de rango, pero BB tiene Kx defendidos.',
            'BTN tiene mejores Kx; BB tiene sets y Kx medios.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♦ 2♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'BTN bets 6 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'KJ es demasiado fuerte para foldear contra segunda barrel en blank. Raise aísla contra mejores manos y pierde valor contra faroles.',
            'GTO simplificado: top pair buen kicker defiende turn con call en boards secos.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 86, 'feedback' => 'Correcto. Mantienes faroles dentro y realizas valor.'],
                'RAISE' => ['grade' => 'marginal', 'frequency' => 12, 'ev_score' => 58, 'feedback' => 'Demasiado agresivo: te aíslas contra Kx mejores y sets.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 10, 'feedback' => 'Fold demasiado nit. KJ debe continuar aquí.'],
            ],
            'Top pair buen kicker suele defender contra segunda barrel en turns blank.',
            'En NL2-NL10 no foldees top pair sólido solo porque apuestan dos veces; paga y reevalúa river.',
            86
        );
    }

    protected static function foldWeakPairBadKicker(): array
    {
        return self::spot(
            'turn_defense_bb_vs_co_a94r_9x_turn_k_fold',
            'turn_defense',
            'Turn Defense',
            'turn_call_second_pair',
            'Pareja débil vs barrel fuerte',
            'BB vs CO · 9♠8♠ en A94r · Turn K',
            'BB',
            'CO',
            ['9s', '8s'],
            ['Ah', '9d', '4c', 'Kh'],
            12.5,
            3.8,
            47.0,
            'A-high con K turn favorable al agresor',
            'CO tiene muchos Ax, AK, AQ, KQ y dobles fuertes.',
            'CO mejora mucho con K; BB tiene pares medios vulnerables.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: A♥ 9♦ 4♣', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: K♥', 'BB checks', 'CO bets 7 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'Segunda pareja con kicker débil queda muy dominada cuando el K favorece al agresor. Sin proyecto claro, pagar quema EV.',
            'GTO simplificado: reducir defensa con pares medios débiles en turns que mejoran mucho al agresor.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 80, 'feedback' => 'Bien. Es una mano dominada y sin buen river plan.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 24, 'ev_score' => 42, 'feedback' => 'Call demasiado loose contra rango fuerte.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 3, 'ev_score' => 12, 'feedback' => 'Raise sin valor ni blockers suficientes.'],
            ],
            'Los pares débiles pierden mucho valor cuando la turn favorece claramente al agresor.',
            'En límites bajos respeta las segundas barrels grandes en A-high/K turn: suelen ser valor.',
            82
        );
    }

    protected static function raiseTurnTwoPairForValue(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_t86ss_t8_turn_2_raise',
            'turn_defense',
            'Turn Defense',
            'turn_two_pair_value',
            'Raise por valor con dobles',
            'BB vs BTN · T8 en T86ss · Turn 2',
            'BB',
            'BTN',
            ['Th', '8h'],
            ['Ts', '8s', '6d', '2c'],
            13.5,
            3.3,
            44.0,
            'Board dinámico con muchos proyectos',
            'BTN tiene overpairs, top pairs y draws.',
            'BB tiene más dobles y sets bajos; BTN mantiene overpairs.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 8♠ 6♦', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♣', 'BB checks', 'BTN bets 7 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'RAISE',
            'Dobles en board cargado quieren subir por valor y protección contra proyectos de color, escalera, Tx fuertes y overpairs.',
            'GTO simplificado: manos fuertes vulnerables pueden check-raisear turn en boards dinámicos.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 56, 'ev_score' => 90, 'feedback' => 'Excelente. Cobras a draws y manos hechas peores.'],
                'CALL' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 78, 'feedback' => 'Call es válido, pero deja demasiadas cartas malas river.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 4, 'feedback' => 'Fold imposible con dobles fuertes.'],
            ],
            'El raise turn no es solo farol: también protege manos fuertes vulnerables.',
            'En NL2-NL10 sube por valor. Te pagan proyectos, top pair y overpairs demasiado a menudo.',
            90
        );
    }

    protected static function callNutFlushDrawVsBarrel(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_q72ss_as5s_turn_9_call',
            'turn_defense',
            'Turn Defense',
            'turn_call_strong_draw',
            'Nut flush draw vs barrel',
            'BB vs BTN · A5s en Q72ss · Turn 9',
            'BB',
            'BTN',
            ['As', '5s'],
            ['Qs', '7s', '2d', '9c'],
            12.5,
            3.7,
            46.0,
            'Q-high con proyecto de color máximo',
            'BTN tiene Qx y overpairs; BB tiene draws y pares.',
            'BTN tiene top range; BB conserva algunos sets y draws fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♠ 2♦', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 9♣', 'BB checks', 'BTN bets 6 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'A5s con nut flush draw tiene equity suficiente para pagar. Raise puede existir como semi-bluff, pero call realiza equity y evita bloating innecesario.',
            'GTO simplificado: proyectos nut con buena equity continúan contra sizing medio.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 84, 'feedback' => 'Correcto. Tienes equity limpia al color máximo.'],
                'RAISE' => ['grade' => 'good', 'frequency' => 24, 'ev_score' => 74, 'feedback' => 'Semi-bluff válido contra rivales que foldean, menos necesario en micros.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 34, 'feedback' => 'Fold demasiado tight con nut draw.'],
            ],
            'Los nut draws fuertes no se abandonan frente a barrels razonables.',
            'En microlímites paga más que farolear si no tienes fold equity clara; cuando ligas, te pagan.',
            84
        );
    }

    protected static function foldGutshotNoOdds(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_j96r_q8_turn_2_fold',
            'turn_defense',
            'Turn Defense',
            'turn_fold_no_equity',
            'Gutshot débil sin odds',
            'BB vs BTN · Q8 en J96r · Turn 2',
            'BB',
            'BTN',
            ['Qh', '8c'],
            ['Js', '9d', '6c', '2h'],
            13.5,
            3.2,
            43.5,
            'Board medio conectado, turn blank',
            'BTN puede seguir con overpairs, Jx y draws mejores.',
            'BB tiene algunas escaleras, pero Q8 solo tiene gutshot débil.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 9♦ 6♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'BTN bets 9 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'Q8 necesita un T para escalera y muchas veces no cobra suficiente. Contra apuesta grande, las odds no alcanzan.',
            'GTO simplificado: proyectos débiles sin implied odds se abandonan ante sizings grandes.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 78, 'feedback' => 'Correcto. No persigas gutshots caros.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 36, 'feedback' => 'Call malo: pocas outs y reverse implied odds.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 14, 'feedback' => 'Farol sin blockers fuertes ni equity suficiente.'],
            ],
            'No todos los proyectos merecen pagar turn; el sizing manda.',
            'En NL2-NL10 no pagues por curiosidad. Gutshot débil contra apuesta grande es fold.',
            80
        );
    }

    protected static function callSecondPairVsSmallBet(): array
    {
        return self::spot(
            'turn_defense_bb_vs_co_q83r_8x_turn_2_call_small',
            'turn_defense',
            'Turn Defense',
            'turn_call_second_pair',
            'Segunda pareja vs apuesta pequeña',
            'BB vs CO · 87s en Q83r · Turn 2',
            'BB',
            'CO',
            ['8h', '7h'],
            ['Qd', '8c', '3s', '2d'],
            9.5,
            4.6,
            44.0,
            'Q-high seco, turn bajo',
            'CO tiene ventaja de Qx, pero sizing pequeño mantiene rango amplio.',
            'CO tiene top pairs; BB tiene pares medios y sets bajos.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: Q♦ 8♣ 3♠', 'BB checks', 'CO bets 1.5 BB', 'BB calls', 'Turn: 2♦', 'BB checks', 'CO bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Contra sizing pequeño, segunda pareja con backdoor bloquea parte del valor y tiene suficiente showdown para continuar.',
            'GTO simplificado: defender más ancho frente a sizings pequeños.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 80, 'feedback' => 'Bien. El precio es bueno y tu mano todavía gana a faroles.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 22, 'ev_score' => 46, 'feedback' => 'Fold demasiado tight contra sizing pequeño.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 34, 'feedback' => 'Raise convierte valor medio en farol sin necesidad.'],
            ],
            'El tamaño de apuesta cambia mucho la defensa mínima.',
            'En micros puedes pagar apuestas pequeñas con valor medio, pero no te cases si river cae malo y siguen apostando grande.',
            80
        );
    }

    protected static function raiseSetOnWetTurn(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_964ss_66_turn_js_raise',
            'turn_defense',
            'Turn Defense',
            'turn_set_value',
            'Set en turn mojado',
            'BB vs BTN · 66 en 964ss · Turn J♠',
            'BB',
            'BTN',
            ['6h', '6c'],
            ['9s', '6s', '4d', 'Js'],
            13.5,
            3.3,
            44.0,
            'Turn completa color, board muy dinámico',
            'BTN tiene overpairs y draws; BB tiene sets y algunos colores.',
            'BB tiene sets y colores; BTN tiene muchos proyectos completados y overpairs.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♠ 6♠ 4♦', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: J♠', 'BB checks', 'BTN bets 8 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Set sigue siendo fuerte, pero la pica completa color. Call mantiene faroles y evita aislarse demasiado contra colores. Raise puede existir contra rivales muy pagadores.',
            'GTO simplificado: sets sin blocker de color mezclan call y algunos raises en turns que completan flush.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 84, 'feedback' => 'Correcto. Mano fuerte, pero no invulnerable al color.'],
                'RAISE' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 76, 'feedback' => 'Válido contra rivales que pagan overpairs/draws, pero cuidado al aislarte.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 1, 'ev_score' => 8, 'feedback' => 'Fold imposible con set y redraw a full.'],
            ],
            'Las manos fuertes no siempre deben raisear cuando se completa el draw principal.',
            'En NL2-NL10 call es sólido; raise solo si sabes que pagan peor demasiado.',
            84
        );
    }

    protected static function foldTopPairOnFourStraight(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_t98_kt_turn_j_fold',
            'turn_defense',
            'Turn Defense',
            'turn_fold_no_equity',
            'Top pair en board de cuatro escalera',
            'BB vs BTN · KT en T98 · Turn J',
            'BB',
            'BTN',
            ['Kh', 'Td'],
            ['Ts', '9c', '8d', 'Jh'],
            13.5,
            3.1,
            42.0,
            'Board de cuatro cartas a escalera',
            'BTN puede tener muchas Qx, KQ, AQ y pares + draw.',
            'El rango con Qx gana muchísimo peso.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♣ 8♦', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: J♥', 'BB checks', 'BTN bets 10 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'KT parece top pair, pero el board ahora deja muchas escaleras. Sin Q ni redraw fuerte, pagar grande es mala defensa.',
            'GTO simplificado: top pair baja muchísimo en valor cuando la turn completa muchísimas escaleras.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 78, 'feedback' => 'Bien. La textura destruye el valor de top pair.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 24, 'ev_score' => 40, 'feedback' => 'Call demasiado optimista. Muchos rivers serán difíciles.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 3, 'ev_score' => 10, 'feedback' => 'Raise absurdo: representas poco y te pagan mejores.'],
            ],
            'La fuerza absoluta de la mano no importa; importa la textura y el rango.',
            'En micros, cuando apuestan grande en cuatro cartas a escalera, normalmente tienen mucho valor.',
            82
        );
    }

    protected static function callOverpairVsPolarBarrel(): array
    {
        return self::spot(
            'turn_defense_co_vs_bb_j72r_qq_turn_5_call',
            'turn_defense',
            'Turn Defense',
            'turn_call_showdown_value',
            'Overpair vs barrel polarizada',
            'CO vs BB · QQ en J72r · Turn 5',
            'CO',
            'BB',
            ['Qh', 'Qc'],
            ['Js', '7d', '2c', '5h'],
            14.0,
            3.4,
            47.0,
            'J-high seco, turn blank',
            'CO mantiene overpairs fuertes; BB tiene sets y Jx.',
            'CO tiene mejores overpairs; BB tiene sets ocasionales.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: J♠ 7♦ 2♣', 'BB checks', 'CO bets 3 BB', 'BB calls', 'Turn: 5♥', 'BB checks', 'CO bets 8 BB', 'BB raises', 'Action on Hero CO'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'QQ es muy fuerte para foldear ante un raise en blank, pero 3bet shove aísla demasiado contra sets. Call mantiene bluffs y Jx sobrejugados.',
            'GTO simplificado: overpair fuerte defiende con call frente a raises polarizados en turns blank.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 82, 'feedback' => 'Correcto. Controlas el bote y mantienes faroles.'],
                'RAISE' => ['grade' => 'marginal', 'frequency' => 18, 'ev_score' => 62, 'feedback' => 'Puede ser demasiado fuerte: te aíslas contra sets.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 42, 'feedback' => 'Fold demasiado débil con overpair fuerte en blank.'],
            ],
            'Las overpairs fuertes suelen continuar, pero no siempre necesitan meter todo en turn.',
            'En NL2-NL10 pagar es mejor que stackearse sin leer al rival; muchos raises son valor, pero también hay sobrejuego.',
            82
        );
    }

    protected static function foldAceHighNoEquity(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_k72r_aq_turn_9_fold',
            'turn_defense',
            'Turn Defense',
            'turn_fold_no_equity',
            'A-high sin equity',
            'BB vs BTN · AQ en K72r · Turn 9',
            'BB',
            'BTN',
            ['Ah', 'Qd'],
            ['Ks', '7c', '2h', '9d'],
            10.5,
            4.1,
            43.0,
            'K-high seco, turn blank relativa',
            'BTN tiene ventaja clara de Kx y overpairs.',
            'BTN tiene manos fuertes; BB tiene algunos Kx y pares bajos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♣ 2♥', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 9♦', 'BB checks', 'BTN bets 6 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'AQ sin par ni proyecto real no debe pagar segunda barrel. Los blockers no compensan la falta de equity y showdown value.',
            'GTO simplificado: A-high sin equity abandona mucho contra barrels en K-high.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 76, 'feedback' => 'Correcto. No defiendas aire por orgullo.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 34, 'feedback' => 'Call demasiado loose: pocas formas de ganar.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 12, 'feedback' => 'Farol caro sin equity ni buenos blockers al valor principal.'],
            ],
            'A-high no siempre es bluffcatcher; sin equity debe foldear muchas turns.',
            'En microlímites, foldea estos spots. El dinero se pierde pagando “a ver si farolea”.',
            78
        );
    }

    protected static function callTopPairWeakKickerVsSmallBarrel(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_q74r_q9_turn_2_call_small',
            'turn_defense',
            'Turn Defense',
            'turn_call_second_pair',
            'Top pair kicker débil vs apuesta pequeña',
            'BB vs BTN · Q9 en Q74r · Turn 2',
            'BB',
            'BTN',
            ['Qh', '9c'],
            ['Qs', '7d', '4c', '2h'],
            9.5,
            4.8,
            46.0,
            'Q-high seco, turn blank y sizing pequeño',
            'BTN puede apostar muchas Qx, pares medios y faroles baratos.',
            'BB tiene Qx defendidos, sets y pares medios.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♦ 4♣', 'BB checks', 'BTN bets 1.5 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Q9 no es una mano para inflar el bote, pero contra apuesta pequeña tiene precio suficiente. Foldear top pair aquí es demasiado tight.',
            'GTO simplificado: frente a sizings pequeños se defiende más ancho, incluso con top pair kicker medio/débil.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 82, 'feedback' => 'Correcto. Pagas por precio y mantienes faroles dentro.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 38, 'feedback' => 'Raise convierte una mano media en una mano demasiado grande.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 34, 'feedback' => 'Fold demasiado débil contra un sizing pequeño.'],
            ],
            'Top pair débil no siempre es fold; el tamaño de apuesta importa mucho.',
            'En NL2-NL10 paga apuestas pequeñas con top pair, pero no te cases si river viene grande.',
            82
        );
    }

    protected static function foldTopPairWeakKickerVsLargeBarrel(): array
    {
        return self::spot(
            'turn_defense_bb_vs_co_a83r_a5_turn_k_fold_large',
            'turn_defense',
            'Turn Defense',
            'turn_call_second_pair',
            'Top pair kicker débil vs barrel grande',
            'BB vs CO · A5 en A83r · Turn K',
            'BB',
            'CO',
            ['Ah', '5c'],
            ['As', '8d', '3c', 'Kh'],
            12.5,
            3.0,
            45.0,
            'A-high con K turn favorable al agresor',
            'CO tiene muchos Ax mejores, AK, AQ, sets y dobles.',
            'El K mejora mucho la parte fuerte del rango de CO.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: A♠ 8♦ 3♣', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: K♥', 'BB checks', 'CO bets 9 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'A5 parece top pair, pero contra barrel grande en K turn está dominada por demasiados Ax mejores. Sin proyecto ni buen kicker, continuar es caro.',
            'GTO simplificado: top pair kicker débil reduce mucha defensa frente a tamaños grandes en turns que favorecen al agresor.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 80, 'feedback' => 'Bien. Disciplina: top pair no significa pagar siempre.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 30, 'ev_score' => 42, 'feedback' => 'Call demasiado optimista contra rango fuerte y sizing grande.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 3, 'ev_score' => 12, 'feedback' => 'Raise sin valor ni fold equity real.'],
            ],
            'La fuerza relativa manda más que la fuerza absoluta.',
            'En microlímites, segundo barrel grande en A-high/K turn suele ser valor. Foldea Ax débil sin drama.',
            82
        );
    }

    protected static function callOverpairOnCoordinatedTurn(): array
    {
        return self::spot(
            'turn_defense_co_vs_bb_t86ss_aa_turn_2_call',
            'turn_defense',
            'Turn Defense',
            'turn_call_showdown_value',
            'Overpair en turn coordinado',
            'CO vs BB · AA en T86ss · Turn 2',
            'CO',
            'BB',
            ['Ah', 'Ac'],
            ['Ts', '8s', '6d', '2c'],
            14.0,
            3.4,
            50.0,
            'Board conectado con muchos proyectos',
            'BB tiene dobles, sets, escaleras y muchos draws.',
            'CO conserva overpairs fuertes; BB conecta mejor con la textura.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: T♠ 8♠ 6♦', 'BB checks', 'CO bets 3 BB', 'BB calls', 'Turn: 2♣', 'BB checks', 'CO bets 8 BB', 'BB raises', 'Action on Hero CO'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'AA sigue siendo fuerte, pero el raise de BB en textura dinámica representa valor y semi-bluffs. Call controla bote y permite evaluar river.',
            'GTO simplificado: overpair fuerte continúa, pero no necesita 3betear siempre ante raise turn en board favorable a BB.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 82, 'feedback' => 'Correcto. Continúas sin aislarte contra manos mejores.'],
                'RAISE' => ['grade' => 'marginal', 'frequency' => 22, 'ev_score' => 62, 'feedback' => 'Puede ser demasiado ambicioso; BB tiene muchas manos fuertes.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 36, 'feedback' => 'Fold demasiado débil con overpair premium.'],
            ],
            'Overpair fuerte no es fold automático en boards dinámicos, pero tampoco es all-in automático.',
            'En NL2-NL10 pagar suele ser mejor que stackearte sin lectura clara.',
            82
        );
    }

    protected static function callFlushDrawVsSeventyFivePot(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_k92ss_js_turn_5_call_fd',
            'turn_defense',
            'Turn Defense',
            'turn_call_strong_draw',
            'Proyecto de color vs apuesta 75%',
            'BB vs BTN · J9s en K92ss · Turn 5',
            'BB',
            'BTN',
            ['Js', '9s'],
            ['Ks', '9d', '2s', '5c'],
            12.5,
            3.7,
            48.0,
            'K-high con pareja + flush draw',
            'BTN apuesta fuerte con Kx, overpairs, draws y algunos bluffs.',
            'BB tiene pares, draws y algunas dobles/sets.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 9♦ 2♠', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 5♣', 'BB checks', 'BTN bets 7 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Pareja + flush draw tiene equity suficiente para pagar. Raise puede existir, pero en micro límites el call realiza equity y evita meterte contra rangos fuertes.',
            'GTO simplificado: combo draw con valor de showdown continúa contra sizing medio/grande.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 84, 'feedback' => 'Bien. Tienes outs al color y algo de showdown value.'],
                'RAISE' => ['grade' => 'good', 'frequency' => 20, 'ev_score' => 72, 'feedback' => 'Semi-bluff válido contra rivales capaces de foldear.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 30, 'feedback' => 'Fold demasiado tight con tanta equity.'],
            ],
            'Los draws con pareja tienen más valor que un draw desnudo.',
            'En microlímites paga y cobra cuando completes; no conviertas todos los draws en farol.',
            84
        );
    }

    protected static function foldGutshotWithoutImpliedOdds(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_a95r_qt_turn_2_fold_gutshot',
            'turn_defense',
            'Turn Defense',
            'turn_fold_no_equity',
            'Gutshot sin odds suficientes',
            'BB vs BTN · QT en A95r · Turn 2',
            'BB',
            'BTN',
            ['Qh', 'Tc'],
            ['As', '9d', '5c', '2h'],
            12.5,
            3.2,
            44.0,
            'A-high seco, turn blank',
            'BTN tiene muchos Ax y value claro.',
            'BB tiene algunas parejas y draws débiles, pero QT solo necesita una J.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 9♦ 5♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'BTN bets 8 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'QT solo tiene gutshot a la J y no siempre cobra cuando completa. Contra apuesta grande, el call no tiene odds suficientes.',
            'GTO simplificado: gutshots desnudos abandonan mucho frente a segunda barrel grande.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 78, 'feedback' => 'Correcto. No persigas cuatro outs caros.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 16, 'ev_score' => 32, 'feedback' => 'Call malo: pocas outs y poca recompensa.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 10, 'feedback' => 'Farol sin blockers suficientes al valor de Ax.'],
            ],
            'Un proyecto existe, pero no todos los proyectos se pagan.',
            'En NL2-NL10 este call quema dinero: foldea los gutshots caros sin implied odds.',
            80
        );
    }

    protected static function callOesdOvercardsVsBarrel(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_987r_qj_turn_2_call_oesd',
            'turn_defense',
            'Turn Defense',
            'turn_call_strong_draw',
            'OESD + overcards vs barrel',
            'BB vs BTN · QJ en 987r · Turn 2',
            'BB',
            'BTN',
            ['Qh', 'Jc'],
            ['9s', '8d', '7c', '2h'],
            13.5,
            3.5,
            46.0,
            'Board conectado con proyecto fuerte',
            'BTN puede seguir apostando overpairs, Tx, sets y bluffs.',
            'BB conecta mucho con esta textura y tiene muchas escaleras/proyectos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♠ 8♦ 7♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'BTN bets 7 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'QJ tiene OESD a T/6 y overcards ocasionales. Call realiza equity con buen precio; raise puede existir, pero no es obligatorio.',
            'GTO simplificado: proyectos abiertos con equity suficiente defienden contra segunda barrel razonable.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 80, 'feedback' => 'Correcto. Tienes equity real y buenos rivers.'],
                'RAISE' => ['grade' => 'good', 'frequency' => 26, 'ev_score' => 72, 'feedback' => 'Semi-bluff válido si el rival foldea overpairs o A-high.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 36, 'feedback' => 'Fold demasiado tight con OESD fuerte.'],
            ],
            'Los proyectos abiertos fuertes no deben foldearse por sistema.',
            'En micros paga cuando tienes outs claras; farolea solo si esperas folds reales.',
            80
        );
    }

    protected static function raiseTwoPairOnDangerousTurn(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_j96ss_j9_turn_7_raise',
            'turn_defense',
            'Turn Defense',
            'turn_two_pair_value',
            'Dobles parejas en board peligroso',
            'BB vs BTN · J9 en J96ss · Turn 7',
            'BB',
            'BTN',
            ['Jh', '9h'],
            ['Js', '9s', '6d', '7c'],
            13.5,
            3.2,
            46.0,
            'Board muy conectado con muchos draws',
            'BTN puede tener overpairs, Jx, draws de color y escalera.',
            'BB tiene dobles, sets y muchas escaleras/draws.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 9♠ 6♦', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 7♣', 'BB checks', 'BTN bets 8 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'RAISE',
            'Dobles son fuertes pero vulnerables. En una textura con tantos proyectos, subir cobra valor y niega equity a draws que pagarían mal.',
            'GTO simplificado: dobles vulnerables pueden check-raisear turn en boards dinámicos.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 88, 'feedback' => 'Excelente. Proteges y cobras a draws/manos peores.'],
                'CALL' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 78, 'feedback' => 'Call es viable, pero dejas demasiadas cartas malas river.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 4, 'feedback' => 'Fold imposible con dobles fuertes.'],
            ],
            'Manos fuertes vulnerables deben construir bote antes de que el river complique todo.',
            'En NL2-NL10 sube por valor; te pagan demasiados draws y top pair.',
            88
        );
    }

    protected static function callSetWhenFlushCompletes(): array
    {
        return self::spot(
            'turn_defense_bb_vs_co_q73ss_77_turn_ks_call',
            'turn_defense',
            'Turn Defense',
            'turn_set_value',
            'Set cuando se completa color',
            'BB vs CO · 77 en Q73ss · Turn K♠',
            'BB',
            'CO',
            ['7h', '7c'],
            ['Qs', '7s', '3d', 'Ks'],
            13.5,
            3.4,
            48.0,
            'Turn completa color y añade overcard',
            'CO tiene colores, KQ, AQ y barrels con blockers.',
            'BB tiene sets y algunos colores defendidos.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♠ 3♦', 'BB checks', 'CO bets 3 BB', 'BB calls', 'Turn: K♠', 'BB checks', 'CO bets 8 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Set medio sigue teniendo mucha equity por redraw a full, pero raisear cuando se completa color puede aislarte contra flushes. Call es sólido.',
            'GTO simplificado: sets con redraw a full continúan, pero mezclan más call cuando el draw principal se completa.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 84, 'feedback' => 'Correcto. No foldeas una mano fuerte y evitas aislarte.'],
                'RAISE' => ['grade' => 'good', 'frequency' => 20, 'ev_score' => 72, 'feedback' => 'Raise puede valer contra rivales que pagan KQ/AQ, pero es más arriesgado.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 8, 'feedback' => 'Fold demasiado débil con set y redraw a full.'],
            ],
            'Cuando se completa color, las manos fuertes sin color bajan de agresividad, no de valor absoluto.',
            'En micros paga y deja que el rival siga apostando; raise solo con lectura clara.',
            84
        );
    }

    protected static function foldPureBluffCatcherNoBlocker(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_a72ss_77_turn_q_fold',
            'turn_defense',
            'Turn Defense',
            'turn_fold_no_equity',
            'Bluffcatcher puro sin blocker',
            'BB vs BTN · 77 en A72ss · Turn Q',
            'BB',
            'BTN',
            ['7h', '7c'],
            ['As', '7s', '2d', 'Qh'],
            12.5,
            3.1,
            44.0,
            'A-high con Q turn favorable al agresor',
            'BTN tiene muchos Ax fuertes, AQ, QQ, sets y barrels de color.',
            'BB tiene algunos sets, pero 77 sin blocker relevante sufre mucho.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♠ 2♦', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: Q♥', 'BB checks', 'BTN bets 9 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'Aunque hay pareja, la mano no bloquea valor fuerte ni mejora bien. Contra barrel grande, es un bluffcatcher pobre.',
            'GTO simplificado: los bluffcatchers sin blockers buenos reducen defensa frente a apuestas grandes.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 78, 'feedback' => 'Bien. No todos los pares son bluffcatchers rentables.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 26, 'ev_score' => 40, 'feedback' => 'Call demasiado optimista contra sizing grande.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 12, 'feedback' => 'Raise sin blockers ni valor claro.'],
            ],
            'Para bluffcatchear necesitas algo más que una pareja: blockers, precio o lectura.',
            'En NL2-NL10 los barrels grandes suelen estar cargados de valor. Foldea bluffcatchers malos.',
            80
        );
    }

    protected static function foldTptkOnWorstRunout(): array
    {
        return self::spot(
            'turn_defense_co_vs_bb_ak_a98ss_turn_ts_fold',
            'turn_defense',
            'Turn Defense',
            'turn_fold_no_equity',
            'Fold disciplinado con TPTK en runout horrible',
            'CO vs BB · AK en A98ss · Turn T♠',
            'CO',
            'BB',
            ['Ah', 'Kc'],
            ['As', '9s', '8d', 'Ts'],
            14.0,
            2.9,
            52.0,
            'Turn completa color y muchas escaleras',
            'BB tiene colores, J7, QJ, dobles, sets y raises de valor.',
            'CO tiene TPTK, pero la textura favorece mucho a BB.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: A♠ 9♠ 8♦', 'BB checks', 'CO bets 3 BB', 'BB calls', 'Turn: T♠', 'BB checks', 'CO bets 8 BB', 'BB raises', 'Action on Hero CO'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'AK era fuerte en flop, pero este turn completa color y muchas escaleras. Frente a check-raise, TPTK sin pica ni redraw es fold disciplinado.',
            'GTO simplificado: top pair top kicker puede foldear ante agresión fuerte cuando el runout mejora masivamente al defensor.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 82, 'feedback' => 'Excelente fold. La textura destruyó el valor relativo de AK.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 30, 'ev_score' => 42, 'feedback' => 'Call caro contra un rango muy fuerte.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 8, 'feedback' => 'Meter más dinero aquí es quemar EV.'],
            ],
            'TPTK no es una mano invencible; en turns horribles puede ser fold.',
            'En microlímites, check-raise turn en carta que completa todo casi siempre es valor. Foldea sin ego.',
            84
        );
    }

}
