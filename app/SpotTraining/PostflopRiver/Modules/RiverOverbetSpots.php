<?php

namespace App\SpotTraining\PostflopRiver\Modules;

use App\SpotTraining\PostflopRiver\Concerns\BuildsPostflopRiverSpots;

class RiverOverbetSpots
{
    use BuildsPostflopRiverSpots;

    public static function all(): array
    {
        return [
            self::nutStraightPolarOverbet(),
            self::missedFlushBlockerOverbet(),
            self::boatVsTripsStation(),
            self::aceBlockerFourFlushRiver(),
            self::rangeNutAdvantageBrickRiver(),
            self::doNotOverbetMergedValue(),
            self::overbetVsCappedCheckLine(),
            self::polarOverbetPairedBoard(),
            self::giveUpBadBlockers(),
            self::overbetJamNutFlush(),
        ];
    }

    protected static function nutStraightPolarOverbet(): array
    {
        return self::spot(
            'river_overbet_btn_vs_bb_qj_t98_2_k_bet125',
            'river_overbet',
            'River Overbet',
            'nut_straight_polar_value',
            'Escalera máxima en river polarizado',
            'BTN vs BB · QJ completa nuts y presiona rango capado',
            'BTN',
            'BB',
            ['Qh', 'Jh'],
            ['Ts', '9c', '8d', '2s', 'Kc'],
            42.0,
            1.5,
            64.0,
            'River K completa escalera máxima para QJ y deja muchas manos medias incómodas',
            'BTN tiene más QJ, sets fuertes y dobles apostadas por valor.',
            'BTN concentra más nuts; BB llega con muchas parejas, Tx, 9x y bluffcatchers.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: T♠ 9♣ 8♦', 'BB checks', 'BTN bets 4 BB', 'BB calls', 'Turn: 2♠', 'BB checks', 'BTN bets 11 BB', 'BB calls', 'River: K♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_75', 'BET_125'],
            'BET_125',
            'Con la escalera máxima Hero puede polarizar. El overbet castiga a bluffcatchers y extrae máximo contra dobles, sets y calls curiosos.',
            'GTO simplificado: cuando tu rango tiene ventaja de nuts y tu mano está en la parte alta, puedes usar overbet para representar valor/bluff polarizado.',
            [
                'BET_125' => ['grade' => 'best', 'frequency' => 58, 'ev_score' => 92, 'feedback' => 'Correcto. Mano perfecta para overbet polarizado por valor.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 78, 'feedback' => 'Gana dinero, pero deja valor contra rangos que no foldean suficiente.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 12, 'ev_score' => 22, 'feedback' => 'Muy pasivo. Estás perdiendo muchísimo valor con una mano de techo.'],
            ],
            'Overbet river no es apostar grande porque sí; es hacerlo cuando tu rango puede representar muchos nuts.',
            'En NL2-NL10 este overbet funciona muy bien por valor: te pagan con dobles, sets y manos que no deberían pagar.',
            89
        );
    }

    protected static function missedFlushBlockerOverbet(): array
    {
        return self::spot(
            'river_overbet_co_vs_bb_as5s_k74ss_2d_9c_bluff125',
            'river_overbet',
            'River Overbet',
            'missed_draw_blocker_bluff',
            'Farol con blockers tras proyecto fallido',
            'CO vs BB · A5s bloquea nuts y puede overbetear',
            'CO',
            'BB',
            ['As', '5s'],
            ['Ks', '7s', '4c', '2d', '9c'],
            36.0,
            1.8,
            66.0,
            'River blank, falló color y Hero bloquea nut flush draws con As',
            'CO conserva más AK, sets y overpairs jugados agresivamente.',
            'CO puede representar valor fuerte; BB tiene muchos Kx y pares medios capados.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: K♠ 7♠ 4♣', 'BB checks', 'CO bets 3.5 BB', 'BB calls', 'Turn: 2♦', 'BB checks', 'CO bets 9 BB', 'BB calls', 'River: 9♣', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_75', 'BET_125'],
            'BET_125',
            'A5s sin showdown value es buen candidato: bloquea proyectos fuertes y no gana al check. El overbet maximiza fold equity contra Kx débiles.',
            'GTO simplificado: los mejores faroles river suelen bloquear calls fuertes y desbloquear folds del rival.',
            [
                'BET_125' => ['grade' => 'best', 'frequency' => 42, 'ev_score' => 82, 'feedback' => 'Buen bluff polarizado. Tienes blockers y poca showdown value.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 69, 'feedback' => 'También puede funcionar, pero presiona menos a Kx.'],
                'CHECK' => ['grade' => 'mistake', 'frequency' => 24, 'ev_score' => 38, 'feedback' => 'Rendir puede ser demasiado débil con este blocker.'],
            ],
            'El blocker no convierte cualquier mano en bluff; aquí importa que Hero casi no tenga showdown value.',
            'En microlímites usa este bluff con cuidado. Contra calling stations puras, baja frecuencia y prefiere valor.',
            81
        );
    }

    protected static function boatVsTripsStation(): array
    {
        return self::spot(
            'river_overbet_sb_vs_bb_77_k72_7_2_bet125',
            'river_overbet',
            'River Overbet',
            'full_house_vs_station',
            'Full house contra trips y Kx curioso',
            'SB vs BB · Full house para overbet de valor',
            'SB',
            'BB',
            ['7h', '7d'],
            ['Ks', '7c', '2h', '7s', '2d'],
            31.0,
            2.1,
            65.0,
            'Board doblado dos veces, Hero tiene full superior muy oculto',
            'SB mantiene rango fuerte tras apostar varias calles.',
            'SB tiene muchos boats; BB puede llegar con trips, Kx y pares curiosos.',
            ['SB raises 3 BB', 'BB calls', 'Flop: K♠ 7♣ 2♥', 'SB bets 3 BB', 'BB calls', 'Turn: 7♠', 'SB bets 8 BB', 'BB calls', 'River: 2♦', 'BB checks', 'Action on Hero SB'],
            ['CHECK', 'BET_75', 'BET_125'],
            'BET_125',
            'Hero tiene una mano que bloquea parte del board pero sigue recibiendo calls de trips y algunos Kx en pools recreacionales. El overbet captura máximo.',
            'GTO simplificado: con valor extremadamente fuerte puedes usar size grande para polarizar contra bluffcatchers.',
            [
                'BET_125' => ['grade' => 'best', 'frequency' => 55, 'ev_score' => 90, 'feedback' => 'Correcto. Valor máximo contra rangos que no foldean trips.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 79, 'feedback' => 'Bien, pero algo conservador contra rivales pagadores.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 11, 'ev_score' => 20, 'feedback' => 'No puedes dejar de apostar una mano tan fuerte.'],
            ],
            'Las manos de techo quieren construir botes grandes, especialmente cuando el rival tiene muchas segundas mejores manos.',
            'En NL2-NL10 este spot es value puro: muchos rivales no sueltan trips ni full houses peores.',
            87
        );
    }

    protected static function aceBlockerFourFlushRiver(): array
    {
        return self::spot(
            'river_overbet_btn_vs_bb_adqc_jd8d3c_2d_6d_bluff125',
            'river_overbet',
            'River Overbet',
            'ace_blocker_four_flush',
            'Blocker al color máximo en river de cuatro diamantes',
            'BTN vs BB · A♦ bloquea nuts en board mono river',
            'BTN',
            'BB',
            ['Ad', 'Qc'],
            ['Jd', '8d', '3c', '2d', '6d'],
            34.0,
            1.9,
            64.0,
            'Cuatro diamantes en mesa; Hero bloquea el color máximo con A♦',
            'BTN tiene más overpairs con diamante y manos fuertes apostadas.',
            'BB tiene muchos pares con un diamante medio, pero pocos colores máximos.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: J♦ 8♦ 3♣', 'BB checks', 'BTN bets 3.5 BB', 'BB calls', 'Turn: 2♦', 'BB checks', 'BTN checks back', 'River: 6♦', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_50', 'BET_125'],
            'BET_125',
            'Hero no tiene showdown suficiente, pero bloquea el color máximo. El overbet puede tirar Jx, 8x y colores bajos incómodos.',
            'GTO simplificado: en rivers de cuatro cartas a color, el blocker al as puede justificar faroles grandes si el rival llega capado.',
            [
                'BET_125' => ['grade' => 'best', 'frequency' => 38, 'ev_score' => 80, 'feedback' => 'Buen bluff por blocker. Representas color alto de forma creíble.'],
                'BET_50' => ['grade' => 'marginal', 'frequency' => 28, 'ev_score' => 55, 'feedback' => 'Tamaño pequeño no presiona suficiente a bluffcatchers.'],
                'CHECK' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 62, 'feedback' => 'Aceptar showdown bajo puede ser razonable contra rivales muy pagadores.'],
            ],
            'El blocker al nut flush reduce combinaciones fuertes del rival, pero no obliga a farolear siempre.',
            'En NL2-NL10 evita este bluff contra jugadores que pagan cualquier color. Úsalo contra perfiles capaces de foldear.',
            78
        );
    }

    protected static function rangeNutAdvantageBrickRiver(): array
    {
        return self::spot(
            'river_overbet_btn_vs_bb_aa_a73_4_2_bet125',
            'river_overbet',
            'River Overbet',
            'range_nut_advantage_brick',
            'Ventaja de nuts en river blank',
            'BTN vs BB · AA polariza en runout seco',
            'BTN',
            'BB',
            ['Ah', 'As'],
            ['Ad', '7c', '3s', '4h', '2c'],
            39.0,
            1.6,
            63.0,
            'Runout seco donde BTN mantiene todos los Ax fuertes y sets',
            'BTN tiene clara ventaja de rango y de manos premium.',
            'BTN posee más Ax fuertes; BB tiene muchos pares medios y Ax peores.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♦ 7♣ 3♠', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 4♥', 'BB checks', 'BTN bets 9 BB', 'BB calls', 'River: 2♣', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_75', 'BET_125'],
            'BET_125',
            'AA es techo absoluto. En un river que no cambia demasiado, Hero puede overbetear para cobrar máximo a Ax peores que no foldean.',
            'GTO simplificado: cuando tu rango tiene mucha ventaja de nuts, el size grande permite apostar valor muy fuerte y bluffs seleccionados.',
            [
                'BET_125' => ['grade' => 'best', 'frequency' => 52, 'ev_score' => 91, 'feedback' => 'Correcto. Mano de techo y rival con muchas segundas mejores manos.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 35, 'ev_score' => 80, 'feedback' => 'Correcto, aunque menos ambicioso.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 13, 'ev_score' => 18, 'feedback' => 'Check pierde demasiado valor.'],
            ],
            'Overbet por valor exige que manos peores puedan pagar; aquí Ax peores hacen ese trabajo.',
            'En microlímites este spot es excelente para apostar grande: muchos jugadores no foldean top pair.',
            90
        );
    }

    protected static function doNotOverbetMergedValue(): array
    {
        return self::spot(
            'river_overbet_co_vs_bb_kq_k84_t_3_bet75_not125',
            'river_overbet',
            'River Overbet',
            'avoid_overbet_merged_value',
            'No sobreapostar valor medio',
            'CO vs BB · KQ value, pero no overbet',
            'CO',
            'BB',
            ['Kh', 'Qh'],
            ['Ks', '8d', '4c', 'Tc', '3s'],
            30.0,
            2.0,
            60.0,
            'River blank con top pair buen kicker, pero no mano polar',
            'CO tiene ventaja moderada, no aplastante.',
            'Nuts repartidos; BB aún tiene dobles, sets y Kx fuertes.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: K♠ 8♦ 4♣', 'BB checks', 'CO bets 3.5 BB', 'BB calls', 'Turn: T♣', 'BB checks', 'CO bets 8 BB', 'BB calls', 'River: 3♠', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_75', 'BET_125'],
            'BET_75',
            'KQ quiere valor, pero no pertenece al rango polar de overbet. Una apuesta normal cobra a Kx peores y evita aislarse contra manos mejores.',
            'GTO simplificado: no todas las manos fuertes son candidatas a overbet; el overbet debe ser polar, no merged.',
            [
                'BET_75' => ['grade' => 'best', 'frequency' => 48, 'ev_score' => 81, 'feedback' => 'Correcto. Value claro sin pasarte de tamaño.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 24, 'ev_score' => 59, 'feedback' => 'Demasiado prudente, aunque evita spots difíciles.'],
                'BET_125' => ['grade' => 'mistake', 'frequency' => 28, 'ev_score' => 45, 'feedback' => 'Overbet demasiado fino. Te pagan demasiadas manos mejores.'],
            ],
            'La disciplina de no overbetear valor medio es tan importante como saber overbetear nuts.',
            'En NL2-NL10 apuesta por valor, sí, pero no conviertas top pair en una mano que solo recibe calls mejores.',
            84
        );
    }

    protected static function overbetVsCappedCheckLine(): array
    {
        return self::spot(
            'river_overbet_btn_vs_sb_98s_q76_2_5_bet125',
            'river_overbet',
            'River Overbet',
            'capped_range_pressure',
            'Presión contra línea capada',
            'BTN vs SB · Escalera vs checks pasivos',
            'BTN',
            'SB',
            ['9s', '8s'],
            ['Qh', '7c', '6d', '2h', '5c'],
            27.0,
            2.4,
            66.0,
            'River completa escalera para 98; SB ha jugado check-call y llega capado',
            'BTN tiene más manos conectadas y faroles naturales.',
            'BTN tiene nuts con 98/43; SB rara vez llega con escalera fuerte.',
            ['BTN opens 2.5 BB', 'SB calls', 'Flop: Q♥ 7♣ 6♦', 'SB checks', 'BTN bets 3 BB', 'SB calls', 'Turn: 2♥', 'SB checks', 'BTN checks back', 'River: 5♣', 'SB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_75', 'BET_125'],
            'BET_125',
            'Hero liga escalera fuerte contra un rango muy capado. El overbet fuerza calls difíciles a Qx y dobles.',
            'GTO simplificado: cuando el rival muestra pasividad y tu rango contiene nuts que él tiene pocas veces, puedes presionar con overbet.',
            [
                'BET_125' => ['grade' => 'best', 'frequency' => 50, 'ev_score' => 88, 'feedback' => 'Correcto. Rango rival capado y mano de valor polar.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 34, 'ev_score' => 77, 'feedback' => 'Bien, aunque menos castigador.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 16, 'ev_score' => 24, 'feedback' => 'Pierdes valor claro.'],
            ],
            'Los rangos capados sufren contra overbets porque no pueden defender suficiente sin pagar manos medias.',
            'En microlímites esto gana mucho valor: los rivales pagan Qx más de lo que deberían.',
            86
        );
    }

    protected static function polarOverbetPairedBoard(): array
    {
        return self::spot(
            'river_overbet_bb_vs_btn_44_a94_9_2_checkraise_line_bet125',
            'river_overbet',
            'River Overbet',
            'paired_board_polar_value',
            'Valor polar en board emparejado',
            'BB vs BTN · Full house oculto para overbet',
            'BB',
            'BTN',
            ['4c', '4d'],
            ['Ah', '9s', '4h', '9c', '2d'],
            46.0,
            1.3,
            60.0,
            'Board emparejado donde Hero tiene full house oculto',
            'BTN tiene ventaja preflop, pero BB conecta muchos 9x/4x defendidos.',
            'BB tiene nuts muy fuertes en esta textura concreta.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: A♥ 9♠ 4♥', 'BB checks', 'BTN bets 3 BB', 'BB calls', 'Turn: 9♣', 'BB checks', 'BTN bets 10 BB', 'BB calls', 'River: 2♦', 'Action on Hero BB'],
            ['CHECK', 'BET_75', 'BET_125'],
            'BET_125',
            'Hero tiene full house y puede liderar polarizado. Muchos Ax fuertes y 9x del BTN pueden pagar demasiado.',
            'GTO simplificado: un donk overbet river puede existir cuando la carta final deja al defensor con ventaja de nuts específica.',
            [
                'BET_125' => ['grade' => 'best', 'frequency' => 44, 'ev_score' => 86, 'feedback' => 'Excelente. Overbet por valor con mano muy oculta.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 36, 'ev_score' => 76, 'feedback' => 'Gana valor, pero no maximiza contra manos fuertes peores.'],
                'CHECK' => ['grade' => 'marginal', 'frequency' => 20, 'ev_score' => 60, 'feedback' => 'Puedes inducir, pero arriesgas que el rival haga check back.'],
            ],
            'No todos los overbets vienen del agresor; el defensor también puede overbetear cuando captura la ventaja de nuts.',
            'En NL2-NL10 liderar grande con full oculto es muy rentable contra jugadores que no foldean trips/top pair.',
            82
        );
    }

    protected static function giveUpBadBlockers(): array
    {
        return self::spot(
            'river_overbet_co_vs_bb_qj_t96_2_3_check_badblockers',
            'river_overbet',
            'River Overbet',
            'give_up_bad_blockers',
            'Rendirse con blockers malos',
            'CO vs BB · QJ no debe overbetear este river',
            'CO',
            'BB',
            ['Qh', 'Jh'],
            ['Td', '9d', '6c', '2s', '3c'],
            33.0,
            1.9,
            62.0,
            'River blank, proyectos fallidos, pero Hero bloquea muchos folds naturales',
            'CO tiene cierta ventaja, pero BB conserva Tx, 9x y pares que pagan.',
            'Nuts no tan claras para Hero; BB también tiene sets y dobles.',
            ['CO opens 2.5 BB', 'BB calls', 'Flop: T♦ 9♦ 6♣', 'BB checks', 'CO bets 4 BB', 'BB calls', 'Turn: 2♠', 'BB checks', 'CO bets 9 BB', 'BB calls', 'River: 3♣', 'BB checks', 'Action on Hero CO'],
            ['CHECK', 'BET_75', 'BET_125'],
            'CHECK',
            'QJ fallido parece candidato natural, pero bloquea manos como QJ/J8 que podrían foldear y no bloquea suficientes calls fuertes. Rendirse es mejor.',
            'GTO simplificado: un mal blocker puede convertir un bluff atractivo visualmente en un bluff de baja calidad.',
            [
                'CHECK' => ['grade' => 'best', 'frequency' => 48, 'ev_score' => 76, 'feedback' => 'Correcto. No todos los draws fallidos se farolean.'],
                'BET_75' => ['grade' => 'marginal', 'frequency' => 30, 'ev_score' => 52, 'feedback' => 'Puede funcionar contra nits, pero no es el mejor candidato.'],
                'BET_125' => ['grade' => 'mistake', 'frequency' => 22, 'ev_score' => 38, 'feedback' => 'Overbet malo: blockers pobres y demasiados calls del rival.'],
            ],
            'El mejor bluff no es el que falló más bonito; es el que bloquea calls y desbloquea folds.',
            'En microlímites este overbet quema dinero contra rivales que pagan Tx/9x. Mejor check y aceptar la pérdida.',
            85
        );
    }

    protected static function overbetJamNutFlush(): array
    {
        return self::spot(
            'river_overbet_btn_vs_bb_asqs_ks8s4d_2c_6s_bet125',
            'river_overbet',
            'River Overbet',
            'nut_flush_overbet_jam',
            'Color máximo para overbet grande',
            'BTN vs BB · Nut flush completa river',
            'BTN',
            'BB',
            ['As', 'Qs'],
            ['Ks', '8s', '4d', '2c', '6s'],
            44.0,
            1.2,
            54.0,
            'River completa color; Hero tiene nut flush y SPR bajo',
            'BTN tiene muchos proyectos de color fuertes y valor premium.',
            'BTN tiene color máximo más a menudo; BB llega con Kx, colores peores y bluffcatchers.',
            ['BTN opens 2.5 BB', 'BB calls', 'Flop: K♠ 8♠ 4♦', 'BB checks', 'BTN bets 4 BB', 'BB calls', 'Turn: 2♣', 'BB checks', 'BTN bets 12 BB', 'BB calls', 'River: 6♠', 'BB checks', 'Action on Hero BTN'],
            ['CHECK', 'BET_75', 'BET_125'],
            'BET_125',
            'Con SPR bajo y nut flush, Hero puede presionar todo el rango de calls. Colores peores y Kx con spade pagan suficiente.',
            'GTO simplificado: cuando la mejor mano posible está en tu rango y tu mano bloquea el techo rival, el overbet es natural.',
            [
                'BET_125' => ['grade' => 'best', 'frequency' => 60, 'ev_score' => 94, 'feedback' => 'Correcto. Nut flush quiere máximo valor.'],
                'BET_75' => ['grade' => 'good', 'frequency' => 30, 'ev_score' => 82, 'feedback' => 'Bien, pero quizá dejas dinero contra colores peores.'],
                'CHECK' => ['grade' => 'blunder', 'frequency' => 10, 'ev_score' => 16, 'feedback' => 'Check es perder valor masivo.'],
            ],
            'Los overbets más rentables en river suelen venir de manos que dominan completamente la parte fuerte del rival.',
            'En NL2-NL10 apuesta grande sin miedo: muchos pagan colores peores y top pair con una pica.',
            91
        );
    }
}
