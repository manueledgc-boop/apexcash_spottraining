<?php

namespace App\SpotTraining\Mastery\Modules;

use App\SpotTraining\Mastery\Concerns\BuildsMasterySpots;

class FourBetPotSpots
{
    use BuildsMasterySpots;

    public static function all(): array
    {
        return [
            self::aaBtnVsSbFourBetPreflop(),
            self::akBtnVsBbCallFiveBetJam(),
            self::kkOopAHighFlop(),
            self::qqLowDryFlop(),
            self::akMissedLowFlop(),
            self::aaPairedDryFlop(),
            self::jjFacingSmallCbetKHigh(),
            self::a5sNutFlushDrawFlop(),
            self::kkTurnJamBlank(),
            self::aqTurnTopPairJam(),
            self::qqTurnAceControl(),
            self::akNutFlushDrawTurnJam(),
            self::aaRiverValueJam(),
            self::kkAceRiverCheck(),
            self::akRiverBluffCatch(),
            self::a5sMissedRiverBluff(),
            self::qqRiverValueJam(),
            self::jjRiverFoldBadRunout(),
            self::aksComboDrawFlopJam(),
            self::aaTurnValueBetDryBoard(),
        ];
    }

    protected static function aaBtnVsSbFourBetPreflop(): array
    {
        return self::spot(
            id: 'mastery_4bp_001',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'preflop_4bet_value',
            conceptLabel: '4Bet Value Preflop',
            title: 'BTN vs SB · AA frente a 3bet',
            street: 'preflop',
            heroPosition: 'BTN',
            villainPosition: 'SB',
            heroCards: ['Ah', 'Ad'],
            boardCards: [],
            potBb: 15.5,
            spr: 3.2,
            effectiveStackBb: 100,
            boardTexture: 'Sin board',
            rangeAdvantage: 'BTN con mano premium',
            nutAdvantage: 'BTN',
            actions: ['BTN abre 2.5 BB', 'SB 3bet 11 BB', 'Hero actúa con AA'],
            options: ['CALL', 'RAISE_2_5X', 'JAM'],
            correctAction: 'RAISE_2_5X',
            explanation: 'AA quiere construir bote contra el rango fuerte de 3bet. El 4bet pequeño mantiene dentro manos dominadas y deja SPR cómodo.',
            solverNote: 'AA es 4bet puro por valor; no necesita sizing enorme porque los rangos ya están comprimidos.',
            grades: ['RAISE_2_5X' => ['grade' => 'best', 'frequency' => 95, 'ev_score' => 100, 'feedback' => 'Correcto. 4bet pequeño por valor máximo.'], 'CALL' => ['grade' => 'good', 'frequency' => 5, 'ev_score' => 82, 'feedback' => 'Slowplay posible, pero pierdes valor directo.'], 'JAM' => ['grade' => 'marginal', 'frequency' => 0, 'ev_score' => 60, 'feedback' => 'All-in es demasiado grande a 100 BB.']],
            gtoInsight: 'GTO simplificado: AA es 4bet por valor casi siempre con tamaño pequeño.',
            lowStakesInsight: 'En NL2-NL10 no hagas slowplay innecesario. 4bet por valor.',
            confidence: 92
        );
    }

