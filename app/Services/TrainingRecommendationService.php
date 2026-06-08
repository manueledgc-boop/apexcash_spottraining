<?php

namespace App\Services;

use App\Models\UserLeak;
use App\SpotTraining\SpotRepository;
use Illuminate\Support\Facades\Auth;

class TrainingRecommendationService
{
    public function __construct(
        protected SpotRepository $spots
    ) {
    }

    /**
     * Selects the next spot without changing the public UI contract.
     *
     * Modes:
     * - normal: 60% weak-module recommendation, 40% random.
     * - leak: 100% current worst leak.
     *
     * Explicit module filters always win over recommendations.
     */
    public function nextSpot(?string $module = null, string $mode = 'normal'): array
    {
        if ($module) {
            return $this->randomFrom($this->spots->byModule($module));
        }

        if ($mode === 'leak') {
            $worstLeak = $this->worstLeakModule();

            if ($worstLeak) {
                return $this->randomFrom($this->spots->byModule($worstLeak));
            }
        }

        if ($this->shouldTrainWeakness()) {
            $worstLeak = $this->worstLeakModule();

            if ($worstLeak) {
                $weakSpots = $this->spots->byModule($worstLeak);

                if (! empty($weakSpots)) {
                    return $this->randomFrom($weakSpots);
                }
            }
        }

        return $this->randomFrom($this->spots->all());
    }

    public function worstLeakModule(): ?string
    {
        $userId = Auth::id();

        if (! $userId) {
            return null;
        }

        return UserLeak::query()
            ->where('user_id', $userId)
            ->where('total', '>=', 3)
            ->orderByDesc('weakness_score')
            ->orderBy('accuracy')
            ->value('module');
    }

    protected function shouldTrainWeakness(): bool
    {
        // 60% leak-focused, 40% broad random practice.
        return random_int(1, 100) <= 60;
    }

    protected function randomFrom(array $spots): array
    {
        if (empty($spots)) {
            $spots = $this->spots->all();
        }

        if (empty($spots)) {
            throw new \RuntimeException('No hay spots disponibles para entrenamiento.');
        }

        return $spots[array_rand($spots)];
    }
}
