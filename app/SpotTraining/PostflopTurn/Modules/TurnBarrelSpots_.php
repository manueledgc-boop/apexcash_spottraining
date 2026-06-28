<?php

namespace App\SpotTraining\PostflopTurn\Modules;

use App\SpotTraining\PostflopTurn\Concerns\BuildsPostflopTurnSpots;

class TurnBarrelSpots
{
    use BuildsPostflopTurnSpots;

    public static function all(): array
    {
        return [
            self::barrelAceHighGoodTurn(),
            self::barrelOverpairSafeTurn(),
            self::giveUpBadTurnAqo(),
            self::barrelNutFlushDraw(),
            self::barrelScareCardK(),
            self::checkBackShowdownValue(),
            self::doubleBarrelTopPairDynamic(),
            self::giveUpLowEquityAir(),
            self::barrelTurnEquityImproves(),
            self::checkBackWetTurnControl(),
            self::barrelScareAceWithEquity(),
            self::noBarrelBlankNoFoldEquity(),
            self::barrelNutFlushDrawTurn(),
            self::barrelOvercardAndFlushDraw(),
            self::checkBackSecondPairShowdown(),
            self::barrelPolarOverbetTurn(),
            self::smallBarrelProtection(),
            self::giveUpMissedBroadwaysNoBlocker(),
            self::barrelTurnImprovesRangeAdvantage(),
            self::checkBackTopPairBadKickerWetTurn(),
            self::barrelSecondNutFlushDrawCombo(),
            self::checkBackAceHighShowdown(),
            self::barrelBlockerAceOnFlushTurn(),
            self::giveUpPairedTurnBadBluff(),
            self::barrelSetForValueWetTurn(),
            self::checkBackOverpairBadRunout(),
            self::barrelOesdPlusOvercards(),
            self::barrelLowTurnRangeAdvantage(),
            self::giveUpNoEquityMonotoneTurn(),
            self::barrelTwoPairForValue(),
            self::checkBackNutAdvantageLost(),
            self::barrelTurnPairsTopCard(),
            self::barrelEquityAndBlockers(),
            self::checkBackSecondPairWetTurn(),
            self::barrelBlankWithOverpair(),
            self::giveUpAceHighNoBackdoor(),
            self::barrelStraightCompletedHero(),
            self::smallBarrelRangeOnAceTurn(),
            self::checkBackTopPairFacingBadTurn(),
            self::barrelPolarWithNutBlocker(),
        ];
    }

