<?php

namespace App\SpotTraining\Mastery\Concerns;

trait BuildsMasterySpots
{
    protected static function spot(
        string $id,
        string $module,
        string $moduleLabel,
        string $concept,
        string $conceptLabel,
        string $title,
        string $street,
        string $heroPosition,
        string $villainPosition,
        array $heroCards,
        array $boardCards,
        float $potBb,
        float $spr,
        float $effectiveStackBb,
        string $boardTexture,
        string $rangeAdvantage,
        string $nutAdvantage,
        array $actions,
        array $options,
        string $correctAction,
        string $explanation,
        string $solverNote,
        array $grades,
        string $gtoInsight,
        string $lowStakesInsight,
        int $confidence = 80,
        string $family = 'mastery',
        string $familyLabel = 'Mastery'
    ): array {
        return [
            'id' => $id,

            'module' => $module,
            'module_label' => $moduleLabel,

            'family' => $family,
            'family_label' => $familyLabel,

            'concept' => $concept,
            'concept_label' => $conceptLabel,

            'title' => $title,
            'street' => $street,

            'hero_position' => $heroPosition,
            'villain_position' => $villainPosition,

            'hero_cards' => $heroCards,
            'board_cards' => $boardCards,

            'pot_bb' => $potBb,
            'spr' => $spr,
            'effective_stack_bb' => $effectiveStackBb,

            'board_texture' => $boardTexture,
            'range_advantage' => $rangeAdvantage,
            'nut_advantage' => $nutAdvantage,

            'actions' => $actions,
            'options' => $options,

            'table_players' => self::tablePlayers(
                heroPosition: $heroPosition,
                villainPosition: $villainPosition,
                effectiveStackBb: $effectiveStackBb
            ),

            'answers' => [
                'gto' => [
                    'correct_action' => $correctAction,
                    'explanation' => $explanation,
                    'solver_note' => $solverNote,
                    'action_grades' => $grades,
                ],
            ],

            'insights' => [
                'gto' => $gtoInsight,
                'low_stakes' => $lowStakesInsight,
            ],

            'confidence' => $confidence,
        ];
    }

    protected static function tablePlayers(
        string $heroPosition,
        string $villainPosition,
        float $effectiveStackBb = 100
    ): array {
        $positions = ['UTG', 'HJ', 'CO', 'BTN', 'SB', 'BB'];

        return array_map(function (string $position) use ($heroPosition, $villainPosition, $effectiveStackBb) {
            $isHero = $position === $heroPosition;
            $isVillain = $position === $villainPosition;

            return [
                'position' => $position,
                'name' => $isHero ? 'Hero' : ($isVillain ? 'Villain' : $position),
                'stack_bb' => $isHero || $isVillain ? $effectiveStackBb : 100,
                'is_hero' => $isHero,
                'is_villain' => $isVillain,
            ];
        }, $positions);
    }
}