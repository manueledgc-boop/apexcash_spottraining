<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class BtnVs3BetSpots
{
    use BuildsSpotPlayers;

    public static function all(): array
    {
        return [
            self::ajsVsSb(), self::a5sVsSb(), self::kqoVsSb(), self::aqoVsSb(), self::ttVsSb(),
            self::kjsVsSb(), self::qtsVsSb(), self::a9oVsSb(), self::j9sVsSb(), self::pocket55VsSb(),
            self::a4sVsSb(), self::k9sVsSb(), self::qjoVsSb(),

            self::pair77VsBb(), self::ktsVsBb(), self::qjoVsBb(), self::aqsVsBb(), self::a5sVsBb(),
            self::pocket99VsBb(), self::qtsVsBb(), self::j8sVsBb(), self::atoVsBb(), self::pocket33VsBb(),
            self::kjoVsBb(), self::t9sVsBb(),
        ];
    }

    protected static function base(
        array $heroCards,
        string $villainPosition,
        string $correctAction,
        string $explanation,
        string $solverNote,
        array $grades
    ): array {
        $actions = $villainPosition === 'SB'
            ? ['UTG folds', 'HJ folds', 'CO folds', 'Hero BTN raises 2.5 BB', 'SB 3bets 10 BB', 'BB folds']
            : ['UTG folds', 'HJ folds', 'CO folds', 'Hero BTN raises 2.5 BB', 'SB folds', 'BB 3bets 10 BB'];

        return [
            'module' => 'btn_vs_3bet',
            'module_label' => 'BTN vs 3Bet',
            'title' => "BTN abre y {$villainPosition} hace 3Bet",
            'hero_position' => 'BTN',
            'hero_cards' => $heroCards,
            'villain_position' => $villainPosition,
            'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
            'pot_bb' => 13.5,
            'actions' => $actions,
            'options' => ['FOLD', 'CALL', '4BET'],
            'correct_action' => $correctAction,
            'explanation' => $explanation,
            'solver_note' => $solverNote,
            'action_grades' => $grades,
            'table_players' => self::defaultPlayers('BTN', $villainPosition),
        ];
    }

    protected static function grades(
        string $best,
        int $foldFreq,
        int $callFreq,
        int $fourBetFreq,
        array $ev,
        array $feedback
    ): array {
        return [
            'FOLD' => [
                'grade' => $best === 'FOLD' ? 'best' : ($foldFreq >= 25 ? 'marginal' : 'mistake'),
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
            '4BET' => [
                'grade' => $best === '4BET' ? 'best' : ($fourBetFreq >= 15 ? 'good' : 'mistake'),
                'frequency' => $fourBetFreq,
                'ev_score' => $ev['4BET'],
                'feedback' => $feedback['4BET'],
            ],
        ];
    }

    protected static function ajsVsSb(): array
    {
        return self::base(['As','Js'], 'SB', 'CALL',
            'AJs defiende muy bien en posición contra SB. Call es línea principal; 4Bet existe como mezcla.',
            'GTO simplificado: FOLD 4%, CALL 74%, 4BET 22%.',
            self::grades('CALL', 4, 74, 22, ['FOLD'=>5,'CALL'=>100,'4BET'=>82], [
                'FOLD'=>'Blunder. AJs es demasiado fuerte para foldear.',
                'CALL'=>'Correcto. Realiza equity muy bien IP.',
                '4BET'=>'Aceptable como mezcla, no como automático.',
            ])
        );
    }

    protected static function a5sVsSb(): array
    {
        return self::base(['Ah','5h'], 'SB', '4BET',
            'A5s es uno de los mejores 4Bet bluffs: bloquea Ax fuertes y conserva equity.',
            'GTO simplificado: FOLD 12%, CALL 30%, 4BET 58%.',
            self::grades('4BET', 12, 30, 58, ['FOLD'=>25,'CALL'=>65,'4BET'=>100], [
                'FOLD'=>'Demasiado tight. Tiene blockers y equity.',
                'CALL'=>'Marginal/mezcla. Suele rendir mejor como 4Bet.',
                '4BET'=>'Correcto. Candidato natural de 4Bet bluff.',
            ])
        );
    }

    protected static function kqoVsSb(): array
    {
        return self::base(['Kh','Qo'], 'SB', 'CALL',
            'KQo puede defenderse IP contra SB, pero no es una 4Bet automática.',
            'GTO simplificado: FOLD 28%, CALL 62%, 4BET 10%.',
            self::grades('CALL', 28, 62, 10, ['FOLD'=>58,'CALL'=>100,'4BET'=>35], [
                'FOLD'=>'Conservador. Puede existir contra rival muy tight.',
                'CALL'=>'Correcto. Buena defensa IP.',
                '4BET'=>'Error como estándar: suele quedar dominada cuando continúa la acción.',
            ])
        );
    }

    protected static function aqoVsSb(): array
    {
        return self::base(['Ad','Qc'], 'SB', 'CALL',
            'AQo es defensa obligatoria. Call domina como línea base; 4Bet también puede mezclarse.',
            'GTO simplificado: FOLD 2%, CALL 64%, 4BET 34%.',
            self::grades('CALL', 2, 64, 34, ['FOLD'=>3,'CALL'=>100,'4BET'=>92], [
                'FOLD'=>'Blunder. AQo es demasiado fuerte para foldear BTN vs SB.',
                'CALL'=>'Correcto. Mantienes dominadas y realizas equity IP.',
                '4BET'=>'Buena mezcla, pero no debe ser siempre.',
            ])
        );
    }

    protected static function ttVsSb(): array
    {
        return self::base(['Tc','Td'], 'SB', 'CALL',
            'TT es defensa muy fuerte. Call mantiene el rango de SB amplio; 4Bet/call puede existir.',
            'GTO simplificado: FOLD 0%, CALL 70%, 4BET 30%.',
            self::grades('CALL', 0, 70, 30, ['FOLD'=>0,'CALL'=>100,'4BET'=>90], [
                'FOLD'=>'Blunder absoluto. TT nunca se foldea aquí.',
                'CALL'=>'Correcto. Defensa fuerte y estable.',
                '4BET'=>'Buena mezcla, especialmente contra SB agresivo.',
            ])
        );
    }

    protected static function kjsVsSb(): array
    {
        return self::base(['Ks','Js'], 'SB', 'CALL',
            'KJs suited defiende muy bien IP contra SB por blockers y jugabilidad.',
            'GTO simplificado: FOLD 6%, CALL 78%, 4BET 16%.',
            self::grades('CALL', 6, 78, 16, ['FOLD'=>18,'CALL'=>100,'4BET'=>76], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. KJs suited realiza muy bien equity.',
                '4BET'=>'Aceptable como mezcla baja.',
            ])
        );
    }

    protected static function qtsVsSb(): array
    {
        return self::base(['Qs','Ts'], 'SB', 'CALL',
            'QTs suited es una defensa natural en posición contra SB 3Bet.',
            'GTO simplificado: FOLD 12%, CALL 78%, 4BET 10%.',
            self::grades('CALL', 12, 78, 10, ['FOLD'=>25,'CALL'=>100,'4BET'=>62], [
                'FOLD'=>'Tight como estándar.',
                'CALL'=>'Correcto. Buena jugabilidad y equity realizable.',
                '4BET'=>'No es principal; mezcla baja.',
            ])
        );
    }

    protected static function a9oVsSb(): array
    {
        return self::base(['Ah','9d'], 'SB', 'FOLD',
            'A9o offsuit se domina mucho y realiza mal equity en 3Bet pot.',
            'GTO simplificado: FOLD 68%, CALL 24%, 4BET 8%.',
            self::grades('FOLD', 68, 24, 8, ['FOLD'=>100,'CALL'=>45,'4BET'=>30], [
                'FOLD'=>'Correcto. A9o está dominada demasiadas veces.',
                'CALL'=>'Demasiado loose como estándar.',
                '4BET'=>'Mal candidato a 4Bet bluff.',
            ])
        );
    }

    protected static function j9sVsSb(): array
    {
        return self::base(['Jh','9h'], 'SB', 'CALL',
            'J9s puede defender IP por jugabilidad, aunque está cerca del borde.',
            'GTO simplificado: FOLD 28%, CALL 66%, 4BET 6%.',
            self::grades('CALL', 28, 66, 6, ['FOLD'=>62,'CALL'=>100,'4BET'=>30], [
                'FOLD'=>'Conservador; no horrible.',
                'CALL'=>'Correcto. Mano jugable IP.',
                '4BET'=>'Demasiado ambicioso como estándar.',
            ])
        );
    }

    protected static function pocket55VsSb(): array
    {
        return self::base(['5c','5d'], 'SB', 'CALL',
            '55 defiende IP por set value y cierta equity de showdown.',
            'GTO simplificado: FOLD 24%, CALL 74%, 4BET 2%.',
            self::grades('CALL', 24, 74, 2, ['FOLD'=>65,'CALL'=>100,'4BET'=>15], [
                'FOLD'=>'Puede existir contra nit, pero estándar es call.',
                'CALL'=>'Correcto. Defensa rentable IP.',
                '4BET'=>'Mal candidato: sin blockers.',
            ])
        );
    }

    protected static function a4sVsSb(): array
    {
        return self::base(['Ac','4c'], 'SB', '4BET',
            'A4s es otro candidato fuerte de 4Bet bluff por blocker al As y equity suited.',
            'GTO simplificado: FOLD 10%, CALL 34%, 4BET 56%.',
            self::grades('4BET', 10, 34, 56, ['FOLD'=>30,'CALL'=>70,'4BET'=>100], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Aceptable, pero no captura todo el fold equity.',
                '4BET'=>'Correcto. Buen blocker y buena estructura de bluff.',
            ])
        );
    }

    protected static function k9sVsSb(): array
    {
        return self::base(['Kh','9h'], 'SB', 'CALL',
            'K9s defiende a frecuencia alta contra SB por suitedness y blocker.',
            'GTO simplificado: FOLD 18%, CALL 72%, 4BET 10%.',
            self::grades('CALL', 18, 72, 10, ['FOLD'=>45,'CALL'=>100,'4BET'=>55], [
                'FOLD'=>'Algo tight.',
                'CALL'=>'Correcto. K9s es defensa razonable IP.',
                '4BET'=>'Mezcla baja; no principal.',
            ])
        );
    }

    protected static function qjoVsSb(): array
    {
        return self::base(['Qh','Jd'], 'SB', 'CALL',
            'QJo contra SB es mejor que contra BB porque SB 3betea OOP y suele tener más bluffs.',
            'GTO simplificado: FOLD 38%, CALL 58%, 4BET 4%.',
            self::grades('CALL', 38, 58, 4, ['FOLD'=>70,'CALL'=>100,'4BET'=>18], [
                'FOLD'=>'Conservador; aceptable contra nit.',
                'CALL'=>'Correcto como defensa IP contra SB.',
                '4BET'=>'Mala 4Bet: dominada y sin buenos blockers.',
            ])
        );
    }

    protected static function pair77VsBb(): array
    {
        return self::base(['7c','7d'], 'BB', 'CALL',
            '77 puede pagar IP contra BB 3Bet con 100 BB.',
            'GTO simplificado: FOLD 25%, CALL 72%, 4BET 3%.',
            self::grades('CALL', 25, 72, 3, ['FOLD'=>60,'CALL'=>100,'4BET'=>15], [
                'FOLD'=>'Conservador; call es estándar.',
                'CALL'=>'Correcto. Buen set value y showdown value.',
                '4BET'=>'Mal candidato: sin blockers.',
            ])
        );
    }

    protected static function ktsVsBb(): array
    {
        return self::base(['Ks','Ts'], 'BB', 'CALL',
            'KTs suited defiende bien IP contra BB 3Bet.',
            'GTO simplificado: FOLD 8%, CALL 78%, 4BET 14%.',
            self::grades('CALL', 8, 78, 14, ['FOLD'=>25,'CALL'=>100,'4BET'=>67], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Realiza muy bien equity.',
                '4BET'=>'Mezcla baja aceptable.',
            ])
        );
    }

    protected static function qjoVsBb(): array
    {
        return self::base(['Qh','Jo'], 'BB', 'FOLD',
            'QJo offsuit realiza mal equity contra BB 3Bet y suele estar dominada.',
            'GTO simplificado: FOLD 78%, CALL 20%, 4BET 2%.',
            self::grades('FOLD', 78, 20, 2, ['FOLD'=>100,'CALL'=>35,'4BET'=>5], [
                'FOLD'=>'Correcto. Fold estándar.',
                'CALL'=>'Demasiado loose como base.',
                '4BET'=>'Blunder. Mal candidato a bluff.',
            ])
        );
    }

    protected static function aqsVsBb(): array
    {
        return self::base(['As','Qs'], 'BB', 'CALL',
            'AQs es defensa premium. Call domina, 4Bet es mezcla fuerte.',
            'GTO simplificado: FOLD 0%, CALL 58%, 4BET 42%.',
            self::grades('CALL', 0, 58, 42, ['FOLD'=>0,'CALL'=>100,'4BET'=>96], [
                'FOLD'=>'Blunder absoluto.',
                'CALL'=>'Correcto. Mantienes rango amplio y realizas equity.',
                '4BET'=>'Muy buena mezcla por valor.',
            ])
        );
    }

    protected static function a5sVsBb(): array
    {
        return self::base(['Ad','5d'], 'BB', 'CALL',
            'A5s contra BB puede pagar o 4betear; ambas líneas tienen sentido.',
            'GTO simplificado: FOLD 8%, CALL 50%, 4BET 42%.',
            self::grades('CALL', 8, 50, 42, ['FOLD'=>20,'CALL'=>100,'4BET'=>96], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Defensa sólida.',
                '4BET'=>'Muy buena mezcla por blocker.',
            ])
        );
    }

    protected static function pocket99VsBb(): array
    {
        return self::base(['9c','9d'], 'BB', 'CALL',
            '99 es defensa fuerte IP. Call es estable; 4Bet mezcla baja.',
            'GTO simplificado: FOLD 2%, CALL 84%, 4BET 14%.',
            self::grades('CALL', 2, 84, 14, ['FOLD'=>5,'CALL'=>100,'4BET'=>70], [
                'FOLD'=>'Blunder. Mano demasiado fuerte.',
                'CALL'=>'Correcto. Defensa clara.',
                '4BET'=>'Aceptable a baja frecuencia.',
            ])
        );
    }

    protected static function qtsVsBb(): array
    {
        return self::base(['Qc','Tc'], 'BB', 'CALL',
            'QTs suited defiende bien IP contra BB 3Bet.',
            'GTO simplificado: FOLD 16%, CALL 76%, 4BET 8%.',
            self::grades('CALL', 16, 76, 8, ['FOLD'=>35,'CALL'=>100,'4BET'=>45], [
                'FOLD'=>'Algo tight.',
                'CALL'=>'Correcto. Buena jugabilidad.',
                '4BET'=>'No es principal.',
            ])
        );
    }

    protected static function j8sVsBb(): array
    {
        return self::base(['Jh','8h'], 'BB', 'FOLD',
            'J8s está cerca del borde inferior y puede foldearse contra size 10 BB.',
            'GTO simplificado: FOLD 56%, CALL 40%, 4BET 4%.',
            self::grades('FOLD', 56, 40, 4, ['FOLD'=>100,'CALL'=>78,'4BET'=>20], [
                'FOLD'=>'Correcto. Fold de baja varianza y sólido.',
                'CALL'=>'Aceptable como mezcla, pero no obligatorio.',
                '4BET'=>'Demasiado ambicioso.',
            ])
        );
    }

    protected static function atoVsBb(): array
    {
        return self::base(['Ah','Td'], 'BB', 'FOLD',
            'ATo offsuit sufre dominación y juega peor que suited Ax.',
            'GTO simplificado: FOLD 58%, CALL 34%, 4BET 8%.',
            self::grades('FOLD', 58, 34, 8, ['FOLD'=>100,'CALL'=>72,'4BET'=>32], [
                'FOLD'=>'Correcto como estrategia base.',
                'CALL'=>'Puede existir contra rangos muy amplios, pero es delicado.',
                '4BET'=>'Mal candidato como estándar.',
            ])
        );
    }

    protected static function pocket33VsBb(): array
    {
        return self::base(['3c','3d'], 'BB', 'CALL',
            '33 puede pagar IP por precio y set value, aunque no imprime muchísimo EV.',
            'GTO simplificado: FOLD 34%, CALL 64%, 4BET 2%.',
            self::grades('CALL', 34, 64, 2, ['FOLD'=>72,'CALL'=>100,'4BET'=>10], [
                'FOLD'=>'Conservador, pero no grave.',
                'CALL'=>'Correcto. Set value suficiente IP.',
                '4BET'=>'Mala idea: sin blockers.',
            ])
        );
    }

    protected static function kjoVsBb(): array
    {
        return self::base(['Kh','Jd'], 'BB', 'FOLD',
            'KJo offsuit está dominada con frecuencia y realiza peor que KJs/KQo.',
            'GTO simplificado: FOLD 52%, CALL 42%, 4BET 6%.',
            self::grades('FOLD', 52, 42, 6, ['FOLD'=>100,'CALL'=>78,'4BET'=>25], [
                'FOLD'=>'Correcto como base sólida.',
                'CALL'=>'Aceptable contra rangos muy amplios, pero delicado.',
                '4BET'=>'No es buen bluff principal.',
            ])
        );
    }

    protected static function t9sVsBb(): array
    {
        return self::base(['Ts','9s'], 'BB', 'CALL',
            'T9s suited es defensa muy jugable IP contra BB 3Bet.',
            'GTO simplificado: FOLD 12%, CALL 80%, 4BET 8%.',
            self::grades('CALL', 12, 80, 8, ['FOLD'=>30,'CALL'=>100,'4BET'=>45], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Muy buena jugabilidad.',
                '4BET'=>'Mezcla baja, no línea principal.',
            ])
        );
    }
}