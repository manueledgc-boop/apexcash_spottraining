<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class SbVsBtnSpots
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
            'module' => 'sb_vs_btn',
            'module_label' => 'SB vs BTN',
            'title' => 'SB enfrenta open BTN',
            'hero_position' => 'SB',
            'hero_cards' => $spot['cards'],
            'villain_position' => 'BTN',
            'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
            'pot_bb' => 4,
            'actions' => ['UTG folds', 'HJ folds', 'CO folds', 'BTN raises 2.5 BB', 'Action on Hero SB'],
            'options' => ['FOLD', 'CALL', '3BET'],
            'correct_action' => $best,
            'explanation' => $spot['why'],
            'solver_note' => "GTO simplificado: FOLD {$freq['FOLD']}%, CALL {$freq['CALL']}%, 3BET {$freq['3BET']}%.",
            'action_grades' => self::grades($best, $freq, $spot['ev'], $spot['feedback']),
            'table_players' => self::defaultPlayers('SB', 'BTN'),
        ];
    }

    protected static function grades(string $best, array $freq, array $ev, array $feedback): array
    {
        return [
            'FOLD' => ['grade' => $best === 'FOLD' ? 'best' : ($freq['FOLD'] >= 30 ? 'marginal' : 'mistake'), 'frequency' => $freq['FOLD'], 'ev_score' => $ev['FOLD'], 'feedback' => $feedback['FOLD']],
            'CALL' => ['grade' => $best === 'CALL' ? 'best' : ($freq['CALL'] >= 18 ? 'marginal' : 'mistake'), 'frequency' => $freq['CALL'], 'ev_score' => $ev['CALL'], 'feedback' => $feedback['CALL']],
            '3BET' => ['grade' => $best === '3BET' ? 'best' : ($freq['3BET'] >= 20 ? 'good' : 'mistake'), 'frequency' => $freq['3BET'], 'ev_score' => $ev['3BET'], 'feedback' => $feedback['3BET']],
        ];
    }

    protected static function spots(): array
    {
        return [
            self::spot(['As','Jd'], '3BET', [12,6,82], 'AJo desde SB contra BTN es 3Bet claro por valor/protección. Call OOP es mala costumbre.'),
            self::spot(['Ah','5h'], '3BET', [16,8,76], 'A5s es candidato premium de 3Bet bluff: blocker al As y buena equity suited.'),
            self::spot(['Kc','Qs'], '3BET', [22,8,70], 'KQo suele funcionar mejor como 3Bet lineal que pagando fuera de posición.'),
            self::spot(['Qh','Ts'], '3BET', [34,12,54], 'QTs puede 3betear como semi-bluff con jugabilidad, aunque no debe defenderse siempre.'),
            self::spot(['Jh','9h'], '3BET', [38,14,48], 'J9s puede entrar como 3Bet selectivo contra BTN amplio, pero es borde inferior.'),
            self::spot(['Ad','8c'], 'FOLD', [62,6,32], 'A8o está dominada a menudo y realiza mal equity OOP. 3Betearla siempre crea problemas.'),
            self::spot(['Ac','4c'], '3BET', [18,10,72], 'A4s combina blocker y suitedness; excelente 3Bet bluff desde SB.'),
            self::spot(['Kd','9d'], '3BET', [30,12,58], 'K9s tiene blocker, equity y suficiente jugabilidad para entrar en 3Bet contra BTN.'),
            self::spot(['Qd','8d'], 'FOLD', [56,18,26], 'Q8s es atractiva visualmente, pero como defensa SB vs BTN sigue siendo demasiado débil como estándar.'),
            self::spot(['Tc','9c'], '3BET', [36,18,46], 'T9s puede mezclarse como 3Bet por jugabilidad, aunque no es defensa obligatoria.'),
            self::spot(['7h','7d'], '3BET', [18,18,64], '77 puede 3betear por valor/protección contra BTN amplio; pagar SB no es ideal.'),
            self::spot(['4s','4c'], 'FOLD', [58,26,16], '44 desde SB contra BTN sufre mucho OOP sin iniciativa. Setminear aquí no imprime dinero.'),
            self::spot(['Ah','Qo'], '3BET', [6,8,86], 'AQo es 3Bet de valor claro contra BTN open. Foldear sería un blunder.'),
            self::spot(['Ks','Js'], '3BET', [16,16,68], 'KJs suited puede 3betear por valor fino y blockers; call existe, pero OOP es inferior.'),
            self::spot(['Qc','Jo'], 'FOLD', [52,12,36], 'QJo offsuit está dominada y juega mal OOP. 3Bet solo contra BTN muy loose.'),
            self::spot(['Jc','To'], 'FOLD', [60,12,28], 'JTo offsuit no tiene suficiente blocker ni jugabilidad para defenderse mucho desde SB.'),
            self::spot(['As','Ts'], '3BET', [8,10,82], 'ATs es 3Bet muy rentable contra BTN por valor, blocker y jugabilidad.'),
            self::spot(['Kh','5h'], '3BET', [34,14,52], 'K5s es buen 3Bet bluff selectivo por blocker al Rey y suitedness.'),
            self::spot(['9s','8s'], 'FOLD', [48,28,24], '98s juega bonito, pero desde SB sin posición no puede defenderse tan alegremente.'),
            self::spot(['Ac','2d'], 'FOLD', [66,4,30], 'A2o tiene blocker, pero muy mala jugabilidad. No es defensa automática desde SB.'),
            self::spot(['Td','8d'], 'FOLD', [54,22,24], 'T8s queda por debajo del umbral estándar desde SB contra BTN.'),
            self::spot(['Ad','Kd'], '3BET', [0,4,96], 'AKs es 3Bet obligatoria de valor. Pagar pierde demasiado EV.'),
            self::spot(['Qs','5s'], 'FOLD', [58,16,26], 'Q5s no tiene suficiente fuerza ni blocker premium para defenderse siempre.'),
            self::spot(['6c','5c'], 'FOLD', [64,20,16], '65s desde SB realiza mal equity OOP y no bloquea manos fuertes.'),
            self::spot(['2h','2d'], 'FOLD', [62,24,14], '22 no debe pagarse por setmine desde SB con tanta frecuencia. Sin posición pierde mucho valor.'),
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
                'FOLD' => $best === 'FOLD' ? 'Correcto. Desde SB no queremos defender manos que realizan mal equity fuera de posición.' : 'Demasiado tight. Esta mano tiene suficiente valor para defender agresivamente.',
                'CALL' => $best === 'CALL' ? 'Aceptable, pero recuerda que SB debe pagar poco.' : 'Pagar desde SB suele ser la línea más débil: juegas OOP y dejas entrar a BB.',
                '3BET' => $best === '3BET' ? 'Correcto. En SB preferimos estrategia agresiva: 3Bet o fold.' : 'Demasiado agresivo como estándar para esta mano concreta.',
            ],
        ];
    }

    protected static function evFor(string $best, array $freq): array
    {
        $ev = [];
        foreach (['FOLD', 'CALL', '3BET'] as $action) {
            $ev[$action] = $action === $best ? 100 : max(5, min(86, $freq[$action] + 15));
        }

        return $ev;
    }
}
