<?php

namespace App\SpotTraining\Mastery\Modules;

use App\SpotTraining\Mastery\Concerns\BuildsMasterySpots;

class ThreeBetPotSpots
{
    use BuildsMasterySpots;

    public static function all(): array
    {
        return [
            self::kkOopAHighDryFlop(),
            self::aqIpTopPairFlop(),
            self::jjOopLowFlop(),
            self::akMissedLowConnectedFlop(),
            self::qqIpKHighFlop(),
            self::a5sNutFlushDrawFlop(),
            self::ttOopPairedBoardFlop(),
            self::kqsIpTwoOversBackdoorFlop(),
            self::aaTurnSecondBarrelSafeCard(),
            self::akTurnBarrelOvercard(),
            self::qqTurnBadAceCard(),
            self::aJsTurnFlushCompletes(),
            self::kkRiverThinValue(),
            self::aqRiverBluffCatch(),
            self::a5sRiverMissedDrawBluff(),
            self::jjRiverScaryRunout(),
            self::aaLowSprTurnJam(),
            self::akRiverValueTopPair(),
            self::kqsTurnDelayedCbet(),
            self::ttRiverBlockBet(),
        ];
    }

    protected static function kkOopAHighDryFlop(): array
    {
        return self::spot(
            id: 'mastery_3bp_001',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'cbet_3bet_pot',
            conceptLabel: 'CBet en 3Bet Pot',
            title: 'BB 3bet vs BTN · KK en flop A-high seco',
            street: 'flop',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Kh', 'Kc'],
            boardCards: ['As', '7d', '2c'],
            potBb: 20.5,
            spr: 4.2,
            effectiveStackBb: 86,
            boardTexture: 'A-high seco',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BB ligera',
            actions: [
                'BTN abre 2.5 BB',
                'BB 3bet 10 BB',
                'BTN paga',
                'Flop As 7d 2c',
                'Hero actúa primero',
            ],
            options: ['CHECK', 'BET_33', 'BET_75'],
            correctAction: 'BET_33',
            explanation: 'En 3Bet pot sobre A-high seco, el 3bettor mantiene ventaja de rango. KK no ama el As, pero apuesta pequeño para presionar pares medios y capturar fold equity.',
            solverNote: 'El sizing pequeño permite apostar amplio sin comprometer demasiado stack con manos medias.',
            grades: [
                'BET_33' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Apuesta pequeña y aprovecha la ventaja de rango.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Aceptable, pero cedes iniciativa en un board donde puedes presionar mucho.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 0, 'ev_score' => 45, 'feedback' => 'Demasiado grande. Aíslas contra Ax y tiras manos peores.'],
            ],
            gtoInsight: 'GTO simplificado: en A-high secos dentro de 3Bet pot, el agresor puede usar cbet pequeña con alta frecuencia.',
            lowStakesInsight: 'En NL2-NL10 el bet pequeño funciona muy bien porque muchos pagan flop débil y foldean demasiado en turn.',
            confidence: 84
        );
    }

    protected static function aqIpTopPairFlop(): array
    {
        return self::spot(
            id: 'mastery_3bp_002',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'value_cbet_3bet_pot',
            conceptLabel: 'Value CBet en 3Bet Pot',
            title: 'BTN paga 3bet · AQ top pair en posición',
            street: 'flop',
            heroPosition: 'BTN',
            villainPosition: 'SB',
            heroCards: ['Ah', 'Qh'],
            boardCards: ['Qs', '8d', '3c'],
            potBb: 21,
            spr: 4.0,
            effectiveStackBb: 84,
            boardTexture: 'Q-high seco',
            rangeAdvantage: 'SB 3bettor',
            nutAdvantage: 'SB ligera',
            actions: [
                'BTN abre 2.5 BB',
                'SB 3bet 11 BB',
                'BTN paga',
                'Flop Qs 8d 3c',
                'SB check',
                'Hero actúa en posición',
            ],
            options: ['CHECK', 'BET_33', 'BET_75'],
            correctAction: 'BET_33',
            explanation: 'Con top pair top kicker en posición tras check del 3bettor, apostar pequeño extrae valor de JJ-TT, 8x y floats, manteniendo dominadas muchas manos peores.',
            solverNote: 'En posición se puede apostar pequeño con rango polar/lineal según el check del agresor.',
            grades: [
                'BET_33' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Sacas valor sin aislarte contra manos mejores.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 86, 'feedback' => 'Check back es viable para controlar bote, pero pierdes valor contra peores.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 66, 'feedback' => 'No es terrible, pero demasiado grande contra un rango que puede estar débil.'],
            ],
            gtoInsight: 'GTO simplificado: después del check del agresor, IP puede apostar pequeño muchas top pairs para protección y valor.',
            lowStakesInsight: 'En microlímites, apostar pequeño aquí imprime valor porque pagan demasiado con pares peores.',
            confidence: 82
        );
    }

    protected static function jjOopLowFlop(): array
    {
        return self::spot(
            id: 'mastery_3bp_003',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'overpair_3bet_pot',
            conceptLabel: 'Overpair en 3Bet Pot',
            title: 'SB 3bet vs CO · JJ en board bajo',
            street: 'flop',
            heroPosition: 'SB',
            villainPosition: 'CO',
            heroCards: ['Jh', 'Jd'],
            boardCards: ['8s', '5c', '2d'],
            potBb: 22,
            spr: 3.8,
            effectiveStackBb: 83,
            boardTexture: 'Bajo seco',
            rangeAdvantage: 'SB 3bettor',
            nutAdvantage: 'SB',
            actions: [
                'CO abre 2.5 BB',
                'SB 3bet 11 BB',
                'CO paga',
                'Flop 8s 5c 2d',
                'Hero actúa primero',
            ],
            options: ['CHECK', 'BET_33', 'BET_75'],
            correctAction: 'BET_33',
            explanation: 'JJ es overpair fuerte. En 3Bet pot OOP conviene apostar pequeño para cobrar a pares peores, overcards y gutshots sin inflar el bote innecesariamente.',
            solverNote: 'Overpairs medias en boards secos prefieren frecuencia alta con sizing pequeño.',
            grades: [
                'BET_33' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Valor y protección con sizing eficiente.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 20, 'ev_score' => 82, 'feedback' => 'Puede funcionar explotativamente, pero reduce calls peores.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 62, 'feedback' => 'Demasiado pasivo. Das carta gratis a overcards.'],
            ],
            gtoInsight: 'GTO simplificado: overpairs en boards bajos dentro de 3Bet pot pueden apostar pequeño con frecuencia alta.',
            lowStakesInsight: 'En NL2-NL10 muchos pagan con 99-TT, A8s y overcards. Apostar por valor es mejor que ponerse tricky.',
            confidence: 86
        );
    }

    protected static function akMissedLowConnectedFlop(): array
    {
        return self::spot(
            id: 'mastery_3bp_004',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'missed_ak_3bet_pot',
            conceptLabel: 'AK fallado en 3Bet Pot',
            title: 'BB 3bet vs BTN · AK falla en board conectado',
            street: 'flop',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Ad', 'Kh'],
            boardCards: ['9s', '8s', '6c'],
            potBb: 20,
            spr: 4.4,
            effectiveStackBb: 88,
            boardTexture: 'Medio conectado',
            rangeAdvantage: 'BTN caller',
            nutAdvantage: 'BTN',
            actions: [
                'BTN abre 2.5 BB',
                'BB 3bet 10 BB',
                'BTN paga',
                'Flop 9s 8s 6c',
                'Hero actúa primero',
            ],
            options: ['CHECK', 'BET_33', 'BET_75'],
            correctAction: 'CHECK',
            explanation: 'Este board conecta mucho con el rango que paga en BTN. AK sin proyecto fuerte no quiere apostar automáticamente contra un rango con pares, escaleras y proyectos.',
            solverNote: 'Los boards medios conectados reducen la frecuencia de cbet del 3bettor OOP.',
            grades: [
                'CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. No fuerces cbet en textura mala para tu rango.'],
                'BET_33' => ['grade' => 'marginal', 'frequency' => 25, 'ev_score' => 61, 'feedback' => 'Puede mezclar algo, pero no debe ser automático.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 20, 'feedback' => 'Muy mal. Apostar grande sin equity suficiente en esta textura quema dinero.'],
            ],
            gtoInsight: 'GTO simplificado: cuando el board favorece al caller, el agresor OOP reduce cbet y protege su rango de check.',
            lowStakesInsight: 'En micros te pagan demasiado en estos boards. No farolees grande sin equity.',
            confidence: 88
        );
    }

    protected static function qqIpKHighFlop(): array
    {
        return self::spot(
            id: 'mastery_3bp_005',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'second_pair_3bet_pot',
            conceptLabel: 'Segundo par en 3Bet Pot',
            title: 'CO paga 3bet · QQ en flop K-high',
            street: 'flop',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['Qh', 'Qs'],
            boardCards: ['Kd', '7c', '3s'],
            potBb: 20.5,
            spr: 4.1,
            effectiveStackBb: 84,
            boardTexture: 'K-high seco',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BB',
            actions: [
                'CO abre 2.5 BB',
                'BB 3bet 10 BB',
                'CO paga',
                'Flop Kd 7c 3s',
                'BB apuesta 33%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'CALL',
            explanation: 'QQ sigue siendo una mano demasiado fuerte para foldear ante cbet pequeña. No necesita raisear porque aislaría contra Kx fuerte y overpairs.',
            solverNote: 'Frente a sizing pequeño, pares medios-altos continúan con alta frecuencia.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 85, 'ev_score' => 100, 'feedback' => 'Correcto. Pagas contra rango amplio y mantienes bluffs dentro.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 18, 'feedback' => 'Demasiado nit. QQ no puede foldear a una cbet pequeña aquí.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 42, 'feedback' => 'Raise convierte una mano con showdown en farol sin necesidad.'],
            ],
            gtoInsight: 'GTO simplificado: contra cbet pequeña en 3Bet pot, QQ suele ser call claro como bluffcatcher/protección.',
            lowStakesInsight: 'En NL2-NL10 paga. Muchos hacen cbet automática con AQ, AJ, TT-JJ.',
            confidence: 87
        );
    }

    protected static function a5sNutFlushDrawFlop(): array
    {
        return self::spot(
            id: 'mastery_3bp_006',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'semi_bluff_3bet_pot',
            conceptLabel: 'Semi-bluff en 3Bet Pot',
            title: 'BTN paga 3bet · A5s con nut flush draw',
            street: 'flop',
            heroPosition: 'BTN',
            villainPosition: 'SB',
            heroCards: ['Ah', '5h'],
            boardCards: ['Kh', '9h', '4c'],
            potBb: 21.5,
            spr: 3.9,
            effectiveStackBb: 84,
            boardTexture: 'K-high con proyecto color',
            rangeAdvantage: 'SB 3bettor',
            nutAdvantage: 'SB ligera',
            actions: [
                'BTN abre 2.5 BB',
                'SB 3bet 11 BB',
                'BTN paga',
                'Flop Kh 9h 4c',
                'SB apuesta 33%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE_3X'],
            correctAction: 'CALL',
            explanation: 'Con nut flush draw y As blocker, pagar es estándar. Raise puede existir, pero no hace falta inflar contra un rango fuerte del 3bettor.',
            solverNote: 'Los nut flush draws mezclan calls y raises; IP call conserva rango y realiza equity.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Tienes equity, posición y realizas bien.'],
                'RAISE_3X' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 86, 'feedback' => 'También puede ser bueno como semi-bluff, pero no siempre.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Fold es gravísimo con nut flush draw.'],
            ],
            gtoInsight: 'GTO simplificado: nut draws en posición tienen suficiente equity para continuar siempre y mezclar raises.',
            lowStakesInsight: 'En micros prefiero pagar mucho: te pagan raises con top pair y no generas suficiente fold equity.',
            confidence: 83
        );
    }

    protected static function ttOopPairedBoardFlop(): array
    {
        return self::spot(
            id: 'mastery_3bp_007',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'paired_board_3bet_pot',
            conceptLabel: 'Board emparejado en 3Bet Pot',
            title: 'SB 3bet vs BTN · TT en board emparejado',
            street: 'flop',
            heroPosition: 'SB',
            villainPosition: 'BTN',
            heroCards: ['Td', 'Tc'],
            boardCards: ['8h', '8c', '3d'],
            potBb: 21,
            spr: 4.0,
            effectiveStackBb: 84,
            boardTexture: 'Board emparejado seco',
            rangeAdvantage: 'SB 3bettor',
            nutAdvantage: 'Compartida',
            actions: [
                'BTN abre 2.5 BB',
                'SB 3bet 11 BB',
                'BTN paga',
                'Flop 8h 8c 3d',
                'Hero actúa primero',
            ],
            options: ['CHECK', 'BET_25', 'BET_75'],
            correctAction: 'BET_25',
            explanation: 'TT es una overpair fuerte en un board seco y emparejado. El sizing pequeño niega equity a overcards y obtiene valor de pares peores.',
            solverNote: 'En boards emparejados secos, el 3bettor puede usar sizing pequeño con amplio rango.',
            grades: [
                'BET_25' => ['grade' => 'best', 'frequency' => 75, 'ev_score' => 100, 'feedback' => 'Correcto. Sizing pequeño, rango amplio y buena protección.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 82, 'feedback' => 'Check es viable, pero apuesta pequeña captura más valor.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 0, 'ev_score' => 38, 'feedback' => 'Demasiado grande. No necesitas polarizar aquí.'],
            ],
            gtoInsight: 'GTO simplificado: boards paired secos favorecen apuestas pequeñas de alta frecuencia.',
            lowStakesInsight: 'En NL2-NL10 te pagan con A-high, 55-77, 99 y floats. Apuesta pequeño por valor/protección.',
            confidence: 85
        );
    }

    protected static function kqsIpTwoOversBackdoorFlop(): array
    {
        return self::spot(
            id: 'mastery_3bp_008',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'float_3bet_pot',
            conceptLabel: 'Float en 3Bet Pot',
            title: 'CO paga 3bet · KQs con overcards y backdoors',
            street: 'flop',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['Ks', 'Qs'],
            boardCards: ['Jd', '7s', '2c'],
            potBb: 20,
            spr: 4.5,
            effectiveStackBb: 90,
            boardTexture: 'J-high seco',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BB ligera',
            actions: [
                'CO abre 2.5 BB',
                'BB 3bet 10 BB',
                'CO paga',
                'Flop Jd 7s 2c',
                'BB apuesta 33%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'CALL',
            explanation: 'KQs tiene dos overcards, backdoor flush y backdoor straight. Contra sizing pequeño, foldear es demasiado débil.',
            solverNote: 'Overcards con backdoors continúan ante sizings pequeños en posición.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Tu mano tiene suficiente equity y jugabilidad.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 15, 'ev_score' => 45, 'feedback' => 'Demasiado tight contra apuesta pequeña.'],
                'RAISE' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 58, 'feedback' => 'No es el mejor combo para raisear; prefieres proyectos más fuertes.'],
            ],
            gtoInsight: 'GTO simplificado: IP debe defender suficientes floats con overcards y backdoors para no sobre-foldear.',
            lowStakesInsight: 'En micros, paga flop y abandona turns malos si el rival sigue fuerte.',
            confidence: 80
        );
    }

    protected static function aaTurnSecondBarrelSafeCard(): array
    {
        return self::spot(
            id: 'mastery_3bp_009',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'turn_barrel_3bet_pot',
            conceptLabel: 'Segundo barrel en 3Bet Pot',
            title: 'AA en turn seguro tras cbet flop',
            street: 'turn',
            heroPosition: 'SB',
            villainPosition: 'BTN',
            heroCards: ['Ac', 'Ad'],
            boardCards: ['Qs', '8d', '3c', '2h'],
            potBb: 35,
            spr: 2.1,
            effectiveStackBb: 74,
            boardTexture: 'Q-high seco · turn blank',
            rangeAdvantage: 'SB 3bettor',
            nutAdvantage: 'SB',
            actions: [
                'BTN abre 2.5 BB',
                'SB 3bet 11 BB',
                'BTN paga',
                'Flop Qs 8d 3c',
                'SB apuesta 33%',
                'BTN paga',
                'Turn 2h',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_75', 'JAM'],
            correctAction: 'BET_75',
            explanation: 'El turn 2h no cambia nada. AA sigue muy por delante y quiere construir bote contra Qx, JJ-TT y floats.',
            solverNote: 'Con SPR bajo, overpairs fuertes empiezan a polarizar y preparar river jam.',
            grades: [
                'BET_75' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Construyes bote con mano premium.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 88, 'feedback' => 'También correcto, aunque algo menos presión.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 48, 'feedback' => 'Pierdes valor contra muchas manos peores.'],
                'JAM' => ['grade' => 'marginal', 'frequency' => 5, 'ev_score' => 60, 'feedback' => 'Demasiado grande salvo rival muy pagador.'],
            ],
            gtoInsight: 'GTO simplificado: en SPR bajo, overpairs fuertes quieren apostar turn para dejar river cómodo.',
            lowStakesInsight: 'En NL2-NL10 apuesta fuerte por valor. Te pagan Qx y pares medios más de lo que deberían.',
            confidence: 86
        );
    }

    protected static function akTurnBarrelOvercard(): array
    {
        return self::spot(
            id: 'mastery_3bp_010',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'turn_barrel_overcard',
            conceptLabel: 'Barrel Turn Overcard',
            title: 'AK gana top pair en turn',
            street: 'turn',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['As', 'Kd'],
            boardCards: ['Qh', '7c', '2d', 'Kc'],
            potBb: 34,
            spr: 2.3,
            effectiveStackBb: 78,
            boardTexture: 'Broadway seco · K turn',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BB',
            actions: [
                'BTN abre 2.5 BB',
                'BB 3bet 10 BB',
                'BTN paga',
                'Flop Qh 7c 2d',
                'BB apuesta 33%',
                'BTN paga',
                'Turn Kc',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_75'],
            correctAction: 'BET_75',
            explanation: 'El K mejora muchísimo a Hero. AK ahora tiene top pair top kicker y puede apostar fuerte contra Qx, KQ parcial y pares con gutshots.',
            solverNote: 'Las overcards que favorecen al agresor permiten aumentar presión en turn.',
            grades: [
                'BET_75' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Turn excelente para segundo barrel de valor.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 88, 'feedback' => 'Bien, aunque dejas algo de valor.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 40, 'feedback' => 'Demasiado pasivo con una carta tan favorable.'],
            ],
            gtoInsight: 'GTO simplificado: cuando el turn favorece al 3bettor, aumenta la frecuencia y tamaño de barrel.',
            lowStakesInsight: 'En micros es apuesta clara. No des cartas gratis a JT, AT, AJ o Qx.',
            confidence: 84
        );
    }

    protected static function qqTurnBadAceCard(): array
    {
        return self::spot(
            id: 'mastery_3bp_011',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'turn_bad_card_control',
            conceptLabel: 'Control en Turn Malo',
            title: 'QQ en turn As tras cbet flop',
            street: 'turn',
            heroPosition: 'SB',
            villainPosition: 'CO',
            heroCards: ['Qd', 'Qc'],
            boardCards: ['Jc', '7d', '3h', 'As'],
            potBb: 33,
            spr: 2.5,
            effectiveStackBb: 82,
            boardTexture: 'J-high seco · As turn',
            rangeAdvantage: 'SB 3bettor',
            nutAdvantage: 'SB',
            actions: [
                'CO abre 2.5 BB',
                'SB 3bet 11 BB',
                'CO paga',
                'Flop Jc 7d 3h',
                'SB apuesta 33%',
                'CO paga',
                'Turn As',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_75'],
            correctAction: 'CHECK',
            explanation: 'El As favorece parte del rango de Hero, pero QQ pierde valor claro. Apostar convierte una mano media con showdown en bluff/value confuso.',
            solverNote: 'Pares bajo la overcard pueden entrar en rango de check para protegerlo.',
            grades: [
                'CHECK' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Controlas bote y proteges tu rango de check.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 25, 'ev_score' => 62, 'feedback' => 'Puede negar equity, pero no es value cómodo.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 35, 'feedback' => 'Demasiado grande con una mano que ya no quiere bote enorme.'],
            ],
            gtoInsight: 'GTO simplificado: no todas las cartas buenas para el rango permiten apostar todas las manos medias.',
            lowStakesInsight: 'En NL2-NL10 check es mejor. Si te pagan turn, casi nunca vas muy por delante.',
            confidence: 82
        );
    }

    protected static function aJsTurnFlushCompletes(): array
    {
        return self::spot(
            id: 'mastery_3bp_012',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'turn_flush_completes',
            conceptLabel: 'Turn completa color',
            title: 'AJ con top pair cuando completa color',
            street: 'turn',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Jh'],
            boardCards: ['Jc', '8c', '4d', '2c'],
            potBb: 32,
            spr: 2.6,
            effectiveStackBb: 84,
            boardTexture: 'Color completado',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BTN caller',
            actions: [
                'BTN abre 2.5 BB',
                'BB 3bet 10 BB',
                'BTN paga',
                'Flop Jc 8c 4d',
                'BB apuesta 33%',
                'BTN paga',
                'Turn 2c',
                'BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_75'],
            correctAction: 'CHECK',
            explanation: 'Top pair sin trébol tiene showdown, pero no quiere apostar grande cuando se completa el color. Check back realiza equity y evita check-raise incómodo.',
            solverNote: 'Cuando completa el flush y Hero no bloquea color, muchas top pairs prefieren check back.',
            grades: [
                'CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Controlas bote en carta peligrosa.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 55, 'feedback' => 'Apuesta fina y vulnerable a check-raise.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 0, 'ev_score' => 28, 'feedback' => 'Demasiado grande. Te aíslas contra color y manos fuertes.'],
            ],
            gtoInsight: 'GTO simplificado: en turns que completan proyectos, las manos medias sin blocker fuerte bajan agresión.',
            lowStakesInsight: 'En micros, cuando completa color y te check-raisean, casi siempre vas muerto. Controla bote.',
            confidence: 83
        );
    }

    protected static function kkRiverThinValue(): array
    {
        return self::spot(
            id: 'mastery_3bp_013',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'river_thin_value_3bet_pot',
            conceptLabel: 'Thin Value River en 3Bet Pot',
            title: 'KK busca value fino en river',
            street: 'river',
            heroPosition: 'SB',
            villainPosition: 'BTN',
            heroCards: ['Ks', 'Kd'],
            boardCards: ['Qh', '8c', '4d', '2s', '7c'],
            potBb: 58,
            spr: 1.1,
            effectiveStackBb: 64,
            boardTexture: 'Runout seco',
            rangeAdvantage: 'SB 3bettor',
            nutAdvantage: 'SB',
            actions: [
                'BTN abre 2.5 BB',
                'SB 3bet 11 BB',
                'BTN paga',
                'Flop Qh 8c 4d · SB bet 33% · BTN paga',
                'Turn 2s · SB bet 75% · BTN paga',
                'River 7c',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'BET_50',
            explanation: 'KK sigue ganando a muchas Qx y pares. El jam puede ser demasiado grande, pero medio bote obtiene calls de peor.',
            solverNote: 'Con SPR cercano a 1, se mezclan jams y sizings medios; exploitativamente medio bote maximiza calls peores.',
            grades: [
                'BET_50' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Value claro sin espantar demasiado.'],
                'JAM' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 84, 'feedback' => 'Puede ser bueno contra calling stations, pero no siempre.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 44, 'feedback' => 'Pierdes demasiado valor contra Qx.'],
            ],
            gtoInsight: 'GTO simplificado: overpairs fuertes en runouts seguros siguen apostando river por valor.',
            lowStakesInsight: 'En NL2-NL10 apuesta. La gente paga demasiado con top pair.',
            confidence: 86
        );
    }

    protected static function aqRiverBluffCatch(): array
    {
        return self::spot(
            id: 'mastery_3bp_014',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'river_bluff_catch_3bet_pot',
            conceptLabel: 'Bluffcatch River en 3Bet Pot',
            title: 'AQ bluffcatch vs triple barrel',
            street: 'river',
            heroPosition: 'BTN',
            villainPosition: 'SB',
            heroCards: ['Ad', 'Qd'],
            boardCards: ['Qs', '9c', '4h', '2d', '8s'],
            potBb: 72,
            spr: 0.8,
            effectiveStackBb: 58,
            boardTexture: 'Q-high sin proyectos completados',
            rangeAdvantage: 'SB 3bettor',
            nutAdvantage: 'SB ligera',
            actions: [
                'BTN abre 2.5 BB',
                'SB 3bet 11 BB',
                'BTN paga',
                'Flop Qs 9c 4h · SB bet 33% · BTN paga',
                'Turn 2d · SB bet 75% · BTN paga',
                'River 8s',
                'SB jam',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL'],
            correctAction: 'CALL',
            explanation: 'AQ bloquea top pair fuerte y gana a missed bluffs. En SPR bajo y sin proyectos obvios completados, foldear top pair top kicker es demasiado tight.',
            solverNote: 'Top pair top kicker con buenos blockers suele defender contra jam polar si el rango rival contiene suficientes bluffs.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. AQ está muy arriba en tu rango.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 30, 'ev_score' => 40, 'feedback' => 'Demasiado nit contra una línea que puede polarizar bluffs.'],
            ],
            gtoInsight: 'GTO simplificado: en 3Bet pot con SPR bajo, TPTK suele estar obligado a bluffcatchear en muchos runouts.',
            lowStakesInsight: 'En micros depende del rival: contra nit extremo puedes foldear, pero por defecto AQ es call demasiado alto en rango.',
            confidence: 79
        );
    }

    protected static function a5sRiverMissedDrawBluff(): array
    {
        return self::spot(
            id: 'mastery_3bp_015',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'river_bluff_3bet_pot',
            conceptLabel: 'Bluff River en 3Bet Pot',
            title: 'A5s falla color y usa blocker para bluff',
            street: 'river',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['As', '5s'],
            boardCards: ['Ks', '9s', '4d', '2h', 'Jc'],
            potBb: 64,
            spr: 1.0,
            effectiveStackBb: 65,
            boardTexture: 'K-high · proyectos fallidos',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BB',
            actions: [
                'BTN abre 2.5 BB',
                'BB 3bet 10 BB',
                'BTN paga',
                'Flop Ks 9s 4d · BB bet 33% · BTN paga',
                'Turn 2h · BB bet 75% · BTN paga',
                'River Jc',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_75', 'JAM'],
            correctAction: 'JAM',
            explanation: 'A5s falló, pero bloquea nut flush draws y algunos Ax suited. Sin showdown value, es buen candidato para bluff polar en river.',
            solverNote: 'Los bluffs river se seleccionan con blockers y bajo showdown value.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 45, 'ev_score' => 100, 'feedback' => 'Correcto. Buen blocker y cero showdown value.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'También presiona, aunque jam maximiza fold equity.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 25, 'ev_score' => 38, 'feedback' => 'Check abandona una mano que casi nunca gana al showdown.'],
            ],
            gtoInsight: 'GTO simplificado: missed draws con blockers relevantes son candidatos naturales a bluff river.',
            lowStakesInsight: 'Cuidado en NL2-NL10: usa este bluff contra rivales capaces de foldear. Contra calling station, check y rendirse puede ser mejor.',
            confidence: 76
        );
    }

    protected static function jjRiverScaryRunout(): array
    {
        return self::spot(
            id: 'mastery_3bp_016',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'river_check_medium_showdown',
            conceptLabel: 'Check River con Showdown Medio',
            title: 'JJ en river con overcards y proyectos completados',
            street: 'river',
            heroPosition: 'SB',
            villainPosition: 'CO',
            heroCards: ['Jh', 'Jd'],
            boardCards: ['9c', '7c', '3s', 'Kc', 'Ah'],
            potBb: 52,
            spr: 1.4,
            effectiveStackBb: 74,
            boardTexture: 'Runout malo con overcards y color',
            rangeAdvantage: 'CO caller',
            nutAdvantage: 'CO',
            actions: [
                'CO abre 2.5 BB',
                'SB 3bet 11 BB',
                'CO paga',
                'Flop 9c 7c 3s · SB bet 33% · CO paga',
                'Turn Kc · check/check',
                'River Ah',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'CHECK',
            explanation: 'JJ tiene showdown muy marginal. Apostar no consigue suficiente value y como bluff bloquea pocas manos que foldean. Check es estándar.',
            solverNote: 'Manos medias que no bloquean calls fuertes ni desbloquean folds deben entrar en check.',
            grades: [
                'CHECK' => ['grade' => 'best', 'frequency' => 80, 'ev_score' => 100, 'feedback' => 'Correcto. No conviertas JJ en bluff malo.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 38, 'feedback' => 'No te paga peor lo suficiente ni foldea mejor bastante.'],
                'JAM' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 12, 'feedback' => 'Bluff muy malo. El rival tiene demasiados Ax, Kx y colores.'],
            ],
            gtoInsight: 'GTO simplificado: no todas las manos con showdown marginal deben bluffear; se necesitan buenos blockers.',
            lowStakesInsight: 'En micros esto es check clarísimo. Si apuestas, te pagan manos mejores y foldean peores.',
            confidence: 88
        );
    }

    protected static function aaLowSprTurnJam(): array
    {
        return self::spot(
            id: 'mastery_3bp_017',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'low_spr_turn_jam',
            conceptLabel: 'Jam Turn con SPR Bajo',
            title: 'AA en 3Bet pot con SPR bajo',
            street: 'turn',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Ah', 'Ac'],
            boardCards: ['Td', '7s', '4c', '2d'],
            potBb: 48,
            spr: 1.2,
            effectiveStackBb: 58,
            boardTexture: 'Bajo-medio con proyecto',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BB',
            actions: [
                'BTN abre 2.5 BB',
                'BB 3bet 12 BB',
                'BTN paga',
                'Flop Td 7s 4c · BB bet 50% · BTN paga',
                'Turn 2d',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'JAM',
            explanation: 'Con SPR 1.2, AA quiere negar equity a draws y cobrar a Tx/pares. Jam simplifica y maximiza valor.',
            solverNote: 'En SPR bajo, overpairs premium empujan mucho turn en cartas seguras o semiseguras.',
            grades: [
                'JAM' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. SPR bajo, valor claro y protección.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 87, 'feedback' => 'También bien, aunque deja decisiones incómodas river.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 32, 'feedback' => 'Demasiado pasivo. Das carta gratis a proyectos.'],
            ],
            gtoInsight: 'GTO simplificado: a menor SPR, menor necesidad de sizings pequeños; las manos fuertes pueden ir all-in antes.',
            lowStakesInsight: 'En NL2-NL10 jam es excelente. Te pagan Tx, JJ-QQ y draws más de la cuenta.',
            confidence: 87
        );
    }

    protected static function akRiverValueTopPair(): array
    {
        return self::spot(
            id: 'mastery_3bp_018',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'river_value_tptk',
            conceptLabel: 'Value River con TPTK',
            title: 'AK value river después de doble barrel',
            street: 'river',
            heroPosition: 'BB',
            villainPosition: 'CO',
            heroCards: ['Ad', 'Ks'],
            boardCards: ['Kh', '8s', '3d', '4c', 'Qd'],
            potBb: 60,
            spr: 1.0,
            effectiveStackBb: 62,
            boardTexture: 'K-high relativamente seco',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BB',
            actions: [
                'CO abre 2.5 BB',
                'BB 3bet 10 BB',
                'CO paga',
                'Flop Kh 8s 3d · BB bet 33% · CO paga',
                'Turn 4c · BB bet 75% · CO paga',
                'River Qd',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'JAM'],
            correctAction: 'BET_50',
            explanation: 'AK sigue sacando valor de KQ parcial, KJs, QQ/JJ que bluffcatchean y algunas manos tercas. Jam puede aislar demasiado.',
            solverNote: 'TPTK apuesta river por valor en muchos runouts, ajustando sizing según calls peores.',
            grades: [
                'BET_50' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Value rentable contra rango peor.'],
                'JAM' => ['grade' => 'marginal', 'frequency' => 25, 'ev_score' => 68, 'feedback' => 'Puede ser demasiado fino si el rival foldea Kx peor.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 15, 'ev_score' => 43, 'feedback' => 'Check pierde valor en microlímites.'],
            ],
            gtoInsight: 'GTO simplificado: TPTK en 3Bet pot suele valuebetear river cuando no se completan demasiadas manos mejores.',
            lowStakesInsight: 'En NL2-NL10 apuesta medio bote. Te pagan más manos peores de las que imaginas.',
            confidence: 85
        );
    }

    protected static function kqsTurnDelayedCbet(): array
    {
        return self::spot(
            id: 'mastery_3bp_019',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'delayed_cbet_3bet_pot',
            conceptLabel: 'Delayed CBet en 3Bet Pot',
            title: 'KQs delayed cbet en turn favorable',
            street: 'turn',
            heroPosition: 'SB',
            villainPosition: 'BTN',
            heroCards: ['Kh', 'Qh'],
            boardCards: ['As', '8c', '3d', 'Jh'],
            potBb: 22,
            spr: 3.7,
            effectiveStackBb: 82,
            boardTexture: 'A-high seco · turn broadway',
            rangeAdvantage: 'SB 3bettor',
            nutAdvantage: 'SB',
            actions: [
                'BTN abre 2.5 BB',
                'SB 3bet 11 BB',
                'BTN paga',
                'Flop As 8c 3d',
                'SB check',
                'BTN check',
                'Turn Jh',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_75'],
            correctAction: 'BET_50',
            explanation: 'Tras check/check flop, el J mejora equity de KQ con gutshot y backdoor hearts. Hero puede representar Ax/Jx fuerte y apostar turn.',
            solverNote: 'Delayed cbets usan cartas que mejoran equity o favorecen rango del agresor.',
            grades: [
                'BET_50' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Buena carta para atacar con equity.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 78, 'feedback' => 'Check es viable, pero desaprovecha fold equity.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 60, 'feedback' => 'Demasiado grande para una mano con equity pero no premium.'],
            ],
            gtoInsight: 'GTO simplificado: cuando el agresor checkea flop, puede recuperar iniciativa en turns que mejoran su rango/equity.',
            lowStakesInsight: 'En microlímites funciona bien contra rivales que stabearían Ax y ahora muestran debilidad.',
            confidence: 78
        );
    }

    protected static function ttRiverBlockBet(): array
    {
        return self::spot(
            id: 'mastery_3bp_020',
            module: 'three_bet_pots',
            moduleLabel: '3Bet Pots',
            concept: 'river_block_bet_3bet_pot',
            conceptLabel: 'Block Bet River en 3Bet Pot',
            title: 'TT hace block bet river en runout medio',
            street: 'river',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Th', 'Td'],
            boardCards: ['9s', '7d', '3c', '2h', 'Qh'],
            potBb: 42,
            spr: 1.7,
            effectiveStackBb: 72,
            boardTexture: 'Runout medio con Q river',
            rangeAdvantage: 'BB 3bettor',
            nutAdvantage: 'BB ligera',
            actions: [
                'BTN abre 2.5 BB',
                'BB 3bet 10 BB',
                'BTN paga',
                'Flop 9s 7d 3c · BB bet 33% · BTN paga',
                'Turn 2h · check/check',
                'River Qh',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_25', 'BET_75'],
            correctAction: 'BET_25',
            explanation: 'TT tiene valor fino contra 9x, 7x y pares peores, pero no quiere enfrentar apuesta grande. Block bet pequeño puede capturar value y controlar precio.',
            solverNote: 'Los block bets aparecen con manos medias que desean valor/protección y evitan enfrentar polarización.',
            grades: [
                'BET_25' => ['grade' => 'best', 'frequency' => 50, 'ev_score' => 100, 'feedback' => 'Correcto. Value fino y control del tamaño del bote.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 45, 'ev_score' => 85, 'feedback' => 'Check también es razonable, pero pierdes algo de value.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 35, 'feedback' => 'Demasiado grande. Solo te pagan mejores con frecuencia alta.'],
            ],
            gtoInsight: 'GTO simplificado: el block bet pequeño puede proteger manos medias y extraer valor fino.',
            lowStakesInsight: 'En NL2-NL10 funciona si el rival paga demasiado pasivo. Si el rival raisea, puedes foldear tranquilo.',
            confidence: 80
        );
    }
}