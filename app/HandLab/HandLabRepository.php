<?php

namespace App\HandLab;

use App\HandLab\Library\HandLabSpotRepository;
use Illuminate\Support\Collection;

class HandLabRepository
{
    public function all(): Collection
    {
        return collect(HandLabSpotRepository::all())
            ->map(fn (array $spot): array => $this->normalize($spot));
    }

    private function normalize(array $spot): array
    {
        $spot['source_type'] = 'official_hand_lab';
        $spot['source_label'] = 'ApexCash Hand Lab Official Library';
        $spot['street'] = strtolower((string) ($spot['street'] ?? ''));
        $spot['hero_position'] = strtoupper((string) ($spot['hero_position'] ?? ''));
        $spot['villain_position'] = strtoupper((string) ($spot['villain_position'] ?? ''));
        $spot['hero_cards'] = $spot['hero_cards'] ?? [];
        $spot['board_cards'] = $spot['board_cards'] ?? [];
        $spot['hand_class'] = $spot['hand_class'] ?? HandLabClassifier::handClass($spot['hero_cards'], $spot['board_cards'], $spot['street']);
        $spot['draws'] = $spot['draws'] ?? HandLabClassifier::draws($spot['hero_cards'], $spot['board_cards']);
        $spot['board_texture'] = $spot['board_texture'] ?? HandLabClassifier::boardTexture($spot['board_cards']);
        $spot['pot_type'] = $spot['pot_type'] ?? HandLabClassifier::potType($spot['spot_type'] ?? null, $spot['actions'] ?? []);
        $spot['concepts'] = $spot['concepts'] ?? [];

        return $spot;
    }
}
