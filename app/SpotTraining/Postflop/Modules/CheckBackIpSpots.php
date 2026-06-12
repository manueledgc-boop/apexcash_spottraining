<?php

namespace App\SpotTraining\Postflop\Modules;

use App\SpotTraining\Postflop\Concerns\BuildsPostflopSpots;

class CheckBackIpSpots
{
    use BuildsPostflopSpots;

    public static function all(): array
    {
        return [
            self::checkBackMediumShowdown(),
            self::avoidOverCbetWetBoard(),
            self::stabTurnSetupFlopCheck(),
            self::checkBackT98Ako(),
            self::checkBack876Aqo(),
            self::checkBackKqj55(),
            self::checkBackQ84_77(),
            self::checkBackK83_66(),
            self::checkBackA72_TT(),
            self::checkBackA98_JJ(),
        ];
    }

    protected static function checkBackMediumShowdown(): array
    {
        return self::spot(
            'pf_checkback_ip_k72r_btn_vs_bb_88',
            'check_back_ip',
            'Check Back IP',
            'showdown_value_control',
            'Showdown value y control',
            'BTN vs BB · K72 rainbow con 88',
            'BTN',
            'BB',
            ['8c', '8d'],
            ['Ks', '7h', '2c'],
            5.5,
            9,
            47.5,
            'Board seco alto',
            'Hero tiene ventaja de rango, pero esta mano concreta no quiere inflar bote.',
            'Hero tiene Kx fuertes; 88 tiene valor medio.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♥ 2♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            '88 tiene showdown value pero no quiere recibir check-raise ni construir un bote grande.',
            'GTO simplificado: parejas medias se chequean para controlar bote.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 82, 'feedback' => 'Muy bien. Controlas bote con showdown value medio.'],
                'BET_33' => ['grade' => 'marginal', 'frequency' => 35, 'ev_score' => 67, 'feedback' => 'No es desastre, pero conviertes una mano con showdown en una apuesta poco clara.'],
                'BET_66' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 25, 'feedback' => 'Sizing grande sin valor claro.'],
            ],
            'No todo el rango con ventaja apuesta. Las parejas medias protegen el check back.',
            'En NL2-NL10 evita apostar por “ver dónde estás”. Check back y juega turns simples.',
            80
        );
    }

    protected static function avoidOverCbetWetBoard(): array
    {
        return self::spot(
            'pf_avoid_cbet_wet_jt9ss_btn_vs_bb_a5',
            'check_back_ip',
            'Check Back IP',
            'bad_bluff_texture',
            'Mal board para farol vacío',
            'BTN vs BB · JT9ss con A5o',
            'BTN',
            'BB',
            ['Ah', '5c'],
            ['Js', 'Ts', '9d'],
            5.5,
            9,
            47.5,
            'Board muy conectado y dinámico',
            'BB conecta muy bien con este board.',
            'BB tiene muchas dobles, escaleras y proyectos fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ T♠ 9♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            'A5o sin proyecto real bloquea poco y tiene mala jugabilidad. En board conectado, BB conecta demasiado para c-bet automática.',
            'GTO simplificado: reduce c-bets con aire en boards conectados.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 80, 'feedback' => 'Correcto. No tires dinero en un board que favorece al defensor.'],
                'BET_33' => ['grade' => 'mistake', 'frequency' => 16, 'ev_score' => 42, 'feedback' => 'C-bet automática mala. Recibes muchos calls y raises.'],
                'BET_66' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 18, 'feedback' => 'Bluff grande sin equity en mal board.'],
            ],
            'No todos los boards son para c-bet. En JT9ss BB conecta muchísimo.',
            'En NL2-NL10 te pagan pares, gutshots, proyectos y cualquier cosa conectada. No farolees boards mojados sin equity.',
            84
        );
    }

    protected static function stabTurnSetupFlopCheck(): array
    {
        return self::spot(
            'pf_check_back_plan_a72r_btn_vs_bb_55',
            'check_back_ip',
            'Check Back IP',
            'future_street_plan',
            'Plan de calles futuras',
            'BTN vs BB · Pareja baja con plan',
            'BTN',
            'BB',
            ['5h', '5d'],
            ['As', '7c', '2d'],
            5.5,
            9,
            47.5,
            'A-high seco',
            'Hero tiene ventaja de rango.',
            'Hero tiene Ax fuertes; 55 tiene showdown value débil.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♣ 2♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            '55 tiene valor de showdown débil y pocas calles de valor. Check back permite llegar a showdown y apostar algunos turns favorables.',
            'GTO simplificado: mezcla checks con pares bajos para proteger rango.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 66, 'ev_score' => 78, 'feedback' => 'Buena línea. Controlas bote y no conviertes 55 en farol innecesario.'],
                'BET_33' => ['grade' => 'marginal', 'frequency' => 42, 'ev_score' => 65, 'feedback' => 'Puede funcionar, pero no debe ser automática.'],
                'BET_66' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 32, 'feedback' => 'Grande no tiene sentido.'],
            ],
            'La ventaja de rango no obliga a apostar toda mano. 55 puede chequear para controlar bote.',
            'No conviertas pares bajos en faroles caros. En límites bajos te pagarán Ax y muchos 7x.',
            76
        );
    }

    protected static function checkBackT98Ako(): array
    {
        return self::spot(
            'pf_checkback_t98ss_btn_vs_bb_ako',
            'check_back_ip',
            'Check Back IP',
            'wet_board_air_control',
            'Control en board mojado',
            'BTN vs BB · T98ss con AKo',
            'BTN',
            'BB',
            ['Ah', 'Kd'],
            ['Ts', '9s', '8d'],
            5.5,
            9,
            47.5,
            'Board muy conectado y con color draw',
            'BB conecta muy fuerte con T98.',
            'BB tiene más dobles, escaleras y proyectos fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♠ 8♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            'AKo tiene overcards pero poca fold equity real. Este board impacta demasiado al rango de BB.',
            'GTO simplificado: check back con aire en boards muy conectados.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 78, 'feedback' => 'Correcto. Evitas meter dinero sin equity real.'],
                'BET_33' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 40, 'feedback' => 'Demasiado automático. BB continúa muchísimo.'],
                'BET_66' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 15, 'feedback' => 'Farol grande muy malo.'],
            ],
            'En T98ss el defensor tiene muchísimas manos que continúan.',
            'En NL2-NL10 te pagan demasiado. No farolees aire en boards mojados.',
            80
        );
    }

    protected static function checkBack876Aqo(): array
    {
        return self::spot(
            'pf_checkback_876r_co_vs_bb_aqo',
            'check_back_ip',
            'Check Back IP',
            'low_connected_check',
            'Check en board bajo conectado',
            'CO vs BB · 876 rainbow con AQo',
            'CO',
            'BB',
            ['As', 'Qh'],
            ['8d', '7c', '6s'],
            5.5,
            9,
            48.5,
            'Board bajo conectado rainbow',
            'BB conecta más con esta textura.',
            'BB tiene más dobles y escaleras.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: 8♦ 7♣ 6♠', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            'AQo no tiene pareja ni proyecto claro. En 876, BB tiene muchas manos que pagan o resuben.',
            'GTO simplificado: check back frecuente en boards bajos conectados.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 74, 'ev_score' => 76, 'feedback' => 'Correcto. Este no es un buen board para presión con aire.'],
                'BET_33' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 52, 'feedback' => 'Puede tener algo de fold equity, pero es frágil.'],
                'BET_66' => ['grade' => 'blunder', 'frequency' => 3, 'ev_score' => 14, 'feedback' => 'Farol caro sin equity.'],
            ],
            'Board bajo conectado favorece al caller de BB.',
            'En microlímites te pagarán pares, gutshots y draws. Check back ahorra dinero.',
            78
        );
    }

    protected static function checkBackKqj55(): array
    {
        return self::spot(
            'pf_checkback_kqjss_btn_vs_bb_55',
            'check_back_ip',
            'Check Back IP',
            'medium_pair_bad_texture',
            'Pareja baja en board malo',
            'BTN vs BB · KQJss con 55',
            'BTN',
            'BB',
            ['5c', '5d'],
            ['Ks', 'Qs', 'Jh'],
            5.5,
            9,
            47.5,
            'Board alto, conectado y con proyecto',
            'Hero tiene broadways fuertes, pero 55 no realiza bien.',
            'Ambos tienen manos fuertes; BB continúa mucho.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ Q♠ J♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            '55 no tiene valor ni blockers útiles. Apostar convierte una mano débil en farol de baja calidad.',
            'GTO simplificado: check con parejas bajas sin equity en boards altos conectados.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 82, 'ev_score' => 74, 'feedback' => 'Bien. No quemas dinero con una mano sin futuro.'],
                'BET_33' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 35, 'feedback' => 'Farol pobre. Muchos calls.'],
                'BET_66' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 10, 'feedback' => 'Farol grande sin sentido.'],
            ],
            'Las parejas bajas sin equity se chequean mucho en boards altos conectados.',
            'En NL2-NL10 no intentes representar demasiado: te pagarán muchos proyectos y pares.',
            76
        );
    }

    protected static function checkBackQ84_77(): array
    {
        return self::spot(
            'pf_checkback_q84r_btn_vs_bb_77',
            'check_back_ip',
            'Check Back IP',
            'showdown_value_medium_pair',
            'Pareja media showdown value',
            'BTN vs BB · Q84 rainbow con 77',
            'BTN',
            'BB',
            ['7h', '7c'],
            ['Qs', '8d', '4c'],
            5.5,
            9,
            47.5,
            'Board seco Q-high',
            'Hero tiene ventaja de rango.',
            'Hero tiene Qx fuertes; 77 tiene showdown value.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 8♦ 4♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            '77 tiene suficiente showdown value. Apostar convierte una mano razonable en un farol innecesario.',
            'GTO simplificado: muchas parejas medias chequean.',
            [
                'CHECK' => ['grade'=>'best','frequency'=>72,'ev_score'=>80,'feedback'=>'Correcto. Controlas bote con showdown value.'],
                'BET_33' => ['grade'=>'marginal','frequency'=>28,'ev_score'=>60,'feedback'=>'No es terrible, pero no hace falta.'],
                'BET_66' => ['grade'=>'mistake','frequency'=>4,'ev_score'=>25,'feedback'=>'Demasiado grande.'],
            ],
            'Las parejas medias suelen preferir control de bote.',
            'En NL2-NL10 evita apostar por información.',
            80
        );
    }

    protected static function checkBackK83_66(): array
    {
        return self::spot(
            'pf_checkback_k83r_btn_vs_bb_66',
            'check_back_ip',
            'Check Back IP',
            'medium_pair_control',
            'Control con pareja media',
            'BTN vs BB · K83 rainbow con 66',
            'BTN',
            'BB',
            ['6h', '6c'],
            ['Ks', '8d', '3c'],
            5.5,
            9,
            47.5,
            'K-high seco',
            'Hero tiene ventaja de rango.',
            'Hero tiene Kx fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 8♦ 3♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            '66 no necesita construir un bote grande y puede llegar al showdown con frecuencia razonable.',
            'GTO simplificado: control de bote con showdown value medio.',
            [
                'CHECK' => ['grade'=>'best','frequency'=>74,'ev_score'=>78,'feedback'=>'Correcto.'],
                'BET_33' => ['grade'=>'marginal','frequency'=>24,'ev_score'=>55,'feedback'=>'No es necesaria.'],
                'BET_66' => ['grade'=>'mistake','frequency'=>4,'ev_score'=>22,'feedback'=>'Demasiado agresiva.'],
            ],
            'No conviertas todas las parejas medias en farol.',
            'En microlímites esta apuesta recibe demasiados calls.',
            78
        );
    }

    protected static function checkBackA72_TT(): array
    {
        return self::spot(
            'pf_checkback_a72r_btn_vs_bb_tt',
            'check_back_ip',
            'Check Back IP',
            'underpair_showdown_value',
            'Underpair con showdown value',
            'BTN vs BB · A72 rainbow con TT',
            'BTN',
            'BB',
            ['Th', 'Tc'],
            ['As', '7d', '2c'],
            5.5,
            9,
            47.5,
            'A-high seco',
            'Hero tiene ventaja de rango.',
            'Hero tiene muchos Ax fuertes.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 7♦ 2♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            'TT todavía gana a muchas manos peores. Apostar no consigue tres calles de valor ni demasiados folds mejores.',
            'GTO simplificado: underpairs fuertes mezclan check.',
            [
                'CHECK' => ['grade'=>'best','frequency'=>68,'ev_score'=>82,'feedback'=>'Muy bien.'],
                'BET_33' => ['grade'=>'good','frequency'=>36,'ev_score'=>68,'feedback'=>'Puede mezclarse.'],
                'BET_66' => ['grade'=>'mistake','frequency'=>6,'ev_score'=>30,'feedback'=>'No hace falta.'],
            ],
            'No toda mano razonable necesita apostar.',
            'En NL2-NL10 muchas veces TT sigue siendo la mejor mano.',
            82
        );
    }

    protected static function checkBackA98_JJ(): array
    {
        return self::spot(
            'pf_checkback_a98tt_btn_vs_bb_jj',
            'check_back_ip',
            'Check Back IP',
            'pot_control_dynamic_board',
            'Control en board dinámico',
            'BTN vs BB · A98 two-tone con JJ',
            'BTN',
            'BB',
            ['Jh', 'Jc'],
            ['As', '9s', '8d'],
            5.5,
            9,
            47.5,
            'A-high dinámico',
            'Hero tiene ventaja en Ax fuertes.',
            'BB conecta con proyectos y pares.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 9♠ 8♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            'JJ tiene showdown value pero no quiere jugar un bote grande en un board con muchos proyectos.',
            'GTO simplificado: control de bote con parejas medias-altas.',
            [
                'CHECK' => ['grade'=>'best','frequency'=>70,'ev_score'=>80,'feedback'=>'Correcto.'],
                'BET_33' => ['grade'=>'marginal','frequency'=>30,'ev_score'=>62,'feedback'=>'Puede mezclarse.'],
                'BET_66' => ['grade'=>'mistake','frequency'=>8,'ev_score'=>28,'feedback'=>'Demasiado agresivo.'],
            ],
            'El control de bote gana importancia en boards dinámicos.',
            'En límites bajos evita inflar el bote sin una mano fuerte.',
            80
        );
    }
}
