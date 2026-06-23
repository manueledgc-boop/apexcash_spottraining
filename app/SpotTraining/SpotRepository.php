<?php

namespace App\SpotTraining;

use App\SpotTraining\Modules\BbVsBtnSpots;
use App\SpotTraining\Modules\BbVsSbSpots;
use App\SpotTraining\Modules\BtnVs3BetSpots;
use App\SpotTraining\Modules\OpenRaiseSpots;
use App\SpotTraining\Modules\SbVsBtnSpots;
use App\SpotTraining\Modules\ThreeBetVsOpenSpots;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SpotRepository
{
    public function all(): array
    {
        $spots = array_merge(
            BtnVs3BetSpots::all(),
            OpenRaiseSpots::all(),
            BbVsBtnSpots::all(),
            ThreeBetVsOpenSpots::all(),
            SbVsBtnSpots::all(),
            BbVsSbSpots::all(),
        );

        if (! Auth::user()?->hasPremiumAccess()) {
            $spots = array_slice($spots, 0, 20);
        }

        return array_values(array_map(
            fn (array $spot) => $this->normalize($spot),
            $spots
        ));
    }

    public function byModule(string $module): array
    {
        return array_values(array_filter(
            $this->all(),
            fn (array $spot) => $spot['module'] === $module
        ));
    }

    public function normalize(array $spot): array
    {
        $spot['id'] = $spot['id'] ?? $this->buildStableId($spot);
        $spot['spot_id'] = $spot['spot_id'] ?? $spot['id'];
        $spot['confidence'] = (int) ($spot['confidence'] ?? 80);
        $spot['training_profile'] = $spot['training_profile'] ?? 'gto';

        if (! isset($spot['answers']) || ! is_array($spot['answers'])) {
            $spot['answers'] = [
                'gto' => [
                    'correct_action' => strtoupper((string) ($spot['correct_action'] ?? 'FOLD')),
                    'explanation' => $spot['explanation'] ?? '',
                    'solver_note' => $spot['solver_note'] ?? null,
                    'action_grades' => $spot['action_grades'] ?? [],
                ],
            ];
        }

        // Backward compatibility for the current frontend/service.
        $gto = $spot['answers']['gto'] ?? [];
        $spot['correct_action'] = strtoupper((string) ($gto['correct_action'] ?? $spot['correct_action'] ?? 'FOLD'));
        $spot['explanation'] = $gto['explanation'] ?? $spot['explanation'] ?? '';
        $spot['solver_note'] = $gto['solver_note'] ?? $spot['solver_note'] ?? null;
        $spot['action_grades'] = $gto['action_grades'] ?? $spot['action_grades'] ?? [];

        return $spot;
    }

    protected function buildStableId(array $spot): string
    {
        $parts = [
            $spot['module'] ?? 'spot',
            $spot['hero_position'] ?? 'hero',
            $spot['villain_position'] ?? 'na',
            implode('', $spot['hero_cards'] ?? []),
            $spot['title'] ?? 'untitled',
        ];

        return strtoupper(Str::slug(implode(' ', $parts), '_'));
    }

    public function findById(string $spotId): ?array
    {
        foreach ($this->all() as $spot) {
            $currentId = $spot['id'] ?? $spot['spot_id'] ?? null;

            if ($currentId === $spotId) {
                return $spot;
            }
        }

        return null;
    }

    public function byConcept(string $concept): array
    {
        return array_values(array_filter($this->all(), function (array $spot) use ($concept) {
            return ($spot['concept'] ?? null) === $concept;
        }));
    }

}
