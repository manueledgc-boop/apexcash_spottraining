<?php

namespace App\SpotTraining\Modules;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class BtnVs3BetSpots
{
    use BuildsSpotPlayers;

    public static function all(): array
    {
        return [
            self::ajsVsSb(), self::a5sVsSb(), self::kqoVsSb(), self::aqoVsSb(), self::ttVsSb(),
            self::kjsVsSb(), self::qtsVsSb(), self::a9oVsSb(), self::j9sVsSb(), self::pocket55VsSb(),
            self::a4sVsSb(), self::k9sVsSb(), self::qjoVsSb(), self::aksVsSb(), self::a2sVsSb(),
            self::pocket88VsSb(), self::kqsVsSb(), self::a8sVsSb(), self::t9sVsSb(), self::q9sVsSb(),
            self::ajoVsSb(), self::ktoVsSb(), self::pocket22VsSb(), self::jtsVsSb(), self::pocketQQVsSb(),

            self::pair77VsBb(), self::ktsVsBb(), self::qjoVsBb(), self::aqsVsBb(), self::a5sVsBb(),
            self::pocket99VsBb(), self::qtsVsBb(), self::j8sVsBb(), self::atoVsBb(), self::pocket33VsBb(),
            self::kjoVsBb(), self::t9sVsBb(), self::aksVsBb(), self::a4sVsBb(), self::pocketTTVsBb(),
            self::kqsVsBb(), self::a9sVsBb(), self::jtsVsBb(), self::pocket66VsBb(), self::q9sVsBb(),
            self::ajoVsBb(), self::k9sVsBb(), self::pocket22VsBb(), self::t8sVsBb(), self::a2sVsBb(),
        ];
    }

    protected static function base(
        array $heroCards,
        string $villainPosition,
        string $correctAction,
        string $explanation,
        string $solverNote,
        array $grades,
        string $concept,
        string $conceptLabel
    ): array {
        $actions = $villainPosition === 'SB'
            ? ['UTG folds', 'HJ folds', 'CO folds', 'Hero BTN raises 2.5 BB', 'SB 3bets 10 BB', 'BB folds']
            : ['UTG folds', 'HJ folds', 'CO folds', 'Hero BTN raises 2.5 BB', 'SB folds', 'BB 3bets 10 BB'];

        return [
            'id' => self::spotId($villainPosition, $heroCards),
            'module' => 'btn_vs_3bet',
            'module_label' => 'BTN vs 3Bet',

            'family' => 'btn_vs_3bet_response',
            'family_label' => 'BTN vs 3Bet',
            'concept' => $concept,
            'concept_label' => $conceptLabel,

            'title' => "BTN abre y {$villainPosition} hace 3Bet",
            'hero_position' => 'BTN',
            'hero_cards' => $heroCards,
            'villain_position' => $villainPosition,
            'stacks' => ['hero_bb' => 100, 'villain_bb' => 100],
            'pot_bb' => 13.5,
            'actions' => $actions,
            'options' => ['FOLD', 'CALL', '4BET'],
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
            'insights' => self::insightsFor($concept, $villainPosition, $correctAction),
            'confidence' => self::confidenceFromGrades($grades),
            'table_players' => self::defaultPlayers('BTN', $villainPosition),
        ];
    }

    protected static function insightsFor(string $concept, string $villainPosition, string $correctAction): array
    {
        $villainText = $villainPosition === 'SB'
            ? 'Cuando la 3Bet viene de SB, el rival está fuera de posición y normalmente puede tener más bluffs que BB.'
            : 'Cuando la 3Bet viene de BB, el rango suele estar más polarizado y muchas veces contiene valor fuerte junto a algunos bluffs seleccionados.';

        $lowStakes = match ($concept) {
            'ax_4bet_bluff' =>
                "{$villainText} En NL2-NL10 los Ax suited bajos funcionan mejor como 4Bet bluff contra rivales que 3betean amplio y foldean demasiado a 4Bet. Contra jugadores tight o calling stations, baja la frecuencia: pagar en posición o foldear puede ser mejor que forzar el bluff.",

            'value_continue' =>
                "{$villainText} En NL2-NL10 manos como AQo y similares no deben foldearse automáticamente, pero tampoco hace falta convertirlas siempre en 4Bet. Contra rivales que 3betean fuerte y pagan mucho, prioriza líneas de valor. Contra nits, reduce los calls marginales.",

            'premium_continue' =>
                "{$villainText} En NL2-NL10 la prioridad con manos premium es no perder valor. Si el rival paga demasiado 4Bets, aumenta el valor preflop. Si el rival farolea mucho postflop, pagar puede mantener sus errores dentro.",

            'suited_broadway' =>
                "{$villainText} En NL2-NL10 los broadways suited suelen rendir muy bien pagando en posición porque conservan dominación, blockers y jugabilidad. Evita convertirlos en 4Bet bluff automático si el rival no foldea suficiente.",

            'offsuit_broadway' =>
                "{$villainText} En NL2-NL10 los broadways offsuit pierden mucho valor cuando el rival 3betea tight. Manos como KQo o QJo pueden parecer fuertes, pero se dominan con facilidad. Paga más contra agresivos amplios y foldea más contra rangos cerrados.",

            'medium_pairs' =>
                "{$villainText} En NL2-NL10 las parejas medias funcionan mejor como call en posición cuando el tamaño permite realizar equity. No las conviertas en 4Bet bluff: no bloquean premiums y suelen aislarse contra rangos fuertes.",

            'small_pairs' =>
                "{$villainText} En NL2-NL10 las parejas pequeñas dependen mucho de implied odds. Pagar puede ser rentable contra rivales que se stackean demasiado con overpairs, pero contra tamaños grandes o rivales agresivos postflop el call se vuelve marginal.",

            'borderline_suited' =>
                "{$villainText} En NL2-NL10 las suited marginales no deben defenderse por orgullo. Si el rival presiona poco postflop y el precio es bueno, pagar puede ser viable; contra 3Bets fuertes o sizings grandes, foldear evita errores caros.",

            'dominated_offsuit' =>
                "{$villainText} En NL2-NL10 una fuga común es pagar demasiadas manos offsuit dominadas en 3Bet pots. Contra rangos tight, foldear manos como ATo, KJo o QJo suele ahorrar más dinero que intentar jugar perfecto postflop.",

            'suited_connectors' =>
                "{$villainText} En NL2-NL10 los suited connectors tienen valor cuando puedes jugar en posición y el rival comete errores postflop. Evita 4betearlos sin fold equity real; su rentabilidad viene de realizar equity, no de inflar el bote preflop.",

            default =>
                "{$villainText} En NL2-NL10 el ajuste principal es simple: paga más en posición contra rivales amplios y pasivos, foldea más contra 3Bets tight, y reserva los 4Bet bluffs para jugadores que realmente foldean."
        };

        return [
            'low_stakes' => $lowStakes,
        ];
    }

