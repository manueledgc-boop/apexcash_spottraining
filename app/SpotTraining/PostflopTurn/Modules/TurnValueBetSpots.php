<?php

namespace App\SpotTraining\PostflopTurn\Modules;

use App\SpotTraining\PostflopTurn\Concerns\BuildsPostflopTurnSpots;

class TurnValueBetSpots
{
    use BuildsPostflopTurnSpots;

    public static function all(): array
    {
        return [
            self::valueTopPairGoodKickerBlankTurn(),
            self::valueOverpairWetTurn(),
            self::valueTwoPairVsCallingRange(),
            self::valueSetOnDrawHeavyTurn(),
            self::thinValueSecondPairAfterCheckBack(),
            self::valueTopPairVsStationSmallSize(),
            self::checkMediumShowdownValueBadTurn(),
            self::valueStraightCompletedTurn(),
            self::valueNutFlushTurn(),
            self::thinValueTopPairWeakKickerDryTurn(),
        ];
    }

    protected static function valueTopPairGoodKickerBlankTurn(): array
    {
        return self::spot(
            'turn_value_btn_vs_bb_k72r_kq_turn_4_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'top_pair_good_kicker_value',
            'Top pair buen kicker por valor',
            'BTN vs BB · KQ en K72r · Turn 4',
            'BTN',
            'BB',
            ['Kh', 'Qc'],
            ['Ks', '7d', '2c', '4h'],
            9.5,
            4.4,
            42.0,
            'K-high seco, turn blank',
            'BTN mantiene ventaja de rango y de overpairs/Kx fuertes.',
            'BTN tiene AK, KQ, AA; BB tiene Kx medios, 7x y pares bajos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♦ 2♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'KQ sigue muy por delante del rango de call flop de BB. El turn 4 no cambia nada, así que puedes apostar grande para cobrar a Kx peores, 7x tercos y floats con backdoors.',
            'GTO simplificado: en blank turns, top pair buen kicker mezcla tamaños medios y grandes; la línea de valor sigue apostando con frecuencia alta.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 88, 'feedback' => 'Correcto. Hay valor claro y el board no asusta a tu rango.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 78, 'feedback' => 'Bien, aunque pierdes algo de valor contra jugadores que pagan demasiado.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 14, 'ev_score' => 55, 'feedback' => 'Demasiado pasivo. Das carta gratis a manos peores y pierdes valor.'],
            ],
            'Cuando el turn es blank y tu top pair domina muchos calls peores, apostar turn es obligatorio en gran parte del rango.',
            'En NL2-NL10 apuesta por valor. Muchos pagan con cualquier Kx, 7x y pocket pairs por curiosidad.',
            88
        );
    }

    protected static function valueOverpairWetTurn(): array
    {
        return self::spot(
            'turn_value_co_vs_bb_j85tt_aa_turn_9_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'overpair_wet_turn_value_protection',
            'Overpair en turn conectado',
            'CO vs BB · AA en J85tt · Turn 9',
            'CO',
            'BB',
            ['As', 'Ad'],
            ['Jh', '8h', '5c', '9d'],
            11.5,
            3.9,
            45.0,
            'Board conectado con proyectos de color y escalera',
            'CO tiene overpairs fuertes, pero BB conecta bastante con Jx, 98, T7, 76 y draws.',
            'BB gana ventaja de nuts en algunas escaleras; CO conserva overpairs y sets fuertes.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: J♥ 8♥ 5♣', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 9♦', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'AA sigue siendo valor, pero necesita protección. Hay demasiados draws y pares peores que pagan. Chequear entrega mucha equity gratis.',
            'GTO simplificado: en turns dinámicos, overpair fuerte suele apostar por valor/protección con tamaño medio-grande, aunque debe tener cuidado ante raises.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 84, 'feedback' => 'Correcto. Cobras a Jx, draws y pares + draw.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 36, 'ev_score' => 76, 'feedback' => 'Aceptable, pero das mejor precio a proyectos fuertes.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 42, 'feedback' => 'Demasiado débil. Este board necesita valor y protección.'],
            ],
            'Valor y protección se juntan cuando tu mano va por delante pero muchas rivers pueden matarte la acción o superarte.',
            'En microlímites no regales turn con overpair en boards cargados. Apuesta y foldea tranquilo ante raises enormes de perfiles pasivos.',
            84
        );
    }

    protected static function valueTwoPairVsCallingRange(): array
    {
        return self::spot(
            'turn_value_sb_vs_btn_q94r_q9_turn_2_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'two_pair_value',
            'Dobles parejas por valor',
            'SB vs BTN · Q9 en Q94r · Turn 2',
            'SB',
            'BTN',
            ['Qs', '9s'],
            ['Qh', '9d', '4c', '2h'],
            13.0,
            3.5,
            46.0,
            'Top two en board semi seco',
            'SB tiene ventaja de manos fuertes tras 3bet preflop; BTN conserva Qx y pares medios.',
            'SB tiene overpairs y sets; BTN tiene algunas dobles pero menos combos fuertes.',
            ['BTN opens 2.5 BB', 'SB 3bets 10 BB', 'BTN calls', 'Flop: Q♥ 9♦ 4♣', 'SB bets 4 BB', 'BTN calls', 'Turn: 2♥', 'Action on Hero SB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Top two quiere construir bote. BTN tiene muchas Qx, TT-JJ, 9x con backdoors y proyectos de corazones que pueden pagar turn.',
            'GTO simplificado: con dobles fuertes en bote 3bet, apostar turn maximiza valor contra top pair y pares medios.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 91, 'feedback' => 'Excelente. Construyes bote con una mano muy fuerte.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 80, 'feedback' => 'Bien, aunque podrías extraer más valor.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 38, 'feedback' => 'Pierdes valor claro. Esta mano quiere apostar.'],
            ],
            'Las dobles fuertes en turn rara vez quieren slowplay cuando todavía hay muchas manos peores que pagan.',
            'En NL2-NL10 no hagas slowplay por miedo. La gente paga Qx y pares medios mucho más de lo que debería.',
            91,
            'three_bet_pot',
            '3Bet Pot'
        );
    }

    protected static function valueSetOnDrawHeavyTurn(): array
    {
        return self::spot(
            'turn_value_btn_vs_bb_t76tt_77_turn_2_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'set_draw_heavy_value',
            'Set en board cargado',
            'BTN vs BB · 77 en T76tt · Turn 2',
            'BTN',
            'BB',
            ['7s', '7c'],
            ['Th', '7d', '6h', '2c'],
            10.5,
            4.2,
            44.0,
            'Board con proyectos de escalera y color',
            'BTN tiene overpairs y sets; BB conecta con pares + draw y proyectos fuertes.',
            'Ambos tienen nuts; BTN tiene set fuerte, BB tiene más 98/54 suited.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♥ 7♦ 6♥', 'BB checks', 'BTN bets 3.5 BB', 'BB calls', 'Turn: 2♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Set medio en este board debe apostar fuerte. Hay muchas manos peores que pagan: Tx, pares + draw, flush draws y straight draws.',
            'GTO simplificado: los sets apuestan con frecuencia muy alta en turns que no completan proyectos principales.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 74, 'ev_score' => 92, 'feedback' => 'Correcto. Cobras caro a draws y valor peor.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 24, 'ev_score' => 78, 'feedback' => 'Funciona, pero dejas demasiado barato a proyectos.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 18, 'feedback' => 'Slowplay muy malo en board tan dinámico.'],
            ],
            'En boards dinámicos, slowplay con set suele quemar valor y permite que proyectos realicen equity gratis.',
            'En microlímites apuesta grande tus sets. Te van a pagar proyectos, top pair y manos dominadas.',
            92
        );
    }

    protected static function thinValueSecondPairAfterCheckBack(): array
    {
        return self::spot(
            'turn_value_bb_vs_btn_a83r_8x_turn_2_bet50',
            'turn_value_bet',
            'Turn Value Bet',
            'thin_value_second_pair_probe',
            'Valor fino con segunda pareja',
            'BB vs BTN · 87 en A83r · Turn 2',
            'BB',
            'BTN',
            ['8s', '7c'],
            ['Ah', '8d', '3c', '2s'],
            5.5,
            8.0,
            44.0,
            'A-high seco después de check back flop',
            'BTN tiene ventaja preflop, pero su check back descarta muchos Ax fuertes.',
            'BB tiene más 8x y pares pequeños; BTN tiene Ax débiles y broadways.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♥ 8♦ 3♣', 'BB checks', 'BTN checks back', 'Turn: 2♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'Después del check back, segunda pareja puede apostar fino. Cobras a pocket pairs, 3x, floats y algunas manos con dos overcards.',
            'GTO simplificado: BB puede liderar turn con pares medios cuando el agresor muestra debilidad en flop.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 82, 'feedback' => 'Correcto. Tamaño suficiente para valor fino y protección.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 72, 'feedback' => 'Check es razonable, pero pierde valor contra manos peores.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 54, 'feedback' => 'Demasiado grande para valor fino. Te aíslas más.'],
            ],
            'El valor fino requiere tamaños que manos peores puedan pagar sin convertir tu mano en farol.',
            'En NL2-NL10 el tamaño medio funciona muy bien: pagan pockets y pares bajos demasiadas veces.',
            82
        );
    }

    protected static function valueTopPairVsStationSmallSize(): array
    {
        return self::spot(
            'turn_value_hj_vs_bb_q62r_qa_turn_9_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'top_pair_vs_station',
            'Top pair vs rival pagador',
            'HJ vs BB · AQ en Q62r · Turn 9',
            'HJ',
            'BB',
            ['Ah', 'Qc'],
            ['Qs', '6d', '2c', '9h'],
            9.0,
            4.8,
            43.0,
            'Q-high seco con turn bajo',
            'HJ tiene ventaja de rango fuerte y mejores Qx.',
            'HJ tiene AQ/KQ/overpairs; BB tiene Qx peores, 6x y floats.',
            ['HJ opens 2.5 BB', 'BB calls', 'Flop: Q♠ 6♦ 2♣', 'BB checks', 'HJ bets 3 BB', 'BB calls', 'Turn: 9♥', 'BB checks', 'Action on Hero HJ'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'AQ domina demasiadas Qx peores. Contra rivales que pagan de más, el tamaño grande imprime valor.',
            'GTO simplificado: top pair top kicker apuesta turn con frecuencia alta en runouts seguros.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 89, 'feedback' => 'Correcto. Extraes máximo valor de Qx peor.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 32, 'ev_score' => 79, 'feedback' => 'Bien, pero contra calling stations puedes cobrar más.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 40, 'feedback' => 'Pierdes valor claro contra Qx peores.'],
            ],
            'Cuando dominas la parte de top pair del rival, debes construir bote antes de que river corte la acción.',
            'En microlímites, si pagan flop con Qx, muchas veces pagan turn. No te quedes corto con manos dominantes.',
            89
        );
    }

    protected static function checkMediumShowdownValueBadTurn(): array
    {
        return self::spot(
            'turn_value_btn_vs_bb_qq_on_a72_turn_k_check',
            'turn_value_bet',
            'Turn Value Bet',
            'medium_showdown_bad_turn',
            'Valor medio en mala carta',
            'BTN vs BB · QQ en A72r · Turn K',
            'BTN',
            'BB',
            ['Qh', 'Qc'],
            ['As', '7d', '2c', 'Kh'],
            9.5,
            4.6,
            44.0,
            'A-high con K turn, mala carta para QQ',
            'BTN tiene ventaja preflop, pero su mano concreta pierde valor contra Ax/Kx.',
            'BTN tiene sets y dobles fuertes; BB tiene muchos Ax que no foldean.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♦ 2♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: K♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'QQ ya no es una apuesta clara por valor. Te pagan demasiados Ax y Kx, y foldean muchas manos peores. Check controla bote y realiza showdown value.',
            'GTO simplificado: las manos medias con showdown value bajan frecuencia de apuesta en cartas que fortalecen el rango de call rival.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 84, 'feedback' => 'Correcto. Controlas bote y proteges tu rango de check.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 22, 'ev_score' => 56, 'feedback' => 'Demasiado fino. Te pagan muchas manos mejores.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 35, 'feedback' => 'Grande sin valor claro. Conviertes QQ en farol malo.'],
            ],
            'No toda mano hecha debe apostar turn. Si pocas manos peores pagan, el valor bet no existe.',
            'En NL2-NL10 evita apostar por inercia. Si solo te paga Ax/Kx, check es mejor.',
            84
        );
    }

    protected static function valueStraightCompletedTurn(): array
    {
        return self::spot(
            'turn_value_bb_vs_btn_986r_t7_turn_5_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'made_straight_turn_value',
            'Escalera completada en turn',
            'BB vs BTN · T7 en 986r · Turn 5',
            'BB',
            'BTN',
            ['Ts', '7s'],
            ['9h', '8d', '6c', '5h'],
            7.5,
            5.7,
            43.0,
            'Board muy conectado, escalera completada',
            'BB tiene muchas defensas que conectan con este board; BTN tiene overpairs y pares altos.',
            'BB tiene ventaja de nuts con T7/74/77; BTN tiene sets y overpairs.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♥ 8♦ 6♣', 'BB checks', 'BTN checks back', 'Turn: 5♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Con escalera hecha y board dinámico debes apostar. BTN puede pagar con overpairs, 9x, sets, dobles y proyectos.',
            'GTO simplificado: cuando el defensor mejora a nuts en turn tras check back, liderar fuerte es estándar.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 93, 'feedback' => 'Correcto. Tu mano quiere construir bote ya.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 80, 'feedback' => 'Bien, pero podrías cobrar más a manos fuertes.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 34, 'feedback' => 'Slowplay innecesario. Hay demasiadas manos que pagan.'],
            ],
            'Cuando tienes ventaja de nuts en turn, el probe/value grande castiga rangos capados.',
            'En microlímites apuesta fuerte tus escaleras. Los rivales pagan con overpair y par + draw con demasiada frecuencia.',
            93
        );
    }

    protected static function valueNutFlushTurn(): array
    {
        return self::spot(
            'turn_value_btn_vs_bb_aqhh_j82hh_turn_4h_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'nut_flush_turn_value',
            'Color nuts en turn',
            'BTN vs BB · A♥Q♥ en J82hh · Turn 4♥',
            'BTN',
            'BB',
            ['Ah', 'Qh'],
            ['Jh', '8h', '2c', '4h'],
            10.0,
            4.3,
            43.0,
            'Color completado en turn',
            'BTN tiene muchos Ax suited y overpairs; BB tiene muchos suited defendidos.',
            'Ambos tienen colores, pero BTN tiene el nut flush con A♥Q♥.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♥ 8♥ 2♣', 'BB checks', 'BTN bets 3.5 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Con color nuts quieres cobrar a colores peores, Jx con corazón, sets y pares con redraw. Check pierde muchísimo valor.',
            'GTO simplificado: el nut flush apuesta con alta frecuencia, usando tamaños que construyen bote contra colores dominados.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 94, 'feedback' => 'Perfecto. Cobras a colores peores y manos con corazón.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 82, 'feedback' => 'Bien, aunque dejas dinero contra colores peores.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 20, 'feedback' => 'No slowplayees nuts cuando hay tantos segundos mejores que pagan.'],
            ],
            'Los nuts no siempre se esconden. Si hay muchas manos fuertes peores que pagan, apostar es superior.',
            'En NL2-NL10 apuesta fuerte colores nuts. Te pagan colores peores y top pair con corazón demasiado a menudo.',
            94
        );
    }

    protected static function thinValueTopPairWeakKickerDryTurn(): array
    {
        return self::spot(
            'turn_value_bb_vs_sb_k64r_k3_turn_2_bet50',
            'turn_value_bet',
            'Turn Value Bet',
            'top_pair_weak_kicker_thin_value',
            'Top pair kicker débil valor fino',
            'BB vs SB · K3 en K64r · Turn 2',
            'BB',
            'SB',
            ['Kh', '3h'],
            ['Ks', '6d', '4c', '2h'],
            6.0,
            7.2,
            43.0,
            'BvB K-high bajo y seco',
            'SB tiene ventaja preflop ligera; BB defiende muchas manos que conectan bajo.',
            'SB tiene mejores Kx; BB tiene dobles raras y pares bajos.',
            ['SB opens 3 BB', 'BB calls', 'Flop: K♠ 6♦ 4♣', 'SB checks', 'BB bets 2 BB', 'SB calls', 'Turn: 2♥', 'SB checks', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'K3 puede apostar fino por valor/protección, pero no quiere inflar demasiado el bote. Tamaño medio cobra a 6x, 4x, pocket pairs y algunos A-high tercos.',
            'GTO simplificado: top pair kicker débil mezcla check y apuesta pequeña/media; tamaño grande se usa menos.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 52, 'ev_score' => 80, 'feedback' => 'Correcto. Valor fino con tamaño razonable.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 44, 'ev_score' => 74, 'feedback' => 'Check es viable para controlar bote.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 12, 'ev_score' => 50, 'feedback' => 'Demasiado grande. Te pagan más Kx mejores que manos peores.'],
            ],
            'El tamaño debe ajustarse a la calidad del valor: cuanto más fino, más cuidado con apostar grande.',
            'En microlímites apuesta medio si el rival paga mucho, pero no conviertas top pair kicker malo en bote gigante.',
            80
        );
    }
}
