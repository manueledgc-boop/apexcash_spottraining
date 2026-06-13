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
        ];
    }

    protected static function callTopPairVsSecondBarrel(): array
    {
        return self::spot(
            'turn_defense_bb_vs_btn_k72r_kj_turn_4_call',
            'turn_defense',
            'Turn Defense',
            'top_pair_vs_second_barrel',
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
            'weak_pair_vs_broadway_barrel',
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
            'two_pair_raise_value',
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
            'nut_flush_draw_call',
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
            'weak_gutshot_no_odds',
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
            'second_pair_vs_small_bet',
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
            'set_raise_wet_turn',
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
            'top_pair_four_straight_fold',
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
            'overpair_vs_polar_bet',
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
            'ace_high_no_equity_fold',
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
}
