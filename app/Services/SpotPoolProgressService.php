<?php

namespace App\Services;

use App\Models\UserSpotPoolProgress;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class SpotPoolProgressService
{
    public function __construct(
        protected FreemiumTrainingAccessService $freemium
    ) {
    }

    public function pick(array $spots, string $stage, ?string $module = null, ?string $concept = null): array
    {
        if ($this->freemium->hasReachedFreeLimit($stage)) {
            throw new RuntimeException('FREE_LIMIT_REACHED');
        }

        $spots = array_values($spots);

        if (empty($spots)) {
            throw new RuntimeException('No hay spots disponibles.');
        }

        $userId = Auth::id();

        if (! $userId) {
            return $spots[array_rand($spots)];
        }

        $poolKey = $this->poolKey($stage, $module, $concept);

        $cycle = (int) UserSpotPoolProgress::query()
            ->where('user_id', $userId)
            ->where('pool_key', $poolKey)
            ->max('cycle');

        $cycle = max(1, $cycle);

        $seenIds = UserSpotPoolProgress::query()
            ->where('user_id', $userId)
            ->where('pool_key', $poolKey)
            ->where('cycle', $cycle)
            ->pluck('spot_id')
            ->all();

        $available = array_values(array_filter($spots, function (array $spot) use ($seenIds): bool {
            return ! in_array($this->spotId($spot), $seenIds, true);
        }));

        if (empty($available)) {
            $cycle++;
            $available = $spots;
        }

        $spot = $available[array_rand($available)];
        $spotId = $this->spotId($spot);

        UserSpotPoolProgress::firstOrCreate([
            'user_id' => $userId,
            'pool_key' => $poolKey,
            'spot_id' => $spotId,
            'cycle' => $cycle,
        ], [
            'stage' => $stage,
            'seen_at' => now(),
        ]);

        return $spot;
    }

    protected function poolKey(string $stage, ?string $module = null, ?string $concept = null): string
    {
        return $stage.'|'.($module ?: 'all').'|'.($concept ?: 'all');
    }

    protected function spotId(array $spot): string
    {
        return (string) ($spot['id'] ?? $spot['spot_id'] ?? md5(json_encode($spot)));
    }
}