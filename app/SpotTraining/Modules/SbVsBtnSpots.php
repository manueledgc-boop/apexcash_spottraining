<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;
use App\SpotTraining\SpotFamilyResolver;

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
            'id' => self::spotId($spot['cards']),
            'module' => 'sb_vs_btn',
            'module_label' => 'SB vs BTN',

            'family' => $spot['family'],
            'family_label' => $spot['family_label'],
            'concept' => $spot['concept'],
            'concept_label' => $spot['concept_label'],
            'spot_family' => SpotFamilyResolver::fromConcept($spot['concept']),
            'spot_family_label' => SpotFamilyResolver::labelFromConcept($spot['concept']),

            'title' => 'SB enfrenta open BTN',
            'hero_position' => 'SB',
            'hero_cards' => $spot['cards'],
            'villain_position' => 'BTN',
            'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
            'pot_bb' => 4,
            'actions' => [
                'UTG folds',
                'HJ folds',
                'CO folds',
                'BTN raises 2.5 BB',
                'Action on Hero SB',
            ],
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
            'insights' => [
                    'low_stakes' => self::lowStakesInsight($spot['concept']),
                ],
            'table_players' => self::defaultPlayers('SB', 'BTN'),
        ];
    }

    protected static function grades(string $best, array $freq, array $ev, array $feedback): array
    {
        return [
            'FOLD' => [
                'grade' => $best === 'FOLD' ? 'best' : ($freq['FOLD'] >= 30 ? 'marginal' : 'mistake'),
                'frequency' => $freq['FOLD'],
                'ev_score' => $ev['FOLD'],
                'feedback' => $feedback['FOLD'],
            ],
            'CALL' => [
                'grade' => $best === 'CALL' ? 'best' : ($freq['CALL'] >= 18 ? 'marginal' : 'mistake'),
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
            self::spot(['As','Jd'], '3BET', [12,6,82], 'AJo desde SB contra BTN es 3Bet claro por valor/protección. Call OOP es mala costumbre.', 'value_3bet', '3Bet por valor'),
            self::spot(['Ah','5h'], '3BET', [16,8,76], 'A5s es candidato premium de 3Bet bluff: blocker al As y buena equity suited.', 'ax_bluff_3bet', '3Bet bluff con Ax suited'),
            self::spot(['Kc','Qs'], '3BET', [22,8,70], 'KQo suele funcionar mejor como 3Bet lineal que pagando fuera de posición.', 'value_3bet', '3Bet por valor'),
            self::spot(['Qh','Ts'], '3BET', [34,12,54], 'Las broadways suited de fuerza media pueden combinarse entre fold y 3Bet dependiendo de las posiciones, los rangos involucrados y la estrategia utilizada. Su valor proviene de sus blockers, su buena jugabilidad postflop y su capacidad para generar fold equity antes del flop.', 'semi_bluff_suited', 'Suited semi-bluffs'),
            self::spot(['Jh','9h'], '3BET', [38,14,48], 'J9s puede entrar como 3Bet selectivo contra BTN amplio, pero es borde inferior.', 'semi_bluff_suited', 'Suited semi-bluffs'),

            self::spot(['Ad','8c'], 'FOLD', [62,6,32], 'A8o está dominada a menudo y realiza mal equity OOP. 3Betearla siempre crea problemas.', 'dominated_offsuit', 'Offsuit dominadas'),
            self::spot(['Ac','4c'], '3BET', [18,10,72], 'A4s combina blocker y suitedness; excelente 3Bet bluff desde SB.', 'ax_bluff_3bet', '3Bet bluff con Ax suited'),
            self::spot(['Kd','9d'], '3BET', [30,12,58], 'K9s tiene blocker, equity y suficiente jugabilidad para entrar en 3Bet contra BTN.', 'kx_bluff_3bet', '3Bet bluff con Kx suited'),
            self::spot(['Qd','8d'], 'FOLD', [56,18,26], 'Q8s es atractiva visualmente, pero como defensa SB vs BTN sigue siendo demasiado débil como estándar.', 'weak_suited_hands', 'Suited débiles'),
            self::spot(['Tc','9c'], '3BET', [36,18,46], 'T9s puede mezclarse como 3Bet por jugabilidad, aunque no es defensa obligatoria.', 'semi_bluff_suited', 'Suited semi-bluffs'),

            self::spot(['7h','7d'], '3BET', [18,18,64], '77 puede 3betear por valor/protección contra BTN amplio; pagar SB no es ideal.', 'value_3bet', '3Bet por valor'),
            self::spot(['4s','4c'], 'FOLD', [58,26,16], '44 desde SB contra BTN sufre mucho OOP sin iniciativa. Setminear aquí no imprime dinero.', 'small_pairs_oop', 'Pocket pairs pequeños OOP'),
            self::spot(['Ah','Qo'], '3BET', [6,8,86], 'AQo es 3Bet de valor claro contra BTN open. Foldear sería un blunder.', 'value_3bet', '3Bet por valor'),
            self::spot(['Ks','Js'], '3BET', [16,16,68], 'KJs suited puede 3betear por valor fino y blockers; call existe, pero OOP es inferior.', 'value_3bet', '3Bet por valor'),
            self::spot(['Qc','Jo'], 'FOLD', [52,12,36], 'QJo offsuit está dominada y juega mal OOP. 3Bet solo contra BTN muy loose.', 'dominated_offsuit', 'Offsuit dominadas'),

            self::spot(['Jc','To'], 'FOLD', [60,12,28], 'JTo offsuit no tiene suficiente blocker ni jugabilidad para defenderse mucho desde SB.', 'dominated_offsuit', 'Offsuit dominadas'),
            self::spot(['As','Ts'], '3BET', [8,10,82], 'ATs es 3Bet muy rentable contra BTN por valor, blocker y jugabilidad.', 'value_3bet', '3Bet por valor'),
            self::spot(['Kh','5h'], '3BET', [34,14,52], 'K5s es buen 3Bet bluff selectivo por blocker al Rey y suitedness.', 'kx_bluff_3bet', '3Bet bluff con Kx suited'),
            self::spot(['9s','8s'], 'FOLD', [48,28,24], '98s juega bonito, pero desde SB sin posición no puede defenderse tan alegremente.', 'weak_suited_hands', 'Suited débiles'),
            self::spot(['Ac','2d'], 'FOLD', [66,4,30], 'A2o tiene blocker, pero muy mala jugabilidad. No es defensa automática desde SB.', 'dominated_offsuit', 'Offsuit dominadas'),

            self::spot(['Td','8d'], 'FOLD', [54,22,24], 'T8s queda por debajo del umbral estándar desde SB contra BTN.', 'weak_suited_hands', 'Suited débiles'),
            self::spot(['Ad','Kd'], '3BET', [0,4,96], 'AKs es 3Bet obligatoria de valor. Pagar pierde demasiado EV.', 'value_3bet', '3Bet por valor'),
            self::spot(['Qs','5s'], 'FOLD', [58,16,26], 'Q5s no tiene suficiente fuerza ni blocker premium para defenderse siempre.', 'weak_suited_hands', 'Suited débiles'),
            self::spot(['6c','5c'], 'FOLD', [64,20,16], '65s desde SB realiza mal equity OOP y no bloquea manos fuertes.', 'weak_suited_hands', 'Suited débiles'),
            self::spot(['2h','2d'], 'FOLD', [62,24,14], '22 no debe pagarse por setmine desde SB con tanta frecuencia. Sin posición pierde mucho valor.', 'small_pairs_oop', 'Pocket pairs pequeños OOP'),

            self::spot(['Ah','Ks'], '3BET', [0,3,97], 'AKo es 3Bet de valor puro contra BTN. En SB no queremos pagar y jugar un bote multiway con BB entrando barato.', 'value_3bet', '3Bet por valor'),
            self::spot(['Qh','Qd'], '3BET', [0,2,98], 'QQ debe 3betear casi siempre. Pagar desde SB pierde valor, permite entrada de BB y oculta menos de lo que parece.', 'value_3bet', '3Bet por valor'),
            self::spot(['Jd','Jc'], '3BET', [2,8,90], 'JJ domina mucho del rango de open de BTN y necesita protección. Es 3Bet claro, no trampa pasiva.', 'value_3bet', '3Bet por valor'),
            self::spot(['9h','9c'], '3BET', [12,18,70], '99 contra BTN amplio es suficientemente fuerte para 3Betear por valor/protección desde SB.', 'value_3bet', '3Bet por valor'),
            self::spot(['6s','6d'], 'FOLD', [46,30,24], '66 es el borde incómodo: pagar OOP no imprime dinero y 3Betearlo siempre sobreexpone una mano difícil postflop.', 'small_pairs_oop', 'Pocket pairs pequeños OOP'),

            self::spot(['Ad','3d'], '3BET', [20,8,72], 'A3s es buen 3Bet bluff: bloquea Ax fuertes y conserva equity cuando BTN paga. Mejor agresivo que call OOP.', 'ax_bluff_3bet', '3Bet bluff con Ax suited'),
            self::spot(['As','9s'], '3BET', [18,12,70], 'A9s puede 3betear de forma lineal contra BTN amplio. Tiene blocker, equity y domina varios Ax peores.', 'ax_bluff_3bet', '3Bet bluff con Ax suited'),
            self::spot(['Ac','7c'], '3BET', [24,10,66], 'A7s es defensa agresiva razonable: blocker al As y jugabilidad suficiente. Call desde SB debe ser poco frecuente.', 'ax_bluff_3bet', '3Bet bluff con Ax suited'),
            self::spot(['Ah','2h'], '3BET', [28,8,64], 'A2s es el Ax suited más bajo, pero sigue funcionando como 3Bet bluff por blocker y potencial de color/rueda.', 'ax_bluff_3bet', '3Bet bluff con Ax suited'),
            self::spot(['As','6d'], 'FOLD', [60,5,35], 'A6o tiene blocker, pero está demasiado dominada y juega mal postflop. No conviertas cualquier As en 3Bet.', 'dominated_offsuit', 'Offsuit dominadas'),

            self::spot(['Kd','Td'], '3BET', [18,16,66], 'KTs combina blocker, equity y buena jugabilidad. Contra BTN amplio es una 3Bet muy educativa desde SB.', 'kx_bluff_3bet', '3Bet bluff con Kx suited'),
            self::spot(['Kh','8h'], '3BET', [34,14,52], 'K8s puede entrar como 3Bet bluff selectivo. No es valor puro: depende de que BTN abra amplio y foldee algo.', 'kx_bluff_3bet', '3Bet bluff con Kx suited'),
            self::spot(['Ks','4s'], 'FOLD', [50,14,36], 'K4s bloquea algo, pero la jugabilidad es baja. En micro-límites es fácil pasarse de agresivo con estos Kxs débiles.', 'kx_bluff_3bet', '3Bet bluff con Kx suited'),
            self::spot(['Kc','Jo'], 'FOLD', [48,10,42], 'KJo offsuit parece fuerte, pero OOP se domina mucho contra continuaciones. 3Bet solo contra BTN muy amplio y fold frecuente.', 'dominated_offsuit', 'Offsuit dominadas'),
            self::spot(['Kh','Qh'], '3BET', [10,16,74], 'KQs es demasiado fuerte para jugar pasivo desde SB. 3Bet construye valor y evita que BB realice equity gratis.', 'value_3bet', '3Bet por valor'),

            self::spot(['Qh','Jh'], '3BET', [26,20,54], 'QJs es suited broadway con buena equity. Puede mezclarse, pero la línea agresiva simplifica mucho el spot OOP.', 'semi_bluff_suited', 'Suited semi-bluffs'),
            self::spot(['Qc','Tc'], '3BET', [30,18,52], 'QTs tiene conectividad y suitedness suficientes para 3Bet selectivo, especialmente contra opens BTN demasiado amplios.', 'semi_bluff_suited', 'Suited semi-bluffs'),
            self::spot(['Js','Ts'], '3BET', [32,22,46], 'JTs es una de las suited connectors que mejor realiza equity. Aun así, desde SB no debe convertirse en call automático.', 'semi_bluff_suited', 'Suited semi-bluffs'),
            self::spot(['8c','7c'], 'FOLD', [56,26,18], '87s juega bonito en posición, pero desde SB pierde mucho EV. Sin blocker premium, no hace falta defenderla siempre.', 'weak_suited_hands', 'Suited débiles'),
            self::spot(['5h','4h'], 'FOLD', [68,20,12], '54s es demasiado baja para defender estándar desde SB. La fantasía de ligar escalera no compensa jugar OOP sin iniciativa.', 'weak_suited_hands', 'Suited débiles'),

            self::spot(['Ad','Qd'], '3BET', [2,6,92], 'AQs es 3Bet por valor muy claro. Domina Ax y broadways peores del BTN y realiza excelente equity.', 'value_3bet', '3Bet por valor'),
            self::spot(['Ah','Td'], '3BET', [18,8,74], 'ATo contra BTN amplio puede 3betear por valor fino y blocker. Pagar OOP suele ser peor que tomar iniciativa.', 'value_3bet', '3Bet por valor'),
            self::spot(['Qc','9c'], 'FOLD', [48,24,28], 'Q9s está cerca, pero en SB se mete en muchos top pairs dominados. Como estándar educativo, fold es más limpio.', 'weak_suited_hands', 'Suited débiles'),
            self::spot(['Jd','8d'], 'FOLD', [58,20,22], 'J8s no bloquea suficiente y realiza mal equity. No confundas suited con defendible.', 'weak_suited_hands', 'Suited débiles'),
            self::spot(['Ts','7s'], 'FOLD', [62,18,20], 'T7s es demasiado débil para defensa estándar SB vs BTN. En micro-límites este tipo de mano quema dinero postflop.', 'weak_suited_hands', 'Suited débiles'),
        ];
    }

    protected static function spot(
        array $cards,
        string $best,
        array $freq,
        string $why,
        string $concept,
        string $conceptLabel
    ): array {
        $freqMap = [
            'FOLD' => $freq[0],
            'CALL' => $freq[1],
            '3BET' => $freq[2],
        ];

        $ev = self::evFor($best, $freqMap);

        return [
            'cards' => $cards,
            'best' => $best,
            'freq' => $freqMap,
            'ev' => $ev,
            'why' => $why,

            'family' => 'sb_vs_btn_response',
            'family_label' => 'SB vs BTN',
            'concept' => $concept,
            'concept_label' => $conceptLabel,

            'feedback' => [
                'FOLD' => $best === 'FOLD'
                    ? 'Correcto. Desde SB no queremos defender manos que realizan mal equity fuera de posición.'
                    : 'Demasiado tight. Esta mano tiene suficiente valor para defender agresivamente.',

                'CALL' => $best === 'CALL'
                    ? 'Aceptable, pero recuerda que SB debe pagar poco.'
                    : 'Pagar desde SB suele ser la línea más débil: juegas OOP y dejas entrar a BB.',

                '3BET' => $best === '3BET'
                    ? 'Correcto. En SB preferimos estrategia agresiva: 3Bet o fold.'
                    : 'Demasiado agresivo como estándar para esta mano concreta.',
            ],
        ];
    }

    protected static function evFor(string $best, array $freq): array
    {
        $ev = [];

        foreach (['FOLD', 'CALL', '3BET'] as $action) {
            $ev[$action] = $action === $best
                ? 100
                : max(5, min(86, $freq[$action] + 15));
        }

        return $ev;
    }

    protected static function spotId(array $cards): string
    {
        return 'sb_vs_btn_' . self::cardsKey($cards);
    }

    protected static function cardsKey(array $cards): string
    {
        return strtolower((string) preg_replace('/[^a-zA-Z0-9]+/', '', implode('', $cards)));
    }

    protected static function confidenceFromFrequency(array $frequency): int
    {
        return max(60, min(95, max(array_map('intval', $frequency ?: [80]))));
    }

    protected static function lowStakesInsight(string $concept): string
    {
        return match ($concept) {
            'value_3bet' =>
                'En NL2-NL10 los opens de BTN suelen contener demasiadas manos dominadas. Desde SB, las manos de valor deben jugarse agresivas para aislar al rival, negar equity a BB y construir bote. La mayoría del pool no castiga lo suficiente una estrategia lineal de 3Bet.',

            'ax_bluff_3bet' =>
                'Los Ax suited bajos funcionan bien como 3Bet bluff porque bloquean parte del rango fuerte de continuación y conservan equity cuando reciben call. Contra rivales que pagan demasiadas 3Bets y foldean poco preflop, reduce la frecuencia y prioriza valor.',

            'kx_bluff_3bet' =>
                'Los Kx suited pueden ser buenos bluffs selectivos por blocker y jugabilidad. En NL2-NL10 no deben usarse de forma automática: funcionan mejor contra BTN que abre amplio y foldea suficiente a 3Bet.',

            'semi_bluff_suited' =>
                'Estas manos suited tienen jugabilidad, pero desde SB sufren por jugar fuera de posición. En NL2-NL10 úsalas como 3Bet selectivo contra BTN amplio; contra jugadores que pagan demasiado, baja la frecuencia y evita inflar botes marginales.',

            'dominated_offsuit' =>
                'Una fuga común en NL2-NL10 es defender demasiadas offsuit dominadas desde SB. La falta de posición amplifica los errores postflop. Contra población estándar, foldear estas manos suele ahorrar más dinero que intentar jugar perfecto después del flop.',

            'weak_suited_hands' =>
                'Que una mano sea suited no significa que deba defenderse. En NL2-NL10 muchas suited débiles pierden dinero porque conectan proyectos dominados y juegan botes difíciles fuera de posición. Si no bloquea bien ni realiza equity, foldea más.',

            'small_pairs_oop' =>
                'Las parejas pequeñas pierden valor cuando juegan fuera de posición. Muchos jugadores sobreestiman el set mining desde SB sin contar que la mayoría de veces no conectarán set y tendrán que abandonar o adivinar postflop.',

            default =>
                'En NL2-NL10 la SB debe jugarse con disciplina: menos calls fuera de posición, más 3Bets claros por valor y bluffs selectivos con blockers. Evita defender manos que solo parecen bonitas pero realizan mal equity.',
        };
    }
}