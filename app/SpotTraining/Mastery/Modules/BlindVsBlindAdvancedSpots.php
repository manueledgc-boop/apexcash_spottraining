<?php

namespace App\SpotTraining\Mastery\Modules;

use App\SpotTraining\Mastery\Concerns\BuildsMasterySpots;

class BlindVsBlindAdvancedSpots
{
    use BuildsMasterySpots;

    public static function all(): array
    {
        return [
            self::sbVsBbAHighCbetSmall(),
            self::bbDefendsK9sFacingSmallCbet(),
            self::sbBarrelTurnOvercard(),
            self::bbRaisesTurnWithComboDraw(),
            self::sbRiverThinValueTopPair(),
            self::bbRiverBluffcatchSecondPair(),
            self::sbOverbetRiverNutAdvantage(),
            self::bbFoldWeakAceVsTripleBarrel(),
            self::sbCheckRaiseFlopPairedBoard(),
            self::bbFloatFlopStabTurn(),
            self::sbVsBb3BetPotAkAHighFlop(),
            self::bb3BetPotQQLowFlop(),
            self::sbCalls3BetAJsFlushDraw(),
            self::bbDelayedCbetTurn(),
            self::sbRiverMissedDrawBluff(),
            self::bbRiverValueBetTwoPair(),
            self::sbLowSprTurnJamTopPair(),
            self::bbCheckRaiseRiverPolar(),
            self::sbDonkTurnPairedBoard(),
            self::bbHeroCallRiverBlockers(),
        ];
    }

