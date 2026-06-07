<?php

namespace App\Services;

use App\SpotTraining\SpotRepository;

class SpotTrainingService
{
    public function __construct(
        protected SpotRepository $spots
    ) {
    }

    public function nextSpot(?string $module = null): array
    {
        $spots = $module
            ? $this->spots->byModule($module)
            : $this->spots->all();

        if (empty($spots)) {
            $spots = $this->spots->all();
        }

        $spot = $spots[array_rand($spots)];
        $spot['spot_id'] = uniqid('spot_', true);

        session(['spot_training.current_spot' => $spot]);

        return $this->publicSpot($spot);
    }

    public function currentSpot(): ?array
    {
        $spot = session('spot_training.current_spot');

        return is_array($spot) ? $this->publicSpot($spot) : null;
    }

    public function evaluateAnswer(string $answer): array
    {
        $spot = session('spot_training.current_spot');

        if (! is_array($spot)) {
            return [
                'success' => false,
                'code' => 'NO_ACTIVE_SPOT',
                'message' => 'No hay spot activo. Genera un nuevo spot.',
            ];
        }

        $answer = strtoupper(trim($answer));
        $correctAction = strtoupper($spot['correct_action']);

        $actionGrades = $spot['action_grades'] ?? [];
        $grade = $actionGrades[$answer]['grade'] ?? 'mistake';

        $isCorrect = in_array($grade, ['best', 'good'], true);

        session()->push('spot_training.results', [
            'spot_id' => $spot['spot_id'] ?? null,
            'module' => $spot['module'],
            'selected_action' => $answer,
            'correct_action' => $correctAction,
            'grade' => $grade,
            'correct' => $isCorrect,
            'created_at' => now()->toDateTimeString(),
        ]);

        return [
            'success' => true,
            'correct' => $isCorrect,
            'grade' => $grade,
            'selected_action' => $answer,
            'correct_action' => $correctAction,
            'title' => $this->titleForGrade($grade),
            'explanation' => $actionGrades[$answer]['feedback'] ?? $spot['explanation'],
            'main_explanation' => $spot['explanation'],
            'solver_note' => $spot['solver_note'] ?? null,
            'frequency' => $actionGrades[$answer]['frequency'] ?? null,
            'ev_score' => $actionGrades[$answer]['ev_score'] ?? 0,
            'spot' => $this->publicSpot($spot),
            'summary' => $this->summary(),
            'leaks' => $this->leakSummary(),
        ];
    }

    public function summary(): array
    {
        $results = session('spot_training.results', []);
        $total = count($results);
        $correct = count(array_filter($results, fn ($result) => (bool) ($result['correct'] ?? false)));

        return [
            'total' => $total,
            'correct' => $correct,
            'wrong' => max(0, $total - $correct),
            'accuracy' => $total > 0 ? round(($correct / $total) * 100, 1) : 0,
        ];
    }

    public function leakSummary(): array
    {
        $results = session('spot_training.results', []);

        if (empty($results)) {
            return [];
        }

        $modules = [];

        foreach ($results as $result) {
            $module = $result['module'] ?? 'unknown';

            if (! isset($modules[$module])) {
                $modules[$module] = [
                    'module' => $module,
                    'module_label' => $this->moduleLabel($module),
                    'total' => 0,
                    'correct' => 0,
                    'best' => 0,
                    'good' => 0,
                    'marginal' => 0,
                    'mistake' => 0,
                    'blunder' => 0,
                    'accuracy' => 0,
                ];
            }

            $grade = $result['grade'] ?? 'mistake';

            $modules[$module]['total']++;

            if (! empty($result['correct'])) {
                $modules[$module]['correct']++;
            }

            if (isset($modules[$module][$grade])) {
                $modules[$module][$grade]++;
            }
        }

        foreach ($modules as &$module) {
            $module['accuracy'] = $module['total'] > 0
                ? round(($module['correct'] / $module['total']) * 100, 1)
                : 0;
        }

        unset($module);

        usort($modules, fn ($a, $b) => $a['accuracy'] <=> $b['accuracy']);

        return array_values($modules);
    }

    public function reset(): void
    {
        session()->forget('spot_training');
    }

    protected function titleForGrade(string $grade): string
    {
        return match ($grade) {
            'best' => 'Correcto: mejor acción',
            'good' => 'Aceptable: línea buena',
            'marginal' => 'Marginal: pequeña pérdida de EV',
            'mistake' => 'Error claro',
            'blunder' => 'Blunder: error grave',
            default => 'Resultado',
        };
    }

    protected function publicSpot(array $spot): array
    {
        return [
            'spot_id' => $spot['spot_id'] ?? null,
            'module' => $spot['module'],
            'module_label' => $spot['module_label'],
            'title' => $spot['title'],
            'hero_position' => $spot['hero_position'],
            'hero_cards' => $spot['hero_cards'],
            'villain_position' => $spot['villain_position'],
            'stacks' => $spot['stacks'],
            'pot_bb' => $spot['pot_bb'],
            'actions' => $spot['actions'],
            'options' => $spot['options'],
            'table_players' => $spot['table_players'],
            'difficulty' => $spot['difficulty'] ?? 'GTO simplificado',
        ];
    }

    protected function moduleLabel(string $module): string
    {
        return match ($module) {
            'btn_vs_3bet' => 'BTN vs 3Bet',
            'open_raise' => 'Open Raise',
            'bb_vs_btn' => 'BB vs BTN',
            'threebet_vs_open' => '3Bet vs Open',
            default => $module,
        };
    }
}