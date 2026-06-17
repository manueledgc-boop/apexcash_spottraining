<?php

namespace App\SpotTraining\Mastery\Modules;

use App\SpotTraining\Mastery\Concerns\BuildsMasterySpots;

class MultiwaySpots
{
    use BuildsMasterySpots;

    public static function all(): array
    {
        return [
            self::topPairMultiwayCbetSmall(),
            self::overpairVulnerableMultiway(),
            self::nutFlushDrawMultiwayCall(),
            self::comboDrawMultiwayRaise(),
            self::setDynamicBoardFastPlay(),
            self::middlePairCheckBackMultiway(),
            self::protectionCbetLowBoard(),
            self::foldOverpairVsRaiseMultiway(),
            self::turnSecondBarrelValueMultiway(),
            self::turnCheckControlTopPair(),
            self::turnDrawLosesEquity(),
            self::turnDrawGainsEquitySemiBluff(),
            self::turnThinValueTwoPair(),
            self::turnFoldVsStrongMultiwayAggression(),
            self::riverThinValueTopPair(),
            self::riverBluffcatcherMultiway(),
            self::riverOverbetPolarNuts(),
            self::riverHeroFoldTopPair(),
            self::riverHeroCallBlocker(),
            self::riverValueBetNuts(),
        ];
    }

    protected static function topPairMultiwayCbetSmall(): array
    {
        return self::spot(
            id: 'mastery_mw_001',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'top_pair_multiway',
            conceptLabel: 'Top Pair Multiway',
            title: 'CO abre · BTN y BB pagan · Top pair en flop seco',
            street: 'flop',
            heroPosition: 'CO',
            villainPosition: 'BTN',
            heroCards: ['Ah', 'Qs'],
            boardCards: ['Qd', '7c', '2h'],
            potBb: 8.5,
            spr: 10.8,
            effectiveStackBb: 92,
            boardTexture: 'Q-high seco multiway',
            rangeAdvantage: 'CO ligera',
            nutAdvantage: 'CO ligera',
            actions: [
                'CO abre 2.5 BB',
                'BTN paga',
                'BB paga',
                'Flop Qd 7c 2h',
                'Hero actúa contra dos rivales',
            ],
            options: ['CHECK', 'BET_33', 'BET_75'],
            correctAction: 'BET_33',
            explanation: 'Top pair top kicker quiere valor, pero multiway no necesita sizing grande. Bet pequeño cobra a Qx peores, 7x y pares sin aislarte contra sets.',
            solverNote: 'En multiway se reduce frecuencia y tamaño de cbet; las manos de valor siguen apostando, pero con cautela.',
            grades: [
                'BET_33' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Valor eficiente multiway.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 80, 'feedback' => 'Check controla, pero deja valor.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 58, 'feedback' => 'Demasiado grande para top pair multiway.'],
            ],
            gtoInsight: 'GTO simplificado: multiway exige menos faroles y sizings más prudentes.',
            lowStakesInsight: 'En NL2-NL10 apuesta pequeño por valor. Te pagan muchas Qx peores.',
            confidence: 86
        );
    }

    protected static function overpairVulnerableMultiway(): array
    {
        return self::spot(
            id: 'mastery_mw_002',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'overpair_vulnerable_multiway',
            conceptLabel: 'Overpair Vulnerable Multiway',
            title: 'UTG con JJ en board conectado multiway',
            street: 'flop',
            heroPosition: 'UTG',
            villainPosition: 'CO',
            heroCards: ['Jh', 'Jd'],
            boardCards: ['Ts', '9s', '6c'],
            potBb: 9.5,
            spr: 9.0,
            effectiveStackBb: 86,
            boardTexture: 'Medio conectado con flush draw',
            rangeAdvantage: 'Compartida',
            nutAdvantage: 'Callers',
            actions: [
                'UTG abre 2.5 BB',
                'CO paga',
                'BTN paga',
                'BB paga',
                'Flop Ts 9s 6c',
                'Hero actúa contra tres rivales',
            ],
            options: ['CHECK', 'BET_33', 'BET_75'],
            correctAction: 'CHECK',
            explanation: 'JJ es overpair, pero el board golpea mucho a rangos de call multiway. Apostar grande se mete en problemas contra sets, escaleras y proyectos fuertes.',
            solverNote: 'En boards dinámicos multiway, incluso overpairs pueden jugar más check.',
            grades: [
                'CHECK' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Controlas en textura peligrosa.'],
                'BET_33' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 82, 'feedback' => 'Pequeño para protección puede valer.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 34, 'feedback' => 'Demasiado grande multiway en board malo.'],
            ],
            gtoInsight: 'GTO simplificado: en multiway la equity de overpairs baja mucho en boards conectados.',
            lowStakesInsight: 'En micros no te cases con JJ multiway. Controla y observa acción.',
            confidence: 88
        );
    }

