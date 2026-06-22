<?php

namespace App\Services;

use App\HandLab\HandLabClassifier;
use App\HandLab\HandLabRepository;
use Illuminate\Support\Collection;

class HandLabSimilarityService
{
    protected int $minimumScore = 74;

    public function __construct(protected HandLabRepository $repository)
    {
    }

    public function findBestMatch(array $payload): ?array
    {
        $payload = HandLabClassifier::enrichPayload($payload);

        $best = $this->officialCandidates()
            ->map(function (array $candidate) use ($payload): array {
                $candidate['similarity_score'] = $this->score($payload, $candidate);

                return $candidate;
            })
            ->filter(fn (array $candidate): bool => $candidate['similarity_score'] >= $this->minimumScore)
            ->sortByDesc('similarity_score')
            ->first();

        return $best ?: null;
    }

    protected function officialCandidates(): Collection
    {
        return $this->repository->all();
    }

    protected function score(array $payload, array $candidate): int
    {
        if (! $this->sameRequiredContext($payload, $candidate)) {
            return 0;
        }

        $street = strtolower((string) ($payload['street'] ?? ''));

        return match ($street) {
            'preflop' => $this->scorePreflop($payload, $candidate),
            'flop', 'turn', 'river' => $this->scorePostflop($payload, $candidate),
            default => 0,
        };
    }

    protected function scorePreflop(array $payload, array $candidate): int
    {
        $score = 0;

        $score += 20; // street
        $score += 18; // hero position
        $score += 12; // villain position
        $score += 18; // pot type

        $score += $this->exactCardsScore(
            $payload['hero_cards'] ?? [],
            $candidate['hero_cards'] ?? []
        ) * 3;

        $score += $this->stackScore(
            (float) ($payload['effective_stack_bb'] ?? 0),
            (float) ($candidate['effective_stack_bb'] ?? 0)
        );

        return max(0, min(100, $score));
    }

    protected function scorePostflop(array $payload, array $candidate): int
    {
        $street = strtolower((string) ($payload['street'] ?? ''));

        if ($street !== 'preflop') {
            $payloadClass = $payload['hand_lab_hand_class'] ?? HandLabClassifier::handClass($payload['hero_cards'] ?? [], $payload['board_cards'] ?? [], $payload['street'] ?? '');
            $candidateClass = $candidate['hand_class'] ?? HandLabClassifier::handClass($candidate['hero_cards'] ?? [], $candidate['board_cards'] ?? [], $candidate['street'] ?? '');

            // This hard gate is only for postflop.
            // It prevents cases like AA overpair matching AQ ace-high.
            if ($payloadClass !== $candidateClass) {
                return 0;
            }
        }

        $score = 0;
        $score += 18;
        $score += 14;
        $score += 14;
        $score += 14;
        $score += 22;
        $score += $this->drawScore($payload['hand_lab_draws'] ?? [], $candidate['draws'] ?? []);
        $score += $this->boardTextureScore($payload['hand_lab_board_texture'] ?? [], $candidate['board_texture'] ?? []);
        $score += $this->exactCardsScore($payload['hero_cards'] ?? [], $candidate['hero_cards'] ?? []);
        $score += $this->stackScore((float) ($payload['effective_stack_bb'] ?? 0), (float) ($candidate['effective_stack_bb'] ?? 0));

        return max(0, min(100, $score));
    }

    protected function sameRequiredContext(array $payload, array $candidate): bool
    {
        $payloadStreet = strtolower((string) ($payload['street'] ?? ''));
        $candidateStreet = strtolower((string) ($candidate['street'] ?? ''));

        if ($payloadStreet === '' || $candidateStreet === '' || $payloadStreet !== $candidateStreet) {
            return false;
        }

        $payloadHero = strtoupper((string) ($payload['hero_position'] ?? ''));
        $candidateHero = strtoupper((string) ($candidate['hero_position'] ?? ''));

        if ($payloadHero === '' || $candidateHero === '' || $payloadHero !== $candidateHero) {
            return false;
        }

        $payloadPotType = $payload['hand_lab_pot_type'] ?? HandLabClassifier::potType($payload['spot_type'] ?? null, $payload['actions'] ?? []);
        $candidatePotType = $candidate['pot_type'] ?? 'unknown';

        if ($payloadPotType === 'unknown' || $candidatePotType === 'unknown' || $payloadPotType !== $candidatePotType) {
            return false;
        }

        $isPreflopOpenRaise =
            $payloadStreet === 'preflop'
            && $payloadPotType === 'open_raise'
            && $candidatePotType === 'open_raise';

        if (! $isPreflopOpenRaise) {
            $payloadVillain = strtoupper((string) ($payload['villain_position'] ?? ''));
            $candidateVillain = strtoupper((string) ($candidate['villain_position'] ?? ''));

            if ($payloadVillain === '' || $candidateVillain === '' || $payloadVillain !== $candidateVillain) {
                return false;
            }
        }

        return true;
    }

    protected function drawScore(array $payloadDraws, array $candidateDraws): int
    {
        sort($payloadDraws);
        sort($candidateDraws);

        if ($payloadDraws === $candidateDraws) {
            return 8;
        }

        if (empty($payloadDraws) && empty($candidateDraws)) {
            return 8;
        }

        $shared = count(array_intersect($payloadDraws, $candidateDraws));

        return min(8, $shared * 4);
    }

    protected function boardTextureScore(array $payloadTexture, array $candidateTexture): int
    {
        if (empty($payloadTexture) || empty($candidateTexture)) {
            return 0;
        }

        $shared = count(array_intersect($payloadTexture, $candidateTexture));
        $total = count(array_unique(array_merge($payloadTexture, $candidateTexture)));

        if ($total === 0) {
            return 0;
        }

        return (int) round(($shared / $total) * 8);
    }

    protected function exactCardsScore(array $payloadCards, array $candidateCards): int
    {
        $payloadCombo = $this->combo($payloadCards);
        $candidateCombo = $this->combo($candidateCards);

        if ($payloadCombo === null || $candidateCombo === null) {
            return 0;
        }

        if ($payloadCombo === $candidateCombo) {
            return 6;
        }

        $payloadRanks = $this->comboRanks($payloadCombo);
        $candidateRanks = $this->comboRanks($candidateCombo);

        return count(array_intersect($payloadRanks, $candidateRanks)) * 2;
    }


    protected function comboRanks(string $combo): array
    {
        if (strlen($combo) === 3) {
            return [substr($combo, 0, 1), substr($combo, 1, 1)];
        }

        return str_split($combo);
    }

    protected function stackScore(float $payloadStack, float $candidateStack): int
    {
        if ($payloadStack <= 0 || $candidateStack <= 0) {
            return 0;
        }

        $diff = abs($payloadStack - $candidateStack);

        if ($diff <= 10) {
            return 4;
        }

        if ($diff <= 25) {
            return 2;
        }

        return 0;
    }

    protected function combo(array $cards): ?string
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
        $pair = $r1 === $r2;
        $suited = $parsed[0]['suit'] === $parsed[1]['suit'];

        return $r1 . $r2 . ($pair ? '' : ($suited ? 's' : 'o'));
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
