<?php

namespace App\SpotTraining;

class SpotFamilyResolver
{
    public static function fromConcept(string $concept): string
    {
        return match ($concept) {

            'premium_continue',
            'value_3bet',
            'value_continue' =>
                'premium_or_strong_value',

            'ax_suited',
            'ax_3bet_bluff',
            'ax_bluff_3bet',
            'ax_4bet_bluff',
            'ax_suited_3bet' =>
                'ax_suited',

            'ax_offsuit_medium' =>
                'ax_offsuit',

            'medium_pairs',
            'pocket_pairs' =>
                'medium_pair',

            'small_pairs',
            'small_pairs_oop' =>
                'small_pair',

            'suited_connectors' =>
                'suited_connector',

            'offsuit_connectors' =>
                'offsuit_connector',

            'broadway_offsuit',
            'offsuit_broadway',
            'dominated_offsuit',
            'marginal_offsuit',
            'value_defense' =>
                'broadway_offsuit',

            'suited_broadway',
            'broadway_suited' =>
                'suited_broadway',

            'weak_suited_broadway',
            'weak_suited',
            'weak_suited_hands',
            'borderline_suited',
            'semi_bluff_suited',
            'kx_bluff_3bet',
            'broadway_weak' =>
                'weak_suited_broadway',

            'weak_suited_connector' =>
                'weak_suited_connector',

            'blind_defense' =>
                'blind_defense',

            'trash_offsuit' =>
                'trash_offsuit',

            default =>
                'uncategorized_preflop',
        };
    }

    public static function labelFromConcept(string $concept): string
    {
        return match (self::fromConcept($concept)) {

            'premium_or_strong_value' =>
                'Premium / Strong Value',

            'ax_suited' =>
                'Ax Suited',

            'ax_offsuit' =>
                'Ax Offsuit',

            'medium_pair' =>
                'Medium Pair',

            'small_pair' =>
                'Small Pair',

            'suited_connector' =>
                'Suited Connector',

            'offsuit_connector' =>
                'Offsuit Connector',

            'broadway_offsuit' =>
                'Broadway Offsuit',

            'suited_broadway' =>
                'Suited Broadway',

            'weak_suited_broadway' =>
                'Weak Suited Broadway',

            'weak_suited_connector' =>
                'Weak Suited Connector',

            'blind_defense' =>
                'Blind Defense',

            'trash_offsuit' =>
                'Trash Offsuit',

            default =>
                'Uncategorized Preflop',
        };
    }

    public static function labelFromFamily(string $family): string
    {
        return match ($family) {
            'premium_or_strong_value' => 'Premium / Strong Value',
            'suited_broadway' => 'Suited Broadway',
            'broadway_offsuit' => 'Broadway Offsuit',
            'ax_suited' => 'Ax Suited',
            'ax_offsuit' => 'Ax Offsuit',
            'medium_pair' => 'Medium Pair',
            'small_pair' => 'Small Pair',
            'suited_connector' => 'Suited Connector',
            'offsuit_connector' => 'Offsuit Connector',
            'weak_suited_broadway' => 'Weak Suited Broadway',
            'weak_suited_connector' => 'Weak Suited Connector',
            'blind_defense' => 'Blind Defense',
            'trash_offsuit' => 'Trash Offsuit',
            default => 'Uncategorized Preflop',
        };
    }

    public static function fromCards(array $cards): string
    {
        if (count($cards) < 2) {
            return 'uncategorized_preflop';
        }

        $values = [
            'A' => 14, 'K' => 13, 'Q' => 12, 'J' => 11, 'T' => 10,
            '9' => 9, '8' => 8, '7' => 7, '6' => 6, '5' => 5,
            '4' => 4, '3' => 3, '2' => 2,
        ];

        $parsed = collect(array_slice($cards, 0, 2))
            ->map(fn ($card): array => [
                'rank' => strtoupper(substr((string) $card, 0, 1)),
                'suit' => strtolower(substr((string) $card, -1)),
            ])
            ->sortByDesc(fn ($card): int => $values[$card['rank']] ?? 0)
            ->values();

        $r1 = $parsed[0]['rank'];
        $r2 = $parsed[1]['rank'];

        $high = $values[$r1] ?? 0;
        $low = $values[$r2] ?? 0;
        $suited = $parsed[0]['suit'] === $parsed[1]['suit'];
        $pair = $r1 === $r2;
        $gap = abs($high - $low);

        if ($pair) {
            return match (true) {
                $high >= 12 => 'premium_or_strong_value',
                $high >= 7 => 'medium_pair',
                default => 'small_pair',
            };
        }

        if ($high === 14 && $low >= 10) {
            return $suited ? 'suited_broadway' : 'broadway_offsuit';
        }

        if ($high >= 13 && $low >= 11 && $suited) {
            return 'suited_broadway';
        }

        if ($high >= 10 && $low >= 10) {
            return $suited ? 'suited_broadway' : 'broadway_offsuit';
        }

        if ($high === 14) {
            return $suited ? 'ax_suited' : 'ax_offsuit';
        }

        if ($suited && $gap <= 2) {
            return 'suited_connector';
        }

        if (! $suited && $gap <= 1 && $high <= 9) {
            return 'offsuit_connector';
        }

        if ($suited && $high >= 10) {
            return 'weak_suited_broadway';
        }

        if ($suited) {
            return 'weak_suited_connector';
        }

        return 'trash_offsuit';
    }
}