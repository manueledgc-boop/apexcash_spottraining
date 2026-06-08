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
    @endphp

    <main class="dashboard-page">
        <section class="dashboard-hero">
            <div>
                <span class="dashboard-badge">APEXCASH TRAINING DASHBOARD</span>
                <h1>Hola, {{ auth()->user()->name }}</h1>
                <p>Tu progreso ya está guardado: XP, precisión, módulos fuertes, módulos débiles, últimos resultados y leaks reales.</p>
            </div>

            <div class="dashboard-actions">
                <a href="{{ route('spot-training.index') }}" class="dashboard-main-btn">Sesión rápida</a>
                @if ($worstLeak)
                    <a href="{{ route('spot-training.index', ['module' => $worstLeak->module]) }}" class="dashboard-secondary-btn">Practicar peor leak</a>
                @endif
            </div>
        </section>

        <section class="progress-panel">
            <div>
                <span>Nivel {{ $level }}</span>
                <strong>{{ $xp }} XP</strong>
                <p>{{ $levelProgress }}/250 XP para el siguiente nivel</p>
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
                    <a class="metric-row" href="{{ route('spot-training.index', ['module' => $leak->module]) }}">
                        <span>{{ $leak->module_label }}</span>
                        <strong>{{ number_format((float) $leak->accuracy, 1) }}% · {{ $leak->total }} spots</strong>
                    </a>
                @empty
                    <p>Aún no hay suficientes respuestas guardadas.</p>
                @endforelse
            </article>

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

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card table-card">
                <span>Estadísticas por módulo</span>
                <h2>Resumen técnico</h2>
                @forelse ($moduleStats->take(8) as $stat)
                    <div class="metric-row">
                        <span>{{ $stat->module_label }}</span>
                        <strong>{{ number_format((float) $stat->accuracy, 1) }}% · {{ $stat->total_spots }} spots</strong>
                    </div>
                @empty
                    <p>Cuando empieces a entrenar aparecerá aquí la precisión por módulo.</p>
                @endforelse
            </article>

            <article class="dashboard-card table-card locked">
                <span>Próxima fase</span>
                <h2>Postflop Trainer</h2>
                <p>Después de estabilizar el dashboard, el siguiente salto será BB vs BTN Flop: c-bets, check-call, check-raise, folds y boards por textura.</p>
            </article>
        </section>
    </main>
</x-app-layout>
