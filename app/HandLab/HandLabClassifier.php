<?php

namespace App\HandLab;

class HandLabClassifier
{
    public static function enrichPayload(array $payload): array
    {
        $payload['hand_lab_hand_class'] = self::handClass($payload['hero_cards'] ?? [], $payload['board_cards'] ?? [], strtolower((string) ($payload['street'] ?? '')));
        $payload['hand_lab_draws'] = self::draws($payload['hero_cards'] ?? [], $payload['board_cards'] ?? []);
        $payload['hand_lab_board_texture'] = self::boardTexture($payload['board_cards'] ?? []);
        $payload['hand_lab_pot_type'] = self::potType($payload['spot_type'] ?? null, $payload['actions'] ?? []);
        $payload['spot_family'] = $payload['hand_lab_hand_class'];
        $payload['spot_family_label'] = self::label($payload['hand_lab_hand_class']);

        return $payload;
    }

    public static function label(?string $class): ?string
    {
        return match ($class) {
            'set_or_better' => 'Set o mejor',
            'two_pair' => 'Doble pareja',
            'overpair' => 'Overpair',
            'top_pair' => 'Top pair',
            'second_pair' => 'Second pair',
            'third_pair' => 'Third pair',
            'underpair' => 'Underpair',
            'ace_high' => 'Ace high',
            'air' => 'Air / sin showdown claro',
            'premium_pair_preflop' => 'Pareja premium preflop',
            'pair_preflop' => 'Pareja preflop',
            'strong_broadway_preflop' => 'Broadway fuerte preflop',
            default => $class,
        };
    }

    public static function handClass(array $heroCards, array $boardCards = [], string $street = ''): string
    {
        if (count($heroCards) < 2) {
            return 'unknown';
        }

        $heroRanks = self::cardRanks($heroCards);
        $heroValues = array_map(fn (string $rank): int => self::rankValues()[$rank] ?? 0, $heroRanks);
        rsort($heroValues);
        $isPair = $heroRanks[0] === $heroRanks[1];

        if ($street === 'preflop' || empty($boardCards)) {
            if ($isPair && $heroValues[0] >= 11) {
                return 'premium_pair_preflop';
            }

            if ($isPair) {
                return 'pair_preflop';
            }

            if ($heroValues[0] >= 14 && $heroValues[1] >= 10) {
                return 'strong_broadway_preflop';
            }

            return 'other_preflop';
        }

        $boardRanks = self::cardRanks($boardCards);
        $boardValues = array_map(fn (string $rank): int => self::rankValues()[$rank] ?? 0, $boardRanks);
        rsort($boardValues);

        $allRanks = array_merge($heroRanks, $boardRanks);
        $counts = array_count_values($allRanks);
        $heroMadeRanks = array_values(array_filter($heroRanks, fn (string $rank): bool => ($counts[$rank] ?? 0) >= 2));

        if (self::hasStraight($heroCards, $boardCards) || self::hasFlush($heroCards, $boardCards)) {
            return 'set_or_better';
        }

        foreach ($heroRanks as $rank) {
            if (($counts[$rank] ?? 0) >= 3) {
                return 'set_or_better';
            }
        }

        if (count(array_unique($heroMadeRanks)) >= 2) {
            return 'two_pair';
        }

        $boardHighest = max($boardValues ?: [0]);
        $boardUniqueDesc = array_values(array_unique($boardValues));
        rsort($boardUniqueDesc);

        if ($isPair) {
            if ($heroValues[0] > $boardHighest) {
                return 'overpair';
            }

            if (in_array($heroRanks[0], $boardRanks, true)) {
                return 'set_or_better';
            }

            return 'underpair';
        }

        foreach ($heroRanks as $rank) {
            if (in_array($rank, $boardRanks, true)) {
                $value = self::rankValues()[$rank] ?? 0;

                if ($value === ($boardUniqueDesc[0] ?? 0)) {
                    return 'top_pair';
                }

                if ($value === ($boardUniqueDesc[1] ?? null)) {
                    return 'second_pair';
                }

                return 'third_pair';
            }
        }

        if (in_array('A', $heroRanks, true)) {
            return 'ace_high';
        }

        return 'air';
    }