    protected static function grades(
        string $best,
        int $foldFreq,
        int $callFreq,
        int $fourBetFreq,
        array $ev,
        array $feedback
    ): array {
        return [
            'FOLD' => [
                'grade' => $best === 'FOLD' ? 'best' : ($foldFreq >= 25 ? 'marginal' : 'mistake'),
                'frequency' => $foldFreq,
                'ev_score' => $ev['FOLD'],
                'feedback' => $feedback['FOLD'],
            ],
            'CALL' => [
                'grade' => $best === 'CALL' ? 'best' : ($callFreq >= 20 ? 'good' : 'mistake'),
                'frequency' => $callFreq,
                'ev_score' => $ev['CALL'],
                'feedback' => $feedback['CALL'],
            ],
            '4BET' => [
                'grade' => $best === '4BET' ? 'best' : ($fourBetFreq >= 15 ? 'good' : 'mistake'),
                'frequency' => $fourBetFreq,
                'ev_score' => $ev['4BET'],
                'feedback' => $feedback['4BET'],
            ],
        ];
    }

    protected static function ajsVsSb(): array
    {
        return self::base(['As','Js'], 'SB', 'CALL',
            'AJs defiende muy bien en posición contra SB. Call es línea principal; 4Bet existe como mezcla.',
            'GTO simplificado: FOLD 4%, CALL 74%, 4BET 22%.',
            self::grades('CALL', 4, 74, 22, ['FOLD'=>5,'CALL'=>100,'4BET'=>82], [
                'FOLD'=>'Blunder. AJs es demasiado fuerte para foldear.',
                'CALL'=>'Correcto. Realiza equity muy bien IP.',
                '4BET'=>'Aceptable como mezcla, no como automático.',
            ]),
            'suited_broadway',
            'Broadways suited'
        );
    }

    protected static function a5sVsSb(): array
    {
        return self::base(['Ah','5h'], 'SB', '4BET',
            'A5s es uno de los mejores 4Bet bluffs: bloquea Ax fuertes y conserva equity.',
            'GTO simplificado: FOLD 12%, CALL 30%, 4BET 58%.',
            self::grades('4BET', 12, 30, 58, ['FOLD'=>25,'CALL'=>65,'4BET'=>100], [
                'FOLD'=>'Demasiado tight. Tiene blockers y equity.',
                'CALL'=>'Marginal/mezcla. Suele rendir mejor como 4Bet.',
                '4BET'=>'Correcto. Candidato natural de 4Bet bluff.',
            ]),
            'ax_4bet_bluff',
            '4Bet bluff con Ax suited'
        );
    }

    protected static function kqoVsSb(): array
    {
        return self::base(['Kh','Qo'], 'SB', 'CALL',
            'KQo puede defenderse IP contra SB, pero no es una 4Bet automática.',
            'GTO simplificado: FOLD 28%, CALL 62%, 4BET 10%.',
            self::grades('CALL', 28, 62, 10, ['FOLD'=>58,'CALL'=>100,'4BET'=>35], [
                'FOLD'=>'Conservador. Puede existir contra rival muy tight.',
                'CALL'=>'Correcto. Buena defensa IP.',
                '4BET'=>'Error como estándar: suele quedar dominada cuando continúa la acción.',
            ]),
            'offsuit_broadway',
            'Broadways offsuit'
        );
    }

    protected static function aqoVsSb(): array
    {
        return self::base(['Ad','Qc'], 'SB', 'CALL',
            'AQo es defensa obligatoria. Call domina como línea base; 4Bet también puede mezclarse.',
            'GTO simplificado: FOLD 2%, CALL 64%, 4BET 34%.',
            self::grades('CALL', 2, 64, 34, ['FOLD'=>3,'CALL'=>100,'4BET'=>92], [
                'FOLD'=>'Blunder. AQo es demasiado fuerte para foldear BTN vs SB.',
                'CALL'=>'Correcto. Mantienes dominadas y realizas equity IP.',
                '4BET'=>'Buena mezcla, pero no debe ser siempre.',
            ]),
            'value_continue',
            'Continuación por valor'
        );
    }

    protected static function ttVsSb(): array
    {
        return self::base(['Tc','Td'], 'SB', 'CALL',
            'TT es defensa muy fuerte. Call mantiene el rango de SB amplio; 4Bet/call puede existir.',
            'GTO simplificado: FOLD 0%, CALL 70%, 4BET 30%.',
            self::grades('CALL', 0, 70, 30, ['FOLD'=>0,'CALL'=>100,'4BET'=>90], [
                'FOLD'=>'Blunder absoluto. TT nunca se foldea aquí.',
                'CALL'=>'Correcto. Defensa fuerte y estable.',
                '4BET'=>'Buena mezcla, especialmente contra SB agresivo.',
            ]),
            'premium_continue',
            'Premium continue'
        );
    }