    protected static function akBtnVsBbCallFiveBetJam(): array
    {
        return self::spot(
            id: 'mastery_4bp_002',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'ak_4bet_calloff',
            conceptLabel: 'AK en 4Bet Pot',
            title: 'BTN 4bet con AKs y enfrenta jam',
            street: 'preflop',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['As', 'Ks'],
            boardCards: [],
            potBb: 42,
            spr: 0,
            effectiveStackBb: 100,
            boardTexture: 'Sin board',
            rangeAdvantage: 'Rangos all-in comprimidos',
            nutAdvantage: 'Compartida',
            actions: ['BTN abre 2.5 BB', 'BB 3bet 10 BB', 'BTN 4bet 24 BB', 'BB jam 100 BB', 'Hero actúa'],
            options: ['FOLD', 'CALL'],
            correctAction: 'CALL',
            explanation: 'AKs tiene equity suficiente contra el rango de jam estándar y bloquea AA/KK.',
            solverNote: 'AKs suele ser call-off contra jams razonables de 5bet en BTN vs BB.',
            grades: ['CALL' => ['grade' => 'best', 'frequency' => 90, 'ev_score' => 100, 'feedback' => 'Correcto. AKs tiene equity y blockers premium.'], 'FOLD' => ['grade' => 'blunder', 'frequency' => 10, 'ev_score' => 18, 'feedback' => 'Demasiado nit después de 4betear AKs.']],
            gtoInsight: 'GTO simplificado: AKs bloquea valor y realiza bien equity.',
            lowStakesInsight: 'Contra nits extremos puedes ajustar, pero por defecto es call-off.',
            confidence: 86
        );
    }

