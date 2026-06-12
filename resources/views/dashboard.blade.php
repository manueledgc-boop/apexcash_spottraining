<x-app-layout>
    <link href="{{ asset('assets/css/apexcash-dashboard.css') }}" rel="stylesheet">

    @php
        $total = (int) ($global->total_spots ?? 0);
        $correct = (int) ($global->correct_spots ?? 0);
        $wrong = (int) ($global->wrong_spots ?? 0);
        $accuracy = (float) ($global->accuracy ?? 0);
        $xp = (int) ($global->xp ?? 0);
        $level = (int) ($global->level ?? 1);
        $levelBase = max(0, ($level - 1) * 250);
        $levelProgress = max(0, $xp - $levelBase);
        $levelPercent = min(100, round(($levelProgress / 250) * 100));
        $worstLeak = $leaks->first();
        $postflopModules = $postflopModules ?? ['cbet_ip', 'check_back_ip', 'defense_vs_cbet', 'check_raise', 'value_bet', 'semi_bluff'];
    @endphp

    <main class="dashboard-page">
        <section class="dashboard-hero">
            <div>
                <span class="dashboard-badge">APEXCASH TRAINING DASHBOARD</span>
                <h1>Hola, {{ auth()->user()->name }}</h1>
                <p>Tu progreso ya está guardado: XP, precisión, módulos fuertes, módulos débiles, últimos resultados y leaks reales.</p>
            </div>

            <div class="dashboard-actions">
                <a href="{{ route('spot-training.index') }}" class="dashboard-main-btn">Preflop</a>
                <a href="{{ route('postflop-training.index') }}" class="dashboard-secondary-btn">Postflop</a>
                @if ($worstLeak)
                    @php
                        $worstLeakRoute = in_array($worstLeak->module, $postflopModules, true)
                            ? 'postflop-training.index'
                            : 'spot-training.index';
                    @endphp
                    <a href="{{ route($worstLeakRoute, ['module' => $worstLeak->module]) }}" class="dashboard-secondary-btn">Practicar peor leak</a>
                @endif
            </div>
        </section>

        @if ($criticalLeak)
        @php
            $criticalErrors = max(0, (int) $criticalLeak->total - (int) $criticalLeak->correct);
        @endphp

        <section class="critical-leak-panel">
            <div>
                <span>🚨 LEAK CRÍTICO DETECTADO</span>
                <h2>{{ $criticalLeak->module_label }}</h2>
                <p>
                    Accuracy {{ number_format((float) $criticalLeak->accuracy, 1) }}%.
                    Has fallado {{ $criticalErrors }} de {{ $criticalLeak->total }} spots en este módulo.
                </p>
            </div>

            @php
                $criticalLeakRoute = in_array($criticalLeak->module, $postflopModules, true)
                    ? 'postflop-training.index'
                    : 'spot-training.index';
            @endphp

            <a href="{{ route($criticalLeakRoute, ['module' => $criticalLeak->module]) }}">
                Practicar ahora
            </a>
        </section>
    @endif

        <section class="progress-panel">
            <div>
                <span>Nivel {{ $level }}</span>
                <strong>{{ $xp }} XP</strong>
                <p>Siguiente objetivo: {{ $nextGoal }} </p>
            </div>
            <div class="xp-bar" aria-label="Progreso de XP">
                <span style="width: {{ $levelPercent }}%"></span>
            </div>
        </section>

        <section class="dashboard-stats">
            <article><span>Spots completados</span><strong>{{ $total }}</strong></article>
            <article><span>Precisión global</span><strong>{{ number_format($accuracy, 1) }}%</strong></article>
            <article><span>Aciertos</span><strong>{{ $correct }}</strong></article>
            <article><span>Errores</span><strong>{{ $wrong }}</strong></article>
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card">
                <span>Ruta ApexCash</span>
                <h2>Progresión</h2>

                <div class="metric-row">
                    <span>Preflop</span>
                    <strong>
                        {{ number_format((float) ($preflopGlobal->accuracy ?? 0), 1) }}%
                        {{ $flopUnlocked ? '✅' : '🔒' }}
                    </strong>
                </div>

                <div class="metric-row">
                    <span>Flop</span>
                    <strong>
                        {{ number_format((float) ($flopGlobal->accuracy ?? 0), 1) }}%
                        {{ $turnUnlocked ? '✅' : '🔒' }}
                    </strong>
                </div>

                <div class="metric-row">
                    <span>Turn</span>
                    <strong>
                        {{ number_format((float) ($turnGlobal->accuracy ?? 0), 1) }}%
                        {{ $riverUnlocked ? '✅' : '🔒' }}
                    </strong>
                </div>

                <div class="metric-row">
                    <span>River</span>
                    <strong>
                        {{ number_format((float) ($riverGlobal->accuracy ?? 0), 1) }}%
                        {{ $masteryUnlocked ? '🏆' : '🔒' }}
                    </strong>
                </div>
            </article>

            <article class="dashboard-card">
                <span>Precisión por etapa</span>
                <h2>Entrenamiento</h2>

                <div class="metric-row"><span>Preflop</span><strong>{{ number_format((float) ($preflopGlobal->accuracy ?? 0), 1) }}%</strong></div>
                <div class="metric-row"><span>Flop</span><strong>{{ number_format((float) ($flopGlobal->accuracy ?? 0), 1) }}%</strong></div>
                <div class="metric-row"><span>Turn</span><strong>{{ number_format((float) ($turnGlobal->accuracy ?? 0), 1) }}%</strong></div>
                <div class="metric-row"><span>River</span><strong>{{ number_format((float) ($riverGlobal->accuracy ?? 0), 1) }}%</strong></div>
            </article>
        </section>

        <section class="dashboard-grid">
            <article class="dashboard-card active">
                <span>Mejor módulo</span>
                <h2>{{ $bestModule->module_label ?? 'Sin muestra suficiente' }}</h2>
                <p>
                    @if ($bestModule)
                        {{ number_format((float) $bestModule->accuracy, 1) }}% de precisión en {{ $bestModule->total_spots }} spots.
                    @else
                        Necesitas al menos 3 spots por módulo para detectar fortalezas reales.
                    @endif
                </p>
            </article>

            <article class="dashboard-card danger-card">
                <span>Peor módulo</span>
                <h2>{{ $worstModule->module_label ?? ($worstLeak->module_label ?? 'Sin datos todavía') }}</h2>
                <p>
                    @if ($worstModule)
                        {{ number_format((float) $worstModule->accuracy, 1) }}% de precisión. Este módulo debe entrenarse primero.
                    @elseif ($worstLeak)
                        {{ number_format((float) $worstLeak->accuracy, 1) }}% de precisión en {{ $worstLeak->total }} spots.
                    @else
                        Responde algunos spots para que ApexCash detecte tu primer leak.
                    @endif
                </p>
            </article>

            <a href="{{ route('spot-training.index') }}" class="dashboard-card active">
                <span>Entrenamiento</span>
                <h2>Spot Training Preflop</h2>
                <p>Open Raise, BB vs BTN, BTN vs 3Bet, 3Bet vs Open, SB vs BTN y BB vs SB.</p>
                <strong>Entrar →</strong>
            </a>
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card table-card">
                <span>Leaks persistentes</span>
                <h2>Módulos débiles</h2>
                @forelse ($leaks as $leak)
                    @php
                        $leakRoute = in_array($leak->module, $postflopModules, true)
                            ? 'postflop-training.index'
                            : 'spot-training.index';
                    @endphp
                    <a class="metric-row" href="{{ route($leakRoute, ['module' => $leak->module]) }}">
                        <span>{{ $leak->module_label }}</span>
                        <strong>{{ number_format((float) $leak->accuracy, 1) }}% · {{ $leak->total }} spots</strong>
                    </a>
                @empty
                    <p>Aún no hay suficientes respuestas guardadas.</p>
                @endforelse
            </article>

            <article class="dashboard-card table-card">
                <span>Peores spots</span>
                <h2>Errores concretos</h2>

                @forelse ($worstSpots as $spot)
                    @php
                        $spotRoute = in_array($spot->module, $postflopModules, true)
                            ? 'postflop-training.index'
                            : 'spot-training.index';
                    @endphp
                    <a class="metric-row" href="{{ route($spotRoute, ['spot_id' => $spot->spot_id]) }}">
                        <span>
                            {{ $spot->hero_cards ?: 'Spot' }}
                            ·
                            {{ $spot->concept_label ?: ($spot->spot_title ?: $spot->spot_id) }}
                        </span>

                        <strong>
                            {{ number_format((float) $spot->accuracy, 1) }}%
                            ·
                            {{ $spot->wrong }} errores
                        </strong>
                    </a>
                @empty
                    <p>Necesitas responder más spots para detectar errores concretos.</p>
                @endforelse
            </article>

            
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card table-card">
                <span>Estadísticas por módulo</span>
                <h2>Resumen técnico</h2>

                @forelse ($moduleStats->take(8) as $stat)
                    @php
                        $acc = (float) $stat->accuracy;

                        if ($acc >= 85) {
                            $badgeClass = 'mastery-dominated';
                            $badgeLabel = '🔥 Dominado';
                        } elseif ($acc >= 60) {
                            $badgeClass = 'mastery-progress';
                            $badgeLabel = '⚡ En progreso';
                        } else {
                            $badgeClass = 'mastery-weak';
                            $badgeLabel = '🚨 Necesita trabajo';
                        }
                    @endphp

                    <div class="metric-row">
                        <div>
                            <span>{{ $stat->module_label }}</span>
                            <div class="mastery-badge {{ $badgeClass }}">
                                {{ $badgeLabel }}
                            </div>
                        </div>

                        <strong>
                            {{ number_format((float) $stat->accuracy, 1) }}%
                            ·
                            {{ $stat->total_spots }} spots
                        </strong>
                    </div>
                @empty
                    <p>Cuando empieces a entrenar aparecerá aquí la precisión por módulo.</p>
                @endforelse
            </article>

            <article class="dashboard-card table-card">
                <span>Concept leaks</span>
                <h2>Patrones débiles</h2>

                @forelse ($conceptLeaks as $concept)
                    @php
                        $conceptRoute = in_array($concept->module, $postflopModules, true)
                            ? 'postflop-training.index'
                            : 'spot-training.index';
                    @endphp
                    <a
                        class="metric-row"
                        href="{{ route($conceptRoute, ['concept' => $concept->concept]) }}"
                    >
                        <span>
                            {{ $concept->concept_label ?: $concept->concept }}

                            @if ($concept->family_label)
                                <small>{{ $concept->family_label }}</small>
                            @endif
                        </span>

                        <strong>
                            {{ number_format((float) $concept->accuracy, 1) }}%
                            ·
                            {{ $concept->wrong }} errores
                        </strong>
                    </a>
                @empty
                    <p>Necesitas más respuestas con taxonomía para detectar patrones.</p>
                @endforelse
            </article>

            <a href="{{ route('postflop-training.index') }}" class="dashboard-card table-card active">
                <span>Nuevo entrenamiento</span>
                <h2>Spot Training Postflop</h2>
                <p>
                    Entrena decisiones en flop: c-bets, check back, defensa vs c-bet,
                    check-raise, value bets, semi-bluffs y boards por textura.
                </p>
                <strong>Entrar →</strong>
            </a>

            @if($turnUnlocked)

                <a href="{{ route('postflop-turn.index') }}"
                class="dashboard-card table-card active">

                    <span>Nuevo entrenamiento</span>
                    <h2>Postflop Turn</h2>

                    <p>
                        Entrena second barrel, probe bets,
                        defensa vs barrel, value bets
                        y decisiones críticas de turn.
                    </p>

                    <strong>Entrar →</strong>

                </a>

                @else

                <article class="dashboard-card table-card">

                    <span>Bloqueado</span>
                    <h2>Postflop Turn</h2>

                    <p>
                        Necesitas alcanzar los requisitos
                        de XP y precisión en Flop.
                    </p>

                    <strong>🔒</strong>

                </article>

                @endif

            <article class="dashboard-card table-card">
                <span>Últimos resultados</span>
                    <h2>Actividad reciente</h2>
                    @forelse ($recentResults as $result)
                        <div class="metric-row">
                            <span>{{ $result->module_label }} · {{ $result->selected_action }}</span>
                            <strong class="grade-pill grade-{{ $result->grade }}">{{ strtoupper($result->grade) }}</strong>
                        </div>
                    @empty
                        <p>Todavía no has respondido spots.</p>
                    @endforelse
                </article>
        </section>
    </main>
</x-app-layout>
