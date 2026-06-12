<?php

namespace App\SpotTraining\Postflop\Modules;

use App\SpotTraining\Postflop\Concerns\BuildsPostflopSpots;

class CbetIpSpots
{
    use BuildsPostflopSpots;

    public static function all(): array
    {
        return [
            self::cbetIpDryAceHigh(),
            self::cbetIpTopPairValue(),
            self::cbetIpA83Kqo(),
            self::cbetIpK72Aa(),
            self::cbetIpLowBoardAqo(),
            self::cbetIpPairedBoardAko(),
        ];
    }

    protected static function cbetIpDryAceHigh(): array
    {
        return self::spot(
            'pf_cbet_ip_a72r_btn_vs_bb_ak',
            'cbet_ip',
            'C-Bet IP',
            'range_advantage_cbet',
            'C-bet por ventaja de rango',
            'BTN vs BB · A72 rainbow',
            'BTN',
            'BB',
            ['Ah', 'Kh'],
            ['Ad', '7c', '2s'],
            5.5,
            8.6,
            47.5,
            'Board seco alto · rainbow',
            'Hero tiene ventaja clara de rango.',
            'Hero conserva muchos Ax fuertes; BB tiene más pares débiles.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♦ 7♣ 2♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'En A72 rainbow el agresor preflop tiene mucha ventaja de rango. La apuesta pequeña imprime presión a manos sin As, cobra a pares bajos y mantiene dominados dentro.',
            'GTO simplificado: apostar pequeño con alta frecuencia.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 82, 'ev_score' => 88, 'feedback' => 'Mejor acción. Apuesta pequeña frecuente por ventaja de rango y buen top pair/top kicker.'],
                'BET_66' => ['grade' => 'marginal', 'frequency' => 18, 'ev_score' => 66, 'feedback' => 'Demasiado grande para este board seco. Aísla contra manos mejores.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 52, 'feedback' => 'Pierdes valor y protección en un board donde tu rango puede apostar mucho.'],
            ],
            'Apuesta pequeña con alta frecuencia. Tu rango tiene más Ax fuertes que BB.',
            'En NL2-NL10 muchos rivales pagan cualquier pareja y Ax peor. Bet pequeño por valor y protección.',
            88
        );
    }

