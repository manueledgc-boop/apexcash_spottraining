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
        ];
    }

    protected static function barrelAceHighGoodTurn(): array
    {
        return self::spot(
            'turn_barrel_btn_vs_bb_a72r_2nd_barrel_ak_q',
            'turn_barrel',
            'Turn Barrel',
            'second_barrel_value',
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
            'overpair_second_barrel',
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
            'give_up_bad_turn',
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
            'made_nut_flush_value',
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
            'scare_card_second_barrel',
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
            'turn_showdown_control',
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
            'top_pair_protection_turn',
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
            'give_up_no_equity',
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
            'equity_improves_turn',
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
            'dangerous_turn_control',
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
}
