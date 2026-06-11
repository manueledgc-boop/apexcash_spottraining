<?php

namespace App\SpotTraining\Postflop;

use App\SpotTraining\Concerns\BuildsSpotPlayers;

class PostflopSpotRepository
{
    use BuildsSpotPlayers;
    public function all(): array
    {
        return [
            $this->cbetIpDryAceHigh(),
            $this->cbetIpTopPairValue(),
            $this->checkBackMediumShowdown(),
            $this->defendVsCbetTopPair(),
            $this->defendVsCbetAirNoBackdoors(),
            $this->checkRaiseComboDraw(),
            $this->valueBetVsMissedCbet(),
            $this->semiBluffNutFlushDraw(),
            $this->avoidOverCbetWetBoard(),
            $this->stabTurnSetupFlopCheck(),
        ];
    }

    public function findById(string $spotId): ?array
    {
        foreach ($this->all() as $spot) {
            if (($spot['id'] ?? null) === $spotId) {
                return $spot;
            }
        }

        return null;
    }

    public function random(?string $module = null, ?string $concept = null): array
    {
        $spots = array_values(array_filter($this->all(), function (array $spot) use ($module, $concept): bool {
            if ($module && ($spot['module'] ?? null) !== $module) {
                return false;
            }

            if ($concept && ($spot['concept'] ?? null) !== $concept) {
                return false;
            }

            return true;
        }));

        if (empty($spots)) {
            $spots = $this->all();
        }

        return $spots[array_rand($spots)];
    }

    public function normalize(array $spot): array
    {
        $spot['spot_id'] = $spot['id'];
        $spot['street'] = $spot['street'] ?? 'flop';
        $spot['difficulty'] = $spot['difficulty'] ?? 'Postflop V1';
        $spot['confidence'] = $spot['confidence'] ?? 75;
        $spot['table_players'] = self::defaultPlayers(
            $spot['hero_position'] ?? 'BTN',
            $spot['villain_position'] ?? null
        );
        $spot['insights'] = $spot['insights'] ?? ['gto' => null, 'low_stakes' => null];

        return $spot;
    }

    protected function cbetIpDryAceHigh(): array
    {
        return [
            'id' => 'pf_cbet_ip_a72r_btn_vs_bb_ak',
            'module' => 'cbet_ip',
            'module_label' => 'C-Bet IP',
            'family' => 'single_raised_pot',
            'family_label' => 'Single Raised Pot',
            'concept' => 'range_advantage_cbet',
            'concept_label' => 'C-bet por ventaja de rango',
            'title' => 'BTN vs BB · A72 rainbow',
            'street' => 'flop',
            'hero_position' => 'BTN',
            'villain_position' => 'BB',
            'hero_cards' => ['Ah', 'Kh'],
            'board_cards' => ['Ad', '7c', '2s'],
            'pot_bb' => 5.5,
            'spr' => 8.6,
            'effective_stack_bb' => 47.5,
            'board_texture' => 'Board seco alto · rainbow',
            'range_advantage' => 'Hero tiene ventaja clara de rango.',
            'nut_advantage' => 'Hero conserva muchos Ax fuertes; BB tiene más pares débiles.',
            'actions' => ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♦ 7♣ 2♠', 'BB checks', 'Action on Hero BTN'],
            'options' => ['CHECK', 'BET_33', 'BET_66'],
            'answers' => [
                'gto' => [
                    'correct_action' => 'BET_33',
                    'explanation' => 'En A72 rainbow el agresor preflop tiene mucha ventaja de rango. La apuesta pequeña imprime presión a manos sin As, cobra a pares bajos y mantiene dominados dentro.',
                    'solver_note' => 'GTO simplificado: apostar pequeño con alta frecuencia.',
                    'action_grades' => [
                        'BET_33' => ['grade' => 'best', 'frequency' => 82, 'ev_score' => 88, 'feedback' => 'Mejor acción. Apuesta pequeña frecuente por ventaja de rango y buen top pair/top kicker.'],
                        'BET_66' => ['grade' => 'marginal', 'frequency' => 18, 'ev_score' => 66, 'feedback' => 'Demasiado grande para este board seco. Aísla contra manos mejores y foldea demasiada basura que quieres presionar barato.'],
                        'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 52, 'feedback' => 'Pierdes valor y protección en un board donde tu rango puede apostar mucho.'],
                    ],
                ],
            ],
            'insights' => [
                'gto' => 'Apuesta pequeña con alta frecuencia. Tu rango tiene más Ax fuertes que BB.',
                'low_stakes' => 'En NL2-NL10 muchos rivales pagan cualquier pareja y Ax peor. Bet pequeño por valor y protección; reduce checks pasivos con top pair fuerte.',
            ],
            'confidence' => 88,
        ];
    }

