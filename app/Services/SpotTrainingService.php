<?php

namespace App\Services;

use App\Models\TrainingResult;
use App\Models\TrainingSession;
use App\Models\UserLeak;
use App\Models\UserTrainingStat;
use App\SpotTraining\SpotRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSpotStat;

class SpotTrainingService
{
    public function __construct(
        protected SpotRepository $spots,
        protected TrainingRecommendationService $recommendations
    ) {
    }

    public function nextSpot(?string $module = null, string $mode = 'normal', string $profile = 'gto', ?string $spotId = null): array
    {
        if ($spotId) {
            $spot = $this->spots->findById($spotId);

            if ($spot) {
                $spot = $this->spots->normalize($spot);
                $spot['training_profile'] = $this->resolveTrainingProfile($profile);
                $spot['spot_id'] = $spot['id'];

                session(['spot_training.current_spot' => $spot]);

                return $this->publicSpot($spot);
            }
        }
        $spot = $this->recommendations->nextSpot($module, $mode);
        $spot = $this->spots->normalize($spot);
        $spot['training_profile'] = $this->resolveTrainingProfile($profile);
        $spot['spot_id'] = $spot['id'];

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
        $profile = $this->resolveTrainingProfile((string) ($spot['training_profile'] ?? 'gto'));
        $profileAnswer = $this->answerProfile($spot, $profile);
        $correctAction = strtoupper($profileAnswer['correct_action']);

        $actionGrades = $profileAnswer['action_grades'] ?? [];
        $grade = $actionGrades[$answer]['grade'] ?? 'mistake';
        $isCorrect = in_array($grade, ['best', 'good'], true);
        $frequency = $actionGrades[$answer]['frequency'] ?? null;
        $evScore = (int) ($actionGrades[$answer]['ev_score'] ?? 0);
        $explanation = $actionGrades[$answer]['feedback'] ?? ($profileAnswer['explanation'] ?? $spot['explanation']);
        $xpEarned = $this->xpForGrade($grade);

        $sessionResult = [
            'spot_id' => $spot['id'] ?? $spot['spot_id'] ?? null,
            'module' => $spot['module'],
            'module_label' => $spot['module_label'],
            'training_profile' => $profile,
            'selected_action' => $answer,
            'correct_action' => $correctAction,
            'grade' => $grade,
            'correct' => $isCorrect,
            'xp_earned' => $xpEarned,
            'created_at' => now()->toDateTimeString(),
        ];

        session()->push('spot_training.results', $sessionResult);

        $this->persistResult($spot, $answer, $correctAction, $grade, $isCorrect, $frequency, $evScore, $xpEarned, $explanation);

        return [
            'success' => true,
            'correct' => $isCorrect,
            'grade' => $grade,
            'selected_action' => $answer,
            'correct_action' => $correctAction,
            'title' => $this->titleForGrade($grade),
            'explanation' => $explanation,
            'main_explanation' => $profileAnswer['explanation'] ?? $spot['explanation'],
            'solver_note' => $profileAnswer['solver_note'] ?? $spot['solver_note'] ?? null,
            'frequency' => $frequency,
            'ev_score' => $evScore,
            'xp_earned' => $xpEarned,
            'spot' => $this->publicSpot($spot),
            'summary' => $this->summary(),
            'leaks' => $this->leakSummary(),
            'lifetime' => $this->lifetimeSummary(),
        ];
    }

    public function summary(): array
    {
        $results = session('spot_training.results', []);
        $total = count($results);
        $correct = count(array_filter($results, fn ($result) => (bool) ($result['correct'] ?? false)));
        $xp = array_sum(array_map(fn ($result) => (int) ($result['xp_earned'] ?? 0), $results));

        return [
            'total' => $total,
            'correct' => $correct,
            'wrong' => max(0, $total - $correct),
            'accuracy' => $total > 0 ? round(($correct / $total) * 100, 1) : 0,
            'xp' => $xp,
        ];
    }

    public function lifetimeSummary(): array
    {
        $userId = Auth::id();

        if (! $userId) {
            return [
                'total' => 0,
                'correct' => 0,
                'wrong' => 0,
                'accuracy' => 0,
                'xp' => 0,
                'level' => 1,
            ];
        }

        $stat = UserTrainingStat::query()
            ->where('user_id', $userId)
            ->where('module', 'global')
            ->first();

        if (! $stat) {
            return [
                'total' => 0,
                'correct' => 0,
                'wrong' => 0,
                'accuracy' => 0,
                'xp' => 0,
                'level' => 1,
            ];
        }

        return [
            'total' => (int) $stat->total_spots,
            'correct' => (int) $stat->correct_spots,
            'wrong' => (int) $stat->wrong_spots,
            'accuracy' => (float) $stat->accuracy,
            'xp' => (int) $stat->xp,
            'level' => (int) $stat->level,
        ];
    }

