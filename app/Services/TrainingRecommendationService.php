<?php

namespace App\Services;

use App\Models\UserLeak;
use App\SpotTraining\SpotRepository;
use Illuminate\Support\Facades\Auth;

class TrainingRecommendationService
{
    protected int $recentLimit = 15;

    public function __construct(
        protected SpotRepository $spots
    ) {
    }

    public function nextSpot(?string $module = null, string $mode = 'normal'): array
    {
        if ($module) {
            return $this->pickAndRemember(
                $this->spots->byModule($module)
            );
        }

        if ($mode === 'leak') {
            $worstLeak = $this->worstLeakModule();

            if ($worstLeak) {
                return $this->pickAndRemember(
                    $this->spots->byModule($worstLeak)
                );
            }
        }

        if ($this->shouldTrainWeakness()) {
            $worstLeak = $this->worstLeakModule();

            if ($worstLeak) {
                $weakSpots = $this->spots->byModule($worstLeak);

                if (! empty($weakSpots)) {
                    return $this->pickAndRemember($weakSpots);
                }
            }
        }

        return $this->pickAndRemember(
            $this->spots->all()
        );
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
        return random_int(1, 100) <= 60;
    }

    protected function pickAndRemember(array $spots): array
    {
        $spot = $this->randomFromWithoutRecent($spots);

        $this->rememberSpot($spot);

        return $spot;
    }

    protected function randomFromWithoutRecent(array $spots): array
    {
        if (empty($spots)) {
            $spots = $this->spots->all();
        }

        if (empty($spots)) {
            throw new \RuntimeException('No hay spots disponibles para entrenamiento.');
        }

        $recentIds = session('spot_training.recent_spots', []);

        $available = array_values(array_filter($spots, function (array $spot) use ($recentIds) {
            $spotId = $this->spotId($spot);

            return ! in_array($spotId, $recentIds, true);
        }));

        if (empty($available)) {
            $available = $spots;
        }

        return $available[array_rand($available)];
    }

    protected function rememberSpot(array $spot): void
    {
        $spotId = $this->spotId($spot);

        if (! $spotId) {
            return;
        }

        $recent = session('spot_training.recent_spots', []);

        $recent[] = $spotId;

        $recent = array_values(array_unique($recent));

        if (count($recent) > $this->recentLimit) {
            $recent = array_slice($recent, -$this->recentLimit);
        }

        session(['spot_training.recent_spots' => $recent]);
    }

    protected function spotId(array $spot): ?string
    {
        return $spot['spot_id'] ?? $spot['id'] ?? null;
    }
}