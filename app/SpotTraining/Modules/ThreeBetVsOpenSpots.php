<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class ThreeBetVsOpenSpots
{
    use BuildsSpotPlayers;

    public static function all(): array
    {
        return [
            self::sbVsCoA5s(),
            self::sbVsBtnAJo(),
            self::btnVsCoAQo(),
            self::bbVsBtnA5s(),
            self::sbVsCoKQo(),
            self::btnVsHjJTs(),
        ];
    }

    protected static function base(
        string $title,
        string $heroPosition,
        array $heroCards,
        string $villainPosition,
        array $actions,
        string $correctAction,
        string $explanation,
        string $solverNote,
        array $actionGrades
    ): array {
        return [
            'module' => 'threebet_vs_open',
            'module_label' => '3Bet vs Open',
            'title' => $title,
            'hero_position' => $heroPosition,
            'hero_cards' => $heroCards,
            'villain_position' => $villainPosition,
            'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
            'pot_bb' => 4,
            'actions' => $actions,
            'options' => ['FOLD', 'CALL', '3BET'],
            'correct_action' => $correctAction,
            'explanation' => $explanation,
            'solver_note' => $solverNote,
            'action_grades' => $actionGrades,
            'table_players' => self::defaultPlayers($heroPosition, $villainPosition),
        ];
    }

    protected static function sbVsCoA5s(): array
    {
        return self::base(
            '3Bet desde SB contra open CO',
            'SB',
            ['Ah', '5h'],
            'CO',
            ['UTG folds', 'HJ folds', 'CO raises 2.5 BB', 'BTN folds', 'Action on Hero SB'],
            '3BET',
            'A5s es excelente 3Bet bluff desde SB contra CO. Bloquea Ax fuertes, tiene equity y juega mejor como raise/fold que pagando fuera de posición.',
            'GTO simplificado: 3BET 74%, CALL 8%, FOLD 18%.',
            [
                '3BET' => ['grade' => 'best', 'frequency' => 74, 'ev_score' => 100, 'feedback' => 'Correcto. A5s es candidato clásico de 3Bet bluff por blockers y equity.'],
                'CALL' => ['grade' => 'marginal', 'frequency' => 8, 'ev_score' => 48, 'feedback' => 'Pagar desde SB es inferior: juegas OOP y permites a BB entrar.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 35, 'feedback' => 'Demasiado tight como estándar. A5s tiene buen valor estratégico.'],
            ]
        );
    }

    protected static function sbVsBtnAJo(): array
    {
        return self::base(
            'SB enfrenta open BTN',
            'SB',
            ['Ah', 'Jd'],
            'BTN',
            ['UTG folds', 'HJ folds', 'CO folds', 'BTN raises 2.5 BB', 'Action on Hero SB'],
            '3BET',
            'AJo en SB contra BTN open suele preferir 3Bet por valor/protección. Pagar OOP es problemático y permite a BB realizar equity.',
            'GTO simplificado: 3BET 82%, CALL 6%, FOLD 12%.',
            [
                '3BET' => ['grade' => 'best', 'frequency' => 82, 'ev_score' => 100, 'feedback' => 'Correcto. AJo domina parte del rango de BTN y gana mucho con fold equity.'],
                'CALL' => ['grade' => 'marginal', 'frequency' => 6, 'ev_score' => 45, 'feedback' => 'No es línea principal. En SB evitamos pagar demasiado.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 28, 'feedback' => 'Demasiado tight. Contra BTN, AJo es demasiado fuerte para foldear.'],
            ]
        );
    }

    protected static function btnVsCoAQo(): array
    {
        return self::base(
            'BTN enfrenta open CO',
            'BTN',
            ['Ad', 'Qc'],
            'CO',
            ['UTG folds', 'HJ folds', 'CO raises 2.5 BB', 'Action on Hero BTN'],
            '3BET',
            'AQo en BTN contra CO es una 3Bet muy rentable por valor y protección. Pagar también existe, pero 3Bet captura mucho EV.',
            'GTO simplificado: 3BET 68%, CALL 30%, FOLD 2%.',
            [
                '3BET' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 100, 'feedback' => 'Correcto. AQo domina muchas manos de CO y se beneficia del aislamiento.'],
                'CALL' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 84, 'feedback' => 'Aceptable como mezcla. En posición, call también realiza bien equity.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 5, 'feedback' => 'Error grave. AQo es demasiado fuerte para foldear BTN vs CO.'],
            ]
        );
    }

    protected static function bbVsBtnA5s(): array
    {
        return self::base(
            'BB enfrenta open BTN',
            'BB',
            ['As', '5s'],
            'BTN',
            ['UTG folds', 'HJ folds', 'CO folds', 'BTN raises 2.5 BB', 'SB folds', 'Action on Hero BB'],
            '3BET',
            'A5s en BB contra BTN puede pagar o 3betear, pero como entrenamiento base es excelente 3Bet bluff por blocker al As y jugabilidad suited.',
            'GTO simplificado: 3BET 46%, CALL 46%, FOLD 8%.',
            [
                '3BET' => ['grade' => 'best', 'frequency' => 46, 'ev_score' => 100, 'feedback' => 'Correcto. A5s tiene blocker fuerte y buena equity cuando recibe call.'],
                'CALL' => ['grade' => 'good', 'frequency' => 46, 'ev_score' => 92, 'feedback' => 'También es buena línea. A5s defiende muy bien pagando por precio.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 22, 'feedback' => 'Demasiado tight. A5s pertenece claramente a la defensa BB vs BTN.'],
            ]
        );
    }

    protected static function sbVsCoKQo(): array
    {
        return self::base(
            'SB enfrenta open CO',
            'SB',
            ['Kh', 'Qd'],
            'CO',
            ['UTG folds', 'HJ folds', 'CO raises 2.5 BB', 'BTN folds', 'Action on Hero SB'],
            '3BET',
            'KQo en SB contra CO suele preferir 3Bet antes que call. Tiene blockers y buena fuerza relativa, pero juega mal multiway/OOP si solo paga.',
            'GTO simplificado: 3BET 62%, FOLD 30%, CALL 8%.',
            [
                '3BET' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 100, 'feedback' => 'Correcto. KQo funciona bien como 3Bet lineal desde SB.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 68, 'feedback' => 'Puede existir contra CO tight, pero como base es conservador.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 30, 'feedback' => 'Pagar SB OOP es la peor línea de las tres en este spot.'],
            ]
        );
    }

    protected static function btnVsHjJTs(): array
    {
        return self::base(
            'BTN enfrenta open HJ',
            'BTN',
            ['Jh', 'Th'],
            'HJ',
            ['UTG folds', 'HJ raises 2.5 BB', 'CO folds', 'Action on Hero BTN'],
            'CALL',
            'JTs en BTN contra HJ open realiza muy bien equity en posición. Puede mezclarse como 3Bet, pero call es la línea principal.',
            'GTO simplificado: CALL 64%, 3BET 28%, FOLD 8%.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 100, 'feedback' => 'Correcto. JTs juega muy bien IP y no necesita convertirse siempre en 3Bet.'],
                '3BET' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 86, 'feedback' => 'Aceptable como mezcla, especialmente contra opens amplios.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 20, 'feedback' => 'Demasiado tight. JTs tiene demasiada jugabilidad en posición.'],
            ]
        );
    }
}