    protected static function cbetIpTopPairValue(): array
    {
        return self::spot(
            'pf_cbet_ip_q72r_btn_vs_bb_kq',
            'cbet_ip',
            'C-Bet IP',
            'thin_value_protection',
            'Valor + protección',
            'BTN vs BB · Q72 rainbow',
            'BTN',
            'BB',
            ['Kc', 'Qd'],
            ['Qs', '7d', '2c'],
            5.5,
            8.6,
            47.5,
            'Board seco con top pair medio-alto',
            'Hero tiene ventaja moderada de rango.',
            'Hero tiene mejores Qx; BB tiene sets y dobles muy ocasionales.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♦ 2♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'Top pair con buen kicker quiere valor de Qx peores, 7x y pares medios. En board seco, sizing pequeño funciona muy bien.',
            'GTO simplificado: bet pequeño por valor y protección.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 84, 'feedback' => 'Correcto. Cobras a peores y mantienes rango amplio pagando.'],
                'BET_66' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 74, 'feedback' => 'Puede ser válido contra calling stations, pero como estándar prefiero pequeño.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 16, 'ev_score' => 55, 'feedback' => 'Demasiado pasivo. Dejas equity gratis a manos peores.'],
            ],
            'Top pair buen kicker apuesta mucho en board seco, especialmente con sizing pequeño.',
            'En microlímites te pagan Q peores, 7x y pares. Bet por valor; no regales carta por miedo al set.',
            84
        );
    }

    protected static function cbetIpA83Kqo(): array
    {
        return self::spot(
            'pf_cbet_ip_a83r_btn_vs_bb_kqo',
            'cbet_ip',
            'C-Bet IP',
            'range_advantage_air',
            'C-bet con aire por ventaja de rango',
            'BTN vs BB · A83 rainbow con KQo',
            'BTN',
            'BB',
            ['Kh', 'Qd'],
            ['As', '8c', '3d'],
            5.5,
            8.4,
            47.5,
            'A-high seco rainbow',
            'Hero tiene ventaja fuerte de rango.',
            'Hero tiene más Ax fuertes; BB tiene muchos pares medios y basura.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 8♣ 3♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'Aunque Hero no ligó, este board favorece mucho al agresor. La c-bet pequeña presiona folds naturales sin arriesgar demasiado.',
            'GTO simplificado: bet pequeño frecuente con rango amplio.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 78, 'feedback' => 'Buena c-bet pequeña. Aprovechas ventaja de rango sin inflar bote.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 66, 'feedback' => 'Check no es malo con K-high, pero pierdes fold equity barata.'],
                'BET_66' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 44, 'feedback' => 'Grande no hace falta. Arriesgas mucho con aire.'],
            ],
            'En A-high seco el agresor puede apostar pequeño con frecuencia alta.',
            'En NL2-NL10 apuesta pequeño; no conviertas aire en farol caro.',
            78
        );
    }

    protected static function cbetIpK72Aa(): array
    {
        return self::spot(
            'pf_cbet_ip_k72r_co_vs_bb_aa',
            'cbet_ip',
            'C-Bet IP',
            'overpair_value',
            'Valor con overpair',
            'CO vs BB · K72 rainbow con AA',
            'CO',
            'BB',
            ['Ah', 'Ad'],
            ['Ks', '7c', '2h'],
            5.5,
            8.8,
            48.5,
            'K-high seco',
            'Hero tiene ventaja clara.',
            'Hero tiene AA, AK, KK; BB tiene sets ocasionales.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♣ 2♥', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'AA es una mano de valor clara. En board seco se puede apostar pequeño para cobrar Kx, 7x y pares.',
            'GTO simplificado: bet pequeño por valor con overpair.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 80, 'ev_score' => 90, 'feedback' => 'Excelente. Sacas valor de muchas manos peores.'],
                'BET_66' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 78, 'feedback' => 'Puede ser bueno contra rivales que pagan mucho, pero pequeño es estándar.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 48, 'feedback' => 'Demasiado pasivo con una mano muy fuerte.'],
            ],
            'AA apuesta por valor en K-high seco con mucha frecuencia.',
            'En límites bajos no hagas slowplay: te pagan Kx y pares peores.',
            88
        );
    }

    protected static function cbetIpLowBoardAqo(): array
    {
        return self::spot(
            'pf_cbet_ip_642r_btn_vs_bb_aqo',
            'cbet_ip',
            'C-Bet IP',
            'bad_low_board_overcards',
            'Overcards en board bajo',
            'BTN vs BB · 642 rainbow con AQo',
            'BTN',
            'BB',
            ['Ah', 'Qd'],
            ['6c', '4h', '2s'],
            5.5,
            8.5,
            47.5,
            'Board bajo y conectado',
            'BB conecta bastante con este board.',
            'BB tiene más dobles, sets y escaleras pequeñas.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 6♣ 4♥ 2♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            'AQo tiene dos overcards pero poca ventaja real en este board. BB conecta mucho con pares, gutshots y dobles.',
            'GTO simplificado: reducir c-bet en boards bajos conectados.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 76, 'feedback' => 'Correcto. Controlas bote en un board que favorece al defensor.'],
                'BET_33' => ['grade' => 'marginal', 'frequency' => 38, 'ev_score' => 60, 'feedback' => 'Puede funcionar, pero no debe ser automática.'],
                'BET_66' => ['grade' => 'blunder', 'frequency' => 5, 'ev_score' => 20, 'feedback' => 'Farol grande sin equity suficiente.'],
            ],
            'En boards bajos y conectados el defensor tiene más equity y más nuts.',
            'En NL2-NL10 te pagan cualquier pareja o proyecto. Check back suele ahorrar dinero.',
            76
        );
    }

    protected static function cbetIpPairedBoardAko(): array
    {
        return self::spot(
            'pf_cbet_ip_998r_btn_vs_bb_ako',
            'cbet_ip',
            'C-Bet IP',
            'paired_board_cbet',
            'C-bet en board emparejado',
            'BTN vs BB · 998 rainbow con AKo',
            'BTN',
            'BB',
            ['Ac', 'Kd'],
            ['9s', '9h', '8c'],
            5.5,
            8.6,
            47.5,
            'Board emparejado medio',
            'La ventaja de rango no es tan clara.',
            'BB tiene más 9x y 8x defendidos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♠ 9♥ 8♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            'AKo sin backdoor fuerte no necesita apostar este board. BB tiene muchos 9x, 8x y floats que no foldean fácil.',
            'GTO simplificado: chequear más en boards medios emparejados.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 68, 'ev_score' => 74, 'feedback' => 'Buen check back. No conviertes AK en farol caro.'],
                'BET_33' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 58, 'feedback' => 'Puede estar mezclado, pero no es obligatorio.'],
                'BET_66' => ['grade' => 'blunder', 'frequency' => 3, 'ev_score' => 18, 'feedback' => 'Grande no representa bien y recibe demasiada resistencia.'],
            ],
            'Los boards emparejados medios no siempre son buenos para c-bet automática.',
            'En microlímites no esperes muchos folds de 8x, 9x o pares. Check back es más simple.',
            74
        );
    }
}
