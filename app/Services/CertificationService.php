<?php

namespace App\Services;

use App\Models\CertificationAttempt;
use App\Models\User;
use App\SpotTraining\Mastery\MasterySpotRepository;
use App\SpotTraining\Postflop\PostflopSpotRepository;
use App\SpotTraining\PostflopRiver\PostflopRiverSpotRepository;
use App\SpotTraining\PostflopTurn\PostflopTurnSpotRepository;
use App\SpotTraining\SpotRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CertificationService
{
    public const TOTAL_QUESTIONS = 75;
    public const QUESTIONS_PER_BLOCK = 15;
    public const DURATION_MINUTES = 60;
    public const PASS_SCORE = 75;
    public const MIN_BLOCK_SCORE = 60;
    public const DISTINCTION_SCORE = 90;
    public const RETRY_DAYS = 7;

    public function __construct(
        protected SpotRepository $preflopSpots,
        protected PostflopSpotRepository $flopSpots,
        protected PostflopTurnSpotRepository $turnSpots,
        protected PostflopRiverSpotRepository $riverSpots,
        protected MasterySpotRepository $masterySpots,
    ) {
    }

    public function activeAttempt(User $user): ?CertificationAttempt
    {
        return CertificationAttempt::query()
            ->where('user_id', $user->id)
            ->whereNull('completed_at')
            ->latest()
            ->first();
    }

    public function startAttempt(User $user): CertificationAttempt
    {
        if ($active = $this->activeAttempt($user)) {
            return $active;
        }

        $attemptNumber = CertificationAttempt::query()
            ->where('user_id', $user->id)
            ->count() + 1;

        $startedAt = now();

        return CertificationAttempt::create([
            'user_id' => $user->id,
            'attempt_number' => $attemptNumber,
            'total_questions' => self::TOTAL_QUESTIONS,
            'preflop_total' => self::QUESTIONS_PER_BLOCK,
            'flop_total' => self::QUESTIONS_PER_BLOCK,
            'turn_total' => self::QUESTIONS_PER_BLOCK,
            'river_total' => self::QUESTIONS_PER_BLOCK,
            'mastery_total' => self::QUESTIONS_PER_BLOCK,
            'questions_snapshot' => $this->generateExamQuestions(),
            'answers_snapshot' => [],
            'started_at' => $startedAt,
            'expires_at' => $startedAt->copy()->addMinutes(self::DURATION_MINUTES),
        ]);
    }

    public function currentQuestion(CertificationAttempt $attempt): ?array
    {
        $questions = $attempt->questions_snapshot ?? [];
        $answers = $attempt->answers_snapshot ?? [];
        $index = count($answers);

        return $questions[$index] ?? null;
    }

    public function currentQuestionNumber(CertificationAttempt $attempt): int
    {
        return count($attempt->answers_snapshot ?? []) + 1;
    }

    public function answerCurrentQuestion(CertificationAttempt $attempt, string $selectedAction): CertificationAttempt
    {
        if ($attempt->completed_at) {
            return $attempt;
        }

        if ($this->isExpired($attempt)) {
            return $this->finishAttempt($attempt);
        }

        $question = $this->currentQuestion($attempt);

        if (! $question) {
            return $this->finishAttempt($attempt);
        }

        $selectedAction = strtoupper(trim($selectedAction));
        $options = array_map(fn ($option) => strtoupper((string) $option), $question['options'] ?? []);

        if (! in_array($selectedAction, $options, true)) {
            abort(422, 'Respuesta inválida para esta pregunta.');
        }

        $grade = $question['grades'][$selectedAction] ?? 'mistake';
        $isCorrect = in_array($grade, ['best', 'good'], true);

        $answers = $attempt->answers_snapshot ?? [];
        $answers[] = [
            'question_index' => count($answers),
            'question_id' => $question['id'],
            'block' => $question['block'],
            'selected_action' => $selectedAction,
            'correct_action' => $question['correct_action'],
            'grade' => $grade,
            'correct' => $isCorrect,
            'answered_at' => now()->toDateTimeString(),
        ];

        $attempt->forceFill([
            'answers_snapshot' => $answers,
        ])->save();

        if (count($answers) >= self::TOTAL_QUESTIONS) {
            return $this->finishAttempt($attempt->fresh());
        }

        return $attempt->fresh();
    }

    public function finishAttempt(CertificationAttempt $attempt): CertificationAttempt
    {
        if ($attempt->completed_at) {
            return $attempt;
        }

        $questions = $attempt->questions_snapshot ?? [];
        $answers = $attempt->answers_snapshot ?? [];
        $answeredByQuestionId = collect($answers)->keyBy('question_id');

        $blockStats = [
            'preflop' => ['total' => 0, 'correct' => 0],
            'flop' => ['total' => 0, 'correct' => 0],
            'turn' => ['total' => 0, 'correct' => 0],
            'river' => ['total' => 0, 'correct' => 0],
            'mastery' => ['total' => 0, 'correct' => 0],
        ];

        foreach ($questions as $question) {
            $block = $question['block'];
            $blockStats[$block]['total']++;

            $answer = $answeredByQuestionId->get($question['id']);

            if ($answer && (bool) ($answer['correct'] ?? false)) {
                $blockStats[$block]['correct']++;
            }
        }

        $totalCorrect = array_sum(array_column($blockStats, 'correct'));
        $totalQuestions = count($questions) ?: self::TOTAL_QUESTIONS;
        $globalScore = $this->score($totalCorrect, $totalQuestions);

        $preflopScore = $this->score($blockStats['preflop']['correct'], $blockStats['preflop']['total']);
        $flopScore = $this->score($blockStats['flop']['correct'], $blockStats['flop']['total']);
        $turnScore = $this->score($blockStats['turn']['correct'], $blockStats['turn']['total']);
        $riverScore = $this->score($blockStats['river']['correct'], $blockStats['river']['total']);
        $masteryScore = $this->score($blockStats['mastery']['correct'], $blockStats['mastery']['total']);

        $blockScores = [$preflopScore, $flopScore, $turnScore, $riverScore, $masteryScore];
        $passesBlocks = collect($blockScores)->every(fn (float $score) => $score >= self::MIN_BLOCK_SCORE);
        $passed = $globalScore >= self::PASS_SCORE && $passesBlocks;
        $distinction = $passed && $globalScore >= self::DISTINCTION_SCORE;

        $completedAt = now();
        $durationSeconds = $attempt->started_at ? $attempt->started_at->diffInSeconds($completedAt) : null;

        $attempt->forceFill([
            'total_correct' => $totalCorrect,
            'total_wrong' => max(0, $totalQuestions - $totalCorrect),
            'global_score' => $globalScore,
            'preflop_correct' => $blockStats['preflop']['correct'],
            'preflop_score' => $preflopScore,
            'flop_correct' => $blockStats['flop']['correct'],
            'flop_score' => $flopScore,
            'turn_correct' => $blockStats['turn']['correct'],
            'turn_score' => $turnScore,
            'river_correct' => $blockStats['river']['correct'],
            'river_score' => $riverScore,
            'mastery_correct' => $blockStats['mastery']['correct'],
            'mastery_score' => $masteryScore,
            'passed' => $passed,
            'distinction' => $distinction,
            'result_label' => $distinction ? 'APROBADO CON DISTINCIÓN' : ($passed ? 'APROBADO' : 'NO APROBADO'),
            'certificate_code' => $passed ? ($attempt->certificate_code ?: $this->generateCertificateCode($attempt)) : null,
            'completed_at' => $completedAt,
            'duration_seconds' => $durationSeconds,
            'next_attempt_at' => $passed ? null : $completedAt->copy()->addDays(self::RETRY_DAYS),
        ])->save();

        return $attempt->fresh();
    }

    public function isExpired(CertificationAttempt $attempt): bool
    {
        return $attempt->expires_at !== null && now()->greaterThanOrEqualTo($attempt->expires_at);
    }

    protected function generateExamQuestions(): array
    {
$questions = array_merge(
            $this->questionsFromRepository('preflop', 'Preflop', $this->preflopSpots->all(), $this->preflopSpots),
            $this->questionsFromRepository('flop', 'Flop', $this->flopSpots->all(), $this->flopSpots),
            $this->questionsFromRepository('turn', 'Turn', $this->turnSpots->all(), $this->turnSpots),
            $this->questionsFromRepository('river', 'River', $this->riverSpots->all(), $this->riverSpots),
            $this->questionsFromRepository('mastery', 'Mastery', $this->masterySpots->all(), $this->masterySpots),
        );

        shuffle($questions);

        return array_values($questions);
    }

    protected function questionsFromRepository(string $block, string $blockLabel, array $spots, object $repository): array
    {
        shuffle($spots);

        return collect($spots)
            ->take(self::QUESTIONS_PER_BLOCK)
            ->map(function (array $spot) use ($block, $blockLabel, $repository): array {
                if (method_exists($repository, 'normalize')) {
                    $spot = $repository->normalize($spot);
                }

                $answerProfile = $spot['answers']['gto'] ?? [];
                $correctAction = strtoupper((string) ($answerProfile['correct_action'] ?? $spot['correct_action'] ?? Arr::first($spot['options'] ?? [])));
                $actionGrades = $answerProfile['action_grades'] ?? $spot['action_grades'] ?? [];

                $grades = [];
                foreach (($spot['options'] ?? []) as $option) {
                    $option = strtoupper((string) $option);
                    $grades[$option] = $actionGrades[$option]['grade'] ?? ($option === $correctAction ? 'best' : 'mistake');
                }

                return [
                    'id' => $block . ':' . ($spot['id'] ?? $spot['spot_id'] ?? Str::uuid()->toString()),
                    'spot_id' => $spot['id'] ?? $spot['spot_id'] ?? null,
                    'block' => $block,
                    'block_label' => $blockLabel,
                    'module' => $spot['module'] ?? $block,
                    'module_label' => $spot['module_label'] ?? $blockLabel,
                    'street' => $spot['street'] ?? $block,
                    'title' => $spot['title'] ?? 'Spot ApexCash',
                    'hero_position' => $spot['hero_position'] ?? 'BTN',
                    'villain_position' => $spot['villain_position'] ?? null,
                    'hero_cards' => $spot['hero_cards'] ?? [],
                    'board_cards' => $spot['board_cards'] ?? [],
                    'pot_bb' => $spot['pot_bb'] ?? 0,
                    'spr' => $spot['spr'] ?? null,
                    'effective_stack_bb' => $spot['effective_stack_bb'] ?? ($spot['stacks']['hero_bb'] ?? null),
                    'actions' => $spot['actions'] ?? [],
                    'options' => array_values(array_map(fn ($option) => strtoupper((string) $option), $spot['options'] ?? ['FOLD', 'CALL', 'RAISE'])),
                    'correct_action' => $correctAction,
                    'grades' => $grades,
                    'table_players' => $spot['table_players'] ?? [],
                ];
            })
            ->values()
            ->all();
    }

    protected function score(int $correct, int $total): float
    {
        return $total > 0 ? round(($correct / $total) * 100, 2) : 0.0;
    }

    protected function generateCertificateCode(CertificationAttempt $attempt): string
    {
        return 'APX-' . now()->format('Y') . '-' . str_pad((string) $attempt->id, 6, '0', STR_PAD_LEFT) . '-' . strtoupper(Str::random(4));
    }
}
