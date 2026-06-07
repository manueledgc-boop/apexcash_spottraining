<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class OpenRaiseSpots
{
    use BuildsSpotPlayers;

    public static function all(): array
    {
        return [
            self::utgAJo(),
            self::utgQ9s(),
            self::hjKJs(),
            self::coKQs(),
            self::btnJ8s(),
            self::sbA7s(),
        ];
    }

    protected static function base(
        string $title,
        string $heroPosition,
        array $heroCards,
        array $actions,
        string $correctAction,
        string $explanation,
        string $solverNote,
        array $actionGrades
    ): array {
        return [
            'module' => 'open_raise',
            'module_label' => 'Open Raise',
            'title' => $title,
            'hero_position' => $heroPosition,
            'hero_cards' => $heroCards,
            'villain_position' => null,
            'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
            'pot_bb' => 1.5,
            'actions' => $actions,
            'options' => ['FOLD', 'CALL', 'RAISE'],
            'correct_action' => $correctAction,
            'explanation' => $explanation,
            'solver_note' => $solverNote,
            'action_grades' => $actionGrades,
            'table_players' => self::defaultPlayers($heroPosition, null),
        ];
    }

    protected static function utgAJo(): array
    {
        return self::base(
            'Open raise desde UTG',
            'UTG',
            ['Ah', 'Jd'],
            ['Action on Hero UTG'],
            'RAISE',
            'AJo es una apertura estándar desde UTG en muchas estrategias 6-max modernas, aunque está cerca del borde inferior del rango.',
            'GTO simplificado: RAISE 88%, FOLD 12%, CALL 0%.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 88, 'ev_score' => 100, 'feedback' => 'Correcto. AJo puede abrirse UTG en 6-max sólido.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 12, 'ev_score' => 65, 'feedback' => 'Conservador, pero no horrible en mesas difíciles. Como base, abrir es mejor.'],
                'CALL' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Open limp no forma parte de una estrategia sólida.'],
            ]
        );
    }

    protected static function utgQ9s(): array
    {
        return self::base(
            'Open raise desde UTG',
            'UTG',
            ['Qd', '9d'],
            ['Action on Hero UTG'],
            'FOLD',
            'Q9s es demasiado loose UTG. Queda demasiada gente por hablar y la mano cae dominada con frecuencia.',
            'GTO simplificado: FOLD 96%, RAISE 4%, CALL 0%.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 96, 'ev_score' => 100, 'feedback' => 'Correcto. Q9s no pertenece al núcleo UTG sólido.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 4, 'ev_score' => 25, 'feedback' => 'Demasiado loose como estrategia base desde UTG.'],
                'CALL' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Open limp es un error grave en esta estrategia.'],
            ]
        );
    }

    protected static function hjKJs(): array
    {
        return self::base(
            'Open raise desde HJ',
            'HJ',
            ['Ks', 'Js'],
            ['UTG folds', 'Action on Hero HJ'],
            'RAISE',
            'KJs es open claro desde HJ: suited broadway fuerte, buena jugabilidad y blockers.',
            'GTO simplificado: RAISE 98%, FOLD 2%, CALL 0%.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 98, 'ev_score' => 100, 'feedback' => 'Correcto. KJs es apertura clara desde HJ.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 10, 'feedback' => 'Demasiado tight. Estás tirando una mano claramente rentable.'],
                'CALL' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'No limpeamos cuando la acción llega limpia.'],
            ]
        );
    }

    protected static function coKQs(): array
    {
        return self::base(
            'Open raise desde CO',
            'CO',
            ['Kh', 'Qh'],
            ['UTG folds', 'HJ folds', 'Action on Hero CO'],
            'RAISE',
            'KQs es open obligatorio desde CO: domina broadways peores, liga bien y juega bien postflop.',
            'GTO simplificado: RAISE 100%, FOLD 0%, CALL 0%.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 100, 'ev_score' => 100, 'feedback' => 'Correcto. KQs es apertura automática desde CO.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Error grave. Foldear KQs en CO pierde mucho EV.'],
                'CALL' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Open limp no existe como línea principal en cash 6-max moderno.'],
            ]
        );
    }

    protected static function btnJ8s(): array
    {
        return self::base(
            'Open raise desde BTN',
            'BTN',
            ['Jh', '8h'],
            ['UTG folds', 'HJ folds', 'CO folds', 'Action on Hero BTN'],
            'RAISE',
            'J8s es apertura rentable desde BTN. Tienes posición, fold equity y buena jugabilidad suited.',
            'GTO simplificado: RAISE 86%, FOLD 14%, CALL 0%.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 86, 'ev_score' => 100, 'feedback' => 'Correcto. BTN abre amplio y J8s entra en el rango.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 14, 'ev_score' => 58, 'feedback' => 'Demasiado tight como base, aunque no es el peor fold.'],
                'CALL' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Open limp desde BTN no forma parte de esta estrategia.'],
            ]
        );
    }

    protected static function sbA7s(): array
    {
        return self::base(
            'Open raise desde SB',
            'SB',
            ['Ac', '7c'],
            ['UTG folds', 'HJ folds', 'CO folds', 'BTN folds', 'Action on Hero SB'],
            'RAISE',
            'A7s es open claro desde SB. Aunque jugarás OOP, solo queda BB y tienes blocker + jugabilidad suited.',
            'GTO simplificado: RAISE 92%, FOLD 8%, CALL 0%.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 92, 'ev_score' => 100, 'feedback' => 'Correcto. A7s es raise desde SB contra BB.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 35, 'feedback' => 'Demasiado tight. La mano gana mucho abriendo contra BB.'],
                'CALL' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Completar SB no es la línea base aquí. Queremos raise/fold.'],
            ]
        );
    }
}