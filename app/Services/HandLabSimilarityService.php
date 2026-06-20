<?php

namespace App\Services;

use App\Models\HandLabSpot;
use App\SpotTraining\Postflop\PostflopSpotRepository;
use App\SpotTraining\PostflopRiver\PostflopRiverSpotRepository;
use App\SpotTraining\PostflopTurn\PostflopTurnSpotRepository;
use App\SpotTraining\SpotRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class HandLabSimilarityService
{
    protected int $minimumScore = 72;

    public function __construct(
        protected SpotRepository $preflopSpots,
        protected PostflopSpotRepository $flopSpots,
        protected PostflopTurnSpotRepository $turnSpots,
        protected PostflopRiverSpotRepository $riverSpots,
    ) {
    }

    public function findBestMatch(array $payload): ?array
    {
        $candidates = collect()
            ->merge($this->officialCandidates())
            ->merge($this->communityCandidates());

        $best = $candidates
            ->map(function (array $candidate) use ($payload): array {
                $candidate['similarity_score'] = $this->score($payload, $candidate);

                return $candidate;
            })
            ->filter(fn (array $candidate): bool => $candidate['similarity_score'] >= $this->minimumScore)
            ->sortByDesc(fn (array $candidate): array => [
                $candidate['similarity_score'],
                $candidate['source_type'] === 'official' ? 1 : 0,
            ])
            ->first();

        return $best ?: null;
    }

    protected function officialCandidates(): Collection
    {
        return collect($this->preflopSpots->all())
            ->map(fn (array $spot): array => $this->candidateFromOfficialSpot($spot, 'preflop'))
            ->merge(collect($this->flopSpots->all())->map(fn (array $spot): array => $this->candidateFromOfficialSpot($this->flopSpots->normalize($spot), 'flop')))
            ->merge(collect($this->turnSpots->all())->map(fn (array $spot): array => $this->candidateFromOfficialSpot($this->turnSpots->normalize($spot), 'turn')))
            ->merge(collect($this->riverSpots->all())->map(fn (array $spot): array => $this->candidateFromOfficialSpot($this->riverSpots->normalize($spot), 'river')));
    }

    protected function communityCandidates(): Collection
    {
        return HandLabSpot::query()
            ->where('review_status', 'approved')
            ->where('visibility', 'public')
            ->whereNotNull('best_action')
            ->latest()
            ->limit(2000)
            ->get()
            ->map(fn (HandLabSpot $spot): array => $this->candidateFromCommunitySpot($spot));
    }

    protected function candidateFromOfficialSpot(array $spot, string $fallbackStreet): array
    {
        $street = strtolower((string) ($spot['street'] ?? $fallbackStreet));
        $bestAction = $this->normalizeActionLabel((string) ($spot['correct_action'] ?? ''));

        return [
            'source_type' => 'official',
            'source_label' => 'ApexCash Official Library',
            'id' => $spot['id'] ?? $spot['spot_id'] ?? null,
            'street' => $street,
            'spot_type' => $spot['spot_type'] ?? $spot['title'] ?? $spot['module_label'] ?? null,
            'pot_type' => $this->potTypeFromOfficialSpot($spot),
            'hero_position' => strtoupper((string) ($spot['hero_position'] ?? '')),
            'villain_position' => strtoupper((string) ($spot['villain_position'] ?? '')),
            'spot_family' => $spot['spot_family'] ?? null,
            'hero_cards' => $spot['hero_cards'] ?? [],
            'board_cards' => $spot['board_cards'] ?? [],
            'actions' => $spot['actions'] ?? [],
            'effective_stack_bb' => (float) ($spot['effective_stack_bb'] ?? data_get($spot, 'stacks.hero_bb', 100)),
            'best_action' => $bestAction,
            'gto_explanation' => $spot['explanation'] ?? null,
            'exploit_explanation' => data_get($spot, 'insights.low_stakes'),
            'leak_label' => $spot['concept_label'] ?? $spot['concept'] ?? null,
            'concepts' => array_values(array_filter([$spot['concept'] ?? null, $spot['module'] ?? null])),
        ];
    }

    protected function candidateFromCommunitySpot(HandLabSpot $spot): array
    {
        return [
            'source_type' => 'community',
            'source_label' => 'Community Library (Approved by ApexCash)',
            'id' => $spot->id,
            'street' => strtolower((string) $spot->street),
            'spot_type' => $spot->spot_type,
            'pot_type' => $this->potTypeFromText($spot->spot_type, $spot->action_history ?? []),
            'hero_position' => strtoupper((string) $spot->hero_position),
            'villain_position' => strtoupper((string) $spot->villain_position),
            'spot_family' => $spot->spot_family,
            'hero_cards' => $spot->hero_cards ?? [],
            'board_cards' => $spot->board_cards ?? [],
            'actions' => $spot->action_history ?? [],
            'effective_stack_bb' => (float) $spot->effective_stack_bb,
            'best_action' => $spot->best_action,
            'gto_explanation' => $spot->gto_explanation,
            'exploit_explanation' => $spot->exploit_explanation,
            'leak_label' => $spot->leak_label,
            'concepts' => $spot->concepts ?? [],
        ];
    }

    protected function score(array $payload, array $candidate): int
    {
        $score = 0;

        $payloadStreet = strtolower((string) ($payload['street'] ?? ''));
        $candidateStreet = strtolower((string) ($candidate['street'] ?? ''));

        if ($payloadStreet !== $candidateStreet) {
            return 0;
        }

        $score += 25;

        $payloadFamily = $payload['spot_family'] ?? null;
        $candidateFamily = $candidate['spot_family'] ?? null;

        if ($payloadStreet === 'preflop') {
            if (! $payloadFamily || ! $candidateFamily) {
                return 0;
            }

            if ($payloadFamily !== $candidateFamily) {
                return 0;
            }
        }

        if (strtoupper((string) ($payload['hero_position'] ?? '')) === strtoupper((string) ($candidate['hero_position'] ?? ''))) {
            $score += 20;
        }

        if (strtoupper((string) ($payload['villain_position'] ?? '')) === strtoupper((string) ($candidate['villain_position'] ?? ''))) {
            $score += 20;
        }

        $payloadPotType = $this->potTypeFromText($payload['spot_type'] ?? null, $payload['actions'] ?? []);
        $candidatePotType = $candidate['pot_type'] ?? 'unknown';

        if ($payloadPotType === $candidatePotType) {
            $score += 25;
        } elseif ($payloadPotType !== 'unknown' && $candidatePotType !== 'unknown') {
            $score -= 15;
        }

        $score += $this->handScore($payload['hero_cards'] ?? [], $candidate['hero_cards'] ?? []);

        if ($payloadStreet !== 'preflop') {
            $score += $this->boardScore($payload['board_cards'] ?? [], $candidate['board_cards'] ?? []);
        }

        $score += $this->stackScore((float) ($payload['effective_stack_bb'] ?? 0), (float) ($candidate['effective_stack_bb'] ?? 0));

        return max(0, min(100, $score));
    }

    protected function handScore(array $payloadCards, array $candidateCards): int
    {
        $a = $this->handProfile($payloadCards);
        $b = $this->handProfile($candidateCards);

        if (! $a || ! $b) {
            return 0;
        }

        if ($a['combo'] === $b['combo']) {
            return 15;
        }

        if ($a['rank_class'] === $b['rank_class']) {
            return 14;
        }

        $score = 0;

        $sharedRanks = count(array_intersect($a['ranks'], $b['ranks']));
        $score += $sharedRanks * 4;

        if ($a['category'] === $b['category']) {
            $score += 5;
        }

        if ($a['suited'] === $b['suited']) {
            $score += 2;
        }

        if (abs($a['high_value'] - $b['high_value']) <= 1) {
            $score += 2;
        }

        if (abs($a['low_value'] - $b['low_value']) <= 1) {
            $score += 2;
        }

        return min(15, $score);
    }

    protected function boardScore(array $payloadBoard, array $candidateBoard): int
    {
        if (empty($payloadBoard) || empty($candidateBoard)) {
            return 0;
        }

        $a = $this->boardProfile($payloadBoard);
        $b = $this->boardProfile($candidateBoard);
        $score = 0;

        if ($a['count'] === $b['count']) {
            $score += 3;
        }

        if ($a['high_card'] === $b['high_card']) {
            $score += 4;
        }

        if ($a['paired'] === $b['paired']) {
            $score += 3;
        }

        if ($a['flush_texture'] === $b['flush_texture']) {
            $score += 3;
        }

        if ($a['connectedness'] === $b['connectedness']) {
            $score += 2;
        }

        return min(15, $score);
    }

    protected function stackScore(float $payloadStack, float $candidateStack): int
    {
        if ($payloadStack <= 0 || $candidateStack <= 0) {
            return 0;
        }

        $diff = abs($payloadStack - $candidateStack);

        if ($diff <= 10) {
            return 5;
        }

        if ($diff <= 25) {
            return 3;
        }

        return 0;
    }

    protected function handProfile(array $cards): ?array
    {
        if (count($cards) < 2) {
            return null;
        }

        $rankValues = $this->rankValues();
        $parsed = collect(array_slice($cards, 0, 2))
            ->map(fn ($card): array => [
                'rank' => strtoupper(substr((string) $card, 0, 1)),
                'suit' => strtolower(substr((string) $card, -1)),
            ])
            ->sortByDesc(fn ($card): int => $rankValues[$card['rank']] ?? 0)
            ->values();

        $r1 = $parsed[0]['rank'];
        $r2 = $parsed[1]['rank'];
        $suited = $parsed[0]['suit'] === $parsed[1]['suit'];
        $pair = $r1 === $r2;
        $high = $rankValues[$r1] ?? 0;
        $low = $rankValues[$r2] ?? 0;
        $gap = abs($high - $low);

        return [
            'combo' => $r1 . $r2 . ($pair ? '' : ($suited ? 's' : 'o')),
            'rank_class' => $r1 . $r2,
            'ranks' => [$r1, $r2],
            'suited' => $suited,
            'high_value' => $high,
            'low_value' => $low,
            'category' => match (true) {
                $pair && $high >= 11 => 'premium_pair',
                $pair => 'pair',
                $high >= 14 && $low >= 10 => 'strong_broadway',
                $high >= 10 && $low >= 10 => 'broadway',
                $suited && $gap <= 2 => 'suited_connected',
                $suited => 'suited',
                default => 'offsuit',
            },
        ];
    }

    protected function boardProfile(array $cards): array
    {
        $rankValues = $this->rankValues();
        $ranks = collect($cards)->map(fn ($card) => strtoupper(substr((string) $card, 0, 1)))->all();
        $suits = collect($cards)->map(fn ($card) => strtolower(substr((string) $card, -1)))->all();
        $values = collect($ranks)->map(fn ($rank) => $rankValues[$rank] ?? 0)->sort()->values();
        $maxSuitCount = collect($suits)->countBy()->max() ?? 0;
        $rankCounts = collect($ranks)->countBy();
        $maxGap = $values->count() > 1 ? $values->last() - $values->first() : 0;
        $highValue = $values->max() ?? 0;

        return [
            'count' => count($cards),
            'high_card' => match (true) {
                $highValue >= 14 => 'ace_high',
                $highValue >= 13 => 'king_high',
                $highValue >= 12 => 'queen_high',
                $highValue >= 10 => 'broadway_high',
                default => 'low_high',
            },
            'paired' => $rankCounts->max() >= 2,
            'flush_texture' => match (true) {
                $maxSuitCount >= 3 => 'monotone_or_flush_possible',
                $maxSuitCount === 2 => 'two_tone',
                default => 'rainbow',
            },
            'connectedness' => $maxGap <= 4 ? 'connected' : 'dry',
        ];
    }

    protected function potTypeFromOfficialSpot(array $spot): string
    {
        $module = strtolower((string) ($spot['module'] ?? ''));
        $family = strtolower((string) ($spot['family'] ?? ''));
        $title = strtolower((string) ($spot['title'] ?? ''));
        $actions = $spot['actions'] ?? [];

        if (Str::contains($module . ' ' . $family . ' ' . $title, ['btn_vs_3bet', '3bet', '3 bet', '3-bet'])) {
            return '3bet_pot';
        }

        if (Str::contains($module . ' ' . $family . ' ' . $title, ['4bet', '4 bet', '4-bet'])) {
            return '4bet_pot';
        }

        return $this->potTypeFromText($title, $actions);
    }

    protected function potTypeFromText(?string $text, array $actions = []): string
    {
        $haystack = strtolower((string) $text . ' ' . json_encode($actions));

        if (Str::contains($haystack, ['4bet', '4 bet', '4-bet'])) {
            return '4bet_pot';
        }

        if (Str::contains($haystack, ['3bet', '3 bet', '3-bet'])) {
            return '3bet_pot';
        }

        if (Str::contains($haystack, ['limp', 'limped'])) {
            return 'limped_pot';
        }

        if (Str::contains($haystack, ['srp', 'single raised', 'opens', 'raises', 'raise'])) {
            return 'srp';
        }

        return 'unknown';
    }

    protected function normalizeActionLabel(string $action): string
    {
        $action = strtoupper(trim($action));

        return match ($action) {
            'BET_33' => 'Bet 33%',
            'BET_50' => 'Bet 50%',
            'BET_66', 'BET_75' => 'Bet 75%',
            'OVERBET' => 'Overbet',
            '4BET' => 'Raise / 4Bet',
            'ALLIN', 'ALL_IN', 'ALL-IN' => 'All-in',
            default => Str::title(strtolower(str_replace('_', ' ', $action))),
        };
    }

    protected function rankValues(): array
    {
        return [
            'A' => 14,
            'K' => 13,
            'Q' => 12,
            'J' => 11,
            'T' => 10,
            '9' => 9,
            '8' => 8,
            '7' => 7,
            '6' => 6,
            '5' => 5,
            '4' => 4,
            '3' => 3,
            '2' => 2,
        ];
    }
}