    protected static function kjsVsSb(): array
    {
        return self::base(['Ks','Js'], 'SB', 'CALL',
            'KJs suited defiende muy bien IP contra SB por blockers y jugabilidad.',
            'GTO simplificado: FOLD 6%, CALL 78%, 4BET 16%.',
            self::grades('CALL', 6, 78, 16, ['FOLD'=>18,'CALL'=>100,'4BET'=>76], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. KJs suited realiza muy bien equity.',
                '4BET'=>'Aceptable como mezcla baja.',
            ]),
            'suited_broadway',
            'Broadways suited'
        );
    }

    protected static function qtsVsSb(): array
    {
        return self::base(['Qs','Ts'], 'SB', 'CALL',
            'QTs suited es una defensa natural en posición contra SB 3Bet.',
            'GTO simplificado: FOLD 12%, CALL 78%, 4BET 10%.',
            self::grades('CALL', 12, 78, 10, ['FOLD'=>25,'CALL'=>100,'4BET'=>62], [
                'FOLD'=>'Tight como estándar.',
                'CALL'=>'Correcto. Buena jugabilidad y equity realizable.',
                '4BET'=>'No es principal; mezcla baja.',
            ]),
            'suited_broadway',
            'Broadways suited'
        );
    }

    protected static function a9oVsSb(): array
    {
        return self::base(['Ah','9d'], 'SB', 'FOLD',
            'A9o offsuit se domina mucho y realiza mal equity en 3Bet pot.',
            'GTO simplificado: FOLD 68%, CALL 24%, 4BET 8%.',
            self::grades('FOLD', 68, 24, 8, ['FOLD'=>100,'CALL'=>45,'4BET'=>30], [
                'FOLD'=>'Correcto. A9o está dominada demasiadas veces.',
                'CALL'=>'Demasiado loose como estándar.',
                '4BET'=>'Mal candidato a 4Bet bluff.',
            ]),
            'dominated_offsuit',
            'Offsuit dominadas'
        );
    }

    protected static function j9sVsSb(): array
    {
        return self::base(['Jh','9h'], 'SB', 'CALL',
            'J9s puede defender IP por jugabilidad, aunque está cerca del borde.',
            'GTO simplificado: FOLD 28%, CALL 66%, 4BET 6%.',
            self::grades('CALL', 28, 66, 6, ['FOLD'=>62,'CALL'=>100,'4BET'=>30], [
                'FOLD'=>'Conservador; no horrible.',
                'CALL'=>'Correcto. Mano jugable IP.',
                '4BET'=>'Demasiado ambicioso como estándar.',
            ]),
            'borderline_suited',
            'Suited marginales'
        );
    }

    protected static function pocket55VsSb(): array
    {
        return self::base(['5c','5d'], 'SB', 'CALL',
            '55 defiende IP por set value y cierta equity de showdown.',
            'GTO simplificado: FOLD 24%, CALL 74%, 4BET 2%.',
            self::grades('CALL', 24, 74, 2, ['FOLD'=>65,'CALL'=>100,'4BET'=>15], [
                'FOLD'=>'Puede existir contra nit, pero estándar es call.',
                'CALL'=>'Correcto. Defensa rentable IP.',
                '4BET'=>'Mal candidato: sin blockers.',
            ]),
            'small_pairs',
            'Pocket pairs bajos'
        );
    }

    protected static function a4sVsSb(): array
    {
        return self::base(['Ac','4c'], 'SB', '4BET',
            'A4s es otro candidato fuerte de 4Bet bluff por blocker al As y equity suited.',
            'GTO simplificado: FOLD 10%, CALL 34%, 4BET 56%.',
            self::grades('4BET', 10, 34, 56, ['FOLD'=>30,'CALL'=>70,'4BET'=>100], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Aceptable, pero no captura todo el fold equity.',
                '4BET'=>'Correcto. Buen blocker y buena estructura de bluff.',
            ]),
            'ax_4bet_bluff',
            '4Bet bluff con Ax suited'
        );
    }

    protected static function k9sVsSb(): array
    {
        return self::base(['Kh','9h'], 'SB', 'CALL',
            'K9s defiende a frecuencia alta contra SB por suitedness y blocker.',
            'GTO simplificado: FOLD 18%, CALL 72%, 4BET 10%.',
            self::grades('CALL', 18, 72, 10, ['FOLD'=>45,'CALL'=>100,'4BET'=>55], [
                'FOLD'=>'Algo tight.',
                'CALL'=>'Correcto. K9s es defensa razonable IP.',
                '4BET'=>'Mezcla baja; no principal.',
            ]),
            'borderline_suited',
            'Suited marginales'
        );
    }

    protected static function qjoVsSb(): array
    {
        return self::base(['Qh','Jd'], 'SB', 'CALL',
            'QJo contra SB es mejor que contra BB porque SB 3betea OOP y suele tener más bluffs.',
            'GTO simplificado: FOLD 38%, CALL 58%, 4BET 4%.',
            self::grades('CALL', 38, 58, 4, ['FOLD'=>70,'CALL'=>100,'4BET'=>18], [
                'FOLD'=>'Conservador; aceptable contra nit.',
                'CALL'=>'Correcto como defensa IP contra SB.',
                '4BET'=>'Mala 4Bet: dominada y sin buenos blockers.',
            ]),
            'offsuit_broadway',
            'Broadways offsuit'
        );
    }

    protected static function pair77VsBb(): array
    {
        return self::base(['7c','7d'], 'BB', 'CALL',
            '77 puede pagar IP contra BB 3Bet con 100 BB.',
            'GTO simplificado: FOLD 25%, CALL 72%, 4BET 3%.',
            self::grades('CALL', 25, 72, 3, ['FOLD'=>60,'CALL'=>100,'4BET'=>15], [
                'FOLD'=>'Conservador; call es estándar.',
                'CALL'=>'Correcto. Buen set value y showdown value.',
                '4BET'=>'Mal candidato: sin blockers.',
            ]),
            'medium_pairs',
            'Pocket pairs medios'
        );
    }

    protected static function ktsVsBb(): array
    {
        return self::base(['Ks','Ts'], 'BB', 'CALL',
            'KTs suited defiende bien IP contra BB 3Bet.',
            'GTO simplificado: FOLD 8%, CALL 78%, 4BET 14%.',
            self::grades('CALL', 8, 78, 14, ['FOLD'=>25,'CALL'=>100,'4BET'=>67], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Realiza muy bien equity.',
                '4BET'=>'Mezcla baja aceptable.',
            ]),
            'suited_broadway',
            'Broadways suited'
        );
    }

    protected static function qjoVsBb(): array
    {
        return self::base(['Qh','Jo'], 'BB', 'FOLD',
            'QJo offsuit realiza mal equity contra BB 3Bet y suele estar dominada.',
            'GTO simplificado: FOLD 78%, CALL 20%, 4BET 2%.',
            self::grades('FOLD', 78, 20, 2, ['FOLD'=>100,'CALL'=>35,'4BET'=>5], [
                'FOLD'=>'Correcto. Fold estándar.',
                'CALL'=>'Demasiado loose como base.',
                '4BET'=>'Blunder. Mal candidato a bluff.',
            ]),
            'dominated_offsuit',
            'Offsuit dominadas'
        );
    }

    protected static function aqsVsBb(): array
    {
        return self::base(['As','Qs'], 'BB', 'CALL',
            'AQs es defensa premium. Call domina, 4Bet es mezcla fuerte.',
            'GTO simplificado: FOLD 0%, CALL 58%, 4BET 42%.',
            self::grades('CALL', 0, 58, 42, ['FOLD'=>0,'CALL'=>100,'4BET'=>96], [
                'FOLD'=>'Blunder absoluto.',
                'CALL'=>'Correcto. Mantienes rango amplio y realizas equity.',
                '4BET'=>'Muy buena mezcla por valor.',
            ]),
            'premium_continue',
            'Premium continue'
        );
    }

    protected static function a5sVsBb(): array
    {
        return self::base(['Ad','5d'], 'BB', 'CALL',
            'A5s contra BB puede pagar o 4betear; ambas líneas tienen sentido.',
            'GTO simplificado: FOLD 8%, CALL 50%, 4BET 42%.',
            self::grades('CALL', 8, 50, 42, ['FOLD'=>20,'CALL'=>100,'4BET'=>96], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Defensa sólida.',
                '4BET'=>'Muy buena mezcla por blocker.',
            ]),
            'ax_4bet_bluff',
            '4Bet bluff con Ax suited'
        );
    }

    protected static function pocket99VsBb(): array
    {
        return self::base(['9c','9d'], 'BB', 'CALL',
            '99 es defensa fuerte IP. Call es estable; 4Bet mezcla baja.',
            'GTO simplificado: FOLD 2%, CALL 84%, 4BET 14%.',
            self::grades('CALL', 2, 84, 14, ['FOLD'=>5,'CALL'=>100,'4BET'=>70], [
                'FOLD'=>'Blunder. Mano demasiado fuerte.',
                'CALL'=>'Correcto. Defensa clara.',
                '4BET'=>'Aceptable a baja frecuencia.',
            ]),
            'medium_pairs',
            'Pocket pairs medios'
        );
    }

    protected static function qtsVsBb(): array
    {
        return self::base(['Qc','Tc'], 'BB', 'CALL',
            'QTs suited defiende bien IP contra BB 3Bet.',
            'GTO simplificado: FOLD 16%, CALL 76%, 4BET 8%.',
            self::grades('CALL', 16, 76, 8, ['FOLD'=>35,'CALL'=>100,'4BET'=>45], [
                'FOLD'=>'Algo tight.',
                'CALL'=>'Correcto. Buena jugabilidad.',
                '4BET'=>'No es principal.',
            ]),
            'suited_broadway',
            'Broadways suited'
        );
    }

    protected static function j8sVsBb(): array
    {
        return self::base(['Jh','8h'], 'BB', 'FOLD',
            'J8s está cerca del borde inferior y puede foldearse contra size 10 BB.',
            'GTO simplificado: FOLD 56%, CALL 40%, 4BET 4%.',
            self::grades('FOLD', 56, 40, 4, ['FOLD'=>100,'CALL'=>78,'4BET'=>20], [
                'FOLD'=>'Correcto. Fold de baja varianza y sólido.',
                'CALL'=>'Aceptable como mezcla, pero no obligatorio.',
                '4BET'=>'Demasiado ambicioso.',
            ]),
            'borderline_suited',
            'Suited marginales'
        );
    }

    protected static function atoVsBb(): array
    {
        return self::base(['Ah','Td'], 'BB', 'FOLD',
            'ATo offsuit sufre dominación y juega peor que suited Ax.',
            'GTO simplificado: FOLD 58%, CALL 34%, 4BET 8%.',
            self::grades('FOLD', 58, 34, 8, ['FOLD'=>100,'CALL'=>72,'4BET'=>32], [
                'FOLD'=>'Correcto como estrategia base.',
                'CALL'=>'Puede existir contra rangos muy amplios, pero es delicado.',
                '4BET'=>'Mal candidato como estándar.',
            ]),
            'dominated_offsuit',
            'Offsuit dominadas'
        );
    }

    protected static function pocket33VsBb(): array
    {
        return self::base(['3c','3d'], 'BB', 'CALL',
            '33 puede pagar IP por precio y set value, aunque no imprime muchísimo EV.',
            'GTO simplificado: FOLD 34%, CALL 64%, 4BET 2%.',
            self::grades('CALL', 34, 64, 2, ['FOLD'=>72,'CALL'=>100,'4BET'=>10], [
                'FOLD'=>'Conservador, pero no grave.',
                'CALL'=>'Correcto. Set value suficiente IP.',
                '4BET'=>'Mala idea: sin blockers.',
            ]),
            'small_pairs',
            'Pocket pairs bajos'
        );
    }

    protected static function kjoVsBb(): array
    {
        return self::base(['Kh','Jd'], 'BB', 'FOLD',
            'KJo offsuit está dominada con frecuencia y realiza peor que KJs/KQo.',
            'GTO simplificado: FOLD 52%, CALL 42%, 4BET 6%.',
            self::grades('FOLD', 52, 42, 6, ['FOLD'=>100,'CALL'=>78,'4BET'=>25], [
                'FOLD'=>'Correcto como base sólida.',
                'CALL'=>'Aceptable contra rangos muy amplios, pero delicado.',
                '4BET'=>'No es buen bluff principal.',
            ]),
            'dominated_offsuit',
            'Offsuit dominadas'
        );
    }

    protected static function t9sVsBb(): array
    {
        return self::base(['Ts','9s'], 'BB', 'CALL',
            'T9s suited es defensa muy jugable IP contra BB 3Bet.',
            'GTO simplificado: FOLD 12%, CALL 80%, 4BET 8%.',
            self::grades('CALL', 12, 80, 8, ['FOLD'=>30,'CALL'=>100,'4BET'=>45], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Muy buena jugabilidad.',
                '4BET'=>'Mezcla baja, no línea principal.',
            ]),
            'suited_connectors',
            'Suited connectors'
        );
    }

    protected static function aksVsSb(): array
    {
        return self::base(['As','Ks'], 'SB', '4BET',
            'AKs es una mano premium contra 3Bet de SB. Puedes pagar para mantener bluffs, pero la línea educativa principal es 4Bet por valor.',
            'GTO simplificado: FOLD 0%, CALL 35%, 4BET 65%.',
            self::grades('4BET', 0, 35, 65, ['FOLD'=>0,'CALL'=>92,'4BET'=>100], [
                'FOLD'=>'Blunder absoluto. AKs nunca se foldea aquí.',
                'CALL'=>'Muy bueno como mezcla, especialmente contra SB agresivo.',
                '4BET'=>'Correcto. Extrae valor y bloquea AA/KK/AK.',
            ]),
            'premium_continue',
            'Premium continue'
        );
    }

    protected static function a2sVsSb(): array
    {
        return self::base(['Ah','2h'], 'SB', '4BET',
            'A2s es un buen candidato de 4Bet bluff contra SB por blocker al As y equity cuando recibe call.',
            'GTO simplificado: FOLD 18%, CALL 28%, 4BET 54%.',
            self::grades('4BET', 18, 28, 54, ['FOLD'=>38,'CALL'=>64,'4BET'=>100], [
                'FOLD'=>'Conservador; aceptable contra SB nit.',
                'CALL'=>'Jugable, pero suele capturar menos fold equity que 4Bet.',
                '4BET'=>'Correcto contra rivales que 3betean amplio y foldean a 4Bet.',
            ]),
            'ax_4bet_bluff',
            '4Bet bluff con Ax suited'
        );
    }

    protected static function pocket88VsSb(): array
    {
        return self::base(['8c','8d'], 'SB', 'CALL',
            '88 tiene demasiado showdown value para foldear y no necesita convertirse en 4Bet bluff.',
            'GTO simplificado: FOLD 8%, CALL 86%, 4BET 6%.',
            self::grades('CALL', 8, 86, 6, ['FOLD'=>28,'CALL'=>100,'4BET'=>35], [
                'FOLD'=>'Demasiado tight contra SB.',
                'CALL'=>'Correcto. Realiza equity bien en posición.',
                '4BET'=>'No es buena idea como estándar: no bloquea premiums.',
            ]),
            'medium_pairs',
            'Pocket pairs medios'
        );
    }

    protected static function kqsVsSb(): array
    {
        return self::base(['Kc','Qc'], 'SB', 'CALL',
            'KQs es defensa fuerte en posición. Pagar mantiene dominadas dentro y 4Bet puede mezclarse.',
            'GTO simplificado: FOLD 0%, CALL 72%, 4BET 28%.',
            self::grades('CALL', 0, 72, 28, ['FOLD'=>0,'CALL'=>100,'4BET'=>88], [
                'FOLD'=>'Blunder. KQs es demasiado fuerte para abandonar.',
                'CALL'=>'Correcto. Excelente jugabilidad IP.',
                '4BET'=>'Buena mezcla, pero no obligatoria.',
            ]),
            'suited_broadway',
            'Broadways suited'
        );
    }

    protected static function a8sVsSb(): array
    {
        return self::base(['As','8s'], 'SB', 'CALL',
            'A8s conserva equity y blocker. Contra SB amplio puede pagar; como 4Bet bluff es menos limpio que A5s-A2s.',
            'GTO simplificado: FOLD 18%, CALL 62%, 4BET 20%.',
            self::grades('CALL', 18, 62, 20, ['FOLD'=>44,'CALL'=>100,'4BET'=>72], [
                'FOLD'=>'Algo tight contra SB agresivo.',
                'CALL'=>'Correcto. Buena defensa IP con suited Ax.',
                '4BET'=>'Mezcla posible, pero no principal.',
            ]),
            'borderline_suited',
            'Suited marginales'
        );
    }

    protected static function t9sVsSb(): array
    {
        return self::base(['Th','9h'], 'SB', 'CALL',
            'T9s juega muy bien en posición y puede realizar equity contra un rango amplio de SB.',
            'GTO simplificado: FOLD 18%, CALL 76%, 4BET 6%.',
            self::grades('CALL', 18, 76, 6, ['FOLD'=>42,'CALL'=>100,'4BET'=>35], [
                'FOLD'=>'Tight como estándar.',
                'CALL'=>'Correcto. Gran jugabilidad postflop.',
                '4BET'=>'No es el plan principal; necesita mucha fold equity.',
            ]),
            'suited_connectors',
            'Suited connectors'
        );
    }

    protected static function q9sVsSb(): array
    {
        return self::base(['Qs','9s'], 'SB', 'CALL',
            'Q9s está en zona media-baja, pero contra SB puede defenderse por posición y suitedness.',
            'GTO simplificado: FOLD 34%, CALL 60%, 4BET 6%.',
            self::grades('CALL', 34, 60, 6, ['FOLD'=>72,'CALL'=>100,'4BET'=>28], [
                'FOLD'=>'Aceptable contra SB tight o sizing grande.',
                'CALL'=>'Correcto contra rangos amplios.',
                '4BET'=>'Demasiado ambicioso como base.',
            ]),
            'borderline_suited',
            'Suited marginales'
        );
    }

    protected static function ajoVsSb(): array
    {
        return self::base(['Ad','Jh'], 'SB', 'CALL',
            'AJo contra SB no es fold automático. Domina parte de los bluffs, pero sufre contra rangos que continúan fuerte.',
            'GTO simplificado: FOLD 24%, CALL 66%, 4BET 10%.',
            self::grades('CALL', 24, 66, 10, ['FOLD'=>58,'CALL'=>100,'4BET'=>42], [
                'FOLD'=>'Aceptable solo contra nit.',
                'CALL'=>'Correcto. Defensa IP razonable.',
                '4BET'=>'No como estándar: cuando te pagan vas dominado muchas veces.',
            ]),
            'offsuit_broadway',
            'Broadways offsuit'
        );
    }

    protected static function ktoVsSb(): array
    {
        return self::base(['Kh','Td'], 'SB', 'FOLD',
            'KTo offsuit parece jugable, pero en 3Bet pot queda dominada demasiadas veces.',
            'GTO simplificado: FOLD 72%, CALL 24%, 4BET 4%.',
            self::grades('FOLD', 72, 24, 4, ['FOLD'=>100,'CALL'=>42,'4BET'=>12], [
                'FOLD'=>'Correcto. Evitas una defensa dominada.',
                'CALL'=>'Demasiado loose salvo rival muy agresivo y débil postflop.',
                '4BET'=>'Mal candidato: blockers insuficientes y mala realización.',
            ]),
            'dominated_offsuit',
            'Offsuit dominadas'
        );
    }

    protected static function pocket22VsSb(): array
    {
        return self::base(['2c','2d'], 'SB', 'CALL',
            '22 puede pagar contra SB por set value y posición, pero está cerca del borde inferior.',
            'GTO simplificado: FOLD 42%, CALL 56%, 4BET 2%.',
            self::grades('CALL', 42, 56, 2, ['FOLD'=>82,'CALL'=>100,'4BET'=>8], [
                'FOLD'=>'No es grave contra rival tight o agresivo postflop.',
                'CALL'=>'Correcto por precio y posición.',
                '4BET'=>'Mala idea: no bloquea nada importante.',
            ]),
            'small_pairs',
            'Pocket pairs bajos'
        );
    }

    protected static function jtsVsSb(): array
    {
        return self::base(['Jc','Tc'], 'SB', 'CALL',
            'JTs es una de las mejores defensas no premium: conecta fuerte y realiza equity en posición.',
            'GTO simplificado: FOLD 6%, CALL 84%, 4BET 10%.',
            self::grades('CALL', 6, 84, 10, ['FOLD'=>18,'CALL'=>100,'4BET'=>60], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Excelente jugabilidad IP.',
                '4BET'=>'Mezcla baja; no la conviertas en farol automático.',
            ]),
            'suited_connectors',
            'Suited connectors'
        );
    }

    protected static function pocketQQVsSb(): array
    {
        return self::base(['Qs','Qd'], 'SB', '4BET',
            'QQ contra SB es valor claro. Pagar puede inducir, pero el entrenamiento debe reconocer que 4Bet imprime valor.',
            'GTO simplificado: FOLD 0%, CALL 22%, 4BET 78%.',
            self::grades('4BET', 0, 22, 78, ['FOLD'=>0,'CALL'=>88,'4BET'=>100], [
                'FOLD'=>'Blunder absoluto.',
                'CALL'=>'Buena mezcla contra rival muy agresivo.',
                '4BET'=>'Correcto. Valor claro contra un rango amplio de SB.',
            ]),
            'premium_continue',
            'Premium continue'
        );
    }

    protected static function a3sVsSb(): array
    {
        return self::base(['Ad','3d'], 'SB', '4BET',
            'A3s funciona bien como 4Bet bluff por blocker y equity. No es obligatorio, pero es un candidato limpio.',
            'GTO simplificado: FOLD 14%, CALL 32%, 4BET 54%.',
            self::grades('4BET', 14, 32, 54, ['FOLD'=>34,'CALL'=>68,'4BET'=>100], [
                'FOLD'=>'Algo tight contra SB amplio.',
                'CALL'=>'Aceptable, especialmente contra jugador que no foldea a 4Bet.',
                '4BET'=>'Correcto como bluff estructurado.',
            ]),
            'ax_4bet_bluff',
            '4Bet bluff con Ax suited'
        );
    }

    protected static function k8sVsSb(): array
    {
        return self::base(['Ks','8s'], 'SB', 'CALL',
            'K8s es defensa marginal contra SB. Tiene blocker y suitedness, pero no debe sobrejugarse.',
            'GTO simplificado: FOLD 36%, CALL 58%, 4BET 6%.',
            self::grades('CALL', 36, 58, 6, ['FOLD'=>78,'CALL'=>100,'4BET'=>30], [
                'FOLD'=>'Aceptable contra rival tight.',
                'CALL'=>'Correcto contra SB amplio y precio estándar.',
                '4BET'=>'Demasiado fino como plan base.',
            ]),
            'borderline_suited',
            'Suited marginales'
        );
    }

    protected static function t8sVsSb(): array
    {
        return self::base(['Tc','8c'], 'SB', 'CALL',
            'T8s puede defenderse contra SB porque juega en posición y liga proyectos fuertes suficientes.',
            'GTO simplificado: FOLD 38%, CALL 58%, 4BET 4%.',
            self::grades('CALL', 38, 58, 4, ['FOLD'=>80,'CALL'=>100,'4BET'=>22], [
                'FOLD'=>'Aceptable contra rangos cerrados.',
                'CALL'=>'Correcto como defensa de borde.',
                '4BET'=>'No es buen farol principal.',
            ]),
            'suited_connectors',
            'Suited connectors'
        );
    }

    protected static function pocket66VsSb(): array
    {
        return self::base(['6h','6d'], 'SB', 'CALL',
            '66 tiene set value y algo de showdown value. Call es la línea estándar en posición.',
            'GTO simplificado: FOLD 20%, CALL 78%, 4BET 2%.',
            self::grades('CALL', 20, 78, 2, ['FOLD'=>56,'CALL'=>100,'4BET'=>12], [
                'FOLD'=>'Conservador; aceptable contra nit.',
                'CALL'=>'Correcto. Buen equilibrio entre precio y realización.',
                '4BET'=>'Mala conversión en bluff.',
            ]),
            'small_pairs',
            'Pocket pairs bajos'
        );
    }

    protected static function q8sVsSb(): array
    {
        return self::base(['Qh','8h'], 'SB', 'FOLD',
            'Q8s ya entra en zona dominada y con kicker débil. Puede mezclarse contra SB muy amplio, pero fold es base sólida.',
            'GTO simplificado: FOLD 54%, CALL 42%, 4BET 4%.',
            self::grades('FOLD', 54, 42, 4, ['FOLD'=>100,'CALL'=>82,'4BET'=>20], [
                'FOLD'=>'Correcto como base sólida.',
                'CALL'=>'No es horrible contra SB muy amplio, pero es marginal.',
                '4BET'=>'Demasiado ambicioso.',
            ]),
            'borderline_suited',
            'Suited marginales'
        );
    }

    protected static function a7oVsSb(): array
    {
        return self::base(['As','7d'], 'SB', 'FOLD',
            'A7o offsuit tiene blocker, pero juega mal cuando recibe call y se domina demasiado.',
            'GTO simplificado: FOLD 76%, CALL 18%, 4BET 6%.',
            self::grades('FOLD', 76, 18, 6, ['FOLD'=>100,'CALL'=>32,'4BET'=>24], [
                'FOLD'=>'Correcto. El As no compensa la mala jugabilidad offsuit.',
                'CALL'=>'Demasiado loose como estándar.',
                '4BET'=>'Candidato flojo comparado con Axs bajos.',
            ]),
            'dominated_offsuit',
            'Offsuit dominadas'
        );
    }

    protected static function k5sVsSb(): array
    {
        return self::base(['Kd','5d'], 'SB', 'FOLD',
            'K5s tiene blocker, pero su kicker y conectividad son pobres. No hace falta defender todo lo suited.',
            'GTO simplificado: FOLD 58%, CALL 34%, 4BET 8%.',
            self::grades('FOLD', 58, 34, 8, ['FOLD'=>100,'CALL'=>70,'4BET'=>34], [
                'FOLD'=>'Correcto como base disciplinada.',
                'CALL'=>'Solo aceptable contra SB muy amplio y pasivo postflop.',
                '4BET'=>'Demasiado fino salvo lectura clara de overfold.',
            ]),
            'borderline_suited',
            'Suited marginales'
        );
    }

    protected static function pocket44VsSb(): array
    {
        return self::base(['4s','4d'], 'SB', 'CALL',
            '44 conserva set value contra SB. Call es razonable si el tamaño no es excesivo.',
            'GTO simplificado: FOLD 30%, CALL 68%, 4BET 2%.',
            self::grades('CALL', 30, 68, 2, ['FOLD'=>70,'CALL'=>100,'4BET'=>10], [
                'FOLD'=>'Aceptable contra rival tight o sizing grande.',
                'CALL'=>'Correcto. Set value suficiente IP.',
                '4BET'=>'Error: sin blockers y mala realización si pagan.',
            ]),
            'small_pairs',
            'Pocket pairs bajos'
        );
    }

    protected static function jtoVsSb(): array
    {
        return self::base(['Jh','Td'], 'SB', 'FOLD',
            'JTo offsuit está dominada, no bloquea premiums relevantes y genera demasiados segundos mejores pares.',
            'GTO simplificado: FOLD 82%, CALL 16%, 4BET 2%.',
            self::grades('FOLD', 82, 16, 2, ['FOLD'=>100,'CALL'=>28,'4BET'=>8], [
                'FOLD'=>'Correcto. Disciplina preflop rentable.',
                'CALL'=>'Demasiado loose como estándar.',
                '4BET'=>'Blunder: mal blocker y mala jugabilidad.',
            ]),
            'dominated_offsuit',
            'Offsuit dominadas'
        );
    }

    protected static function atsVsSb(): array
    {
        return self::base(['Ac','Tc'], 'SB', 'CALL',
            'ATs es defensa fuerte contra SB. Tiene dominación sobre Ax peores, blocker y buena jugabilidad.',
            'GTO simplificado: FOLD 4%, CALL 72%, 4BET 24%.',
            self::grades('CALL', 4, 72, 24, ['FOLD'=>10,'CALL'=>100,'4BET'=>84], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Defensa sólida y rentable IP.',
                '4BET'=>'Buena mezcla contra SB amplio.',
            ]),
            'value_continue',
            'Continuación por valor'
        );
    }

    protected static function aksVsBb(): array
    {
        return self::base(['Ah','Kh'], 'BB', '4BET',
            'AKs contra BB es premium clara. La 4Bet por valor simplifica y castiga rangos que continúan demasiado.',
            'GTO simplificado: FOLD 0%, CALL 38%, 4BET 62%.',
            self::grades('4BET', 0, 38, 62, ['FOLD'=>0,'CALL'=>94,'4BET'=>100], [
                'FOLD'=>'Blunder absoluto.',
                'CALL'=>'Muy bueno como mezcla.',
                '4BET'=>'Correcto. Valor y blockers máximos.',
            ]),
            'premium_continue',
            'Premium continue'
        );
    }

    protected static function a4sVsBb(): array
    {
        return self::base(['As','4s'], 'BB', 'CALL',
            'A4s contra BB puede pagar o 4betear. Como la BB suele tener un rango más polar, call realiza muy bien equity en posición.',
            'GTO simplificado: FOLD 10%, CALL 52%, 4BET 38%.',
            self::grades('CALL', 10, 52, 38, ['FOLD'=>24,'CALL'=>100,'4BET'=>94], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Mantienes bluffs y realizas equity.',
                '4BET'=>'También buena mezcla, especialmente si BB foldea mucho.',
            ]),
            'ax_4bet_bluff',
            '4Bet bluff con Ax suited'
        );
    }

    protected static function pocketTTVsBb(): array
    {
        return self::base(['Ts','Td'], 'BB', 'CALL',
            'TT contra BB es defensa fuerte. Call mantiene faroles dentro y evita aislarte solo contra premiums.',
            'GTO simplificado: FOLD 0%, CALL 76%, 4BET 24%.',
            self::grades('CALL', 0, 76, 24, ['FOLD'=>0,'CALL'=>100,'4BET'=>86], [
                'FOLD'=>'Blunder absoluto.',
                'CALL'=>'Correcto. Mano fuerte con gran realización IP.',
                '4BET'=>'Buena mezcla, pero no obligatoria.',
            ]),
            'premium_continue',
            'Premium continue'
        );
    }

    protected static function kqsVsBb(): array
    {
        return self::base(['Ks','Qs'], 'BB', 'CALL',
            'KQs suited es una defensa muy fuerte contra BB 3Bet. No debe foldearse.',
            'GTO simplificado: FOLD 0%, CALL 78%, 4BET 22%.',
            self::grades('CALL', 0, 78, 22, ['FOLD'=>0,'CALL'=>100,'4BET'=>82], [
                'FOLD'=>'Blunder. KQs es demasiado fuerte.',
                'CALL'=>'Correcto. Excelente jugabilidad.',
                '4BET'=>'Mezcla posible, no automática.',
            ]),
            'suited_broadway',
            'Broadways suited'
        );
    }

    protected static function a9sVsBb(): array
    {
        return self::base(['Ad','9d'], 'BB', 'CALL',
            'A9s tiene blocker, nut flush potential y buena realización IP. Call es la línea educativa principal.',
            'GTO simplificado: FOLD 18%, CALL 68%, 4BET 14%.',
            self::grades('CALL', 18, 68, 14, ['FOLD'=>44,'CALL'=>100,'4BET'=>60], [
                'FOLD'=>'Algo tight contra BB amplio.',
                'CALL'=>'Correcto. Buena defensa suited Ax.',
                '4BET'=>'Mezcla baja; A5s-A2s suelen ser mejores bluffs.',
            ]),
            'borderline_suited',
            'Suited marginales'
        );
    }

    protected static function jtsVsBb(): array
    {
        return self::base(['Jd','Td'], 'BB', 'CALL',
            'JTs es una defensa excelente en posición: conecta con muchos boards y no está tan dominada como offsuit broadways.',
            'GTO simplificado: FOLD 8%, CALL 84%, 4BET 8%.',
            self::grades('CALL', 8, 84, 8, ['FOLD'=>20,'CALL'=>100,'4BET'=>52], [
                'FOLD'=>'Demasiado tight.',
                'CALL'=>'Correcto. Muy buena realización de equity.',
                '4BET'=>'Mezcla baja; no principal.',
            ]),
            'suited_connectors',
            'Suited connectors'
        );
    }

    protected static function pocket66VsBb(): array
    {
        return self::base(['6c','6d'], 'BB', 'CALL',
            '66 puede pagar IP por set value. No es una mano para 4Bet bluff.',
            'GTO simplificado: FOLD 30%, CALL 68%, 4BET 2%.',
            self::grades('CALL', 30, 68, 2, ['FOLD'=>70,'CALL'=>100,'4BET'=>10], [
                'FOLD'=>'Aceptable contra BB muy tight.',
                'CALL'=>'Correcto. Set value y posición.',
                '4BET'=>'Error: no bloquea valor y se aísla mal.',
            ]),
            'small_pairs',
            'Pocket pairs bajos'
        );
    }

    protected static function q9sVsBb(): array
    {
        return self::base(['Qh','9h'], 'BB', 'FOLD',
            'Q9s contra BB es más marginal que contra SB. Puede pagar contra rangos amplios, pero fold es base segura.',
            'GTO simplificado: FOLD 52%, CALL 44%, 4BET 4%.',
            self::grades('FOLD', 52, 44, 4, ['FOLD'=>100,'CALL'=>84,'4BET'=>18], [
                'FOLD'=>'Correcto como estrategia base.',
                'CALL'=>'Aceptable contra BB agresivo y débil postflop.',
                '4BET'=>'Demasiado fino.',
            ]),
            'borderline_suited',
            'Suited marginales'
        );
    }

    protected static function ajoVsBb(): array
    {
        return self::base(['Ac','Jh'], 'BB', 'FOLD',
            'AJo offsuit contra BB 3Bet está muy cerca, pero como base se foldea más que contra SB por dominación.',
            'GTO simplificado: FOLD 54%, CALL 40%, 4BET 6%.',
            self::grades('FOLD', 54, 40, 6, ['FOLD'=>100,'CALL'=>78,'4BET'=>24], [
                'FOLD'=>'Correcto como base disciplinada.',
                'CALL'=>'Puede existir contra BB muy amplio.',
                '4BET'=>'No es buen estándar; demasiadas veces te aíslas dominado.',
            ]),
            'dominated_offsuit',
            'Offsuit dominadas'
        );
    }

    protected static function k9sVsBb(): array
    {
        return self::base(['Kd','9d'], 'BB', 'CALL',
            'K9s conserva blocker y suitedness. Contra BB puede defenderse, aunque está más cerca del borde.',
            'GTO simplificado: FOLD 36%, CALL 58%, 4BET 6%.',
            self::grades('CALL', 36, 58, 6, ['FOLD'=>78,'CALL'=>100,'4BET'=>28], [
                'FOLD'=>'Aceptable contra rival tight.',
                'CALL'=>'Correcto contra BB con 3Bet razonable.',
                '4BET'=>'Demasiado fino como farol estándar.',
            ]),
            'borderline_suited',
            'Suited marginales'
        );
    }

    protected static function pocket22VsBb(): array
    {
        return self::base(['2h','2d'], 'BB', 'FOLD',
            '22 contra BB 3Bet y size 10 BB queda muy justo. Sin implied odds claras, fold evita spots difíciles.',
            'GTO simplificado: FOLD 54%, CALL 44%, 4BET 2%.',
            self::grades('FOLD', 54, 44, 2, ['FOLD'=>100,'CALL'=>86,'4BET'=>8], [
                'FOLD'=>'Correcto como base segura.',
                'CALL'=>'No es horrible, pero depende mucho de implied odds.',
                '4BET'=>'Mala idea: cero blockers.',
            ]),
            'small_pairs',
            'Pocket pairs bajos'
        );
    }

    protected static function t8sVsBb(): array
    {
        return self::base(['Ts','8s'], 'BB', 'FOLD',
            'T8s tiene jugabilidad, pero contra BB 3Bet suele quedar por debajo del rango rentable estándar.',
            'GTO simplificado: FOLD 56%, CALL 40%, 4BET 4%.',
            self::grades('FOLD', 56, 40, 4, ['FOLD'=>100,'CALL'=>78,'4BET'=>18], [
                'FOLD'=>'Correcto. No hay que defender todo lo suited.',
                'CALL'=>'Aceptable solo contra BB muy amplio y mal postflop.',
                '4BET'=>'Demasiado ambicioso.',
            ]),
            'suited_connectors',
            'Suited connectors'
        );
    }

    protected static function a2sVsBb(): array
    {
        return self::base(['Ac','2c'], 'BB', 'CALL',
            'A2s contra BB puede ser call o 4Bet bluff. Call es buena línea base porque realiza equity IP y mantiene bluffs.',
            'GTO simplificado: FOLD 16%, CALL 48%, 4BET 36%.',
            self::grades('CALL', 16, 48, 36, ['FOLD'=>36,'CALL'=>100,'4BET'=>92], [
                'FOLD'=>'Algo tight si BB 3betea suficiente.',
                'CALL'=>'Correcto. Buena defensa con blocker y nut potential.',
                '4BET'=>'Buena mezcla contra overfold a 4Bet.',
            ]),
            'ax_4bet_bluff',
            '4Bet bluff con Ax suited'
        );
    }


    protected static function spotId(string $villainPosition, array $cards): string
    {
        return 'btn_vs_3bet_' . strtolower($villainPosition) . '_' . self::cardsKey($cards);
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