    protected static function sbVsBbAHighCbetSmall(): array
    {
        return self::spot(
            id: 'mastery_bvb_001',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'sb_cbet_a_high',
            conceptLabel: 'CBet SB vs BB en A-high',
            title: 'SB vs BB · A-high seco tras open SB',
            street: 'flop',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['Kd', 'Qd'],
            boardCards: ['As', '7c', '2h'],
            potBb: 5.0,
            spr: 17.0,
            effectiveStackBb: 85,
            boardTexture: 'A-high seco',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop As 7c 2h',
                'Hero actúa primero',
            ],
            options: ['CHECK', 'BET_33', 'BET_75'],
            correctAction: 'BET_33',
            explanation: 'SB tiene ventaja de rango en A-high seco. KQ sin showdown fuerte puede apostar pequeño y presionar muchas manos que no conectaron.',
            solverNote: 'En boards A-high secos, SB puede usar cbet pequeña con frecuencia alta.',
            grades: [
                'BET_33' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Apuestas pequeño aprovechando ventaja de rango.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 80, 'feedback' => 'Check es viable, pero pierdes fold equity.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 0, 'ev_score' => 42, 'feedback' => 'Demasiado grande para una mano sin equity fuerte.'],
            ],
            gtoInsight: 'GTO simplificado: SB conserva ventaja de rango en muchos A-high secos y puede cbetear pequeño.',
            lowStakesInsight: 'En NL2-NL10 el bet pequeño funciona muy bien porque BB foldea demasiada basura.',
            confidence: 84
        );
    }

    protected static function bbDefendsK9sFacingSmallCbet(): array
    {
        return self::spot(
            id: 'mastery_bvb_002',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'bb_defense_vs_cbet',
            conceptLabel: 'Defensa BB vs CBet',
            title: 'BB defiende K9s contra cbet pequeña',
            street: 'flop',
            heroPosition: 'BB',
            villainPosition: 'SB',
            heroCards: ['Ks', '9s'],
            boardCards: ['Kc', '7d', '3h'],
            potBb: 5.0,
            spr: 17.0,
            effectiveStackBb: 85,
            boardTexture: 'K-high seco',
            rangeAdvantage: 'SB ligera',
            nutAdvantage: 'SB ligera',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Kc 7d 3h',
                'SB apuesta 33%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'CALL',
            explanation: 'K9s es top pair suficiente para pagar. Raisear aísla contra mejores Kx y foldear es demasiado débil.',
            solverNote: 'Top pairs medias continúan mucho contra sizing pequeño en defensa de BB.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 80, 'ev_score' => 100, 'feedback' => 'Correcto. Pagas y mantienes bluffs dentro.'],
                'RAISE' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 58, 'feedback' => 'No necesitas convertir top pair media en raise.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 10, 'feedback' => 'Fold demasiado débil con top pair.'],
            ],
            gtoInsight: 'GTO simplificado: BB debe defender suficientes top pairs frente a cbet pequeña.',
            lowStakesInsight: 'En micros paga; muchos c-betean demasiado amplio desde SB.',
            confidence: 87
        );
    }

    protected static function sbBarrelTurnOvercard(): array
    {
        return self::spot(
            id: 'mastery_bvb_003',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'turn_barrel_bvb',
            conceptLabel: 'Segundo barrel BvB',
            title: 'SB barrelea turn overcard favorable',
            street: 'turn',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Jc'],
            boardCards: ['Qd', '7s', '2c', 'Ks'],
            potBb: 8.5,
            spr: 10.8,
            effectiveStackBb: 92,
            boardTexture: 'Broadway seco · K turn',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Qd 7s 2c',
                'SB apuesta 33%',
                'BB paga',
                'Turn Ks',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_75'],
            correctAction: 'BET_75',
            explanation: 'El K favorece al rango de SB y AJ gana gutshot más blockers. Es una carta excelente para aumentar presión.',
            solverNote: 'Las overcards que favorecen al agresor permiten barrels más grandes.',
            grades: [
                'BET_75' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Buena carta para presionar.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 84, 'feedback' => 'También bien, aunque menos presión.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 56, 'feedback' => 'Pierdes fold equity en una carta favorable.'],
            ],
            gtoInsight: 'GTO simplificado: SB barrelea turns que mejoran su rango percibido y su equity.',
            lowStakesInsight: 'En NL2-NL10 funciona contra BB que paga flop y foldea demasiado turn.',
            confidence: 81
        );
    }

    protected static function bbRaisesTurnWithComboDraw(): array
    {
        return self::spot(
            id: 'mastery_bvb_004',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'turn_raise_combo_draw',
            conceptLabel: 'Raise Turn con Combo Draw',
            title: 'BB raisea turn con combo draw',
            street: 'turn',
            heroPosition: 'BB',
            villainPosition: 'SB',
            heroCards: ['Ts', '9s'],
            boardCards: ['8s', '7d', '2s', 'Qh'],
            potBb: 9.0,
            spr: 9.5,
            effectiveStackBb: 86,
            boardTexture: 'Muy dinámico con flush draw y open ended',
            rangeAdvantage: 'Compartida',
            nutAdvantage: 'BB',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop 8s 7d 2s',
                'SB apuesta 33%',
                'BB paga',
                'Turn Qh',
                'SB apuesta 75%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'RAISE',
            explanation: 'T9s tiene open ended, flush draw y poca showdown. Raise maximiza fold equity y castiga barrels amplios.',
            solverNote: 'Combo draws fuertes son candidatos naturales a semi-bluff raise en turn.',
            grades: [
                'RAISE' => ['grade' => 'best', 'frequency' => 45, 'ev_score' => 100, 'feedback' => 'Correcto. Mucha equity y fold equity.'],
                'CALL' => ['grade' => 'good', 'frequency' => 45, 'ev_score' => 86, 'feedback' => 'Call también realiza equity, pero menos presión.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Fold imposible con tanta equity.'],
            ],
            gtoInsight: 'GTO simplificado: los mejores proyectos pueden jugar agresivo para equilibrar raises de valor.',
            lowStakesInsight: 'En micros, si el rival foldea turn, raise es muy rentable. Contra calling station, call gana valor.',
            confidence: 79
        );
    }

    protected static function sbRiverThinValueTopPair(): array
    {
        return self::spot(
            id: 'mastery_bvb_005',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'river_thin_value_bvb',
            conceptLabel: 'Thin Value River BvB',
            title: 'SB value fino river con top pair',
            street: 'river',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['Kh', 'Jd'],
            boardCards: ['Kc', '8s', '4d', '2h', '7c'],
            potBb: 15.5,
            spr: 5.0,
            effectiveStackBb: 78,
            boardTexture: 'K-high seco',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB ligera',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Kc 8s 4d · SB bet 33% · BB paga',
                'Turn 2h · check/check',
                'River 7c',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_100'],
            correctAction: 'BET_50',
            explanation: 'KJ gana a muchos Kx peores, 8x curioso y bluffcatchers. Medio bote extrae valor sin aislarse demasiado.',
            solverNote: 'Top pair buen kicker puede valuebetear river en runouts seguros.',
            grades: [
                'BET_50' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Value fino rentable.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 25, 'ev_score' => 48, 'feedback' => 'Pierdes valor contra peores.'],
                'BET_100' => ['grade' => 'marginal', 'frequency' => 15, 'ev_score' => 62, 'feedback' => 'Demasiado grande para value fino.'],
            ],
            gtoInsight: 'GTO simplificado: en BvB los rangos son amplios, top pair gana valor relativo.',
            lowStakesInsight: 'En NL2-NL10 apuesta por valor. Pagan Kx peores más de la cuenta.',
            confidence: 84
        );
    }

    protected static function bbRiverBluffcatchSecondPair(): array
    {
        return self::spot(
            id: 'mastery_bvb_006',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'river_bluffcatch_bvb',
            conceptLabel: 'Bluffcatch River BvB',
            title: 'BB bluffcatchea segundo par river',
            street: 'river',
            heroPosition: 'BB',
            villainPosition: 'SB',
            heroCards: ['Qh', '8h'],
            boardCards: ['Ks', '8d', '4c', '2s', '7h'],
            potBb: 16.0,
            spr: 4.8,
            effectiveStackBb: 77,
            boardTexture: 'K-high con draws fallidos',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB ligera',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Ks 8d 4c · SB bet 33% · BB paga',
                'Turn 2s · SB bet 75% · BB paga',
                'River 7h',
                'SB apuesta 75%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'CALL',
            explanation: 'Q8 bloquea algunas dobles y gana a bluffs fallidos. En BvB los rangos son amplios y segundo par puede defender.',
            solverNote: 'Los bluffcatchers con blockers decentes continúan contra frecuencias de bluff amplias.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Bluffcatch razonable en BvB.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 78, 'feedback' => 'Exploit contra nit puede ser fold.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 14, 'feedback' => 'Raise no representa suficiente y quema EV.'],
            ],
            gtoInsight: 'GTO simplificado: BvB requiere defender más ancho que en posiciones normales.',
            lowStakesInsight: 'Contra pasivos de NL2, foldea más. Contra agresivos, paga.',
            confidence: 76
        );
    }

    protected static function sbOverbetRiverNutAdvantage(): array
    {
        return self::spot(
            id: 'mastery_bvb_007',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'river_overbet_bvb',
            conceptLabel: 'Overbet River BvB',
            title: 'SB overbet river con ventaja de nuts',
            street: 'river',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Th'],
            boardCards: ['Td', '7c', '3s', '2h', 'Ac'],
            potBb: 14.0,
            spr: 5.8,
            effectiveStackBb: 82,
            boardTexture: 'River As mejora fuerte a SB',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Td 7c 3s · SB bet 33% · BB paga',
                'Turn 2h · check/check',
                'River Ac',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_125'],
            correctAction: 'BET_125',
            explanation: 'AT mejora a top two y bloquea Ax fuertes. SB puede usar overbet porque el As river favorece su rango percibido.',
            solverNote: 'Overbets aparecen cuando Hero concentra más nuts que el rival y quiere polarizar.',
            grades: [
                'BET_125' => ['grade' => 'best', 'frequency' => 45, 'ev_score' => 100, 'feedback' => 'Correcto. Polarizas con top two.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 45, 'ev_score' => 86, 'feedback' => 'Value seguro, aunque menos presión.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 35, 'feedback' => 'Pierdes mucho valor.'],
            ],
            gtoInsight: 'GTO simplificado: overbet con ventaja de nuts y manos muy fuertes.',
            lowStakesInsight: 'En micros overbet por valor funciona si el rival paga Ax/Tx demasiado. No lo conviertas en bluff excesivo.',
            confidence: 82
        );
    }

    protected static function bbFoldWeakAceVsTripleBarrel(): array
    {
        return self::spot(
            id: 'mastery_bvb_008',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'river_fold_weak_top_pair',
            conceptLabel: 'Foldear Top Pair Débil',
            title: 'BB foldea Ax débil vs triple barrel',
            street: 'river',
            heroPosition: 'BB',
            villainPosition: 'SB',
            heroCards: ['Ac', '5c'],
            boardCards: ['Ad', 'Qh', '8s', '7d', '2s'],
            potBb: 28.0,
            spr: 2.6,
            effectiveStackBb: 73,
            boardTexture: 'A-high con muchos Ax mejores',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Ad Qh 8s · SB bet 50% · BB paga',
                'Turn 7d · SB bet 75% · BB paga',
                'River 2s',
                'SB apuesta 100%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'FOLD',
            explanation: 'A5 está dominado por muchos Ax mejores y no bloquea suficiente valor. Frente a triple barrel grande, fold disciplinado.',
            solverNote: 'Top pairs débiles con mal kicker no defienden todos los rivers contra líneas grandes.',
            grades: [
                'FOLD' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Top pair débil no es call automático.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 30, 'ev_score' => 38, 'feedback' => 'Demasiado optimista contra triple barrel grande.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Raise sin blockers útiles es muy malo.'],
            ],
            gtoInsight: 'GTO simplificado: se defiende por rango, no por “tengo top pair”.',
            lowStakesInsight: 'En NL2-NL10 los triples barrels grandes suelen ser valor. Foldea tranquilo.',
            confidence: 86
        );
    }

    protected static function sbCheckRaiseFlopPairedBoard(): array
    {
        return self::spot(
            id: 'mastery_bvb_009',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'flop_check_raise_bvb',
            conceptLabel: 'Check-Raise Flop BvB',
            title: 'SB check-raise en board emparejado',
            street: 'flop',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['9h', '8h'],
            boardCards: ['8c', '8d', '3s'],
            potBb: 5.0,
            spr: 17.5,
            effectiveStackBb: 88,
            boardTexture: 'Emparejado seco',
            rangeAdvantage: 'Compartida',
            nutAdvantage: 'SB ligera',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop 8c 8d 3s',
                'SB check',
                'BB apuesta 33%',
                'Hero actúa',
            ],
            options: ['CALL', 'RAISE', 'FOLD'],
            correctAction: 'RAISE',
            explanation: 'Trips con kicker razonable quiere construir bote en BvB. Raise cobra a 8x peores, pares y floats.',
            solverNote: 'En BvB los check-raises de valor se amplían por rangos muy anchos.',
            grades: [
                'RAISE' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Construyes bote con trips.'],
                'CALL' => ['grade' => 'good', 'frequency' => 40, 'ev_score' => 84, 'feedback' => 'Call induce, pero deja valor.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Fold imposible con trips.'],
            ],
            gtoInsight: 'GTO simplificado: trips en BvB pueden raisear más fino por rangos amplios.',
            lowStakesInsight: 'En micros raise por valor. La gente no foldea pares ni 8x.',
            confidence: 88
        );
    }

    protected static function bbFloatFlopStabTurn(): array
    {
        return self::spot(
            id: 'mastery_bvb_010',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'float_stab_turn_bvb',
            conceptLabel: 'Float Flop + Stab Turn',
            title: 'BB flota flop y apuesta turn tras check',
            street: 'turn',
            heroPosition: 'BB',
            villainPosition: 'SB',
            heroCards: ['Jd', 'Td'],
            boardCards: ['Qh', '7d', '3c', '9d'],
            potBb: 8.5,
            spr: 10.7,
            effectiveStackBb: 91,
            boardTexture: 'Turn mejora equity de BB',
            rangeAdvantage: 'Compartida',
            nutAdvantage: 'BB',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Qh 7d 3c',
                'SB apuesta 33%',
                'BB paga',
                'Turn 9d',
                'SB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_100'],
            correctAction: 'BET_50',
            explanation: 'JT gana open ended y backdoor diamonds. Tras check de SB, BB puede stabear con mucha equity.',
            solverNote: 'Floats que mejoran equity en turn son buenos candidatos a bet cuando el agresor abandona.',
            grades: [
                'BET_50' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Apuestas con equity y fold equity.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 78, 'feedback' => 'Check realiza equity, pero pierde presión.'],
                'BET_100' => ['grade' => 'marginal', 'frequency' => 5, 'ev_score' => 54, 'feedback' => 'Demasiado grande para tu rango medio.'],
            ],
            gtoInsight: 'GTO simplificado: cuando el agresor checkea turn, BB puede atacar con draws fuertes.',
            lowStakesInsight: 'En NL2-NL10 apuesta medio. Muchos abandonan al fallar la cbet de turn.',
            confidence: 80
        );
    }

    protected static function sbVsBb3BetPotAkAHighFlop(): array
    {
        return self::spot(
            id: 'mastery_bvb_011',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'bvb_3bet_pot_cbet',
            conceptLabel: '3Bet Pot BvB CBet',
            title: 'SB paga 3bet · AK en A-high',
            street: 'flop',
            heroPosition: 'BB',
            villainPosition: 'SB',
            heroCards: ['Ah', 'Kd'],
            boardCards: ['As', '8c', '3d'],
            potBb: 19.0,
            spr: 4.1,
            effectiveStackBb: 78,
            boardTexture: 'A-high seco',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BB',
            actions: [
                'SB abre 3 BB',
                'BB 3bet 10 BB',
                'SB paga',
                'Flop As 8c 3d',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_33', 'BET_75'],
            correctAction: 'BET_33',
            explanation: 'AK domina muchos Ax del SB. Cbet pequeña cobra y mantiene manos peores dentro.',
            solverNote: 'En 3Bet pot BvB, top pair top kicker apuesta pequeño con frecuencia alta.',
            grades: [
                'BET_33' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Value/protección eficiente.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 20, 'ev_score' => 82, 'feedback' => 'Value posible, pero tira más peores.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 60, 'feedback' => 'Check induce, pero pierdes valor.'],
            ],
            gtoInsight: 'GTO simplificado: BvB 3Bet pots tienen rangos amplios; TPTK imprime valor.',
            lowStakesInsight: 'En micros apuesta. Te pagan Ax peores y pares curiosos.',
            confidence: 88
        );
    }

    protected static function bb3BetPotQQLowFlop(): array
    {
        return self::spot(
            id: 'mastery_bvb_012',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'bvb_3bet_pot_overpair',
            conceptLabel: 'Overpair BvB 3Bet Pot',
            title: 'BB 3bet · QQ en board bajo',
            street: 'flop',
            heroPosition: 'BB',
            villainPosition: 'SB',
            heroCards: ['Qh', 'Qd'],
            boardCards: ['9s', '5c', '2h'],
            potBb: 19.0,
            spr: 4.2,
            effectiveStackBb: 80,
            boardTexture: 'Bajo semi-seco',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BB',
            actions: [
                'SB abre 3 BB',
                'BB 3bet 10 BB',
                'SB paga',
                'Flop 9s 5c 2h',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_33', 'BET_75'],
            correctAction: 'BET_33',
            explanation: 'QQ es overpair fuerte. Bet pequeño cobra a pares peores y overcards sin aislar contra sets.',
            solverNote: 'Overpairs en 3Bet pots suelen usar sizing pequeño en boards secos.',
            grades: [
                'BET_33' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Valor y protección.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 84, 'feedback' => 'También value, pero más polar.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 58, 'feedback' => 'Das carta gratis a overcards.'],
            ],
            gtoInsight: 'GTO simplificado: en BvB los pares fuertes extraen mucho valor por rangos amplios.',
            lowStakesInsight: 'En NL2-NL10 apuesta por valor. Te pagan demasiados pares peores.',
            confidence: 87
        );
    }

    protected static function sbCalls3BetAJsFlushDraw(): array
    {
        return self::spot(
            id: 'mastery_bvb_013',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'bvb_3bet_pot_draw_defense',
            conceptLabel: 'Defensa Draw BvB 3Bet Pot',
            title: 'SB paga 3bet y liga nut flush draw',
            street: 'flop',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Jh'],
            boardCards: ['Kh', '8h', '4c'],
            potBb: 19.0,
            spr: 4.0,
            effectiveStackBb: 76,
            boardTexture: 'K-high con proyecto color',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BB ligera',
            actions: [
                'SB abre 3 BB',
                'BB 3bet 10 BB',
                'SB paga',
                'Flop Kh 8h 4c',
                'BB apuesta 33%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE_3X'],
            correctAction: 'CALL',
            explanation: 'Nut flush draw con overcard tiene demasiada equity para foldear. Call realiza bien en posición relativa contra el 3bettor.',
            solverNote: 'Nut draws mezclan call y raise; call conserva rango y evita aislarse.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Realizas equity y mantienes bluffs.'],
                'RAISE_3X' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 86, 'feedback' => 'Semi-bluff válido, pero no obligatorio.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Fold gravísimo con nut flush draw.'],
            ],
            gtoInsight: 'GTO simplificado: los nut flush draws continúan siempre frente a cbet pequeña.',
            lowStakesInsight: 'En micros call suele ser mejor porque los raises reciben demasiados calls de Kx.',
            confidence: 84
        );
    }

    protected static function bbDelayedCbetTurn(): array
    {
        return self::spot(
            id: 'mastery_bvb_014',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'bvb_delayed_cbet',
            conceptLabel: 'Delayed CBet BvB',
            title: 'BB delayed cbet turn tras check flop',
            street: 'turn',
            heroPosition: 'BB',
            villainPosition: 'SB',
            heroCards: ['Ac', 'Qc'],
            boardCards: ['Jd', '7s', '2h', 'Qd'],
            potBb: 19.0,
            spr: 4.1,
            effectiveStackBb: 78,
            boardTexture: 'Turn Q mejora al 3bettor',
            rangeAdvantage: 'BB',
            nutAdvantage: 'BB',
            actions: [
                'SB abre 3 BB',
                'BB 3bet 10 BB',
                'SB paga',
                'Flop Jd 7s 2h',
                'BB check',
                'SB check',
                'Turn Qd',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_75'],
            correctAction: 'BET_75',
            explanation: 'AQ mejora a top pair y el turn Q favorece el rango del 3bettor. Apostar fuerte cobra y protege.',
            solverNote: 'Delayed cbets aumentan tamaño cuando la carta mejora rango y mano concreta.',
            grades: [
                'BET_75' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Value claro en carta favorable.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 86, 'feedback' => 'También bien.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 42, 'feedback' => 'Pierdes valor y protección.'],
            ],
            gtoInsight: 'GTO simplificado: tras check/check flop, cartas favorables permiten recuperar iniciativa.',
            lowStakesInsight: 'En NL2-NL10 apuesta. Te pagan Jx, Qx peores y draws.',
            confidence: 85
        );
    }

    protected static function sbRiverMissedDrawBluff(): array
    {
        return self::spot(
            id: 'mastery_bvb_015',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'river_missed_draw_bluff_bvb',
            conceptLabel: 'Bluff River Draw Fallido BvB',
            title: 'SB bluffea river con draw fallido y blockers',
            street: 'river',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['Ah', '5h'],
            boardCards: ['Kh', '9h', '4c', '2d', 'Jc'],
            potBb: 20.0,
            spr: 3.7,
            effectiveStackBb: 74,
            boardTexture: 'K-high con flush fallido',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Kh 9h 4c · SB bet 50% · BB paga',
                'Turn 2d · SB bet 75% · BB paga',
                'River Jc',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_75', 'BET_125'],
            correctAction: 'BET_125',
            explanation: 'A5h falla color pero bloquea nut flush y no tiene showdown. Overbet polar presiona Kx medios y pares.',
            solverNote: 'Bluffs river se eligen con blockers relevantes y bajo showdown.',
            grades: [
                'BET_125' => ['grade' => 'best', 'frequency' => 40, 'ev_score' => 100, 'feedback' => 'Correcto. Bluff polar con blocker.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 78, 'feedback' => 'Presiona, aunque menos polar.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 55, 'feedback' => 'Rendirse es aceptable contra calling station.'],
            ],
            gtoInsight: 'GTO simplificado: los missed draws con blockers completan el rango de bluff river.',
            lowStakesInsight: 'En NL2-NL10 cuidado: contra calling station check es mejor. Contra reg que foldea, bluffea.',
            confidence: 75
        );
    }

    protected static function bbRiverValueBetTwoPair(): array
    {
        return self::spot(
            id: 'mastery_bvb_016',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'river_value_two_pair_bvb',
            conceptLabel: 'Value River Dos Pares BvB',
            title: 'BB value bet river con dobles',
            street: 'river',
            heroPosition: 'BB',
            villainPosition: 'SB',
            heroCards: ['Qd', '8d'],
            boardCards: ['Qs', '8c', '4h', '2d', '7s'],
            potBb: 18.0,
            spr: 4.3,
            effectiveStackBb: 78,
            boardTexture: 'Q-high seco',
            rangeAdvantage: 'Compartida',
            nutAdvantage: 'BB',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Qs 8c 4h · SB bet 33% · BB paga',
                'Turn 2d · check/check',
                'River 7s',
                'SB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_100'],
            correctAction: 'BET_100',
            explanation: 'Q8 tiene dobles fuertes y desbloquea calls de Qx. Apuesta grande por valor contra top pair y bluffcatchers.',
            solverNote: 'Dos pares en rangos amplios BvB pueden valuebetear grande.',
            grades: [
                'BET_100' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Value grande.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 84, 'feedback' => 'Valor seguro, pero menos EV.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 18, 'feedback' => 'Pierdes muchísimo valor.'],
            ],
            gtoInsight: 'GTO simplificado: en BvB las dobles ganan mucho valor porque top pairs pagan más.',
            lowStakesInsight: 'En NL2-NL10 apuesta grande. Qx paga demasiado.',
            confidence: 88
        );
    }

    protected static function sbLowSprTurnJamTopPair(): array
    {
        return self::spot(
            id: 'mastery_bvb_017',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'low_spr_turn_jam_bvb',
            conceptLabel: 'Jam Turn SPR Bajo BvB',
            title: 'SB jam turn con top pair en 3Bet pot',
            street: 'turn',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['Ac', 'Qs'],
            boardCards: ['Qh', '8d', '3s', '4c'],
            potBb: 34.0,
            spr: 1.5,
            effectiveStackBb: 52,
            boardTexture: 'Q-high seco',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'Compartida',
            actions: [
                'SB abre 3 BB',
                'BB 3bet 10 BB',
                'SB paga',
                'Flop Qh 8d 3s · BB bet 33% · SB paga',
                'Turn 4c',
                'BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'AQ es top pair top kicker y el SPR es bajo. Tras check de BB, jam cobra a Qx peores, JJ-TT y niega equity.',
            solverNote: 'En SPR bajo, TPTK puede jugar por stacks en turns seguros.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Valor/protección.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 84, 'feedback' => 'También valor, pero deja poco detrás.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 38, 'feedback' => 'Demasiado pasivo con TPTK.'],
            ],
            gtoInsight: 'GTO simplificado: con SPR bajo el valor de top pair fuerte aumenta mucho.',
            lowStakesInsight: 'En micros jam es value claro. Pagan QJ/KQ y pares.',
            confidence: 86
        );
    }

    protected static function bbCheckRaiseRiverPolar(): array
    {
        return self::spot(
            id: 'mastery_bvb_018',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'river_check_raise_polar_bvb',
            conceptLabel: 'Check-Raise River Polar',
            title: 'BB check-raise river polar con nuts',
            street: 'river',
            heroPosition: 'BB',
            villainPosition: 'SB',
            heroCards: ['6h', '5h'],
            boardCards: ['Kh', '8c', '4h', '2d', '7s'],
            potBb: 22.0,
            spr: 3.4,
            effectiveStackBb: 75,
            boardTexture: 'Escalera completada river',
            rangeAdvantage: 'SB',
            nutAdvantage: 'BB',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Kh 8c 4h · SB bet 50% · BB paga',
                'Turn 2d · check/check',
                'River 7s',
                'BB check',
                'SB apuesta 75%',
                'Hero actúa',
            ],
            options: ['CALL', 'RAISE', 'FOLD'],
            correctAction: 'RAISE',
            explanation: '65 hace escalera y BB tiene más combos de 65 que SB. Raise polar extrae valor de Kx fuertes y dobles.',
            solverNote: 'Cuando el river mejora una parte exclusiva del rango de BB, el check-raise gana frecuencia.',
            grades: [
                'RAISE' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Nuts y ventaja de nuts.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 30, 'ev_score' => 52, 'feedback' => 'Demasiado pasivo con nuts.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Fold imposible.'],
            ],
            gtoInsight: 'GTO simplificado: check-raise river necesita ventaja de nuts y valor suficiente.',
            lowStakesInsight: 'En micros raise grande por valor. Te pagan Kx más de lo correcto.',
            confidence: 90
        );
    }

    protected static function sbDonkTurnPairedBoard(): array
    {
        return self::spot(
            id: 'mastery_bvb_019',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'turn_donk_bvb',
            conceptLabel: 'Donk Turn BvB',
            title: 'SB donk turn en carta que empareja',
            street: 'turn',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['8h', '7h'],
            boardCards: ['Jc', '8d', '3s', '8c'],
            potBb: 7.0,
            spr: 12.0,
            effectiveStackBb: 84,
            boardTexture: 'Turn empareja segunda carta',
            rangeAdvantage: 'Compartida',
            nutAdvantage: 'SB',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Jc 8d 3s',
                'SB check',
                'BB check',
                'Turn 8c',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_100'],
            correctAction: 'BET_100',
            explanation: 'Hero liga trips y la carta mejora mucho su rango de check flop. Bet grande cobra a Jx, 8x peores y pares.',
            solverNote: 'Donks/probes aparecen cuando la carta cambia la ventaja de nuts tras check/check.',
            grades: [
                'BET_100' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Valor grande con trips.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 84, 'feedback' => 'Value seguro, pero menos EV.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 40, 'feedback' => 'Pierdes valor en una carta excelente.'],
            ],
            gtoInsight: 'GTO simplificado: cuando una carta favorece tu rango tras pasividad, puedes liderar.',
            lowStakesInsight: 'En NL2-NL10 apuesta fuerte. Jx y pares pagan mucho.',
            confidence: 85
        );
    }

    protected static function bbHeroCallRiverBlockers(): array
    {
        return self::spot(
            id: 'mastery_bvb_020',
            module: 'blind_vs_blind_advanced',
            moduleLabel: 'Blind vs Blind Advanced',
            concept: 'hero_call_blockers_bvb',
            conceptLabel: 'Hero Call con Blockers BvB',
            title: 'BB hero call river con blocker clave',
            street: 'river',
            heroPosition: 'BB',
            villainPosition: 'SB',
            heroCards: ['Ah', '9c'],
            boardCards: ['Kh', '9h', '4c', '2d', 'Jd'],
            potBb: 24.0,
            spr: 3.0,
            effectiveStackBb: 72,
            boardTexture: 'K-high con missed hearts',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB',
            actions: [
                'SB abre 3 BB',
                'BB paga',
                'Flop Kh 9h 4c · SB bet 50% · BB paga',
                'Turn 2d · SB bet 75% · BB paga',
                'River Jd',
                'SB apuesta 100%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'CALL',
            explanation: 'A9 bloquea missed nut hearts y tiene par medio. En BvB contra rival agresivo, es candidato razonable a bluffcatch.',
            solverNote: 'Los bluffcatchers prefieren bloquear bluffs menos relevantes y desbloquear faroles; aquí el Ah bloquea parte del valor de hearts pero también reduce bluffs, por eso no es call puro.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 45, 'ev_score' => 100, 'feedback' => 'Correcto contra perfil agresivo.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 45, 'ev_score' => 82, 'feedback' => 'Exploit contra pasivo es fold.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 12, 'feedback' => 'Raise sin valor ni blockers suficientes es malo.'],
            ],
            gtoInsight: 'GTO simplificado: los hero calls en BvB dependen mucho de blockers y frecuencia rival.',
            lowStakesInsight: 'En NL2-NL10 foldea más contra pasivos. Paga solo contra agresivos reales.',
            confidence: 74
        );
    }
}
