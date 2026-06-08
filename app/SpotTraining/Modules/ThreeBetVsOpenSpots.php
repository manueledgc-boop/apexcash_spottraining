<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class ThreeBetVsOpenSpots
{
    use BuildsSpotPlayers;

    public static function all(): array
    {
        return array_map(fn (array $spot) => self::fromData($spot), self::spots());
    }

    protected static function fromData(array $spot): array
    {
        $hero = $spot['hero'];
        $villain = $spot['villain'];
        $best = $spot['best'];
        $freq = $spot['freq'];

        return [
            'id' => self::spotId($hero, $villain, $spot['cards']),
            'module' => 'threebet_vs_open',
            'module_label' => '3Bet vs Open',
            'title' => "{$hero} enfrenta open {$villain}",
            'hero_position' => $hero,
            'hero_cards' => $spot['cards'],
            'villain_position' => $villain,
            'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
            'pot_bb' => 4,
            'actions' => self::actionsFor($hero, $villain),
            'options' => ['FOLD', 'CALL', '3BET'],
            'correct_action' => $best,
            'explanation' => $spot['why'],
            'solver_note' => "GTO simplificado: FOLD {$freq['FOLD']}%, CALL {$freq['CALL']}%, 3BET {$freq['3BET']}%.",
            'action_grades' => self::grades($best, $freq, $spot['ev'], $spot['feedback']),
            'answers' => [
                'gto' => [
                    'correct_action' => $best,
                    'explanation' => $spot['why'],
                    'solver_note' => "GTO simplificado: FOLD {$freq['FOLD']}%, CALL {$freq['CALL']}%, 3BET {$freq['3BET']}%.",
                    'action_grades' => self::grades($best, $freq, $spot['ev'], $spot['feedback']),
                ],
            ],
            'confidence' => self::confidenceFromFrequency($freq),
            'table_players' => self::defaultPlayers($hero, $villain),
        ];
    }

    protected static function actionsFor(string $hero, string $villain): array
    {
        $positions = ['UTG', 'HJ', 'CO', 'BTN', 'SB', 'BB'];
        $actions = [];

        foreach ($positions as $position) {
            if ($position === $villain) {
                $actions[] = "{$villain} raises 2.5 BB";
                continue;
            }

            if ($position === $hero) {
                $actions[] = "Action on Hero {$hero}";
                break;
            }

            $actions[] = "{$position} folds";
        }

        return $actions;
    }

    protected static function grades(string $best, array $freq, array $ev, array $feedback): array
    {
        return [
            'FOLD' => [
                'grade' => $best === 'FOLD' ? 'best' : ($freq['FOLD'] >= 25 ? 'marginal' : 'mistake'),
                'frequency' => $freq['FOLD'],
                'ev_score' => $ev['FOLD'],
                'feedback' => $feedback['FOLD'],
            ],
            'CALL' => [
                'grade' => $best === 'CALL' ? 'best' : ($freq['CALL'] >= 25 ? 'good' : 'mistake'),
                'frequency' => $freq['CALL'],
                'ev_score' => $ev['CALL'],
                'feedback' => $feedback['CALL'],
            ],
            '3BET' => [
                'grade' => $best === '3BET' ? 'best' : ($freq['3BET'] >= 20 ? 'good' : 'mistake'),
                'frequency' => $freq['3BET'],
                'ev_score' => $ev['3BET'],
                'feedback' => $feedback['3BET'],
            ],
        ];
    }

    protected static function spots(): array
    {
        return [
            self::spot('SB', 'CO', ['Ah','5h'], '3BET', [18,8,74], 'A5s es excelente 3Bet bluff desde SB contra CO: bloquea Ax fuertes, tiene equity y juega mejor como raise/fold que pagando OOP.'),
            self::spot('SB', 'BTN', ['Ah','Jd'], '3BET', [12,6,82], 'AJo en SB contra BTN suele preferir 3Bet por valor/protección. Pagar OOP es problemático y permite a BB realizar equity.'),
            self::spot('BTN', 'CO', ['Ad','Qc'], '3BET', [2,30,68], 'AQo en BTN contra CO es una 3Bet muy rentable por valor y protección. Call también existe, pero 3Bet captura mucho EV.'),
            self::spot('BB', 'BTN', ['As','5s'], '3BET', [8,46,46], 'A5s en BB contra BTN puede pagar o 3betear. Como entrenamiento base es excelente 3Bet bluff por blocker al As y jugabilidad suited.'),
            self::spot('SB', 'CO', ['Kh','Qd'], '3BET', [30,8,62], 'KQo en SB contra CO suele preferir 3Bet antes que call. Tiene blockers y fuerza relativa, pero juega mal multiway/OOP si solo paga.'),
            self::spot('BTN', 'HJ', ['Jh','Th'], 'CALL', [8,64,28], 'JTs en BTN contra HJ open realiza muy bien equity en posición. Puede mezclarse como 3Bet, pero call es la línea principal.'),
            self::spot('CO', 'HJ', ['As','Qs'], '3BET', [0,28,72], 'AQs contra HJ es demasiado fuerte para foldear y gana mucho EV como 3Bet de valor/protección.'),
            self::spot('CO', 'HJ', ['9h','9d'], 'CALL', [8,70,22], '99 en CO contra HJ realiza bien equity pagando. 3Bet existe, pero call mantiene manos dominadas dentro.'),
            self::spot('BTN', 'UTG', ['Ac','Jd'], 'CALL', [28,58,14], 'AJo contra UTG no es 3Bet automática. En posición puede defender pagando; foldear contra nits no es horrible.'),
            self::spot('BTN', 'UTG', ['Ks','Qs'], 'CALL', [4,68,28], 'KQs tiene demasiada jugabilidad para foldear contra UTG. Call es estable; 3Bet puede mezclarse.'),
            self::spot('SB', 'HJ', ['Ad','5d'], '3BET', [24,8,68], 'A5s desde SB contra HJ funciona bien como 3Bet bluff por blocker y equity suited. Call OOP no debe ser rutina.'),
            self::spot('SB', 'UTG', ['Ah','Qo'], 'FOLD', [54,14,32], 'AQo desde SB contra UTG es incómoda: dominada con frecuencia y OOP. 3Bet puede existir, pero fold es una base prudente contra rango fuerte.'),
            self::spot('BB', 'CO', ['7s','6s'], 'CALL', [12,78,10], '76s en BB contra CO obtiene buen precio y realiza equity suficiente pagando. 3Bet es mezcla baja.'),
            self::spot('BB', 'BTN', ['Kc','To'], 'CALL', [20,68,12], 'KTo en BB contra BTN es defensa estándar por precio. No necesita convertirse en 3Bet frecuente.'),
            self::spot('BB', 'HJ', ['Qc','Jo'], 'FOLD', [62,28,10], 'QJo offsuit contra HJ queda dominada a menudo. Puede pagar contra tamaños pequeños, pero fold es la base segura.'),
            self::spot('CO', 'HJ', ['Ac','5c'], '3BET', [18,30,52], 'A5s CO vs HJ es buen 3Bet bluff selectivo: blocker al As y buena jugabilidad cuando recibe call.'),
            self::spot('BTN', 'CO', ['Tc','9c'], 'CALL', [8,74,18], 'T9s en BTN contra CO es defensa clara por posición y jugabilidad. 3Bet existe, pero call domina como base.'),
            self::spot('SB', 'BTN', ['Kc','9c'], '3BET', [32,10,58], 'K9s en SB contra BTN puede 3betear por blocker, suitedness y fold equity. Call OOP es inferior.'),
            self::spot('SB', 'BTN', ['Qh','To'], 'FOLD', [58,8,34], 'QTo offsuit desde SB contra BTN parece tentadora, pero paga mal y 3betearla demasiado abre fugas.'),
            self::spot('BB', 'SB', ['Ad','8d'], 'CALL', [6,78,16], 'A8s en BB contra SB es defensa fuerte. Call realiza bien equity IP; 3Bet es mezcla.'),
            self::spot('BB', 'SB', ['Ah','4h'], '3BET', [8,42,50], 'A4s BB vs SB es gran candidato a 3Bet bluff por blocker y jugabilidad. Call también es viable.'),
            self::spot('BTN', 'HJ', ['Kc','Jo'], 'FOLD', [52,36,12], 'KJo offsuit contra HJ se domina con frecuencia. Call puede ser marginal, pero fold evita spots difíciles.'),
            self::spot('CO', 'UTG', ['Qh','Qs'], '3BET', [0,32,68], 'QQ contra UTG es 3Bet clara por valor. Call puede proteger rango, pero foldear es imposible.'),
            self::spot('BTN', 'UTG', ['5s','5d'], 'CALL', [18,80,2], '55 en BTN contra UTG paga por set value y posición. 3Bet sin blockers no es atractiva.'),
            self::spot('SB', 'CO', ['Jc','Ts'], 'FOLD', [64,18,18], 'JTo offsuit desde SB contra CO es una defensa floja: dominación, mala realización OOP y poco blocker real.'),
        ];
    }

    protected static function spot(string $hero, string $villain, array $cards, string $best, array $freq, string $why): array
    {
        $freqMap = ['FOLD' => $freq[0], 'CALL' => $freq[1], '3BET' => $freq[2]];
        $ev = self::evFor($best, $freqMap);

        return [
            'hero' => $hero,
            'villain' => $villain,
            'cards' => $cards,
            'best' => $best,
            'freq' => $freqMap,
            'ev' => $ev,
            'why' => $why,
            'feedback' => [
                'FOLD' => $best === 'FOLD' ? 'Correcto. Esta mano no tiene suficiente EV como defensa agresiva o call estándar.' : 'Demasiado tight. Estás dejando pasar una defensa rentable.',
                'CALL' => $best === 'CALL' ? 'Correcto. La mano realiza bien equity pagando y no necesita convertirse siempre en 3Bet.' : 'Puede existir como mezcla, pero no es la línea principal en este spot.',
                '3BET' => $best === '3BET' ? 'Correcto. La mano captura más EV como 3Bet por valor, protección, blockers o fold equity.' : 'No es la línea principal. 3betear aquí puede inflar el bote con una mano que realiza mejor pagando o foldeando.',
            ],
        ];
    }

    protected static function evFor(string $best, array $freq): array
    {
        $ev = [];
        foreach (['FOLD', 'CALL', '3BET'] as $action) {
            $ev[$action] = $action === $best ? 100 : max(5, min(86, $freq[$action] + 18));
        }

        return $ev;
    }

    protected static function spotId(string $hero, string $villain, array $cards): string
    {
        return 'threebet_vs_open_' . strtolower($hero) . '_vs_' . strtolower($villain) . '_' . self::cardsKey($cards);
    }

    protected static function cardsKey(array $cards): string
    {
        return strtolower((string) preg_replace('/[^a-zA-Z0-9]+/', '', implode('', $cards)));
    }

    protected static function confidenceFromFrequency(array $frequency): int
    {
        return max(60, min(95, max(array_map('intval', $frequency ?: [80]))));
    }

}
