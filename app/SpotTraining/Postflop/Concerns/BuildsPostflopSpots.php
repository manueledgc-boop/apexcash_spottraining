<?php

namespace App\SpotTraining\Postflop\Concerns;
use App\SpotTraining\FlopSpotFamilyResolver;

trait BuildsPostflopSpots
{
    protected static function spot(
        string $id,
        string $module,
        string $moduleLabel,
        string $concept,
        string $conceptLabel,
        string $title,
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
        string $family = 'single_raised_pot',
        string $familyLabel = 'Single Raised Pot'
    ): array {
        return [
            'id' => $id,
            'module' => $module,
            'module_label' => $moduleLabel,
            'family' => $family,
            'family_label' => $familyLabel,
            'concept' => $concept,
            'concept_label' => $conceptLabel,
            'spot_family' => FlopSpotFamilyResolver::fromConcept($concept),
            'spot_family_label' => FlopSpotFamilyResolver::labelFromConcept($concept),
            'title' => $title,
            'street' => 'flop',
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
            'correct_action' => $correctAction,
            'explanation' => $explanation,
            'solver_note' => $solverNote,
            'action_grades' => $grades,
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
}
