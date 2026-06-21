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
            self::valueOverpairProtectionVsDraws(),
            self::valueTripsOnPairedTurn(),
            self::thinValueTopPairVsPassiveCaller(),
            self::valueSetWhenFlushCompletes(),
            self::valueTwoPairOnScaryBroadway(),
            self::betFoldTopPairVsPassiveRaise(),
            self::smallValueSecondPairVsMissedCbet(),
            self::checkBackTopPairBadKickerOnFourLiner(),
            self::valueBigWithStraightVsStation(),
            self::valueOverpairInThreeBetPotBlankTurn(),
        ];
    }

    protected static function valueTopPairGoodKickerBlankTurn(): array
    {
        return self::spot(
            'turn_value_btn_vs_bb_k72r_kq_turn_4_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'turn_top_pair_value',
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
            'turn_overpair_value',
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
            'turn_two_pair_value',
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
            'turn_set_value',
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
            'turn_value_protection',
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
            'turn_top_pair_value',
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
            'turn_pot_control',
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
            'turn_straight_value',
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
            'turn_flush_value',
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
            'turn_top_pair_value',
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

    protected static function valueOverpairProtectionVsDraws(): array
    {
        return self::spot(
            'turn_value_btn_vs_bb_t74tt_kk_turn_2_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'turn_overpair_value',
            'Overpair por valor y protección',
            'BTN vs BB · KK en T74tt · Turn 2',
            'BTN',
            'BB',
            ['Kh', 'Kc'],
            ['Ts', '7s', '4d', '2h'],
            10.0,
            4.5,
            44.0,
            'Turn blank en board con proyectos',
            'BTN conserva overpairs fuertes y BB tiene muchos pares + draw.',
            'BTN tiene ventaja de overpairs; BB tiene más combos conectados y proyectos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 7♠ 4♦', 'BB checks', 'BTN bets 3.5 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'KK va claramente por delante de Tx, 7x, pares con proyecto y flush draws. El turn no completa nada, así que apostar grande cobra valor y niega equity.',
            'GTO simplificado: overpairs fuertes en turns blank de boards dinámicos siguen apostando a frecuencia alta con tamaño medio/grande.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 88, 'feedback' => 'Correcto. Cobras valor y proteges contra muchos proyectos.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 32, 'ev_score' => 78, 'feedback' => 'Bien, aunque das mejor precio a draws.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 42, 'feedback' => 'Demasiado pasivo. Dejas realizar equity gratis.'],
            ],
            'Cuando el turn no completa proyectos y tienes overpair fuerte, apuesta por valor/protección.',
            'En NL2-NL10 te pagan Tx, pares y proyectos. Apostar grande es mejor que regalar carta.',
            88
        );
    }

    protected static function valueTripsOnPairedTurn(): array
    {
        return self::spot(
            'turn_value_bb_vs_btn_q84_q_qt_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'turn_trips_value',
            'Trips por valor en turn emparejado',
            'BB vs BTN · QT en Q84r · Turn Q',
            'BB',
            'BTN',
            ['Qh', 'Tc'],
            ['Qs', '8d', '4c', 'Qd'],
            7.5,
            5.6,
            42.0,
            'Turn empareja top card',
            'BTN chequeó flop y su rango queda algo capado.',
            'BB tiene muchas Qx defendidas y ahora trips fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 8♦ 4♣', 'BB checks', 'BTN checks back', 'Turn: Q♦', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Trips con QT quiere construir bote contra 8x, pares, Ax curiosos y Qx peores. El check back del flop hace que muchos rivales paguen porque no creen tanta fuerza.',
            'GTO simplificado: cuando el defensor mejora fuerte tras check back, puede liderar turn con tamaño grande por valor.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 91, 'feedback' => 'Excelente. Hay valor claro y mano escondida.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 80, 'feedback' => 'Correcto, aunque puedes cobrar más.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 36, 'feedback' => 'Slowplay innecesario. Pierdes valor.'],
            ],
            'Trips ocultos después de check back deben apostar con frecuencia alta.',
            'En microlímites apuesta fuerte. Muchos no foldean pares medios ni Ax.',
            91
        );
    }

    protected static function thinValueTopPairVsPassiveCaller(): array
    {
        return self::spot(
            'turn_value_co_vs_bb_j62r_jt_turn_5_bet50',
            'turn_value_bet',
            'Turn Value Bet',
            'turn_top_pair_value',
            'Top pair valor fino vs pasivo',
            'CO vs BB · JT en J62r · Turn 5',
            'CO',
            'BB',
            ['Jh', 'Tc'],
            ['Js', '6d', '2c', '5h'],
            9.0,
            4.8,
            43.0,
            'Turn bajo que no cambia demasiado',
            'BB tiene Jx peores, 6x, pocket pairs y algunos floats.',
            'CO mantiene mejores Jx; BB tiene muchas manos medias que pagan una apuesta razonable.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: J♠ 6♦ 2♣', 'BB checks', 'CO bets 3 BB', 'BB calls', 'Turn: 5♥', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'JT tiene valor, pero no quiere inflar demasiado porque BB también tiene Jx mejores ocasionalmente. Medio bote cobra a peores sin aislarte tanto.',
            'GTO simplificado: top pair kicker medio mezcla apuesta pequeña/media y check; el tamaño grande baja frecuencia.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 56, 'ev_score' => 82, 'feedback' => 'Correcto. Valor fino con tamaño adecuado.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 72, 'feedback' => 'Check controla bote, pero pierdes valor contra pasivos.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 16, 'ev_score' => 56, 'feedback' => 'Algo grande para kicker medio.'],
            ],
            'El valor fino necesita tamaños pagables por manos peores.',
            'En NL2-NL10 apuesta medio contra pasivos: pagan demasiado con pares peores.',
            82
        );
    }

    protected static function valueSetWhenFlushCompletes(): array
    {
        return self::spot(
            'turn_value_btn_vs_bb_954hh_99_turn_2h_bet50',
            'turn_value_bet',
            'Turn Value Bet',
            'turn_set_value',
            'Set cuando completa color',
            'BTN vs BB · 99 en 954hh · Turn 2h',
            'BTN',
            'BB',
            ['9s', '9d'],
            ['9h', '5h', '4c', '2h'],
            10.5,
            4.1,
            45.0,
            'Turn completa color',
            'BB tiene muchos corazones defendidos, pero también pares, dobles y draws peores.',
            'BB tiene más flushes pequeños; BTN conserva sets y overpairs con corazón.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♥ 5♥ 4♣', 'BB checks', 'BTN bets 3.5 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'Set sigue teniendo mucho valor y redraw a full, pero el color completado exige tamaño más controlado. Apostar medio cobra a pares con corazón, dobles y proyectos peores.',
            'GTO simplificado: sets sin color en turn que completa flush suelen apostar a tamaño medio o mezclar check, no siempre polarizar grande.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 52, 'ev_score' => 84, 'feedback' => 'Bien. Sigues cobrando valor sin inflar demasiado.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 36, 'ev_score' => 76, 'feedback' => 'Check también protege tu rango y controla bote.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 14, 'ev_score' => 58, 'feedback' => 'Grande puede aislarte contra colores.'],
            ],
            'Cuando se completa color, el set no desaparece, pero el sizing debe ser más cuidadoso.',
            'En microlímites puedes apostar medio porque pagan con muchas manos peores, pero respeta raises fuertes.',
            84
        );
    }

    protected static function valueTwoPairOnScaryBroadway(): array
    {
        return self::spot(
            'turn_value_sb_vs_btn_aq7_k_aq_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'turn_two_pair_value',
            'Dobles en carta Broadway peligrosa',
            'SB vs BTN · AQ en AQ7 · Turn K',
            'SB',
            'BTN',
            ['As', 'Qd'],
            ['Ah', 'Qc', '7s', 'Kh'],
            14.0,
            3.3,
            46.0,
            'Turn K añade proyectos y manos dominadas',
            'BTN tiene muchos Ax, Qx, KQ, JT y pares con gutshot.',
            'SB tiene ventaja fuerte en bote 3bet con AK/AQ/AA/QQ.',
            ['BTN opens 2.5 BB', 'SB 3bets 10 BB', 'BTN calls', 'Flop: A♥ Q♣ 7♠', 'SB bets 4 BB', 'BTN calls', 'Turn: K♥', 'Action on Hero SB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'AQ sigue siendo valor enorme. El K puede asustar, pero también mejora muchas manos peores que pagan: AK, AJ, AT con gutshot, KQ y draws.',
            'GTO simplificado: dobles fuertes en bote 3bet siguen apostando por valor incluso en cartas que traen más conexión.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 90, 'feedback' => 'Correcto. Muchísimas manos peores continúan.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 80, 'feedback' => 'Bien, aunque el stack-pot permite presionar más.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 42, 'feedback' => 'Demasiado temeroso. Pierdes valor claro.'],
            ],
            'No confundas carta peligrosa con carta mala para apostar si tu mano sigue dominando el rango de call.',
            'En NL2-NL10 dobles fuertes en bote 3bet deben apostar. Pagan demasiados Ax y broadways.',
            90,
            'three_bet_pot',
            '3Bet Pot'
        );
    }

    protected static function betFoldTopPairVsPassiveRaise(): array
    {
        return self::spot(
            'turn_value_hj_vs_bb_k83r_ak_turn_6_bet50',
            'turn_value_bet',
            'Turn Value Bet',
            'turn_top_pair_value',
            'Bet/fold con top pair fuerte',
            'HJ vs BB · AK en K83r · Turn 6',
            'HJ',
            'BB',
            ['Ah', 'Kd'],
            ['Ks', '8d', '3c', '6h'],
            9.5,
            4.6,
            44.0,
            'Turn bajo semi blank',
            'BB tiene Kx peores y pares, pero sus raises en turn suelen ser muy fuertes.',
            'HJ domina top pair; BB tiene sets/dobles ocasionales.',
            ['HJ opens 2.5 BB', 'BB calls', 'Flop: K♠ 8♦ 3♣', 'BB checks', 'HJ bets 3 BB', 'BB calls', 'Turn: 6♥', 'BB checks', 'Action on Hero HJ'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'AK debe apostar por valor contra KQ, KJ, 8x y pares. Pero contra un check-raise grande de un rival pasivo, el plan explotativo suele ser bet/fold.',
            'GTO simplificado: TPTK apuesta turn con frecuencia alta en blank; frente a raise se evalúa rango y tamaño.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 86, 'feedback' => 'Correcto. Extraes valor sin crear un bote absurdo.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 78, 'feedback' => 'También válido contra calling stations.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 18, 'ev_score' => 58, 'feedback' => 'Pierdes valor contra muchos Kx peores.'],
            ],
            'Apostar por valor no significa casarte con la mano si recibes raise fuerte.',
            'En NL2-NL10 apuesta AK por valor, pero foldea tranquilo ante raise grande de pasivo.',
            86
        );
    }

    protected static function smallValueSecondPairVsMissedCbet(): array
    {
        return self::spot(
            'turn_value_bb_vs_co_q73r_7x_turn_2_bet50',
            'turn_value_bet',
            'Turn Value Bet',
            'turn_value_protection',
            'Valor pequeño con segunda pareja',
            'BB vs CO · 76 en Q73r · Turn 2',
            'BB',
            'CO',
            ['7h', '6h'],
            ['Qs', '7d', '3c', '2s'],
            5.5,
            8.0,
            45.0,
            'Flop check/check y turn bajo',
            'CO chequeó flop y queda con muchos A-high, pockets y aire con equity.',
            'BB tiene muchas parejas medias y puede apostar fino.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♦ 3♣', 'BB checks', 'CO checks back', 'Turn: 2♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'Segunda pareja puede apostar pequeño/medio por valor y protección. Cobras a 3x, pockets, A-high con backdoor y niegas equity a overcards.',
            'GTO simplificado: tras missed c-bet, BB lidera turn con parte de sus manos medias y valor fino.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 80, 'feedback' => 'Bien. Valor fino y protección.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 40, 'ev_score' => 72, 'feedback' => 'Check también realiza equity, pero deja cartas gratis.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 48, 'feedback' => 'Demasiado grande para segunda pareja.'],
            ],
            'Las manos medias pueden apostar por valor fino cuando el agresor pierde iniciativa.',
            'En microlímites apuesta medio: te pagan pockets y A-high más de la cuenta.',
            80
        );
    }

    protected static function checkBackTopPairBadKickerOnFourLiner(): array
    {
        return self::spot(
            'turn_value_btn_vs_bb_987_6_a9_check',
            'turn_value_bet',
            'Turn Value Bet',
            'turn_pot_control',
            'No value bet en four-liner',
            'BTN vs BB · A9 en 987 · Turn 6',
            'BTN',
            'BB',
            ['Ah', '9c'],
            ['9s', '8d', '7c', '6h'],
            9.0,
            4.8,
            44.0,
            'Turn completa muchas escaleras',
            'BB defiende muchas manos conectadas que mejoran en este turn.',
            'BB tiene ventaja de nuts con T9, T8, 65, 54; BTN conserva overpairs pero su 9x pierde valor.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♠ 8♦ 7♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 6♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'A9 ya no tiene value bet claro. Muchas manos mejores pagan o suben, y pocas peores pagan dos calles en este runout. Check realiza showdown value y evita desastre.',
            'GTO simplificado: top pair baja mucho su frecuencia de apuesta cuando el turn completa una four-liner favorable al defensor.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 82, 'feedback' => 'Correcto. Tu mano tiene showdown value pero no valor claro.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 42, 'feedback' => 'Te pagan demasiadas manos mejores.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 6, 'ev_score' => 18, 'feedback' => 'Apuesta grande sin valor. Muy mala en este runout.'],
            ],
            'No apuestes por inercia cuando el turn cambia totalmente la jerarquía de manos.',
            'En NL2-NL10 evita value bets suicidas en boards de cuatro cartas a escalera.',
            82
        );
    }

    protected static function valueBigWithStraightVsStation(): array
    {
        return self::spot(
            'turn_value_bb_vs_btn_t98_7_jq_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'turn_straight_value',
            'Escalera fuerte vs calling station',
            'BB vs BTN · QJ en T98 · Turn 7',
            'BB',
            'BTN',
            ['Qh', 'Jc'],
            ['Ts', '9d', '8c', '7h'],
            7.5,
            5.5,
            42.0,
            'Turn completa muchas manos fuertes',
            'BTN chequeó flop y puede tener overpairs, Tx, 9x y proyectos que pagan.',
            'BB tiene muchas escaleras y ventaja de nuts.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♦ 8♣', 'BB checks', 'BTN checks back', 'Turn: 7♥', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'QJ es escalera alta y quiere cobrar a cualquier Jx, 6x, dobles, sets, overpairs y pares tercos. El check pierde valor contra rivales que pagan demasiado.',
            'GTO simplificado: con nuts o casi nuts tras check back, el defensor lidera turn con tamaños grandes.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 94, 'feedback' => 'Perfecto. Mano enorme, apuesta grande.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 22, 'ev_score' => 82, 'feedback' => 'Bien, pero contra station deja dinero.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 20, 'feedback' => 'Slowplay malo. Hay demasiadas manos que pagan.'],
            ],
            'Las manos muy fuertes en turn deben construir bote antes de que river asuste o corte acción.',
            'En microlímites apuesta grande tus escaleras. Te pagan con manos dominadas muy a menudo.',
            94
        );
    }

    protected static function valueOverpairInThreeBetPotBlankTurn(): array
    {
        return self::spot(
            'turn_value_sb_vs_btn_q74r_kk_turn_2_bet75',
            'turn_value_bet',
            'Turn Value Bet',
            'turn_overpair_value',
            'Overpair en bote 3bet turn blank',
            'SB vs BTN · KK en Q74r · Turn 2',
            'SB',
            'BTN',
            ['Kh', 'Kc'],
            ['Qs', '7d', '4c', '2h'],
            18.0,
            2.5,
            38.0,
            'Bote 3bet, turn totalmente blank',
            'SB mantiene ventaja de rango y overpairs fuertes.',
            'BTN tiene Qx, JJ-TT, pares medios y floats; SB domina con KK.',
            ['BTN opens 2.5 BB', 'SB 3bets 10 BB', 'BTN calls', 'Flop: Q♠ 7♦ 4♣', 'SB bets 5 BB', 'BTN calls', 'Turn: 2♥', 'Action on Hero SB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'KK en bote 3bet sobre turn blank debe seguir apostando. Hay muchas Qx y pares medios que pagan, y el SPR permite preparar shove river.',
            'GTO simplificado: overpairs en botes 3bet sobre blanks continúan apostando por valor con alta frecuencia.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 90, 'feedback' => 'Correcto. Construyes bote con ventaja clara.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 80, 'feedback' => 'También correcto, aunque menos presión.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 38, 'feedback' => 'Pierdes valor en un spot muy favorable.'],
            ],
            'En botes 3bet, los overpairs fuertes deben pensar en construir bote por calles.',
            'En NL2-NL10 apuesta fuerte: BTN paga Qx y pockets demasiadas veces.',
            90,
            'three_bet_pot',
            '3Bet Pot'
        );
    }

}
