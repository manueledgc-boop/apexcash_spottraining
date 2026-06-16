<?php

namespace App\SpotTraining\PostflopRiver\Modules;

use App\SpotTraining\PostflopRiver\Concerns\BuildsPostflopRiverSpots;

class RiverThinValueSpots
{
    use BuildsPostflopRiverSpots;

    public static function all(): array
    {
        return [
            self::topPairKickerVsCapedRange(),
            self::secondPairVsMissedDraws(),
            self::overpairSmallRiverBet(),
            self::topTwoVsFourLiner(),
            self::aceHighFlushSmallValue(),
            self::blockBetMediumStrength(),
            self::thinValueVsStation(),
            self::checkBackTooThinVsAggro(),
            self::smallBetTripsKicker(),
            self::thinValueOnPairedRiver(),
            self::thinValueSecondPairVsCheckDown(),
            self::thinValueTopPairWeakKickerSmall(),
            self::thinValuePocketPairUnderTopCard(),
            self::thinValueAceHighOnPairedLowBoard(),
            self::thinValueThirdPairVsMissedDraws(),
            self::avoidThinValueIntoStrongRange(),
            self::thinValueBlockBetRiverOop(),
            self::thinValueOverpairOnScaryRiverSmall(),
            self::thinValueTripsWeakKickerSmall(),
            self::thinValueTopPairVsRecreational(),
        ];
    }

