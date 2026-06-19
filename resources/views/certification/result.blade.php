<x-app-layout>
    <link href="{{ asset('assets/css/certification-result.css') }}" rel="stylesheet">

    @php
        $globalScore = (float) ($attempt->global_score ?? 0);
        $totalCorrect = (int) ($attempt->total_correct ?? 0);
        $totalQuestions = (int) ($attempt->total_questions ?? 75);
        $durationSeconds = (int) ($attempt->duration_seconds ?? 0);
        $durationMinutes = max(0, (int) floor($durationSeconds / 60));
        $durationRemainder = max(0, $durationSeconds % 60);
        $durationLabel = $durationSeconds > 0
            ? $durationMinutes . ' min' . ($durationRemainder > 0 ? ' ' . $durationRemainder . ' s' : '')
            : '—';

        $isPassed = (bool) $attempt->passed;
        $isDistinction = (bool) $attempt->distinction;

        $resultIcon = $isDistinction ? '🏆' : ($isPassed ? '✅' : '❌');
        $resultTitle = $isDistinction ? 'APROBADO CON DISTINCIÓN' : ($isPassed ? 'CERTIFICATION APROBADA' : 'CERTIFICATION NO SUPERADA');
        $resultTone = $isDistinction ? 'distinction' : ($isPassed ? 'passed' : 'failed');

        $blockScores = [
            'Preflop' => (float) ($attempt->preflop_score ?? 0),
            'Flop' => (float) ($attempt->flop_score ?? 0),
            'Turn' => (float) ($attempt->turn_score ?? 0),
            'River' => (float) ($attempt->river_score ?? 0),
            'Mastery' => (float) ($attempt->mastery_score ?? 0),
        ];
    @endphp

    <main class="cert-result-page">
        <div class="cert-result-shell">
            @if(session('error'))
                <div class="cert-result-alert {{ str_contains(session('error'), 'Tiempo agotado') ? 'is-warning' : 'is-error' }}">
                    {{ session('error') }}
                </div>
            @endif

            <section class="cert-result-hero cert-result-hero--{{ $resultTone }}">
                <div class="cert-result-badge">{{ $resultIcon }}</div>

                <p class="cert-result-kicker">Resultado Certification ApexCash</p>
                <h1>{{ $resultTitle }}</h1>

                @if($isPassed)
                    <p class="cert-result-message">
                        Has superado satisfactoriamente la Certification ApexCash.
                    </p>

                    @if($attempt->certificate_code)
                        <div class="cert-result-code">
                            Código certificado: <strong>{{ $attempt->certificate_code }}</strong>
                        </div>
                    @endif
                @else
                    <p class="cert-result-message">
                        No has alcanzado los requisitos mínimos de aprobación.
                    </p>

                    @if($attempt->next_attempt_at)
                        <div class="cert-result-retry">
                            Podrás volver a intentarlo el<br>
                            <strong>{{ $attempt->next_attempt_at->format('d/m/Y H:i') }}</strong>
                        </div>
                    @endif
                @endif
            </section>

            <section class="cert-result-summary" aria-label="Resumen del examen">
                <article class="cert-result-card">
                    <span>Resultado global</span>
                    <strong>{{ number_format($globalScore, 1) }}%</strong>
                    <small>Mínimo requerido: 75%</small>
                </article>

                <article class="cert-result-card">
                    <span>Aciertos</span>
                    <strong>{{ $totalCorrect }} / {{ $totalQuestions }}</strong>
                    <small>Preguntas totales</small>
                </article>

                <article class="cert-result-card">
                    <span>Duración</span>
                    <strong>{{ $durationLabel }}</strong>
                    <small>Tiempo máximo: 60 min</small>
                </article>
            </section>

            <section class="cert-result-blocks">
                <div class="cert-result-section-head">
                    <p>Bloques evaluados</p>
                    <h2>Resultado por bloque</h2>
                    <span>Para aprobar necesitas mínimo 60% en cada bloque.</span>
                </div>

                <div class="cert-result-block-grid">
                    @foreach($blockScores as $label => $score)
                        @php $blockPassed = $score >= 60; @endphp
                        <article class="cert-result-block {{ $blockPassed ? 'is-ok' : 'is-bad' }}">
                            <div>
                                <span>{{ $label }}</span>
                                <strong>{{ number_format($score, 1) }}%</strong>
                            </div>
                            <em>{{ $blockPassed ? '✅' : '❌' }}</em>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="cert-result-next cert-result-next--{{ $resultTone }}">
                @if($isPassed)
                    <h2>¿Qué sigue ahora?</h2>
                    <p>
                        La certificación marca el final de la formación. No el final del aprendizaje.
                        Continúa entrenando para mantener tu nivel, detectar nuevos leaks y mejorar tu precisión.
                    </p>
                @else
                    <h2>Tu referencia actual</h2>
                    <p>
                        Este resultado no es el final del proceso. Usa los bloques débiles como guía,
                        vuelve a entrenar y presenta la Certification cuando el sistema desbloquee tu próximo intento.
                    </p>
                @endif
            </section>

            <div class="cert-result-actions">
                <a href="{{ route('certification.index') }}" class="cert-result-btn cert-result-btn--ghost">
                    Volver a Certification
                </a>

                <a href="{{ route('dashboard') }}" class="cert-result-btn cert-result-btn--primary">
                    Ir al Dashboard
                </a>
            </div>
        </div>
    </main>
</x-app-layout>
