<x-app-layout>
    <link href="{{ asset('assets/css/spot-training.css') }}" rel="stylesheet">
    <script>
        window.ApexSpotTraining = {
            initialSpot: @json($initialSpot),
            initialSummary: @json($summary),
            nextUrl: @json(route('spot-training.next')),
            answerUrl: @json(route('spot-training.answer')),
            csrf: @json(csrf_token()),
        };
    </script>

    <main class="spot-page">
        <section class="spot-header">
            <div>
                <span class="spot-kicker">APEXCASH SPOT TRAINING V1</span>
                <h1>Entrenador de decisiones preflop</h1>
                <p>Practica spots concretos, recibe feedback inmediato y repite hasta que la decisión correcta sea automática.</p>
            </div>
            <form method="POST" action="{{ route('spot-training.reset') }}">
                @csrf
                <button type="submit" class="ghost-btn">Reiniciar práctica</button>
            </form>
        </section>

        <section class="spot-layout">
            <div class="spot-table-card">
                <div class="spot-table" id="spotTable">
                    <div class="table-felt">
                        <div class="board-zone">
                            <span>SPOT PREFLOP</span>
                            <strong id="spotPot">Pot: -- BB</strong>
                        </div>

                        <div class="seat seat-utg" data-position="UTG"></div>
                        <div class="seat seat-hj" data-position="HJ"></div>
                        <div class="seat seat-co" data-position="CO"></div>
                        <div class="seat seat-btn" data-position="BTN"></div>
                        <div class="seat seat-sb" data-position="SB"></div>
                        <div class="seat seat-bb" data-position="BB"></div>
                    </div>
                </div>

                <div class="hero-cards" id="heroCards"></div>
            </div>

            <aside class="spot-panel">
                <div class="spot-box">
                    <span class="spot-module" id="spotModule">--</span>
                    <h2 id="spotTitle">Cargando spot...</h2>
                    <p class="spot-meta" id="spotMeta">--</p>
                </div>

                <div class="spot-box actions-box">
                    <h3>Acción previa</h3>
                    <ol id="spotActions"></ol>
                </div>

                <div class="spot-box decision-box">
                    <h3>Tu decisión</h3>
                    <div class="decision-buttons" id="decisionButtons"></div>
                    <div class="feedback" id="feedbackBox" hidden></div>
                    <div class="grade-box" id="gradeBox" hidden></div>
                    <div class="frequency-box" id="frequencyBox" hidden></div>
                    <div class="ev-box" id="evBox" hidden></div>
                    <button type="button" class="next-btn" id="nextSpotBtn">Siguiente spot →</button>
                </div>

                <div class="spot-box summary-box">
                    <h3>Sesión actual</h3>
                    <div class="summary-grid">
                        <div><span>Total</span><strong id="summaryTotal">0</strong></div>
                        <div><span>Aciertos</span><strong id="summaryCorrect">0</strong></div>
                        <div><span>Fallos</span><strong id="summaryWrong">0</strong></div>
                        <div><span>Precisión</span><strong id="summaryAccuracy">0%</strong></div>
                    </div>

                    <div class="leaks-box">
                        <h4>Tus leaks actuales</h4>
                        <div id="leaksList"></div>

                        <button type="button" id="practiceLeakBtn" class="ghost-btn">
                            Practicar peor leak
                        </button>
                    </div>
                    </div>
                </div>
            </aside>
        </section>
    </main>

    <script src="{{ asset('js/spot-training.js') }}"></script>
</x-app-layout>
