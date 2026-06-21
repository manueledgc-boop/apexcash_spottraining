<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;
use App\SpotTraining\SpotFamilyResolver;

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
            'family' => $spot['family'],
            'family_label' => $spot['family_label'],
            'spot_family' => SpotFamilyResolver::fromConcept($spot['concept']),
            'spot_family_label' => SpotFamilyResolver::labelFromConcept($spot['concept']),
            'concept' => $spot['concept'],
            'concept_label' => $spot['concept_label'],
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

            'insights' => [
                'low_stakes' => self::lowStakesInsight(
                    $spot['concept'],
                    $best,
                    $hero,
                    $villain,
                    $spot['cards']
                ),
            ],

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
            self::spot('SB', 'CO', ['Ah','5h'], '3BET', [18,8,74], 'A5s es excelente 3Bet bluff desde SB contra CO: bloquea Ax fuertes, tiene equity y juega mejor como raise/fold que pagando OOP.', 'ax_3bet_bluff', '3Bet bluff con Ax suited'),
            self::spot('SB', 'BTN', ['Ah','Jd'], '3BET', [12,6,82], 'AJo en SB contra BTN suele preferir 3Bet por valor/protección. Pagar OOP es problemático y permite a BB realizar equity.', 'value_3bet', '3Bet por valor'),
            self::spot('BTN', 'CO', ['Ad','Qc'], '3BET', [2,30,68], 'AQo en BTN contra CO es una 3Bet muy rentable por valor y protección. Call también existe, pero 3Bet captura mucho EV.', 'value_3bet', '3Bet por valor'),
            self::spot('BB', 'BTN', ['As','5s'], '3BET', [8,46,46], 'A5s en BB contra BTN puede pagar o 3betear. Como entrenamiento base es excelente 3Bet bluff por blocker al As y jugabilidad suited.', 'ax_3bet_bluff', '3Bet bluff con Ax suited'),
            self::spot('SB', 'CO', ['Kh','Qd'], '3BET', [30,8,62], 'KQo en SB contra CO suele preferir 3Bet antes que call. Tiene blockers y fuerza relativa, pero juega mal multiway/OOP si solo paga.', 'value_3bet', '3Bet por valor'),
            self::spot('BTN', 'HJ', ['Jh','Th'], 'CALL', [8,64,28], 'JTs en BTN contra HJ open realiza muy bien equity en posición. Puede mezclarse como 3Bet, pero call es la línea principal.', 'suited_broadway', 'Broadways suited'),
            self::spot('CO', 'HJ', ['As','Qs'], '3BET', [0,28,72], 'AQs contra HJ es demasiado fuerte para foldear y gana mucho EV como 3Bet de valor/protección.', 'value_3bet', '3Bet por valor'),
            self::spot('CO', 'HJ', ['9h','9d'], 'CALL', [8,70,22], '99 en CO contra HJ realiza bien equity pagando. 3Bet existe, pero call mantiene manos dominadas dentro.', 'pocket_pairs', 'Pocket pairs'),
            self::spot('BTN', 'UTG', ['Ac','Jd'], 'CALL', [28,58,14], 'AJo contra UTG no es 3Bet automática. En posición puede defender pagando; foldear contra nits no es horrible.', 'ax_offsuit', 'As Offsuit'),
            self::spot('BTN', 'UTG', ['Ks','Qs'], 'CALL', [4,68,28], 'KQs tiene demasiada jugabilidad para foldear contra UTG. Call es estable; 3Bet puede mezclarse.', 'suited_broadway', 'Broadways suited'),
            self::spot('SB', 'HJ', ['Ad','5d'], '3BET', [24,8,68], 'A5s desde SB contra HJ funciona bien como 3Bet bluff por blocker y equity suited. Call OOP no debe ser rutina.', 'ax_3bet_bluff', '3Bet bluff con Ax suited'),
            self::spot('SB', 'UTG', ['Ah','Qo'], 'FOLD', [54,14,32], 'AQo desde SB contra UTG es incómoda: dominada con frecuencia y OOP. 3Bet puede existir, pero fold es una base prudente contra rango fuerte.', 'dominated_offsuit', 'Offsuit dominadas'),
            self::spot('BB', 'CO', ['7s','6s'], 'CALL', [12,78,10], '76s en BB contra CO obtiene buen precio y realiza equity suficiente pagando. 3Bet es mezcla baja.', 'suited_connectors', 'Suited connectors'),
            self::spot('BB', 'BTN', ['Kc','To'], 'CALL', [20,68,12], 'KTo en BB contra BTN es defensa estándar por precio. No necesita convertirse en 3Bet frecuente.', 'blind_defense', 'Defensa de ciegas'),
            self::spot('BB', 'HJ', ['Qc','Jo'], 'FOLD', [62,28,10], 'QJo offsuit contra HJ queda dominada a menudo. Puede pagar contra tamaños pequeños, pero fold es la base segura.', 'dominated_offsuit', 'Offsuit dominadas'),
            self::spot('CO', 'HJ', ['Ac','5c'], '3BET', [18,30,52], 'A5s CO vs HJ es buen 3Bet bluff selectivo: blocker al As y buena jugabilidad cuando recibe call.', 'ax_3bet_bluff', '3Bet bluff con Ax suited'),
            self::spot('BTN', 'CO', ['Tc','9c'], 'CALL', [8,74,18], 'T9s en BTN contra CO es defensa clara por posición y jugabilidad. 3Bet existe, pero call domina como base.', 'suited_connectors', 'Suited connectors'),
            self::spot('SB', 'BTN', ['Kc','9c'], '3BET', [32,10,58], 'K9s en SB contra BTN puede 3betear por blocker, suitedness y fold equity. Call OOP es inferior.', 'value_3bet', '3Bet por valor'),
            self::spot('SB', 'BTN', ['Qh','To'], 'FOLD', [58,8,34], 'QTo offsuit desde SB contra BTN parece tentadora, pero paga mal y 3betearla demasiado abre fugas.', 'dominated_offsuit', 'Offsuit dominadas'),
            self::spot('BB', 'SB', ['Ad','8d'], 'CALL', [6,78,16], 'A8s en BB contra SB es defensa fuerte. Call realiza bien equity IP; 3Bet es mezcla.', 'blind_defense', 'Defensa de ciegas'),
            self::spot('BB', 'SB', ['Ah','4h'], '3BET', [8,42,50], 'A4s BB vs SB es gran candidato a 3Bet bluff por blocker y jugabilidad. Call también es viable.', 'ax_3bet_bluff', '3Bet bluff con Ax suited'),
            self::spot('BTN', 'HJ', ['Kc','Jo'], 'FOLD', [52,36,12], 'KJo offsuit contra HJ se domina con frecuencia. Call puede ser marginal, pero fold evita spots difíciles.', 'dominated_offsuit', 'Offsuit dominadas'),
            self::spot('CO', 'UTG', ['Qh','Qs'], '3BET', [0,32,68], 'QQ contra UTG es 3Bet clara por valor. Call puede proteger rango, pero foldear es imposible.', 'value_3bet', '3Bet por valor'),
            self::spot('BTN', 'UTG', ['5s','5d'], 'CALL', [18,80,2], '55 en BTN contra UTG paga por set value y posición. 3Bet sin blockers no es atractiva.', 'pocket_pairs', 'Pocket pairs'),
            self::spot('SB', 'CO', ['Jc','Ts'], 'FOLD', [64,18,18], 'JTo offsuit desde SB contra CO es una defensa floja: dominación, mala realización OOP y poco blocker real.', 'dominated_offsuit', 'Offsuit dominadas'),

            // Premium value 3Bets
            self::spot('SB', 'BTN', ['Ah','Kd'], '3BET', [0,4,96], 'AKo desde SB contra BTN es 3Bet claro por valor. Domina muchos Ax/Kx del open y evita jugar un bote multiway OOP.', 'value_3bet', '3Bet por valor'),
            self::spot('BB', 'BTN', ['Ac','Kh'], '3BET', [0,24,76], 'AKo en BB contra BTN puede pagar a veces, pero como base de entrenamiento captura más EV 3beteando por valor contra robo amplio.', 'value_3bet', '3Bet por valor'),
            self::spot('BTN', 'CO', ['Kh','Ks'], '3BET', [0,10,90], 'KK en BTN contra CO debe construir bote inmediatamente. Pagar existe como trampa ocasional, pero 3Bet es la línea principal.', 'value_3bet', '3Bet por valor'),
            self::spot('CO', 'HJ', ['Ah','Ad'], '3BET', [0,18,82], 'AA contra HJ es 3Bet por valor. Slowplay puede existir con baja frecuencia, pero el plan estándar es aislar y construir bote.', 'value_3bet', '3Bet por valor'),
            self::spot('SB', 'UTG', ['Kh','Ks'], '3BET', [0,8,92], 'KK desde SB contra UTG sigue siendo 3Bet claro por valor. Pagar OOP deja realizar equity gratis a BB y pierde valor.', 'value_3bet', '3Bet por valor'),

            // Strong value / protection
            self::spot('BTN', 'HJ', ['Ad','Kh'], '3BET', [0,24,76], 'AKo en BTN contra HJ es 3Bet rentable por valor y protección. Call puede mezclarse, pero 3Bet castiga opens dominados.', 'value_3bet', '3Bet por valor'),
            self::spot('SB', 'HJ', ['Jh','Jd'], '3BET', [4,18,78], 'JJ desde SB contra HJ prefiere 3Bet por valor/protección. Pagar OOP deja demasiadas overcards y permite a BB entrar barato.', 'value_3bet', '3Bet por valor'),
            self::spot('BB', 'CO', ['Qc','Qd'], '3BET', [0,30,70], 'QQ en BB contra CO es suficientemente fuerte para 3Bet de valor. Call existe, pero 3Bet simplifica y captura valor de broadways y pares peores.', 'value_3bet', '3Bet por valor'),
            self::spot('SB', 'BTN', ['Td','Ts'], '3BET', [8,24,68], 'TT desde SB contra BTN gana mucho con 3Bet por valor/protección. Pagar OOP permite que BB entre y complica muchas texturas.', 'value_3bet', '3Bet por valor'),
            self::spot('BB', 'SB', ['As','Qh'], '3BET', [0,42,58], 'AQo BB vs SB es una defensa muy fuerte. Call realiza equity IP, pero 3Bet por valor castiga un rango de robo muy amplio.', 'value_3bet', '3Bet por valor'),

            // Ax suited 3Bet bluffs
            self::spot('BTN', 'CO', ['Ah','4h'], '3BET', [12,38,50], 'A4s en BTN contra CO es buen 3Bet bluff mixto: bloquea Ax fuertes, conserva equity y puede ganar el bote preflop.', 'ax_3bet_bluff', '3Bet bluff con Ax suited'),
            self::spot('CO', 'HJ', ['Ad','4d'], '3BET', [24,32,44], 'A4s CO vs HJ no es call automático. Como 3Bet bluff selectivo funciona por blocker y jugabilidad cuando recibe call.', 'ax_3bet_bluff', '3Bet bluff con Ax suited'),
            self::spot('SB', 'BTN', ['As','2s'], '3BET', [28,12,60], 'A2s desde SB contra BTN es buen candidato a 3Bet bluff por blocker, equity suited y mala realización si solo paga OOP.', 'ax_3bet_bluff', '3Bet bluff con Ax suited'),
            self::spot('BB', 'CO', ['Ah','3h'], 'CALL', [18,54,28], 'A3s en BB contra CO puede 3betear, pero con buen precio realiza suficiente equity pagando. No hace falta convertirlo siempre en bluff.', 'ax_3bet_bluff', '3Bet bluff con Ax suited'),
            self::spot('BTN', 'HJ', ['Ac','5c'], 'CALL', [14,52,34], 'A5s en BTN contra HJ puede mezclarse como 3Bet bluff, pero el call en posición conserva jugabilidad y evita aislarse contra rango fuerte.', 'ax_3bet_bluff', '3Bet bluff con Ax suited'),

            // Suited broadways / playable calls
            self::spot('BTN', 'HJ', ['Qh','Jh'], 'CALL', [8,70,22], 'QJs en BTN contra HJ realiza muy bien equity en posición. 3Bet existe, pero call mantiene dentro manos dominadas.', 'suited_broadway', 'Broadways suited'),
            self::spot('BB', 'CO', ['Ks','Js'], 'CALL', [4,72,24], 'KJs en BB contra CO es defensa clara por jugabilidad y precio. 3Bet puede mezclarse, pero call es una base sólida.', 'suited_broadway', 'Broadways suited'),
            self::spot('SB', 'CO', ['Kc','Jc'], '3BET', [20,16,64], 'KJs desde SB contra CO suele preferir 3Bet antes que call: tiene blocker, equity y evita invitar a BB al bote.', 'suited_broadway', 'Broadways suited'),
            self::spot('BTN', 'UTG', ['Ah','Th'], 'CALL', [18,64,18], 'ATs en BTN contra UTG tiene suficiente jugabilidad para pagar. 3Bet demasiado frecuente se aísla contra mejores Ax.', 'suited_broadway', 'Broadways suited'),
            self::spot('CO', 'UTG', ['Kd','Qd'], 'CALL', [16,60,24], 'KQs CO vs UTG es demasiado fuerte para foldear. Call controla el bote y mantiene dominadas peores; 3Bet puede mezclarse.', 'suited_broadway', 'Broadways suited'),

            // Pocket pairs
            self::spot('BTN', 'CO', ['8s','8d'], 'CALL', [6,76,18], '88 en BTN contra CO defiende muy bien pagando por posición y valor de set. 3Bet puede existir, pero no debe ser automático.', 'pocket_pairs', 'Pocket pairs'),
            self::spot('CO', 'HJ', ['7h','7d'], 'CALL', [18,74,8], '77 CO vs HJ juega mejor como call por set value. 3Bet sin blockers suele aislarte contra una parte fuerte del rango.', 'pocket_pairs', 'Pocket pairs'),
            self::spot('BB', 'BTN', ['6c','6d'], 'CALL', [10,84,6], '66 en BB contra BTN tiene precio y suficiente equity para pagar. 3Bet bluff con pares bajos no es necesario en micro-límites.', 'pocket_pairs', 'Pocket pairs'),
            self::spot('SB', 'BTN', ['8c','8h'], '3BET', [18,26,56], '88 desde SB contra BTN puede funcionar mejor como 3Bet por protección que como call OOP. Evita regalar equity a BB y simplifica la mano.', 'pocket_pairs', 'Pocket pairs'),
            self::spot('BTN', 'UTG', ['2s','2d'], 'CALL', [32,66,2], '22 en BTN contra UTG es call marginal por set value si el tamaño es estándar y stacks son profundos. 3Bet sin blockers no aporta mucho.', 'pocket_pairs', 'Pocket pairs'),

        ];
    }

    protected static function spot(
        string $hero,
        string $villain,
        array $cards,
        string $best,
        array $freq,
        string $why,
        string $concept,
        string $conceptLabel
    ): array {
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
            'family' => 'threebet_vs_open_response',
            'family_label' => '3Bet vs Open',

            'concept' => $concept,
            'concept_label' => $conceptLabel,
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

    protected static function lowStakesInsight(
        string $concept,
        string $best,
        string $hero,
        string $villain,
        array $cards
    ): string {
        return match ($concept) {
            'ax_3bet_bluff' =>
                'En NL2-NL10 los Ax suited bajos funcionan mejor como 3Bet bluff contra rivales que abren amplio y foldean demasiado a 3Bet. Contra jugadores que pagan mucho o 4betean muy poco, baja la frecuencia y prefiere call o fold según posición.',

            'value_3bet' =>
                'En NL2-NL10 muchos rivales continúan contra 3Bet con rangos demasiado amplios y manos dominadas. Con manos de valor, prioriza construir bote y aislar al rival. Reduce el slowplay preflop salvo contra jugadores muy agresivos.',

            'suited_broadway' =>
                'En NL2-NL10 los broadways suited suelen tener más valor como call cuando tienes posición y el rival comete errores postflop. Usa el 3Bet con más cuidado: funciona mejor contra opens amplios y rivales que foldean demasiado.',

            'pocket_pairs' =>
                'En NL2-NL10 las pocket pairs medias y bajas ganan valor cuando puedes pagar con buenas odds y cobrar fuerte al ligar set. Evita convertirlas en 3Bet bluff sin blockers; contra tamaños grandes o rivales agresivos, reduce los calls marginales.',

            'dominated_offsuit' =>
                'En NL2-NL10 muchas pérdidas vienen de defender offsuit dominadas contra rangos fuertes. Manos como KJo, QJo o QTo parecen jugables, pero suelen acabar dominadas. Contra opens tight o 3Bets fuertes, foldear más es el ajuste rentable.',

            'suited_connectors' =>
                'En NL2-NL10 los suited connectors ganan valor cuando tienes posición, buen precio y rivales que pagan demasiado postflop. No los uses como 3Bet automático: sin fold equity real, inflar el bote reduce su ventaja.',

            'blind_defense' =>
                'En NL2-NL10 muchos rivales roban amplio desde late position, pero también pagan demasiado cuando reciben resistencia. Defiende ciegas con criterio: 3betea valor claro y bluffs con blockers; paga manos jugables cuando el precio sea bueno.',

            default =>
                'En NL2-NL10 el ajuste principal no es jugar más complicado, sino reducir defensas marginales contra rangos fuertes y aumentar valor contra rivales que pagan demasiado. La explotación debe depender del perfil, no de una regla fija.',
        };
    }

}
