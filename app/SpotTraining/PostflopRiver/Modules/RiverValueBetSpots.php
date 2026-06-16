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
            self::valueBetTopTwoVsStation(),
            self::valueBetSetOnMissedFlush(),
            self::valueBetNutStraightPairedBoard(),
            self::valueBetFlushVsWorseFlushes(),
            self::valueBetFullHouseVsTrips(),
            self::smallValueBetTopPairWeakRange(),
            self::valueBetOverpairVsCappedRiver(),
            self::valueBetTripsOnBrickRiver(),
            self::valueBetStraightVsTwoPairHeavyRange(),
            self::valueBetRiverAfterDelayedCbet(),
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

    protected static function valueBetTopTwoVsStation(): array
    {
        return self::spot(
            'river_value_btn_vs_bb_ak_a96_k_3_bet75',
            'river_value_bet',
            'River Value Bet',
            'top_two_vs_station',
            'Top two contra jugador pagador',
            'BTN vs BB · AK en A96-K-3',
            'BTN',
            'BB',
            ['Ah', 'Kd'],
            ['As', '9c', '6d', 'Kh', '3s'],
            31.0,
            1.3,
            44.0,
            'River blank después de ligar top two',
            'BTN tiene Ax fuertes y dobles; BB llega con Ax peores, 9x y draws fallidos.',
            'BB tiene muchas manos que pagan demasiado en microlímites.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 9♣ 6♦', 'BB checks', 'BTN bets 4 BB', 'BB calls', 'Turn: K♥', 'BB checks', 'BTN bets 10 BB', 'BB calls', 'River: 3♠', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'AK tiene valor muy claro contra Ax peores y dobles inferiores. En este runout hay que apostar grande porque muchos rivales pagan por curiosidad con cualquier As.',
            'GTO simplificado: top two en river blank debe apostar grande contra rangos que contienen muchos bluff catchers peores.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 91, 'feedback' => 'Excelente. Cobras máximo a Ax peores y dobles inferiores.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 32, 'ev_score' => 80, 'feedback' => 'Correcto, aunque dejas valor contra calling stations.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 28, 'feedback' => 'Check pierde demasiado valor.'],
            ],
            'Top two en river blank es una mano de valor grande, no de control de bote.',
            'En NL2-NL10 apuesta grande: Ax peor paga muchísimo más de lo que debería.',
            91
        );
    }

    protected static function valueBetSetOnMissedFlush(): array
    {
        return self::spot(
            'river_value_co_vs_bb_99_k94_2_7_bet75',
            'river_value_bet',
            'River Value Bet',
            'set_on_missed_flush',
            'Set cuando falla el color',
            'CO vs BB · 99 en K94ss-2-7',
            'CO',
            'BB',
            ['9h', '9d'],
            ['Ks', '9s', '4c', '2h', '7d'],
            34.0,
            1.2,
            43.0,
            'River blank, proyecto de color fallido',
            'CO tiene sets y Kx fuertes; BB llega con Kx, pares y missed draws.',
            'BB puede bluffcatchear demasiado con Kx y pares medios.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: K♠ 9♠ 4♣', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'CO bets 11 BB', 'BB calls', 'River: 7♦', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'El color falló y BB tendrá muchos Kx que no foldean. Set quiere tamaño grande por valor; check es perder una calle enorme.',
            'GTO simplificado: sets en rivers blank apuestan grande cuando el rango rival tiene top pair y bluff catchers suficientes.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 74, 'ev_score' => 94, 'feedback' => 'Perfecto. Máximo valor contra Kx y bluff catchers.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 26, 'ev_score' => 82, 'feedback' => 'Bien, pero el rival pagador permite más grande.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 3, 'ev_score' => 12, 'feedback' => 'No puedes dejar de apostar set aquí.'],
            ],
            'Cuando los proyectos fallan, tus manos fuertes cobran mucho más valor.',
            'En micros, no slowplayees sets en river: la gente paga top pair.',
            94
        );
    }

    protected static function valueBetNutStraightPairedBoard(): array
    {
        return self::spot(
            'river_value_bb_vs_btn_qj_t98_2_t_bet50',
            'river_value_bet',
            'River Value Bet',
            'nut_straight_paired_board',
            'Escalera en board emparejado',
            'BB vs BTN · QJ en T98-2-T',
            'BB',
            'BTN',
            ['Qh', 'Jd'],
            ['Ts', '9c', '8d', '2h', 'Tc'],
            29.0,
            1.6,
            46.0,
            'River empareja top card',
            'BB tiene escaleras y algunos full houses; BTN tiene Tx, overpairs y bluff catchers.',
            'Hero tiene escalera fuerte pero el board emparejado reduce algo el valor absoluto.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♣ 8♦', 'BB checks', 'BTN checks back', 'Turn: 2♥', 'BB bets 6 BB', 'BTN calls', 'River: T♣', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'La escalera sigue ganando a Tx y overpairs, pero el board emparejado permite full houses. El tamaño medio cobra valor sin aislarse demasiado contra manos mejores.',
            'GTO simplificado: manos fuertes no-nut en boards emparejados suelen preferir tamaño medio.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 84, 'feedback' => 'Correcto. Cobras a Tx y evitas polarizar demasiado.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 62, 'feedback' => 'Check pierde valor contra Tx.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 22, 'ev_score' => 76, 'feedback' => 'Puede valer contra rivales que pagan demasiado, pero es más thin.'],
            ],
            'No todas las manos fuertes deben usar tamaño máximo: el board importa.',
            'En NL2-NL10 apuesta medio si el river empareja y hay full houses posibles.',
            84
        );
    }

    protected static function valueBetFlushVsWorseFlushes(): array
    {
        return self::spot(
            'river_value_btn_vs_bb_a5s_k82_q_3_bet75_flush',
            'river_value_bet',
            'River Value Bet',
            'flush_vs_worse_flushes',
            'Color alto contra colores peores',
            'BTN vs BB · A5s color river',
            'BTN',
            'BB',
            ['As', '5s'],
            ['Ks', '8s', '2d', 'Qh', '3s'],
            37.0,
            1.1,
            42.0,
            'River completa color',
            'BTN tiene nut flushes; BB tiene muchos colores peores y Kx con spade.',
            'BB puede pagar con cualquier color y algunos bluff catchers con As bloqueado no existen porque Hero lo tiene.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 8♠ 2♦', 'BB checks', 'BTN bets 4 BB', 'BB calls', 'Turn: Q♥', 'BB checks', 'BTN bets 11 BB', 'BB calls', 'River: 3♠', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Con el As de espadas tienes el color máximo. BB llega con muchos suited spades peores y Kx con spade que no foldean. Apuesta grande.',
            'GTO simplificado: nut flushes apuestan grande en river cuando el rival conserva muchos flushes peores.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 93, 'feedback' => 'Excelente. El rival puede pagar muchísimos colores peores.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Bien, pero dejas dinero contra colores peores.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 8, 'feedback' => 'No apostar el nut flush aquí es un error grave.'],
            ],
            'Cuando tienes las nuts y el rival tiene muchas segundas mejores manos, aumenta el tamaño.',
            'En microlímites los colores no se foldean. Apuesta fuerte por valor.',
            93
        );
    }

    protected static function valueBetFullHouseVsTrips(): array
    {
        return self::spot(
            'river_value_sb_vs_bb_77_a72_7_a_bet75',
            'river_value_bet',
            'River Value Bet',
            'full_house_vs_trips',
            'Full house contra trips',
            'SB vs BB · 77 en A727A',
            'SB',
            'BB',
            ['7h', '7d'],
            ['As', '7c', '2h', '7s', 'Ad'],
            45.0,
            1.0,
            40.0,
            'River dobla el As',
            'SB tiene full houses enormes; BB tiene muchos Ax y algunos 7x.',
            'BB no foldea trips de As en microlímites.',
            ['SB opens 3 BB', 'BB calls', 'Flop: A♠ 7♣ 2♥', 'SB bets 3 BB', 'BB calls', 'Turn: 7♠', 'SB bets 9 BB', 'BB calls', 'River: A♦', 'Action on Hero SB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Hero tiene full house muy fuerte y BB puede tener Ax que ahora se siente invencible. Hay que apostar grande por valor.',
            'GTO simplificado: full houses altos apuestan grande frente a rangos con trips abundantes.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 96, 'feedback' => 'Perfecto. Ax te paga muchísimo en este river.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 22, 'ev_score' => 84, 'feedback' => 'Correcto, pero el spot permite más grande.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 1, 'ev_score' => 4, 'feedback' => 'Check pierde una apuesta enorme.'],
            ],
            'Las manos monstruo deben pensar en qué segundas mejores manos pagan.',
            'En NL2-NL10 nadie foldea trips de As. Cobra caro.',
            96
        );
    }

    protected static function smallValueBetTopPairWeakRange(): array
    {
        return self::spot(
            'river_value_btn_vs_bb_qj_q83_2_5_bet50',
            'river_value_bet',
            'River Value Bet',
            'small_value_top_pair_weak_range',
            'Value pequeño con top pair',
            'BTN vs BB · QJ en Q8325',
            'BTN',
            'BB',
            ['Qh', 'Jc'],
            ['Qs', '8d', '3c', '2h', '5s'],
            21.0,
            2.0,
            46.0,
            'River bajo sin proyectos obvios',
            'BTN tiene Qx fuertes; BB tiene Qx peores, 8x y pares medios.',
            'BB está capado tras check-call/check-check.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 8♦ 3♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'BTN checks back', 'River: 5♠', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'QJ gana a muchas Qx peores y 8x, pero no quiere polarizar demasiado. Tamaño medio/pequeño cobra valor de rango débil.',
            'GTO simplificado: top pair buen kicker puede apostar pequeño/medio contra rangos capados.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 80, 'feedback' => 'Bien. Value claro sin asustar manos peores.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 62, 'feedback' => 'Check pierde valor contra Qx peor y 8x curioso.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 14, 'ev_score' => 56, 'feedback' => 'Grande puede aislarte demasiado contra mejores Qx.'],
            ],
            'Value bet no siempre significa apostar grande; a veces el tamaño pequeño cobra más calls peores.',
            'En microlímites apuesta tamaños que te paguen manos peores, no tamaños que solo pagan mejores.',
            80
        );
    }

    protected static function valueBetOverpairVsCappedRiver(): array
    {
        return self::spot(
            'river_value_co_vs_bb_qq_j64_2_2_bet50',
            'river_value_bet',
            'River Value Bet',
            'overpair_vs_capped_range',
            'Overpair contra rango capado',
            'CO vs BB · QQ en J6422',
            'CO',
            'BB',
            ['Qh', 'Qc'],
            ['Js', '6d', '4c', '2h', '2s'],
            27.0,
            1.6,
            45.0,
            'River dobla carta baja',
            'CO tiene overpairs; BB llega con Jx, pares medios y algunos 6x.',
            'BB está relativamente capado porque no subió calles anteriores.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: J♠ 6♦ 4♣', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'CO bets 8 BB', 'BB calls', 'River: 2♠', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'QQ gana a Jx y pares medios. El river 2 no cambia mucho y permite una apuesta de valor media.',
            'GTO simplificado: overpairs contra rangos capados siguen valuebeteando en runouts bajos.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 84, 'feedback' => 'Correcto. Jx paga y casi no cambió la textura.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 24, 'ev_score' => 76, 'feedback' => 'Puede funcionar contra calling stations.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 44, 'feedback' => 'Check pierde valor contra Jx.'],
            ],
            'Cuando el river no cambia el rango relativo, las overpairs fuertes siguen apostando por valor.',
            'En NL2-NL10 apuesta: Jx paga mucho más de lo correcto.',
            84
        );
    }

    protected static function valueBetTripsOnBrickRiver(): array
    {
        return self::spot(
            'river_value_bb_vs_sb_k9_994_2_6_bet75',
            'river_value_bet',
            'River Value Bet',
            'trips_on_brick_river',
            'Trips en river ladrillo',
            'BB vs SB · K9 en 99426',
            'BB',
            'SB',
            ['Kh', '9h'],
            ['9s', '9d', '4c', '2h', '6s'],
            25.0,
            1.8,
            47.0,
            'River blank con trips fuertes',
            'BB tiene muchos 9x defendidos; SB puede tener overpairs y A-high curiosos.',
            'SB abrió rango amplio y puede pagar con pares altos.',
            ['SB opens 3 BB', 'BB calls', 'Flop: 9♠ 9♦ 4♣', 'SB bets 2 BB', 'BB calls', 'Turn: 2♥', 'SB checks', 'BB bets 6 BB', 'SB calls', 'River: 6♠', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'K9 es trips con kicker alto y SB puede pagar con TT-AA o 4x desconfiando. Hay que apostar grande por valor.',
            'GTO simplificado: trips fuertes en river blank son value bet grande contra rangos con overpairs.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 90, 'feedback' => 'Muy bien. Overpairs pagan muchísimo.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 78, 'feedback' => 'Correcto, pero puedes cobrar más.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 7, 'ev_score' => 30, 'feedback' => 'Check pierde valor claro.'],
            ],
            'Trips fuerte debe construir bote cuando el rival tiene muchas manos segundas mejores.',
            'En microlímites la gente no abandona overpairs fácilmente. Apuesta fuerte.',
            90
        );
    }

    protected static function valueBetStraightVsTwoPairHeavyRange(): array
    {
        return self::spot(
            'river_value_btn_vs_bb_jt_987_2_q_bet75',
            'river_value_bet',
            'River Value Bet',
            'straight_vs_two_pair_range',
            'Escalera contra rango de dobles',
            'BTN vs BB · JT en 987-2-Q',
            'BTN',
            'BB',
            ['Jh', 'Tc'],
            ['9s', '8d', '7c', '2h', 'Qs'],
            33.0,
            1.3,
            44.0,
            'River completa escalera alta para Hero',
            'BTN tiene JT/T6; BB llega con dobles, sets y pares fuertes.',
            'BB puede pagar grande con 9x, dobles y sets en microlímites.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♠ 8♦ 7♣', 'BB checks', 'BTN bets 4 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'BTN checks back', 'River: Q♠', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Hero tiene escalera fuerte y BB conserva muchas manos hechas que pagan. El check back turn induce calls curiosos en river.',
            'GTO simplificado: escaleras fuertes valuebetean grande cuando el rival tiene muchas dobles/sets peores.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 89, 'feedback' => 'Excelente. Cobras a sets, dobles y pares tercos.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 80, 'feedback' => 'Bien, aunque dejas valor si el rival paga de más.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 32, 'feedback' => 'Check pierde demasiado valor con una mano fuerte.'],
            ],
            'Piensa qué manos peores pagan antes de decidir el tamaño.',
            'En NL2-NL10 muchos no foldean dobles ni sets: apuesta grande.',
            89
        );
    }

    protected static function valueBetRiverAfterDelayedCbet(): array
    {
        return self::spot(
            'river_value_btn_vs_bb_aq_q74_2_a_bet75',
            'river_value_bet',
            'River Value Bet',
            'river_value_after_delayed_cbet',
            'Valor tras delayed c-bet',
            'BTN vs BB · AQ en Q74-2-A',
            'BTN',
            'BB',
            ['Ah', 'Qd'],
            ['Qs', '7c', '4h', '2d', 'As'],
            24.0,
            1.7,
            45.0,
            'River mejora Hero a dobles',
            'BTN chequeó flop y apostó turn, por lo que BB puede pagar con Qx y Ax curiosos.',
            'BB tiene muchas Qx peores después de pagar turn.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♣ 4♥', 'BB checks', 'BTN checks back', 'Turn: 2♦', 'BB checks', 'BTN bets 5 BB', 'BB calls', 'River: A♠', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'AQ mejora a top two y la línea de check flop mantiene al rival con Qx peores. El As también puede hacer que Ax pague. Hay que apostar por valor grande.',
            'GTO simplificado: cuando una carta de river mejora tu rango y tu mano a valor fuerte, apuesta grande contra rangos capados.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 90, 'feedback' => 'Muy bien. Top two cobra a Qx y Ax peores.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 80, 'feedback' => 'Correcto, aunque más pequeño pierde valor.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 7, 'ev_score' => 30, 'feedback' => 'Check pierde una apuesta clara de valor.'],
            ],
            'Las líneas retrasadas también generan oportunidades de valor fuerte en river.',
            'En microlímites, cuando mejoras a dobles contra rango capado, apuesta: te pagan Qx y Ax.',
            90
        );
    }
}
