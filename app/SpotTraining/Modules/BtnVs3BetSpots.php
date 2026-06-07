<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class BtnVs3BetSpots
{
    use BuildsSpotPlayers;

    public static function all(): array
    {
        return [
            self::ajsVsSb(),
            self::a5sVsSb(),
            self::kqoVsSb(),
            self::pair77VsBb(),
            self::ktsVsBb(),
            self::qjoVsBb(),
        ];
    }

    protected static function base(
        string $title,
        array $heroCards,
        string $villainPosition,
        array $actions,
        string $correctAction,
        string $explanation,
        string $solverNote,
        array $actionGrades
    ): array {
        return [
            'module' => 'btn_vs_3bet',
            'module_label' => 'BTN vs 3Bet',
            'title' => $title,
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
            'action_grades' => $actionGrades,
            'table_players' => self::defaultPlayers('BTN', $villainPosition),
        ];
    }

    protected static function ajsVsSb(): array
    {
        return self::base(
            'BTN abre y SB hace 3Bet',
            ['As', 'Js'],
            'SB',
            ['UTG folds', 'HJ folds', 'CO folds', 'Hero BTN raises 2.5 BB', 'SB 3bets 10 BB', 'BB folds'],
            'CALL',
            'AJs es defensa clara en posición contra 3Bet de SB. La línea principal es pagar; 4Bet existe a baja frecuencia.',
            'GTO simplificado: CALL 74%, 4BET 22%, FOLD 4%.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 74, 'ev_score' => 100, 'feedback' => 'Correcto. AJs realiza muy bien equity en posición.'],
                '4BET' => ['grade' => 'good', 'frequency' => 22, 'ev_score' => 82, 'feedback' => 'Aceptable como mezcla, pero no debe ser automático.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 5, 'feedback' => 'Error grave. Foldear AJs aquí es demasiado tight.'],
            ]
        );
    }

    protected static function a5sVsSb(): array
    {
        return self::base(
            'BTN abre y SB hace 3Bet',
            ['Ah', '5h'],
            'SB',
            ['UTG folds', 'HJ folds', 'CO folds', 'Hero BTN raises 2.5 BB', 'SB 3bets 10 BB', 'BB folds'],
            '4BET',
            'A5s es uno de los mejores 4Bet bluffs: bloquea Ax fuertes y conserva equity si recibe call.',
            'GTO simplificado: 4BET 58%, CALL 30%, FOLD 12%.',
            [
                '4BET' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 100, 'feedback' => 'Correcto. A5s es candidato natural de 4Bet bluff.'],
                'CALL' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 65, 'feedback' => 'Puede mezclarse, pero suele rendir mejor como 4Bet bluff.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 25, 'feedback' => 'Demasiado tight. Tiene blockers y equity suficiente.'],
            ]
        );
    }

    protected static function kqoVsSb(): array
    {
        return self::base(
            'BTN abre y SB hace 3Bet',
            ['Kh', 'Qo'],
            'SB',
            ['UTG folds', 'HJ folds', 'CO folds', 'Hero BTN raises 2.5 BB', 'SB 3bets 10 BB', 'BB folds'],
            'CALL',
            'KQo puede defenderse IP contra SB, pero no quiere construir un bote enorme como 4Bet estándar.',
            'GTO simplificado: CALL 62%, FOLD 28%, 4BET 10%.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 100, 'feedback' => 'Correcto. KQo defiende razonablemente IP.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 58, 'feedback' => 'Puede existir contra un 3bettor muy tight, pero es conservador.'],
                '4BET' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 35, 'feedback' => 'No es buen 4Bet bluff principal: suele estar dominada si continúa la acción.'],
            ]
        );
    }

    protected static function pair77VsBb(): array
    {
        return self::base(
            'BTN abre y BB hace 3Bet',
            ['7c', '7d'],
            'BB',
            ['UTG folds', 'HJ folds', 'CO folds', 'Hero BTN raises 2.5 BB', 'SB folds', 'BB 3bets 10 BB'],
            'CALL',
            '77 puede pagar IP contra BB 3Bet con 100 BB: tiene showdown value y set value.',
            'GTO simplificado: CALL 72%, FOLD 25%, 4BET 3%.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 100, 'feedback' => 'Correcto. Pagar mantiene manos peores y realiza equity IP.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 25, 'ev_score' => 60, 'feedback' => 'Aceptable contra rival muy nit, pero estándar es pagar.'],
                '4BET' => ['grade' => 'mistake', 'frequency' => 3, 'ev_score' => 15, 'feedback' => 'Mal candidato a 4Bet: no bloquea premiums y sufre contra jam.'],
            ]
        );
    }

    protected static function ktsVsBb(): array
    {
        return self::base(
            'BTN abre y BB hace 3Bet',
            ['Ks', 'Ts'],
            'BB',
            ['UTG folds', 'HJ folds', 'CO folds', 'Hero BTN raises 2.5 BB', 'SB folds', 'BB 3bets 10 BB'],
            'CALL',
            'KTs suited defiende bien IP por jugabilidad, blockers y proyectos fuertes.',
            'GTO simplificado: CALL 78%, 4BET 14%, FOLD 8%.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 100, 'feedback' => 'Correcto. KTs suited realiza bien equity IP.'],
                '4BET' => ['grade' => 'marginal', 'frequency' => 14, 'ev_score' => 67, 'feedback' => 'Puede mezclarse, pero no es principal.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 25, 'feedback' => 'Demasiado tight. KTs suited defiende claramente.'],
            ]
        );
    }

    protected static function qjoVsBb(): array
    {
        return self::base(
            'BTN abre y BB hace 3Bet',
            ['Qh', 'Jo'],
            'BB',
            ['UTG folds', 'HJ folds', 'CO folds', 'Hero BTN raises 2.5 BB', 'SB folds', 'BB 3bets 10 BB'],
            'FOLD',
            'QJo offsuit realiza mal equity en 3Bet pot y suele estar dominada.',
            'GTO simplificado: FOLD 78%, CALL 20%, 4BET 2%.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 100, 'feedback' => 'Correcto. QJo offsuit es fold estándar.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 35, 'feedback' => 'Demasiado loose como estándar; genera spots dominados.'],
                '4BET' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 5, 'feedback' => 'Error grave. No tiene buenos blockers ni jugabilidad para 4Bet bluff.'],
            ]
        );
    }
}