    protected static function barrelAceHighGoodTurn(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_a72r_2nd_barrel_ak_q',
            'turn_barrel',
            'Turn Barrel',
            'turn_tptk_value',
            'Segunda barrel por valor',
            'BTN vs BB · AK en A72r · Turn Q',
            'BTN',
            'BB',
            ['Ah', 'Kh'],
            ['Ad', '7c', '2s', 'Qh'],
            8.5,
            5.5,
            44.5,
            'A-high seco con broadway turn',
            'Hero mantiene ventaja fuerte de Ax y broadways.',
            'Hero tiene mejores Ax; BB tiene muchos pares medios y Ax peores.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♦ 7♣ 2♠', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: Q♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'AK sigue dominando muchos Ax peores. La Q no cambia demasiado y permite apostar por valor sin polarizar de más.',
            'GTO simplificado: segunda barrel media con top pair top kicker en turn favorable.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 88, 'feedback' => 'Correcto. Sacas valor de Ax peores y pares que no foldean.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 78, 'feedback' => 'También válido contra rivales calling station, pero puede aislar más.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 48, 'feedback' => 'Demasiado pasivo con una mano que todavía tiene valor claro.'],
            ],
            'Top pair top kicker puede seguir apostando por valor en turn seguro.',
            'En NL2-NL10 apuesta por valor. Te pagan Ax peores demasiado a menudo.',
            88
        );
    }

    protected static function barrelOverpairSafeTurn(): array
    {
        return self::spot(
            'turn_barrel_co_vs_bb_q72r_aa_turn_3',
            'turn_barrel',
            'Turn Barrel',
            'turn_overpair_value',
            'Overpair en turn seguro',
            'CO vs BB · AA en Q72r · Turn 3',
            'CO',
            'BB',
            ['Ah', 'Ad'],
            ['Qs', '7c', '2h', '3d'],
            8.5,
            5.8,
            45.0,
            'Q-high seco, turn blank',
            'Hero tiene overpairs y mejores Qx.',
            'Hero conserva ventaja de overpairs; BB tiene sets ocasionales.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♣ 2♥', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: 3♦', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'AA quiere seguir cobrando a Qx, 7x y pares. El 3♦ es blank y no cambia la textura.',
            'GTO simplificado: overpair fuerte puede usar sizing medio/grande en turn blank.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 90, 'feedback' => 'Muy bien. Cobras fuerte a Qx y pares.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 46, 'ev_score' => 82, 'feedback' => 'También válido, algo menos presión.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 44, 'feedback' => 'Demasiado pasivo con overpair fuerte en blank.'],
            ],
            'Los blanks de turn permiten seguir apostando manos de valor fuerte.',
            'En límites bajos apuesta grande por valor cuando el rival tiene muchas Qx que pagan.',
            90
        );
    }

    protected static function giveUpBadTurnAqo(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_t83r_aqo_turn_9',
            'turn_barrel',
            'Turn Barrel',
            'turn_bad_barrel_card',
            'Rendirse en mala carta',
            'BTN vs BB · AQo en T83r · Turn 9',
            'BTN',
            'BB',
            ['Ah', 'Qd'],
            ['Ts', '8c', '3h', '9d'],
            8.5,
            5.5,
            44.5,
            'Board medio conectado en turn',
            'BB conecta mucho con T, 9, 8, pares y proyectos.',
            'BB tiene más dobles, sets y escaleras potenciales.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 8♣ 3♥', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 9♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'La turn 9 conecta demasiado con el rango de BB. AQo sin proyecto real debe rendirse muchas veces.',
            'GTO simplificado: abandonar faroles sin equity en turns que favorecen al defensor.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 78, 'feedback' => 'Correcto. No tires otra barrel en una carta mala.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 38, 'feedback' => 'Demasiado optimista. BB continúa mucho.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 16, 'feedback' => 'Farol caro en una carta que mejora al rival.'],
            ],
            'No todas las c-bets de flop deben continuar en turn.',
            'En NL2-NL10 evita segunda barrel con aire cuando la turn conecta al rival.',
            82
        );
    }

    protected static function barrelNutFlushDraw(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_k72ss_asqs_turn_4s',
            'turn_barrel',
            'Turn Barrel',
            'turn_flush_value',
            'Color máximo completado',
            'BTN vs BB · AQs en K72ss · Turn 4♠',
            'BTN',
            'BB',
            ['As', 'Qs'],
            ['Ks', '7s', '2d', '4s'],
            8.5,
            5.5,
            44.5,
            'K-high con color completado',
            'Hero tiene nut flush y manos fuertes.',
            'Hero tiene nut flush; BB puede tener colores peores y Kx.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♠ 2♦', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 4♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Hero completó el color máximo. Debe apostar por valor contra colores peores, Kx con espada y proyectos fuertes.',
            'GTO simplificado: apostar grande por valor con nuts en turn.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 94, 'feedback' => 'Excelente. Construyes bote con el color máximo.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 44, 'ev_score' => 82, 'feedback' => 'También correcto, pero deja valor contra manos que pagan.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 6, 'ev_score' => 20, 'feedback' => 'Slowplay malo. Hay demasiado valor disponible.'],
            ],
            'Cuando completas el nut flush, apuesta por valor.',
            'En microlímites no slowplayees nuts: te pagan colores peores y top pair con espada.',
            94
        );
    }

    protected static function barrelScareCardK(): array
    {
        return self::spot(
            'turn_barrel_co_vs_bb_q83_aq_turn_k',
            'turn_barrel',
            'Turn Barrel',
            'turn_scare_card_barrel',
            'Barrel en scare card',
            'CO vs BB · AQ en Q83r · Turn K',
            'CO',
            'BB',
            ['As', 'Qh'],
            ['Qd', '8c', '3s', 'Kh'],
            8.5,
            5.8,
            45.0,
            'Q-high con K turn',
            'El K mejora al rango percibido de Hero.',
            'Hero tiene AK, KQ, sets y Qx fuertes.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: Q♦ 8♣ 3♠', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: K♥', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'AQ sigue teniendo valor, pero el K también puede asustar a manos peores. Un sizing medio cobra a Qx peores y protege.',
            'GTO simplificado: barrel media en scare card favorable.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 82, 'feedback' => 'Correcto. Sigues cobrando sin aislarte demasiado.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 72, 'feedback' => 'Check también puede controlar bote contra rivales agresivos.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 18, 'ev_score' => 62, 'feedback' => 'Puede ser algo grande: foldeas manos peores y te pagan mejores.'],
            ],
            'Las scare cards pueden servir para seguir apostando, pero el sizing importa.',
            'En NL2-NL10 apuesta medio: todavía te pagan Q peores, pero no infles demasiado sin nuts.',
            82
        );
    }

    protected static function checkBackShowdownValue(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_k72r_88_turn_4',
            'turn_barrel',
            'Turn Barrel',
            'turn_medium_pair_control',
            'Control con showdown value',
            'BTN vs BB · 88 en K72r · Turn 4',
            'BTN',
            'BB',
            ['8c', '8d'],
            ['Ks', '7h', '2c', '4d'],
            5.5,
            8.0,
            46.5,
            'K-high seco, turn blank',
            'Hero tiene ventaja de rango, pero 88 tiene valor medio.',
            'Hero tiene Kx fuertes; 88 quiere controlar bote.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♥ 2♣', 'BB checks', 'BTN checks back', 'Turn: 4♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            '88 tiene showdown value. Apostar turn no logra valor claro ni foldea suficientes manos mejores.',
            'GTO simplificado: controlar bote con pares medios en turn.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 74, 'ev_score' => 78, 'feedback' => 'Correcto. Realizas showdown value.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 22, 'ev_score' => 58, 'feedback' => 'Puede existir, pero no debe ser estándar.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 26, 'feedback' => 'Demasiado grande para una mano media.'],
            ],
            'Las parejas medias muchas veces prefieren check en turn.',
            'En límites bajos no apuestes por información. Llega barato a showdown.',
            78
        );
    }

    protected static function doubleBarrelTopPairDynamic(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_jt7ss_kj_turn_2',
            'turn_barrel',
            'Turn Barrel',
            'turn_vulnerable_top_pair',
            'Top pair y protección',
            'BTN vs BB · KJ en JT7ss · Turn 2',
            'BTN',
            'BB',
            ['Kh', 'Jc'],
            ['Js', 'Ts', '7d', '2c'],
            8.5,
            5.5,
            44.5,
            'Board dinámico, turn blank',
            'BB tiene muchos proyectos y pares.',
            'BB tiene dobles y proyectos; Hero tiene top pair buen kicker.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ T♠ 7♦', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 2♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Top pair buen kicker en turn blank quiere seguir cobrando a proyectos, Tx, Jx peores y pares + draw.',
            'GTO simplificado: segunda barrel por valor y protección en boards dinámicos.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 84, 'feedback' => 'Muy bien. Cobras y proteges.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 44, 'ev_score' => 76, 'feedback' => 'También correcto, pero menos presión.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 16, 'ev_score' => 42, 'feedback' => 'Das carta gratis a demasiados proyectos.'],
            ],
            'Las top pairs vulnerables siguen apostando en turns blank.',
            'En NL2-NL10 apuesta fuerte por valor y protección en boards con proyectos.',
            84
        );
    }

    protected static function giveUpLowEquityAir(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_k22_aqo_turn_9',
            'turn_barrel',
            'Turn Barrel',
            'turn_give_up_air',
            'Rendirse sin equity',
            'BTN vs BB · AQo en K22r · Turn 9',
            'BTN',
            'BB',
            ['Ah', 'Qd'],
            ['Ks', '2c', '2h', '9d'],
            8.5,
            5.5,
            44.5,
            'Board emparejado seco',
            'Hero tiene ventaja de Kx, pero AQ no mejoró.',
            'Hero representa Kx, pero BB ya pagó flop.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 2♣ 2♥', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 9♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'Después de que BB paga flop, AQo sin equity debe rendirse a menudo. Seguir apostando requiere blockers/equity mejores.',
            'GTO simplificado: dar up con aire sin equity tras recibir call.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 74, 'feedback' => 'Bien. No forces otro farol sin equity.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 36, 'feedback' => 'Segunda barrel débil: BB no foldeará suficiente.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 14, 'feedback' => 'Farol caro sin mejora ni blockers claros.'],
            ],
            'Cuando te pagan flop y no mejoras, muchos faroles deben rendirse.',
            'En microlímites evita doble barrel con aire: la gente paga demasiado.',
            80
        );
    }

    protected static function barrelTurnEquityImproves(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_a94_jt_turn_q',
            'turn_barrel',
            'Turn Barrel',
            'turn_double_barrel_draw',
            'Barrel al mejorar equity',
            'BTN vs BB · JT en A94 · Turn Q',
            'BTN',
            'BB',
            ['Jh', 'Th'],
            ['As', '9d', '4h', 'Qh'],
            5.5,
            8.0,
            46.5,
            'A-high con backdoor color completando equity',
            'Hero tiene ventaja de Ax y broadways.',
            'Hero mejora a combo draw; BB tiene pares y Ax.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 9♦ 4♥', 'BB checks', 'BTN checks back', 'Turn: Q♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'JT mejora a gutshot + flush draw. Ahora sí tiene equity y fold equity para apostar fuerte.',
            'GTO simplificado: apostar cuando la turn mejora mucho tu equity.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 84, 'feedback' => 'Excelente. Ahora tienes equity real y presión.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 76, 'feedback' => 'También válido, con menos presión.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 62, 'feedback' => 'Check toma carta gratis, pero pierdes fold equity.'],
            ],
            'Las turns que añaden equity convierten manos pasivas en buenos semi-bluffs.',
            'En NL2-NL10 farolea con equity real: gutshot + flush draw es mucho mejor que aire.',
            84
        );
    }

    protected static function checkBackWetTurnControl(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_a98_jj_turn_ts',
            'turn_barrel',
            'Turn Barrel',
            'turn_pot_control',
            'Control en turn peligroso',
            'BTN vs BB · JJ en A98ss · Turn T♠',
            'BTN',
            'BB',
            ['Jh', 'Jc'],
            ['As', '9s', '8d', 'Ts'],
            5.5,
            8.0,
            46.5,
            'Turn muy peligroso completa proyectos',
            'BB mejora muchas manos con T♠.',
            'BB tiene escaleras, colores y dobles; Hero tiene showdown marginal.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 9♠ 8♦', 'BB checks', 'BTN checks back', 'Turn: T♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'JJ no quiere apostar en una turn que completa color y muchas escaleras. Check back realiza equity y evita un check-raise muy incómodo.',
            'GTO simplificado: control con manos medias en turns que completan demasiados proyectos.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 78, 'feedback' => 'Correcto. Turn muy mala para apostar.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 16, 'ev_score' => 36, 'feedback' => 'Apuesta vulnerable: recibes calls/raises de manos mejores.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 12, 'feedback' => 'Sizing grande en turn pésima.'],
            ],
            'Las turns que completan draws reducen mucho los faroles y thin value.',
            'En microlímites no fuerces valor en cartas que completan todo. Check y controla.',
            82
        );
    }
    protected static function barrelScareAceWithEquity(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_k72_a_qj_gutshot',
            'turn_barrel',
            'Turn Barrel',
            'turn_scare_card_barrel',
            'Segundo barrel en scary card con equity',
            'BTN vs BB · QJ en K72r · Turn A',
            'BTN',
            'BB',
            ['Qh', 'Jh'],
            ['Ks', '7d', '2c', 'As'],
            8.5,
            5.5,
            44.5,
            'Turn A cambia mucho el rango percibido',
            'BTN tiene ventaja de Ax fuertes y broadways.',
            'BTN representa AK, AQ, AJ y dobles fuertes con más frecuencia que BB.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♦ 2♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: A♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'El As es una carta excelente para el agresor preflop. QJ además gana gutshot a Broadway y bloquea parte de KQ/KJ. Barrel grande presiona Kx débiles y pares medios.',
            'GTO simplificado: scary card favorable al agresor + equity real permite segundo barrel polarizado.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 80, 'feedback' => 'Muy bien. La carta favorece tu rango y tienes equity de respaldo.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 36, 'ev_score' => 70, 'feedback' => 'También válido, aunque presiona menos a Kx.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 26, 'ev_score' => 56, 'feedback' => 'Check realiza equity, pero desaprovecha una carta muy buena para tu rango.'],
            ],
            'Las scary cards no se farolean a ciegas: funcionan mejor con blockers o equity.',
            'En NL2-NL10 este bluff funciona mejor contra rivales capaces de foldear Kx. Contra calling stations baja la frecuencia.',
            80
        );
    }

    protected static function noBarrelBlankNoFoldEquity(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_q83_2_a5_no_equity',
            'turn_barrel',
            'Turn Barrel',
            'turn_give_up_air',
            'No barrel en blank sin equity',
            'BTN vs BB · A5 en Q83r · Turn 2',
            'BTN',
            'BB',
            ['Ah', '5c'],
            ['Qs', '8d', '3c', '2h'],
            8.5,
            5.5,
            44.5,
            'Turn blank que no cambia rangos',
            'BTN mantiene ventaja preflop, pero BB tiene muchos pares que no foldean.',
            'BB conserva Qx, 8x, 3x y pares medios tras pagar flop.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 8♦ 3♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'A5 no mejora, no tiene proyecto fuerte y la carta no presiona el rango de BB. Apostar de nuevo suele quemar dinero contra pares que pagan.',
            'GTO simplificado: en blanks que no cambian nada, los faroles sin equity reducen frecuencia.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 76, 'feedback' => 'Correcto. Rindes una mano con poca equity y poca fold equity.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 34, 'feedback' => 'Segundo barrel pobre: no representas mucho nuevo.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 6, 'ev_score' => 14, 'feedback' => 'Farol caro en una carta que no ayuda a tu historia.'],
            ],
            'No todos los turns son buenos para seguir apostando después de c-bet flop.',
            'En microlímites evita el piloto automático: si la carta no asusta y no tienes equity, check y abandona.',
            82
        );
    }

    protected static function barrelNutFlushDrawTurn(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_j72ss_4s_asqs',
            'turn_barrel',
            'Turn Barrel',
            'turn_double_barrel_draw',
            'Segundo barrel con nut flush draw',
            'BTN vs BB · AQs en J72ss · Turn 4s',
            'BTN',
            'BB',
            ['As', 'Qs'],
            ['Js', '7s', '2d', '4s'],
            8.5,
            5.5,
            44.5,
            'Turn completa color',
            'BTN puede tener nut flushes y overpairs con spade.',
            'Hero bloquea el nut flush y tiene equity enorme si va detrás.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 7♠ 2♦', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 4♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Hero tiene nut flush draw convertido en proyecto máximo con blockers muy fuertes. Apostar grande presiona Jx sin spade, pares y draws peores.',
            'GTO simplificado: el As de spades permite barrels agresivos en cartas que completan color.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 84, 'feedback' => 'Excelente barrel. Bloqueas nuts y tienes mucha equity.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 74, 'feedback' => 'Correcto, aunque deja respirar a demasiadas manos.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 58, 'feedback' => 'Check no es horrible, pero pierdes fold equity y presión.'],
            ],
            'Los blockers al nut flush son candidatos naturales para seguir barreleando.',
            'En NL2-NL10 no farolees cualquier carta de color: hazlo con el blocker correcto o equity clara.',
            84
        );
    }

    protected static function barrelOvercardAndFlushDraw(): array
    {
        return self::spot(
            'turn_barrel_co_vs_bb_t64ss_qs_aks',
            'turn_barrel',
            'Turn Barrel',
            'turn_double_barrel_draw',
            'Segundo barrel con overcards + draw',
            'CO vs BB · AKs en T64ss · Turn Qs',
            'CO',
            'BB',
            ['As', 'Kh'],
            ['Ts', '6s', '4d', 'Qs'],
            8.5,
            5.5,
            44.5,
            'Turn Q completa color y mejora broadways',
            'CO tiene ventaja en broadways fuertes y blockers al color máximo.',
            'Hero bloquea nut flush y puede representar AQ/KQ con spade.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: T♠ 6♠ 4♦', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: Q♠', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'La Q favorece al agresor y el As de spades bloquea el color máximo. Además Hero tiene overcard y equity potencial. Barrel grande presiona Tx y pares medios.',
            'GTO simplificado: combinar blocker al nut flush con carta favorable al rango permite polarizar turn.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 52, 'ev_score' => 80, 'feedback' => 'Buen barrel polarizado con blocker clave.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 70, 'feedback' => 'Aceptable, pero menos presión.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 58, 'feedback' => 'Check conserva equity, pero deja de presionar una carta excelente.'],
            ],
            'Los barrels buenos cuentan una historia coherente con blockers y ventaja de rango.',
            'En micro límites úsalo selectivamente: si el rival nunca foldea par, reduce este bluff.',
            80
        );
    }

    protected static function checkBackSecondPairShowdown(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_k82_4_q8_check',
            'turn_barrel',
            'Turn Barrel',
            'turn_second_pair_control',
            'Check back con segunda pareja',
            'BTN vs BB · Q8 en K82r · Turn 4',
            'BTN',
            'BB',
            ['Qh', '8h'],
            ['Ks', '8d', '2c', '4h'],
            8.5,
            5.5,
            44.5,
            'Turn blank con showdown value medio',
            'BTN tiene rango fuerte, pero Hero tiene mano media vulnerable.',
            'BB puede tener Kx, 8x mejores, sets y floats.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 8♦ 2♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'Q8 tiene showdown value, pero apostar no cobra suficiente de manos peores ni foldea mejores. Check back controla el bote y permite pagar muchos rivers.',
            'GTO simplificado: las manos medias con showdown value chequean turn con frecuencia.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 78, 'feedback' => 'Correcto. Controlas bote con una mano media.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 56, 'feedback' => 'Puede proteger, pero se aísla contra mejores con frecuencia.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 24, 'feedback' => 'Demasiado grande para segunda pareja.'],
            ],
            'No conviertas todas tus manos medias en apuestas automáticas.',
            'En NL2-NL10 controlar bote con segunda pareja evita decisiones caras en river.',
            80
        );
    }

    protected static function barrelPolarOverbetTurn(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_a74_7_ak_big',
            'turn_barrel',
            'Turn Barrel',
            'turn_overbet_polar_value',
            'Barrel grande polarizado por valor',
            'BTN vs BB · AK en A74r · Turn 7',
            'BTN',
            'BB',
            ['Ah', 'Kh'],
            ['As', '7d', '4c', '7h'],
            8.5,
            5.5,
            44.5,
            'Turn emparejado con top pair fuerte',
            'BTN conserva muchos Ax fuertes; BB tiene 7x pero también Ax peores.',
            'Hero tiene top pair top kicker y bloquea Ax fuertes del rival.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♦ 4♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 7♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'AK puede apostar grande por valor contra Ax peores que no foldean. La carta emparejada reduce combos de 7x y mantiene muchos calls de Ax.',
            'GTO simplificado: top pair top kicker puede usar sizing grande en turns donde el rival sigue teniendo bluffcatchers peores.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 86, 'feedback' => 'Correcto. Sacas máximo valor de Ax peores.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 40, 'ev_score' => 78, 'feedback' => 'También correcto, pero menos valor contra jugadores pagadores.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 44, 'feedback' => 'Demasiado pasivo con una mano que cobra mucho valor.'],
            ],
            'El tamaño grande no es solo bluff: también maximiza valor cuando te pagan demasiadas manos peores.',
            'En microlímites apuesta fuerte por valor cuando el rival paga Ax peores.',
            86
        );
    }

    protected static function smallBarrelProtection(): array
    {
        return self::spot(
            'turn_barrel_co_vs_bb_974_2_tt_protection',
            'turn_barrel',
            'Turn Barrel',
            'turn_range_advantage_barrel',
            'Barrel pequeño por protección',
            'CO vs BB · TT en 974r · Turn 2',
            'CO',
            'BB',
            ['Th', 'Tc'],
            ['9s', '7d', '4c', '2h'],
            8.5,
            5.5,
            44.5,
            'Board medio con muchas overcards futuras',
            'CO tiene overpairs; BB tiene muchos pares y draws bajos.',
            'Hero va por delante de 9x, 7x y proyectos, pero necesita protección.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: 9♠ 7♦ 4♣', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'TT sigue siendo overpair, pero no quiere inflar demasiado en una textura que conecta con BB. Apuesta media cobra valor y protege contra overcards y draws.',
            'GTO simplificado: overpairs vulnerables pueden apostar sizing medio en turns blanks.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 82, 'feedback' => 'Bien. Valor y protección sin exagerar el bote.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 68, 'feedback' => 'Check controla, pero das carta gratis a mucha equity.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 18, 'ev_score' => 58, 'feedback' => 'Demasiado grande contra un rango que también tiene manos fuertes.'],
            ],
            'La protección también es una razón válida para barrelear turn.',
            'En NL2-NL10 muchos pagan 9x y draws: apuesta por valor/protección sin regalar cartas.',
            82
        );
    }

    protected static function giveUpMissedBroadwaysNoBlocker(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_j84_2_kq_no_blocker',
            'turn_barrel',
            'Turn Barrel',
            'turn_give_up_air',
            'Rendirse con broadways sin blocker',
            'BTN vs BB · KQ en J84r · Turn 2',
            'BTN',
            'BB',
            ['Kh', 'Qc'],
            ['Js', '8d', '4c', '2h'],
            8.5,
            5.5,
            44.5,
            'Turn blank tras call flop',
            'BB conecta mucho con Jx, 8x, pares y floats que no foldean suficiente.',
            'Hero no bloquea las principales manos de call y solo tiene overcards.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 8♦ 4♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'KQ no mejora, no bloquea Jx relevante y tiene poca fold equity en blank. Continuar barreleando suele ser un farol de baja calidad.',
            'GTO simplificado: broadways sin backdoors ni blockers abandonan muchas turns blank.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 74, 'ev_score' => 76, 'feedback' => 'Correcto. No fuerces un farol malo.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 34, 'feedback' => 'Farol flojo: BB no foldea suficiente.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 6, 'ev_score' => 12, 'feedback' => 'Sizing caro sin blockers ni equity clara.'],
            ],
            'Los buenos faroles necesitan equity, blockers o una carta que cambie la historia.',
            'En micro límites abandonar turns malas ahorra mucho dinero.',
            82
        );
    }

    protected static function barrelTurnImprovesRangeAdvantage(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_t72_k_aq',
            'turn_barrel',
            'Turn Barrel',
            'turn_range_advantage_barrel',
            'Barrel cuando mejora la ventaja de rango',
            'BTN vs BB · AQ en T72r · Turn K',
            'BTN',
            'BB',
            ['Ah', 'Qh'],
            ['Ts', '7d', '2c', 'Kh'],
            8.5,
            5.5,
            44.5,
            'Turn K favorece al agresor preflop',
            'BTN tiene AK, KQ, KJ y broadways fuertes con mucha frecuencia.',
            'Hero gana gutshot y bloquea AQ/AK parcialmente.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 7♦ 2♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: K♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'El K es muy bueno para BTN y AQ gana gutshot a Broadway. Barrel grande presiona Tx, 7x y pares medios que sufren contra el rango percibido del agresor.',
            'GTO simplificado: cuando el turn aumenta tu ventaja de rango y tu mano gana equity, se barrelea con frecuencia.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 56, 'ev_score' => 82, 'feedback' => 'Excelente. Carta favorable + equity real.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 72, 'feedback' => 'Correcto, aunque menos presión.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 56, 'feedback' => 'Check desaprovecha una de las mejores cartas para tu rango.'],
            ],
            'La ventaja de rango cambia calle a calle; algunos turns son mucho mejores para el agresor.',
            'En NL2-NL10 no lo conviertas en bluff automático, pero con equity como AQ es un buen barrel.',
            82
        );
    }

    protected static function checkBackTopPairBadKickerWetTurn(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_q76_8_q5_check',
            'turn_barrel',
            'Turn Barrel',
            'turn_weak_top_pair_control',
            'Check back con top pair kicker débil en turn malo',
            'BTN vs BB · Q5s en Q76r · Turn 8',
            'BTN',
            'BB',
            ['Qh', '5h'],
            ['Qs', '7d', '6c', '8c'],
            8.5,
            5.5,
            44.5,
            'Turn conecta escaleras y mejora mucho a BB',
            'BTN tiene Qx, pero BB conecta mejor con 98, T9, 85, 76, 87 y sets.',
            'Hero tiene top pair débil sin ganas de jugar bote grande.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♦ 6♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 8♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'Q5 tiene valor de showdown, pero el 8 mejora mucho al rango de defensa de BB. Apostar se aísla contra mejores y abre la puerta a check-raises difíciles.',
            'GTO simplificado: top pairs débiles chequean más en turns que favorecen al caller.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 80, 'feedback' => 'Correcto. Controlas bote en una carta muy mala.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 54, 'feedback' => 'Thin value peligroso; muchos calls/raises te dominan.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 26, 'feedback' => 'Demasiado grande con kicker débil en turn conectado.'],
            ],
            'Top pair no siempre es tres calles de valor, especialmente con kicker débil y runout malo.',
            'En microlímites este check evita regalar botes grandes cuando el board se vuelve peligroso.',
            82
        );
    }

    protected static function barrelSecondNutFlushDrawCombo(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_q72hh_khjh_turn_4c',
            'turn_barrel',
            'Turn Barrel',
            'turn_combo_draw_barrel',
            'Barrel con combo draw fuerte',
            'BTN vs BB · KJhh en Q72hh · Turn 4',
            'BTN',
            'BB',
            ['Kh', 'Jh'],
            ['Qh', '7h', '2c', '4d'],
            8.5,
            5.5,
            44.5,
            'Q-high con proyecto de color fuerte',
            'BTN mantiene Qx fuertes, overpairs y proyectos fuertes.',
            'Hero tiene color draw alto, overcard y blockers relevantes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♥ 7♥ 2♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 4♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'KJhh tiene mucha equity y bloquea colores fuertes. Buen candidato para seguir presionando con sizing grande.',
            'GTO simplificado: los combo draws fuertes barrelean turns blanks con frecuencia.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 84, 'feedback' => 'Muy bien. Presionas con equity real y buenos blockers.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 36, 'ev_score' => 74, 'feedback' => 'Correcto, aunque genera menos fold equity.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 60, 'feedback' => 'Check realiza equity, pero pierde presión en buen spot.'],
            ],
            'Los proyectos fuertes con blockers pueden apostar turn aunque todavía no hayan ligado.',
            'En microlímites apuesta más tus draws fuertes; muchos rivales foldean pares medios o pagan peor.',
            84
        );
    }

    protected static function checkBackAceHighShowdown(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_k72r_aq_turn_2_check',
            'turn_barrel',
            'Turn Barrel',
            'turn_ace_high_showdown',
            'Check back con As alto',
            'BTN vs BB · AQ en K72r · Turn 2',
            'BTN',
            'BB',
            ['Ah', 'Qc'],
            ['Ks', '7d', '2c', '2h'],
            8.5,
            5.5,
            44.5,
            'Board emparejado seco',
            'BTN tiene Kx fuertes, pero AQ conserva showdown value.',
            'Hero bloquea Ax y puede ganar contra floats peores.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♦ 2♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'AQ tiene algo de showdown value y pocos folds mejores. Barrelear aquí suele convertir una mano media en bluff débil.',
            'GTO simplificado: As alto con showdown value puede chequear turns secos emparejados.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 78, 'feedback' => 'Correcto. No conviertas As alto en farol malo.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 55, 'feedback' => 'Puede tirar floats, pero no foldea muchas manos mejores.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 30, 'feedback' => 'Demasiado caro para una mano con showdown value.'],
            ],
            'No todas las manos sin pareja deben farolear turn.',
            'En NL2-NL10 ahorra fichas: muchos no foldean Kx ni pares.',
            78
        );
    }

    protected static function barrelBlockerAceOnFlushTurn(): array
    {
        return self::spot(
            'turn_barrel_co_vs_bb_j83ss_asqh_turn_5s',
            'turn_barrel',
            'Turn Barrel',
            'turn_nut_blocker_barrel',
            'Barrel con blocker al color máximo',
            'CO vs BB · AsQh en J83ss · Turn 5s',
            'CO',
            'BB',
            ['As', 'Qh'],
            ['Js', '8s', '3d', '5s'],
            8.5,
            5.8,
            45.0,
            'Color completado en turn',
            'CO puede representar colores altos y overpairs con espada.',
            'Hero bloquea el color máximo con As.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: J♠ 8♠ 3♦', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: 5♠', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'As bloquea el nut flush y permite presionar Jx sin espada, pares y draws medios.',
            'GTO simplificado: el blocker al nut flush permite algunos barrels grandes.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 44, 'ev_score' => 78, 'feedback' => 'Buen farol. Tienes blocker clave al color máximo.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 70, 'feedback' => 'Correcto, aunque mete menos presión.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 38, 'ev_score' => 62, 'feedback' => 'Check es prudente, pero desaprovecha un blocker importante.'],
            ],
            'Los blockers importan más cuando la carta del turn completa proyectos fuertes.',
            'En micro límites úsalo con cuidado: algunos pagan demasiado con cualquier pareja o espada.',
            78
        );
    }

    protected static function giveUpPairedTurnBadBluff(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_998r_kq_turn_9',
            'turn_barrel',
            'Turn Barrel',
            'turn_bad_paired_card_giveup',
            'Rendirse en turn muy malo',
            'BTN vs BB · KQ en 998r · Turn 9',
            'BTN',
            'BB',
            ['Kh', 'Qc'],
            ['9s', '9d', '8c', '9h'],
            8.5,
            5.5,
            44.5,
            'Board muy emparejado',
            'BB tiene muchos 9x, 8x y pares que no foldean.',
            'Hero tiene aire sin blockers relevantes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♠ 9♦ 8♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 9♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'El tercer 9 reduce fold equity y BB no abandona pares fácilmente. KQ sin equity debe rendirse.',
            'GTO simplificado: se abandona aire sin blockers en turns que no mejoran tu historia.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 80, 'feedback' => 'Correcto. No fuerces un bluff sin credibilidad.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 16, 'ev_score' => 34, 'feedback' => 'Farol débil: no representas suficiente y te pagan pares.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 14, 'feedback' => 'Muy mal. Bluff caro sin fold equity real.'],
            ],
            'Los boards emparejados no son automáticamente buenos para seguir faroleando.',
            'En NL2-NL10 no intentes tirar pares de rivales curiosos.',
            80
        );
    }

    protected static function barrelSetForValueWetTurn(): array
    {
        return self::spot(
            'turn_barrel_co_vs_bb_t87ss_tt_turn_2d',
            'turn_barrel',
            'Turn Barrel',
            'turn_set_value_wet',
            'Set fuerte en board húmedo',
            'CO vs BB · TT en T87ss · Turn 2',
            'CO',
            'BB',
            ['Th', 'Tc'],
            ['Ts', '8s', '7d', '2d'],
            8.5,
            5.8,
            45.0,
            'Board coordinado con muchos proyectos',
            'CO tiene sets y overpairs; BB tiene pares, draws y escaleras.',
            'Hero tiene top set y quiere cobrar/proteger.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: T♠ 8♠ 7♦', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: 2♦', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Top set debe apostar grande. Hay demasiados draws y manos peores que pagan.',
            'GTO simplificado: sets fuertes apuestan grande en turns húmedos.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 94, 'feedback' => 'Excelente. Máximo valor y protección.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 82, 'feedback' => 'Correcto, pero puedes cobrar más.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 20, 'feedback' => 'Slowplay pésimo en board tan cargado.'],
            ],
            'En boards húmedos, las manos muy fuertes deben construir bote.',
            'En micro límites apuesta grande: te pagan draws, pares y proyectos peores.',
            94
        );
    }

    protected static function checkBackOverpairBadRunout(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_987ss_aa_turn_6s',
            'turn_barrel',
            'Turn Barrel',
            'turn_overpair_bad_runout',
            'Control con overpair en turn horrible',
            'BTN vs BB · AA en 987ss · Turn 6s',
            'BTN',
            'BB',
            ['Ah', 'Ad'],
            ['9s', '8s', '7d', '6s'],
            8.5,
            5.5,
            44.5,
            'Turn completa escaleras y color',
            'BB conecta muy fuerte con suited connectors, pares y proyectos.',
            'Hero tiene overpair, pero el nut advantage cae hacia BB.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♠ 8♠ 7♦', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 6♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'AA perdió mucha fuerza relativa. Apostar grande se aísla contra escaleras, colores y manos muy fuertes.',
            'GTO simplificado: overpairs chequean más cuando el turn cambia drásticamente la textura.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 80, 'feedback' => 'Correcto. Controlas bote en una carta pésima.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 22, 'ev_score' => 52, 'feedback' => 'Thin value muy peligroso contra rango fuerte.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 24, 'feedback' => 'Demasiado grande; te pagan muchas manos mejores.'],
            ],
            'Overpair no siempre significa seguir apostando.',
            'En NL2-NL10 evita inflar botes cuando todos los draws obvios completan.',
            84
        );
    }

    protected static function barrelOesdPlusOvercards(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_t92r_qj_turn_8',
            'turn_barrel',
            'Turn Barrel',
            'turn_oesd_overcards_barrel',
            'Barrel con OESD y overcards',
            'BTN vs BB · QJ en T92r · Turn 8',
            'BTN',
            'BB',
            ['Qh', 'Jc'],
            ['Ts', '9d', '2c', '8h'],
            8.5,
            5.5,
            44.5,
            'Board conectado con proyecto fuerte',
            'BTN tiene broadways fuertes y algunas escaleras.',
            'Hero tiene OESD a escalera alta y overcards útiles.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♦ 2♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 8♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'QJ gana proyecto abierto fuerte y presiona Tx, 9x y pares. Tiene suficiente equity para barrelear.',
            'GTO simplificado: los draws fuertes con fold equity pueden apostar grande turn.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 56, 'ev_score' => 82, 'feedback' => 'Bien. Tienes equity y presión real.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 36, 'ev_score' => 72, 'feedback' => 'Correcto, aunque genera menos presión.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 60, 'feedback' => 'Check realiza equity, pero pierde fold equity.'],
            ],
            'Los proyectos abiertos fuertes son buenos candidatos de segunda barrel.',
            'En microlímites barrelea draws fuertes, pero no esperes folds enormes de top pair.',
            82
        );
    }

    protected static function barrelLowTurnRangeAdvantage(): array
    {
        return self::spot(
            'turn_barrel_co_vs_bb_a72r_kk_turn_3',
            'turn_barrel',
            'Turn Barrel',
            'turn_range_advantage_value',
            'Segunda barrel con valor vulnerable',
            'CO vs BB · KK en A72r · Turn 3',
            'CO',
            'BB',
            ['Kh', 'Kc'],
            ['As', '7d', '2c', '3h'],
            8.5,
            5.8,
            45.0,
            'A-high seco con blank turn',
            'CO tiene muchos Ax fuertes y overpairs.',
            'KK no es top pair, pero aún cobra a pares peores ocasionalmente.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♦ 2♣', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: 3♥', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'KK tiene showdown value, pero tras call flop en A-high no consigue suficiente valor apostando otra vez.',
            'GTO simplificado: pares fuertes sin top pair chequean bastante tras recibir call en A-high.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 76, 'feedback' => 'Correcto. Realizas showdown value sin aislarte.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 58, 'feedback' => 'Puede proteger, pero pocas peores pagan cómodo.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 32, 'feedback' => 'Demasiado grande contra rango cargado de Ax.'],
            ],
            'La ventaja de rango no obliga a apostar todas las manos medias.',
            'En NL2-NL10 si te pagan flop en A-high, respeta más los Ax.',
            76
        );
    }

    protected static function giveUpNoEquityMonotoneTurn(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_q74hhh_kcjd_turn_2h',
            'turn_barrel',
            'Turn Barrel',
            'turn_monotone_giveup',
            'Rendirse sin blocker en monotone',
            'BTN vs BB · KJo en Q74hhh · Turn 2h',
            'BTN',
            'BB',
            ['Kc', 'Jd'],
            ['Qh', '7h', '4h', '2h'],
            8.5,
            5.5,
            44.5,
            'Board cuatro corazones',
            'BB tiene muchos corazones y pares con corazón.',
            'Hero no tiene corazón ni pareja.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♥ 7♥ 4♥', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'Sin corazón ni equity real, KJ no debe seguir faroleando. BB no foldea suficientes manos con corazón.',
            'GTO simplificado: sin blocker en turn monotone, muchos bluffs abandonan.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 82, 'ev_score' => 80, 'feedback' => 'Correcto. No farolees sin blocker ni equity.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 28, 'feedback' => 'Farol malo: no bloqueas colores.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 10, 'feedback' => 'Muy caro y sin credibilidad suficiente.'],
            ],
            'En boards monotone, los blockers al palo importan muchísimo.',
            'En micro límites muchos pagan con cualquier corazón: no quemes dinero sin blocker.',
            80
        );
    }

    protected static function barrelTwoPairForValue(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_k96r_k9_turn_2',
            'turn_barrel',
            'Turn Barrel',
            'turn_two_pair_value',
            'Dos pares por valor',
            'BTN vs BB · K9s en K96r · Turn 2',
            'BTN',
            'BB',
            ['Kh', '9h'],
            ['Ks', '9d', '6c', '2s'],
            8.5,
            5.5,
            44.5,
            'K-high semi seco',
            'BTN tiene Kx fuertes y dobles ocasionales.',
            'Hero tiene dos pares y domina muchos Kx.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 9♦ 6♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 2♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Dos pares quiere construir bote contra Kx, 9x y proyectos. El turn no cambia casi nada.',
            'GTO simplificado: manos fuertes vulnerables apuestan grande en turn.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 92, 'feedback' => 'Excelente. Mucho valor contra Kx peor.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 40, 'ev_score' => 82, 'feedback' => 'Correcto, aunque cobras menos.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 38, 'feedback' => 'Demasiado pasivo con una mano fuerte.'],
            ],
            'Dos pares en turn suele buscar valor y protección.',
            'En NL2-NL10 apuesta fuerte: top pair paga demasiado.',
            92
        );
    }

    protected static function checkBackNutAdvantageLost(): array
    {
        return self::spot(
            'turn_barrel_co_vs_bb_654r_ak_turn_7',
            'turn_barrel',
            'Turn Barrel',
            'turn_nut_advantage_lost',
            'Check cuando pierdes ventaja de nuts',
            'CO vs BB · AK en 654r · Turn 7',
            'CO',
            'BB',
            ['Ah', 'Kd'],
            ['6s', '5d', '4c', '7h'],
            8.5,
            5.8,
            45.0,
            'Turn completa muchas escaleras',
            'BB conecta mucho con pares bajos, 8x, 3x y dobles.',
            'Hero tiene overcards sin equity suficiente.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: 6♠ 5♦ 4♣', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: 7♥', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'El 7 mejora muchísimo a BB. AK sin proyecto real no debe barrelear en una carta tan mala.',
            'GTO simplificado: cuando el caller gana nut advantage, muchos bluffs se abandonan.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 80, 'feedback' => 'Correcto. La carta favorece demasiado a BB.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 16, 'ev_score' => 30, 'feedback' => 'Farol muy flojo contra rango conectado.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 12, 'feedback' => 'Mal barrel: representas poco y te pagan/raisean fuerte.'],
            ],
            'Cuando la ventaja de nuts cambia, tu frecuencia de barrel debe bajar.',
            'En microlímites no farolees boards que claramente conectan con la ciega.',
            82
        );
    }

    protected static function barrelTurnPairsTopCard(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_k72r_ak_turn_k',
            'turn_barrel',
            'Turn Barrel',
            'turn_trips_value',
            'Trips por valor',
            'BTN vs BB · AK en K72r · Turn K',
            'BTN',
            'BB',
            ['Ah', 'Kh'],
            ['Ks', '7d', '2c', 'Kd'],
            8.5,
            5.5,
            44.5,
            'Top card emparejada',
            'BTN tiene muchos Kx fuertes y full houses ocasionales.',
            'Hero tiene trips top kicker y domina Kx peores.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♦ 2♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: K♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'AK bloquea Kx, pero sigue cobrando a K peores, 7x y pares curiosos. Sizing medio mantiene manos peores dentro.',
            'GTO simplificado: trips fuertes apuestan con frecuencia, usando sizing que retenga manos peores.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 86, 'feedback' => 'Correcto. Cobras sin espantar demasiadas manos peores.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 78, 'feedback' => 'También válido contra rivales muy pagadores.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 62, 'feedback' => 'Puede inducir, pero pierdes valor contra muchos rivales.'],
            ],
            'Trips fuertes siguen apostando, pero el tamaño debe pensar en qué manos peores pagan.',
            'En NL2-NL10 apuesta por valor; muchos pagan pares y Kx dominados.',
            86
        );
    }

    protected static function barrelEquityAndBlockers(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_a95ss_qsjs_turn_3d',
            'turn_barrel',
            'Turn Barrel',
            'turn_equity_blockers_barrel',
            'Barrel con equity y blockers',
            'BTN vs BB · QJss en A95ss · Turn 3',
            'BTN',
            'BB',
            ['Qs', 'Js'],
            ['As', '9s', '5d', '3c'],
            8.5,
            5.5,
            44.5,
            'A-high con draw de color fuerte',
            'BTN tiene Ax fuertes y proyectos altos.',
            'Hero tiene flush draw alto y bloquea colores fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 9♠ 5♦', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 3♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'QJss mantiene mucha equity y bloquea colores altos. Puede presionar 9x, pares y floats sin As.',
            'GTO simplificado: draws altos con blockers son buenos candidatos a second barrel.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 82, 'feedback' => 'Buen barrel. Tienes equity y blockers fuertes.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 36, 'ev_score' => 72, 'feedback' => 'Correcto, menos presión pero sigue bien.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 32, 'ev_score' => 62, 'feedback' => 'Check realiza equity, pero pierde fold equity.'],
            ],
            'Equity más blockers suele justificar seguir apostando.',
            'En micro límites apuesta tus draws fuertes, pero prepárate para recibir calls frecuentes.',
            82
        );
    }

    protected static function checkBackSecondPairWetTurn(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_j97ss_t9_turn_qs',
            'turn_barrel',
            'Turn Barrel',
            'turn_second_pair_wet_control',
            'Control con segunda pareja en turn malo',
            'BTN vs BB · T9 en J97ss · Turn Qs',
            'BTN',
            'BB',
            ['Th', '9h'],
            ['Js', '9s', '7d', 'Qs'],
            8.5,
            5.5,
            44.5,
            'Turn completa color y mejora broadways',
            'BB tiene colores, QJ, QT, T8 y muchos proyectos fuertes.',
            'Hero tiene segunda pareja con gutshot marginal.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 9♠ 7♦', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: Q♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'T9 ya no puede apostar cómodamente por valor. La Qs mejora demasiado el rango de BB.',
            'GTO simplificado: pares medios chequean cuando el turn completa muchos proyectos.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 78, 'feedback' => 'Correcto. Controlas bote en carta peligrosa.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 50, 'feedback' => 'Apuesta fina y peligrosa; te pagan mejores.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 22, 'feedback' => 'Demasiado grande para segunda pareja vulnerable.'],
            ],
            'Cuando el turn completa proyectos, las manos medias deben frenar.',
            'En NL2-NL10 no intentes sacar valor fino en cartas que asustan de verdad.',
            80
        );
    }

    protected static function barrelBlankWithOverpair(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_853r_qq_turn_2',
            'turn_barrel',
            'Turn Barrel',
            'turn_overpair_blank_value',
            'Overpair en blank absoluto',
            'BTN vs BB · QQ en 853r · Turn 2',
            'BTN',
            'BB',
            ['Qh', 'Qc'],
            ['8s', '5d', '3c', '2h'],
            8.5,
            5.5,
            44.5,
            'Board bajo con turn blank',
            'BTN tiene overpairs fuertes; BB tiene pares bajos y proyectos.',
            'Hero domina muchas parejas y necesita protección.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 8♠ 5♦ 3♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'QQ sigue muy fuerte y debe cobrar a 8x, 5x, pares y proyectos. El 2 no cambia casi nada.',
            'GTO simplificado: overpairs fuertes barrelean grande en turns blanks.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 90, 'feedback' => 'Excelente. Mucho valor contra pares peores.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 80, 'feedback' => 'Correcto, aunque puedes cobrar más.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 42, 'feedback' => 'Demasiado pasivo con overpair fuerte.'],
            ],
            'Los turns blanks son buenos para seguir apostando overpairs fuertes.',
            'En microlímites apuesta por valor: te pagan demasiados pares peores.',
            90
        );
    }

    protected static function giveUpAceHighNoBackdoor(): array
    {
        return self::spot(
            'turn_barrel_co_vs_bb_j86r_aq_turn_4',
            'turn_barrel',
            'Turn Barrel',
            'turn_air_no_backdoor_giveup',
            'Rendirse con aire sin backdoor',
            'CO vs BB · AQ en J86r · Turn 4',
            'CO',
            'BB',
            ['Ah', 'Qc'],
            ['Js', '8d', '6c', '4h'],
            8.5,
            5.8,
            45.0,
            'Board medio que conecta con BB',
            'BB tiene Jx, 8x, 6x, pares y draws que continúan.',
            'Hero solo tiene overcards sin proyecto claro.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: J♠ 8♦ 6♣', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'AQ no mejora y no tiene blockers suficientes. BB conectó demasiado con este board.',
            'GTO simplificado: aire sin equity abandona turns que no cambian la textura.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 78, 'feedback' => 'Correcto. No sigas quemando fichas.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 34, 'feedback' => 'Farol débil: BB continúa demasiado.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 12, 'feedback' => 'Muy caro sin equity ni blockers.'],
            ],
            'Los barrels necesitan una razón: equity, blockers o carta favorable.',
            'En NL2-NL10 abandonar aire malo es una gran fuente de ahorro.',
            80
        );
    }

    protected static function barrelStraightCompletedHero(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_986r_t7_turn_2',
            'turn_barrel',
            'Turn Barrel',
            'turn_straight_value',
            'Escalera hecha por valor',
            'BTN vs BB · T7s en 986r · Turn 2',
            'BTN',
            'BB',
            ['Th', '7h'],
            ['9s', '8d', '6c', '2s'],
            8.5,
            5.5,
            44.5,
            'Board conectado con escalera hecha',
            'BTN tiene algunas escaleras y sets; BB también conecta mucho.',
            'Hero tiene escalera y debe cobrar/proteger.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♠ 8♦ 6♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 2♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Con escalera hecha en board conectado hay que apostar grande contra pares, dobles, sets y draws.',
            'GTO simplificado: manos muy fuertes apuestan grande en boards dinámicos.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 74, 'ev_score' => 94, 'feedback' => 'Excelente. Cobras y proteges en board peligroso.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 40, 'ev_score' => 82, 'feedback' => 'Correcto, aunque puedes extraer más.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 6, 'ev_score' => 18, 'feedback' => 'Slowplay malo: hay demasiadas cartas peligrosas.'],
            ],
            'Las escaleras hechas en boards dinámicos quieren construir bote.',
            'En NL2-NL10 apuesta fuerte: pagan con dobles, sets y proyectos.',
            94
        );
    }

    protected static function smallBarrelRangeOnAceTurn(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_q72r_kq_turn_a',
            'turn_barrel',
            'Turn Barrel',
            'turn_ace_range_barrel',
            'Barrel pequeño en As favorable',
            'BTN vs BB · KQ en Q72r · Turn A',
            'BTN',
            'BB',
            ['Kh', 'Qh'],
            ['Qs', '7d', '2c', 'Ad'],
            8.5,
            5.5,
            44.5,
            'As turn favorece al agresor',
            'BTN tiene muchos Ax fuertes y dobles.',
            'Hero mantiene segunda pareja fuerte y puede apostar pequeño.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♦ 2♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: A♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_50',
            'El As favorece a BTN, pero KQ no quiere inflar demasiado. Sizing medio cobra/protege y presiona pares medios.',
            'GTO simplificado: cartas muy favorables permiten barrels pequeños/medios con rango amplio.',
            [
                'BET_50' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 78, 'feedback' => 'Bien. Usas carta favorable sin sobrepolarizar.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 36, 'ev_score' => 70, 'feedback' => 'Check también controla bien con showdown value.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 16, 'ev_score' => 52, 'feedback' => 'Grande de más para una mano media.'],
            ],
            'Las cartas que favorecen tu rango no significan apostar grande siempre.',
            'En microlímites usa tamaño medio: aún te pagan Qx y pares curiosos.',
            78
        );
    }

    protected static function checkBackTopPairFacingBadTurn(): array
    {
        return self::spot(
            'turn_barrel_co_vs_bb_t74ss_at_turn_9s',
            'turn_barrel',
            'Turn Barrel',
            'turn_top_pair_bad_turn_control',
            'Top pair en turn muy peligroso',
            'CO vs BB · AT en T74ss · Turn 9s',
            'CO',
            'BB',
            ['Ah', 'Tc'],
            ['Ts', '7s', '4d', '9s'],
            8.5,
            5.8,
            45.0,
            'Turn completa color y aumenta conectividad',
            'BB tiene colores, 98, J8, pares y proyectos completados.',
            'Hero tiene top pair, pero su valor relativo bajó mucho.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: T♠ 7♠ 4♦', 'BB checks', 'CO bets 2 BB', 'BB calls', 'Turn: 9♠', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'AT tiene showdown value, pero apostar turn se aísla contra colores, escaleras y mejores Tx.',
            'GTO simplificado: top pair frena en turns que completan muchos proyectos.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 78, 'feedback' => 'Correcto. Controlas bote en turn peligroso.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 54, 'feedback' => 'Thin value arriesgado: muchas peores foldean y mejores pagan.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 24, 'feedback' => 'Demasiado grande con top pair vulnerable.'],
            ],
            'Top pair debe bajar frecuencia cuando el turn completa proyectos claros.',
            'En NL2-NL10 controlar bote evita pagar raises fuertes con manos medias.',
            80
        );
    }

    protected static function barrelPolarWithNutBlocker(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_a84dd_kdqc_turn_2d',
            'turn_barrel',
            'Turn Barrel',
            'turn_polar_nut_blocker',
            'Barrel polar con blocker fuerte',
            'BTN vs BB · KdQc en A84dd · Turn 2d',
            'BTN',
            'BB',
            ['Kd', 'Qc'],
            ['Ad', '8d', '4c', '2d'],
            8.5,
            5.5,
            44.5,
            'Color completado en turn',
            'BTN representa colores altos, Ax fuertes y manos polarizadas.',
            'Hero bloquea colores altos con Kd.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♦ 8♦ 4♣', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 2♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'Kd bloquea colores fuertes y permite presionar Ax sin diamante, 8x y pares medios.',
            'GTO simplificado: blockers fuertes permiten barrels polarizados en cartas que completan proyectos.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 42, 'ev_score' => 78, 'feedback' => 'Buen bluff polar. Tienes blocker importante.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 60, 'feedback' => 'Medio presiona poco y no representa tanta fuerza.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 68, 'feedback' => 'Check también es prudente contra rivales muy pagadores.'],
            ],
            'Los blockers fuertes pueden convertir algunas manos sin valor en buenos barrels.',
            'En microlímites úsalo selectivo: muchos rivales no foldean Ax aunque completes color.',
            78
        );
    }

}
