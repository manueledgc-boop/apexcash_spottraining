<?php

namespace App\Services;

class SpotTrainingService
{
    /**
     * Spot Training V1 is intentionally stateless at database level.
     * Current spot is stored only in Laravel session.
     */
    public function nextSpot(?string $module = null): array
    {
        $spots = $this->spots();

        if ($module) {
            $filtered = array_values(array_filter(
                $spots,
                fn (array $spot) => $spot['module'] === $module
            ));

            if (! empty($filtered)) {
                $spots = $filtered;
            }
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
        $isCorrect = $answer === $correctAction;

        $result = [
            'success' => true,
            'correct' => $isCorrect,
            'selected_action' => $answer,
            'correct_action' => $correctAction,
            'title' => $isCorrect ? 'Correcto' : 'Incorrecto',
            'explanation' => $spot['explanation'],
            'spot' => $this->publicSpot($spot),
        ];

        session()->push('spot_training.results', [
            'spot_id' => $spot['spot_id'] ?? null,
            'module' => $spot['module'],
            'selected_action' => $answer,
            'correct_action' => $correctAction,
            'correct' => $isCorrect,
            'created_at' => now()->toDateTimeString(),
        ]);

        return $result;
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

    public function reset(): void
    {
        session()->forget('spot_training');
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
        ];
    }

    protected function spots(): array
    {
        return [
            [
                'module' => 'btn_vs_3bet',
                'module_label' => 'BTN vs 3Bet',
                'title' => 'BTN abre y SB hace 3Bet',
                'hero_position' => 'BTN',
                'hero_cards' => ['As', 'Js'],
                'villain_position' => 'SB',
                'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
                'pot_bb' => 13.5,
                'actions' => [
                    'UTG folds',
                    'HJ folds',
                    'CO folds',
                    'Hero BTN raises 2.5 BB',
                    'SB 3bets 10 BB',
                    'BB folds',
                ],
                'options' => ['FOLD', 'CALL', '4BET'],
                'correct_action' => 'CALL',
                'explanation' => 'AJs en BTN contra 3Bet de SB tiene buena jugabilidad en posición, bloquea Ax fuertes y domina parte de los bluffs. Foldear es demasiado tight y 4betear siempre sería sobreactuar la mano.',
                'table_players' => $this->defaultPlayers('BTN', 'SB'),
            ],
            [
                'module' => 'btn_vs_3bet',
                'module_label' => 'BTN vs 3Bet',
                'title' => 'BTN abre y BB hace 3Bet',
                'hero_position' => 'BTN',
                'hero_cards' => ['7c', '7d'],
                'villain_position' => 'BB',
                'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
                'pot_bb' => 13.5,
                'actions' => [
                    'UTG folds',
                    'HJ folds',
                    'CO folds',
                    'Hero BTN raises 2.5 BB',
                    'SB folds',
                    'BB 3bets 10 BB',
                ],
                'options' => ['FOLD', 'CALL', '4BET'],
                'correct_action' => 'CALL',
                'explanation' => '77 puede pagar en posición contra una 3Bet estándar con 100 BB efectivos, especialmente contra rangos de BB que contienen bluffs. No es una 4Bet estándar y foldear pierde demasiado valor realizable.',
                'table_players' => $this->defaultPlayers('BTN', 'BB'),
            ],
            [
                'module' => 'open_raise',
                'module_label' => 'Open Raise',
                'title' => 'Open raise desde CO',
                'hero_position' => 'CO',
                'hero_cards' => ['Kh', 'Qh'],
                'villain_position' => null,
                'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
                'pot_bb' => 1.5,
                'actions' => [
                    'UTG folds',
                    'HJ folds',
                    'Action on Hero CO',
                ],
                'options' => ['FOLD', 'CALL', 'RAISE'],
                'correct_action' => 'RAISE',
                'explanation' => 'KQs es un open claro desde CO. Tiene blockers, jugabilidad postflop y domina muchas manos peores. Limpear/call no existe como estrategia principal en cash 6-max moderno.',
                'table_players' => $this->defaultPlayers('CO', null),
            ],
            [
                'module' => 'open_raise',
                'module_label' => 'Open Raise',
                'title' => 'Open raise desde UTG',
                'hero_position' => 'UTG',
                'hero_cards' => ['Qd', '9d'],
                'villain_position' => null,
                'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
                'pot_bb' => 1.5,
                'actions' => [
                    'Action on Hero UTG',
                ],
                'options' => ['FOLD', 'CALL', 'RAISE'],
                'correct_action' => 'FOLD',
                'explanation' => 'Q9s es demasiado loose para abrir UTG en una estrategia sólida 6-max. Desde posiciones tempranas se necesita un rango más estricto para evitar jugar manos dominadas fuera de posición.',
                'table_players' => $this->defaultPlayers('UTG', null),
            ],
            [
                'module' => 'bb_vs_btn',
                'module_label' => 'BB vs BTN',
                'title' => 'Defensa BB contra open BTN',
                'hero_position' => 'BB',
                'hero_cards' => ['Tc', '9c'],
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
                'correct_action' => 'CALL',
                'explanation' => 'T9s defiende muy bien en BB contra BTN por pot odds y jugabilidad. Puede 3betearse a baja frecuencia, pero el call es la línea estándar y rentable.',
                'table_players' => $this->defaultPlayers('BB', 'BTN'),
            ],
            [
                'module' => 'threebet_vs_open',
                'module_label' => '3Bet vs Open',
                'title' => '3Bet desde SB contra open CO',
                'hero_position' => 'SB',
                'hero_cards' => ['Ah', '5h'],
                'villain_position' => 'CO',
                'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
                'pot_bb' => 4,
                'actions' => [
                    'UTG folds',
                    'HJ folds',
                    'CO raises 2.5 BB',
                    'BTN folds',
                    'Action on Hero SB',
                ],
                'options' => ['FOLD', 'CALL', '3BET'],
                'correct_action' => '3BET',
                'explanation' => 'A5s es una 3Bet bluff muy buena desde SB contra CO: bloquea Ax fuertes, tiene equity cuando paga y juega mejor como raise/fold que como call fuera de posición.',
                'table_players' => $this->defaultPlayers('SB', 'CO'),
            ],
        ];
    }

    protected function defaultPlayers(string $heroPosition, ?string $villainPosition): array
    {
        $positions = ['UTG', 'HJ', 'CO', 'BTN', 'SB', 'BB'];
        $players = [];

        foreach ($positions as $position) {
            $players[] = [
                'position' => $position,
                'name' => $position === $heroPosition ? 'Hero' : $this->botNameForPosition($position),
                'is_hero' => $position === $heroPosition,
                'is_villain' => $villainPosition !== null && $position === $villainPosition,
                'stack_bb' => 100,
            ];
        }

        return $players;
    }

    protected function botNameForPosition(string $position): string
    {
        return match ($position) {
            'UTG' => 'MadridReg',
            'HJ' => 'BilbaoTAG',
            'CO' => 'ValenciaPro',
            'BTN' => 'RiverKing',
            'SB' => 'SevillaNit',
            'BB' => 'BoardHunter',
            default => 'Villain',
        };
    }
}