    protected static function topPairKickerVsCapedRange(): array
    {
        return self::spot(
            'river_thin_value_btn_vs_bb_kq_k72_4_9_bet33',
            'river_thin_value',
            'River Thin Value',
            'top_pair_good_kicker',
            'Top pair buen kicker vs rango capado',
            'BTN vs BB · KQ value fino river',
            'BTN',
            'BB',
            ['Kh', 'Qd'],
            ['Ks', '7c', '2d', '4h', '9s'],
            28.0,
            1.8,
            50.0,
            'River blank, muchos proyectos fallidos y Kx peores en BB',
            'BTN mantiene ventaja de rango tras apostar flop y check back turn.',
            'BTN tiene más Kx fuertes; BB llega capado con pares medios, 7x y Kx dominados.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♣ 2♦', 'BB checks', 'BTN bets 3.5 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'BTN checks back', 'River: 9♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'KQ gana a muchos Kx peores y pares que pueden pagar una apuesta pequeña. El tamaño grande se aísla demasiado contra mejores manos.',
            'GTO simplificado: cuando tienes ventaja pero tu mano no quiere jugar por stacks, la apuesta pequeña captura valor de la parte media del rango rival.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 84, 'feedback' => 'Correcto. Tamaño pequeño para cobrar a Kx peores y pares medios.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 61, 'feedback' => 'No es horrible, pero dejas dinero contra calls peores.'],
                'BET_66' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 44, 'feedback' => 'Demasiado grande. Vas a tirar manos peores y recibir calls mejores.'],
            ],
            'Thin value no significa apostar siempre; significa elegir un size que manos peores puedan pagar.',
            'En NL2-NL10 este spot imprime valor contra rivales que pagan cualquier Kx. No uses size grande sin lectura clara.',
            84
        );
    }

    protected static function secondPairVsMissedDraws(): array
    {
        return self::spot(
            'river_thin_value_co_vs_bb_a9_q94_t_2_bet33',
            'river_thin_value',
            'River Thin Value',
            'second_pair_vs_missed_draws',
            'Segundo par vs draws fallidos',
            'CO vs BB · A9 cobra fino en river blank',
            'CO',
            'BB',
            ['Ah', '9h'],
            ['Qh', '9c', '4h', 'Ts', '2d'],
            24.0,
            2.2,
            53.0,
            'River blank tras muchos proyectos fallidos',
            'CO tiene ventaja moderada, pero BB conserva Qx y algunas dobles.',
            'Nuts bastante repartidos; Hero no quiere polarizar.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: Q♥ 9♣ 4♥', 'BB checks', 'CO bets 3 BB', 'BB calls', 'Turn: T♠', 'BB checks', 'CO checks back', 'River: 2♦', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_33', 'BET_75'],
            'BET_33',
            'A9 puede recibir calls de 9x peores, 4x curioso y A-high que no cree. El check es seguro pero pierde valor contra jugadores pasivos.',
            'GTO simplificado: las manos medias que desbloquean folds y bloquean calls no deben sobredimensionar; buscan una apuesta pequeña.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 48, 'ev_score' => 78, 'feedback' => 'Bien. Value fino con size que induce calls peores.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 69, 'feedback' => 'Aceptable, sobre todo contra rivales agresivos que pueden check-raise bluff.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 7, 'ev_score' => 24, 'feedback' => 'Muy grande para segundo par. Te aíslas contra Qx y mejores 9x.'],
            ],
            'La diferencia entre thin value y value claro es que el tamaño importa más que la fuerza absoluta de tu mano.',
            'Contra recreacionales pasivos, apuesta pequeño. Contra reg agresivo capaz de check-raise, check back más a menudo.',
            77
        );
    }

    protected static function overpairSmallRiverBet(): array
    {
        return self::spot(
            'river_thin_value_hj_vs_bb_jj_t72_4_8_bet50',
            'river_thin_value',
            'River Thin Value',
            'overpair_controlled_value',
            'Overpair con value controlado',
            'HJ vs BB · JJ en board bajo river',
            'HJ',
            'BB',
            ['Jd', 'Jh'],
            ['Ts', '7d', '2c', '4s', '8h'],
            32.0,
            1.5,
            48.0,
            'River bajo que completa algunas escaleras, pero deja muchos Tx y 7x',
            'HJ mantiene overpairs; BB tiene más 86/65 pero también muchos pares peores.',
            'Nuts algo más en BB, pero rango de value medio fuerte en HJ.',
            ['HJ opens 2.5 BB', 'BB calls', 'Flop: T♠ 7♦ 2♣', 'BB checks', 'HJ bets 4 BB', 'BB calls', 'Turn: 4♠', 'BB checks', 'HJ bets 9 BB', 'BB calls', 'River: 8♥', 'BB checks', 'Action on Hero HJ'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'JJ todavía cobra de Tx, 99, 7x fuertes y bluff-catchers. Pero no quiere overbetear porque el river mejora parte del rango de BB.',
            'GTO simplificado: en rivers que mejoran algo al caller, las overpairs pueden seguir apostando pero con tamaño contenido.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 52, 'ev_score' => 80, 'feedback' => 'Correcto. Value razonable sin convertir la mano en bluff.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 63, 'feedback' => 'Demasiado conservador contra rivales que pagan Tx.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 45, 'feedback' => 'Size alto castiga tu mano contra straights y dobles.'],
            ],
            'La overpair no siempre es value grueso en river; mira qué cambió la última carta.',
            'En microlímites el bet medio funciona muy bien porque pagan top pair. Si recibes raise grande, casi siempre estás muerto.',
            80
        );
    }

    protected static function topTwoVsFourLiner(): array
    {
        return self::spot(
            'river_thin_value_btn_vs_bb_kj_kjt_q_2_check',
            'river_thin_value',
            'River Thin Value',
            'too_thin_four_liner',
            'Dobles en textura peligrosa',
            'BTN vs BB · KJ en KJTQ2',
            'BTN',
            'BB',
            ['Kd', 'Jc'],
            ['Ks', 'Jh', 'Tc', 'Qd', '2s'],
            36.0,
            1.4,
            50.0,
            'Board muy conectado con cuatro cartas a escalera',
            'BTN conserva manos fuertes, pero BB tiene muchos Ax y 9x defendidos.',
            'Nut advantage muy sensible: BB puede tener muchas escaleras.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ J♥ T♣', 'BB checks', 'BTN bets 4 BB', 'BB calls', 'Turn: Q♦', 'BB checks', 'BTN checks back', 'River: 2♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_75'],
            'CHECK',
            'Aunque KJ parece fuerte, el board hace que muchas manos peores no paguen y muchas mejores sí. El value es demasiado fino sin lectura de station.',
            'GTO simplificado: si tu apuesta solo recibe calls de manos mejores y foldea manos peores, no es value; es quemar EV.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 79, 'feedback' => 'Correcto. Showdown value alto, pero apuesta vulnerable.'],
                'BET_33' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 58, 'feedback' => 'Solo vale contra rivales muy pagadores con Kx/Qx.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 6, 'ev_score' => 18, 'feedback' => 'Muy mal. Te aíslas contra escalera.'],
            ],
            'Thin value exige que existan suficientes manos peores que paguen. Aquí no hay tantas.',
            'En NL2-NL10 puedes betear pequeño solo contra calling station extrema. Contra desconocido, check back.',
            76
        );
    }

    protected static function aceHighFlushSmallValue(): array
    {
        return self::spot(
            'river_thin_value_sb_vs_btn_ahjh_flush_bet50',
            'river_thin_value',
            'River Thin Value',
            'non_nut_flush_value',
            'Color alto sin nuts absolutas',
            'SB vs BTN · A-high flush en river',
            'SB',
            'BTN',
            ['Ah', 'Jh'],
            ['Kh', '7h', '3c', '2h', '9d'],
            30.0,
            1.7,
            52.0,
            'Color completado en turn, river blank',
            'SB tiene muchos colores fuertes tras 3bet preflop; BTN tiene calls medios.',
            'SB tiene ventaja de nuts aunque algunos sets y flushes menores existen en BTN.',
            ['BTN opens 2.5 BB', 'SB 3bets 10 BB', 'BTN calls', 'Flop: K♥ 7♥ 3♣', 'SB bets 7 BB', 'BTN calls', 'Turn: 2♥', 'SB checks', 'BTN checks', 'River: 9♦', 'Action on Hero SB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'A♥J♥ puede cobrar de Kx con corazón, sets lentos y colores peores. El tamaño medio permite calls peores sin espantar todo.',
            'GTO simplificado: una mano fuerte pero no invulnerable suele preferir value medio frente a rangos con bluff-catchers.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 83, 'feedback' => 'Correcto. Value claro pero controlado.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 26, 'ev_score' => 72, 'feedback' => 'Puede ser bueno contra calling stations, pero no estándar.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 40, 'feedback' => 'Pierdes demasiado valor contra manos peores.'],
            ],
            'No confundas miedo a un cooler con razón para dejar de valuebetear.',
            'En microlímites apuesta. Te pagan Kx, sets y colores peores más de lo que deberían.',
            85
        );
    }

    protected static function blockBetMediumStrength(): array
    {
        return self::spot(
            'river_thin_value_bb_vs_btn_qt_q72_6_a_block',
            'river_thin_value',
            'River Thin Value',
            'block_bet_medium_pair',
            'Block bet con top pair medio',
            'BB vs BTN · QT lidera pequeño river A',
            'BB',
            'BTN',
            ['Qs', 'Td'],
            ['Qh', '7s', '2c', '6d', 'Ac'],
            22.0,
            2.5,
            55.0,
            'River A cambia ventaja de rango, pero Hero aún gana a pares peores',
            'BTN tiene más Ax; BB tiene Qx y manos medias.',
            'BTN mejora en nut advantage por Ax fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♥ 7♠ 2♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 6♦', 'BB checks', 'BTN checks back', 'River: A♣', 'Action on Hero BB'],
            ['CHECK', 'BET_33', 'BET_75'],
            'BET_33',
            'La apuesta pequeña bloquea el precio, cobra de Qx peores/7x curioso y evita enfrentar apuesta grande demasiado a menudo.',
            'GTO simplificado: los block bets aparecen cuando tu mano quiere showdown barato y aún obtiene calls peores.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 50, 'ev_score' => 77, 'feedback' => 'Buena línea. Value fino y control del bote.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 68, 'feedback' => 'Correcto contra rivales que farolean poco o apuestan mal.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 19, 'feedback' => 'No tiene sentido polarizar con QT en river A.'],
            ],
            'Block bet no es miedo; es una apuesta diseñada para cobrar fino y controlar la respuesta rival.',
            'En NL2-NL10 el block bet funciona porque muchos rivales pagan pequeño y suben grande solo con manos muy fuertes.',
            78
        );
    }

    protected static function thinValueVsStation(): array
    {
        return self::spot(
            'river_thin_value_co_vs_sb_at_a86_3_j_bet66',
            'river_thin_value',
            'River Thin Value',
            'exploit_station_value',
            'Value fino explotativo vs station',
            'CO vs SB · AT cobra grande vs recreacional',
            'CO',
            'SB',
            ['Ac', 'Td'],
            ['Ah', '8d', '6s', '3c', 'Jd'],
            26.0,
            2.0,
            52.0,
            'River J no completa demasiado y recreacional paga pares',
            'CO tiene ventaja de Ax; SB llega con Ax peores, 8x y pares medios.',
            'CO tiene más top pairs fuertes.',
            ['CO opens 2.5 BB', 'SB calls', 'Flop: A♥ 8♦ 6♠', 'SB checks', 'CO bets 3.5 BB', 'SB calls', 'Turn: 3♣', 'SB checks', 'CO checks back', 'River: J♦', 'SB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_66',
            'Contra un rival calling station, AT puede cobrar de muchos Ax peores y pares que no deberían pagar. Aquí el exploit sube el tamaño.',
            'GTO simplificado: sin lectura, el tamaño pequeño es más estándar; con lectura de station, el EV aumenta apostando más grande por valor.',
            [
                'BET_66' => ['grade' => 'best', 'frequency' => 46, 'ev_score' => 82, 'feedback' => 'Correcto explotativo. Castigas calls demasiado amplios.'],
                'BET_33' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 74, 'feedback' => 'Bien estándar, pero pierdes valor contra station.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 35, 'feedback' => 'Muy pasivo contra rival que paga peor.'],
            ],
            'El solver piensa contra un rival equilibrado. En microlímites, si pagan de más, apuesta más por valor.',
            'Este es exactamente el tipo de ajuste NL2-NL10: menos faroles y más value fino contra jugadores que no foldean.',
            82
        );
    }

    protected static function checkBackTooThinVsAggro(): array
    {
        return self::spot(
            'river_thin_value_btn_vs_bb_99_j74_q_k_check',
            'river_thin_value',
            'River Thin Value',
            'showdown_value_not_bet',
            'Showdown value, no value bet',
            'BTN vs BB · 99 no debe thin value river',
            'BTN',
            'BB',
            ['9c', '9d'],
            ['Js', '7d', '4c', 'Qh', 'Ks'],
            25.0,
            2.1,
            52.0,
            'Runout alto que empeora pares medios',
            'BTN tiene ventaja de rango, pero 99 cae mucho en valor relativo.',
            'BTN tiene nuts, pero 99 no pertenece al rango de value.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 7♦ 4♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: Q♥', 'BB checks', 'BTN checks back', 'River: K♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            '99 tiene showdown value pero muy pocas manos peores pagan. Apostar transforma una mano media en bluff malo.',
            'GTO simplificado: no todas las manos que ganan a veces deben apostar. Algunas solo quieren llegar al showdown.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 81, 'feedback' => 'Correcto. Toma showdown y evita value own.'],
                'BET_33' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 37, 'feedback' => 'Apuesta demasiado fina; casi nada peor paga.'],
                'BET_66' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 12, 'feedback' => 'Error claro. No representas value con esta mano.'],
            ],
            'Thin value se vuelve error cuando tu rival solo continúa con manos mejores.',
            'En límites bajos muchos jugadores pagan, sí, pero no con cualquier cosa en runouts KQJ. No fuerces value inexistente.',
            79
        );
    }

    protected static function smallBetTripsKicker(): array
    {
        return self::spot(
            'river_thin_value_bb_vs_sb_q8_884_2_k_bet50',
            'river_thin_value',
            'River Thin Value',
            'trips_kicker_value',
            'Trips con kicker medio',
            'BB vs SB · Q8 en board emparejado',
            'BB',
            'SB',
            ['Qd', '8d'],
            ['8s', '8c', '4h', '2d', 'Ks'],
            20.0,
            2.6,
            52.0,
            'Board trips, river K mejora faroles de SB pero no cambia muchos 8x',
            'BB tiene más 8x defendidos; SB tiene overpairs y Kx.',
            'BB tiene ventaja de nuts por más combinaciones de 8x.',
            ['SB opens 3 BB', 'BB calls', 'Flop: 8♠ 8♣ 4♥', 'SB bets 2 BB', 'BB calls', 'Turn: 2♦', 'SB checks', 'BB checks back', 'River: K♠', 'SB checks', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'Q8 es value, pero no necesita tamaño enorme: cobra de Kx, pares y 8x peores. El size medio mantiene dentro manos peores.',
            'GTO simplificado: con trips no-nuts, value medio es superior a polarizar si el rival tiene algunos full houses.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 84, 'feedback' => 'Correcto. Value sólido sin espantar calls.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 24, 'ev_score' => 72, 'feedback' => 'Puede ser bueno contra SB pagador, pero no obligatorio.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 39, 'feedback' => 'Demasiado pasivo. Hay muchas manos peores que pagan.'],
            ],
            'Value fino no significa mano débil; significa que el rango rival tiene mejores manos suficientes para cuidar el size.',
            'En microlímites apuesta siempre aquí. Muchos pagan Kx por curiosidad.',
            83
        );
    }

    protected static function thinValueOnPairedRiver(): array
    {
        return self::spot(
            'river_thin_value_hj_vs_bb_ak_a72_7_3_bet33',
            'river_thin_value',
            'River Thin Value',
            'paired_river_top_pair',
            'Top pair en river emparejado',
            'HJ vs BB · AK apuesta pequeño en A7273',
            'HJ',
            'BB',
            ['As', 'Kh'],
            ['Ac', '7d', '2s', '7c', '3h'],
            29.0,
            1.9,
            55.0,
            'River blank tras turn paired, Hero bloquea top pair fuerte',
            'HJ tiene muchos Ax fuertes; BB tiene 7x pero también Ax peores y pares.',
            'BB tiene algunos trips, HJ conserva ventaja de Ax premium.',
            ['HJ opens 2.5 BB', 'BB calls', 'Flop: A♣ 7♦ 2♠', 'BB checks', 'HJ bets 3 BB', 'BB calls', 'Turn: 7♣', 'BB checks', 'HJ checks back', 'River: 3♥', 'BB checks', 'Action on Hero HJ'],
            ['CHECK', 'BET_33', 'BET_75'],
            'BET_33',
            'AK todavía gana a muchos Ax peores y puede apostar pequeño. El size grande se estrella demasiado contra 7x.',
            'GTO simplificado: en boards emparejados, top pair top kicker suele buscar value pequeño/medio, no polarización grande.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 85, 'feedback' => 'Correcto. Cobras de Ax peor sin aislarte.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 22, 'ev_score' => 60, 'feedback' => 'Demasiado prudente salvo contra rival tricky.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 42, 'feedback' => 'Grande de más. Foldeas Ax peor y te pagan trips.'],
            ],
            'El river emparejado reduce el techo de tu mano, no elimina su valor.',
            'En NL2-NL10 apuesta pequeño: los Ax peores pagan muchísimo, pero un raise suele ser trips o mejor.',
            85
        );
    }

    protected static function thinValueSecondPairVsCheckDown(): array
    {
        return self::spot(
            'river_thin_value_btn_vs_bb_88_k82_4_3_bet33',
            'river_thin_value',
            'River Thin Value',
            'second_pair_vs_checkdown',
            'Segunda pareja tras línea pasiva',
            'BTN vs BB · 88 en K8243',
            'BTN',
            'BB',
            ['8h', '8c'],
            ['Ks', '8d', '2c', '4h', '3s'],
            16.0,
            3.0,
            58.0,
            'River bajo tras turn check/check',
            'BTN tiene algunas Kx y pares medios; BB llega con muchos pares peores y A-high.',
            'BB está capado después de no apostar turn ni river.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 8♦ 2♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'BTN checks back', 'River: 3♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_75'],
            'BET_33',
            '88 ahora es set y cobra valor de Kx, 8x peores y pares curiosos. El tamaño pequeño mantiene dentro manos peores.',
            'GTO simplificado: manos fuertes pero no polarizadas pueden apostar pequeño contra rangos capados.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 86, 'feedback' => 'Correcto. Tamaño pequeño cobra de muchas manos peores.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 78, 'feedback' => 'También puede valer contra rivales muy pagadores.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 34, 'feedback' => 'Check pierde valor claro.'],
            ],
            'Thin value no significa mano débil; significa elegir el tamaño que recibe calls peores.',
            'En NL2-NL10, apuesta pequeño cuando quieres que te paguen manos marginales.',
            86
        );
    }

    protected static function thinValueTopPairWeakKickerSmall(): array
    {
        return self::spot(
            'river_thin_value_co_vs_bb_qt_q73_2_6_bet33',
            'river_thin_value',
            'River Thin Value',
            'top_pair_weak_kicker_small',
            'Top pair kicker medio apuesta pequeño',
            'CO vs BB · QT en Q7326',
            'CO',
            'BB',
            ['Qh', 'Tc'],
            ['Qs', '7d', '3c', '2h', '6s'],
            22.0,
            2.2,
            52.0,
            'River blank sin proyectos completados',
            'CO tiene Qx; BB tiene Qx peores, 7x y pares medios.',
            'QT gana a suficientes manos peores, pero no quiere inflar demasiado.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♦ 3♣', 'BB checks', 'CO bets 3 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'CO checks back', 'River: 6♠', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_33', 'BET_75'],
            'BET_33',
            'QT puede cobrar una apuesta pequeña de Qx peor, 7x y pares curiosos. Apostar grande convierte la mano en una apuesta demasiado fina.',
            'GTO simplificado: top pair kicker medio usa tamaños pequeños contra rangos capados.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 79, 'feedback' => 'Bien. Sacas valor sin aislarte contra Qx mejores.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 68, 'feedback' => 'Check es aceptable, pero dejas valor contra jugadores pagadores.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 32, 'feedback' => 'Demasiado grande para kicker medio.'],
            ],
            'El thin value exige tamaño coherente: pequeño para cobrar manos peores.',
            'En microlímites la gente paga 7x y pares medios ante sizes pequeños.',
            79
        );
    }

    protected static function thinValuePocketPairUnderTopCard(): array
    {
        return self::spot(
            'river_thin_value_btn_vs_bb_tt_a84_2_5_check',
            'river_thin_value',
            'River Thin Value',
            'pocket_pair_under_top_card',
            'No value con par medio bajo As',
            'BTN vs BB · TT en A8425',
            'BTN',
            'BB',
            ['Th', 'Tc'],
            ['As', '8d', '4c', '2h', '5s'],
            24.0,
            2.0,
            52.0,
            'River bajo pero board A-high',
            'BTN tiene Ax fuertes; BB tiene Ax, 8x y pares medios.',
            'TT tiene showdown value, pero pocas peores pagan una apuesta.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 8♦ 4♣', 'BB checks', 'BTN checks back', 'Turn: 2♥', 'BB checks', 'BTN bets 5 BB', 'BB calls', 'River: 5♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_75'],
            'CHECK',
            'TT gana a algunos pares peores, pero si apuestas te pagan demasiados Ax y 8x fuertes. Es mejor tomar showdown.',
            'GTO simplificado: manos medias con showdown value que no reciben suficientes calls peores prefieren check back.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 76, 'feedback' => 'Correcto. Realizas showdown value sin convertirte en value cut.'],
                'BET_33' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 54, 'feedback' => 'Muy fino; solo contra calling stations que pagan pares peores.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 3, 'ev_score' => 10, 'feedback' => 'Grande es pésimo: solo te pagan mejores.'],
            ],
            'Thin value no es apostar cualquier mano media; debe haber peores que paguen.',
            'En NL2-NL10 evita valuecutearte contra rangos llenos de Ax.',
            76
        );
    }

    protected static function thinValueAceHighOnPairedLowBoard(): array
    {
        return self::spot(
            'river_thin_value_bb_vs_sb_aq_662_9_3_bet33',
            'river_thin_value',
            'River Thin Value',
            'ace_high_paired_low_board',
            'A-high como value muy fino',
            'BB vs SB · AQ en 66293',
            'BB',
            'SB',
            ['Ah', 'Qd'],
            ['6s', '6d', '2c', '9h', '3s'],
            13.0,
            4.0,
            55.0,
            'River bajo tras doble check',
            'BB tiene algunos 6x, pares y A-high fuertes.',
            'SB puede pagar demasiado con K-high, Q-high y pares pequeños.',
            ['SB opens 3 BB', 'BB calls', 'Flop: 6♠ 6♦ 2♣', 'SB checks', 'BB checks back', 'Turn: 9♥', 'SB checks', 'BB checks back', 'River: 3♠', 'SB checks', 'Action on Hero BB'],
            ['CHECK', 'BET_33', 'BET_75'],
            'BET_33',
            'AQ high puede apostar muy pequeño contra un rival que paga demasiado con peores A-high/K-high o foldea equity. Es un thin value/bluff híbrido.',
            'GTO simplificado: en líneas muy capadas, algunos A-high fuertes pueden usar size pequeño con EV marginal.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 36, 'ev_score' => 68, 'feedback' => 'Bien como thin value explotativo contra rangos débiles.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 60, 'ev_score' => 66, 'feedback' => 'Check también es muy razonable; realizas showdown.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 4, 'ev_score' => 20, 'feedback' => 'Grande no tiene sentido con A-high.'],
            ],
            'Algunos thin values son muy marginales y dependen del rival.',
            'En microlímites solo haz esto contra rivales que pagan/foldéan mal ante tamaños pequeños.',
            68
        );
    }

    protected static function thinValueThirdPairVsMissedDraws(): array
    {
        return self::spot(
            'river_thin_value_btn_vs_bb_77_j72_9_4_bet33',
            'river_thin_value',
            'River Thin Value',
            'third_pair_vs_missed_draws',
            'Tercera pareja vs proyectos fallidos',
            'BTN vs BB · 77 en J7294',
            'BTN',
            'BB',
            ['7h', '7c'],
            ['Js', '7d', '2s', '9h', '4c'],
            20.0,
            2.5,
            54.0,
            'River blank con draws fallidos',
            'BTN tiene manos fuertes y pares medios; BB tiene Jx, 7x peores y missed spades.',
            'Hero tiene set y puede cobrar pequeño a Jx y pares tercos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 7♦ 2♠', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 9♥', 'BB checks', 'BTN checks back', 'River: 4♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_75'],
            'BET_33',
            'Aunque la línea de turn fue pasiva, Hero tiene set y puede sacar valor pequeño de Jx y bluff catchers. El tamaño pequeño maximiza calls peores.',
            'GTO simplificado: cuando el rival está capado y los draws fallan, manos fuertes pueden apostar pequeño para recibir calls amplios.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 84, 'feedback' => 'Correcto. El size pequeño captura calls ligeros.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 78, 'feedback' => 'Grande también sirve contra stations, pero puede tirar Jx débil.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 30, 'feedback' => 'Check pierde valor con una mano demasiado fuerte.'],
            ],
            'El tamaño pequeño no significa debilidad; puede ser la mejor forma de cobrar thin value.',
            'En NL2-NL10 usa pequeño cuando quieres que Jx y pares curiosos paguen.',
            84
        );
    }

    protected static function avoidThinValueIntoStrongRange(): array
    {
        return self::spot(
            'river_thin_value_co_vs_bb_kq_k98_t_j_check',
            'river_thin_value',
            'River Thin Value',
            'avoid_value_into_strong_range',
            'Evitar value cut en runout malo',
            'CO vs BB · KQ en K98-T-J',
            'CO',
            'BB',
            ['Kh', 'Qd'],
            ['Ks', '9d', '8c', 'Th', 'Js'],
            36.0,
            1.3,
            45.0,
            'River completa muchas escaleras',
            'BB tiene muchas manos conectadas: Qx, 7x y dobles.',
            'KQ ya no domina suficiente rango de call.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: K♠ 9♦ 8♣', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: T♥', 'BB checks', 'CO checks back', 'River: J♠', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_33', 'BET_75'],
            'CHECK',
            'KQ parece top pair fuerte, pero el river J completa muchas escaleras y dobles. Apostar fino aquí se convierte en value cut.',
            'GTO simplificado: cuando el runout mejora mucho al rango defensor, muchas top pairs pasan a check back.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 78, 'feedback' => 'Correcto. Tomas showdown y evitas aislarte contra mejores.'],
                'BET_33' => ['grade' => 'marginal', 'frequency' => 22, 'ev_score' => 50, 'feedback' => 'Muy fino; necesitas rival extremadamente calling station.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 3, 'ev_score' => 8, 'feedback' => 'Grande es un value cut claro.'],
            ],
            'El thin value muere cuando casi no hay peores que paguen.',
            'En micros, aunque paguen mucho, no apuestes top pair en runouts que completan todo.',
            78
        );
    }

    protected static function thinValueBlockBetRiverOop(): array
    {
        return self::spot(
            'river_thin_value_bb_vs_btn_q9_q84_2_6_bet33',
            'river_thin_value',
            'River Thin Value',
            'block_bet_oop_top_pair',
            'Block bet OOP con top pair',
            'BB vs BTN · Q9 en Q8426',
            'BB',
            'BTN',
            ['Qh', '9h'],
            ['Qs', '8d', '4c', '2s', '6d'],
            18.0,
            3.0,
            50.0,
            'River blank estando fuera de posición',
            'BB tiene Qx y pares; BTN chequeó turn y está capado.',
            'BTN puede pagar pequeño con 8x, pares medios y Qx peores.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 8♦ 4♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♠', 'BB checks', 'BTN checks back', 'River: 6♦', 'Action on Hero BB'],
            ['CHECK', 'BET_33', 'BET_75'],
            'BET_33',
            'Fuera de posición, Q9 puede hacer block bet pequeño para cobrar a peores y evitar que BTN tome showdown gratis.',
            'GTO simplificado: algunas top pairs medias OOP usan block bet en river contra rangos capados.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 76, 'feedback' => 'Bien. Cobras fino y controlas el tamaño del bote.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 40, 'ev_score' => 68, 'feedback' => 'Check-call o check-evaluate también es jugable.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 34, 'feedback' => 'Grande te aísla contra mejores Qx.'],
            ],
            'La block bet permite extraer valor fino y reducir decisiones difíciles.',
            'En NL2-NL10 funciona bien contra rivales pasivos que pagan pequeño y no bluffean suficiente.',
            76
        );
    }

    protected static function thinValueOverpairOnScaryRiverSmall(): array
    {
        return self::spot(
            'river_thin_value_sb_vs_btn_qq_j74_8_9_bet33',
            'river_thin_value',
            'River Thin Value',
            'overpair_scary_river_small',
            'Overpair en river peligroso',
            'SB vs BTN · QQ en J7489',
            'SB',
            'BTN',
            ['Qh', 'Qc'],
            ['Js', '7d', '4c', '8h', '9s'],
            42.0,
            1.2,
            42.0,
            'River conecta muchas manos, pero BTN está capado',
            'SB tiene overpairs; BTN tiene Jx, TT, 9x y algunas escaleras.',
            'QQ todavía gana a muchas manos, pero debe elegir tamaño pequeño.',
            ['BTN opens 2.5 BB', 'SB 3bets 10 BB', 'BTN calls', 'Flop: J♠ 7♦ 4♣', 'SB bets 7 BB', 'BTN calls', 'Turn: 8♥', 'SB checks', 'BTN checks back', 'River: 9♠', 'Action on Hero SB'],
            ['CHECK', 'BET_33', 'BET_75'],
            'BET_33',
            'QQ aún cobra de Jx y TT, pero el river conecta T9/T6/65. Tamaño pequeño evita aislarse demasiado.',
            'GTO simplificado: overpair en runouts que empeoran puede usar block/value pequeño contra rangos capados.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 44, 'ev_score' => 72, 'feedback' => 'Bien. Value fino con tamaño prudente.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 46, 'ev_score' => 70, 'feedback' => 'Check también es sólido contra rivales agresivos.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 28, 'feedback' => 'Grande de más en un river que conecta mucho.'],
            ],
            'Cuando el river empeora tu mano, si apuestas debe ser por valor fino y con size controlado.',
            'En microlímites, pequeño cobra Jx; grande recibe demasiados calls mejores.',
            72
        );
    }

    protected static function thinValueTripsWeakKickerSmall(): array
    {
        return self::spot(
            'river_thin_value_bb_vs_sb_96_992_4_7_bet33',
            'river_thin_value',
            'River Thin Value',
            'trips_weak_kicker_small',
            'Trips kicker débil apuesta pequeño',
            'BB vs SB · 96 en 99247',
            'BB',
            'SB',
            ['9h', '6h'],
            ['9s', '9d', '2c', '4h', '7s'],
            20.0,
            2.5,
            54.0,
            'River blank con trips pero kicker bajo',
            'BB tiene trips; SB puede tener overpairs, 2x/4x y algunos 9x mejores.',
            'Hero gana a muchas manos peores pero no quiere polarizar.',
            ['SB opens 3 BB', 'BB calls', 'Flop: 9♠ 9♦ 2♣', 'SB bets 2 BB', 'BB calls', 'Turn: 4♥', 'SB checks', 'BB bets 5 BB', 'SB calls', 'River: 7♠', 'Action on Hero BB'],
            ['CHECK', 'BET_33', 'BET_75'],
            'BET_33',
            'Trips con kicker débil quiere cobrar a overpairs y pares, pero si apuesta grande se aísla contra 9x mejores. Size pequeño es mejor.',
            'GTO simplificado: trips con kicker bajo suele preferir value pequeño contra rangos que contienen trips mejores.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 78, 'feedback' => 'Correcto. Cobras a peores sin inflar contra mejores.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 62, 'feedback' => 'Check pierde valor contra overpairs.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 38, 'feedback' => 'Grande es demasiado thin con kicker bajo.'],
            ],
            'La misma categoría de mano cambia mucho según el kicker.',
            'En NL2-NL10 overpairs pagan pequeño; 9x mejores te castigan si apuestas grande.',
            78
        );
    }

    protected static function thinValueTopPairVsRecreational(): array
    {
        return self::spot(
            'river_thin_value_btn_vs_bb_a9_a73_2_8_bet33',
            'river_thin_value',
            'River Thin Value',
            'top_pair_vs_recreational',
            'Top pair débil vs recreacional',
            'BTN vs BB · A9 en A7328',
            'BTN',
            'BB',
            ['Ah', '9c'],
            ['As', '7d', '3c', '2h', '8s'],
            19.0,
            2.6,
            56.0,
            'River blank contra rango débil',
            'BTN tiene Ax; BB tiene Ax peores, 7x y pares curiosos.',
            'Contra recreacional, muchas manos peores pagan tamaño pequeño.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♦ 3♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'BTN checks back', 'River: 8♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_75'],
            'BET_33',
            'A9 no es una mano enorme, pero contra recreacionales obtiene valor de Ax peores, 7x y pocket pairs. El tamaño pequeño es clave.',
            'GTO simplificado: top pair kicker medio puede valuebetear pequeño contra rangos pasivos/capados.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 56, 'ev_score' => 77, 'feedback' => 'Bien. Thin value explotativo con size adecuado.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 36, 'ev_score' => 66, 'feedback' => 'Check es prudente, pero dejas dinero contra recreacionales.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 34, 'feedback' => 'Demasiado grande para kicker medio.'],
            ],
            'El rival importa: contra recreacionales hay más thin value que contra regulares.',
            'En NL2-NL10 una apuesta pequeña recibe calls muy malos. Eso es dinero.',
            77
        );
    }
}