    public function persistentLeaks(): array
    {
        $userId = Auth::id();

        if (! $userId) {
            return [];
        }

        return UserLeak::query()
            ->where('user_id', $userId)
            ->where('total', '>=', 1)
            ->orderByDesc('weakness_score')
            ->orderBy('accuracy')
            ->limit(6)
            ->get()
            ->map(fn (UserLeak $leak) => [
                'module' => $leak->module,
                'module_label' => $leak->module_label,
                'total' => (int) $leak->total,
                'correct' => (int) $leak->correct,
                'accuracy' => (float) $leak->accuracy,
                'mistake' => (int) $leak->mistakes,
                'blunder' => (int) $leak->blunders,
                'weakness_score' => (float) $leak->weakness_score,
            ])
            ->values()
            ->all();
    }

    public function leakSummary(): array
    {
        $results = session('spot_training.results', []);

        if (empty($results)) {
            return $this->persistentLeaks();
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
        $trainingSessionId = session('spot_training.training_session_id');

        if ($trainingSessionId) {
            TrainingSession::query()
                ->where('id', $trainingSessionId)
                ->where('user_id', Auth::id())
                ->update(['ended_at' => now()]);
        }

        session()->forget('spot_training');
    }

    protected function persistResult(array $spot, string $answer, string $correctAction, string $grade, bool $isCorrect, ?int $frequency, int $evScore, int $xpEarned, string $explanation): void
    {
        $userId = Auth::id();

        if (! $userId) {
            return;
        }

        $trainingSession = $this->currentTrainingSession($spot['module']);

        TrainingResult::create([
            'user_id' => $userId,
            'training_session_id' => $trainingSession->id,
            'spot_id' => $spot['id'] ?? $spot['spot_id'] ?? null,
            'module' => $spot['module'],
            'module_label' => $spot['module_label'],
            'title' => $spot['title'],
            'hero_position' => $spot['hero_position'] ?? null,
            'villain_position' => $spot['villain_position'] ?? null,
            'hero_cards' => $spot['hero_cards'] ?? [],
            'selected_action' => $answer,
            'correct_action' => $correctAction,
            'grade' => $grade,
            'is_correct' => $isCorrect,
            'frequency' => $frequency,
            'ev_score' => $evScore,
            'xp_earned' => $xpEarned,
            'explanation' => $explanation,
            'spot_snapshot' => array_merge($this->publicSpot($spot), [
                'answers' => $spot['answers'] ?? [],
                'confidence' => $spot['confidence'] ?? null,
                'training_profile' => $spot['training_profile'] ?? 'gto',
            ]),
        ]);

        $this->updateTrainingSession($trainingSession, $isCorrect, $xpEarned);
        $this->updateStat($userId, 'global', 'Global', $grade, $isCorrect, $xpEarned);
        $this->updateStat($userId, $spot['module'], $spot['module_label'], $grade, $isCorrect, $xpEarned);
        $this->updateLeak($userId, $spot['module'], $spot['module_label'], $grade, $isCorrect);
        $this->updateSpotStat($userId, $spot, $grade, $isCorrect);
    }

    protected function currentTrainingSession(?string $module): TrainingSession
    {
        $userId = Auth::id();
        $sessionId = session('spot_training.training_session_id');

        if ($sessionId) {
            $trainingSession = TrainingSession::query()
                ->where('id', $sessionId)
                ->where('user_id', $userId)
                ->first();

            if ($trainingSession) {
                return $trainingSession;
            }
        }

        $trainingSession = TrainingSession::create([
            'user_id' => $userId,
            'mode' => 'preflop',
            'module' => $module,
            'started_at' => now(),
        ]);

        session(['spot_training.training_session_id' => $trainingSession->id]);

        return $trainingSession;
    }

    protected function updateTrainingSession(TrainingSession $trainingSession, bool $isCorrect, int $xpEarned): void
    {
        $total = $trainingSession->total_spots + 1;
        $correct = $trainingSession->correct_spots + ($isCorrect ? 1 : 0);
        $wrong = $total - $correct;

        $trainingSession->update([
            'total_spots' => $total,
            'correct_spots' => $correct,
            'wrong_spots' => $wrong,
            'accuracy' => round(($correct / max(1, $total)) * 100, 2),
            'xp_earned' => $trainingSession->xp_earned + $xpEarned,
            'ended_at' => now(),
        ]);
    }

    protected function updateStat(int $userId, string $module, string $moduleLabel, string $grade, bool $isCorrect, int $xpEarned): void
    {
        $stat = UserTrainingStat::firstOrCreate(
            ['user_id' => $userId, 'module' => $module],
            ['module_label' => $moduleLabel]
        );

        $total = $stat->total_spots + 1;
        $correct = $stat->correct_spots + ($isCorrect ? 1 : 0);
        $wrong = $total - $correct;
        $xp = $stat->xp + $xpEarned;

        $stat->fill([
            'module_label' => $moduleLabel,
            'total_spots' => $total,
            'correct_spots' => $correct,
            'wrong_spots' => $wrong,
            'best' => $stat->best + ($grade === 'best' ? 1 : 0),
            'good' => $stat->good + ($grade === 'good' ? 1 : 0),
            'marginal' => $stat->marginal + ($grade === 'marginal' ? 1 : 0),
            'mistake' => $stat->mistake + ($grade === 'mistake' ? 1 : 0),
            'blunder' => $stat->blunder + ($grade === 'blunder' ? 1 : 0),
            'accuracy' => round(($correct / max(1, $total)) * 100, 2),
            'xp' => $xp,
            'level' => $this->levelForXp($xp),
        ])->save();
    }
    protected function updateLeak(int $userId, string $module, string $moduleLabel, string $grade, bool $isCorrect): void
    {
        $leak = UserLeak::firstOrCreate(
            ['user_id' => $userId, 'module' => $module],
            ['module_label' => $moduleLabel]
        );

        $total = $leak->total + 1;
        $correct = $leak->correct + ($isCorrect ? 1 : 0);
        $mistakes = $leak->mistakes + ($grade === 'mistake' ? 1 : 0);
        $blunders = $leak->blunders + ($grade === 'blunder' ? 1 : 0);
        $accuracy = round(($correct / max(1, $total)) * 100, 2);
        $weaknessScore = round((100 - $accuracy) + ($mistakes * 1.25) + ($blunders * 2.5), 2);

        $leak->fill([
            'module_label' => $moduleLabel,
            'total' => $total,
            'correct' => $correct,
            'accuracy' => $accuracy,
            'mistakes' => $mistakes,
            'blunders' => $blunders,
            'weakness_score' => $weaknessScore,
            'last_mistake_at' => $isCorrect ? $leak->last_mistake_at : now(),
        ])->save();
    }

    protected function updateSpotStat(
        int $userId,
        array $spot,
        string $grade,
        bool $isCorrect
    ): void {
        $spotId = $spot['id'] ?? $spot['spot_id'] ?? null;

        if (! $spotId) {
            return;
        }

        $stat = UserSpotStat::firstOrCreate(
            [
                'user_id' => $userId,
                'spot_id' => $spotId,
            ],
            [
                'module' => $spot['module'],
            ]
        );

        $total = $stat->total + 1;
        $correct = $stat->correct + ($isCorrect ? 1 : 0);
        $wrong = $total - $correct;

        $stat->fill([
            'module' => $spot['module'],

            'family' => $spot['family'] ?? null,
            'family_label' => $spot['family_label'] ?? null,
            'concept' => $spot['concept'] ?? null,
            'concept_label' => $spot['concept_label'] ?? null,

            'spot_title' => $spot['title'] ?? null,

            'hero_cards' => is_array($spot['hero_cards'] ?? null)
                ? implode('', $spot['hero_cards'])
                : ($spot['hero_cards'] ?? null),

            'total' => $total,
            'correct' => $correct,
            'wrong' => $wrong,
            'accuracy' => round(($correct / max(1, $total)) * 100, 2),

            'last_seen_at' => now(),
            'last_wrong_at' => $isCorrect ? $stat->last_wrong_at : now(),
        ])->save();
    }

    protected function xpForGrade(string $grade): int
    {
        return match ($grade) {
            'best' => 12,
            'good' => 9,
            'marginal' => 4,
            'mistake' => 1,
            'blunder' => 0,
            default => 0,
        };
    }

    protected function levelForXp(int $xp): int
    {
        return max(1, (int) floor($xp / 250) + 1);
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
            'spot_id' => $spot['id'] ?? $spot['spot_id'] ?? null,
            'module' => $spot['module'],
            'module_label' => $spot['module_label'],

            'family' => $spot['family'] ?? null,
            'family_label' => $spot['family_label'] ?? null,
            'concept' => $spot['concept'] ?? null,
            'concept_label' => $spot['concept_label'] ?? null,

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
            'confidence' => $spot['confidence'] ?? 80,
            'training_profile' => $spot['training_profile'] ?? 'gto',
        ];
    }

    protected function resolveTrainingProfile(string $profile): string
    {
        // For now only GTO is active. This keeps the architecture ready for
        // exploit_micro without changing current behaviour.
        return $profile === 'gto' ? 'gto' : 'gto';
    }

    protected function answerProfile(array $spot, string $profile): array
    {
        $answers = $spot['answers'] ?? [];

        if (isset($answers[$profile]) && is_array($answers[$profile])) {
            return $answers[$profile];
        }

        return $answers['gto'] ?? [
            'correct_action' => $spot['correct_action'] ?? 'FOLD',
            'explanation' => $spot['explanation'] ?? '',
            'solver_note' => $spot['solver_note'] ?? null,
            'action_grades' => $spot['action_grades'] ?? [],
        ];
    }

    protected function moduleLabel(string $module): string
    {
        return match ($module) {
            'btn_vs_3bet' => 'BTN vs 3Bet',
            'open_raise' => 'Open Raise',
            'bb_vs_btn' => 'BB vs BTN',
            'threebet_vs_open' => '3Bet vs Open',
            'sb_vs_btn' => 'SB vs BTN',
            'bb_vs_sb' => 'BB vs SB',
            default => $module,
        };
    }
}
