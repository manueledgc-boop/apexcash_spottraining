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
            self::missedFlushDrawGoodBlockerCall(),
            self::missedStraightDrawNoBlockerFold(),
            self::pairedRiverTripsBlockerCall(),
            self::fourFlushNoBlockerFold(),
            self::aceHighBlocksNutFlushCall(),
            self::topPairFacingTripleBarrelFold(),
            self::secondPairVsSmallBlockBetCall(),
            self::overpairOnFourLinerFold(),
            self::boatBlockerHeroCall(),
            self::catchVsMissedComboDrawCall(),
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

    protected static function missedFlushDrawGoodBlockerCall(): array
    {
        return self::spot(
            'river_bluffcatch_btn_vs_bb_kt_q84_2_7_call',
            'river_bluff_catch',
            'River Bluff Catch',
            'missed_flush_good_blocker_call',
            'Call con blocker a valor y missed flush',
            'BTN vs BB · KT en Q84ss-2-7',
            'BTN',
            'BB',
            ['Ks', 'Th'],
            ['Qd', '8s', '4s', '2c', '7h'],
            32.0,
            1.4,
            45.0,
            'River blank después de fallar el color',
            'BTN mantiene algunas Qx, overpairs y bluff catchers con blocker.',
            'BB tiene draws de color fallidos y algunas manos de valor como dobles/sets.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♦ 8♠ 4♠', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♣', 'BB checks', 'BTN checks back', 'River: 7♥', 'BB bets 20 BB', 'Action on Hero BTN'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'K♠ bloquea parte de los proyectos de color fuertes y reduce combinaciones de valor con K-high spades. Aunque solo tienes K high, la línea de BB contiene suficientes missed draws si el rival es capaz de farolear.',
            'GTO simplificado: algunos bluff catchers sin pareja pueden pagar cuando bloquean valor y desbloquean faroles naturales.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 36, 'ev_score' => 74, 'feedback' => 'Buen call selectivo. No pagas por fuerza absoluta, pagas por blockers y línea.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 56, 'ev_score' => 68, 'feedback' => 'Fold explotativo está bien contra pasivos que no farolean missed draws.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 5, 'ev_score' => 26, 'feedback' => 'Raise innecesario. Tu mano gana a faroles y pierde contra calls.'],
            ],
            'Los blockers importan más que la fuerza visual de la mano en bluff catch river.',
            'En NL2-NL10 este call solo es bueno contra rivales que sí farolean proyectos fallidos. Contra pasivos, fold.',
            74
        );
    }

    protected static function missedStraightDrawNoBlockerFold(): array
    {
        return self::spot(
            'river_bluffcatch_co_vs_bb_qj_t96_2_3_fold',
            'river_bluff_catch',
            'River Bluff Catch',
            'missed_straight_no_blocker_fold',
            'Fold sin blockers contra apuesta grande',
            'CO vs BB · QJ en T96-2-3',
            'CO',
            'BB',
            ['Qh', 'Jc'],
            ['Ts', '9d', '6c', '2h', '3s'],
            34.0,
            1.5,
            44.0,
            'River blank en board conectado',
            'CO tiene overcards fallidas; BB conserva pares, dobles y sets.',
            'BB puede tener algunos draws fallidos, pero Hero no bloquea valor importante.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♦ 6♣', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'CO checks back', 'River: 3♠', 'BB bets 24 BB', 'Action on Hero CO'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'QJ falló su equity y no bloquea suficientes manos de valor de BB. Pagar aquí es justificar una mano perdida por curiosidad.',
            'GTO simplificado: los bluff catchers sin pareja necesitan blockers muy específicos; sin ellos se foldean mucho ante tamaños grandes.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 78, 'ev_score' => 80, 'feedback' => 'Correcto. No tienes showdown suficiente ni blockers buenos.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 30, 'feedback' => 'Call demasiado optimista. Vas perdiendo contra demasiadas manos.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 3, 'ev_score' => 8, 'feedback' => 'Farol sin blockers claros. Malo.'],
            ],
            'No todos los missed draws se convierten automáticamente en bluff catchers.',
            'En micros, cuando no tienes blockers y enfrentas bet grande, foldear es imprimir dinero a largo plazo.',
            80
        );
    }

    protected static function pairedRiverTripsBlockerCall(): array
    {
        return self::spot(
            'river_bluffcatch_bb_vs_btn_a8_a82_5_8_call',
            'river_bluff_catch',
            'River Bluff Catch',
            'paired_river_trips_blocker_call',
            'Call con trips y blocker al full',
            'BB vs BTN · A8 en A82-5-8',
            'BB',
            'BTN',
            ['8h', '7h'],
            ['As', '8d', '2c', '5s', '8c'],
            40.0,
            1.0,
            42.0,
            'River empareja y Hero mejora a trips',
            'BTN sigue polarizado entre Ax fuerte/full houses y faroles fallidos.',
            'BB bloquea 88/8x y tiene una mano muy alta dentro de su rango de check-call.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ 8♦ 2♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 5♠', 'BB checks', 'BTN bets 9 BB', 'BB calls', 'River: 8♣', 'BB checks', 'BTN bets 28 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Hero mejora a trips y bloquea full houses relevantes. Aunque BTN puede tener Ax fuerte, foldear esta mano sería demasiado tight.',
            'GTO simplificado: trips con blockers al valor fuerte se defienden contra apuestas polarizadas.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 74, 'ev_score' => 88, 'feedback' => 'Correcto. Estás demasiado arriba en tu rango para foldear.'],
                'RAISE' => ['grade' => 'marginal', 'frequency' => 12, 'ev_score' => 58, 'feedback' => 'Raise se aísla mucho contra full houses y Ax fuerte.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 8, 'ev_score' => 22, 'feedback' => 'Fold muy débil. Tienes blocker y mano fuerte.'],
            ],
            'En river, la posición dentro de tu rango importa: esta mano está demasiado alta para tirarla.',
            'En NL2-NL10 paga. Solo foldea si el rival es extremadamente nit y jamás farolea river.',
            88
        );
    }

    protected static function fourFlushNoBlockerFold(): array
    {
        return self::spot(
            'river_bluffcatch_btn_vs_bb_kq_q95_2_3_fold_fourflush',
            'river_bluff_catch',
            'River Bluff Catch',
            'four_flush_no_blocker_fold',
            'Fold sin blocker en cuarto color',
            'BTN vs BB · KQ sin trébol en Q95cc-2c-3c',
            'BTN',
            'BB',
            ['Kh', 'Qd'],
            ['Qs', '9c', '5c', '2c', '3c'],
            30.0,
            1.5,
            43.0,
            'River completa cuarto trébol',
            'BTN tiene top pair, pero no bloquea colores.',
            'BB tiene muchos floats y calls con trébol que llegan al river.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 9♣ 5♣', 'BB checks', 'BTN bets 4 BB', 'BB calls', 'Turn: 2♣', 'BB checks', 'BTN checks back', 'River: 3♣', 'BB bets 22 BB', 'Action on Hero BTN'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'Top pair parece bonita, pero sin trébol bloqueas cero valor y el rival tiene demasiados colores. Pagar aquí contra pool pasivo es quemar dinero.',
            'GTO simplificado: en runouts de cuatro cartas del mismo palo, los bluff catchers sin blocker al color foldean mucho.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 72, 'ev_score' => 84, 'feedback' => 'Buen fold. Sin blocker al color, tu top pair cae muchísimo.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 22, 'ev_score' => 36, 'feedback' => 'Call malo salvo rival muy agresivo.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 8, 'feedback' => 'No representas suficiente y no bloqueas valor.'],
            ],
            'Top pair sin blocker no es un héroe call automático en rivers de cuatro colores.',
            'En microlímites este bet suele ser color. Foldea sin drama.',
            84
        );
    }

    protected static function aceHighBlocksNutFlushCall(): array
    {
        return self::spot(
            'river_bluffcatch_bb_vs_btn_asj_q84_6_2_call',
            'river_bluff_catch',
            'River Bluff Catch',
            'ace_high_blocks_nut_flush_call',
            'A high con blocker al nut flush',
            'BB vs BTN · A♠J bloquea nuts',
            'BB',
            'BTN',
            ['As', 'Jd'],
            ['Qh', '8s', '4s', '6c', '2d'],
            28.0,
            2.0,
            46.0,
            'River blank y draws fallidos',
            'BTN puede tener valor fino, pero también muchos spades fallidos.',
            'BB bloquea el nut flush draw fallido y algunas apuestas de valor con As.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♥ 8♠ 4♠', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 6♣', 'BB checks', 'BTN checks back', 'River: 2♦', 'BB checks', 'BTN bets 18 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'A♠ bloquea parte del rango fuerte de proyectos y puede ganar a missed draws con KJ/JT/T9. No es un call masivo, pero sí un buen bluff catcher selectivo.',
            'GTO simplificado: A high con blocker relevante puede defender frente a tamaños polarizados cuando los draws fallan.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 38, 'ev_score' => 72, 'feedback' => 'Call correcto contra agresivos: tienes blocker útil y showdown contra faroles.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 58, 'ev_score' => 66, 'feedback' => 'Fold explotativo también está bien contra población pasiva.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 4, 'ev_score' => 22, 'feedback' => 'No conviertas siempre tus blockers en raises.'],
            ],
            'Los mejores calls con A high necesitan blockers y una línea con faroles naturales.',
            'En NL2-NL10 selecciona bien: contra pasivos fold, contra agresivos call.',
            72
        );
    }

    protected static function topPairFacingTripleBarrelFold(): array
    {
        return self::spot(
            'river_bluffcatch_bb_vs_utg_kj_k74_2_9_fold',
            'river_bluff_catch',
            'River Bluff Catch',
            'top_pair_vs_utg_triple_fold',
            'Top pair vs triple barrel de UTG',
            'BB vs UTG · KJ en K74-2-9',
            'BB',
            'UTG',
            ['Kh', 'Jc'],
            ['Ks', '7d', '4c', '2h', '9s'],
            52.0,
            1.1,
            38.0,
            'Triple barrel de rango fuerte',
            'UTG tiene rango preflop fuerte y puede valuebetear AK/KQ/sets.',
            'BB tiene muchos Kx dominados y pocos raises de valor.',
            ['UTG opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♦ 4♣', 'BB checks', 'UTG bets 3 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'UTG bets 10 BB', 'BB calls', 'River: 9♠', 'BB checks', 'UTG bets 36 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'KJ es una mano fuerte en apariencia, pero contra triple barrel grande de UTG queda dominada por muchos Kx mejores y sets. Los faroles naturales son escasos.',
            'GTO simplificado: top pair kicker medio puede foldear contra rangos fuertes y líneas muy polarizadas de early position.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 82, 'feedback' => 'Buen fold disciplinado. No estás obligado a pagar tres calles con KJ.'],
                'CALL' => ['grade' => 'marginal', 'frequency' => 34, 'ev_score' => 55, 'feedback' => 'Call solo contra rivales capaces de triple barrel bluff.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 1, 'ev_score' => 6, 'feedback' => 'Raise absurdo: no te pagan manos peores.'],
            ],
            'Una mano bonita no justifica pagar una línea que casi siempre es valor.',
            'En micros, triple barrel grande de UTG suele ser muy honesto. Foldea más.',
            82
        );
    }

    protected static function secondPairVsSmallBlockBetCall(): array
    {
        return self::spot(
            'river_bluffcatch_btn_vs_bb_99_j92_5_4_call_small',
            'river_bluff_catch',
            'River Bluff Catch',
            'second_pair_vs_small_block_call',
            'Call vs apuesta pequeña de bloqueo',
            'BTN vs BB · 99 contra block bet river',
            'BTN',
            'BB',
            ['9h', '9c'],
            ['Js', '9d', '2c', '5h', '4s'],
            26.0,
            2.8,
            50.0,
            'River blank y apuesta pequeña',
            'BB apuesta pequeño con muchas manos medias y algunos faroles baratos.',
            'BTN tiene valor suficiente y no necesita convertir en raise.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♠ 9♦ 2♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 5♥', 'BB checks', 'BTN checks back', 'River: 4♠', 'BB bets 6 BB', 'Action on Hero BTN'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'Con set en river frente a apuesta pequeña, pagar es mínimo obligatorio. Subir puede ser mejor a veces, pero como ejercicio de bluff catch la prioridad es no foldear una mano muy fuerte.',
            'GTO simplificado: contra block bets pequeñas se defiende amplio y se sube polarizado; manos fuertes pueden mezclar call/raise.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 45, 'ev_score' => 86, 'feedback' => 'Correcto. Nunca foldees una mano tan alta contra tamaño pequeño.'],
                'RAISE' => ['grade' => 'good', 'frequency' => 50, 'ev_score' => 84, 'feedback' => 'Raise también es muy bueno por valor, especialmente contra calling stations.'],
                'FOLD' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 0, 'feedback' => 'Fold imposible.'],
            ],
            'El tamaño de la apuesta cambia radicalmente tus pot odds y tu rango de defensa.',
            'En NL2-NL10, contra apuesta pequeña, no sobrefoldees manos hechas fuertes.',
            86
        );
    }

    protected static function overpairOnFourLinerFold(): array
    {
        return self::spot(
            'river_bluffcatch_co_vs_bb_aa_t98_7_6_fold',
            'river_bluff_catch',
            'River Bluff Catch',
            'overpair_four_liner_fold',
            'Overpair en cuatro cartas a escalera',
            'CO vs BB · AA en T9876',
            'CO',
            'BB',
            ['Ah', 'Ad'],
            ['Ts', '9d', '8c', '7h', '6s'],
            44.0,
            1.3,
            40.0,
            'River completa cuatro cartas a escalera',
            'BB tiene muchísimos 6x/Jx y manos conectadas defendidas.',
            'CO tiene overpair pero su mano se degrada mucho.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♦ 8♣', 'BB checks', 'CO bets 5 BB', 'BB calls', 'Turn: 7♥', 'BB checks', 'CO checks back', 'River: 6♠', 'BB bets 30 BB', 'Action on Hero CO'],
            ['FOLD', 'CALL', 'RAISE'],
            'FOLD',
            'AA era fuerte preflop/flop, pero en T9876 es solo una pareja en un board donde BB tiene demasiadas escaleras. Sin blocker relevante, fold.',
            'GTO simplificado: overpairs bajan muchísimo de valor en runouts con cuatro cartas conectadas que favorecen a BB.',
            [
                'FOLD' => ['grade' => 'best', 'frequency' => 76, 'ev_score' => 85, 'feedback' => 'Correcto. No te cases con AA cuando el board cambia por completo.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 32, 'feedback' => 'Call por apego a la mano inicial. Malo.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 6, 'feedback' => 'No tienes blockers ni fold equity suficiente.'],
            ],
            'La fuerza de AA depende del board; en river muchas veces ya no es una mano fuerte.',
            'En microlímites, cuando completan boards obvios y apuestan grande, suele ser valor.',
            85
        );
    }

    protected static function boatBlockerHeroCall(): array
    {
        return self::spot(
            'river_bluffcatch_btn_vs_bb_aq_aa7_4_7_call',
            'river_bluff_catch',
            'River Bluff Catch',
            'boat_blocker_hero_call',
            'Hero call bloqueando full houses',
            'BTN vs BB · AQ en AA7-4-7',
            'BTN',
            'BB',
            ['Ah', 'Qd'],
            ['As', 'Ac', '7d', '4h', '7s'],
            48.0,
            1.2,
            42.0,
            'Board doblemente emparejado',
            'BTN bloquea Ax fuertes y reduce combos de full con As.',
            'BB representa 7x/full, pero también puede convertir pares en farol.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♠ A♣ 7♦', 'BB checks', 'BTN bets 2 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'BTN checks back', 'River: 7♠', 'BB bets 34 BB', 'Action on Hero BTN'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'AQ bloquea muchos Ax fuertes y está muy arriba en el rango de BTN. El board da miedo, pero foldear Ax fuerte contra una apuesta polarizada sería excesivo.',
            'GTO simplificado: en boards doblados, manos que bloquean full houses y están altas en rango deben defender.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 84, 'feedback' => 'Buen call. Tu mano bloquea valor y está alta en tu rango.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 58, 'feedback' => 'Fold solo contra rival extremadamente pasivo.'],
                'RAISE' => ['grade' => 'mistake', 'frequency' => 4, 'ev_score' => 20, 'feedback' => 'Raise se aísla contra full houses.'],
            ],
            'No foldees automáticamente por miedo cuando bloqueas gran parte del valor rival.',
            'En NL2-NL10 call contra agresivos; contra pasivos extremos se puede foldear explotativamente.',
            84
        );
    }

    protected static function catchVsMissedComboDrawCall(): array
    {
        return self::spot(
            'river_bluffcatch_sb_vs_btn_qt_qj8_2_3_call',
            'river_bluff_catch',
            'River Bluff Catch',
            'catch_vs_missed_combo_draw',
            'Call contra combo draws fallidos',
            'SB vs BTN · QT en QJ8ss-2-3',
            'SB',
            'BTN',
            ['Qh', 'Td'],
            ['Qs', 'Jh', '8s', '2c', '3d'],
            38.0,
            1.3,
            41.0,
            'River blank tras muchos proyectos fallidos',
            'BTN tiene missed spades, KT, T9 y floats agresivos.',
            'SB tiene top pair medio que desbloquea faroles y bloquea algunas escaleras.',
            ['BTN opens 2.5 BB', 'SB calls', 'Flop: Q♠ J♥ 8♠', 'SB checks', 'BTN bets 4 BB', 'SB calls', 'Turn: 2♣', 'SB checks', 'BTN bets 11 BB', 'SB calls', 'River: 3♦', 'SB checks', 'BTN bets 26 BB', 'Action on Hero SB'],
            ['FOLD', 'CALL', 'RAISE'],
            'CALL',
            'QT no es top kicker, pero el runout deja demasiados combo draws fallidos. Además T bloquea algunas escaleras de valor como T9/KT.',
            'GTO simplificado: top pair con blockers útiles puede pagar en rivers blank cuando los draws principales fallan.',
            [
                'CALL' => ['grade' => 'best', 'frequency' => 50, 'ev_score' => 80, 'feedback' => 'Correcto. Buen bluff catcher contra rango con muchos draws fallidos.'],
                'FOLD' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 66, 'feedback' => 'Fold explotativo aceptable contra población muy pasiva.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 2, 'ev_score' => 8, 'feedback' => 'No conviertas top pair en bluff sin necesidad.'],
            ],
            'Cuando el river no completa proyectos, revisa cuántos faroles naturales quedan en el rango rival.',
            'En microlímites paga solo contra rivales que sí apuestan draws fallidos; contra pasivos, foldea más.',
            80
        );
    }
}
