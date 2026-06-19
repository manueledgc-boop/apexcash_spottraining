<x-app-layout>
    <link href="{{ asset('assets/css/postflop-training.css') }}" rel="stylesheet">

    @php
        $postflopI18n = [
            'default_title' => __('postflop.default_title'),
            'default_difficulty' => __('postflop.default_difficulty'),
            'confidence' => __('postflop.confidence'),
            'pot' => __('postflop.pot'),
            'spr' => __('postflop.spr'),
            'effective_stack' => __('postflop.effective_stack'),
            'no_leaks' => __('postflop.no_leaks'),
            'gto_simplified' => __('postflop.gto_simplified'),
            'low_stakes' => __('postflop.low_stakes'),
            'result' => __('postflop.result'),
            'you_chose' => __('postflop.you_chose'),
            'best_action' => __('postflop.best_action'),
            'grade' => __('postflop.grade'),
            'suggested_frequency' => __('postflop.suggested_frequency'),
            'relative_ev' => __('postflop.relative_ev'),
            'answer_error' => __('postflop.answer_error'),
            'unexpected_answer_error' => __('postflop.unexpected_answer_error'),
            'next_error' => __('postflop.next_error'),
            'unexpected_next_error' => __('postflop.unexpected_next_error'),
            'actions' => [
                'CHECK' => __('postflop.actions.check'),
                'BET_33' => __('postflop.actions.bet_33'),
                'BET_66' => __('postflop.actions.bet_66'),
                'FOLD' => __('postflop.actions.fold'),
                'CALL' => __('postflop.actions.call'),
                'RAISE' => __('postflop.actions.raise'),
            ],
        ];
    @endphp

    <script>
        window.ApexPostflopTraining = {
            initialSpot: @json($initialSpot),
            initialSummary: @json($summary),
            initialLeaks: @json($leaks),
            initialModule: @json($initialModule ?? null),
            initialMode: @json($initialMode ?? 'normal'),
            lifetime: @json($lifetime),
            nextUrl: @json(route('postflop-training.next')),
            answerUrl: @json(route('postflop-training.answer')),
            csrf: @json(csrf_token()),
            i18n: @json($postflopI18n),
        };
    </script>

    <main class="postflop-page">
        <section class="postflop-header">
            <div>
                <span class="postflop-kicker">{{ __('postflop.kicker') }}</span>
                <h1>{{ __('postflop.title') }}</h1>
                <p>{{ __('postflop.subtitle') }}</p>
            </div>

            <div class="street-tabs">
                <a href="{{ route('spot-training.index') }}">{{ __('postflop.tabs.preflop') }}</a>
                <a href="{{ route('postflop-training.index') }}" class="is-active">{{ __('postflop.tabs.postflop') }}</a>
            </div>

            <form method="POST" action="{{ route('postflop-training.reset') }}">
                @csrf
                <button type="submit" class="ghost-btn">{{ __('postflop.reset') }}</button>
            </form>
        </section>

        <section class="postflop-layout">
            <div class="postflop-table-card">
                <div class="postflop-table" id="postflopTable">
                    <div class="table-felt">
                        <div class="board-zone">
                            <span>BOARD</span>
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
                
                <div class="hero-cards" id="heroCards" ></div>

                

                <div class="table-actions-area">
                    <div class="decision-buttons" id="decisionButtons"></div>

                    <button type="button" class="next-btn" id="nextSpotBtn">
                        {{ __('postflop.next_spot') }}
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
                    <h2 id="spotTitle">{{ __('postflop.loading_spot') }}</h2>
                    <p class="spot-meta" id="spotMeta">--</p>

                    <div class="module-filter" id="moduleFilter">
                        <button type="button" data-module="">{{ __('postflop.filters.all') }}</button>
                        <button type="button" data-module="cbet_ip">C-Bet IP</button>
                        <button type="button" data-module="check_back_ip">Check Back</button>
                        <button type="button" data-module="defense_vs_cbet">Defensa vs C-Bet</button>
                        <button type="button" data-module="check_raise">Check-Raise</button>
                        <button type="button" data-module="value_bet">Value Bet</button>
                        <button type="button" data-module="semi_bluff">Semi-Bluff</button>
                        <button type="button" data-module="overbet">Overbet</button>
                        <button type="button" data-module="donk_bet">Donk Bet</button>
                        <button type="button" data-module="float">Float</button>
                    </div>
                </div>

                

                <div class="postflop-box actions-box">
                    <h3>{{ __('postflop.previous_action') }}</h3>
                    <ol id="spotActions"></ol>
                </div>

                <div class="postflop-box decision-box" id="decisionResultBox" hidden>
                    <div class="feedback" id="feedbackBox" hidden></div>
                    <div class="grade-box" id="gradeBox" hidden></div>
                    <div class="frequency-box" id="frequencyBox" hidden></div>
                    <div class="ev-box" id="evBox" hidden></div>
                </div>

                <div class="postflop-box texture-box" id="textureBox" hidden>
                    <h3>{{ __('postflop.spot_analysis') }}</h3>

                    <div class="metric-row">
                        <span>{{ __('postflop.board') }}</span>
                        <strong id="boardTexture">--</strong>
                    </div>

                    <div class="metric-row">
                        <span>{{ __('postflop.range_advantage') }}</span>
                        <strong id="rangeAdvantage">--</strong>
                    </div>

                    <div class="metric-row">
                        <span>{{ __('postflop.nut_advantage') }}</span>
                        <strong id="nutAdvantage">--</strong>
                    </div>

                </div>

                <div class="postflop-box summary-box">
                    <h3>{{ __('postflop.session') }}</h3>

                    <div class="summary-grid">
                        <div><span>{{ __('postflop.total') }}</span><strong id="summaryTotal">0</strong></div>
                        <div><span>{{ __('postflop.correct') }}</span><strong id="summaryCorrect">0</strong></div>
                        <div><span>{{ __('postflop.wrong') }}</span><strong id="summaryWrong">0</strong></div>
                        <div><span>{{ __('postflop.accuracy') }}</span><strong id="summaryAccuracy">0%</strong></div>
                    </div>

                    <div class="leaks-box">
                        <h4>{{ __('postflop.flop_summary') }}</h4>
                        <div id="leaksList"></div>
                    </div>
                </div>
            </aside>
        </section>
    </main>

    <script src="{{ asset('js/postflop-training.js') }}"></script>
</x-app-layout>
