<x-app-layout>
    <link href="{{ asset('assets/css/postflop-training.css') }}" rel="stylesheet">

    <script>
        window.ApexMasteryTraining = {
            initialSpot: @json($initialSpot),
            initialSummary: @json($summary),
            initialLeaks: @json($leaks),
            initialModule: @json($initialModule ?? null),
            initialMode: @json($initialMode ?? 'normal'),
            lifetime: @json($lifetime),
            nextUrl: @json(route('mastery-training.next')),
            answerUrl: @json(route('mastery-training.answer')),
            csrf: @json(csrf_token()),
        };
    </script>

    <main class="postflop-page">
        <section class="postflop-header">
            <div>
                <span class="postflop-kicker">APEXCASH MASTERY TRAINING</span>
                <h1>Advanced Training · Mastery</h1>
                <p>Entrena situaciones avanzadas que combinan decisiones preflop, flop, turn, river, botes 3Bet, 
                    4Bet, multiway, short stack y torneos.</p>
            </div>

            <div class="street-tabs">
                <a href="{{ route('spot-training.index') }}">Preflop</a>
                <a href="{{ route('postflop-training.index') }}">Flop</a>
                <a href="{{ route('postflop-turn.index') }}">Turn</a>
                <a href="{{ route('postflop-river.index') }}">River</a>
                <a href="{{ route('mastery-training.index') }}" class="is-active">Mastery</a>
            </div>

            <form method="POST" action="{{ route('mastery-training.reset') }}">
                @csrf
                <button type="submit" class="ghost-btn">Reiniciar Mastery</button>
            </form>
        </section>

        <section class="postflop-layout">
            <div class="postflop-table-card">
                <div class="postflop-table" id="postflopTable">
                    <div class="table-felt">
                        <div class="board-zone">
                            <span id="boardStreetLabel">BOARD · --</span>
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
                        <button type="button" data-module="three_bet_pots">3Bet Pots</button>
                        <button type="button" data-module="four_bet_pots">4Bet Pots</button>
                        <button type="button" data-module="blind_vs_blind_advanced">Blind vs Blind</button>
                        <button type="button" data-module="multiway">Multiway</button>
                        <button type="button" data-module="short_stack_lab">Short Stack Lab</button>
                        <button type="button" data-module="tournament_lab">Tournament Lab</button>
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
                    <h3>Sesión mastery</h3>

                    <div class="summary-grid">
                        <div><span>Total</span><strong id="summaryTotal">0</strong></div>
                        <div><span>Aciertos</span><strong id="summaryCorrect">0</strong></div>
                        <div><span>Fallos</span><strong id="summaryWrong">0</strong></div>
                        <div><span>Precisión</span><strong id="summaryAccuracy">0%</strong></div>
                    </div>

                    <div class="leaks-box">
                        <h4>Resumen Mastery</h4>
                        <div id="leaksList"></div>
                    </div>
                </div>
            </aside>
        </section>
    </main>

    <script src="{{ asset('js/mastery-training.js') }}"></script>
</x-app-layout>
