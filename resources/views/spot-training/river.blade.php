<x-app-layout>
    <link href="{{ asset('assets/css/postflop-training.css') }}" rel="stylesheet">

    <script>
        window.ApexPostflopRiverTraining = {
            initialSpot: @json($initialSpot),
            initialSummary: @json($summary),
            initialLeaks: @json($leaks),
            initialModule: @json($initialModule ?? null),
            initialMode: @json($initialMode ?? 'normal'),
            lifetime: @json($lifetime),
            nextUrl: @json(route('postflop-river.next')),
            answerUrl: @json(route('postflop-river.answer')),
            csrf: @json(csrf_token()),
        };
    </script>

    <main class="postflop-page">
        <section class="postflop-header">
            <div>
                <span class="postflop-kicker">APEXCASH POSTFLOP RIVER V1</span>
                <h1>Entrenador postflop · River</h1>
                <p>Practica decisiones de river: value claro, thin value, bluffs, bluff catch, overbets y control de showdown.</p>
            </div>

            <div class="street-tabs">
                <a href="{{ route('spot-training.index') }}">Preflop</a>
                <a href="{{ route('postflop-training.index') }}">Flop</a>
                <a href="{{ route('postflop-turn.index') }}">Turn</a>
                <a href="{{ route('postflop-river.index') }}" class="is-active">River</a>
            </div>

            <form method="POST" action="{{ route('postflop-river.reset') }}">
                @csrf
                <button type="submit" class="ghost-btn">Reiniciar river</button>
            </form>
        </section>

        <section class="postflop-layout">
            <div class="postflop-table-card">
                <div class="postflop-table" id="postflopTable">
                    <div class="table-felt">
                        <div class="board-zone">
                            <span>BOARD · RIVER</span>
                            <div class="board-cards" id="boardCards"></div>
                            <strong id="spotPot">Pot: -- BB</strong>
                            <small id="spotSpr">SPR: --</small>
                        </div>

                        <div id="heroPosition" hidden></div>
                        <div id="villainPosition" hidden></div>

                        <div class="seat seat-utg" data-position="UTG"></div>
                        <div class="seat seat-hj" data-position="HJ"></div>
                        <div class="seat seat-co" data-position="CO"></div>
                        <div class="seat seat-btn" data-position="BTN"></div>
                        <div class="seat seat-sb" data-position="SB"></div>
                        <div class="seat seat-bb" data-position="BB"></div>
                    </div>
                </div>

                <div class="hero-cards" id="heroCards"></div>

                <div class="table-actions-area">
                    <div class="decision-buttons" id="decisionButtons"></div>

                    <button type="button" class="next-btn" id="nextSpotBtn">
                        Siguiente spot →
                    </button>

                    <div class="table-insights-area">
                        <div class="insight-box gto" id="gtoInsightBox" hidden></div>
                        <div class="insight-box low-stakes" id="lowStakesInsightBox" hidden></div>
                    </div>
                </div>
            </div>

            <aside class="postflop-panel">
                <div class="postflop-box">
                    <span class="postflop-module" id="spotModule">--</span>
                    <h2 id="spotTitle">Cargando spot...</h2>
                    <p class="spot-meta" id="spotMeta">--</p>

                    <div class="module-filter" id="moduleFilter">
                        <button type="button" data-module="">Todos</button>
                        <button type="button" data-module="river_value_bet">River Value Bet</button>
                        <button type="button" data-module="river_bluff_catch">River Bluff Catch</button>
                        <button type="button" data-module="river_bluff">River Bluff</button>
                        <button type="button" data-module="river_thin_value">River Thin Value</button>
                        <button type="button" data-module="river_overbet">River Overbet</button>
                    </div>
                </div>

                <div class="postflop-box actions-box">
                    <h3>Acción previa</h3>
                    <ol id="spotActions"></ol>
                </div>

                <div class="postflop-box decision-box" id="decisionResultBox" hidden>
                    <div class="feedback" id="feedbackBox" hidden></div>
                    <div class="grade-box" id="gradeBox" hidden></div>
                    <div class="frequency-box" id="frequencyBox" hidden></div>
                    <div class="ev-box" id="evBox" hidden></div>
                </div>

                <div class="postflop-box texture-box" id="textureBox" hidden>
                    <h3>Análisis del spot</h3>

                    <div class="metric-row">
                        <span>Board</span>
                        <strong id="boardTexture">--</strong>
                    </div>

                    <div class="metric-row">
                        <span>Ventaja rango</span>
                        <strong id="rangeAdvantage">--</strong>
                    </div>

                    <div class="metric-row">
                        <span>Ventaja nuts</span>
                        <strong id="nutAdvantage">--</strong>
                    </div>

                    <div class="metric-row">
                        <span>Stack efectivo</span>
                        <strong id="effectiveStack">--</strong>
                    </div>
                </div>

                <div class="postflop-box summary-box">
                    <h3>Sesión river</h3>

                    <div class="summary-grid">
                        <div><span>Total</span><strong id="summaryTotal">0</strong></div>
                        <div><span>Aciertos</span><strong id="summaryCorrect">0</strong></div>
                        <div><span>Fallos</span><strong id="summaryWrong">0</strong></div>
                        <div><span>Precisión</span><strong id="summaryAccuracy">0%</strong></div>
                    </div>

                    <div class="leaks-box">
                        <h4>Leaks river</h4>
                        <div id="leaksList"></div>
                    </div>
                </div>
            </aside>
        </section>
    </main>

    <script src="{{ asset('js/postflop-river-training.js') }}"></script>
</x-app-layout>
