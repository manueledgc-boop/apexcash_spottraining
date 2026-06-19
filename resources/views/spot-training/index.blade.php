<x-app-layout>
    <link href="{{ asset('assets/css/spot-training.css') }}" rel="stylesheet">

    <script>
        window.ApexSpotTraining = {
            initialSpot: @json($initialSpot),
            initialSummary: @json($summary),
            initialLeaks: @json($leaks),
            initialModule: @json($initialModule ?? null),
            initialMode: @json($initialMode ?? 'normal'),
            lifetime: @json($lifetime),
            nextUrl: @json(route('spot-training.next')),
            answerUrl: @json(route('spot-training.answer')),
            csrf: @json(csrf_token()),
            i18n: @json(__('preflop')),
        };
    </script>

    <main class="spot-page">
        <section class="spot-header">
            <div>
                <span class="spot-kicker">{{ __('preflop.kicker') }}</span>
                <h1>{{ __('preflop.title') }}</h1>
                <p>{{ __('preflop.subtitle') }}</p>
            </div>

            <form method="POST" action="{{ route('spot-training.reset') }}">
                @csrf
                <button type="submit" class="ghost-btn">{{ __('preflop.reset_practice') }}</button>
            </form>
        </section>

        <section class="spot-layout">
            <div class="spot-table-card">
                <div class="spot-table" id="spotTable">
                    <div class="table-felt">
                        <div class="board-zone">
                            <span>{{ __('preflop.board_label') }}</span>
                            <strong id="spotPot">{{ __('preflop.pot_placeholder') }}</strong>
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
                <br>

                <div class="table-actions-area">
                    <div class="decision-buttons" id="decisionButtons"></div>

                    <button type="button" class="next-btn" id="nextSpotBtn">
                        {{ __('preflop.next_spot') }}
                    </button>

                    <div class="table-insights-area">
                        <br>
                        <div class="insight-box low-stakes" id="lowStakesInsightBox" hidden></div>
                    </div>
                </div>
            </div>

            <aside class="spot-panel">
                <div class="spot-box">
                    <span class="spot-module" id="spotModule">--</span>
                    <h2 id="spotTitle">{{ __('preflop.loading_spot') }}</h2>
                    <p class="spot-meta" id="spotMeta">--</p>

                    <div class="module-filter" id="moduleFilter">
                        <button type="button" data-module="">{{ __('preflop.modules.all') }}</button>
                        <button type="button" data-module="open_raise">{{ __('preflop.modules.open_raise') }}</button>
                        <button type="button" data-module="bb_vs_btn">{{ __('preflop.modules.bb_vs_btn') }}</button>
                        <button type="button" data-module="btn_vs_3bet">{{ __('preflop.modules.btn_vs_3bet') }}</button>
                        <button type="button" data-module="threebet_vs_open">{{ __('preflop.modules.threebet_vs_open') }}</button>
                        <button type="button" data-module="sb_vs_btn">{{ __('preflop.modules.sb_vs_btn') }}</button>
                        <button type="button" data-module="bb_vs_sb">{{ __('preflop.modules.bb_vs_sb') }}</button>
                    </div>
                </div>

                <div class="spot-box actions-box">
                    <h3>{{ __('preflop.previous_action') }}</h3>
                    <ol id="spotActions"></ol>
                </div>

                <div class="spot-box decision-box" id="decisionResultBox" hidden>
                    <div class="feedback" id="feedbackBox" hidden></div>
                    <div class="grade-box" id="gradeBox" hidden></div>
                    <div class="frequency-box" id="frequencyBox" hidden></div>
                    <div class="ev-box" id="evBox" hidden></div>
                </div>

                <div class="spot-box summary-box">
                    <h3>{{ __('preflop.current_session') }}</h3>

                    <div class="summary-grid">
                        <div><span>{{ __('preflop.summary.total') }}</span><strong id="summary{{ __('preflop.summary.total') }}">0</strong></div>
                        <div><span>{{ __('preflop.summary.correct') }}</span><strong id="summaryCorrect">0</strong></div>
                        <div><span>{{ __('preflop.summary.wrong') }}</span><strong id="summaryWrong">0</strong></div>
                        <div><span>{{ __('preflop.summary.accuracy') }}</span><strong id="summaryAccuracy">0%</strong></div>
                    </div>

                    <div class="leaks-box">
                        <h4>{{ __('preflop.preflop_summary') }}</h4>
                        <div id="leaksList"></div>

                    </div>
                </div>
            </aside>
        </section>
    </main>

    <script src="{{ asset('js/spot-training.js') }}"></script>
</x-app-layout>