<?php

namespace App\SpotTraining\Postflop\Modules;

use App\SpotTraining\Postflop\Concerns\BuildsPostflopSpots;

class SemiBluffSpots
{
    use BuildsPostflopSpots;

    public static function all(): array
    {
        return [
            self::semiBluffNutFlushDraw(),
            self::semiBluffA5NutDraw(),
            self::semiBluffT9FlushDraw(),
            self::semiBluffAqOvercardsFlushDraw(),
            self::semiBluffOpenEndedStraightDraw(),
            self::semiBluffComboDrawAggressive(),
            self::semiBluffGutshotBackdoorControl(),
            self::semiBluffLowFlushDrawControl(),
        ];
    }

    protected static function semiBluffNutFlushDraw(): array
    {
        return self::spot(
            'pf_semibluff_nfd_btn_vs_bb_k72ss_asqs',
            'semi_bluff',
            'Semi-Bluff Flop',
            'nut_draw_pressure',
            'Presión con nut draw',
            'BTN vs BB · Nut flush draw',
            'BTN',
            'BB',
            ['As', 'Qs'],
            ['Ks', '7s', '2d'],
            5.5,
            8.6,
            47.5,
            'K-high con proyecto de color',
            'Hero tiene ventaja de rango.',
            'Hero tiene Kx fuertes y nut flush draws.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♠ 2♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'Nut flush draw con overcard y blockers quiere apostar frecuentemente.',
            'GTO simplificado: semi-bluff pequeño frecuente con nut draw.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 74, 'ev_score' => 87, 'feedback' => 'Excelente semi-bluff.'],
                'BET_66' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 79, 'feedback' => 'También jugable, pero no hace falta usar grande como estándar.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 26, 'ev_score' => 65, 'feedback' => 'Check no es horrible, pero pierdes fold equity.'],
            ],
            'Los nut draws pueden apostar por equity + fold equity.',
            'Farolea menos con aire, pero sí presiona con proyectos fuertes.',
            82
        );
    }

    protected static function semiBluffA5NutDraw(): array
    {
        return self::spot(
            'pf_semibluff_q72ss_btn_vs_bb_as5s',
            'semi_bluff',
            'Semi-Bluff Flop',
            'nut_flush_draw',
            'Nut flush draw',
            'BTN vs BB · Q72ss con A5s',
            'BTN',
            'BB',
            ['As', '5s'],
            ['Qs', '7s', '2d'],
            5.5,
            8.6,
            47.5,
            'Q-high con flush draw',
            'Hero tiene ventaja moderada.',
            'Hero tiene mejores Qx y nut flush draws.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 7♠ 2♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_33',
            'Nut flush draw con blocker al As es excelente para apostar pequeño: equity y fold equity.',
            'GTO simplificado: bet semi-bluff con draws fuertes.',
            [
                'BET_33' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 84, 'feedback' => 'Muy buen semi-bluff.'],
                'BET_66' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 76, 'feedback' => 'Jugable, pero pequeño es suficiente.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 62, 'feedback' => 'No es grave, pero pierdes iniciativa.'],
            ],
            'Nut flush draw apuesta mucho por equity y fold equity.',
            'En límites bajos semi-bluffea con equity real, no con aire.',
            84
        );
    }

    protected static function semiBluffT9FlushDraw(): array
    {
        return self::spot(
            'pf_semibluff_j84ss_bb_vs_btn_ts9s',
            'semi_bluff',
            'Semi-Bluff Flop',
            'draw_plus_backdoors',
            'Proyecto con jugabilidad',
            'BB vs BTN · J84ss con T9s',
            'BB',
            'BTN',
            ['Ts', '9s'],
            ['Js', '8d', '4s'],
            8.5,
            6.5,
            49.0,
            'J-high con flush draw',
            'BTN tiene ventaja de rango.',
            'BB tiene draws y algunas dobles.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 8♦ 4♠', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'T9s tiene proyecto de color y backdoors de escalera. Call realiza equity y mantiene rango amplio.',
            'GTO simplificado: continuar con draws jugables.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 78, 'feedback' => 'Correcto. Realizas equity con buena jugabilidad.'],
                'RAISE' => ['grade' => 'good', 'frequency' => 32, 'ev_score' => 74, 'feedback' => 'Raise también puede ser buen semi-bluff.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 10, 'ev_score' => 32, 'feedback' => 'Demasiado débil con proyecto real.'],
            ],
            'Los draws con buena jugabilidad deben continuar.',
            'En NL2-NL10 paga o sube draws fuertes; no foldees equity clara.',
            78
        );
    }

    protected static function semiBluffAqOvercardsFlushDraw(): array
    {
        return self::spot(
            'pf_semibluff_t73ss_co_vs_bb_asqs',
            'semi_bluff',
            'Semi-Bluff Flop',
            'overcards_nfd',
            'Overcards + nut draw',
            'CO vs BB · T73ss con AQs',
            'CO',
            'BB',
            ['As', 'Qs'],
            ['Ts', '7s', '3d'],
            5.5,
            8.8,
            48.5,
            'T-high con flush draw',
            'Hero tiene overpairs y draws fuertes.',
            'BB tiene sets y algunas dobles.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: T♠ 7♠ 3♦', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_66',
            'AQs con nut flush draw y overcards puede apostar más grande para presionar pares y draws peores.',
            'GTO simplificado: semi-bluff fuerte puede usar sizing más grande.',
            [
                'BET_66' => ['grade' => 'best', 'frequency' => 52, 'ev_score' => 86, 'feedback' => 'Excelente presión con mucha equity.'],
                'BET_33' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 78, 'feedback' => 'También válido, pero menos presión.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 22, 'ev_score' => 62, 'feedback' => 'Check no es terrible, pero pierdes fold equity.'],
            ],
            'Nut draw + overcards puede apostar grande en boards donde genera presión.',
            'En microlímites usa agresión con proyectos fuertes, no con faroles vacíos.',
            84
        );
    }

    protected static function semiBluffOpenEndedStraightDraw(): array
    {
        return self::spot(
            'pf_semibluff_976r_btn_vs_bb_t8s',
            'semi_bluff',
            'Semi-Bluff Flop',
            'open_ended_pressure',
            'OESD con presión',
            'BTN vs BB · OESD en 976r',
            'BTN',
            'BB',
            ['Th', '8h'],
            ['9s', '7d', '6c'],
            5.5,
            8.6,
            47.5,
            'Board bajo conectado',
            'BB conecta bastante con este board.',
            'BB tiene dobles y escaleras; Hero conserva overpairs.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: 9♠ 7♦ 6♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_66',
            'T8s tiene escalera abierta y buena equity. Apostar grande presiona pares, proyectos peores y construye bote cuando completas.',
            'GTO simplificado: los proyectos fuertes pueden usar sizing grande en boards dinámicos.',
            [
                'BET_66' => ['grade' => 'best', 'frequency' => 56, 'ev_score' => 86, 'feedback' => 'Muy buen semi-bluff. Tienes equity real y fold equity.'],
                'BET_33' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 76, 'feedback' => 'También válido, aunque presiona menos.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 62, 'feedback' => 'Check no es horrible, pero pierdes iniciativa con un draw fuerte.'],
            ],
            'Los OESD fuertes pueden jugar agresivo como semi-bluff.',
            'En NL2-NL10 presiona proyectos fuertes, no aire. Si te pagan, todavía tienes muchas outs.',
            84
        );
    }

    protected static function semiBluffComboDrawAggressive(): array
    {
        return self::spot(
            'pf_semibluff_qt9ss_btn_vs_bb_jsTs',
            'semi_bluff',
            'Semi-Bluff Flop',
            'combo_draw_aggression',
            'Combo draw agresivo',
            'BTN vs BB · Combo draw en QT9ss',
            'BTN',
            'BB',
            ['Js', 'Ts'],
            ['Qs', '9s', '2d'],
            5.5,
            8.6,
            47.5,
            'Board dinámico con color y escalera',
            'Hero tiene ventaja de rango, pero BB conecta mucho.',
            'BB tiene dobles y sets; Hero tiene broadways fuertes y draws premium.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 9♠ 2♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'BET_66',
            'JTs tiene proyecto de color, gutshot y mucha jugabilidad. Es una mano ideal para presionar y construir bote.',
            'GTO simplificado: combo draws fuertes pueden apostar grande.',
            [
                'BET_66' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 90, 'feedback' => 'Excelente semi-bluff agresivo con mucha equity.'],
                'BET_33' => ['grade' => 'good', 'frequency' => 40, 'ev_score' => 78, 'feedback' => 'Bueno, pero algo pequeño para tanta equity.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 16, 'ev_score' => 46, 'feedback' => 'Demasiado pasivo con un draw premium.'],
            ],
            'Los combo draws son candidatos naturales a presión.',
            'En microlímites, si vas a farolear, que sea con manos que puedan mejorar fuerte.',
            88
        );
    }

    protected static function semiBluffGutshotBackdoorControl(): array
    {
        return self::spot(
            'pf_semibluff_a94r_btn_vs_bb_jt_bdfd',
            'semi_bluff',
            'Semi-Bluff Flop',
            'weak_draw_control',
            'Proyecto débil con control',
            'BTN vs BB · Gutshot débil + backdoor',
            'BTN',
            'BB',
            ['Jh', 'Th'],
            ['As', '9d', '4h'],
            5.5,
            8.6,
            47.5,
            'A-high semi seco',
            'Hero tiene ventaja de Ax.',
            'Hero tiene más Ax fuertes; BB tiene pares medios y floats.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 9♦ 4♥', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_33', 'BET_66'],
            'CHECK',
            'JT tiene backdoor de color y algunas turns útiles, pero no suficiente equity para apostar grande ni convertirlo en semi-bluff automático.',
            'GTO simplificado: los backdoors débiles mezclan mucho check.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 74, 'feedback' => 'Correcto. Controlas bote con equity débil.'],
                'BET_33' => ['grade' => 'good', 'frequency' => 38, 'ev_score' => 66, 'feedback' => 'Puede mezclarse por ventaja de rango, pero no abuses.'],
                'BET_66' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 30, 'feedback' => 'Demasiado grande para un proyecto tan débil.'],
            ],
            'No todo backdoor es un semi-bluff fuerte.',
            'En NL2-NL10 evita inflar botes con proyectos débiles. Mejor check y tomar carta gratis.',
            76
        );
    }

    protected static function semiBluffLowFlushDrawControl(): array
    {
        return self::spot(
            'pf_semibluff_k95ss_bb_vs_btn_6s4s',
            'semi_bluff',
            'Semi-Bluff Flop',
            'low_flush_draw_control',
            'Flush draw bajo controlado',
            'BB vs BTN · Flush draw bajo',
            'BB',
            'BTN',
            ['6s', '4s'],
            ['Ks', '9s', '5d'],
            8.5,
            6.5,
            49.0,
            'K-high con flush draw',
            'BTN tiene ventaja de rango.',
            'BTN tiene más Kx fuertes y nut flush draws.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 9♠ 5♦', 'BB checks', 'BTN bets 3 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Flush draw bajo tiene equity para pagar, pero subirlo demasiado puede aislarte contra draws mejores y manos fuertes.',
            'GTO simplificado: los flush draws bajos prefieren call más que raise.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 78, 'feedback' => 'Correcto. Realizas equity sin inflar el bote.'],
                'RAISE' => ['grade' => 'marginal', 'frequency' => 18, 'ev_score' => 55, 'feedback' => 'Puede existir alguna vez, pero no como estándar con draw bajo.'],
                'FOLD' => ['grade' => 'mistake', 'frequency' => 12, 'ev_score' => 34, 'feedback' => 'Demasiado débil. Tienes proyecto y buen precio.'],
            ],
            'Los draws bajos tienen equity, pero no siempre quieren presión máxima.',
            'En límites bajos paga con proyectos bajos; no construyas botes enormes cuando puedes ir dominado.',
            80
        );
    }
}