    public static function draws(array $heroCards, array $boardCards): array
    {
        if (count($heroCards) < 2 || count($boardCards) < 3) {
            return [];
        }

        $draws = [];
        $allCards = array_merge($heroCards, $boardCards);
        $suits = array_map(fn (string $card): string => strtolower(substr($card, -1)), $allCards);
        $suitCounts = array_count_values($suits);

        foreach ($heroCards as $card) {
            $suit = strtolower(substr((string) $card, -1));
            if (($suitCounts[$suit] ?? 0) === 4) {
                $draws[] = 'flush_draw';
                break;
            }
        }

        $values = self::uniqueValues($allCards);
        $openEnded = false;
        $gutshot = false;

        for ($start = 2; $start <= 10; $start++) {
            $window = range($start, $start + 4);
            $present = array_values(array_intersect($window, $values));
            $missing = array_values(array_diff($window, $values));

            if (count($present) === 4) {
                if (count($missing) === 1 && ($missing[0] === $start || $missing[0] === $start + 4)) {
                    $openEnded = true;
                } else {
                    $gutshot = true;
                }
            }
        }

        if ($openEnded) {
            $draws[] = 'oesd';
        } elseif ($gutshot) {
            $draws[] = 'gutshot';
        }

        return array_values(array_unique($draws));
    }

    public static function boardTexture(array $boardCards): array
    {
        if (empty($boardCards)) {
            return ['none'];
        }

        $ranks = self::cardRanks($boardCards);
        $values = array_map(fn (string $rank): int => self::rankValues()[$rank] ?? 0, $ranks);
        sort($values);
        $suits = array_map(fn (string $card): string => strtolower(substr($card, -1)), $boardCards);
        $rankCounts = array_count_values($ranks);
        $suitCounts = array_count_values($suits);
        $maxSuit = max($suitCounts ?: [0]);
        $gap = count($values) > 1 ? max($values) - min($values) : 0;
        $high = max($values ?: [0]);

        return array_values(array_filter([
            $high >= 14 ? 'ace_high' : null,
            $high >= 12 && $high < 14 ? 'broadway_high' : null,
            $high < 12 ? 'low_medium_high' : null,
            max($rankCounts ?: [0]) >= 2 ? 'paired' : 'unpaired',
            $maxSuit >= 3 ? 'monotone' : ($maxSuit === 2 ? 'two_tone' : 'rainbow'),
            $gap <= 4 ? 'connected' : 'dry',
        ]));
    }

    public static function potType(?string $text, array $actions = []): string
    {
        $haystack = strtolower((string) $text . ' ' . json_encode($actions));

        if (str_contains($haystack, '4bet') || str_contains($haystack, '4 bet') || str_contains($haystack, '4-bet')) {
            return '4bet_pot';
        }

        if (str_contains($haystack, '3bet') || str_contains($haystack, '3 bet') || str_contains($haystack, '3-bet')) {
            return '3bet_pot';
        }

        if (str_contains($haystack, 'limp')) {
            return 'limped_pot';
        }

        if (str_contains($haystack, 'raise') || str_contains($haystack, 'opens') || str_contains($haystack, 'single raised') || str_contains($haystack, 'srp')) {
            return 'srp';
        }

        return 'unknown';
    }

    private static function cardRanks(array $cards): array
    {
        return array_map(fn ($card): string => strtoupper(substr((string) $card, 0, 1)), $cards);
    }

    private static function hasFlush(array $heroCards, array $boardCards): bool
    {
        $allCards = array_merge($heroCards, $boardCards);
        $suits = array_map(fn (string $card): string => strtolower(substr($card, -1)), $allCards);
        $counts = array_count_values($suits);

        foreach ($heroCards as $card) {
            $suit = strtolower(substr((string) $card, -1));
            if (($counts[$suit] ?? 0) >= 5) {
                return true;
            }
        }

        return false;
    }

    private static function hasStraight(array $heroCards, array $boardCards): bool
    {
        $values = self::uniqueValues(array_merge($heroCards, $boardCards));

        for ($start = 2; $start <= 10; $start++) {
            if (count(array_intersect(range($start, $start + 4), $values)) === 5) {
                return true;
            }
        }

        return false;
    }

    private static function uniqueValues(array $cards): array
    {
        $values = [];
        foreach ($cards as $card) {
            $rank = strtoupper(substr((string) $card, 0, 1));
            $value = self::rankValues()[$rank] ?? 0;
            if ($value > 0) {
                $values[] = $value;
                if ($value === 14) {
                    $values[] = 1;
                }
            }
        }

        return array_values(array_unique($values));
    }

    private static function rankValues(): array
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