    protected function cbetIpTopPairValue(): array
    {
        return [
            'id' => 'pf_cbet_ip_q72r_btn_vs_bb_kq',
            'module' => 'cbet_ip',
            'module_label' => 'C-Bet IP',
            'family' => 'single_raised_pot',
            'family_label' => 'Single Raised Pot',
            'concept' => 'thin_value_protection',
            'concept_label' => 'Valor + protección',
            'title' => 'BTN vs BB · Q72 rainbow',
            'street' => 'flop',
            'hero_position' => 'BTN',
            'villain_position' => 'BB',
            'hero_cards' => ['Kc', 'Qd'],
            'board_cards' => ['Qs', '7d', '2c'],
            'pot_bb' => 5.5,
            'spr' => 8.6,
            'effective_stack_bb' => 47.5,
            'board_texture' => 'Board seco con top pair medio-alto',
            'range_advantage' => 'Hero tiene ventaja moderada de rango.',
            'nut_advantage' => 'Hero tiene mejores Qx; BB tiene sets y dobles muy ocasionales.',
            'actions' => ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♦ 2♣', 'BB checks', 'Action on Hero BTN'],
            'options' => ['CHECK', 'BET_33', 'BET_66'],
            'answers' => [
                'gto' => [
                    'correct_action' => 'BET_33',
                    'explanation' => 'Top pair con buen kicker quiere valor de Qx peores, 7x y pares medios. En board seco, sizing pequeño funciona muy bien.',
                    'solver_note' => 'GTO simplificado: bet pequeño por valor y protección.',
                    'action_grades' => [
                        'BET_33' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 84, 'feedback' => 'Correcto. Cobras a peores y mantienes rango amplio pagando.'],
                        'BET_66' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 74, 'feedback' => 'Puede ser válido contra calling stations, pero como estándar prefiero pequeño.'],
                        'CHECK' => ['grade' => 'mistake', 'frequency' => 16, 'ev_score' => 55, 'feedback' => 'Demasiado pasivo. Dejas equity gratis a manos como JT, T9, A7 y pares bajos.'],
                    ],
                ],
            ],
            'insights' => [
                'gto' => 'Top pair buen kicker apuesta mucho en board seco, especialmente con sizing pequeño.',
                'low_stakes' => 'En microlímites te pagan Q peores, 7x y pares. Bet por valor; no regales carta por miedo al set.',
            ],
            'confidence' => 84,
        ];
    }

    protected function checkBackMediumShowdown(): array
    {
        return [
            'id' => 'pf_checkback_ip_k72r_btn_vs_bb_88',
            'module' => 'check_back_ip',
            'module_label' => 'Check Back IP',
            'family' => 'single_raised_pot',
            'family_label' => 'Single Raised Pot',
            'concept' => 'showdown_value_control',
            'concept_label' => 'Showdown value y control',
            'title' => 'BTN vs BB · K72 rainbow con 88',
            'street' => 'flop',
            'hero_position' => 'BTN',
            'villain_position' => 'BB',
            'hero_cards' => ['8c', '8d'],
            'board_cards' => ['Ks', '7h', '2c'],
            'pot_bb' => 5.5,
            'spr' => 8.6,
            'effective_stack_bb' => 47.5,
            'board_texture' => 'Board seco alto',
            'range_advantage' => 'Hero tiene ventaja de rango, pero esta mano concreta no quiere inflar bote.',
            'nut_advantage' => 'Hero tiene Kx fuertes; 88 tiene valor medio.',
            'actions' => ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♥ 2♣', 'BB checks', 'Action on Hero BTN'],
            'options' => ['CHECK', 'BET_33', 'BET_66'],
            'answers' => [
                'gto' => [
                    'correct_action' => 'CHECK',
                    'explanation' => '88 tiene showdown value pero no quiere recibir check-raise ni construir un bote grande. Check back protege tu rango de check y permite pagar turns razonables.',
                    'solver_note' => 'GTO simplificado: algunas parejas medias se chequean para controlar bote.',
                    'action_grades' => [
                        'CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 82, 'feedback' => 'Muy bien. Controlas bote con showdown value medio.'],
                        'BET_33' => ['grade' => 'marginal', 'frequency' => 35, 'ev_score' => 67, 'feedback' => 'No es desastre, pero conviertes una mano con showdown en una apuesta poco clara.'],
                        'BET_66' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 25, 'feedback' => 'Sizing grande sin valor claro. Te aíslas contra Kx y folds de manos peores.'],
                    ],
                ],
            ],
            'insights' => [
                'gto' => 'No todo el rango con ventaja apuesta. Las parejas medias protegen el check back.',
                'low_stakes' => 'En NL2-NL10 evita apostar por “ver dónde estás”. Con 88 en K72r, check back y juega turns simples.',
            ],
            'confidence' => 80,
        ];
    }

    protected function defendVsCbetTopPair(): array
    {
        return [
            'id' => 'pf_defend_vs_cbet_q72r_bb_vs_btn_qj',
            'module' => 'defense_vs_cbet',
            'module_label' => 'Defensa vs C-Bet',
            'family' => 'single_raised_pot',
            'family_label' => 'Single Raised Pot',
            'concept' => 'call_top_pair',
            'concept_label' => 'Pagar top pair',
            'title' => 'BB vs BTN · Top pair vs c-bet',
            'street' => 'flop',
            'hero_position' => 'BB',
            'villain_position' => 'BTN',
            'hero_cards' => ['Qh', 'Jc'],
            'board_cards' => ['Qs', '7d', '2c'],
            'pot_bb' => 7.3,
            'spr' => 6.7,
            'effective_stack_bb' => 49.0,
            'board_texture' => 'Board seco con top pair',
            'range_advantage' => 'BTN tiene ventaja de rango; BB tiene muchos pares y defensas medias.',
            'nut_advantage' => 'BB puede tener sets; BTN tiene Qx mejores.',
            'actions' => ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♦ 2♣', 'BB checks', 'BTN bets 1.8 BB', 'Action on Hero BB'],
            'options' => ['FOLD', 'CALL', 'RAISE'],
            'answers' => [
                'gto' => [
                    'correct_action' => 'CALL',
                    'explanation' => 'Top pair con kicker medio es demasiado fuerte para foldear y normalmente no necesita subir. Call mantiene bluffs y Qx peores dentro.',
                    'solver_note' => 'GTO simplificado: call estándar con top pair media.',
                    'action_grades' => [
                        'CALL' => ['grade' => 'best', 'frequency' => 86, 'ev_score' => 88, 'feedback' => 'Correcto. Mantienes el rango del rival amplio.'],
                        'RAISE' => ['grade' => 'marginal', 'frequency' => 12, 'ev_score' => 58, 'feedback' => 'Subir top pair media suele aislarte contra mejores y foldear bluffs.'],
                        'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Fold demasiado débil. Top pair no se foldea ante c-bet pequeña estándar.'],
                    ],
                ],
            ],
            'insights' => [
                'gto' => 'Top pair media defiende casi siempre contra sizing pequeño.',
                'low_stakes' => 'No foldees demasiado vs c-bets pequeñas. Muchos jugadores apuestan automático con aire y proyectos.',
            ],
            'confidence' => 90,
        ];
    }

    protected function defendVsCbetAirNoBackdoors(): array
    {
        return [
            'id' => 'pf_defend_vs_cbet_a72r_bb_vs_btn_j9',
            'module' => 'defense_vs_cbet',
            'module_label' => 'Defensa vs C-Bet',
            'family' => 'single_raised_pot',
            'family_label' => 'Single Raised Pot',
            'concept' => 'fold_no_equity',
            'concept_label' => 'Foldear sin equity',
            'title' => 'BB vs BTN · Aire sin backdoors',
            'street' => 'flop',
            'hero_position' => 'BB',
            'villain_position' => 'BTN',
            'hero_cards' => ['Jc', '9d'],
            'board_cards' => ['As', '7h', '2c'],
            'pot_bb' => 7.3,
            'spr' => 6.7,
            'effective_stack_bb' => 49.0,
            'board_texture' => 'A-high seco rainbow',
            'range_advantage' => 'BTN tiene clara ventaja de rango.',
            'nut_advantage' => 'BTN tiene más Ax fuertes.',
            'actions' => ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♥ 2♣', 'BB checks', 'BTN bets 1.8 BB', 'Action on Hero BB'],
            'options' => ['FOLD', 'CALL', 'RAISE'],
            'answers' => [
                'gto' => [
                    'correct_action' => 'FOLD',
                    'explanation' => 'J9o sin backdoor relevante, sin pareja y sin proyecto no tiene suficiente equity ni jugabilidad. Defender esto abre una fuga clara.',
                    'solver_note' => 'GTO simplificado: foldea aire sin backdoors ante c-bet en A-high seco.',
                    'action_grades' => [
                        'FOLD' => ['grade' => 'best', 'frequency' => 92, 'ev_score' => 80, 'feedback' => 'Correcto. No defiendas manos sin equity.'],
                        'CALL' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 30, 'feedback' => 'Call flotando sin plan. Vas a abandonar demasiados turns.'],
                        'RAISE' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 12, 'feedback' => 'Bluff malo: sin blockers fuertes ni equity.'],
                    ],
                ],
            ],
            'insights' => [
                'gto' => 'Defiende manos con pareja, backdoors o equity. Aire total se foldea.',
                'low_stakes' => 'En microlímites no intentes “outplayear” con aire. Ahorras mucho dinero foldeando basura sin equity.',
            ],
            'confidence' => 86,
        ];
    }

    protected function checkRaiseComboDraw(): array
    {
        return [
            'id' => 'pf_xraise_combo_draw_bb_vs_btn_t98ss_qsjs',
            'module' => 'check_raise',
            'module_label' => 'Check-Raise Flop',
            'family' => 'single_raised_pot',
            'family_label' => 'Single Raised Pot',
            'concept' => 'semi_bluff_equity',
            'concept_label' => 'Semi-bluff con equity',
            'title' => 'BB vs BTN · Combo draw',
            'street' => 'flop',
            'hero_position' => 'BB',
            'villain_position' => 'BTN',
            'hero_cards' => ['Qs', 'Js'],
            'board_cards' => ['Ts', '9s', '2d'],
            'pot_bb' => 8.1,
            'spr' => 6.1,
            'effective_stack_bb' => 49.0,
            'board_texture' => 'Board dinámico con proyectos',
            'range_advantage' => 'BTN tiene ventaja de rango general; BB conecta muy fuerte con T9x.',
            'nut_advantage' => 'BB tiene más dobles, sets y escaleras ocultas.',
            'actions' => ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♠ 2♦', 'BB checks', 'BTN bets 2.6 BB', 'Action on Hero BB'],
            'options' => ['FOLD', 'CALL', 'RAISE'],
            'answers' => [
                'gto' => [
                    'correct_action' => 'RAISE',
                    'explanation' => 'QJs con proyecto de color, gutshot y overcards tiene mucha equity y fold equity. Es una mano excelente para check-raise semi-bluff.',
                    'solver_note' => 'GTO simplificado: subir draws fuertes en boards donde BB tiene nuts.',
                    'action_grades' => [
                        'RAISE' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 90, 'feedback' => 'Excelente. Presionas overcards, pares medios y proyectos peores con mucha equity.'],
                        'CALL' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 78, 'feedback' => 'Call también es jugable, pero pierdes fold equity con una mano muy fuerte.'],
                        'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'Nunca foldees un combo draw tan fuerte ante c-bet.'],
                    ],
                ],
            ],
            'insights' => [
                'gto' => 'Los draws fuertes mezclan call y raise. Raise gana fold equity y construye bote cuando completas.',
                'low_stakes' => 'Contra rivales que pagan demasiado, sube draws fuertes con equity real, no faroles vacíos. Si pagan, todavía tienes muchas outs.',
            ],
            'confidence' => 82,
        ];
    }

    protected function valueBetVsMissedCbet(): array
    {
        return [
            'id' => 'pf_value_vs_check_co_vs_bb_kj_k72',
            'module' => 'value_bet',
            'module_label' => 'Value Bet Flop',
            'family' => 'single_raised_pot',
            'family_label' => 'Single Raised Pot',
            'concept' => 'value_when_checked_to',
            'concept_label' => 'Valor cuando chequean',
            'title' => 'CO vs BB · Top pair vs check',
            'street' => 'flop',
            'hero_position' => 'CO',
            'villain_position' => 'BB',
            'hero_cards' => ['Kc', 'Jc'],
            'board_cards' => ['Kd', '7s', '2h'],
            'pot_bb' => 5.5,
            'spr' => 8.8,
            'effective_stack_bb' => 48.5,
            'board_texture' => 'K-high seco',
            'range_advantage' => 'Hero tiene ventaja de rango.',
            'nut_advantage' => 'Hero tiene mejores Kx; BB tiene sets ocasionales.',
            'actions' => ['CO opens 2.5 BB', 'BB calls', 'Flop: K♦ 7♠ 2♥', 'BB checks', 'Action on Hero CO'],
            'options' => ['CHECK', 'BET_33', 'BET_66'],
            'answers' => [
                'gto' => [
                    'correct_action' => 'BET_33',
                    'explanation' => 'Top pair buen kicker debe apostar por valor contra Kx peores, 7x y pares. En board seco, pequeño es suficiente.',
                    'solver_note' => 'GTO simplificado: bet pequeño por valor.',
                    'action_grades' => [
                        'BET_33' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 86, 'feedback' => 'Correcto. Valor claro sin expulsar demasiadas manos peores.'],
                        'BET_66' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 77, 'feedback' => 'Puede estar bien vs recreacionales calling station, pero estándar pequeño.'],
                        'CHECK' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 48, 'feedback' => 'Pierdes valor contra muchas manos peores que pagan.'],
                    ],
                ],
            ],
            'insights' => [
                'gto' => 'Apuesta top pair buen kicker por valor en board seco.',
                'low_stakes' => 'La gente paga demasiado con pares y K peores. No hagas slowplay innecesario: apuesta por valor.',
            ],
            'confidence' => 86,
        ];
    }

    protected function semiBluffNutFlushDraw(): array
    {
        return [
            'id' => 'pf_semibluff_nfd_btn_vs_bb_k72ss_asqs',
            'module' => 'semi_bluff',
            'module_label' => 'Semi-Bluff Flop',
            'family' => 'single_raised_pot',
            'family_label' => 'Single Raised Pot',
            'concept' => 'nut_draw_pressure',
            'concept_label' => 'Presión con nut draw',
            'title' => 'BTN vs BB · Nut flush draw',
            'street' => 'flop',
            'hero_position' => 'BTN',
            'villain_position' => 'BB',
            'hero_cards' => ['As', 'Qs'],
            'board_cards' => ['Ks', '7s', '2d'],
            'pot_bb' => 5.5,
            'spr' => 8.6,
            'effective_stack_bb' => 47.5,
            'board_texture' => 'K-high con proyecto de color',
            'range_advantage' => 'Hero tiene ventaja de rango.',
            'nut_advantage' => 'Hero tiene Kx fuertes y nut flush draws.',
            'actions' => ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♠ 2♦', 'BB checks', 'Action on Hero BTN'],
            'options' => ['CHECK', 'BET_33', 'BET_66'],
            'answers' => [
                'gto' => [
                    'correct_action' => 'BET_33',
                    'explanation' => 'Nut flush draw con overcard y blockers quiere apostar frecuentemente. Gana fold equity y construye bote cuando completa.',
                    'solver_note' => 'GTO simplificado: semi-bluff pequeño frecuente con nut draw.',
                    'action_grades' => [
                        'BET_33' => ['grade' => 'best', 'frequency' => 74, 'ev_score' => 87, 'feedback' => 'Excelente semi-bluff. Tienes equity, blockers y fold equity.'],
                        'BET_66' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 79, 'feedback' => 'También jugable, pero no hace falta usar grande como estándar.'],
                        'CHECK' => ['grade' => 'marginal', 'frequency' => 26, 'ev_score' => 65, 'feedback' => 'Check no es horrible, pero pierdes fold equity con una mano ideal para apostar.'],
                    ],
                ],
            ],
            'insights' => [
                'gto' => 'Los nut draws pueden apostar por equity + fold equity.',
                'low_stakes' => 'Farolea menos con aire, pero sí presiona con proyectos fuertes. Si pagan, tu mano todavía puede mejorar mucho.',
            ],
            'confidence' => 82,
        ];
    }

    protected function avoidOverCbetWetBoard(): array
    {
        return [
            'id' => 'pf_avoid_cbet_wet_jt9ss_btn_vs_bb_a5',
            'module' => 'check_back_ip',
            'module_label' => 'Check Back IP',
            'family' => 'single_raised_pot',
            'family_label' => 'Single Raised Pot',
            'concept' => 'bad_bluff_texture',
            'concept_label' => 'Mal board para farol vacío',
            'title' => 'BTN vs BB · JT9ss con A5o',
            'street' => 'flop',
            'hero_position' => 'BTN',
            'villain_position' => 'BB',
            'hero_cards' => ['Ah', '5c'],
            'board_cards' => ['Js', 'Ts', '9d'],
            'pot_bb' => 5.5,
            'spr' => 8.6,
            'effective_stack_bb' => 47.5,
            'board_texture' => 'Board muy conectado y dinámico',
            'range_advantage' => 'BB conecta muy bien con este board.',
            'nut_advantage' => 'BB tiene muchas dobles, escaleras y proyectos fuertes.',
            'actions' => ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ T♠ 9♦', 'BB checks', 'Action on Hero BTN'],
            'options' => ['CHECK', 'BET_33', 'BET_66'],
            'answers' => [
                'gto' => [
                    'correct_action' => 'CHECK',
                    'explanation' => 'A5o sin proyecto real bloquea poco y tiene mala jugabilidad. En board muy conectado, BB conecta demasiado para hacer c-bet automática.',
                    'solver_note' => 'GTO simplificado: reduce c-bets con aire en boards conectados que favorecen a BB.',
                    'action_grades' => [
                        'CHECK' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 80, 'feedback' => 'Correcto. No tires dinero en un board que favorece al defensor.'],
                        'BET_33' => ['grade' => 'mistake', 'frequency' => 16, 'ev_score' => 42, 'feedback' => 'C-bet automática mala. Recibes muchos calls y raises.'],
                        'BET_66' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 18, 'feedback' => 'Bluff grande sin equity en mal board. Error caro.'],
                    ],
                ],
            ],
            'insights' => [
                'gto' => 'No todos los boards son para c-bet. En JT9ss BB conecta muchísimo.',
                'low_stakes' => 'En NL2-NL10 te pagan pares, gutshots, proyectos y cualquier cosa conectada. No farolees boards mojados sin equity.',
            ],
            'confidence' => 84,
        ];
    }

    protected function stabTurnSetupFlopCheck(): array
    {
        return [
            'id' => 'pf_check_back_plan_a72r_btn_vs_bb_55',
            'module' => 'check_back_ip',
            'module_label' => 'Check Back IP',
            'family' => 'single_raised_pot',
            'family_label' => 'Single Raised Pot',
            'concept' => 'future_street_plan',
            'concept_label' => 'Plan de calles futuras',
            'title' => 'BTN vs BB · Pareja baja con plan',
            'street' => 'flop',
            'hero_position' => 'BTN',
            'villain_position' => 'BB',
            'hero_cards' => ['5h', '5d'],
            'board_cards' => ['As', '7c', '2d'],
            'pot_bb' => 5.5,
            'spr' => 8.6,
            'effective_stack_bb' => 47.5,
            'board_texture' => 'A-high seco',
            'range_advantage' => 'Hero tiene ventaja de rango.',
            'nut_advantage' => 'Hero tiene Ax fuertes; 55 tiene showdown value débil.',
            'actions' => ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♣ 2♦', 'BB checks', 'Action on Hero BTN'],
            'options' => ['CHECK', 'BET_33', 'BET_66'],
            'answers' => [
                'gto' => [
                    'correct_action' => 'CHECK',
                    'explanation' => 'Aunque Hero tiene ventaja de rango, 55 tiene valor de showdown débil y pocas calles de valor. Check back permite llegar a showdown y apostar algunos turns favorables.',
                    'solver_note' => 'GTO simplificado: mezcla checks con pares bajos para proteger rango y controlar bote.',
                    'action_grades' => [
                        'CHECK' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 78, 'feedback' => 'Buena línea. Controlas bote y no conviertes 55 en farol innecesario.'],
                        'BET_33' => ['grade' => 'marginal', 'frequency' => 42, 'ev_score' => 65, 'feedback' => 'Puede funcionar por fold equity, pero no debe ser automática con todas las parejas bajas.'],
                        'BET_66' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 32, 'feedback' => 'Grande no tiene sentido: te pagan Ax/7x y foldean basura.'],
                    ],
                ],
            ],
            'insights' => [
                'gto' => 'La ventaja de rango no obliga a apostar toda mano. 55 puede chequear para controlar bote.',
                'low_stakes' => 'No conviertas pares bajos en faroles caros. En límites bajos te pagarán Ax y muchos 7x. Check back es simple y rentable.',
            ],
            'confidence' => 76,
        ];
    }
}
