<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class BbVsBtnSpots
{
    use BuildsSpotPlayers;

    public static function all(): array
    {
        return [
            self::t9s(), self::kto(), self::a2s(), self::q7o(), self::pocket44(),
            self::j5s(), self::a5s(), self::a9o(), self::k9s(), self::qjo(),
            self::jto(), self::t8s(), self::pocket22(), self::pocket88(), self::k4s(),
            self::q2s(), self::j7o(), self::a7s(), self::kqo(), self::q9o(),
            self::t6s(), self::nineEightOff(), self::sixFiveSuited(), self::sevenTwoOff(), self::aTo(),
        ];
    }

    protected static function base(
        array $heroCards,
        string $correctAction,
        string $explanation,
        string $solverNote,
        array $grades
    ): array {
        return [
            'id' => self::spotId($heroCards),
            'module' => 'bb_vs_btn',
            'module_label' => 'BB vs BTN',
            'title' => 'Defensa BB contra open BTN',
            'hero_position' => 'BB',
            'hero_cards' => $heroCards,
            'villain_position' => 'BTN',
            'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
            'pot_bb' => 4,
            'actions' => [
                'UTG folds',
                'HJ folds',
                'CO folds',
                'BTN raises 2.5 BB',
                'SB folds',
                'Action on Hero BB',
            ],
            'options' => ['FOLD', 'CALL', '3BET'],
            'correct_action' => $correctAction,
            'explanation' => $explanation,
            'solver_note' => $solverNote,
            'action_grades' => $grades,
            'answers' => [
                'gto' => [
                    'correct_action' => $correctAction,
                    'explanation' => $explanation,
                    'solver_note' => $solverNote,
                    'action_grades' => $grades,
                ],
            ],
            'confidence' => self::confidenceFromGrades($grades),
            'table_players' => self::defaultPlayers('BB', 'BTN'),
        ];
    }

    protected static function grades(
        string $best,
        int $foldFreq,
        int $callFreq,
        int $threeBetFreq,
        array $ev,
        array $feedback
    ): array {
        return [
            'FOLD' => [
                'grade' => $best === 'FOLD' ? 'best' : ($foldFreq >= 30 ? 'marginal' : 'mistake'),
                'frequency' => $foldFreq,
                'ev_score' => $ev['FOLD'],
                'feedback' => $feedback['FOLD'],
            ],
            'CALL' => [
                'grade' => $best === 'CALL' ? 'best' : ($callFreq >= 20 ? 'good' : 'mistake'),
                'frequency' => $callFreq,
                'ev_score' => $ev['CALL'],
                'feedback' => $feedback['CALL'],
            ],
            '3BET' => [
                'grade' => $best === '3BET' ? 'best' : ($threeBetFreq >= 15 ? 'good' : 'mistake'),
                'frequency' => $threeBetFreq,
                'ev_score' => $ev['3BET'],
                'feedback' => $feedback['3BET'],
            ],
        ];
    }

    protected static function t9s(): array
    {
        return self::base(['Tc','9c'], 'CALL',
            'T9s defiende muy bien en BB contra BTN por pot odds y jugabilidad. Puede mezclarse como 3Bet.',
            'GTO simplificado: FOLD 6%, CALL 76%, 3BET 18%.',
            self::grades('CALL', 6, 76, 18, ['FOLD'=>20,'CALL'=>100,'3BET'=>82], [
                'FOLD'=>'Demasiado tight. BB tiene buen precio y T9s defiende claramente.',
                'CALL'=>'Correcto. T9s realiza equity muy bien y conecta muchos boards.',
                '3BET'=>'Aceptable como mezcla, pero no conviertas todos los suited connectors en 3Bet.',
            ])
        );
    }

    protected static function kto(): array
    {
        return self::base(['Kd','To'], 'CALL',
            'KTo tiene suficiente equity para defender BB vs BTN, aunque juega peor que KTs.',
            'GTO simplificado: FOLD 24%, CALL 68%, 3BET 8%.',
            self::grades('CALL', 24, 68, 8, ['FOLD'=>62,'CALL'=>100,'3BET'=>35], [
                'FOLD'=>'Conservador. Puede existir contra open grande o rival tight.',
                'CALL'=>'Correcto. KTo entra en la defensa estándar BB vs BTN.',
                '3BET'=>'No es buen 3Bet estándar: puede quedar dominada por mejores Kx.',
            ])
        );
    }

    protected static function a2s(): array
    {
        return self::base(['As','2s'], 'CALL',
            'A2s defiende bien por blocker, equity suited y capacidad de ligar proyectos fuertes.',
            'GTO simplificado: FOLD 10%, CALL 58%, 3BET 32%.',
            self::grades('CALL', 10, 58, 32, ['FOLD'=>25,'CALL'=>100,'3BET'=>88], [
                'FOLD'=>'Demasiado tight. A2s es demasiado jugable.',
                'CALL'=>'Correcto. A2s realiza bien equity pagando.',
                '3BET'=>'Buena mezcla como bluff por blocker al As.',
            ])
        );
    }

    protected static function q7o(): array
    {
        return self::base(['Qh','7d'], 'FOLD',
            'Q7o offsuit realiza mal equity, queda dominada y no tiene suficiente jugabilidad.',
            'GTO simplificado: FOLD 82%, CALL 18%, 3BET 0%.',
            self::grades('FOLD', 82, 18, 0, ['FOLD'=>100,'CALL'=>35,'3BET'=>0], [
                'FOLD'=>'Correcto. Q7o es fold estándar BB vs BTN.',
                'CALL'=>'Demasiado loose como base. La mano realiza mal equity.',
                '3BET'=>'Blunder. Sin blockers ni jugabilidad para 3Bet bluff.',
            ])
        );
    }

    protected static function pocket44(): array
    {
        return self::base(['4c','4d'], 'CALL',
            '44 defiende por precio, showdown value y posibilidad de set.',
            'GTO simplificado: FOLD 12%, CALL 86%, 3BET 2%.',
            self::grades('CALL', 12, 86, 2, ['FOLD'=>60,'CALL'=>100,'3BET'=>18], [
                'FOLD'=>'Conservador. Puede existir contra size grande, pero estándar es call.',
                'CALL'=>'Correcto. 44 tiene suficiente valor para defender pagando.',
                '3BET'=>'No es buen 3Bet: no bloquea premiums.',
            ])
        );
    }

    protected static function j5s(): array
    {
        return self::base(['Js','5s'], 'CALL',
            'J5s está cerca del borde, pero puede defenderse por precio y suitedness.',
            'GTO simplificado: FOLD 42%, CALL 54%, 3BET 4%.',
            self::grades('CALL', 42, 54, 4, ['FOLD'=>74,'CALL'=>100,'3BET'=>25], [
                'FOLD'=>'No es grave. Es una mano de borde.',
                'CALL'=>'Correcto. Defensa fina pero aceptable por precio.',
                '3BET'=>'No es el mejor bluff; hay mejores blockers.',
            ])
        );
    }

    protected static function a5s(): array
    {
        return self::base(['Ah','5h'], 'CALL',
            'A5s puede pagar o 3betear. Tiene blocker fuerte, buena equity y jugabilidad suited.',
            'GTO simplificado: FOLD 6%, CALL 50%, 3BET 44%.',
            self::grades('CALL', 6, 50, 44, ['FOLD'=>15,'CALL'=>100,'3BET'=>96], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. A5s defiende bien por precio.',
                '3BET'=>'Muy buena mezcla como bluff por blocker al As.',
            ])
        );
    }

    protected static function a9o(): array
    {
        return self::base(['Ah','9d'], 'CALL',
            'A9o tiene suficiente fuerza contra BTN, pero no quiere inflar demasiado el bote como 3Bet estándar.',
            'GTO simplificado: FOLD 26%, CALL 66%, 3BET 8%.',
            self::grades('CALL', 26, 66, 8, ['FOLD'=>64,'CALL'=>100,'3BET'=>38], [
                'FOLD'=>'Conservador. Contra open 2.5x se defiende bastante.',
                'CALL'=>'Correcto. A9o tiene equity suficiente contra BTN.',
                '3BET'=>'No es principal; se domina al recibir call.',
            ])
        );
    }

    protected static function k9s(): array
    {
        return self::base(['Ks','9s'], 'CALL',
            'K9s defiende bien por suitedness, blocker y jugabilidad.',
            'GTO simplificado: FOLD 8%, CALL 74%, 3BET 18%.',
            self::grades('CALL', 8, 74, 18, ['FOLD'=>25,'CALL'=>100,'3BET'=>82], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. K9s realiza bien equity.',
                '3BET'=>'Aceptable como mezcla baja-media.',
            ])
        );
    }

    protected static function qjo(): array
    {
        return self::base(['Qh','Jd'], 'CALL',
            'QJo offsuit puede defenderse contra BTN por fuerza relativa, aunque es más delicada que QJs.',
            'GTO simplificado: FOLD 34%, CALL 60%, 3BET 6%.',
            self::grades('CALL', 34, 60, 6, ['FOLD'=>72,'CALL'=>100,'3BET'=>28], [
                'FOLD'=>'Conservador. Puede existir contra size grande.',
                'CALL'=>'Correcto como defensa estándar contra BTN.',
                '3BET'=>'No es buen 3Bet principal.',
            ])
        );
    }

    protected static function jto(): array
    {
        return self::base(['Jh','Td'], 'CALL',
            'JTo defiende contra BTN por conectividad y fuerza relativa, aunque sufre dominación.',
            'GTO simplificado: FOLD 38%, CALL 58%, 3BET 4%.',
            self::grades('CALL', 38, 58, 4, ['FOLD'=>75,'CALL'=>100,'3BET'=>22], [
                'FOLD'=>'No es horrible, pero algo conservador.',
                'CALL'=>'Correcto. JTo entra cerca del borde de defensa.',
                '3BET'=>'Demasiado ambicioso como estándar.',
            ])
        );
    }

    protected static function t8s(): array
    {
        return self::base(['Ts','8s'], 'CALL',
            'T8s defiende bien por conectividad, suitedness y realización de equity.',
            'GTO simplificado: FOLD 18%, CALL 76%, 3BET 6%.',
            self::grades('CALL', 18, 76, 6, ['FOLD'=>45,'CALL'=>100,'3BET'=>35], [
                'FOLD'=>'Algo tight.',
                'CALL'=>'Correcto. Mano muy jugable contra BTN.',
                '3BET'=>'No es principal; mejores suited hands pueden bluffear.',
            ])
        );
    }

    protected static function pocket22(): array
    {
        return self::base(['2c','2d'], 'CALL',
            '22 puede defender por precio y set value, aunque está cerca del borde.',
            'GTO simplificado: FOLD 28%, CALL 70%, 3BET 2%.',
            self::grades('CALL', 28, 70, 2, ['FOLD'=>68,'CALL'=>100,'3BET'=>10], [
                'FOLD'=>'Conservador; aceptable contra size grande.',
                'CALL'=>'Correcto. Set value suficiente.',
                '3BET'=>'Mala idea: sin blockers.',
            ])
        );
    }

    protected static function pocket88(): array
    {
        return self::base(['8c','8d'], 'CALL',
            '88 es defensa clara por showdown value y set value.',
            'GTO simplificado: FOLD 4%, CALL 92%, 3BET 4%.',
            self::grades('CALL', 4, 92, 4, ['FOLD'=>12,'CALL'=>100,'3BET'=>35], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Defensa clara.',
                '3BET'=>'No es principal, pero puede mezclarse muy poco.',
            ])
        );
    }

    protected static function k4s(): array
    {
        return self::base(['Kh','4h'], 'CALL',
            'K4s puede defender por suitedness y blocker, aunque está en zona de borde.',
            'GTO simplificado: FOLD 36%, CALL 56%, 3BET 8%.',
            self::grades('CALL', 36, 56, 8, ['FOLD'=>76,'CALL'=>100,'3BET'=>40], [
                'FOLD'=>'Aceptable contra size grande, pero algo conservador.',
                'CALL'=>'Correcto. Defensa fina con suited king.',
                '3BET'=>'Mezcla baja; no principal.',
            ])
        );
    }

    protected static function q2s(): array
    {
        return self::base(['Qs','2s'], 'FOLD',
            'Q2s tiene suitedness, pero kicker muy débil y poca jugabilidad suficiente.',
            'GTO simplificado: FOLD 62%, CALL 36%, 3BET 2%.',
            self::grades('FOLD', 62, 36, 2, ['FOLD'=>100,'CALL'=>70,'3BET'=>12], [
                'FOLD'=>'Correcto. Es una suited queen muy débil.',
                'CALL'=>'Puede existir a baja frecuencia, pero es thin.',
                '3BET'=>'Demasiado débil para 3Bet bluff.',
            ])
        );
    }

    protected static function j7o(): array
    {
        return self::base(['Jh','7d'], 'FOLD',
            'J7o offsuit realiza mal equity y queda dominada con frecuencia.',
            'GTO simplificado: FOLD 86%, CALL 14%, 3BET 0%.',
            self::grades('FOLD', 86, 14, 0, ['FOLD'=>100,'CALL'=>25,'3BET'=>0], [
                'FOLD'=>'Correcto. Fold estándar.',
                'CALL'=>'Demasiado loose.',
                '3BET'=>'Blunder. Sin blockers ni jugabilidad.',
            ])
        );
    }

    protected static function a7s(): array
    {
        return self::base(['Ac','7c'], 'CALL',
            'A7s defiende muy bien y también puede 3betearse por blocker.',
            'GTO simplificado: FOLD 4%, CALL 62%, 3BET 34%.',
            self::grades('CALL', 4, 62, 34, ['FOLD'=>10,'CALL'=>100,'3BET'=>92], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Defensa muy sólida.',
                '3BET'=>'Buena mezcla por blocker al As.',
            ])
        );
    }

    protected static function kqo(): array
    {
        return self::base(['Kh','Qd'], 'CALL',
            'KQo es defensa clara BB vs BTN. Tiene fuerza relativa, pero 3Bet no siempre es obligatorio.',
            'GTO simplificado: FOLD 6%, CALL 70%, 3BET 24%.',
            self::grades('CALL', 6, 70, 24, ['FOLD'=>15,'CALL'=>100,'3BET'=>88], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. KQo defiende claramente.',
                '3BET'=>'Buena mezcla lineal, pero no automática.',
            ])
        );
    }

    protected static function q9o(): array
    {
        return self::base(['Qh','9d'], 'FOLD',
            'Q9o está cerca del borde, pero como base sólida foldea bastante contra 2.5x.',
            'GTO simplificado: FOLD 58%, CALL 40%, 3BET 2%.',
            self::grades('FOLD', 58, 40, 2, ['FOLD'=>100,'CALL'=>78,'3BET'=>10], [
                'FOLD'=>'Correcto como base sólida.',
                'CALL'=>'Aceptable contra BTN muy amplio, pero no obligatorio.',
                '3BET'=>'Demasiado débil como bluff.',
            ])
        );
    }

    protected static function t6s(): array
    {
        return self::base(['Tc','6c'], 'FOLD',
            'T6s tiene suitedness pero conectividad pobre. Es fold o defensa muy marginal.',
            'GTO simplificado: FOLD 54%, CALL 44%, 3BET 2%.',
            self::grades('FOLD', 54, 44, 2, ['FOLD'=>100,'CALL'=>80,'3BET'=>12], [
                'FOLD'=>'Correcto como estrategia base.',
                'CALL'=>'Marginal; puede existir contra size pequeño.',
                '3BET'=>'No es buen 3Bet bluff.',
            ])
        );
    }

    protected static function nineEightOff(): array
    {
        return self::base(['9h','8d'], 'CALL',
            '98o puede defender contra BTN por conectividad, aunque es mucho peor que 98s.',
            'GTO simplificado: FOLD 44%, CALL 54%, 3BET 2%.',
            self::grades('CALL', 44, 54, 2, ['FOLD'=>82,'CALL'=>100,'3BET'=>10], [
                'FOLD'=>'Conservador, pero no grave.',
                'CALL'=>'Correcto si BTN abre 2.5x y no es muy tight.',
                '3BET'=>'No tiene blockers ni suficiente calidad para 3Bet.',
            ])
        );
    }

    protected static function sixFiveSuited(): array
    {
        return self::base(['6s','5s'], 'CALL',
            '65s defiende muy bien por conectividad, suitedness y implied odds.',
            'GTO simplificado: FOLD 10%, CALL 82%, 3BET 8%.',
            self::grades('CALL', 10, 82, 8, ['FOLD'=>25,'CALL'=>100,'3BET'=>48], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Excelente realización de equity por precio.',
                '3BET'=>'Puede existir a baja frecuencia, pero call es principal.',
            ])
        );
    }

    protected static function sevenTwoOff(): array
    {
        return self::base(['7c','2d'], 'FOLD',
            '72o es la peor estructura posible: offsuit, desconectada y sin blockers útiles.',
            'GTO simplificado: FOLD 100%, CALL 0%, 3BET 0%.',
            self::grades('FOLD', 100, 0, 0, ['FOLD'=>100,'CALL'=>0,'3BET'=>0], [
                'FOLD'=>'Correcto. Fold automático.',
                'CALL'=>'Blunder. No hay suficiente equity ni jugabilidad.',
                '3BET'=>'Blunder total. No hay blockers ni equity.',
            ])
        );
    }

    protected static function aTo(): array
    {
        return self::base(['As','Td'], 'CALL',
            'ATo tiene suficiente equity contra BTN, aunque puede estar dominada. Call es línea base.',
            'GTO simplificado: FOLD 20%, CALL 70%, 3BET 10%.',
            self::grades('CALL', 20, 70, 10, ['FOLD'=>55,'CALL'=>100,'3BET'=>45], [
                'FOLD'=>'Algo tight contra BTN 2.5x.',
                'CALL'=>'Correcto. ATo defiende con suficiente equity.',
                '3BET'=>'No es principal; cuidado con dominación.',
            ])
        );
    }

    protected static function spotId(array $cards): string
    {
        return 'bb_vs_btn_' . self::cardsKey($cards);
    }

    protected static function cardsKey(array $cards): string
    {
        return strtolower((string) preg_replace('/[^a-zA-Z0-9]+/', '', implode('', $cards)));
    }

    protected static function confidenceFromGrades(array $grades): int
    {
        $frequencies = array_map(fn (array $grade) => (int) ($grade['frequency'] ?? 0), $grades);

        return max(60, min(95, max($frequencies ?: [80])));
    }

}