<?php

namespace App\SpotTraining\PostflopRiver\Modules;

use App\SpotTraining\PostflopRiver\Concerns\BuildsPostflopRiverSpots;

class RiverBluffCatchSpots
{
    use BuildsPostflopRiverSpots;

    public static function all(): array
    {
        return [
            self::topPairBlocksValueCall(),
            self::overpairFacingPolarBet(),
            self::secondPairBadBlockersFold(),
            self::aceHighMissedDrawCall(),
            self::twoPairFacingOverbetCall(),
            self::onePairVsNitFold(),
            self::flushBlockerHeroCall(),
            self::straightBlockerCall(),
            self::topPairNoBlockersFold(),
            self::underbluffedLineFold(),
        ];
    }

    protected static function topPairBlocksValueCall(): array
    {
        return self::spot(
            'river_bluffcatch_btn_vs_bb_kq_k72_4_9_call',
            'river_bluff_catch',
            'River Bluff Catch',
            'top_pair_blocks_value_call',
            'Top pair con buen blocker',
            'BTN vs BB · KQ bluff catch river',
            'BTN',
            'BB',
            ['Ks', 'Qh'],
            ['Kd', '7c', '2h', '4s', '9d'],
            29.0,
            1.5,
            44.0,
            'River blank tras línea check-call/check-call/donk',
            'BTN mantiene Kx fuertes; BB representa polarización estrecha.',
            'BB tiene algunos 2 pares raros/sets, pero también suficientes draws fallidos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♦ 7♣ 2♥', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 4♠', 'BB checks', 'BTN bets 8 BB', 'BB calls', 'River: 9♦', 'BB bets 18 BB', 'Action on Hero BTN'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'KQ bloquea parte del valor de BB con Kx mejor y sigue ganando a missed draws. Raise no tiene sentido porque solo te pagan manos mejores.',
            'GTO simplificado: top pair fuerte con buenos blockers puede pagar apuestas polarizadas cuando el rival conserva suficientes faroles naturales.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 82, 'feedback' => 'Correcto. Tienes bluff catcher fuerte y bloqueas parte del valor.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 35, 'ev_score' => 60, 'feedback' => 'Puede ser explotativo contra nits, pero foldear siempre esta mano es demasiado débil.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 3, 'ev_score' => 18, 'feedback' => 'Muy malo. Conviertes una mano con showdown en bluff innecesario.'],
            ],
            'Un bluff catcher no necesita ganar siempre; solo necesita ganar lo suficiente contra la apuesta recibida.',
            'En NL2-NL10 paga contra rivales agresivos o recreacionales impredecibles. Contra pasivos extremos, foldea más.',
            82
        );
    }

    protected static function overpairFacingPolarBet(): array
    {
        return self::spot(
            'river_bluffcatch_co_vs_bb_aa_j85_9_3_call',
            'river_bluff_catch',
            'River Bluff Catch',
            'overpair_vs_polar_bet',
            'Overpair contra apuesta polarizada',
            'CO vs BB · AA enfrenta lead river',
            'CO',
            'BB',
            ['As', 'Ad'],
            ['Jh', '8h', '5c', '9d', '3s'],
            36.0,
            1.2,
            43.0,
            'River blank, muchos proyectos fallidos',
            'CO tiene overpairs; BB tiene proyectos fallidos y algunas manos fuertes.',
            'BB representa dobles/sets/escaleras, pero no todas llegan así.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: J♥ 8♥ 5♣', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 9♦', 'BB checks', 'CO checks back', 'River: 3♠', 'BB bets 24 BB', 'Action on Hero CO'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'AA bloquea poco los faroles y gana a suficientes missed hearts, T7/T6 fallidos y manos convertidas en bluff. El raise no extrae valor de peor.',
            'GTO simplificado: overpair puede bluffcatchear cuando la línea rival contiene bastantes draws fallidos y el tamaño no exige una frecuencia imposible.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 48, 'ev_score' => 78, 'feedback' => 'Buen call. Tu mano gana a una parte razonable de los faroles.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 68, 'feedback' => 'Aceptable contra pools muy pasivos, pero demasiado tight contra rivales capaces de farolear.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 15, 'feedback' => 'No representas suficiente y te aíslas contra valor.'],
            ],
            'El check back turn puede inducir apuestas river; por eso no puedes foldear automáticamente manos fuertes.',
            'Contra desconocidos pasivos en micro, call pequeño/medio; contra overbet de nit, fold. Contra agresivos, paga.',
            78
        );
    }

    protected static function secondPairBadBlockersFold(): array
    {
        return self::spot(
            'river_bluffcatch_btn_vs_bb_qj_q94_2_a_fold',
            'river_bluff_catch',
            'River Bluff Catch',
            'second_pair_bad_blockers_fold',
            'Segunda pareja con malos blockers',
            'BTN vs BB · QJ en Q942A',
            'BTN',
            'BB',
            ['Qd', 'Js'],
            ['Qh', '9c', '4d', '2s', 'As'],
            25.0,
            1.8,
            45.0,
            'River A cambia ventaja y completa parte del rango rival',
            'BTN pierde ventaja al caer A river tras check back turn.',
            'BB puede tener Ax flotado, dobles y algunos sets slowplayed.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♥ 9♣ 4♦', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♠', 'BB checks', 'BTN checks back', 'River: A♠', 'BB bets 18 BB', 'Action on Hero BTN'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'QJ ahora es solo un bluff catcher medio y no bloquea las mejores manos de valor. Además el A river favorece bastantes floats y manos que mejoran.',
            'GTO simplificado: las manos medias con malos blockers deben foldear más contra apuestas grandes en cartas que mejoran el rango del rival.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 80, 'feedback' => 'Correcto. Malos blockers y runout incómodo.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 28, 'ev_score' => 42, 'feedback' => 'Pagas demasiado. Esta mano no bloquea valor y pierde contra muchos Ax.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 4, 'ev_score' => 12, 'feedback' => 'Bluff malo. No tienes blockers relevantes ni credibilidad suficiente.'],
            ],
            'No todos los top pairs son bluff catchers automáticos cuando cambia la carta de river.',
            'En microlímites la gente farolea poco esta carta. Foldear aquí ahorra mucho dinero.',
            80
        );
    }

    protected static function aceHighMissedDrawCall(): array
    {
        return self::spot(
            'river_bluffcatch_bb_vs_btn_ahq_x_missed_flush_call',
            'river_bluff_catch',
            'River Bluff Catch',
            'ace_high_blocks_flush_call',
            'A-high bloqueando color fallido',
            'BB vs BTN · AhQx en runout de corazones fallidos',
            'BB',
            'BTN',
            ['Ah', 'Qc'],
            ['Kh', '8h', '3s', '4d', '2c'],
            18.0,
            2.4,
            43.0,
            'River blank, flush draw fallido',
            'BTN tiene rango amplio de c-bet y barrels fallidos.',
            'BTN tiene Kx fuertes, pero también muchos corazones fallidos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♥ 8♥ 3♠', 'BB checks', 'BTN bets 2.5 BB', 'BB calls', 'Turn: 4♦', 'BB checks', 'BTN bets 6 BB', 'BB calls', 'River: 2♣', 'BB checks', 'BTN bets 12 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Ah bloquea muchos faroles de color, pero también bloquea valor de A-high hearts. Aun así, contra tamaño medio y rango amplio, A-high puede ganar a suficientes proyectos fallidos sin pareja.',
            'GTO simplificado: algunos A-high con blockers adecuados entran en la región de bluff catch cuando el rival tiene demasiados draws fallidos.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 38, 'ev_score' => 74, 'feedback' => 'Call avanzado. No es automático, pero funciona contra agresores con muchos barrels.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 55, 'ev_score' => 67, 'feedback' => 'Fold estándar contra rivales pasivos. No es un error grave.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 6, 'ev_score' => 35, 'feedback' => 'No necesitas convertir esta mano en bluff salvo lecturas muy claras.'],
            ],
            'Los bluff catchers marginales dependen mucho del perfil rival y del tamaño de apuesta.',
            'En NL2-NL10 este call solo es bueno contra jugadores que realmente disparan tres barrels. Contra la mayoría, fold está bien.',
            74
        );
    }

    protected static function twoPairFacingOverbetCall(): array
    {
        return self::spot(
            'river_bluffcatch_sb_vs_btn_q9_q94_2_6_overbet_call',
            'river_bluff_catch',
            'River Bluff Catch',
            'two_pair_vs_overbet_call',
            'Dobles contra overbet polarizada',
            'SB vs BTN · Q9 enfrenta overbet',
            'SB',
            'BTN',
            ['Qs', '9s'],
            ['Qh', '9d', '4c', '2h', '6c'],
            42.0,
            1.1,
            47.0,
            'River blank, rango rival polarizado',
            'SB tiene manos fuertes de 3bet pot; BTN llega con Qx, sets y floats.',
            'SB tiene ventaja de overpairs y sets, BTN representa polarización.',
            ['BTN opens 2.5 BB', 'SB 3bets 10 BB', 'BTN calls', 'Flop: Q♥ 9♦ 4♣', 'SB bets 5 BB', 'BTN calls', 'Turn: 2♥', 'SB checks', 'BTN bets 12 BB', 'SB calls', 'River: 6♣', 'SB checks', 'BTN bets 52 BB all-in', 'Action on Hero SB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Top two está demasiado arriba en tu rango para foldear contra una línea polarizada. Pierdes contra sets, pero ganas a faroles y value peor mal jugado.',
            'GTO simplificado: manos cercanas al top de rango deben defender frente a overbets, especialmente cuando no bloquean los faroles principales.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 88, 'feedback' => 'Correcto. Estás muy alto en rango y no puedes foldear tanto.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 12, 'ev_score' => 24, 'feedback' => 'Demasiado tight. Si foldeas dobles aquí, tu rango queda indefenso.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 0, 'ev_score' => 30, 'feedback' => 'No aplica: el rival ya está all-in o muy polarizado.'],
            ],
            'Contra overbet river, decide por posición en tu rango, blockers y pool, no por miedo al tamaño.',
            'En microlímites, si el rival es nit pasivo puedes hacer fold explotativo. Contra agresivos o desconocidos, dobles fuertes pagan.',
            88
        );
    }

    protected static function onePairVsNitFold(): array
    {
        return self::spot(
            'river_bluffcatch_co_vs_bb_kj_k98_2_5_fold_vs_nit',
            'river_bluff_catch',
            'River Bluff Catch',
            'one_pair_vs_nit_fold',
            'Una pareja contra línea de nit',
            'CO vs BB · KJ vs check-raise river',
            'CO',
            'BB',
            ['Ks', 'Jd'],
            ['Kh', '9h', '8c', '2d', '5s'],
            33.0,
            1.6,
            52.0,
            'River blank, rival pasivo muestra fuerza extrema',
            'CO tiene Kx fuertes, pero BB representa valor muy concentrado.',
            'BB tiene sets/dobles slowplayed; faroles de river son escasos en este pool.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: K♥ 9♥ 8♣', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 2♦', 'BB checks', 'CO bets 9 BB', 'BB calls', 'River: 5♠', 'BB checks', 'CO bets 14 BB', 'BB raises to 45 BB', 'Action on Hero CO'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'Top pair no es suficiente contra check-raise river de jugador pasivo. Esta línea está muy cargada de valor y casi no contiene faroles naturales.',
            'GTO simplificado: algunas top pairs pueden defender, pero contra pools underbluffing se permite sobrefoldear river raises.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 70, 'ev_score' => 86, 'feedback' => 'Excelente fold explotativo. Esta línea casi siempre es valor en micros.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 24, 'ev_score' => 38, 'feedback' => 'Pagas demasiado contra una línea que casi nadie farolea.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 1, 'ev_score' => 5, 'feedback' => 'Desastre. No conviertas top pair en spew.'],
            ],
            'GTO no significa pagar todos los bluff catchers: la línea y el pool importan.',
            'En NL2-NL10, raise river de pasivo = valor. Foldea sin ego.',
            86
        );
    }

    protected static function flushBlockerHeroCall(): array
    {
        return self::spot(
            'river_bluffcatch_btn_vs_bb_as_kx_flush_blocker_call',
            'river_bluff_catch',
            'River Bluff Catch',
            'nut_flush_blocker_call',
            'Blocker al color nuts',
            'BTN vs BB · As bloquea nuts en river monocolor',
            'BTN',
            'BB',
            ['As', 'Kd'],
            ['Qs', '8s', '4c', '2s', '7s'],
            27.0,
            1.7,
            46.0,
            'River cuarto trébol/pica, color posible',
            'BTN tiene muchos AsX que bloquean nuts; BB tiene colores medios y faroles.',
            'Ambos tienen colores, pero As en Hero reduce combos de nuts del rival.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 8♠ 4♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♠', 'BB checks', 'BTN checks back', 'River: 7♠', 'BB bets 20 BB', 'Action on Hero BTN'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'El As es un blocker muy valioso: reduce fuertemente los colores nuts de BB. Sin embargo, no debes subir porque tu mano no tiene valor contra calls.',
            'GTO simplificado: los blockers al nuts permiten defender algunos bluff catchers que sin blocker serían fold claro.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 46, 'ev_score' => 77, 'feedback' => 'Buen hero call. El blocker al nuts importa mucho.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 48, 'ev_score' => 66, 'feedback' => 'Explotativamente aceptable contra rivales que nunca farolean river.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 8, 'ev_score' => 36, 'feedback' => 'El blocker sirve para pagar o bluffear en contextos concretos, pero aquí el raise es demasiado ambicioso.'],
            ],
            'Blocker bueno no convierte automáticamente una mano en raise; muchas veces solo mejora el call.',
            'En micros, usa este call contra jugadores agresivos. Contra pasivos que apuestan grande en river con color obvio, foldea más.',
            77
        );
    }

    protected static function straightBlockerCall(): array
    {
        return self::spot(
            'river_bluffcatch_bb_vs_btn_t9_blocker_j8762_call',
            'river_bluff_catch',
            'River Bluff Catch',
            'straight_blocker_call',
            'Blocker a escalera nuts',
            'BB vs BTN · T9 bloquea escalera',
            'BB',
            'BTN',
            ['Ts', '9c'],
            ['Jh', '8d', '7c', '2s', '6h'],
            30.0,
            1.5,
            45.0,
            'Board muy conectado, river completa más escaleras',
            'BTN tiene ventaja de agresor; BB conserva muchas manos conectadas.',
            'T9 bloquea escaleras fuertes del rival y también tiene showdown fuerte.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♥ 8♦ 7♣', 'BB checks', 'BTN bets 4 BB', 'BB calls', 'Turn: 2♠', 'BB checks', 'BTN checks back', 'River: 6♥', 'BB checks', 'BTN bets 22 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'T9 bloquea parte importante de las escaleras fuertes y gana a sets/dobles convertidas en value thin o bluffs. El raise es innecesario sin nuts claros.',
            'GTO simplificado: blockers a nuts reducen combinaciones de valor rival y permiten defender más ante apuestas polarizadas.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 83, 'feedback' => 'Correcto. Tienes una mano demasiado fuerte para foldear y buenos blockers.'],
                'RAISE' => ['grade' => 'marginal', 'frequency' => 16, 'ev_score' => 58, 'feedback' => 'Muy fino. Puedes aislarte contra mejores escaleras o manos que no foldean.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 10, 'ev_score' => 22, 'feedback' => 'Demasiado débil. Esta mano está muy arriba en tu rango.'],
            ],
            'Cuanto más arriba estás en tu rango, menos puedes foldear solo porque el board da miedo.',
            'En límites bajos, paga. Si resubes, muchos solo continúan con mejor; por eso call suele ser superior.',
            83
        );
    }

    protected static function topPairNoBlockersFold(): array
    {
        return self::spot(
            'river_bluffcatch_btn_vs_bb_kt_k72_4_a_fold',
            'river_bluff_catch',
            'River Bluff Catch',
            'top_pair_no_blockers_fold',
            'Top pair sin blockers buenos',
            'BTN vs BB · KT en river A',
            'BTN',
            'BB',
            ['Kh', 'Td'],
            ['Ks', '7d', '2c', '4h', 'As'],
            28.0,
            1.6,
            44.0,
            'River A favorece al caller que llega con Ax floats y dobles',
            'BTN tiene Kx, pero la carta A reduce valor relativo de top pair.',
            'BB representa Ax, dobles y algunos slowplays; Hero no bloquea suficiente valor.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♦ 2♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'BTN checks back', 'River: A♠', 'BB bets 21 BB', 'Action on Hero BTN'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'KT es demasiado medio y no bloquea las manos fuertes que BB representa. Además pierdes contra muchos Ax que flotaron o pagaron flop.',
            'GTO simplificado: top pair débil sin blockers relevantes foldea más cuando una overcard cambia la distribución de nuts.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 64, 'ev_score' => 81, 'feedback' => 'Correcto. No hay que pagar por orgullo con top pair débil.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 25, 'ev_score' => 40, 'feedback' => 'Call demasiado optimista contra una carta que mejora mucho al rival.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 3, 'ev_score' => 10, 'feedback' => 'No tienes buenos blockers ni valor. Es spew.'],
            ],
            'La fuerza absoluta de una pareja baja mucho cuando el river mejora una parte importante del rango rival.',
            'En NL2-NL10 este bet grande suele ser valor. Foldea y sigue jugando tranquilo.',
            81
        );
    }

    protected static function underbluffedLineFold(): array
    {
        return self::spot(
            'river_bluffcatch_bb_vs_sb_qx_paired_board_fold',
            'river_bluff_catch',
            'River Bluff Catch',
            'underbluffed_line_fold',
            'Línea muy underbluffed',
            'BB vs SB · Qx en board doblado',
            'BB',
            'SB',
            ['Qd', 'Tc'],
            ['Qs', '8h', '8c', '3d', '2s'],
            24.0,
            2.0,
            48.0,
            'Board doblado, rival apuesta pequeño flop y grande river',
            'SB tiene más overpairs y trips; BB tiene Qx y pares medios.',
            'SB conserva 8x, QQ+ y algunos full houses; faroles naturales escasean.',
            ['SB opens 3 BB', 'BB calls', 'Flop: Q♠ 8♥ 8♣', 'SB bets 2 BB', 'BB calls', 'Turn: 3♦', 'SB checks', 'BB checks back', 'River: 2♠', 'SB bets 18 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'Qx parece fuerte, pero en este board y línea el rival tiene muchos value hands y pocos faroles naturales. Sin reads, el fold explotativo es superior.',
            'GTO simplificado: en boards doblados algunas Qx defienden, pero frente a pools que no encuentran faroles suficientes se puede sobrefoldear.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 79, 'feedback' => 'Buen fold. Esta línea está muy cargada de valor en micros.'],
                'CALL' => ['grade' => 'marginal', 'frequency' => 36, 'ev_score' => 55, 'feedback' => 'Puede ser defendible contra agresivos, pero contra pool medio es caro.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 8, 'feedback' => 'Sin blockers al full ni historia, raise es quemar dinero.'],
            ],
            'El mejor bluff catch no es el que parece bonito, sino el que gana suficiente contra la línea real del rival.',
            'En límites bajos, las líneas grandes de river en boards doblados están muy underbluffed. Foldea más.',
            79
        );
    }
}
