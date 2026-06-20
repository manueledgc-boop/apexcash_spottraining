<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;
use App\SpotTraining\SpotFamilyResolver;

class OpenRaiseSpots
{
    use BuildsSpotPlayers;

    public static function all(): array
    {
        return [
            self::utgAJo(), self::utgQ9s(), self::utgATs(), self::utgKQo(), self::utgJ9s(),
            self::utgPocket99(), self::utgA5s(), self::utgKTs(), self::utgQJo(), self::utgPocket44(),

            self::hjKJs(), self::hjA9s(), self::hjQTo(), self::hjPocket66(), self::hjT8s(),
            self::hjAJo(), self::hjKTo(), self::hjQJs(), self::hjPocket33(), self::hjJ9s(),

            self::coKQs(), self::coA8o(), self::coQ9s(), self::coPocket22(), self::coJ7s(),
            self::coATo(), self::coK9s(), self::coT9s(), self::coA5s(), self::coK7o(),

            self::btnJ8s(), self::btnK5s(), self::btnQ4o(), self::btnT7s(), self::btnA2o(),
            self::btnQ8o(), self::btn98o(), self::btn76s(), self::btnK2o(), self::btn54s(),

            self::sbA7s(), self::sbK9o(), self::sbQ5s(), self::sbJ4o(), self::sb72o(),
            self::sbA2o(), self::sbT8o(), self::sb86s(), self::sbK3s(), self::sb94o(),
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
            'spot_family' => SpotFamilyResolver::fromConcept($concept),
            'spot_family_label' => SpotFamilyResolver::labelFromConcept($concept),
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
            'insights' => [
                'low_stakes' => self::lowStakesInsight($concept),
            ],
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

    protected static function utgPocket99(): array { return self::openSpot('UTG', ['9c','9d'], 'RAISE', 98, 2, '99 es apertura clara UTG en 6-max: tiene valor propio, puede ligar set y no necesita jugar como bluff.', 'small_pairs', 'Pocket pairs bajos'); }
    protected static function utgA5s(): array { return self::openSpot('UTG', ['As','5s'], 'RAISE', 74, 26, 'A5s puede abrirse UTG por blocker al As, jugabilidad suited y potencial de escalera baja.', 'ax_suited', 'Ases suited'); }
    protected static function utgKTs(): array { return self::openSpot('UTG', ['Kh','Th'], 'RAISE', 68, 32, 'KTs es una apertura UTG de borde: suited y conectada, pero hay que saber foldear top pair dominada.', 'broadway_premium', 'Broadways premium'); }
    protected static function utgQJo(): array { return self::openSpot('UTG', ['Qh','Jd'], 'FOLD', 30, 70, 'QJo offsuit es demasiado dominable UTG. Parece bonita, pero juega mal contra calls y 3bets.', 'broadway_weak', 'Broadways debiles'); }
    protected static function utgPocket44(): array { return self::openSpot('UTG', ['4c','4s'], 'RAISE', 62, 38, '44 se puede abrir UTG como parte baja del rango, pero no es una mano para enamorarse postflop sin set.', 'small_pairs', 'Pocket pairs bajos'); }

    protected static function hjKJs(): array { return self::openSpot('HJ', ['Ks','Js'], 'RAISE', 98, 2, 'KJs es open claro desde HJ: suited broadway fuerte y jugable.', 'broadway_premium', 'Broadways premium'); }
    protected static function hjA9s(): array { return self::openSpot('HJ', ['Ac','9c'], 'RAISE', 86, 14, 'A9s entra en el rango HJ por blocker y jugabilidad suited.', 'ax_suited', 'Ases suited'); }
    protected static function hjQTo(): array { return self::openSpot('HJ', ['Qh','Td'], 'FOLD', 18, 82, 'QTo offsuit es floja desde HJ; se domina con facilidad.', 'broadway_weak', 'Broadways debiles'); }
    protected static function hjPocket66(): array { return self::openSpot('HJ', ['6c','6d'], 'RAISE', 94, 6, '66 es apertura estándar desde HJ con valor de set y showdown.', 'small_pairs', 'Pocket pairs bajos'); }
    protected static function hjT8s(): array { return self::openSpot('HJ', ['Ts','8s'], 'FOLD', 22, 78, 'T8s es atractiva, pero HJ sigue siendo demasiado temprano para abrirla siempre.', 'suited_connectors', 'Suited connectors'); }

    protected static function hjAJo(): array { return self::openSpot('HJ', ['Ah','Jc'], 'RAISE', 94, 6, 'AJo gana bastante valor desde HJ. Bloquea Ax fuertes y suele dominar ases peores de recreacionales.', 'ax_offsuit', 'Ases offsuit'); }
    protected static function hjKTo(): array { return self::openSpot('HJ', ['Ks','Td'], 'FOLD', 28, 72, 'KTo offsuit sigue siendo demasiado floja desde HJ. Muchas veces ligas top pair con kicker dominado.', 'broadway_weak', 'Broadways debiles'); }
    protected static function hjQJs(): array { return self::openSpot('HJ', ['Qd','Jd'], 'RAISE', 90, 10, 'QJs es suited broadway muy jugable desde HJ: conecta boards fuertes y realiza bien su equity.', 'broadway_premium', 'Broadways premium'); }
    protected static function hjPocket33(): array { return self::openSpot('HJ', ['3h','3s'], 'RAISE', 72, 28, '33 puede abrirse desde HJ por set value y fold equity, pero no debe sobrejugarse sin ligar.', 'small_pairs', 'Pocket pairs bajos'); }
    protected static function hjJ9s(): array { return self::openSpot('HJ', ['Js','9s'], 'RAISE', 58, 42, 'J9s es una apertura de borde desde HJ. En mesas pasivas puede abrirse; contra agresivos conviene foldear más.', 'suited_connectors', 'Suited connectors'); }

    protected static function coKQs(): array { return self::openSpot('CO', ['Kh','Qh'], 'RAISE', 100, 0, 'KQs es open obligatorio desde CO.', 'broadway_premium', 'Broadways premium'); }
    protected static function coA8o(): array { return self::openSpot('CO', ['Ah','8d'], 'FOLD', 35, 65, 'A8o es borderline; como base sólida CO no se abre siempre.', 'ax_offsuit', 'Ases offsuit'); }
    protected static function coQ9s(): array { return self::openSpot('CO', ['Qs','9s'], 'RAISE', 74, 26, 'Q9s empieza a ser rentable desde CO por posición y jugabilidad suited.', 'suited_connectors', 'Suited connectors'); }
    protected static function coPocket22(): array { return self::openSpot('CO', ['2c','2d'], 'RAISE', 88, 12, '22 puede abrirse CO por fold equity y set value.', 'small_pairs', 'Pocket pairs bajos'); }
    protected static function coJ7s(): array { return self::openSpot('CO', ['Jh','7h'], 'FOLD', 28, 72, 'J7s sigue siendo demasiado débil CO como base.', 'weak_suited', 'Suited debiles'); }

    protected static function coATo(): array { return self::openSpot('CO', ['Ac','Td'], 'RAISE', 86, 14, 'ATo ya es apertura rentable desde CO: blocker al As, iniciativa y solo tres jugadores por detrás.', 'ax_offsuit', 'Ases offsuit'); }
    protected static function coK9s(): array { return self::openSpot('CO', ['Kh','9h'], 'RAISE', 72, 28, 'K9s puede abrirse CO por blocker y suitedness, pero no es una mano para pagar 3bets sin plan.', 'weak_suited', 'Suited debiles'); }
    protected static function coT9s(): array { return self::openSpot('CO', ['Tc','9c'], 'RAISE', 84, 16, 'T9s es muy buena apertura CO: conecta escaleras, colores y juega bien con posición relativa.', 'suited_connectors', 'Suited connectors'); }
    protected static function coA5s(): array { return self::openSpot('CO', ['Ad','5d'], 'RAISE', 96, 4, 'A5s es open claro CO por blocker, jugabilidad y potencial para seguir agrediendo en muchos boards.', 'ax_suited', 'Ases suited'); }
    protected static function coK7o(): array { return self::openSpot('CO', ['Ks','7d'], 'FOLD', 24, 76, 'K7o no tiene suficiente jugabilidad ni kicker para abrir CO como base sólida.', 'broadway_weak', 'Broadways debiles'); }

    protected static function btnJ8s(): array { return self::openSpot('BTN', ['Jh','8h'], 'RAISE', 86, 14, 'J8s es apertura rentable desde BTN por posición y jugabilidad.', 'suited_connectors', 'Suited connectors'); }
    protected static function btnK5s(): array { return self::openSpot('BTN', ['Ks','5s'], 'RAISE', 92, 8, 'K5s abre rentable BTN por blocker, posición y suitedness.', 'weak_suited', 'Suited debiles'); }
    protected static function btnQ4o(): array { return self::openSpot('BTN', ['Qh','4d'], 'FOLD', 32, 68, 'Q4o es demasiado débil incluso BTN como base sólida.', 'broadway_weak', 'Broadways debiles'); }
    protected static function btnT7s(): array { return self::openSpot('BTN', ['Tc','7c'], 'RAISE', 78, 22, 'T7s puede abrirse BTN por posición y jugabilidad suited.', 'suited_connectors', 'Suited connectors'); }
    protected static function btnA2o(): array { return self::openSpot('BTN', ['As','2d'], 'RAISE', 84, 16, 'A2o abre BTN por blocker al As y fold equity.', 'ax_offsuit', 'Ases offsuit'); }

    protected static function btnQ8o(): array { return self::openSpot('BTN', ['Qc','8d'], 'RAISE', 62, 38, 'Q8o es apertura BTN de borde, pero rentable si las ciegas foldean demasiado y no defienden agresivo.', 'broadway_weak', 'Broadways debiles'); }
    protected static function btn98o(): array { return self::openSpot('BTN', ['9h','8d'], 'FOLD', 38, 62, '98o parece conectada, pero offsuit realiza mal equity. Como base es mejor abrir suited y foldear esta.', 'trash_offsuit', 'Basura offsuit'); }
    protected static function btn76s(): array { return self::openSpot('BTN', ['7s','6s'], 'RAISE', 82, 18, '76s es open BTN rentable: posición, jugabilidad y capacidad de ligar boards ocultos.', 'suited_connectors', 'Suited connectors'); }
    protected static function btnK2o(): array { return self::openSpot('BTN', ['Kh','2d'], 'RAISE', 58, 42, 'K2o es una apertura BTN muy marginal. Se puede abrir contra ciegas tight, pero no contra rivales que 3betean mucho.', 'broadway_weak', 'Broadways debiles'); }
    protected static function btn54s(): array { return self::openSpot('BTN', ['5c','4c'], 'RAISE', 74, 26, '54s abre BTN por posición y jugabilidad. No gana por fuerza preflop, gana por realización y fold equity.', 'suited_connectors', 'Suited connectors'); }

    protected static function sbA7s(): array { return self::openSpot('SB', ['Ac','7c'], 'RAISE', 92, 8, 'A7s es open claro SB contra BB.', 'ax_suited', 'Ases suited'); }
    protected static function sbK9o(): array { return self::openSpot('SB', ['Kh','9d'], 'RAISE', 76, 24, 'K9o puede abrirse SB porque solo queda BB y tiene blocker/valor alto.', 'broadway_weak', 'Broadways debiles'); }
    protected static function sbQ5s(): array { return self::openSpot('SB', ['Qs','5s'], 'RAISE', 70, 30, 'Q5s puede abrirse SB por suitedness y fold equity.', 'weak_suited', 'Suited debiles'); }
    protected static function sbJ4o(): array { return self::openSpot('SB', ['Jh','4d'], 'FOLD', 35, 65, 'J4o es demasiado débil para abrir siempre desde SB.', 'broadway_weak', 'Broadways debiles'); }
    protected static function sb72o(): array { return self::openSpot('SB', ['7c','2d'], 'FOLD', 8, 92, '72o es fold claro incluso en SB.', 'trash_offsuit', 'Basura offsuit'); }

    protected static function sbA2o(): array { return self::openSpot('SB', ['Ah','2d'], 'RAISE', 68, 32, 'A2o puede abrirse SB por blocker al As, pero su kicker bajo exige disciplina postflop.', 'ax_offsuit', 'Ases offsuit'); }
    protected static function sbT8o(): array { return self::openSpot('SB', ['Th','8d'], 'RAISE', 54, 46, 'T8o es apertura SB de borde. Contra BB pasiva imprime, contra BB agresiva pierde valor rápido.', 'trash_offsuit', 'Basura offsuit'); }
    protected static function sb86s(): array { return self::openSpot('SB', ['8c','6c'], 'RAISE', 76, 24, '86s puede abrirse SB por suitedness y conectividad. Tiene suficiente jugabilidad contra una sola ciega.', 'suited_connectors', 'Suited connectors'); }
    protected static function sbK3s(): array { return self::openSpot('SB', ['Kd','3d'], 'RAISE', 80, 20, 'K3s abre SB por blocker y suitedness. Es mejor raise/fold que completar sin iniciativa.', 'weak_suited', 'Suited debiles'); }
    protected static function sb94o(): array { return self::openSpot('SB', ['9h','4d'], 'FOLD', 26, 74, '94o sigue siendo demasiado mala incluso SB. Abrir basura offsuit sin jugabilidad crea problemas postflop.', 'trash_offsuit', 'Basura offsuit'); }

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

    protected static function lowStakesInsight(string $concept): string
    {
        return match ($concept) {

            'ax_suited' =>
                'Los Ax suited son muy rentables en NL2-NL10 porque pueden ganar botes grandes cuando ligan color y además bloquean manos premium. Son aperturas muy cómodas desde casi todas las posiciones adecuadas.',

            'ax_offsuit' =>
                'Los Ax offsuit aumentan mucho de valor en posiciones tardías. En posiciones tempranas hay que ser más selectivo porque pueden quedar dominados con facilidad.',

            'broadway_premium' =>
                'Las broadways fuertes suelen imprimir dinero en NL2-NL10 porque los rivales pagan demasiado con manos peores. Abrirlas agresivamente suele ser la mejor estrategia.',

            'broadway_weak' =>
                'Las broadways débiles parecen mejores de lo que realmente son. Muchas generan top pair dominadas y problemas postflop. No las abras demasiado desde posiciones tempranas.',

            'small_pairs' =>
                'Las parejas pequeñas funcionan muy bien en NL2-NL10 porque muchos rivales pagan demasiado cuando conectas set. Además generan folds preflop suficientes para ser aperturas rentables.',

            'suited_connectors' =>
                'Los suited connectors ganan valor porque los rivales suelen cometer errores postflop. Su rentabilidad aumenta mucho cuando tienes posición.',

            'weak_suited' =>
                'Las manos suited débiles pueden abrirse desde posiciones tardías, pero no deben sobrevalorarse. El hecho de ser suited no convierte automáticamente una mano mediocre en una buena apertura.',

            'trash_offsuit' =>
                'Uno de los errores más comunes en micro límites es abrir demasiada basura porque solo quedan pocos jugadores por hablar. Algunas manos siguen siendo folds claros incluso desde posiciones tardías.',

            default =>
                'En NL2-NL10 suele ser más rentable abrir rangos sólidos y aprovechar errores postflop que intentar abrir demasiadas manos marginales.'
        };
    }

}