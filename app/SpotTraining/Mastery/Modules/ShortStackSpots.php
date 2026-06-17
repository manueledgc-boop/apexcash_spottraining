<?php

namespace App\SpotTraining\Mastery\Modules;

use App\SpotTraining\Mastery\Concerns\BuildsMasterySpots;

class ShortStackSpots
{
    use BuildsMasterySpots;

    public static function all(): array
    {
        return [
            self::btn15BbPushAJs(),
            self::co12BbPush77(),
            self::sb10BbJamKQs(),
            self::btn18BbRestealA5s(),
            self::bbCallOff20BbTT(),
            self::sb14BbPush66(),
            self::co16BbJamAQo(),
            self::btn13BbPushKJs(),
            self::hj15BbJamATs(),
            self::sb12BbPushA8s(),
            self::spr2TopPair(),
            self::overpairLowSpr(),
            self::nutFlushDrawLowSpr(),
            self::pairPlusDrawJam(),
            self::turnBarrelSpr1(),
            self::topPairTurnJam(),
            self::comboDrawJam(),
            self::overpairCommitment(),
            self::riverBluffCatcher(),
            self::allInRiverValue(),
        ];
    }

    protected static function btn15BbPushAJs(): array
    {
        return self::spot(
            id: 'mastery_ss_001',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'open_jam_15bb',
            conceptLabel: 'Open Jam 15 BB',
            title: 'BTN 15 BB · AJs open jam',
            street: 'preflop',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Jh'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 15,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'Todos foldean hasta BTN',
                'Hero tiene 15 BB',
                'SB y BB cubren a Hero',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: 'Con 15 BB, AJs es demasiado fuerte para foldear y no quiere abrir/fold. El jam captura fold equity y realiza toda la equity.',
            solverNote: 'AJs entra en rango de open jam frecuente con 12-16 BB desde BTN.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 80, 'ev_score' => 100, 'feedback' => 'Correcto. Jam rentable con blocker y equity.'],
                'RAISE_2_5X' => ['grade' => 'good', 'frequency' => 20, 'ev_score' => 78, 'feedback' => 'Puede mezclarse, pero raise/fold es incómodo.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Fold demasiado nit con AJs.'],
            ],
            gtoInsight: 'GTO simplificado: con 15 BB, las broadways suited fuertes pueden empujar directamente desde BTN.',
            lowStakesInsight: 'En niveles bajos, jam funciona muy bien porque las ciegas foldean demasiado.',
            confidence: 88
        );
    }

    protected static function co12BbPush77(): array
    {
        return self::spot(
            id: 'mastery_ss_002',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'open_jam_pair_12bb',
            conceptLabel: 'Open Jam Parejas 12 BB',
            title: 'CO 12 BB · 77 open jam',
            street: 'preflop',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['7h', '7d'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 12,
            boardTexture: 'Sin board',
            rangeAdvantage: 'CO',
            nutAdvantage: 'Compartida',
            actions: [
                'Todos foldean hasta CO',
                'Hero tiene 12 BB',
                'BTN/SB/BB cubren a Hero',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: '77 con 12 BB juega mejor empujando que abriendo pequeño. Tiene fold equity y buena equity cuando recibe call.',
            solverNote: 'Parejas medias con 10-14 BB son jams claros desde CO/BTN en muchos escenarios.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 85, 'ev_score' => 100, 'feedback' => 'Correcto. Jam simple y rentable.'],
                'RAISE_2_5X' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 40, 'feedback' => 'Abres la puerta a spots incómodos.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 10, 'feedback' => 'Fold demasiado tight con 77.'],
            ],
            gtoInsight: 'GTO simplificado: las parejas ganan mucho empujando fold equity cuando el stack es corto.',
            lowStakesInsight: 'En torneos/cash corto de bajo nivel, jam evita errores postflop y roba ciegas.',
            confidence: 87
        );
    }

    protected static function sb10BbJamKQs(): array
    {
        return self::spot(
            id: 'mastery_ss_003',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'sb_push_fold_10bb',
            conceptLabel: 'SB Push/Fold 10 BB',
            title: 'SB 10 BB · KQs jam vs BB',
            street: 'preflop',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['Kh', 'Qh'],
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
                'BB tiene 18 BB',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: 'Con 10 BB en SB, KQs es jam clarísimo. Tiene equity, blockers y mucha fold equity contra BB.',
            solverNote: 'SB pushea muy amplio a 10 BB porque sólo queda un rival por hablar.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 95, 'ev_score' => 100, 'feedback' => 'Correcto. Jam estándar.'],
                'RAISE_2_5X' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 30, 'feedback' => 'Raise/fold con 10 BB no tiene sentido.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Fold imposible con KQs.'],
            ],
            gtoInsight: 'GTO simplificado: SB shortstack empuja amplio por fold equity.',
            lowStakesInsight: 'En microlímites la BB foldea demasiado; jam imprime EV.',
            confidence: 92
        );
    }

    protected static function btn18BbRestealA5s(): array
    {
        return self::spot(
            id: 'mastery_ss_004',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
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
                'CO abre 2.5 BB',
                'Hero tiene 18 BB en BTN',
                'SB y BB por hablar',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'JAM'],
            correctAction: 'JAM',
            explanation: 'A5s bloquea Ax fuertes y tiene equity decente cuando paga. Con 18 BB, jam presiona mucho a CO y evita jugar postflop con SPR incómodo.',
            solverNote: 'Axs bajos son buenos resteals por blocker y fold equity.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Buen resteal con blocker.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 78, 'feedback' => 'Fold vale contra CO muy tight.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 36, 'feedback' => 'Call con 18 BB invita squeezes y spots malos.'],
            ],
            gtoInsight: 'GTO simplificado: los resteals shortstack prefieren blockers y manos suited.',
            lowStakesInsight: 'Contra rivales que abren/fold mucho, este jam gana fichas directamente.',
            confidence: 80
        );
    }

    protected static function bbCallOff20BbTT(): array
    {
        return self::spot(
            id: 'mastery_ss_005',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'calloff_20bb',
            conceptLabel: 'Call Off 20 BB',
            title: 'BB 20 BB · TT vs jam BTN',
            street: 'preflop',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Th', 'Td'],
            boardCards: [],
            potBb: 22.5,
            spr: 0.0,
            effectiveStackBb: 20,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN amplio',
            nutAdvantage: 'BB por mano concreta',
            actions: [
                'Todos foldean hasta BTN',
                'BTN jam 20 BB',
                'SB foldea',
                'Hero está en BB con TT',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL'],
            correctAction: 'CALL',
            explanation: 'TT está muy por delante del rango de jam de BTN con 20 BB si el rival empuja razonablemente amplio. Foldear sería demasiado tight.',
            solverNote: 'TT es call-off fuerte contra jams de posiciones tardías con stacks medios-cortos.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 85, 'ev_score' => 100, 'feedback' => 'Correcto. TT domina demasiadas manos.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 15, 'ev_score' => 35, 'feedback' => 'Fold sólo contra nit extremo.'],
            ],
            gtoInsight: 'GTO simplificado: contra rangos amplios, pares medios-altos son calls obligatorios.',
            lowStakesInsight: 'En torneos bajos muchos BTN pushean peor que TT. Paga.',
            confidence: 86
        );
    }

    protected static function sb14BbPush66(): array
    {
        return self::spot(
            id: 'mastery_ss_006',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'sb_push_pair_14bb',
            conceptLabel: 'SB Push Pareja 14 BB',
            title: 'SB 14 BB · 66 jam vs BB',
            street: 'preflop',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['6c', '6d'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 14,
            boardTexture: 'Sin board',
            rangeAdvantage: 'SB',
            nutAdvantage: 'Compartida',
            actions: [
                'Todos foldean hasta SB',
                'Hero tiene 14 BB',
                'BB cubre a Hero',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: '66 juega mal postflop OOP con 14 BB. Jam captura fold equity y evita decisiones difíciles.',
            solverNote: 'SB puede empujar muchas parejas con 12-15 BB contra BB.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 75, 'ev_score' => 100, 'feedback' => 'Correcto. Jam rentable.'],
                'RAISE_2_5X' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 55, 'feedback' => 'Raise/fold con pareja y 14 BB es incómodo.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 32, 'feedback' => 'Demasiado tight SB vs BB.'],
            ],
            gtoInsight: 'GTO simplificado: parejas pequeñas empujan bien porque niegan equity.',
            lowStakesInsight: 'En niveles bajos BB foldea mucho y cuando paga aún tienes equity.',
            confidence: 84
        );
    }

    protected static function co16BbJamAQo(): array
    {
        return self::spot(
            id: 'mastery_ss_007',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'open_jam_16bb_broadway',
            conceptLabel: 'Open Jam 16 BB Broadway',
            title: 'CO 16 BB · AQo open jam',
            street: 'preflop',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['Ad', 'Qh'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 16,
            boardTexture: 'Sin board',
            rangeAdvantage: 'CO',
            nutAdvantage: 'CO',
            actions: [
                'Todos foldean hasta CO',
                'Hero tiene 16 BB',
                'BTN/SB/BB tienen stacks que cubren',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'RAISE_2_5X',
            explanation: 'AQo con 16 BB es muy fuerte. Puede abrir pequeño para inducir jams peores y no necesita convertir todo en open jam automático.',
            solverNote: 'A 16 BB, AQo puede mezclar open pequeño y jam según dinámica; raise/call suele ser muy rentable.',
            grades: [
                'RAISE_2_5X' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Abres para pagar jams peores.'],
                'JAM' => ['grade' => 'good', 'frequency' => 45, 'ev_score' => 88, 'feedback' => 'Jam también es rentable y simple.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Fold imposible con AQo.'],
            ],
            gtoInsight: 'GTO simplificado: manos premium a 16 BB no siempre necesitan open jam; pueden inducir.',
            lowStakesInsight: 'En micros, raise/call funciona si los rivales resuben peor. Jam es más simple.',
            confidence: 78
        );
    }

    protected static function btn13BbPushKJs(): array
    {
        return self::spot(
            id: 'mastery_ss_008',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'btn_push_13bb',
            conceptLabel: 'BTN Push 13 BB',
            title: 'BTN 13 BB · KJs open jam',
            street: 'preflop',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Kh', 'Jh'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 13,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'Todos foldean hasta BTN',
                'Hero tiene 13 BB',
                'SB tiene 20 BB',
                'BB tiene 18 BB',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: 'KJs tiene buena equity y blockers. Con 13 BB, jam evita raise/fold y maximiza fold equity.',
            solverNote: 'Broadways suited fuertes entran en push desde BTN con 12-14 BB.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 75, 'ev_score' => 100, 'feedback' => 'Correcto. Jam rentable.'],
                'RAISE_2_5X' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 58, 'feedback' => 'Puede inducir, pero te compromete incómodo.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 8, 'feedback' => 'Fold demasiado nit.'],
            ],
            gtoInsight: 'GTO simplificado: BTN con stack corto empuja muchas manos suited con blockers.',
            lowStakesInsight: 'En niveles bajos las ciegas foldean demasiado; jam gana mucho.',
            confidence: 84
        );
    }

    protected static function hj15BbJamATs(): array
    {
        return self::spot(
            id: 'mastery_ss_009',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'hj_push_15bb',
            conceptLabel: 'HJ Push 15 BB',
            title: 'HJ 15 BB · ATs decisión preflop',
            street: 'preflop',
            heroPosition: 'HJ',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Th'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 15,
            boardTexture: 'Sin board',
            rangeAdvantage: 'HJ',
            nutAdvantage: 'HJ por blockers',
            actions: [
                'Todos foldean hasta HJ',
                'Hero tiene 15 BB',
                'CO/BTN/SB/BB cubren',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: 'ATs bloquea Ax fuertes y tiene buena equity. Con 15 BB desde HJ, jam evita opens incómodos contra stacks que pueden restealear.',
            solverNote: 'ATs mezcla open pequeño y jam; con rivales agresivos detrás, jam gana valor.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto contra mesa agresiva.'],
                'RAISE_2_5X' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 82, 'feedback' => 'También viable en mesa pasiva.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 35, 'feedback' => 'Demasiado tight con ATs.'],
            ],
            gtoInsight: 'GTO simplificado: a 15 BB, los suited Ax fuertes pueden jugarse como jam o raise/call según mesa.',
            lowStakesInsight: 'Si te resuben mucho, jam simplifica y evita errores.',
            confidence: 79
        );
    }

    protected static function sb12BbPushA8s(): array
    {
        return self::spot(
            id: 'mastery_ss_010',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'sb_push_ax_12bb',
            conceptLabel: 'SB Push Ax 12 BB',
            title: 'SB 12 BB · A8s jam vs BB',
            street: 'preflop',
            heroPosition: 'SB',
            villainPosition: 'BB',
            heroCards: ['As', '8s'],
            boardCards: [],
            potBb: 1.5,
            spr: 0.0,
            effectiveStackBb: 12,
            boardTexture: 'Sin board',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB',
            actions: [
                'Todos foldean hasta SB',
                'Hero tiene 12 BB',
                'BB tiene 22 BB',
                'Hero actúa',
            ],
            options: ['FOLD', 'RAISE_2_5X', 'JAM'],
            correctAction: 'JAM',
            explanation: 'A8s tiene blocker, equity y jugabilidad. Con 12 BB SB vs BB, jam es claro y evita jugar OOP.',
            solverNote: 'Ax suited empuja amplio desde SB a stacks cortos.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 85, 'ev_score' => 100, 'feedback' => 'Correcto. Jam estándar.'],
                'RAISE_2_5X' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 50, 'feedback' => 'Raise/fold incómodo con 12 BB.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Fold demasiado nit.'],
            ],
            gtoInsight: 'GTO simplificado: SB shortstack empuja Ax suited por fold equity y blockers.',
            lowStakesInsight: 'En micros, BB sobrefoldea; jam es muy rentable.',
            confidence: 87
        );
    }

    protected static function spr2TopPair(): array
    {
        return self::spot(
            id: 'mastery_ss_011',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'spr2_top_pair',
            conceptLabel: 'SPR 2 Top Pair',
            title: 'SPR 2 · Top pair top kicker en flop',
            street: 'flop',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Kd'],
            boardCards: ['Kc', '8d', '3s'],
            potBb: 9.0,
            spr: 2.0,
            effectiveStackBb: 18,
            boardTexture: 'K-high seco',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'BTN abre 2 BB con 20 BB',
                'BB paga',
                'Flop Kc 8d 3s',
                'BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_33', 'JAM'],
            correctAction: 'BET_33',
            explanation: 'Con TPTK y SPR 2, no necesitas jam flop. Bet pequeño mantiene Kx peores y prepara turn jam.',
            solverNote: 'En SPR bajo, sizings pequeños comprometen stacks sin espantar rango peor.',
            grades: [
                'BET_33' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Value eficiente.'],
                'JAM' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 62, 'feedback' => 'Demasiado grande en board seco.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 40, 'feedback' => 'Pierdes valor/protección.'],
            ],
            gtoInsight: 'GTO simplificado: SPR bajo no significa jam automático en flop.',
            lowStakesInsight: 'En niveles bajos apuesta pequeño; te pagan peores.',
            confidence: 86
        );
    }

    protected static function overpairLowSpr(): array
    {
        return self::spot(
            id: 'mastery_ss_012',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'overpair_low_spr',
            conceptLabel: 'Overpair SPR Bajo',
            title: 'SPR bajo · Overpair en board bajo',
            street: 'flop',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['Qh', 'Qc'],
            boardCards: ['8s', '5d', '2c'],
            potBb: 10.0,
            spr: 1.8,
            effectiveStackBb: 18,
            boardTexture: 'Bajo seco',
            rangeAdvantage: 'CO',
            nutAdvantage: 'CO',
            actions: [
                'CO abre 2.2 BB con 22 BB',
                'BB paga',
                'Flop 8s 5d 2c',
                'BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'BET_50',
            explanation: 'QQ es overpair fuerte. Bet medio deja el bote preparado y cobra a pares/draws sin tirar todo el rango peor.',
            solverNote: 'Overpairs con SPR menor a 2 buscan compromiso progresivo.',
            grades: [
                'BET_50' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Valor y compromiso.'],
                'JAM' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 84, 'feedback' => 'También rentable contra pagadores.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 35, 'feedback' => 'Demasiado pasivo con overpair.'],
            ],
            gtoInsight: 'GTO simplificado: en SPR bajo las overpairs juegan por stacks en boards seguros.',
            lowStakesInsight: 'En micros, apuesta por valor. Pagan 8x, 99-JJ y draws.',
            confidence: 88
        );
    }

    protected static function nutFlushDrawLowSpr(): array
    {
        return self::spot(
            id: 'mastery_ss_013',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'nut_flush_draw_low_spr',
            conceptLabel: 'Nut Flush Draw SPR Bajo',
            title: 'Nut flush draw con SPR bajo',
            street: 'flop',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Jh'],
            boardCards: ['Kh', '8h', '4c'],
            potBb: 9.5,
            spr: 2.1,
            effectiveStackBb: 20,
            boardTexture: 'K-high con nut flush draw',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'BTN abre 2 BB con 22 BB',
                'BB paga',
                'Flop Kh 8h 4c',
                'BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'BET_50',
            explanation: 'Nut flush draw tiene mucha equity. Bet medio genera fold equity y permite pagar/jamear muchas respuestas.',
            solverNote: 'Draws nuts en SPR bajo juegan agresivo, pero no siempre necesitan jam directo.',
            grades: [
                'BET_50' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Equity + fold equity.'],
                'JAM' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 84, 'feedback' => 'Jam también es viable.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 58, 'feedback' => 'Realizas equity, pero pierdes presión.'],
            ],
            gtoInsight: 'GTO simplificado: los draws nuts con SPR bajo son candidatos a presión.',
            lowStakesInsight: 'En niveles bajos bet medio suele recibir calls peores y aún tienes outs.',
            confidence: 82
        );
    }

    protected static function pairPlusDrawJam(): array
    {
        return self::spot(
            id: 'mastery_ss_014',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'pair_plus_draw_low_spr',
            conceptLabel: 'Pair + Draw SPR Bajo',
            title: 'Par + proyecto con SPR 2',
            street: 'flop',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['9s', '8s'],
            boardCards: ['8d', '7s', '2s'],
            potBb: 8.5,
            spr: 2.0,
            effectiveStackBb: 17,
            boardTexture: 'Par + flush draw + gutshot',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BB',
            actions: [
                'BTN abre 2 BB con 20 BB',
                'BB paga',
                'Flop 8d 7s 2s',
                'BB check',
                'BTN apuesta 50%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'JAM'],
            correctAction: 'JAM',
            explanation: 'Hero tiene par, flush draw y gutshot. Con SPR 2, jam maximiza fold equity y nunca está muerto cuando recibe call.',
            solverNote: 'Pair + draw fuerte en SPR bajo se beneficia mucho del check-jam.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Mucha equity y fold equity.'],
                'CALL' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 80, 'feedback' => 'Call es viable, pero menos presión.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Fold imposible con tanta equity.'],
            ],
            gtoInsight: 'GTO simplificado: con SPR bajo, los proyectos con par tienen mucho valor agresivo.',
            lowStakesInsight: 'En micros, jam funciona contra cbet automática y aún tienes outs si pagan.',
            confidence: 84
        );
    }

    protected static function turnBarrelSpr1(): array
    {
        return self::spot(
            id: 'mastery_ss_015',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'turn_barrel_spr1',
            conceptLabel: 'Turn Barrel SPR 1',
            title: 'Turn con SPR 1 tras cbet flop',
            street: 'turn',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Ac', 'Ks'],
            boardCards: ['Kc', '9d', '4h', '2s'],
            potBb: 16.0,
            spr: 1.0,
            effectiveStackBb: 16,
            boardTexture: 'K-high seco · turn blank',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'BTN abre 2 BB con 22 BB',
                'BB paga',
                'Flop Kc 9d 4h · BTN bet 33% · BB paga',
                'Turn 2s',
                'BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'Con TPTK y SPR 1, jam cobra a Kx peores y evita rivers incómodos. Check pierde demasiado valor.',
            solverNote: 'SPR 1 simplifica: las top pairs fuertes suelen empujar turn seguro.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Valor claro.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 84, 'feedback' => 'También compromete, aunque deja poco detrás.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 30, 'feedback' => 'Demasiado pasivo.'],
            ],
            gtoInsight: 'GTO simplificado: con SPR 1, las manos fuertes se stackean antes.',
            lowStakesInsight: 'En niveles bajos, jam por valor. Pagan KQ/KJ demasiado.',
            confidence: 89
        );
    }

    protected static function topPairTurnJam(): array
    {
        return self::spot(
            id: 'mastery_ss_016',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'top_pair_turn_jam',
            conceptLabel: 'Top Pair Turn Jam',
            title: 'Top pair vulnerable jam turn',
            street: 'turn',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['Qh', 'Jc'],
            boardCards: ['Qs', '8s', '3d', '4s'],
            potBb: 14.0,
            spr: 1.2,
            effectiveStackBb: 17,
            boardTexture: 'Q-high con color completado',
            rangeAdvantage: 'CO',
            nutAdvantage: 'BB',
            actions: [
                'CO abre 2.2 BB con 20 BB',
                'BB paga',
                'Flop Qs 8s 3d · CO bet 33% · BB paga',
                'Turn 4s',
                'BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'CHECK',
            explanation: 'QJ sin spade pierde valor cuando completa color. Aunque SPR es bajo, no todas las top pairs deben jam en turn malo.',
            solverNote: 'La textura manda: SPR bajo no justifica stackear top pair en cartas que favorecen al caller.',
            grades: [
                'CHECK' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Control en carta mala.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 58, 'feedback' => 'Value muy fino y vulnerable.'],
                'JAM' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 32, 'feedback' => 'Demasiado optimista en color completado.'],
            ],
            gtoInsight: 'GTO simplificado: SPR bajo importa, pero los blockers y la textura importan más.',
            lowStakesInsight: 'En micros, si completa color y te pagan/jamean, casi siempre vas mal.',
            confidence: 82
        );
    }

    protected static function comboDrawJam(): array
    {
        return self::spot(
            id: 'mastery_ss_017',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'combo_draw_turn_jam',
            conceptLabel: 'Combo Draw Jam',
            title: 'Combo draw turn con fold equity',
            street: 'turn',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Jh', 'Th'],
            boardCards: ['9h', '8d', '2c', 'Qh'],
            potBb: 13.0,
            spr: 1.4,
            effectiveStackBb: 18,
            boardTexture: 'Open ended + flush draw',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BB',
            actions: [
                'BTN abre 2 BB con 22 BB',
                'BB paga',
                'Flop 9h 8d 2c · BB check · BTN bet 33% · BB paga',
                'Turn Qh',
                'BB check',
                'BTN apuesta 50%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'JAM'],
            correctAction: 'JAM',
            explanation: 'JT tiene escalera abierta, flush draw y blocker de nuts. Con SPR bajo, jam maximiza fold equity y tiene mucha equity cuando pagan.',
            solverNote: 'Combo draws fuertes son jams naturales en SPR bajo.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Equity masiva + fold equity.'],
                'CALL' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 82, 'feedback' => 'Call realiza equity, pero menos presión.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Fold imposible.'],
            ],
            gtoInsight: 'GTO simplificado: los mejores draws no se juegan pasivos cuando el SPR permite jam.',
            lowStakesInsight: 'En niveles bajos, jam puede recibir calls, pero tienes mucha equity.',
            confidence: 84
        );
    }

    protected static function overpairCommitment(): array
    {
        return self::spot(
            id: 'mastery_ss_018',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'overpair_commitment',
            conceptLabel: 'Overpair Commitment',
            title: 'Overpair comprometida con SPR menor a 1',
            street: 'turn',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Ad'],
            boardCards: ['Jc', '7d', '3h', '2c'],
            potBb: 20.0,
            spr: 0.8,
            effectiveStackBb: 16,
            boardTexture: 'J-high seco',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'BTN abre 2 BB con 24 BB',
                'BB paga',
                'Flop Jc 7d 3h · BTN bet 50% · BB paga',
                'Turn 2c',
                'BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'AA con SPR menor a 1 en turn seguro está totalmente comprometida. Jam cobra a Jx, pares y draws mínimos.',
            solverNote: 'Overpairs premium empujan turn con SPR sub-1 en runouts seguros.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 80, 'ev_score' => 100, 'feedback' => 'Correcto. Valor máximo.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 15, 'ev_score' => 84, 'feedback' => 'También valor, pero deja poco detrás.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 15, 'feedback' => 'Check pierde demasiado valor.'],
            ],
            gtoInsight: 'GTO simplificado: cuando el SPR es menor a 1, las premiums se stackean.',
            lowStakesInsight: 'En micros, jam. Te pagan Jx y pares peores.',
            confidence: 92
        );
    }

    protected static function riverBluffCatcher(): array
    {
        return self::spot(
            id: 'mastery_ss_019',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'river_bluffcatch_short',
            conceptLabel: 'River Bluffcatch Short Stack',
            title: 'River bluffcatch con segundo par y SPR bajo',
            street: 'river',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Qd', '9d'],
            boardCards: ['Ks', '9h', '4c', '2s', '7d'],
            potBb: 18.0,
            spr: 0.7,
            effectiveStackBb: 13,
            boardTexture: 'K-high seco',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'BTN abre 2 BB con 20 BB',
                'BB paga',
                'Flop Ks 9h 4c · BTN bet 33% · BB paga',
                'Turn 2s · check/check',
                'River 7d',
                'BB check',
                'BTN jam 13 BB',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL'],
            correctAction: 'FOLD',
            explanation: 'Segundo par contra jam river en bote shortstack suele ser bluffcatch débil. Sin blockers relevantes y con población poco farolera, fold es mejor.',
            solverNote: 'Los bluffcatchers débiles no están obligados a pagar sólo porque el SPR sea bajo.',
            grades: [
                'FOLD' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Fold disciplinado.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 35, 'ev_score' => 35, 'feedback' => 'Call demasiado optimista contra población pasiva.'],
            ],
            gtoInsight: 'GTO simplificado: SPR bajo no convierte cualquier par en call.',
            lowStakesInsight: 'En niveles bajos, los jams river suelen ser valor. Foldea más.',
            confidence: 82
        );
    }

    protected static function allInRiverValue(): array
    {
        return self::spot(
            id: 'mastery_ss_020',
            module: 'short_stack_lab',
            moduleLabel: 'Short Stack Lab',
            concept: 'river_value_allin_short',
            conceptLabel: 'River All-In Value',
            title: 'River all-in por valor con top pair fuerte',
            street: 'river',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Ac', 'Kh'],
            boardCards: ['Ks', '8d', '4h', '2c', '7s'],
            potBb: 18.0,
            spr: 0.7,
            effectiveStackBb: 13,
            boardTexture: 'K-high seco',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'BTN abre 2 BB con 22 BB',
                'BB paga',
                'Flop Ks 8d 4h · BTN bet 33% · BB paga',
                'Turn 2c · BTN bet 50% · BB paga',
                'River 7s',
                'BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'AK sigue ganando a KQ/KJ/KT y algunos pares tercos. Con SPR 0.7, jam es el tamaño natural de value.',
            solverNote: 'TPTK en runout seco y SPR bajo valuejamea con frecuencia alta.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Valor máximo.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 20, 'ev_score' => 84, 'feedback' => 'También valor, pero deja fichas sin sentido.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 35, 'feedback' => 'Pierdes valor contra Kx peores.'],
            ],
            gtoInsight: 'GTO simplificado: con SPR muy bajo, las manos de value fuertes suelen usar all-in.',
            lowStakesInsight: 'En micros, jam. Pagan top pair peor demasiado.',
            confidence: 88
        );
    }
}
