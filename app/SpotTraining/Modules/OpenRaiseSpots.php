<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class OpenRaiseSpots
{
    use BuildsSpotPlayers;

    public static function all(): array
    {
        return [
            self::utgAJo(), self::utgQ9s(), self::utgATs(), self::utgKQo(), self::utgJ9s(),
            self::hjKJs(), self::hjA9s(), self::hjQTo(), self::hjPocket66(), self::hjT8s(),
            self::coKQs(), self::coA8o(), self::coQ9s(), self::coPocket22(), self::coJ7s(),
            self::btnJ8s(), self::btnK5s(), self::btnQ4o(), self::btnT7s(), self::btnA2o(),
            self::sbA7s(), self::sbK9o(), self::sbQ5s(), self::sbJ4o(), self::sb72o(),
        ];
    }

    protected static function base(
        string $title,
        string $heroPosition,
        array $heroCards,
        array $actions,
        string $correctAction,
        string $explanation,
        string $solverNote,
        array $actionGrades,
        string $family,
        string $familyLabel,
        string $concept,
        string $conceptLabel
    ): array{
        return [
            'id' => self::spotId($heroPosition, $heroCards),
            'module' => 'open_raise',
            'module_label' => 'Open Raise',
            'family' => $family,
            'family_label' => $familyLabel,
            'concept' => $concept,
'concept_label' => $conceptLabel,
            'title' => $title,
            'hero_position' => $heroPosition,
            'hero_cards' => $heroCards,
            'villain_position' => null,
            'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
            'pot_bb' => 1.5,
            'actions' => $actions,
            'options' => ['FOLD', 'CALL', 'RAISE'],
            'correct_action' => $correctAction,
            'explanation' => $explanation,
            'solver_note' => $solverNote,
            'action_grades' => $actionGrades,
            'answers' => [
                'gto' => [
                    'correct_action' => $correctAction,
                    'explanation' => $explanation,
                    'solver_note' => $solverNote,
                    'action_grades' => $actionGrades,
                ],
            ],
            'confidence' => self::confidenceFromGrades($actionGrades),
            'table_players' => self::defaultPlayers($heroPosition, null),
        ];
    }

    protected static function openSpot(
        string $pos,
        array $cards,
        string $correct,
        int $raiseFreq,
        int $foldFreq,
        string $why,
        string $concept,
        string $conceptLabel
    ): array {
        $actions = match ($pos) {
            'UTG' => ['Action on Hero UTG'],
            'HJ' => ['UTG folds', 'Action on Hero HJ'],
            'CO' => ['UTG folds', 'HJ folds', 'Action on Hero CO'],
            'BTN' => ['UTG folds', 'HJ folds', 'CO folds', 'Action on Hero BTN'],
            'SB' => ['UTG folds', 'HJ folds', 'CO folds', 'BTN folds', 'Action on Hero SB'],
            default => ['Action on Hero'],
        };

        $family = match ($pos) {
            'UTG', 'HJ' => 'early_position_open',
            'CO', 'BTN' => 'late_position_open',
            'SB' => 'sb_open',
            default => 'open_raise',
        };

        $familyLabel = match ($pos) {
            'UTG', 'HJ' => 'Open Raise Early Position',
            'CO', 'BTN' => 'Open Raise Late Position',
            'SB' => 'SB Open Raise',
            default => 'Open Raise',
        };

        $isRaise = $correct === 'RAISE';

        return self::base(
            "Open raise desde {$pos}",
            $pos,
            $cards,
            $actions,
            $correct,
            $why,
            "GTO simplificado: RAISE {$raiseFreq}%, FOLD {$foldFreq}%, CALL 0%.",
            [
                'RAISE' => [
                    'grade' => $isRaise ? 'best' : ($raiseFreq >= 15 ? 'marginal' : 'mistake'),
                    'frequency' => $raiseFreq,
                    'ev_score' => $isRaise ? 100 : max(10, min(70, $raiseFreq)),
                    'feedback' => $isRaise
                        ? 'Correcto. Esta mano pertenece al rango de apertura de esta posición.'
                        : 'Demasiado loose como estrategia base para esta posición.',
                ],
                'FOLD' => [
                    'grade' => ! $isRaise ? 'best' : ($foldFreq >= 25 ? 'marginal' : 'blunder'),
                    'frequency' => $foldFreq,
                    'ev_score' => ! $isRaise ? 100 : max(0, min(75, $foldFreq)),
                    'feedback' => ! $isRaise
                        ? 'Correcto. Esta mano no tiene suficiente EV para abrir desde esta posición.'
                        : 'Demasiado tight. Estás dejando pasar una apertura rentable.',
                ],
                'CALL' => [
                    'grade' => 'blunder',
                    'frequency' => 0,
                    'ev_score' => 0,
                    'feedback' => 'Open limp no forma parte de la estrategia base de cash 6-max. Si la acción llega limpia: raise o fold.',
                ],
            ],
            $family,
            $familyLabel,
            $concept,
            $conceptLabel
        );
    }
    protected static function utgAJo(): array { return self::openSpot('UTG', ['Ah','Jd'], 'RAISE', 88, 12, 'AJo es apertura estándar UTG en 6-max, aunque cerca del borde inferior.', 'ax_offsuit', 'Ases offsuit'); }
    protected static function utgQ9s(): array { return self::openSpot('UTG', ['Qd','9d'], 'FOLD', 4, 96, 'Q9s es demasiado loose UTG; queda dominada con frecuencia.', 'suited_connectors', 'Suited connectors'); }
    protected static function utgATs(): array { return self::openSpot('UTG', ['As','Ts'], 'RAISE', 96, 4, 'ATs tiene blockers, jugabilidad suited y suficiente fuerza para abrir UTG.', 'ax_suited', 'Ases suited'); }
    protected static function utgKQo(): array { return self::openSpot('UTG', ['Kh','Qc'], 'RAISE', 82, 18, 'KQo es apertura UTG frecuente en 6-max, aunque sensible a mesas muy agresivas.', 'broadway_premium', 'Broadways premium'); }
    protected static function utgJ9s(): array { return self::openSpot('UTG', ['Jh','9h'], 'FOLD', 10, 90, 'J9s es demasiado loose UTG como base; demasiados jugadores quedan por hablar.', 'suited_connectors', 'Suited connectors'); }

    protected static function hjKJs(): array { return self::openSpot('HJ', ['Ks','Js'], 'RAISE', 98, 2, 'KJs es open claro desde HJ: suited broadway fuerte y jugable.', 'broadway_premium', 'Broadways premium'); }
    protected static function hjA9s(): array { return self::openSpot('HJ', ['Ac','9c'], 'RAISE', 86, 14, 'A9s entra en el rango HJ por blocker y jugabilidad suited.', 'ax_suited', 'Ases suited'); }
    protected static function hjQTo(): array { return self::openSpot('HJ', ['Qh','Td'], 'FOLD', 18, 82, 'QTo offsuit es floja desde HJ; se domina con facilidad.', 'broadway_weak', 'Broadways debiles'); }
    protected static function hjPocket66(): array { return self::openSpot('HJ', ['6c','6d'], 'RAISE', 94, 6, '66 es apertura estándar desde HJ con valor de set y showdown.', 'small_pairs', 'Pocket pairs bajos'); }
    protected static function hjT8s(): array { return self::openSpot('HJ', ['Ts','8s'], 'FOLD', 22, 78, 'T8s es atractiva, pero HJ sigue siendo demasiado temprano para abrirla siempre.', 'suited_connectors', 'Suited connectors'); }

    protected static function coKQs(): array { return self::openSpot('CO', ['Kh','Qh'], 'RAISE', 100, 0, 'KQs es open obligatorio desde CO.', 'broadway_premium', 'Broadways premium'); }
    protected static function coA8o(): array { return self::openSpot('CO', ['Ah','8d'], 'FOLD', 35, 65, 'A8o es borderline; como base sólida CO no se abre siempre.', 'ax_offsuit', 'Ases offsuit'); }
    protected static function coQ9s(): array { return self::openSpot('CO', ['Qs','9s'], 'RAISE', 74, 26, 'Q9s empieza a ser rentable desde CO por posición y jugabilidad suited.', 'suited_connectors', 'Suited connectors'); }
    protected static function coPocket22(): array { return self::openSpot('CO', ['2c','2d'], 'RAISE', 88, 12, '22 puede abrirse CO por fold equity y set value.', 'small_pairs', 'Pocket pairs bajos'); }
    protected static function coJ7s(): array { return self::openSpot('CO', ['Jh','7h'], 'FOLD', 28, 72, 'J7s sigue siendo demasiado débil CO como base.', 'weak_suited', 'Suited debiles'); }

    protected static function btnJ8s(): array { return self::openSpot('BTN', ['Jh','8h'], 'RAISE', 86, 14, 'J8s es apertura rentable desde BTN por posición y jugabilidad.', 'suited_connectors', 'Suited connectors'); }
    protected static function btnK5s(): array { return self::openSpot('BTN', ['Ks','5s'], 'RAISE', 92, 8, 'K5s abre rentable BTN por blocker, posición y suitedness.', 'weak_suited', 'Suited debiles'); }
    protected static function btnQ4o(): array { return self::openSpot('BTN', ['Qh','4d'], 'FOLD', 32, 68, 'Q4o es demasiado débil incluso BTN como base sólida.', 'broadway_weak', 'Broadways debiles'); }
    protected static function btnT7s(): array { return self::openSpot('BTN', ['Tc','7c'], 'RAISE', 78, 22, 'T7s puede abrirse BTN por posición y jugabilidad suited.', 'suited_connectors', 'Suited connectors'); }
    protected static function btnA2o(): array { return self::openSpot('BTN', ['As','2d'], 'RAISE', 84, 16, 'A2o abre BTN por blocker al As y fold equity.', 'ax_offsuit', 'Ases offsuit'); }

    protected static function sbA7s(): array { return self::openSpot('SB', ['Ac','7c'], 'RAISE', 92, 8, 'A7s es open claro SB contra BB.', 'ax_suited', 'Ases suited'); }
    protected static function sbK9o(): array { return self::openSpot('SB', ['Kh','9d'], 'RAISE', 76, 24, 'K9o puede abrirse SB porque solo queda BB y tiene blocker/valor alto.', 'broadway_weak', 'Broadways debiles'); }
    protected static function sbQ5s(): array { return self::openSpot('SB', ['Qs','5s'], 'RAISE', 70, 30, 'Q5s puede abrirse SB por suitedness y fold equity.', 'weak_suited', 'Suited debiles'); }
    protected static function sbJ4o(): array { return self::openSpot('SB', ['Jh','4d'], 'FOLD', 35, 65, 'J4o es demasiado débil para abrir siempre desde SB.', 'broadway_weak', 'Broadways debiles'); }
    protected static function sb72o(): array { return self::openSpot('SB', ['7c','2d'], 'FOLD', 8, 92, '72o es fold claro incluso en SB.', 'trash_offsuit', 'Basura offsuit'); }

    protected static function spotId(string $position, array $cards): string
    {
        return 'open_raise_' . strtolower($position) . '_' . self::cardsKey($cards);
    }

    protected static function cardsKey(array $cards): string
    {
        return strtolower((string) preg_replace('/[^a-zA-Z0-9]+/', '', implode('', $cards)));
    }

    protected static function confidenceFromGrades(array $grades): int
    {
        $frequencies = array_map(fn (array $grade) => (int) ($grade['frequency'] ?? 0), $grades);

        return max(60, min(95, max($frequencies ?: [80])));
    }

}