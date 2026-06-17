<?php

namespace App\SpotTraining\Mastery\Modules;

use App\SpotTraining\Mastery\Concerns\BuildsMasterySpots;

class TournamentSpots
{
    use BuildsMasterySpots;

    public static function all(): array
    {
        return [
            self::btnTwelveBbJamAto(),
            self::coFourteenBbJam55(),
            self::sbTenBbJamK9s(),
            self::btnEighteenBbRestealA5s(),
            self::bbCallVsBtnJamAqo(),
            self::mpTwentyBbOpenFoldKjo(),
            self::coTwentyFiveBbThreeBetJamAqs(),
            self::bbDefenseVsBtnTwentyBb(),
            self::flopCbetLowSprTourney(),
            self::turnJamTopPairTourney(),
            self::bubbleBigStackPressure(),
            self::bubbleMediumStackFoldAjo(),
            self::bubbleShortStackPushKTs(),
            self::btnBubbleAbuseQ9s(),
            self::sbVsBbBubbleJamA7s(),
            self::finalTableLadderFoldA9o(),
            self::finalTableShortStackReshove66(),
            self::finalTableBigStackAttackK5s(),
            self::finalTableCallOffJJ(),
            self::headsUpFifteenBbJamQTs(),
        ];
    }

    protected static function btnTwelveBbJamAto(): array
    {
        return self::spot(
            id: 'mastery_tourney_001',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'open_jam_12bb',
            conceptLabel: 'Open Jam 12 BB',
            title: 'BTN 12 BB · ATo open jam',
            street: 'preflop',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Td'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 12,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'Todos foldean hasta BTN',
                'Hero tiene 12 BB',
                'SB tiene 18 BB',
                'BB tiene 22 BB',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: 'Con 12 BB en BTN, ATo es demasiado fuerte para foldear y no quiere raise/fold. Open jam maximiza fold equity y realiza toda la equity.',
            solverNote: 'En stacks de 10-14 BB, muchos Ax offsuit fuertes entran en rango de open jam desde BTN.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 85, 'ev_score' => 100, 'feedback' => 'Correcto. Jam rentable con 12 BB.'],
                'RAISE_2_5X' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 58, 'feedback' => 'Raise/fold con 12 BB es incómodo.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Fold demasiado nit con ATo en BTN.'],
            ],
            gtoInsight: 'GTO simplificado: con 12 BB, BTN prioriza shove directo con manos que tienen blockers y buena equity.',
            lowStakesInsight: 'En torneos micro, jam es aún mejor porque las ciegas foldean demasiado y no defienden perfecto.',
            confidence: 88
        );
    }

    protected static function coFourteenBbJam55(): array
    {
        return self::spot(
            id: 'mastery_tourney_002',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'open_jam_small_pair',
            conceptLabel: 'Open Jam Pareja Media/Baja',
            title: 'CO 14 BB · 55 open jam',
            street: 'preflop',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['5h', '5d'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 14,
            boardTexture: 'Sin board',
            rangeAdvantage: 'CO',
            nutAdvantage: 'Compartida',
            actions: [
                'Todos foldean hasta CO',
                'Hero tiene 14 BB',
                'BTN/SB/BB cubren a Hero',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: '55 tiene mucha equity cuando paga alguien, pero juega mal postflop con stack corto. Jam captura fold equity y evita decisiones difíciles.',
            solverNote: 'Parejas bajas-medias entre 12-15 BB suelen preferir open jam desde CO/BTN en muchos escenarios.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Shove simple y rentable.'],
                'RAISE_2_5X' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Abres la puerta a 3bet jam y spots incómodos.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 35, 'feedback' => 'Fold demasiado tight con 55 en CO.'],
            ],
            gtoInsight: 'GTO simplificado: las parejas pequeñas ganan mucho empujando fold equity preflop.',
            lowStakesInsight: 'En freerolls/micros, jam funciona bien porque muchos foldean demasiado sus ciegas.',
            confidence: 82
        );
    }

    protected static function sbTenBbJamK9s(): array
    {
        return self::spot(
            id: 'mastery_tourney_003',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'sb_push_fold_10bb',
            conceptLabel: 'SB Push/Fold 10 BB',
            title: 'SB 10 BB · K9s contra BB',
            street: 'preflop',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['Ks', '9s'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 10,
            boardTexture: 'Sin board',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB',
            actions: [
                'Todos foldean hasta SB',
                'Hero tiene 10 BB',
                'BB tiene 16 BB',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: 'SB contra BB con 10 BB es spot claro de push/fold. K9s tiene suficiente equity y fold equity para jam.',
            solverNote: 'SB puede pushear muy amplio con 10 BB cuando sólo queda BB por hablar.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 90, 'ev_score' => 100, 'feedback' => 'Correcto. Jam estándar SB vs BB.'],
                'RAISE_2_5X' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 36, 'feedback' => 'Con 10 BB no quieres raise/fold.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 8, 'feedback' => 'Fold demasiado nit.'],
            ],
            gtoInsight: 'GTO simplificado: SB shortstack pushea amplio por fold equity y posición relativa.',
            lowStakesInsight: 'En torneos bajos, BB foldea demasiadas manos; jam gana aún más.',
            confidence: 90
        );
    }

    protected static function btnEighteenBbRestealA5s(): array
    {
        return self::spot(
            id: 'mastery_tourney_004',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'resteal_18bb',
            conceptLabel: 'Resteal 18 BB',
            title: 'BTN 18 BB · A5s resteal vs CO',
            street: 'preflop',
            heroPosition: 'BTN',
            villainPosition: 'CO',
            heroCards: ['As', '5s'],
            boardCards: [],
            potBb: 5.0,
            spr: 0.0,
            effectiveStackBb: 18,
            boardTexture: 'Sin board',
            rangeAdvantage: 'CO opener',
            nutAdvantage: 'Compartida',
            actions: [
                'CO abre 2.2 BB',
                'Hero está en BTN con 18 BB',
                'SB y BB tienen stacks medios',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'JAM'],
            correctAction: 'JAM',
            explanation: 'A5s bloquea Ax fuertes y tiene buena equity cuando paga. Con 18 BB, jam presiona mucho al rango de open de CO.',
            solverNote: 'Axs bajos son buenos resteals por blocker y jugabilidad cuando reciben call.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Buen resteal con blocker.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 76, 'feedback' => 'Fold puede valer contra CO muy tight.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 40, 'feedback' => 'Call con 18 BB invita squeeze y juega mal SPR.'],
            ],
            gtoInsight: 'GTO simplificado: los resteals shortstack prefieren blockers y fold equity.',
            lowStakesInsight: 'Contra jugadores que abren demasiado CO y foldean a jam, este movimiento imprime fichas.',
            confidence: 80
        );
    }

    protected static function bbCallVsBtnJamAqo(): array
    {
        return self::spot(
            id: 'mastery_tourney_005',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'bb_call_vs_btn_jam',
            conceptLabel: 'BB Call vs BTN Jam',
            title: 'BB enfrenta jam BTN 13 BB con AQo',
            street: 'preflop',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Ad', 'Qc'],
            boardCards: [],
            potBb: 15.5,
            spr: 0.0,
            effectiveStackBb: 13,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN amplio',
            nutAdvantage: 'BB por mano concreta',
            actions: [
                'Todos foldean hasta BTN',
                'BTN jam 13 BB',
                'SB foldea',
                'Hero está en BB con AQo',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL'],
            correctAction: 'CALL',
            explanation: 'BTN pushea amplio con 13 BB. AQo domina muchas manos del rango de jam y tiene equity suficiente para pagar.',
            solverNote: 'AQo es call claro contra jams amplios de BTN en stacks cortos.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 90, 'ev_score' => 100, 'feedback' => 'Correcto. AQo domina demasiado rango.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 10, 'ev_score' => 18, 'feedback' => 'Fold demasiado nit contra BTN.'],
            ],
            gtoInsight: 'GTO simplificado: contra jam BTN, BB debe pagar manos fuertes de Ax y broadways premium.',
            lowStakesInsight: 'En micros muchos BTN pushean peor que GTO. AQo gana muchísimo.',
            confidence: 89
        );
    }

    protected static function mpTwentyBbOpenFoldKjo(): array
    {
        return self::spot(
            id: 'mastery_tourney_006',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'open_fold_20bb',
            conceptLabel: 'Open/Fold 20 BB',
            title: 'MP 20 BB · KJo contra mesa agresiva',
            street: 'preflop',
            heroPosition: 'HJ',
            villainPosition: 'BB',
            heroCards: ['Kh', 'Jd'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 20,
            boardTexture: 'Sin board',
            rangeAdvantage: 'HJ si abre',
            nutAdvantage: 'Compartida',
            actions: [
                'Hero tiene 20 BB en HJ',
                'CO/BTN son agresivos con resteal',
                'Ciegas cubren a Hero',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'FOLD',
            explanation: 'KJo en HJ con 20 BB y jugadores agresivos detrás es marginal. Abre/fold queda explotable y jam es demasiado grande. Fold conserva stack.',
            solverNote: 'KJo offsuit pierde valor en posiciones medias con stacks de resteal detrás.',
            grades: [
                'FOLD' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Evitas spot dominado.'],
                'RAISE_2_5X' => ['grade' => 'marginal', 'frequency' => 35, 'ev_score' => 62, 'feedback' => 'Puede abrirse en mesa pasiva, no contra agresivos.'],
                'JAM' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 32, 'feedback' => 'Jam 20 BB con KJo es demasiado grande.'],
            ],
            gtoInsight: 'GTO simplificado: offsuit broadways dominados deben cuidarse con 18-25 BB.',
            lowStakesInsight: 'Si la mesa es pasiva puedes abrir; si hay resteals, fold es mejor.',
            confidence: 76
        );
    }

    protected static function coTwentyFiveBbThreeBetJamAqs(): array
    {
        return self::spot(
            id: 'mastery_tourney_007',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'threebet_jam_25bb',
            conceptLabel: '3Bet Jam 25 BB',
            title: 'CO 25 BB · AQs 3bet jam vs HJ',
            street: 'preflop',
            heroPosition: 'CO',
            villainPosition: 'HJ',
            heroCards: ['Ah', 'Qh'],
            boardCards: [],
            potBb: 5.0,
            spr: 0.0,
            effectiveStackBb: 25,
            boardTexture: 'Sin board',
            rangeAdvantage: 'HJ opener',
            nutAdvantage: 'CO por blockers',
            actions: [
                'HJ abre 2.2 BB',
                'Hero tiene 25 BB en CO',
                'BTN/SB/BB por hablar',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'JAM'],
            correctAction: 'JAM',
            explanation: 'AQs tiene blockers, domina opens peores y evita jugar multiway. Con 25 BB, 3bet jam presiona mucho y realiza equity.',
            solverNote: 'AQs es candidato fuerte a 3bet jam contra opens de posiciones medias cuando hay stacks de resteal.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Jam fuerte y rentable.'],
                'CALL' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 78, 'feedback' => 'Call es posible, pero invita squeezes.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 8, 'feedback' => 'Fold demasiado nit con AQs.'],
            ],
            gtoInsight: 'GTO simplificado: AQs combina equity, blockers y jugabilidad excelente.',
            lowStakesInsight: 'En torneos bajos, jam evita errores postflop y castiga opens amplios.',
            confidence: 84
        );
    }

    protected static function bbDefenseVsBtnTwentyBb(): array
    {
        return self::spot(
            id: 'mastery_tourney_008',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'bb_defense_20bb',
            conceptLabel: 'Defensa BB 20 BB',
            title: 'BB 20 BB defiende KTs vs BTN minraise',
            street: 'preflop',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Ks', 'Ts'],
            boardCards: [],
            potBb: 4.5,
            spr: 4.4,
            effectiveStackBb: 20,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN amplio',
            nutAdvantage: 'Compartida',
            actions: [
                'Todos foldean hasta BTN',
                'BTN abre 2 BB',
                'SB foldea',
                'Hero está en BB con 20 BB',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'JAM'],
            correctAction: 'CALL',
            explanation: 'KTs juega bien contra rango amplio de BTN y tiene buen precio en BB. Jam puede ser rentable a veces, pero call conserva manos dominadas dentro.',
            solverNote: 'BB defiende suited broadways con alta frecuencia contra minraise BTN.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Defiendes por precio y jugabilidad.'],
                'JAM' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 82, 'feedback' => 'Resteal viable contra BTN que foldea mucho.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 30, 'feedback' => 'Fold demasiado tight por precio.'],
            ],
            gtoInsight: 'GTO simplificado: BB defiende más ancho contra minraise por odds.',
            lowStakesInsight: 'En micros, call y juega sencillo postflop; no sobrefoldees BB.',
            confidence: 83
        );
    }

    protected static function flopCbetLowSprTourney(): array
    {
        return self::spot(
            id: 'mastery_tourney_009',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'flop_cbet_low_spr_tourney',
            conceptLabel: 'CBet SPR Bajo Torneo',
            title: '20 BB effective · AQ top pair en flop',
            street: 'flop',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Qd'],
            boardCards: ['Qs', '8c', '3h'],
            potBb: 5.0,
            spr: 3.6,
            effectiveStackBb: 18,
            boardTexture: 'Q-high seco',
            rangeAdvantage: 'CO',
            nutAdvantage: 'CO',
            actions: [
                'CO abre 2.2 BB con 20 BB',
                'BB paga',
                'Flop Qs 8c 3h',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_33', 'JAM'],
            correctAction: 'BET_33',
            explanation: 'Con TPTK y SPR bajo, apuesta pequeña mantiene manos peores y prepara stack-off en calles futuras. Jam espanta demasiadas manos.',
            solverNote: 'En torneos con SPR bajo, sizings pequeños comprometen sin polarizar demasiado.',
            grades: [
                'BET_33' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Value eficiente.'],
                'JAM' => ['grade' => 'marginal', 'frequency' => 15, 'ev_score' => 60, 'feedback' => 'Demasiado grande en flop seco.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 15, 'ev_score' => 42, 'feedback' => 'Pierdes valor/protección.'],
            ],
            gtoInsight: 'GTO simplificado: en SPR bajo, no hace falta apostar grande para comprometer stacks.',
            lowStakesInsight: 'En torneos bajos, bet pequeño induce calls de peores.',
            confidence: 86
        );
    }

    protected static function turnJamTopPairTourney(): array
    {
        return self::spot(
            id: 'mastery_tourney_010',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'turn_jam_tourney',
            conceptLabel: 'Jam Turn Torneo',
            title: 'Top pair top kicker jam turn con SPR 1',
            street: 'turn',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['As', 'Kh'],
            boardCards: ['Kd', '9c', '4h', '2s'],
            potBb: 11.0,
            spr: 1.0,
            effectiveStackBb: 11,
            boardTexture: 'K-high seco',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'BTN abre 2 BB con 18 BB',
                'BB paga',
                'Flop Kd 9c 4h · BTN bet 33% · BB paga',
                'Turn 2s',
                'BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'Con SPR 1 y TPTK en turn seguro, jam cobra a Kx peores, 9x tercos y draws mínimos. Check pierde valor.',
            solverNote: 'SPR cercano a 1 convierte top pair top kicker en mano de stack-off en muchos turns seguros.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Valor/protección.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 84, 'feedback' => 'También compromete, aunque deja poco detrás.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 32, 'feedback' => 'Demasiado pasivo.'],
            ],
            gtoInsight: 'GTO simplificado: en torneos, SPR bajo simplifica decisiones de valor.',
            lowStakesInsight: 'En micros, jam: te pagan Kx peores demasiado.',
            confidence: 88
        );
    }

    protected static function bubbleBigStackPressure(): array
    {
        return self::spot(
            id: 'mastery_tourney_011',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'bubble_big_stack_pressure',
            conceptLabel: 'Presión Big Stack Bubble',
            title: 'Bubble · Big stack presiona BTN',
            street: 'preflop',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Qh', '9h'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 24,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN big stack',
            nutAdvantage: 'BTN por presión',
            actions: [
                'Burbuja de premios',
                'Hero es big stack en BTN',
                'SB tiene 15 BB',
                'BB tiene 24 BB y no quiere bustear',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'RAISE_2_5X',
            explanation: 'Como big stack en burbuja, Hero puede abrir amplio y presionar stacks medios. Q9s es buen open; jam no hace falta con 24 BB efectivos.',
            solverNote: 'Big stack aplica presión ICM abriendo más contra stacks que no quieren bustear.',
            grades: [
                'RAISE_2_5X' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Presión sin arriesgar de más.'],
                'JAM' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 58, 'feedback' => 'Demasiado grande con 24 BB.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 40, 'feedback' => 'Demasiado pasivo como big stack.'],
            ],
            gtoInsight: 'GTO simplificado: en burbuja, big stack gana EV presionando rangos capped.',
            lowStakesInsight: 'En torneos bajos la gente sobre-foldea burbuja. Roba más.',
            confidence: 82
        );
    }

    protected static function bubbleMediumStackFoldAjo(): array
    {
        return self::spot(
            id: 'mastery_tourney_012',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'bubble_medium_stack_survival',
            conceptLabel: 'Medium Stack Bubble',
            title: 'Bubble · Medium stack foldea AJo vs big stack',
            street: 'preflop',
            heroPosition: 'CO',
            villainPosition: 'BTN',
            heroCards: ['Ad', 'Jh'],
            boardCards: [],
            potBb: 6.0,
            spr: 0.0,
            effectiveStackBb: 22,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN big stack',
            nutAdvantage: 'BTN por presión',
            actions: [
                'Burbuja de premios',
                'Hero tiene 22 BB en CO',
                'BTN big stack 80 BB',
                'Hero abre 2.2 BB',
                'BTN 3bet jam cubriendo a Hero',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL'],
            correctAction: 'FOLD',
            explanation: 'AJo parece fuerte, pero en burbuja contra big stack que cubre, el coste de bustear es alto. Sin reads de abuso extremo, fold es correcto.',
            solverNote: 'ICM reduce rangos de call-off de stacks medios frente a presión de big stack.',
            grades: [
                'FOLD' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Conservas stack en burbuja.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 30, 'ev_score' => 34, 'feedback' => 'Call demasiado ligero por ICM.'],
            ],
            gtoInsight: 'GTO simplificado: los stacks medios deben evitar bustear light en burbuja.',
            lowStakesInsight: 'En micros muchos big stacks no farolean suficiente all-in. Foldea más.',
            confidence: 84
        );
    }

    protected static function bubbleShortStackPushKTs(): array
    {
        return self::spot(
            id: 'mastery_tourney_013',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'bubble_short_stack_push',
            conceptLabel: 'Short Stack Bubble Push',
            title: 'Bubble · Short stack 7 BB con KTs',
            street: 'preflop',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['Kh', 'Th'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 7,
            boardTexture: 'Sin board',
            rangeAdvantage: 'CO',
            nutAdvantage: 'CO',
            actions: [
                'Burbuja de premios',
                'Hero tiene 7 BB',
                'Todos foldean hasta CO',
                'BTN/SB/BB tienen stacks medios',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: 'Con 7 BB no hay margen para esperar demasiado. KTs tiene buena equity y blockers. Jam busca fold equity antes de quedar sin stack.',
            solverNote: 'Short stacks en burbuja aún deben tomar spots rentables de push si el stack cae demasiado.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 75, 'ev_score' => 100, 'feedback' => 'Correcto. Push necesario.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Puede sobrevivir, pero pierdes fold equity.'],
                'RAISE_2_5X' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 10, 'feedback' => 'Raise/fold con 7 BB no existe.'],
            ],
            gtoInsight: 'GTO simplificado: los short stacks no pueden esperar siempre; pierden fold equity.',
            lowStakesInsight: 'En freerolls la gente espera demasiado la burbuja. Jam gana muchas ciegas.',
            confidence: 82
        );
    }

    protected static function btnBubbleAbuseQ9s(): array
    {
        return self::spot(
            id: 'mastery_tourney_014',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'btn_bubble_abuse',
            conceptLabel: 'Abuso BTN en Burbuja',
            title: 'BTN presiona burbuja con Q9s',
            street: 'preflop',
            heroPosition: 'BTN',
            villainPosition: 'SB',
            heroCards: ['Qs', '9s'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 18,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN por presión',
            actions: [
                'Burbuja de premios',
                'Hero está en BTN con 35 BB',
                'SB tiene 18 BB',
                'BB tiene 16 BB',
                'Ambos quieren entrar en premios',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'RAISE_2_5X',
            explanation: 'Q9s es open rentable en BTN cuando las ciegas están presionadas por burbuja. Raise pequeño arriesga poco y roba mucho.',
            solverNote: 'Presión ICM permite abrir más manos como big stack o stack cómodo.',
            grades: [
                'RAISE_2_5X' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Robas con presión ICM.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 42, 'feedback' => 'Demasiado pasivo en BTN.'],
                'JAM' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 60, 'feedback' => 'Jam arriesga más de lo necesario.'],
            ],
            gtoInsight: 'GTO simplificado: en burbuja, los opens pequeños castigan rangos de defensa muy tight.',
            lowStakesInsight: 'En torneos bajos la burbuja se sobre-foldea. Roba mucho desde BTN.',
            confidence: 83
        );
    }

    protected static function sbVsBbBubbleJamA7s(): array
    {
        return self::spot(
            id: 'mastery_tourney_015',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'sb_vs_bb_bubble',
            conceptLabel: 'SB vs BB Bubble',
            title: 'SB vs BB burbuja · A7s con 11 BB',
            street: 'preflop',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['As', '7s'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 11,
            boardTexture: 'Sin board',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB',
            actions: [
                'Burbuja de premios',
                'Todos foldean hasta SB',
                'Hero tiene 11 BB',
                'BB tiene 14 BB',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: 'A7s SB vs BB con 11 BB es jam claro. Tiene blocker, equity y mucha fold equity incluso en burbuja.',
            solverNote: 'SB puede empujar Ax suited con alta frecuencia en stacks cortos.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 85, 'ev_score' => 100, 'feedback' => 'Correcto. Jam estándar.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 36, 'feedback' => 'Demasiado tight.'],
                'RAISE_2_5X' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 30, 'feedback' => 'Raise/fold con 11 BB no es ideal.'],
            ],
            gtoInsight: 'GTO simplificado: SB shortstack usa jam para negar equity y capturar ciegas.',
            lowStakesInsight: 'En micros BB foldea demasiado por burbuja. Jam imprime EV.',
            confidence: 88
        );
    }

    protected static function finalTableLadderFoldA9o(): array
    {
        return self::spot(
            id: 'mastery_tourney_016',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'final_table_ladder_pressure',
            conceptLabel: 'Final Table Ladder Pressure',
            title: 'Mesa final · A9o vs jam de big stack',
            street: 'preflop',
            heroPosition: 'HJ',
            villainPosition: 'BTN',
            heroCards: ['Ad', '9c'],
            boardCards: [],
            potBb: 5.0,
            spr: 0.0,
            effectiveStackBb: 18,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN big stack',
            nutAdvantage: 'BTN por presión',
            actions: [
                'Mesa final',
                'Hero tiene 18 BB',
                'Hay dos stacks de 5 BB',
                'Hero abre 2.2 BB en HJ',
                'BTN big stack jam cubriendo',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL'],
            correctAction: 'FOLD',
            explanation: 'A9o está dominado y hay presión de saltos de premios con dos shorts. Call off sería demasiado ligero en mesa final.',
            solverNote: 'ICM endurece mucho los calls de stacks medios cuando hay shorts vivos.',
            grades: [
                'FOLD' => ['grade' => 'best', 'frequency' => 80, 'ev_score' => 100, 'feedback' => 'Correcto. Fold por presión ICM.'],
                'CALL' => ['grade' => 'blunder', 'frequency' => 20, 'ev_score' => 18, 'feedback' => 'Call demasiado ligero en mesa final.'],
            ],
            gtoInsight: 'GTO simplificado: en final table, stacks medios deben evitar bustear antes que shorts.',
            lowStakesInsight: 'En torneos bajos, el big stack suele tener valor cuando mete all-in grande. Foldea.',
            confidence: 86
        );
    }

    protected static function finalTableShortStackReshove66(): array
    {
        return self::spot(
            id: 'mastery_tourney_017',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'final_table_short_reshove',
            conceptLabel: 'Short Stack Reshove Final Table',
            title: 'Mesa final · Short stack reshove 66',
            street: 'preflop',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['6h', '6d'],
            boardCards: [],
            potBb: 5.5,
            spr: 0.0,
            effectiveStackBb: 9,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN amplio',
            nutAdvantage: 'Compartida',
            actions: [
                'Mesa final',
                'Hero tiene 9 BB en BB',
                'BTN abre 2 BB',
                'SB foldea',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'JAM'],
            correctAction: 'JAM',
            explanation: 'Con 9 BB, 66 contra open amplio de BTN es reshove claro. Call deja SPR incómodo y fold desperdicia equity.',
            solverNote: 'Short stacks convierten muchas parejas en reshove por fold equity y equity realizable.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 75, 'ev_score' => 100, 'feedback' => 'Correcto. Reshove estándar.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 15, 'ev_score' => 36, 'feedback' => 'Call OOP con 9 BB no tiene sentido.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 55, 'feedback' => 'Muy tight, salvo ICM extremo.'],
            ],
            gtoInsight: 'GTO simplificado: parejas con 8-12 BB prefieren jam frente a opens tardíos.',
            lowStakesInsight: 'En torneos bajos, BTN abre demasiado. Jam con 66 gana mucho.',
            confidence: 84
        );
    }

    protected static function finalTableBigStackAttackK5s(): array
    {
        return self::spot(
            id: 'mastery_tourney_018',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'final_table_big_stack_attack',
            conceptLabel: 'Big Stack Attack Final Table',
            title: 'Mesa final · Big stack presiona SB vs BB',
            street: 'preflop',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['Ks', '5s'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 16,
            boardTexture: 'Sin board',
            rangeAdvantage: 'SB big stack',
            nutAdvantage: 'SB por presión',
            actions: [
                'Mesa final',
                'Hero es big stack en SB',
                'BB tiene 16 BB',
                'Hay dos shorts de 6 BB',
                'Todos foldean hasta SB',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'RAISE_2_5X',
            explanation: 'K5s es open rentable como big stack presionando BB que no quiere bustear antes que shorts. Raise pequeño arriesga poco.',
            solverNote: 'Big stack final table presiona a stacks medios sin tener que ir all-in con todo.',
            grades: [
                'RAISE_2_5X' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Presión ICM eficiente.'],
                'JAM' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 62, 'feedback' => 'Jam puede ser excesivo con 16 BB efectivos.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 15, 'ev_score' => 40, 'feedback' => 'Demasiado pasivo como big stack.'],
            ],
            gtoInsight: 'GTO simplificado: big stack no necesita arriesgar de más; puede abrir pequeño y forzar folds.',
            lowStakesInsight: 'En micros, los stacks medios se asustan mucho por los saltos. Ataca.',
            confidence: 80
        );
    }

    protected static function finalTableCallOffJJ(): array
    {
        return self::spot(
            id: 'mastery_tourney_019',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'final_table_calloff_premium',
            conceptLabel: 'Call Off Premium Final Table',
            title: 'Mesa final · JJ vs reshove 18 BB',
            street: 'preflop',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['Jh', 'Jc'],
            boardCards: [],
            potBb: 23.0,
            spr: 0.0,
            effectiveStackBb: 18,
            boardTexture: 'Sin board',
            rangeAdvantage: 'CO opener',
            nutAdvantage: 'CO por mano concreta',
            actions: [
                'Mesa final',
                'Hero tiene 32 BB en CO',
                'BB tiene 18 BB',
                'Hero abre 2.2 BB',
                'BB reshove 18 BB',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL'],
            correctAction: 'CALL',
            explanation: 'JJ es demasiado fuerte para foldear frente a reshove de 18 BB de BB contra CO. Domina muchas parejas y broadways.',
            solverNote: 'Aunque ICM aprieta calls, JJ suele seguir siendo call frente a reshoves razonables.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 80, 'ev_score' => 100, 'feedback' => 'Correcto. JJ es premium aquí.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 35, 'feedback' => 'Fold demasiado tight con JJ.'],
            ],
            gtoInsight: 'GTO simplificado: ICM no significa foldear premiums. Hay manos que siguen siendo call.',
            lowStakesInsight: 'En torneos bajos, reshove de BB puede ser mucho peor que JJ. Paga.',
            confidence: 87
        );
    }

    protected static function headsUpFifteenBbJamQTs(): array
    {
        return self::spot(
            id: 'mastery_tourney_020',
            module: 'tournament_lab',
            moduleLabel: 'Tournament Lab',
            concept: 'heads_up_15bb_push',
            conceptLabel: 'Heads-Up 15 BB Push',
            title: 'Heads-up · SB 15 BB con QTs',
            street: 'preflop',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['Qh', 'Th'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 15,
            boardTexture: 'Sin board',
            rangeAdvantage: 'SB',
            nutAdvantage: 'Compartida',
            actions: [
                'Heads-up',
                'Hero está en SB/Button con 15 BB',
                'BB cubre ligeramente',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: 'QTs tiene mucha equity y jugabilidad. Con 15 BB heads-up, jam es rentable y evita jugar OOP postflop si recibe call.',
            solverNote: 'Heads-up shortstack amplía rangos de push por ausencia de jugadores detrás.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Shove rentable HU.'],
                'RAISE_2_5X' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Minraise también puede usarse con estrategia mixta.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Fold imposible heads-up con QTs.'],
            ],
            gtoInsight: 'GTO simplificado: heads-up se juegan rangos muchísimo más amplios.',
            lowStakesInsight: 'En HU de torneos bajos, la gente foldea demasiado a jams de 12-16 BB.',
            confidence: 85
        );
    }
}
