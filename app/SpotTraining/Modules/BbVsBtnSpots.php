<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class BbVsBtnSpots
{
    use BuildsSpotPlayers;

    public static function all(): array
    {
        return [
            self::t9s(),
            self::kto(),
            self::a2s(),
            self::q7o(),
            self::pocket44(),
            self::j5s(),
        ];
    }

    protected static function base(
        array $heroCards,
        string $correctAction,
        string $explanation,
        string $solverNote,
        array $actionGrades
    ): array {
        return [
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
            'action_grades' => $actionGrades,
            'table_players' => self::defaultPlayers('BB', 'BTN'),
        ];
    }

    protected static function t9s(): array
    {
        return self::base(
            ['Tc', '9c'],
            'CALL',
            'T9s defiende muy bien en BB contra BTN por pot odds y jugabilidad. Puede mezclarse como 3Bet, pero call es la línea principal.',
            'GTO simplificado: CALL 76%, 3BET 18%, FOLD 6%.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 100, 'feedback' => 'Correcto. T9s realiza equity muy bien y conecta muchos boards.'],
                '3BET' => ['grade' => 'good', 'frequency' => 18, 'ev_score' => 82, 'feedback' => 'Aceptable como mezcla, pero no conviertas todos tus suited connectors en 3Bet.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 20, 'feedback' => 'Demasiado tight. BB tiene buen precio y T9s defiende claramente.'],
            ]
        );
    }

    protected static function kto(): array
    {
        return self::base(
            ['Kd', 'To'],
            'CALL',
            'KTo contra BTN open suele defenderse en BB por precio y fuerza relativa, aunque juega peor que KTs. Es más call que 3Bet estándar.',
            'GTO simplificado: CALL 68%, FOLD 24%, 3BET 8%.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 100, 'feedback' => 'Correcto. KTo tiene suficiente equity para defender BB vs BTN.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 62, 'feedback' => 'Puede existir contra open grande o rival tight, pero como base es conservador.'],
                '3BET' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 35, 'feedback' => 'No es buen 3Bet estándar: puede quedar dominada por mejores Kx y broadways.'],
            ]
        );
    }

    protected static function a2s(): array
    {
        return self::base(
            ['As', '2s'],
            'CALL',
            'A2s defiende bien en BB contra BTN. Tiene blocker, equity suited y puede ligar proyectos fuertes. 3Bet también puede mezclarse.',
            'GTO simplificado: CALL 58%, 3BET 32%, FOLD 10%.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 100, 'feedback' => 'Correcto. A2s realiza bien equity y tiene jugabilidad suited.'],
                '3BET' => ['grade' => 'good', 'frequency' => 32, 'ev_score' => 88, 'feedback' => 'Buena mezcla como 3Bet bluff por blocker al As.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 25, 'feedback' => 'Demasiado tight. A2s es demasiado jugable para foldear siempre.'],
            ]
        );
    }

    protected static function q7o(): array
    {
        return self::base(
            ['Qh', '7d'],
            'FOLD',
            'Q7o offsuit realiza mal equity, queda dominada a menudo y no tiene suficiente jugabilidad para defender contra 2.5x como estándar.',
            'GTO simplificado: FOLD 82%, CALL 18%, 3BET 0%.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 82, 'ev_score' => 100, 'feedback' => 'Correcto. Q7o es fold estándar BB vs BTN.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 35, 'feedback' => 'Demasiado loose como base. La mano realiza mal equity.'],
                '3BET' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Error grave. No tiene blockers ni jugabilidad para 3Bet bluff.'],
            ]
        );
    }

    protected static function pocket44(): array
    {
        return self::base(
            ['4c', '4d'],
            'CALL',
            '44 defiende en BB contra BTN por precio, valor de showdown y posibilidad de set. No es un 3Bet estándar.',
            'GTO simplificado: CALL 86%, FOLD 12%, 3BET 2%.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 86, 'ev_score' => 100, 'feedback' => 'Correcto. 44 tiene suficiente valor para defender pagando.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 12, 'ev_score' => 60, 'feedback' => 'Conservador. Puede existir contra size grande, pero estándar es call.'],
                '3BET' => ['grade' => 'mistake', 'frequency' => 2, 'ev_score' => 18, 'feedback' => 'No es buen 3Bet: no bloquea premiums y sufre contra 4Bet.'],
            ]
        );
    }

    protected static function j5s(): array
    {
        return self::base(
            ['Js', '5s'],
            'CALL',
            'J5s puede defenderse contra BTN 2.5x por precio y jugabilidad suited. Está cerca del borde, pero call es aceptable.',
            'GTO simplificado: CALL 54%, FOLD 42%, 3BET 4%.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 54, 'ev_score' => 100, 'feedback' => 'Correcto. Es una defensa de borde, pero el precio permite call.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 42, 'ev_score' => 74, 'feedback' => 'No es grave. Es una mano cercana al límite inferior de defensa.'],
                '3BET' => ['grade' => 'mistake', 'frequency' => 4, 'ev_score' => 25, 'feedback' => 'No es el mejor 3Bet bluff; hay mejores blockers y mejores suited hands.'],
            ]
        );
    }
}