    protected static function nutFlushDrawMultiwayCall(): array
    {
        return self::spot(
            id: 'mastery_mw_003',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'nut_flush_draw_multiway',
            conceptLabel: 'Nut Flush Draw Multiway',
            title: 'BTN con nut flush draw frente a cbet multiway',
            street: 'flop',
            heroPosition: 'BTN',
            villainPosition: 'HJ',
            heroCards: ['Ah', 'Jh'],
            boardCards: ['Kh', '8h', '4c'],
            potBb: 8.0,
            spr: 11.5,
            effectiveStackBb: 92,
            boardTexture: 'K-high con flush draw',
            rangeAdvantage: 'HJ opener',
            nutAdvantage: 'HJ ligera',
            actions: [
                'HJ abre 2.5 BB',
                'CO paga',
                'BTN paga',
                'BB paga',
                'Flop Kh 8h 4c',
                'HJ apuesta 50%',
                'CO foldea',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'CALL',
            explanation: 'Nut flush draw tiene equity enorme, pero multiway el raise recibe menos folds y se aisla contra Kx fuerte/sets. Call realiza equity en posición.',
            solverNote: 'Los nut draws multiway tienden más a call cuando la fold equity baja.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Realizas equity en posición.'],
                'RAISE' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 82, 'feedback' => 'Semi-bluff posible, pero no obligatorio multiway.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Fold gravísimo con nut draw.'],
            ],
            gtoInsight: 'GTO simplificado: multiway reduce la fold equity de proyectos, favoreciendo calls con draws fuertes.',
            lowStakesInsight: 'En NL2-NL10 call es muy rentable porque te pagan cuando ligas.',
            confidence: 84
        );
    }

    protected static function comboDrawMultiwayRaise(): array
    {
        return self::spot(
            id: 'mastery_mw_004',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'combo_draw_multiway',
            conceptLabel: 'Combo Draw Multiway',
            title: 'BB con combo draw fuerte multiway',
            street: 'flop',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['9s', '8s'],
            boardCards: ['7s', '6s', '2d'],
            potBb: 7.5,
            spr: 12.0,
            effectiveStackBb: 90,
            boardTexture: 'Muy dinámico · open ended + flush draw',
            rangeAdvantage: 'Callers',
            nutAdvantage: 'BB',
            actions: [
                'BTN abre 2.5 BB',
                'SB paga',
                'BB paga',
                'Flop 7s 6s 2d',
                'SB check',
                'BB check',
                'BTN apuesta 50%',
                'SB paga',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'RAISE',
            explanation: '9s8s tiene open ended, flush draw y mucha equity contra varios rangos. Raise aprovecha fold equity y construye bote cuando tiene equity masiva.',
            solverNote: 'Combo draws premium pueden subir incluso multiway porque toleran bien acción fuerte.',
            grades: [
                'RAISE' => ['grade' => 'best', 'frequency' => 50, 'ev_score' => 100, 'feedback' => 'Correcto. Equity enorme y presión.'],
                'CALL' => ['grade' => 'good', 'frequency' => 45, 'ev_score' => 88, 'feedback' => 'Call también es rentable.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Fold imposible con combo draw.'],
            ],
            gtoInsight: 'GTO simplificado: los draws con equity masiva pueden jugarse agresivo incluso multiway.',
            lowStakesInsight: 'En micros raise funciona si hay fold equity; si todos pagan, aún tienes muchísima equity.',
            confidence: 82
        );
    }

    protected static function setDynamicBoardFastPlay(): array
    {
        return self::spot(
            id: 'mastery_mw_005',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'set_fastplay_multiway',
            conceptLabel: 'Set en Board Dinámico',
            title: 'Set en board dinámico multiway',
            street: 'flop',
            heroPosition: 'CO',
            villainPosition: 'BTN',
            heroCards: ['8c', '8d'],
            boardCards: ['8s', '7s', '5h'],
            potBb: 8.0,
            spr: 11.0,
            effectiveStackBb: 88,
            boardTexture: 'Muy conectado con flush draw',
            rangeAdvantage: 'Callers',
            nutAdvantage: 'CO',
            actions: [
                'MP abre 2.5 BB',
                'CO paga',
                'BTN paga',
                'BB paga',
                'Flop 8s 7s 5h',
                'MP apuesta 50%',
                'Hero actúa',
            ],
            options: ['CALL', 'RAISE', 'FOLD'],
            correctAction: 'RAISE',
            explanation: 'Set en board tan dinámico debe jugar rápido. Hay muchos proyectos y pares que pagan; slowplay permite demasiadas cartas malas.',
            solverNote: 'En boards muy dinámicos multiway, los sets prefieren raise por valor/protección.',
            grades: [
                'RAISE' => ['grade' => 'best', 'frequency' => 75, 'ev_score' => 100, 'feedback' => 'Correcto. Valor y protección urgente.'],
                'CALL' => ['grade' => 'marginal', 'frequency' => 25, 'ev_score' => 66, 'feedback' => 'Slowplay peligroso multiway.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Fold imposible con set.'],
            ],
            gtoInsight: 'GTO simplificado: más jugadores y más draws = menos slowplay.',
            lowStakesInsight: 'En NL2-NL10 sube fuerte. Te pagan draws, overpairs y top pair.',
            confidence: 91
        );
    }

    protected static function middlePairCheckBackMultiway(): array
    {
        return self::spot(
            id: 'mastery_mw_006',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'middle_pair_control_multiway',
            conceptLabel: 'Control con Mano Media Multiway',
            title: 'BTN con segundo par tras checks multiway',
            street: 'flop',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Qh', 'Jd'],
            boardCards: ['Kc', 'Jc', '6s'],
            potBb: 7.0,
            spr: 13.0,
            effectiveStackBb: 91,
            boardTexture: 'K-high con proyecto color',
            rangeAdvantage: 'Open raiser',
            nutAdvantage: 'Open raiser',
            actions: [
                'HJ abre 2.5 BB',
                'BTN paga',
                'SB paga',
                'BB paga',
                'Flop Kc Jc 6s',
                'Todos checkean hasta Hero',
            ],
            options: ['CHECK', 'BET_33', 'BET_75'],
            correctAction: 'CHECK',
            explanation: 'Segundo par multiway tiene showdown pero no quiere inflar bote. Apostar se enfrenta a muchos Kx, draws y check-raises.',
            solverNote: 'Manos medias multiway prefieren check back para realizar equity.',
            grades: [
                'CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Controlas y realizas equity.'],
                'BET_33' => ['grade' => 'marginal', 'frequency' => 25, 'ev_score' => 62, 'feedback' => 'Puede proteger, pero no es value claro.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 28, 'feedback' => 'Demasiado grande con mano media multiway.'],
            ],
            gtoInsight: 'GTO simplificado: en multiway las manos medias bajan agresión.',
            lowStakesInsight: 'En micros check es mejor. Si apuestas, te pagan muchas manos mejores.',
            confidence: 85
        );
    }

    protected static function protectionCbetLowBoard(): array
    {
        return self::spot(
            id: 'mastery_mw_007',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'protection_cbet_multiway',
            conceptLabel: 'CBet Protección Multiway',
            title: 'Overpair necesita protección en board bajo',
            street: 'flop',
            heroPosition: 'HJ',
            villainPosition: 'BTN',
            heroCards: ['Ts', 'Td'],
            boardCards: ['7c', '5d', '2h'],
            potBb: 8.5,
            spr: 10.5,
            effectiveStackBb: 89,
            boardTexture: 'Bajo seco',
            rangeAdvantage: 'HJ',
            nutAdvantage: 'Compartida',
            actions: [
                'HJ abre 2.5 BB',
                'CO paga',
                'BTN paga',
                'BB paga',
                'Flop 7c 5d 2h',
                'Hero actúa contra tres rivales',
            ],
            options: ['CHECK', 'BET_33', 'BET_75'],
            correctAction: 'BET_33',
            explanation: 'TT es overpair vulnerable. Bet pequeño cobra a pares peores y niega equity a overcards sin inflar demasiado.',
            solverNote: 'Protección multiway se hace con sizing eficiente, no necesariamente grande.',
            grades: [
                'BET_33' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Valor/protección prudente.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 80, 'feedback' => 'Check controla, pero da cartas gratis.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 42, 'feedback' => 'Demasiado grande multiway con overpair media.'],
            ],
            gtoInsight: 'GTO simplificado: en multiway se protege con sizings que no polaricen demasiado.',
            lowStakesInsight: 'En NL2-NL10 apuesta pequeño; te pagan 7x, 66-99 y overcards.',
            confidence: 84
        );
    }

    protected static function foldOverpairVsRaiseMultiway(): array
    {
        return self::spot(
            id: 'mastery_mw_008',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'fold_vs_raise_multiway',
            conceptLabel: 'Fold vs Raise Multiway',
            title: 'Overpair enfrenta raise fuerte multiway',
            street: 'flop',
            heroPosition: 'UTG',
            villainPosition: 'BTN',
            heroCards: ['Kh', 'Kc'],
            boardCards: ['9s', '8s', '6d'],
            potBb: 9.0,
            spr: 9.0,
            effectiveStackBb: 81,
            boardTexture: 'Muy conectado con proyectos',
            rangeAdvantage: 'Callers',
            nutAdvantage: 'BTN/BB',
            actions: [
                'UTG abre 2.5 BB',
                'BTN paga',
                'SB paga',
                'BB paga',
                'Flop 9s 8s 6d',
                'UTG apuesta 50%',
                'BTN raise 4x',
                'SB foldea',
                'BB paga',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'JAM'],
            correctAction: 'FOLD',
            explanation: 'KK es solo overpair en board que conecta mucho multiway. Raise + cold call representa sets, escaleras y draws enormes. Fold evita un spot desastroso.',
            solverNote: 'La agresión fuerte multiway es mucho más value-heavy que heads-up.',
            grades: [
                'FOLD' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Disciplina multiway.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 25, 'ev_score' => 34, 'feedback' => 'Pagas contra rangos muy fuertes.'],
                'JAM' => ['grade' => 'blunder', 'frequency' => 10, 'ev_score' => 12, 'feedback' => 'All-in sobrevalora overpair.'],
            ],
            gtoInsight: 'GTO simplificado: raises multiway son más fuertes; se foldea mucho más.',
            lowStakesInsight: 'En NL2-NL10 raise multiway casi siempre es fuerza. Foldea overpairs en boards malos.',
            confidence: 90
        );
    }

    protected static function turnSecondBarrelValueMultiway(): array
    {
        return self::spot(
            id: 'mastery_mw_009',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'turn_value_multiway',
            conceptLabel: 'Value Turn Multiway',
            title: 'Top set barrelea turn multiway',
            street: 'turn',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['Qh', 'Qs'],
            boardCards: ['Qd', '8s', '4c', '2h'],
            potBb: 18.0,
            spr: 4.5,
            effectiveStackBb: 81,
            boardTexture: 'Q-high seco · turn blank',
            rangeAdvantage: 'CO',
            nutAdvantage: 'CO',
            actions: [
                'CO abre 2.5 BB',
                'BTN paga',
                'BB paga',
                'Flop Qd 8s 4c · CO bet 33% · BTN foldea · BB paga',
                'Turn 2h',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_100'],
            correctAction: 'BET_100',
            explanation: 'Top set en turn blank quiere construir bote. BB tiene muchas Qx, 8x y pares que pagan demasiado.',
            solverNote: 'Con ventaja de nuts clara y mano premium, el segundo barrel grande maximiza valor.',
            grades: [
                'BET_100' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Valor grande.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 86, 'feedback' => 'También valor, pero menos EV.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 20, 'feedback' => 'Pierdes demasiado valor con top set.'],
            ],
            gtoInsight: 'GTO simplificado: una vez queda heads-up en turn, las manos premium vuelven a presionar fuerte.',
            lowStakesInsight: 'En NL2-NL10 apuesta grande. Te pagan top pair muchísimo.',
            confidence: 91
        );
    }

    protected static function turnCheckControlTopPair(): array
    {
        return self::spot(
            id: 'mastery_mw_010',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'turn_control_multiway',
            conceptLabel: 'Control Turn Multiway',
            title: 'Top pair controla turn peligroso',
            street: 'turn',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Kc', 'Qd'],
            boardCards: ['Kh', '9s', '7s', '8s'],
            potBb: 16.0,
            spr: 5.2,
            effectiveStackBb: 83,
            boardTexture: 'Turn completa color y conecta escalera',
            rangeAdvantage: 'BB',
            nutAdvantage: 'BB',
            actions: [
                'CO abre 2.5 BB',
                'BTN paga',
                'BB paga',
                'Flop Kh 9s 7s · CO check · BTN bet 33% · BB paga · CO foldea',
                'Turn 8s',
                'BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_100'],
            correctAction: 'CHECK',
            explanation: 'Top pair sin spade pierde mucho valor cuando completa color y escalera. Check realiza equity y evita check-raise incómodo.',
            solverNote: 'En turns que completan proyectos, top pairs sin blocker bajan agresión.',
            grades: [
                'CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Control en carta peligrosa.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 25, 'ev_score' => 58, 'feedback' => 'Value/protección muy fino.'],
                'BET_100' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 22, 'feedback' => 'Demasiado grande con mano media.'],
            ],
            gtoInsight: 'GTO simplificado: cuando el turn favorece al caller, se protege el rango de check.',
            lowStakesInsight: 'En micros check. Si te resuben, casi siempre vas mal.',
            confidence: 86
        );
    }

    protected static function turnDrawLosesEquity(): array
    {
        return self::spot(
            id: 'mastery_mw_011',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'draw_loses_equity_multiway',
            conceptLabel: 'Draw Pierde Equity Multiway',
            title: 'Draw pierde valor en turn doblado',
            street: 'turn',
            heroPosition: 'BB',
            villainPosition: 'CO',
            heroCards: ['Ah', 'Jh'],
            boardCards: ['Kh', '9h', '4c', '4d'],
            potBb: 14.0,
            spr: 6.0,
            effectiveStackBb: 84,
            boardTexture: 'Board doblado con flush draw',
            rangeAdvantage: 'CO',
            nutAdvantage: 'CO/BTN',
            actions: [
                'CO abre 2.5 BB',
                'BTN paga',
                'BB paga',
                'Flop Kh 9h 4c · CO bet 50% · BTN paga · BB paga',
                'Turn 4d',
                'CO apuesta 75%',
                'BTN paga',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'CALL',
            explanation: 'Nut flush draw todavía tiene equity, pero el board doblado reduce implied odds. Raise multiway es demasiado optimista; call por precio si el sizing lo permite.',
            solverNote: 'Cuando el board se dobla, los draws pierden valor relativo frente a full houses/trips.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Continúas sin sobrerrepresentar.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 78, 'feedback' => 'Contra sizing muy fuerte puede foldearse.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 30, 'feedback' => 'Raise malo con board doblado multiway.'],
            ],
            gtoInsight: 'GTO simplificado: los draws valen menos en boards doblados multiway.',
            lowStakesInsight: 'En NL2-NL10 no semi-bluffees aquí. Te pagan trips/full demasiado.',
            confidence: 80
        );
    }

    protected static function turnDrawGainsEquitySemiBluff(): array
    {
        return self::spot(
            id: 'mastery_mw_012',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'draw_gains_equity_multiway',
            conceptLabel: 'Draw Gana Equity Multiway',
            title: 'Draw mejora turn y apuesta tras checks',
            street: 'turn',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Js', 'Ts'],
            boardCards: ['9s', '6d', '2c', 'Qs'],
            potBb: 9.0,
            spr: 9.5,
            effectiveStackBb: 86,
            boardTexture: 'Turn abre combo draw',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'HJ abre 2.5 BB',
                'BTN paga',
                'BB paga',
                'Flop 9s 6d 2c · todos check',
                'Turn Qs',
                'BB check',
                'HJ check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_100'],
            correctAction: 'BET_50',
            explanation: 'JTs gana open ended y flush draw. Tras dos checks, apostar medio genera fold equity y construye bote con equity fuerte.',
            solverNote: 'Cuando el field muestra debilidad y Hero gana equity, stab turn es rentable.',
            grades: [
                'BET_50' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Equity + fold equity.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 78, 'feedback' => 'Realiza equity, pero pierdes presión.'],
                'BET_100' => ['grade' => 'marginal', 'frequency' => 5, 'ev_score' => 56, 'feedback' => 'Demasiado grande multiway.'],
            ],
            gtoInsight: 'GTO simplificado: los stabs multiway necesitan equity real, no aire puro.',
            lowStakesInsight: 'En micros bet medio funciona porque muchos checks son debilidad real.',
            confidence: 81
        );
    }

    protected static function turnThinValueTwoPair(): array
    {
        return self::spot(
            id: 'mastery_mw_013',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'turn_thin_value_multiway',
            conceptLabel: 'Thin Value Turn Multiway',
            title: 'Dobles busca valor turn multiway',
            street: 'turn',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Qh', '8c'],
            boardCards: ['Qs', '8d', '4c', '2s'],
            potBb: 12.0,
            spr: 7.0,
            effectiveStackBb: 84,
            boardTexture: 'Q-high con flush draw turn',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BB',
            actions: [
                'BTN abre 2.5 BB',
                'SB paga',
                'BB paga',
                'Flop Qs 8d 4c · SB check · BB check · BTN bet 33% · SB paga · BB paga',
                'Turn 2s',
                'SB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_100'],
            correctAction: 'BET_100',
            explanation: 'Q8 tiene dobles y la pica abre proyectos. Liderar grande cobra a Qx, draws y pares antes de rivers malos.',
            solverNote: 'Cuando Hero tiene ventaja de nuts en una carta que añade draws, puede liderar grande.',
            grades: [
                'BET_100' => ['grade' => 'best', 'frequency' => 50, 'ev_score' => 100, 'feedback' => 'Correcto. Valor/protección grande.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 40, 'ev_score' => 84, 'feedback' => 'Value seguro, menos presión.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 42, 'feedback' => 'Pierdes valor y das carta gratis.'],
            ],
            gtoInsight: 'GTO simplificado: dobles en multiway deben protegerse cuando aparecen proyectos.',
            lowStakesInsight: 'En NL2-NL10 apuesta fuerte. Qx y draws pagan demasiado.',
            confidence: 86
        );
    }

    protected static function turnFoldVsStrongMultiwayAggression(): array
    {
        return self::spot(
            id: 'mastery_mw_014',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'fold_vs_turn_aggression_multiway',
            conceptLabel: 'Fold vs Agresión Turn Multiway',
            title: 'Top pair foldea ante raise turn multiway',
            street: 'turn',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['Ad', 'Qh'],
            boardCards: ['Qs', '9s', '5c', '8s'],
            potBb: 18.0,
            spr: 4.2,
            effectiveStackBb: 76,
            boardTexture: 'Color y escalera completados',
            rangeAdvantage: 'BB',
            nutAdvantage: 'BB',
            actions: [
                'CO abre 2.5 BB',
                'BTN paga',
                'BB paga',
                'Flop Qs 9s 5c · CO bet 50% · BTN paga · BB paga',
                'Turn 8s',
                'BB check',
                'CO apuesta 50%',
                'BTN foldea',
                'BB raise 4x',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'JAM'],
            correctAction: 'FOLD',
            explanation: 'Top pair sin spade enfrenta raise fuerte en turn que completa color y escalera. Multiway, esto está muy cargado de valor.',
            solverNote: 'Raises turn multiway en cartas que completan proyectos requieren folds muy disciplinados.',
            grades: [
                'FOLD' => ['grade' => 'best', 'frequency' => 75, 'ev_score' => 100, 'feedback' => 'Correcto. Disciplina en turn malo.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 28, 'feedback' => 'Pagas contra rango demasiado fuerte.'],
                'JAM' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 8, 'feedback' => 'All-in sobrevalora top pair.'],
            ],
            gtoInsight: 'GTO simplificado: top pair cae mucho de valor frente a raises multiway en cartas dinámicas.',
            lowStakesInsight: 'En NL2-NL10 raise turn multiway casi siempre es monstruo. Foldea.',
            confidence: 92
        );
    }

    protected static function riverThinValueTopPair(): array
    {
        return self::spot(
            id: 'mastery_mw_015',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'river_thin_value_multiway',
            conceptLabel: 'Thin Value River Multiway',
            title: 'Top pair buen kicker busca value fino river',
            street: 'river',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['Kc', 'Qh'],
            boardCards: ['Kh', '8d', '4s', '2c', '7d'],
            potBb: 20.0,
            spr: 3.5,
            effectiveStackBb: 70,
            boardTexture: 'K-high seco',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN ligera',
            actions: [
                'CO abre 2.5 BB',
                'BTN paga',
                'BB paga',
                'Flop Kh 8d 4s · CO check · BTN bet 33% · BB paga · CO foldea',
                'Turn 2c · check/check',
                'River 7d · BB check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_100'],
            correctAction: 'BET_50',
            explanation: 'KQ gana a KJ/KT y algunos 8x curiosos. Medio bote es value fino sin aislarte contra mejores.',
            solverNote: 'Cuando el bote pasa de multiway a heads-up, top pair buen kicker puede valuebetear rivers seguros.',
            grades: [
                'BET_50' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 100, 'feedback' => 'Correcto. Value fino rentable.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 80, 'feedback' => 'Check es seguro, pero deja valor.'],
                'BET_100' => ['grade' => 'marginal', 'frequency' => 10, 'ev_score' => 55, 'feedback' => 'Demasiado grande para value fino.'],
            ],
            gtoInsight: 'GTO simplificado: value fino depende del rango que llega al river, no solo de la fuerza absoluta.',
            lowStakesInsight: 'En NL2-NL10 medio bote saca valor de Kx peores.',
            confidence: 82
        );
    }

    protected static function riverBluffcatcherMultiway(): array
    {
        return self::spot(
            id: 'mastery_mw_016',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'river_bluffcatch_multiway',
            conceptLabel: 'Bluffcatch River Multiway',
            title: 'Segundo par enfrenta apuesta river tras línea pasiva',
            street: 'river',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Jc', '8c'],
            boardCards: ['Ks', '8h', '4d', '2s', '7c'],
            potBb: 18.0,
            spr: 4.0,
            effectiveStackBb: 72,
            boardTexture: 'K-high seco',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'CO abre 2.5 BB',
                'BTN paga',
                'BB paga',
                'Flop Ks 8h 4d · todos check',
                'Turn 2s · BB check · CO check · BTN bet 50% · BB paga · CO foldea',
                'River 7c · BB check',
                'BTN apuesta 75%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'FOLD',
            explanation: 'Segundo par multiway contra apuesta turn y river suele estar por detrás. BTN tiene Kx, sets slowplay y value thin; pocos bluffs naturales.',
            solverNote: 'Los bluffcatchers multiway bajan mucho de valor por menor frecuencia de farol.',
            grades: [
                'FOLD' => ['grade' => 'best', 'frequency' => 65, 'ev_score' => 100, 'feedback' => 'Correcto. Bluffcatch demasiado débil.'],
                'CALL' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 50, 'feedback' => 'Solo contra rival agresivo.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 8, 'feedback' => 'Raise sin valor ni blockers es malo.'],
            ],
            gtoInsight: 'GTO simplificado: en multiway se bluffcatchea menos porque hay menos bluffs.',
            lowStakesInsight: 'En NL2-NL10 fold. Apuestas river multiway suelen ser valor.',
            confidence: 86
        );
    }

    protected static function riverOverbetPolarNuts(): array
    {
        return self::spot(
            id: 'mastery_mw_017',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'river_overbet_nuts_multiway',
            conceptLabel: 'Overbet Nuts River Multiway',
            title: 'Escalera nuts overbetea river',
            street: 'river',
            heroPosition: 'BB',
            villainPosition: 'BTN',
            heroCards: ['Jd', 'Ts'],
            boardCards: ['9c', '8d', '2s', '3h', 'Qh'],
            potBb: 16.0,
            spr: 5.0,
            effectiveStackBb: 80,
            boardTexture: 'River completa escalera nuts',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BB',
            actions: [
                'BTN abre 2.5 BB',
                'SB paga',
                'BB paga',
                'Flop 9c 8d 2s · todos check',
                'Turn 3h · SB check · BB check · BTN bet 50% · SB foldea · BB paga',
                'River Qh',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_75', 'BET_125'],
            correctAction: 'BET_125',
            explanation: 'JT hace nuts y BB tiene más combos de JT que BTN por defensa de BB. Overbet polar cobra a Qx, sets y dobles.',
            solverNote: 'Cuando el river da ventaja de nuts al defensor, los leads grandes aparecen.',
            grades: [
                'BET_125' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 100, 'feedback' => 'Correcto. Nuts y ventaja de nuts.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 84, 'feedback' => 'Valor claro, menos presión.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 30, 'feedback' => 'Pierdes valor con nuts.'],
            ],
            gtoInsight: 'GTO simplificado: overbet river requiere nuts o blocker fuerte; aquí Hero tiene nuts.',
            lowStakesInsight: 'En NL2-NL10 apuesta grande. Muchos no foldean top pair o dobles.',
            confidence: 90
        );
    }

    protected static function riverHeroFoldTopPair(): array
    {
        return self::spot(
            id: 'mastery_mw_018',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'river_hero_fold_multiway',
            conceptLabel: 'Hero Fold River Multiway',
            title: 'Top pair foldea ante polar river multiway',
            street: 'river',
            heroPosition: 'CO',
            villainPosition: 'BB',
            heroCards: ['Ah', 'Kd'],
            boardCards: ['Ks', 'Ts', '8d', '9s', '2c'],
            potBb: 32.0,
            spr: 2.4,
            effectiveStackBb: 76,
            boardTexture: 'Color y escalera completados',
            rangeAdvantage: 'BB',
            nutAdvantage: 'BB',
            actions: [
                'CO abre 2.5 BB',
                'BTN paga',
                'BB paga',
                'Flop Ks Ts 8d · CO bet 50% · BTN paga · BB paga',
                'Turn 9s · todos check',
                'River 2c',
                'BB apuesta 125%',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'FOLD',
            explanation: 'AK sin spade es solo top pair en runout que completa color y escalera. Overbet de BB multiway representa muchos nuts.',
            solverNote: 'Top pair sin blocker relevante foldea frente a overbets polarizadas multiway.',
            grades: [
                'FOLD' => ['grade' => 'best', 'frequency' => 80, 'ev_score' => 100, 'feedback' => 'Correcto. Fold disciplinado.'],
                'CALL' => ['grade' => 'blunder', 'frequency' => 15, 'ev_score' => 20, 'feedback' => 'Call demasiado optimista.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Raise sin blockers es quemar dinero.'],
            ],
            gtoInsight: 'GTO simplificado: los overbets multiway están mucho más cargados de nuts.',
            lowStakesInsight: 'En NL2-NL10 esto es fold claro. Casi nadie overbetea bluff multiway.',
            confidence: 93
        );
    }

    protected static function riverHeroCallBlocker(): array
    {
        return self::spot(
            id: 'mastery_mw_019',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'river_hero_call_blocker_multiway',
            conceptLabel: 'Hero Call con Blocker Multiway',
            title: 'Hero call river con blocker de nuts',
            street: 'river',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['As', 'Qh'],
            boardCards: ['Ks', 'Qs', '7d', '2c', '4s'],
            potBb: 24.0,
            spr: 3.0,
            effectiveStackBb: 72,
            boardTexture: 'Flush completado river',
            rangeAdvantage: 'BB',
            nutAdvantage: 'BB',
            actions: [
                'CO abre 2.5 BB',
                'BTN paga',
                'BB paga',
                'Flop Ks Qs 7d · CO bet 33% · BTN paga · BB paga',
                'Turn 2c · todos check',
                'River 4s',
                'BB apuesta 75%',
                'CO foldea',
                'Hero actúa',
            ],
            options: ['FOLD', 'CALL', 'RAISE'],
            correctAction: 'CALL',
            explanation: 'Hero tiene As, bloqueando nut flush, y segundo par/top kicker relativo. Contra sizing 75%, puede pagar frente a un rival capaz de bluffear.',
            solverNote: 'Los calls con blocker a nuts suben de valor, aunque multiway siguen siendo selectivos.',
            grades: [
                'CALL' => ['grade' => 'best', 'frequency' => 45, 'ev_score' => 100, 'feedback' => 'Correcto contra perfil agresivo.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 45, 'ev_score' => 82, 'feedback' => 'Exploit contra pasivo es fold.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 30, 'feedback' => 'Raise no representa suficiente valor creíble.'],
            ],
            gtoInsight: 'GTO simplificado: los blockers importan mucho, pero multiway exige cautela.',
            lowStakesInsight: 'En NL2-NL10 foldea más contra pasivos. Paga solo contra agresivos reales.',
            confidence: 74
        );
    }

    protected static function riverValueBetNuts(): array
    {
        return self::spot(
            id: 'mastery_mw_020',
            module: 'multiway',
            moduleLabel: 'Multiway',
            concept: 'river_value_nuts_multiway',
            conceptLabel: 'Value Nuts River Multiway',
            title: 'Color nuts apuesta river por valor',
            street: 'river',
            heroPosition: 'BTN',
            villainPosition: 'BB',
            heroCards: ['As', 'Js'],
            boardCards: ['Ks', '8s', '4d', '2c', '6s'],
            potBb: 30.0,
            spr: 2.6,
            effectiveStackBb: 78,
            boardTexture: 'Flush completado river',
            rangeAdvantage: 'BTN',
            nutAdvantage: 'BTN',
            actions: [
                'HJ abre 2.5 BB',
                'BTN paga',
                'BB paga',
                'Flop Ks 8s 4d · HJ bet 50% · BTN paga · BB paga',
                'Turn 2c · todos check',
                'River 6s',
                'BB check',
                'HJ check',
                'Hero actúa',
            ],
            options: ['CHECK', 'BET_50', 'BET_100'],
            correctAction: 'BET_100',
            explanation: 'Hero tiene nut flush. Después de dos checks, apuesta grande por valor contra colores peores, Kx con spade y bluffcatchers.',
            solverNote: 'Con nuts en river multiway y acción pasiva delante, se maximiza valor con tamaño grande.',
            grades: [
                'BET_100' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 100, 'feedback' => 'Correcto. Valor máximo con nuts.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 84, 'feedback' => 'Valor seguro, pero menos EV.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Check behind con nuts es error grave.'],
            ],
            gtoInsight: 'GTO simplificado: value bets grandes con nuts castigan rangos capped.',
            lowStakesInsight: 'En NL2-NL10 apuesta grande. Te pagan colores peores y top pair con spade.',
            confidence: 92
        );
    }
}
