<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class BbVsSbSpots
{
    use BuildsSpotPlayers;

    public static function all(): array
    {
        return array_map(fn (array $spot) => self::fromData($spot), self::spots());
    }

    protected static function fromData(array $spot): array
    {
        $best = $spot['best'];
        $freq = $spot['freq'];

        return [
            'module' => 'bb_vs_sb',
            'module_label' => 'BB vs SB',
            'title' => 'BB enfrenta open SB',
            'hero_position' => 'BB',
            'hero_cards' => $spot['cards'],
            'villain_position' => 'SB',
            'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
            'pot_bb' => 4,
            'actions' => ['UTG folds', 'HJ folds', 'CO folds', 'BTN folds', 'SB raises 2.5 BB', 'Action on Hero BB'],
            'options' => ['FOLD', 'CALL', '3BET'],
            'correct_action' => $best,
            'explanation' => $spot['why'],
            'solver_note' => "GTO simplificado: FOLD {$freq['FOLD']}%, CALL {$freq['CALL']}%, 3BET {$freq['3BET']}%.",
            'action_grades' => self::grades($best, $freq, $spot['ev'], $spot['feedback']),
            'table_players' => self::defaultPlayers('BB', 'SB'),
        ];
    }

    protected static function grades(string $best, array $freq, array $ev, array $feedback): array
    {
        return [
            'FOLD' => ['grade' => $best === 'FOLD' ? 'best' : ($freq['FOLD'] >= 25 ? 'marginal' : 'mistake'), 'frequency' => $freq['FOLD'], 'ev_score' => $ev['FOLD'], 'feedback' => $feedback['FOLD']],
            'CALL' => ['grade' => $best === 'CALL' ? 'best' : ($freq['CALL'] >= 25 ? 'good' : 'mistake'), 'frequency' => $freq['CALL'], 'ev_score' => $ev['CALL'], 'feedback' => $feedback['CALL']],
            '3BET' => ['grade' => $best === '3BET' ? 'best' : ($freq['3BET'] >= 20 ? 'good' : 'mistake'), 'frequency' => $freq['3BET'], 'ev_score' => $ev['3BET'], 'feedback' => $feedback['3BET']],
        ];
    }

    protected static function spots(): array
    {
        return [
            self::spot(['Ah','8h'], 'CALL', [6,78,16], 'A8s defiende muy bien IP contra SB. Call realiza equity y mantiene dominadas dentro.'),
            self::spot(['As','4s'], '3BET', [8,42,50], 'A4s es excelente 3Bet bluff contra SB por blocker al As y equity suited.'),
            self::spot(['Kd','Qo'], 'CALL', [4,70,26], 'KQo es defensa fuerte IP. Call es estable; 3Bet puede mezclarse.'),
            self::spot(['Qc','7d'], 'CALL', [28,66,6], 'Q7o puede defender por precio contra SB, pero no es 3Bet natural.'),
            self::spot(['Jc','5c'], 'CALL', [24,68,8], 'J5s obtiene buen precio IP y puede realizar equity suficiente contra rango amplio de SB.'),
            self::spot(['9s','8s'], 'CALL', [4,82,14], '98s es defensa clara: posición, conectividad y buena realización de equity.'),
            self::spot(['7h','2d'], 'FOLD', [78,22,0], '72o sigue siendo basura incluso contra SB. No hay que defender todo por orgullo.'),
            self::spot(['Ac','Jo'], '3BET', [2,36,62], 'AJo puede 3betear por valor contra SB amplio y bloquea Ax fuertes.'),
            self::spot(['Kc','5c'], 'CALL', [16,70,14], 'K5s defiende bien por suitedness y blocker; call suele ser mejor que inflar el bote.'),
            self::spot(['Td','8d'], 'CALL', [12,78,10], 'T8s tiene jugabilidad suficiente IP contra SB.'),
            self::spot(['6c','5c'], 'CALL', [8,84,8], '65s defiende rentable IP por conectividad y implied odds.'),
            self::spot(['3h','3d'], 'CALL', [18,78,4], '33 puede pagar IP contra SB por precio y showdown/set value.'),
            self::spot(['Ah','Kd'], '3BET', [0,18,82], 'AKo es 3Bet de valor claro contra SB open. Call existe, pero 3Bet imprime más EV.'),
            self::spot(['Qs','Js'], 'CALL', [2,74,24], 'QJs es defensa premium IP. Call o 3Bet son buenas, pero call mantiene rango dominado de SB.'),
            self::spot(['Kh','9d'], 'CALL', [18,72,10], 'K9o puede defender IP contra SB, pero no debe 3betearse demasiado.'),
            self::spot(['Qh','3d'], 'FOLD', [58,40,2], 'Q3o está cerca, pero como base sólida no hace falta defenderla siempre.'),
            self::spot(['Jd','To'], 'CALL', [10,78,12], 'JTo juega suficientemente bien IP contra SB amplio.'),
            self::spot(['Ts','4s'], 'CALL', [28,66,6], 'T4s puede pagar por precio y suitedness, aunque es una defensa de borde.'),
            self::spot(['Ac','2d'], 'CALL', [22,66,12], 'A2o puede defender por blocker y posición contra SB, pero cuidado con dominación postflop.'),
            self::spot(['8h','6d'], 'FOLD', [56,42,2], '86o offsuit no realiza suficiente equity; no todo se defiende BB vs SB.'),
            self::spot(['Kc','Tc'], 'CALL', [2,72,26], 'KTs es defensa muy fuerte IP. 3Bet mezcla bien, call es estándar.'),
            self::spot(['Qd','9d'], 'CALL', [8,78,14], 'Q9s tiene suficiente jugabilidad para defender IP.'),
            self::spot(['5s','4s'], 'CALL', [18,76,6], '54s puede pagar por conectividad y posición.'),
            self::spot(['9c','2d'], 'FOLD', [72,28,0], '92o no tiene equity realizable suficiente. Fold claro.'),
            self::spot(['Ad','5d'], '3BET', [4,44,52], 'A5s puede pagar o 3betear, pero como 3Bet bluff captura mucho EV por blocker y equity.'),
        ];
    }

    protected static function spot(array $cards, string $best, array $freq, string $why): array
    {
        $freqMap = ['FOLD' => $freq[0], 'CALL' => $freq[1], '3BET' => $freq[2]];
        $ev = self::evFor($best, $freqMap);

        return [
            'cards' => $cards,
            'best' => $best,
            'freq' => $freqMap,
            'ev' => $ev,
            'why' => $why,
            'feedback' => [
                'FOLD' => $best === 'FOLD' ? 'Correcto. Aunque estás en BB, esta mano sigue siendo demasiado débil.' : 'Demasiado tight. En BB contra SB tienes posición y buen precio.',
                'CALL' => $best === 'CALL' ? 'Correcto. Contra SB defendemos mucho más porque jugamos en posición.' : 'Call no es la línea principal para esta mano concreta.',
                '3BET' => $best === '3BET' ? 'Correcto. Buen spot para castigar el rango amplio de SB.' : '3Bet demasiado ambiciosa como estándar aquí.',
            ],
        ];
    }

    protected static function evFor(string $best, array $freq): array
    {
        $ev = [];
        foreach (['FOLD', 'CALL', '3BET'] as $action) {
            $ev[$action] = $action === $best ? 100 : max(5, min(88, $freq[$action] + 16));
        }

        return $ev;
    }
}
