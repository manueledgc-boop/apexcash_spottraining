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
}
