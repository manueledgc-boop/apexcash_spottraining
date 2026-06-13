<?php

namespace App\SpotTraining\PostflopRiver\Modules;

use App\SpotTraining\PostflopRiver\Concerns\BuildsPostflopRiverSpots;

class RiverValueBetSpots
{
    use BuildsPostflopRiverSpots;

    public static function all(): array
    {
        return [
            self::topPairTopKickerClearValue(),
            self::overpairGetsCalledByTopPair(),
            self::setOnDryRunout(),
            self::twoPairVsCappedRange(),
            self::nutFlushRiverValue(),
            self::straightVsStation(),
            self::boatOnPairedRiver(),
            self::topPairSmallValueVsMissedDraws(),
            self::tripsKickerValue(),
            self::threeBetPotOverpairRiver(),
        ];
    }

    protected static function topPairTopKickerClearValue(): array
    {
        return self::spot(
            'river_value_btn_vs_bb_ak_k72_4_2_bet66',
            'river_value_bet',
            'River Value Bet',
            'top_pair_top_kicker_clear_value',
            'Top pair top kicker por valor',
            'BTN vs BB · AK en K72r · River 2',
            'BTN',
            'BB',
            ['As', 'Kh'],
            ['Ks', '7d', '2c', '4h', '2d'],
            23.5,
            1.8,
            42.0,
            'River doblado bajo, sin proyectos completados',
            'BTN conserva ventaja de Kx fuertes y overpairs.',
            'BTN tiene AK/KQ/AA; BB tiene Kx peores, 7x y pares medios.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♦ 2♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'BTN bets 7 BB', 'BB calls', 'River: 2♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'AK sigue dominando muchísimos calls peores. El river no completa draws importantes y BB tendrá KQ, KJ, KT, 7x curioso y pares que no foldean siempre.',
            'GTO simplificado: top pair top kicker en runouts limpios apuesta por valor a frecuencia alta, usando tamaño medio para recibir calls de rango dominado.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 88, 'feedback' => 'Correcto. Tamaño perfecto para cobrar a Kx peores sin aislarte solo contra trips o full houses.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 78, 'feedback' => 'Buena agresión, pero contra algunos rivales este tamaño tira demasiadas manos peores.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 42, 'feedback' => 'Pierdes valor claro. Hay demasiadas manos peores que pagan river.'],
            ],
            'En river, apostar por valor no exige tener nuts: exige que suficientes manos peores paguen.',
            'En NL2-NL10 este es value clarísimo. La gente paga demasiado con cualquier Kx y odia foldear pares en river.',
            88
        );
    }

    protected static function overpairGetsCalledByTopPair(): array
    {
        return self::spot(
            'river_value_co_vs_bb_aa_j85_9_3_bet50',
            'river_value_bet',
            'River Value Bet',
            'overpair_value_river',
            'Overpair por valor en river seguro',
            'CO vs BB · AA en J85tt · River 3',
            'CO',
            'BB',
            ['As', 'Ad'],
            ['Jh', '8h', '5c', '9d', '3s'],
            31.0,
            1.4,
            44.0,
            'River blank tras turn dinámico',
            'CO mantiene overpairs fuertes; BB tiene muchos Jx y draws fallidos.',
            'BB tiene algunas escaleras, pero muchas manos medias llegan al river.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: J♥ 8♥ 5♣', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 9♦', 'BB checks', 'CO bets 10 BB', 'BB calls', 'River: 3♠', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'AA todavía gana a Jx, TT, T9, 98 y muchos bluffcatchers. El tamaño medio permite valor sin convertir la mano en una apuesta demasiado polarizada.',
            'GTO simplificado: overpair puede value betear river en blanks, pero prefiere tamaño medio porque no bloquea demasiados calls peores.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 84, 'feedback' => 'Correcto. Cobras a Jx y pares medios sin exagerar el tamaño.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 62, 'feedback' => 'No es horrible, pero dejas dinero contra rivales que pagan demasiado.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 22, 'ev_score' => 74, 'feedback' => 'Puede funcionar contra calling stations, pero contra rivales normales aisla más contra manos fuertes.'],
            ],
            'El tamaño de river debe responder a qué manos peores pagan, no solo a la fuerza absoluta de tu mano.',
            'Contra recreacionales pasivos, apuesta. Si te resuben grande, normalmente estás muerto y puedes foldear sin drama.',
            84
        );
    }

    protected static function setOnDryRunout(): array
    {
        return self::spot(
            'river_value_bb_vs_btn_set_77_k72_4_j_bet75',
            'river_value_bet',
            'River Value Bet',
            'set_value_dry_runout',
            'Set fuerte en runout seco',
            'BB vs BTN · 77 en K72r · River J',
            'BB',
            'BTN',
            ['7s', '7c'],
            ['Kh', '7d', '2c', '4s', 'Jd'],
            18.0,
            2.3,
            41.0,
            'Runout seco, river overcard',
            'BTN tiene Kx fuertes; BB tiene sets y algunas dobles.',
            'BB tiene ventaja de nuts por sets defendidos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♥ 7♦ 2♣', 'BB checks', 'BTN bets 2.5 BB', 'BB calls', 'Turn: 4♠', 'BB checks', 'BTN checks back', 'River: J♦', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'El check back turn de BTN capa bastante su rango, pero todavía tiene Kx y Jx que pueden pagar. Con set quieres construir bote y castigar manos hechas.',
            'GTO simplificado: cuando el rival muestra debilidad en turn, river puede apostar grande con sets para capturar valor de top pairs y bluffcatchers.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 90, 'feedback' => 'Correcto. Set fuerte quiere tamaño grande contra rango capado.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 80, 'feedback' => 'Bien, aunque dejas valor contra Kx que pagan grande.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 20, 'feedback' => 'Muy pasivo. Pierdes una apuesta de valor enorme.'],
            ],
            'Cuando tu mano desbloquea calls peores y bloquea pocas manos de pago, el valor grande imprime dinero.',
            'En microlímites no hagas slowplay river con set. Apuesta grande: te pagan con Kx, Jx y curiosidad.',
            90
        );
    }

    protected static function twoPairVsCappedRange(): array
    {
        return self::spot(
            'river_value_sb_vs_btn_q9_q94_2_6_bet66',
            'river_value_bet',
            'River Value Bet',
            'two_pair_vs_capped_range',
            'Dobles contra rango capado',
            'SB vs BTN · Q9 en Q94r · River 6',
            'SB',
            'BTN',
            ['Qs', '9s'],
            ['Qh', '9d', '4c', '2h', '6c'],
            34.0,
            1.3,
            43.0,
            'River blank, dobles siguen fuertes',
            'SB tiene ventaja de manos fuertes tras 3bet pot.',
            'SB conserva overpairs, sets y dobles fuertes.',
            ['BTN opens 2.5 BB', 'SB 3bets 10 BB', 'BTN calls', 'Flop: Q♥ 9♦ 4♣', 'SB bets 5 BB', 'BTN calls', 'Turn: 2♥', 'SB bets 12 BB', 'BTN calls', 'River: 6♣', 'Action on Hero SB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Top two domina Qx, AQ slowplayed, KQ, QJ y algunos bluffcatchers. En bote 3bet el SPR es bajo y el objetivo es extraer máximo valor.',
            'GTO simplificado: dobles fuertes en river blank pueden usar tamaño grande porque el rango del caller contiene muchas top pairs dominadas.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 89, 'feedback' => 'Correcto. Presionas a Qx y pares que no quieren foldear en bote grande.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 32, 'ev_score' => 80, 'feedback' => 'Aceptable, pero el spot permite más valor.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 38, 'feedback' => 'Demasiado pasivo. Hero tiene apuesta clara.'],
            ],
            'En botes 3bet, manos fuertes no necesitan inducir: necesitan sacar valor antes del showdown.',
            'El pool de NL2-NL10 paga demasiado en botes 3bet porque ya se siente comprometido. Apuesta fuerte por valor.',
            89
        );
    }

    protected static function nutFlushRiverValue(): array
    {
        return self::spot(
            'river_value_btn_vs_bb_nut_flush_aqs_k72hh_4h_9c_bet75',
            'river_value_bet',
            'River Value Bet',
            'nut_flush_value',
            'Color nuts por valor',
            'BTN vs BB · AQs color nuts · River 9',
            'BTN',
            'BB',
            ['Ah', 'Qh'],
            ['Kh', '7h', '2c', '4h', '9c'],
            29.0,
            1.6,
            47.0,
            'Color completado en turn, river blank',
            'BTN tiene muchos colores altos; BB tiene colores peores, Kx y bluffcatchers.',
            'BTN tiene ventaja clara de nuts por Ax suited altos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♥ 7♥ 2♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'BTN bets 8 BB', 'BB calls', 'River: 9♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Con el color nuts bloqueas el A-high flush, pero BB conserva muchos colores peores y Kx que pueden pagar. No apostar es quemar valor.',
            'GTO simplificado: los nuts en river apuestan grande con alta frecuencia, equilibrados por bluffs con blockers adecuados.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 95, 'feedback' => 'Correcto. Mano premium, apuesta grande por valor.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 24, 'ev_score' => 84, 'feedback' => 'Gana dinero, pero puedes cobrar más.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 10, 'feedback' => 'Gravísimo. Los nuts deben apostar river.'],
            ],
            'Los nuts imprimen EV cuando el rival aún tiene suficientes segundas mejores manos.',
            'En límites bajos apuesta grande. Muchos no foldean colores peores ni top pair aunque sea obvio el color.',
            95
        );
    }

    protected static function straightVsStation(): array
    {
        return self::spot(
            'river_value_co_vs_bb_straight_t9_j87_2_6_bet75',
            'river_value_bet',
            'River Value Bet',
            'straight_value_vs_station',
            'Escalera contra calling station',
            'CO vs BB · T9 en J8762',
            'CO',
            'BB',
            ['Ts', '9s'],
            ['Jh', '8d', '7c', '2s', '6h'],
            26.0,
            1.9,
            49.0,
            'Board conectado, escalera hecha',
            'CO tiene manos fuertes por c-bet; BB tiene muchos pares, dobles y draws completados peor.',
            'Ambos tienen escaleras, pero Hero tiene una escalera muy fuerte.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: J♥ 8♦ 7♣', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 2♠', 'BB checks', 'CO bets 8 BB', 'BB calls', 'River: 6♥', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'La escalera de Hero gana a muchísimas dobles, sets lentos y Jx que pagan. Aunque el board asusta, contra station hay valor claro.',
            'GTO simplificado: una mano muy fuerte en river conectado puede apostar grande, pero debe estar preparada para evaluar raises.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 86, 'feedback' => 'Correcto. Hay valor de dobles, sets y bluffcatchers tercos.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 78, 'feedback' => 'Bien si el rival foldea mucho, pero contra station es pequeño.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 40, 'feedback' => 'Muy conservador. Tu mano merece value bet.'],
            ],
            'No todos los boards conectados obligan a frenar: si tu mano domina suficientes calls, apuesta.',
            'Contra jugadores que pagan de más, no te asustes por el board. Value betea y foldea ante raises enormes de nits.',
            86
        );
    }

    protected static function boatOnPairedRiver(): array
    {
        return self::spot(
            'river_value_bb_vs_btn_full_house_55_a95_9_2_bet75',
            'river_value_bet',
            'River Value Bet',
            'full_house_value',
            'Full house en river doblado',
            'BB vs BTN · 55 en A9592',
            'BB',
            'BTN',
            ['5c', '5d'],
            ['Ah', '9s', '5h', '9d', '2c'],
            24.0,
            2.0,
            48.0,
            'River paired, full house fuerte',
            'BTN tiene Ax y trips de 9; BB tiene full houses defendidos.',
            'BB tiene ventaja de nuts con 55, 95s y algunos 9x.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♥ 9♠ 5♥', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 9♦', 'BB checks', 'BTN checks back', 'River: 2♣', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Full house fuerte debe apostar. BTN puede tener Ax que no cree, trips, slowplays y bluffcatchers. Chequear esperando que apueste es inferior tras su check back turn.',
            'GTO simplificado: cuando el agresor muestra showdown value en turn, el defensor lidera river con sus manos muy fuertes.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 94, 'feedback' => 'Correcto. Valor grande contra rango con muchas manos hechas.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 26, 'ev_score' => 82, 'feedback' => 'Bien, aunque el spot permite presionar más.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 35, 'feedback' => 'No dependas de que el rival apueste. Tú debes construir valor.'],
            ],
            'Cuando el rival capea su rango, tus monstruos deben liderar river con tamaño ambicioso.',
            'En microlímites muchos pagan con Ax porque “no te creen”. Apuesta fuerte y cobra.',
            94
        );
    }

    protected static function topPairSmallValueVsMissedDraws(): array
    {
        return self::spot(
            'river_value_btn_vs_bb_kj_k86hh_2c_3s_bet50',
            'river_value_bet',
            'River Value Bet',
            'top_pair_small_value',
            'Top pair valor pequeño',
            'BTN vs BB · KJ en K86hh · River 3',
            'BTN',
            'BB',
            ['Kc', 'Js'],
            ['Kh', '8h', '6d', '2c', '3s'],
            21.0,
            2.2,
            46.0,
            'Missed flush draw, river blank',
            'BTN tiene Kx fuertes; BB tiene Kx peores, 8x y draws fallidos.',
            'BTN tiene ventaja de top pair fuerte, pero no de nuts absoluta.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♥ 8♥ 6♦', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♣', 'BB checks', 'BTN checks back', 'River: 3♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'KJ puede sacar valor pequeño de Kx peores, 8x curioso y algunos pares. El tamaño grande ya empieza a aislarte contra manos mejores.',
            'GTO simplificado: manos de valor medio en river prefieren tamaños pequeños o medios para recibir calls de rango amplio.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 56, 'ev_score' => 78, 'feedback' => 'Correcto. Value fino sin sobrerrepresentar tu mano.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 34, 'ev_score' => 62, 'feedback' => 'Aceptable contra rivales agresivos, pero pierdes valor contra calling stations.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 45, 'feedback' => 'Demasiado grande. Te pagan menos manos peores.'],
            ],
            'Thin value no significa apostar enorme; significa elegir el tamaño que manos peores sí pueden pagar.',
            'En NL2-NL10, el value pequeño con top pair funciona muy bien porque pagan por curiosidad.',
            78
        );
    }

    protected static function tripsKickerValue(): array
    {
        return self::spot(
            'river_value_sb_vs_bb_trips_aq_q72_q_5_bet66',
            'river_value_bet',
            'River Value Bet',
            'trips_good_kicker_value',
            'Trips buen kicker por valor',
            'SB vs BB · AQ en Q72Q5',
            'SB',
            'BB',
            ['Ah', 'Qs'],
            ['Qh', '7d', '2c', 'Qc', '5s'],
            27.0,
            1.7,
            45.0,
            'Board doblado, trips con top kicker',
            'SB tiene Qx fuertes y overpairs; BB tiene Qx peores y pares.',
            'SB tiene ventaja de trips fuertes por rango de open.',
            ['SB opens 3 BB', 'BB calls', 'Flop: Q♥ 7♦ 2♣', 'SB bets 3 BB', 'BB calls', 'Turn: Q♣', 'SB bets 8 BB', 'BB calls', 'River: 5♠', 'Action on Hero SB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'AQ bloquea algunos Qx, pero BB todavía tiene QJ, QT, Q9s y pares que bluffcatchean. Trips buen kicker debe apostar fuerte por valor.',
            'GTO simplificado: trips con kicker alto apuesta river con frecuencia alta porque domina la mayoría de trips del defensor.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 87, 'feedback' => 'Correcto. Dominas Qx peores y quieres valor grande.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 32, 'ev_score' => 79, 'feedback' => 'Bien, aunque puedes cobrar más a Qx.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 36, 'feedback' => 'Demasiado pasivo con trips fuertes.'],
            ],
            'Trips buen kicker no es bluffcatcher: es una mano de valor contra rangos amplios.',
            'Los jugadores de microlímites no foldean trips. Apuesta grande con AQ/KQ y cobra.',
            87
        );
    }

    protected static function threeBetPotOverpairRiver(): array
    {
        return self::spot(
            'river_value_sb_vs_btn_kk_t74_2_8_bet50',
            'river_value_bet',
            'River Value Bet',
            'three_bet_pot_overpair_value',
            'Overpair en bote 3bet',
            'SB vs BTN · KK en T7428',
            'SB',
            'BTN',
            ['Ks', 'Kd'],
            ['Th', '7c', '4d', '2s', '8h'],
            42.0,
            1.0,
            42.0,
            'Bote 3bet, river bajo semi conectado',
            'SB tiene overpairs; BTN tiene Tx, JJ-QQ, floats y algunos sets.',
            'SB mantiene overpairs fuertes; BTN tiene algunos sets pero rango más capado.',
            ['BTN opens 2.5 BB', 'SB 3bets 10 BB', 'BTN calls', 'Flop: T♥ 7♣ 4♦', 'SB bets 7 BB', 'BTN calls', 'Turn: 2♠', 'SB bets 14 BB', 'BTN calls', 'River: 8♥', 'Action on Hero SB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'KK todavía obtiene valor de Tx, JJ, QQ y calls tercos. Con SPR bajo, el tamaño medio deja al rival pagar con bluffcatchers peores.',
            'GTO simplificado: en botes 3bet con SPR bajo, overpair fuerte puede value betear river en runouts que no cambian demasiado la textura.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 82, 'feedback' => 'Correcto. Saca valor sin polarizar demasiado.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 32, 'ev_score' => 64, 'feedback' => 'Puede controlar contra rivales duros, pero pierde valor contra el pool.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 20, 'ev_score' => 74, 'feedback' => 'Funciona contra stations, aunque puede tirar Tx débil.'],
            ],
            'En river, las overpairs fuertes en botes 3bet siguen siendo apuestas de valor en muchos runouts bajos.',
            'En NL2-NL10 la gente paga demasiados 3bet pots con top pair y JJ/QQ. Apuesta por valor y no te asustes antes de tiempo.',
            82
        );
    }
}
