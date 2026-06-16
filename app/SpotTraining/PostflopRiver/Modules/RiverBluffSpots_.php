<?php

namespace App\SpotTraining\PostflopRiver\Modules;

use App\SpotTraining\PostflopRiver\Concerns\BuildsPostflopRiverSpots;

class RiverBluffSpots
{
    use BuildsPostflopRiverSpots;

    public static function all(): array
    {
        return [
            self::missedFlushAceBlockerJam(),
            self::missedStraightBlockerOverbet(),
            self::riverScareCardBarrel(),
            self::tripleBarrelNutAdvantage(),
            self::giveUpBadBlockers(),
            self::blockerRaiseVsBlockBet(),
            self::polarBetAfterTurnCheckBack(),
            self::pairedBoardRepFullHouse(),
            self::flushCompletesRangeAdvantage(),
            self::lowStakesNoBluffIntoStation(),
        ];
    }

    protected static function missedFlushAceBlockerJam(): array
    {
        return self::spot(
            'river_bluff_btn_vs_bb_as5s_k82ss_4h_9c_bet75',
            'river_bluff',
            'River Bluff',
            'ace_blocker_missed_flush',
            'Farol con blocker al nut flush',
            'BTN vs BB · A5s missed draw river',
            'BTN',
            'BB',
            ['As', '5s'],
            ['Ks', '8s', '2d', '4h', '9c'],
            34.0,
            1.2,
            41.0,
            'River blank tras proyecto de color fallido',
            'BTN conserva Kx fuertes, sets y overpairs; BB tiene muchos pares medios.',
            'BTN tiene más manos fuertes de apuesta triple y bloquea nut flush draws fallidos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 8♠ 2♦', 'BB checks', 'BTN bets 4 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'BTN bets 10 BB', 'BB calls', 'River: 9♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'A♠5♠ no gana casi nunca al showdown, bloquea parte de los mejores missed draws y puede presionar 8x, pares medios y Kx débiles. El check abandona demasiado equity fold.',
            'GTO simplificado: los mejores faroles river suelen tener poco showdown y buenos blockers a calls fuertes o a raises del rival.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 48, 'ev_score' => 82, 'feedback' => 'Correcto. Mano ideal para polarizar: no gana al showdown y tiene blocker relevante.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 25, 'ev_score' => 70, 'feedback' => 'Puede funcionar, pero el tamaño medio genera menos fold equity contra Kx débiles.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 22, 'ev_score' => 38, 'feedback' => 'Demasiado pasivo. Con A alto aquí rara vez ganas sin apostar.'],
            ],
            'El farol river no se elige por valentía; se elige porque tu mano bloquea calls y desbloquea folds.',
            'En NL2-NL10 usa este farol contra rivales capaces de foldear. Contra calling stations, reduce mucho la frecuencia.',
            82
        );
    }

    protected static function missedStraightBlockerOverbet(): array
    {
        return self::spot(
            'river_bluff_co_vs_bb_qt_j98_2_3_overbet',
            'river_bluff',
            'River Bluff',
            'straight_blocker_overbet',
            'Overbet bluff con blocker a escalera',
            'CO vs BB · QT bloquea nuts en J9832',
            'CO',
            'BB',
            ['Qs', 'Th'],
            ['Jd', '9c', '8s', '2h', '3d'],
            38.0,
            1.0,
            38.0,
            'River blank, board conectado donde T7/QT son relevantes',
            'CO tiene sets fuertes y algunas escaleras; BB llega con muchos pares y proyectos fallidos.',
            'CO puede representar rango polarizado fuerte tras apostar flop y turn.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: J♦ 9♣ 8♠', 'BB checks', 'CO bets 5 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'CO bets 12 BB', 'BB calls', 'River: 3♦', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_75', 'RAISE'],
            'BET_75',
            'QT bloquea una parte importante de las escaleras fuertes y no tiene showdown suficiente. Apostar grande presiona Jx, 9x y pares medios que no pueden aguantar tres barrels cómodamente.',
            'GTO simplificado: en runouts donde el agresor conserva manos muy fuertes, los missed draws con blockers pueden entrar en la región de bluff grande.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 44, 'ev_score' => 80, 'feedback' => 'Bien. Tu mano bloquea nuts y necesita fold equity.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 35, 'ev_score' => 50, 'feedback' => 'Rendirse no es horrible contra rivales que no foldean, pero pierdes un bluff natural.'],
                'RAISE' => ['grade' => 'blunder', 'frequency' => 0, 'ev_score' => 5, 'feedback' => 'No hay apuesta previa que subir. Esta opción no encaja con la secuencia.'],
            ],
            'Los blockers importan más cuando apuestas grande, porque representas una región muy estrecha y fuerte.',
            'En microlímites este bluff baja de valor si BB es recreacional pagador. Contra reg débil que sobre-foldea river, imprime dinero.',
            80
        );
    }

    protected static function riverScareCardBarrel(): array
    {
        return self::spot(
            'river_bluff_btn_vs_bb_a5_q72_8_k_bet75',
            'river_bluff',
            'River Bluff',
            'scare_card_river_barrel',
            'Farol en scare card favorable',
            'BTN vs BB · River K favorece al agresor',
            'BTN',
            'BB',
            ['Ah', '5h'],
            ['Qd', '7c', '2s', '8h', 'Ks'],
            27.0,
            1.7,
            45.0,
            'River overcard que mejora más al agresor preflop',
            'BTN tiene AK, KQ y broadways; BB tiene muchas Qx medias y pares bajos.',
            'BTN gana ventaja de nuts por dobles/top pairs fuertes en river K.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♦ 7♣ 2♠', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 8♥', 'BB checks', 'BTN checks back', 'River: K♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'El K es una carta muy buena para el rango de BTN y mala para muchas Qx de BB. A5 no gana casi nada, así que puede convertirse en farol polarizado.',
            'GTO simplificado: las scare cards que favorecen al agresor permiten reactivar bluffs, especialmente con manos sin showdown.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 42, 'ev_score' => 78, 'feedback' => 'Correcto. Presionas una parte capada del rango rival en una carta favorable.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 68, 'feedback' => 'Aceptable, pero puede no generar suficientes folds contra Qx.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 45, 'feedback' => 'Rendirse es viable contra pagadores, pero pierdes un spot claro de presión.'],
            ],
            'No todas las cartas altas son scare cards: solo lo son si mejoran más tu rango que el del rival.',
            'En NL2-NL10 apuesta si el rival tiene botón de fold. Si es calling station, no intentes representar historias complejas.',
            78
        );
    }

    protected static function tripleBarrelNutAdvantage(): array
    {
        return self::spot(
            'river_bluff_co_vs_btn_a4s_a96_2_q_bet75',
            'river_bluff',
            'River Bluff',
            'triple_barrel_nut_advantage',
            'Triple barrel con ventaja de nuts',
            'CO vs BTN · A4s como bluff river',
            'CO',
            'BTN',
            ['Ac', '4c'],
            ['Ad', '9h', '6c', '2s', 'Qh'],
            42.0,
            0.9,
            39.0,
            'River broadway tras dos barrels en A-high seco',
            'CO mantiene AK/AQ/sets; BTN tiene muchos Ax medios capados.',
            'CO tiene ventaja de mejores Ax y sets por iniciativa preflop.',
            ['CO opens 2.5 BB', 'BTN calls', 'Flop: A♦ 9♥ 6♣', 'CO bets 4 BB', 'BTN calls', 'Turn: 2♠', 'CO bets 11 BB', 'BTN calls', 'River: Q♥', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'A4 bloquea Ax y tiene kicker demasiado débil para ganar a menudo al showdown. La Q mejora AQ del agresor y presiona Ax medios del caller.',
            'GTO simplificado: algunos Ax débiles se convierten en bluff cuando bloquean top pair y no pueden value betear.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 36, 'ev_score' => 76, 'feedback' => 'Buena presión. Bloqueas calls y representas Ax mejores.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 42, 'ev_score' => 62, 'feedback' => 'No es malo; tienes algo de showdown. Pero contra rivales que foldean Ax medio, bluffear gana más.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 55, 'feedback' => 'Tamaño poco polarizado. Muchas manos mejores pagan demasiado fácil.'],
            ],
            'Convertir una mano hecha en bluff solo tiene sentido si bloquea mucho valor rival y no gana suficiente al check.',
            'En microlímites ten cuidado: muchos rivales no foldean Ax. Usa este bluff más contra regulares tight.',
            76
        );
    }

    protected static function giveUpBadBlockers(): array
    {
        return self::spot(
            'river_bluff_btn_vs_bb_76hh_k92hh_3_3_check',
            'river_bluff',
            'River Bluff',
            'bad_blockers_give_up',
            'Rendirse con malos blockers',
            'BTN vs BB · 76hh missed draw sin buenos blockers',
            'BTN',
            'BB',
            ['7h', '6h'],
            ['Kh', '9h', '2c', '3d', '3s'],
            33.0,
            1.3,
            43.0,
            'River emparejado, color fallido, pocos blockers útiles',
            'BTN tiene Kx fuertes, pero BB conserva muchos calls con Kx/9x y pocket pairs.',
            'BTN tiene valor, pero esta mano no bloquea suficientemente los calls principales.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♥ 9♥ 2♣', 'BB checks', 'BTN bets 4 BB', 'BB calls', 'Turn: 3♦', 'BB checks', 'BTN bets 9 BB', 'BB calls', 'River: 3♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            '76hh falló y no bloquea Kx, 9x fuertes ni full houses. Apostar aquí suele ser quemar dinero contra un rango que llega demasiado hecho al river.',
            'GTO simplificado: no todos los proyectos fallidos son bluffs. Los peores candidatos se rinden cuando no bloquean calls importantes.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 74, 'feedback' => 'Correcto. Esta mano es mal candidato a bluff river.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 20, 'ev_score' => 36, 'feedback' => 'Tamaño insuficiente y malos blockers. Te pagan demasiado.'],
                'BET_75' => ['grade' => 'mistake', 'frequency' => 14, 'ev_score' => 34, 'feedback' => 'Puedes generar algunos folds, pero tu combo no es bueno para polarizar.'],
            ],
            'Saber rendirse es parte del bluffing correcto. Farolear todos los missed draws destruye el winrate.',
            'En NL2-NL10 este check ahorra muchísimo dinero. El pool paga demasiado en rivers emparejados con top pair.',
            74
        );
    }

    protected static function blockerRaiseVsBlockBet(): array
    {
        return self::spot(
            'river_bluff_bb_vs_btn_asx_raise_blockbet',
            'river_bluff',
            'River Bluff',
            'raise_vs_block_bet_blocker',
            'Raise bluff vs block bet con blocker',
            'BB vs BTN · A♠ blocker vs block bet river',
            'BB',
            'BTN',
            ['As', '7d'],
            ['Qs', '8s', '4c', '2h', '6s'],
            24.0,
            2.0,
            48.0,
            'River completa color, agresor apuesta pequeño bloqueando',
            'BTN tiene muchas manos medias que bloquean; BB tiene más suited defendidos.',
            'BB puede tener flushes; A♠ bloquea nut flush del rival.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♠ 8♠ 4♣', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'BTN checks back', 'River: 6♠', 'BB checks', 'BTN bets 5 BB into 24 BB', 'Action on Hero BB'],
            ['FOLD', 'CALL', 'RAISE'],
            'RAISE',
            'La apuesta pequeña de BTN suele ser mano media buscando showdown barato. A♠ bloquea el nut flush, y BB puede representar muchos colores defendidos.',
            'GTO simplificado: contra block bets, se puede construir rango de raise polarizado con valor fuerte y blockers clave.',
            [
                'RAISE' => ['grade' => 'best', 'frequency' => 34, 'ev_score' => 78, 'feedback' => 'Correcto. Buen blocker y excelente presión contra sizing débil.'],
                'CALL' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 30, 'feedback' => 'A high no gana suficiente contra una apuesta por valor/protección.'],
                'FOLD' => ['grade' => 'marginal', 'frequency' => 40, 'ev_score' => 55, 'feedback' => 'Fold es seguro, pero pierdes un raise bluff rentable contra rangos capados.'],
            ],
            'Los block bets pequeños en river suelen revelar rangos capados. Ahí los blockers ganan mucho valor.',
            'En microlímites haz esto solo contra rivales capaces de foldear. Contra recreacional pagador, foldea y sigue.',
            78
        );
    }

    protected static function polarBetAfterTurnCheckBack(): array
    {
        return self::spot(
            'river_bluff_btn_vs_bb_jt_ace_river_bet75',
            'river_bluff',
            'River Bluff',
            'polar_after_turn_check_back',
            'Farol tras check back turn',
            'BTN vs BB · River A como carta de presión',
            'BTN',
            'BB',
            ['Js', 'Ts'],
            ['Qh', '6c', '2d', '5s', 'Ac'],
            16.0,
            3.0,
            48.0,
            'River A tras check back turn, rango de BB capado',
            'BTN puede tener Ax que controla turn; BB tiene muchas parejas medias.',
            'BTN gana ventaja de top pair fuerte en river A.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♥ 6♣ 2♦', 'BB checks', 'BTN bets 2.5 BB', 'BB calls', 'Turn: 5♠', 'BB checks', 'BTN checks back', 'River: A♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'JT no gana al showdown y el A permite representar Ax que hizo pot control turn. BB queda cargado de Qx débil, 6x y pares que sufren ante apuesta grande.',
            'GTO simplificado: después de check back turn, algunas scare cards permiten apostar polarizado river porque el rango del rival queda limitado.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 38, 'ev_score' => 76, 'feedback' => 'Buena historia. Representas Ax creíble y atacas rango capado.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 66, 'feedback' => 'Funciona a veces, pero el tamaño grande presiona mejor Qx.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 36, 'ev_score' => 44, 'feedback' => 'Check pierde casi siempre, aunque está bien contra rivales que no foldean nada.'],
            ],
            'Un check back turn no siempre abandona la mano; a veces prepara una apuesta river cuando cambia la ventaja de rango.',
            'En NL2-NL10 este bluff depende mucho del rival. Si paga cualquier pareja, no lo hagas.',
            76
        );
    }

    protected static function pairedBoardRepFullHouse(): array
    {
        return self::spot(
            'river_bluff_sb_vs_btn_t9_998_2_2_bet75',
            'river_bluff',
            'River Bluff',
            'paired_board_full_house_rep',
            'Representar full en board doblado',
            'SB vs BTN · T9 bloquea trips en 99822',
            'SB',
            'BTN',
            ['Ts', '9s'],
            ['9d', '9c', '8h', '2d', '2s'],
            30.0,
            1.5,
            45.0,
            'Doble paired board, rangos muy polarizados',
            'SB tiene 9x fuertes y algunos full houses; BTN tiene muchos bluffcatchers.',
            'SB bloquea trips y puede representar full houses por línea agresiva.',
            ['BTN opens 2.5 BB', 'SB calls', 'Flop: 9♦ 9♣ 8♥', 'SB checks', 'BTN bets 2.5 BB', 'SB calls', 'Turn: 2♦', 'SB checks', 'BTN checks back', 'River: 2♠', 'Action on Hero SB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'T9 bloquea muchos 9x de BTN y puede apostar polarizado representando full/trips fuertes. Check gana a veces, pero permite showdown barato a pares medios.',
            'GTO simplificado: blockers a trips/full houses permiten algunas apuestas polarizadas en boards muy emparejados.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 35, 'ev_score' => 74, 'feedback' => 'Buena presión polarizada con blocker fuerte.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 64, 'feedback' => 'Aceptable, aunque menos presión sobre pares medios.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 38, 'ev_score' => 56, 'feedback' => 'Tienes algo de showdown, pero pierdes fold equity en un runout favorable.'],
            ],
            'En boards doblados, los blockers cambian mucho la decisión porque las combinaciones de valor son pocas.',
            'Contra jugadores pasivos que no foldean full-house boards, baja frecuencia. Contra regs miedosos, presiona.',
            74
        );
    }

    protected static function flushCompletesRangeAdvantage(): array
    {
        return self::spot(
            'river_bluff_bb_vs_btn_kd7x_flush_complete_bet75',
            'river_bluff',
            'River Bluff',
            'flush_complete_range_advantage',
            'Donk bluff cuando completa color del defensor',
            'BB vs BTN · River completa color favorable BB',
            'BB',
            'BTN',
            ['Kd', '7c'],
            ['Qd', '8d', '3s', '2h', '5d'],
            22.0,
            2.4,
            52.0,
            'River completa color de diamantes tras turn check back',
            'BB defiende muchos suited; BTN tiene overcards y Qx que controlan bote.',
            'BB gana ventaja de flushes bajos/medios por defensa amplia.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: Q♦ 8♦ 3♠', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 2♥', 'BB checks', 'BTN checks back', 'River: 5♦', 'Action on Hero BB'],
            ['CHECK', 'BET_50', 'BET_75'],
            'BET_75',
            'K♦ bloquea color fuerte y BB representa muchos flushes defendidos. BTN, al checkear turn, tiene muchas manos medias que no soportan presión grande.',
            'GTO simplificado: cuando una carta completa más proyectos del defensor que del agresor, el defensor puede liderar polarizado.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 40, 'ev_score' => 78, 'feedback' => 'Correcto. Buen blocker y carta excelente para tu rango.'],
                'BET_50' => ['grade' => 'good', 'frequency' => 28, 'ev_score' => 66, 'feedback' => 'Puede tirar aire, pero presiona menos a Qx.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 32, 'ev_score' => 48, 'feedback' => 'Check gana poco y deja pasar un buen spot de presión.'],
            ],
            'Las mejores donk bets river suelen aparecer cuando la carta final cambia la ventaja de nuts hacia el defensor.',
            'En NL2-NL10 este farol funciona mejor contra jugadores que entienden el peligro del color. Contra pagadores, apuesta solo valor.',
            78
        );
    }

    protected static function lowStakesNoBluffIntoStation(): array
    {
        return self::spot(
            'river_bluff_co_vs_bb_missed_draw_station_check',
            'river_bluff',
            'River Bluff',
            'exploit_no_bluff_station',
            'No farolear a calling station',
            'CO vs BB · Missed draw contra perfil pagador',
            'CO',
            'BB',
            ['Ah', 'Th'],
            ['Kd', 'Jh', '6h', '4c', '4s'],
            36.0,
            1.1,
            40.0,
            'River emparejado, proyecto fallido contra rival que paga demasiado',
            'CO tiene manos fuertes, pero BB llega cargado de Kx/Jx y no foldea suficiente.',
            'CO puede representar valor, pero el perfil rival reduce mucho la fold equity.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: K♦ J♥ 6♥', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 4♣', 'BB checks', 'CO bets 11 BB', 'BB calls', 'River: 4♠', 'BB checks', 'Read: BB es calling station', 'Action on Hero CO'],
            ['CHECK', 'BET_50', 'BET_75'],
            'CHECK',
            'Aunque ATh parece tener blockers y proyecto fallido, el dato clave es el perfil: si BB paga demasiado, el farol pierde valor. Aquí la mejor explotación es rendirse.',
            'GTO simplificado: este combo podría bluffear cierta frecuencia, pero la estrategia explotativa elimina faroles contra perfiles que no foldean.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 62, 'ev_score' => 78, 'feedback' => 'Correcto. Contra calling station, no quemes dinero faroleando river.'],
                'BET_50' => ['grade' => 'mistake', 'frequency' => 18, 'ev_score' => 32, 'feedback' => 'Tamaño tentador, pero este rival paga demasiado con manos medias.'],
                'BET_75' => ['grade' => 'blunder', 'frequency' => 8, 'ev_score' => 18, 'feedback' => 'Malo contra este perfil. El tamaño grande no sirve si no existe fold equity.'],
            ],
            'La teoría permite algunos bluffs; el exploit correcto los elimina cuando el rival no foldea.',
            'Esta es una regla de oro en NL2-NL10: farolea menos contra calling stations y apuesta más fuerte por valor.',
            84
        );
    }
    protected static function aceBlockerBluff(): array { return self::missedFlushDrawBluff(); }
    protected static function pairedBoardBluff(): array { return self::missedFlushDrawBluff(); }
    protected static function fourLinerBluff(): array { return self::missedFlushDrawBluff(); }
    protected static function missedComboDrawBluff(): array { return self::missedFlushDrawBluff(); }
    protected static function delayedRiverBluff(): array { return self::missedFlushDrawBluff(); }
    protected static function tripleBarrelScareCard(): array { return self::missedFlushDrawBluff(); }
    protected static function flushCompletesBluff(): array { return self::missedFlushDrawBluff(); }
    protected static function fullHouseBlockerBluff(): array { return self::missedFlushDrawBluff(); }
    protected static function cappedRangeRiverBluff(): array { return self::missedFlushDrawBluff(); }
    protected static function dontBluffCallingStation(): array { return self::missedFlushDrawBluff(); }

}