    protected static function kkOopAHighFlop(): array
    {
        return self::spot(
            id: 'mastery_4bp_003',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'overpair_under_ace_4bet_pot',
            conceptLabel: 'KK bajo As en 4Bet Pot',
            title: 'SB 4bet pot · KK en flop A-high',
            street: 'flop',
            heroPosition: 'SB',
            villainPosition: 'BTN',
            heroCards: ['Kh', 'Kd'],
            boardCards: ['As', '7c', '2d'],
            potBb: 49,
            spr: 1.55,
            effectiveStackBb: 76,
            boardTexture: 'A-high seco',
            rangeAdvantage: 'SB 4bettor',
            nutAdvantage: 'SB',
            actions: ['BTN abre 2.5 BB', 'SB 3bet 11 BB', 'BTN 4bet 24 BB', 'SB paga', 'Flop As 7c 2d', 'Hero actúa primero'],
            options: ['CHECK', 'BET_25', 'BET_50'],
            correctAction: 'CHECK',
            explanation: 'KK tiene mucho showdown pero no quiere construir bote en flop con As.',
            solverNote: 'Manos fuertes degradadas bajo As entran mucho en check.',
            grades: ['CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Controlas bote.'], 'BET_25' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 78, 'feedback' => 'Pequeño puede mezclarse.'], 'BET_50' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 38, 'feedback' => 'Demasiado grande; te aíslas contra Ax.']],
            gtoInsight: 'GTO simplificado: no se apuesta automáticamente por iniciativa en 4Bet pot.',
            lowStakesInsight: 'En NL2-NL10 check es claro; si apuestas y pagan, estás incómodo.',
            confidence: 84
        );
    }

    protected static function qqLowDryFlop(): array
    {
        return self::spot(
            id: 'mastery_4bp_004',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'overpair_4bet_pot',
            conceptLabel: 'Overpair en 4Bet Pot',
            title: 'CO 4bet pot · QQ en board bajo',
            street: 'flop',
            heroPosition: 'CO',
            villainPosition: 'BTN',
            heroCards: ['Qh', 'Qs'],
            boardCards: ['8d', '5c', '2s'],
            potBb: 50,
            spr: 1.45,
            effectiveStackBb: 72,
            boardTexture: 'Bajo seco',
            rangeAdvantage: 'CO 4bettor',
            nutAdvantage: 'CO',
            actions: ['CO abre 2.5 BB', 'BTN 3bet 8 BB', 'CO 4bet 22 BB', 'BTN paga', 'Flop 8d 5c 2s', 'Hero actúa'],
            options: ['CHECK', 'BET_25', 'JAM'],
            correctAction: 'BET_25',
            explanation: 'QQ es overpair fuerte, pero el SPR ya es bajo. Bet pequeño mantiene peores dentro.',
            solverNote: 'En 4Bet pots se usan sizings pequeños porque el pot ya está inflado.',
            grades: ['BET_25' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Valor y control.'], 'JAM' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 84, 'feedback' => 'Puede funcionar contra pagadores.'], 'CHECK' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 60, 'feedback' => 'Demasiado pasivo salvo plan claro.']],
            gtoInsight: 'GTO simplificado: con SPR bajo, tamaños pequeños presionan mucho.',
            lowStakesInsight: 'En micros bet pequeño recibe calls de JJ-TT y overcards.',
            confidence: 87
        );
    }

    protected static function akMissedLowFlop(): array
    {
        return self::spot(
            id: 'mastery_4bp_005',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'ak_missed_4bet_pot',
            conceptLabel: 'AK fallado en 4Bet Pot',
            title: 'AK falla en flop bajo dentro de 4Bet pot',
            street: 'flop',
            heroPosition: 'SB',
            villainPosition: 'BTN',
            heroCards: ['Ac', 'Kd'],
            boardCards: ['9s', '6d', '4c'],
            potBb: 48,
            spr: 1.6,
            effectiveStackBb: 78,
            boardTexture: 'Bajo medio',
            rangeAdvantage: 'SB 4bettor',
            nutAdvantage: 'BTN ligera',
            actions: ['BTN abre 2.5 BB', 'SB 3bet 11 BB', 'BTN 4bet 24 BB', 'SB paga', 'Flop 9s 6d 4c', 'Hero actúa'],
            options: ['CHECK', 'BET_25', 'JAM'],
            correctAction: 'CHECK',
            explanation: 'AK sin conectar no tiene suficiente equity para jam automático en board bajo.',
            solverNote: 'AK sin backdoors fuertes mezcla checks en boards que conectan con el caller.',
            grades: ['CHECK' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. No fuerces bluff caro.'], 'BET_25' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 62, 'feedback' => 'Puede mezclar, no automático.'], 'JAM' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 18, 'feedback' => 'All-in sin ligar es demasiado optimista.']],
            gtoInsight: 'GTO simplificado: SPR bajo no significa jam con todo.',
            lowStakesInsight: 'En NL2-NL10 te pagan con pares. No regales stacks con AK high.',
            confidence: 86
        );
    }

    protected static function aaPairedDryFlop(): array
    {
        return self::spot(
            id: 'mastery_4bp_006',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'paired_board_4bet_pot',
            conceptLabel: 'Board emparejado en 4Bet Pot',
            title: 'AA en board emparejado seco',
            street: 'flop',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['As', 'Ah'],
            boardCards: ['9d', '9c', '3s'],
            potBb: 46,
            spr: 1.7,
            effectiveStackBb: 78,
            boardTexture: 'Emparejado seco',
            rangeAdvantage: 'BTN 4bettor',
            nutAdvantage: 'BTN',
            actions: ['BTN abre 2.5 BB', 'BB 3bet 10 BB', 'BTN 4bet 23 BB', 'BB paga', 'Flop 9d 9c 3s', 'BB check', 'Hero actúa'],
            options: ['CHECK', 'BET_25', 'BET_50'],
            correctAction: 'BET_25',
            explanation: 'AA está muy por delante. El sizing pequeño cobra a pares peores y overcards.',
            solverNote: 'Boards emparejados secos permiten apuestas pequeñas de rango.',
            grades: ['BET_25' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Sizing pequeño, value enorme.'], 'BET_50' => ['grade' => 'good', 'frequency' => 20, 'ev_score' => 82, 'feedback' => 'También value, pero tira más peores.'], 'CHECK' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 65, 'feedback' => 'Induce, pero pierde valor directo.']],
            gtoInsight: 'GTO simplificado: tamaño pequeño tiene mucho apalancamiento por SPR bajo.',
            lowStakesInsight: 'En micros apuesta; pagan TT-QQ y A-high.',
            confidence: 88
        );
    }

    protected static function jjFacingSmallCbetKHigh(): array
    {
        return self::spot(
            id: 'mastery_4bp_007',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'medium_pair_4bet_pot',
            conceptLabel: 'Par medio en 4Bet Pot',
            title: 'JJ en flop K-high tras pagar 4bet',
            street: 'flop',
            heroPosition: 'BTN',
            villainPosition: 'SB',
            heroCards: ['Jh', 'Jc'],
            boardCards: ['Ks', '7d', '2c'],
            potBb: 50,
            spr: 1.4,
            effectiveStackBb: 70,
            boardTexture: 'K-high seco',
            rangeAdvantage: 'SB 4bettor',
            nutAdvantage: 'SB',
            actions: ['BTN abre 2.5 BB', 'SB 3bet 11 BB', 'BTN 4bet 24 BB', 'SB paga', 'Flop Ks 7d 2c', 'SB apuesta 25%', 'Hero actúa'],
            options: ['FOLD', 'CALL', 'JAM'],
            correctAction: 'CALL',
            explanation: 'La mano está demasiado alta en rango para foldear ante la apuesta actual.',
            solverNote: 'Contra sizing pequeño o rango polar, esta mano defiende bien.',
            grades: ['FOLD' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 35, 'feedback' => 'Demasiado débil para este spot.'], 'CALL' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Buen bluffcatch/continuación.'], 'JAM' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 38, 'feedback' => 'Demasiado grande para la textura o fuerza de mano.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function a5sNutFlushDrawFlop(): array
    {
        return self::spot(
            id: 'mastery_4bp_008',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: '4bet_bluff_postflop',
            conceptLabel: '4Bet Bluff Postflop',
            title: 'A5s 4bet bluff conecta equity en flop',
            street: 'flop',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['As', '5s'],
            boardCards: ['Ks', '8s', '3d'],
            potBb: 47,
            spr: 1.65,
            effectiveStackBb: 78,
            boardTexture: 'K-high con nut flush draw',
            rangeAdvantage: 'BTN 4bettor',
            nutAdvantage: 'BTN',
            actions: ['BTN abre 2.5 BB', 'BB 3bet 10 BB', 'BTN 4bet 23 BB', 'BB paga', 'Flop Ks 8s 3d', 'BB check', 'Hero actúa'],
            options: ['CHECK', 'BET_25', 'JAM'],
            correctAction: 'BET_25',
            explanation: 'El sizing pequeño aprovecha el SPR bajo y mantiene manos peores dentro.',
            solverNote: 'En 4Bet pots, las apuestas pequeñas generan mucha presión por el tamaño del bote.',
            grades: ['CHECK' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Controla bote, pero pierde valor o fold equity.'], 'BET_25' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Sizing eficiente.'], 'JAM' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 38, 'feedback' => 'Demasiado grande para la textura o fuerza de mano.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function kkTurnJamBlank(): array
    {
        return self::spot(
            id: 'mastery_4bp_009',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'turn_commitment_4bet_pot',
            conceptLabel: 'Compromiso Turn en 4Bet Pot',
            title: 'KK en turn blank con SPR menor a 1',
            street: 'turn',
            heroPosition: 'CO',
            villainPosition: 'BTN',
            heroCards: ['Kh', 'Kc'],
            boardCards: ['Qd', '8s', '3c', '2h'],
            potBb: 70,
            spr: 0.75,
            effectiveStackBb: 52,
            boardTexture: 'Q-high seco · turn blank',
            rangeAdvantage: 'CO 4bettor',
            nutAdvantage: 'CO',
            actions: ['CO abre 2.5 BB', 'BTN 3bet 8 BB', 'CO 4bet 22 BB', 'BTN paga', 'Flop Qd 8s 3c · CO bet 25% · BTN paga', 'Turn 2h', 'Hero actúa'],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'La mano/equity y el SPR bajo justifican máxima presión por valor o fold equity.',
            solverNote: 'Con SPR bajo, jam es una herramienta estándar cuando la mano tiene valor o equity robusta.',
            grades: ['CHECK' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Controla bote, pero pierde valor o fold equity.'], 'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Línea posible, aunque no es la mejor.'], 'JAM' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Máxima presión en SPR bajo.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function aqTurnTopPairJam(): array
    {
        return self::spot(
            id: 'mastery_4bp_010',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'top_pair_low_spr_4bet',
            conceptLabel: 'Top Pair SPR Bajo',
            title: 'AQ top pair en turn dentro de 4Bet pot',
            street: 'turn',
            heroPosition: 'BTN',
            villainPosition: 'SB',
            heroCards: ['Ah', 'Qh'],
            boardCards: ['Qs', '7d', '2c', '4s'],
            potBb: 68,
            spr: 0.85,
            effectiveStackBb: 58,
            boardTexture: 'Q-high con backdoor spades',
            rangeAdvantage: 'BTN 4bettor',
            nutAdvantage: 'BTN',
            actions: ['BTN abre 2.5 BB', 'SB 3bet 11 BB', 'BTN 4bet 24 BB', 'SB paga', 'Flop Qs 7d 2c · SB check · BTN bet 25% · SB paga', 'Turn 4s', 'SB check', 'Hero actúa'],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'La mano/equity y el SPR bajo justifican máxima presión por valor o fold equity.',
            solverNote: 'Con SPR bajo, jam es una herramienta estándar cuando la mano tiene valor o equity robusta.',
            grades: ['CHECK' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Controla bote, pero pierde valor o fold equity.'], 'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Línea posible, aunque no es la mejor.'], 'JAM' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Máxima presión en SPR bajo.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function qqTurnAceControl(): array
    {
        return self::spot(
            id: 'mastery_4bp_011',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'turn_overcard_control_4bet',
            conceptLabel: 'Overcard Turn en 4Bet Pot',
            title: 'QQ enfrenta As turn en 4Bet pot',
            street: 'turn',
            heroPosition: 'CO',
            villainPosition: 'BTN',
            heroCards: ['Qh', 'Qd'],
            boardCards: ['Jh', '7c', '2d', 'As'],
            potBb: 66,
            spr: 0.95,
            effectiveStackBb: 63,
            boardTexture: 'J-high convertido en As turn',
            rangeAdvantage: 'CO 4bettor',
            nutAdvantage: 'CO',
            actions: ['CO abre 2.5 BB', 'BTN 3bet 8 BB', 'CO 4bet 22 BB', 'BTN paga', 'Flop Jh 7c 2d · CO bet 25% · BTN paga', 'Turn As', 'Hero actúa'],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'CHECK',
            explanation: 'La mano tiene showdown o el runout reduce mucho el valor de apostar.',
            solverNote: 'El check protege el rango y evita convertir manos medias en faroles malos.',
            grades: ['CHECK' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Controlas el bote.'], 'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Línea posible, aunque no es la mejor.'], 'JAM' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 38, 'feedback' => 'Demasiado grande para la textura o fuerza de mano.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function akNutFlushDrawTurnJam(): array
    {
        return self::spot(
            id: 'mastery_4bp_012',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'nut_draw_low_spr_4bet',
            conceptLabel: 'Nut Draw SPR Bajo',
            title: 'AKs con nut flush draw en turn',
            street: 'turn',
            heroPosition: 'SB',
            villainPosition: 'BTN',
            heroCards: ['As', 'Ks'],
            boardCards: ['Qs', '7s', '3d', '2c'],
            potBb: 64,
            spr: 1.0,
            effectiveStackBb: 64,
            boardTexture: 'Q-high con nut flush draw',
            rangeAdvantage: 'SB 4bettor',
            nutAdvantage: 'SB',
            actions: ['BTN abre 2.5 BB', 'SB 3bet 11 BB', 'BTN 4bet 24 BB', 'SB paga', 'Flop Qs 7s 3d · check/check', 'Turn 2c', 'Hero actúa'],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'La mano/equity y el SPR bajo justifican máxima presión por valor o fold equity.',
            solverNote: 'Con SPR bajo, jam es una herramienta estándar cuando la mano tiene valor o equity robusta.',
            grades: ['CHECK' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Controla bote, pero pierde valor o fold equity.'], 'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Línea posible, aunque no es la mejor.'], 'JAM' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Máxima presión en SPR bajo.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function aaRiverValueJam(): array
    {
        return self::spot(
            id: 'mastery_4bp_013',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'river_value_jam_4bet',
            conceptLabel: 'Value Jam River en 4Bet Pot',
            title: 'AA jam river en runout seguro',
            street: 'river',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Ac', 'Ad'],
            boardCards: ['Qh', '8s', '3c', '2d', '6h'],
            potBb: 88,
            spr: 0.55,
            effectiveStackBb: 48,
            boardTexture: 'Runout seco',
            rangeAdvantage: 'BTN 4bettor',
            nutAdvantage: 'BTN',
            actions: ['BTN abre 2.5 BB', 'BB 3bet 10 BB', 'BTN 4bet 23 BB', 'BB paga', 'Flop Qh 8s 3c · BB check · BTN bet 25% · BB paga', 'Turn 2d · check/check', 'River 6h · BB check', 'Hero actúa'],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'La mano/equity y el SPR bajo justifican máxima presión por valor o fold equity.',
            solverNote: 'Con SPR bajo, jam es una herramienta estándar cuando la mano tiene valor o equity robusta.',
            grades: ['CHECK' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Controla bote, pero pierde valor o fold equity.'], 'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Línea posible, aunque no es la mejor.'], 'JAM' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Máxima presión en SPR bajo.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function kkAceRiverCheck(): array
    {
        return self::spot(
            id: 'mastery_4bp_014',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'river_control_4bet',
            conceptLabel: 'Control River en 4Bet Pot',
            title: 'KK en runout con As river',
            street: 'river',
            heroPosition: 'SB',
            villainPosition: 'BTN',
            heroCards: ['Kc', 'Kd'],
            boardCards: ['Qd', '8c', '3s', '2h', 'As'],
            potBb: 76,
            spr: 0.8,
            effectiveStackBb: 61,
            boardTexture: 'Q-high hasta As river',
            rangeAdvantage: 'SB 4bettor',
            nutAdvantage: 'SB',
            actions: ['BTN abre 2.5 BB', 'SB 3bet 11 BB', 'BTN 4bet 24 BB', 'SB paga', 'Flop Qd 8c 3s · check/check', 'Turn 2h · SB bet 50% · BTN paga', 'River As', 'Hero actúa'],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'CHECK',
            explanation: 'La mano tiene showdown o el runout reduce mucho el valor de apostar.',
            solverNote: 'El check protege el rango y evita convertir manos medias en faroles malos.',
            grades: ['CHECK' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Controlas el bote.'], 'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Línea posible, aunque no es la mejor.'], 'JAM' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 38, 'feedback' => 'Demasiado grande para la textura o fuerza de mano.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function akRiverBluffCatch(): array
    {
        return self::spot(
            id: 'mastery_4bp_015',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'river_bluffcatch_4bet',
            conceptLabel: 'Bluffcatch River en 4Bet Pot',
            title: 'AK top pair enfrenta jam river',
            street: 'river',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Kd'],
            boardCards: ['Ks', '8d', '4c', '2h', '7s'],
            potBb: 86,
            spr: 0.6,
            effectiveStackBb: 52,
            boardTexture: 'K-high seco',
            rangeAdvantage: 'BTN 4bettor',
            nutAdvantage: 'BTN',
            actions: ['BTN abre 2.5 BB', 'BB 3bet 10 BB', 'BTN 4bet 23 BB', 'BB paga', 'Flop Ks 8d 4c · BB check · BTN bet 25% · BB paga', 'Turn 2h · check/check', 'River 7s', 'BB jam', 'Hero actúa'],
            options: ['FOLD', 'CALL'],
            correctAction: 'CALL',
            explanation: 'La mano está demasiado alta en rango para foldear ante la apuesta actual.',
            solverNote: 'Contra sizing pequeño o rango polar, esta mano defiende bien.',
            grades: ['FOLD' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 35, 'feedback' => 'Demasiado débil para este spot.'], 'CALL' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Buen bluffcatch/continuación.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function a5sMissedRiverBluff(): array
    {
        return self::spot(
            id: 'mastery_4bp_016',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'river_bluff_4bet_pot',
            conceptLabel: 'Bluff River en 4Bet Pot',
            title: 'A5s falla proyecto y decide river',
            street: 'river',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['As', '5s'],
            boardCards: ['Ks', '8s', '3d', '2c', 'Jd'],
            potBb: 82,
            spr: 0.7,
            effectiveStackBb: 57,
            boardTexture: 'K-high con missed flush',
            rangeAdvantage: 'BTN 4bettor',
            nutAdvantage: 'BTN',
            actions: ['BTN abre 2.5 BB', 'BB 3bet 10 BB', 'BTN 4bet 23 BB', 'BB paga', 'Flop Ks 8s 3d · BB check · BTN bet 25% · BB paga', 'Turn 2c · check/check', 'River Jd · BB check', 'Hero actúa'],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'La mano/equity y el SPR bajo justifican máxima presión por valor o fold equity.',
            solverNote: 'Con SPR bajo, jam es una herramienta estándar cuando la mano tiene valor o equity robusta.',
            grades: ['CHECK' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Controla bote, pero pierde valor o fold equity.'], 'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Línea posible, aunque no es la mejor.'], 'JAM' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Máxima presión en SPR bajo.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function qqRiverValueJam(): array
    {
        return self::spot(
            id: 'mastery_4bp_017',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'river_thin_value_4bet',
            conceptLabel: 'Thin Value River en 4Bet Pot',
            title: 'QQ busca valor fino en river bajo',
            street: 'river',
            heroPosition: 'CO',
            villainPosition: 'BTN',
            heroCards: ['Qh', 'Qs'],
            boardCards: ['9c', '7d', '3s', '2h', '5c'],
            potBb: 78,
            spr: 0.75,
            effectiveStackBb: 59,
            boardTexture: 'Runout bajo',
            rangeAdvantage: 'CO 4bettor',
            nutAdvantage: 'CO',
            actions: ['CO abre 2.5 BB', 'BTN 3bet 8 BB', 'CO 4bet 22 BB', 'BTN paga', 'Flop 9c 7d 3s · CO bet 25% · BTN paga', 'Turn 2h · check/check', 'River 5c', 'Hero actúa'],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'La mano/equity y el SPR bajo justifican máxima presión por valor o fold equity.',
            solverNote: 'Con SPR bajo, jam es una herramienta estándar cuando la mano tiene valor o equity robusta.',
            grades: ['CHECK' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Controla bote, pero pierde valor o fold equity.'], 'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Línea posible, aunque no es la mejor.'], 'JAM' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Máxima presión en SPR bajo.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function jjRiverFoldBadRunout(): array
    {
        return self::spot(
            id: 'mastery_4bp_018',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'river_fold_medium_pair_4bet',
            conceptLabel: 'Foldear Par Medio River',
            title: 'JJ enfrenta jam en river malo',
            street: 'river',
            heroPosition: 'BTN',
            villainPosition: 'SB',
            heroCards: ['Jh', 'Jd'],
            boardCards: ['Qh', '8h', '4c', 'Ah', '7s'],
            potBb: 82,
            spr: 0.7,
            effectiveStackBb: 58,
            boardTexture: 'Overcards y color completado',
            rangeAdvantage: 'SB',
            nutAdvantage: 'SB',
            actions: ['BTN abre 2.5 BB', 'SB 3bet 11 BB', 'BTN 4bet 24 BB', 'SB paga', 'Flop Qh 8h 4c · SB check · BTN check', 'Turn Ah · SB bet 50% · BTN paga', 'River 7s', 'SB jam', 'Hero actúa'],
            options: ['FOLD', 'CALL'],
            correctAction: 'FOLD',
            explanation: 'El runout y la acción reducen demasiado el valor de la mano. Foldear conserva EV.',
            solverNote: 'Los bluffcatchers malos sin blockers relevantes deben abandonar frente a líneas fuertes.',
            grades: ['FOLD' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Fold disciplinado.'], 'CALL' => ['grade' => 'marginal', 'frequency' => 25, 'ev_score' => 58, 'feedback' => 'Puede ser aceptable en algunos perfiles, pero no maximiza EV.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function aksComboDrawFlopJam(): array
    {
        return self::spot(
            id: 'mastery_4bp_019',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'combo_draw_jam_4bet',
            conceptLabel: 'Combo Draw Jam en 4Bet Pot',
            title: 'AKs con overcards y flush draw en flop',
            street: 'flop',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Ah', 'Kh'],
            boardCards: ['Qh', '7h', '2c'],
            potBb: 48,
            spr: 1.5,
            effectiveStackBb: 72,
            boardTexture: 'Q-high con nut flush draw',
            rangeAdvantage: 'BTN 4bettor',
            nutAdvantage: 'Compartida',
            actions: ['BTN abre 2.5 BB', 'BB 3bet 10 BB', 'BTN 4bet 23 BB', 'BB paga', 'Flop Qh 7h 2c', 'Hero actúa primero'],
            options: ['CHECK', 'BET_25', 'JAM'],
            correctAction: 'JAM',
            explanation: 'La mano/equity y el SPR bajo justifican máxima presión por valor o fold equity.',
            solverNote: 'Con SPR bajo, jam es una herramienta estándar cuando la mano tiene valor o equity robusta.',
            grades: ['CHECK' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Controla bote, pero pierde valor o fold equity.'], 'BET_25' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Línea posible, aunque no es la mejor.'], 'JAM' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Máxima presión en SPR bajo.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

    protected static function aaTurnValueBetDryBoard(): array
    {
        return self::spot(
            id: 'mastery_4bp_020',
            module: 'four_bet_pots',
            moduleLabel: '4Bet Pots',
            concept: 'turn_value_4bet_pot',
            conceptLabel: 'Value Turn en 4Bet Pot',
            title: 'AA apuesta turn seco para valor',
            street: 'turn',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Ad', 'Ac'],
            boardCards: ['Kc', '7d', '2s', '2h'],
            potBb: 60,
            spr: 1.2,
            effectiveStackBb: 72,
            boardTexture: 'K-high emparejado seco',
            rangeAdvantage: 'BTN 4bettor',
            nutAdvantage: 'BTN',
            actions: ['BTN abre 2.5 BB', 'BB 3bet 10 BB', 'BTN 4bet 23 BB', 'BB paga', 'Flop Kc 7d 2s · BB check · BTN bet 25% · BB paga', 'Turn 2h · BB check', 'Hero actúa'],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'BET_50',
            explanation: 'Apuesta media extrae valor sin espantar tanto como el all-in.',
            solverNote: 'Value bet medio funciona bien cuando aún quieres calls de manos peores.',
            grades: ['CHECK' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Controla bote, pero pierde valor o fold equity.'], 'BET_50' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Buen value.'], 'JAM' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 38, 'feedback' => 'Demasiado grande para la textura o fuerza de mano.']],
            gtoInsight: 'GTO simplificado: en 4Bet pots el SPR bajo hace que cada apuesta tenga mucho apalancamiento.',
            lowStakesInsight: 'En NL2-NL10 prioriza valor claro; los bluffs grandes deben usarse contra rivales capaces de foldear.',
            confidence: 85
        );
    }

}
