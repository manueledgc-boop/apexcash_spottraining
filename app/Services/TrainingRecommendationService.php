<?php

namespace App\Services;

use App\Models\UserLeak;
use App\SpotTraining\SpotRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\SpotPoolProgressService;

class TrainingRecommendationService
{
    public function __construct(
        protected SpotRepository $spots,
        protected SpotPoolProgressService $poolProgress,
    ) {
    }

    public function nextSpot(
        ?string $module = null,
        string $mode = 'normal',
        ?string $concept = null
    ): array {
        if ($concept) {
            return $this->pickAndRemember(
                $this->spots->byConcept($concept),
                $module,
                $mode,
                $concept
            );
        }

        if ($module) {
            return $this->pickAndRemember(
                $this->spots->byModule($module),
                $module,
                $mode,
                $concept
            );
        }

        if ($mode === 'leak') {
            $worstLeak = $this->worstLeakModule();

            if ($worstLeak) {
                return $this->pickAndRemember(
                    $this->spots->byModule($worstLeak),
                    $worstLeak,
                    $mode,
                    $concept
                );
            }
        }

        $recommendedModule = $this->recommendedModule();

        if ($recommendedModule) {
            return $this->pickAndRemember(
                $this->spots->byModule($recommendedModule),
                $recommendedModule,
                $mode,
                $concept
            );
        }

        return $this->pickAndRemember(
            $this->spots->all(),
            null,
            $mode,
            $concept
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

    protected function recommendedModule(): ?string
    {
        $userId = Auth::id();

        if (! $userId) {
            return null;
        }

        $leaks = UserLeak::query()
            ->where('user_id', $userId)
            ->where('total', '>=', 3)
            ->get();

        if ($leaks->isEmpty()) {
            return null;
        }

        $weightedModules = [];

        foreach ($leaks as $leak) {
            $accuracy = (float) $leak->accuracy;
            $weakness = (float) $leak->weakness_score;

            if ($accuracy < 60) {
                $weight = 5;
            } elseif ($accuracy < 80) {
                $weight = 3;
            } else {
                $weight = 1;
            }

            $score = max(1, (int) round($weight + $weakness));

            for ($i = 0; $i < $score; $i++) {
                $weightedModules[] = $leak->module;
            }
        }

        if (empty($weightedModules)) {
            return null;
        }

        return $weightedModules[array_rand($weightedModules)];
    }

    protected function pickAndRemember(
        array $spots,
        ?string $module = null,
        string $mode = 'normal',
        ?string $concept = null
    ): array {
        return $this->poolProgress->pick(
            $spots,
            'preflop',
            $module,
            $concept
        );
    }

}
