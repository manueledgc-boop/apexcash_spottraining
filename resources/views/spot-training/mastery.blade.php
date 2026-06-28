<x-app-layout>
    <link href="{{ asset('assets/css/postflop-training.css') }}" rel="stylesheet">

    @php
        $masteryI18n = [
            'board' => __('mastery.board'),
            'no_board_preflop' => __('mastery.no_board_preflop'),
            'preflop_no_board' => __('mastery.preflop_no_board'),
            'spot_mastery' => __('mastery.spot_mastery'),
            'confidence' => __('mastery.confidence'),
            'pot' => __('mastery.pot'),
            'spr' => __('mastery.spr'),
            'gto_simplified' => __('mastery.gto_simplified'),
            'low_stakes' => __('mastery.low_stakes'),
            'no_leaks_yet' => __('mastery.no_leaks_yet'),
            'cannot_evaluate' => __('mastery.cannot_evaluate'),
            'unexpected_evaluating' => __('mastery.unexpected_evaluating'),
            'result' => __('mastery.result'),
            'you_chose' => __('mastery.you_chose'),
            'best_action' => __('mastery.best_action'),
            'grade' => __('mastery.grade'),
            'suggested_frequency' => __('mastery.suggested_frequency'),
            'relative_ev' => __('mastery.relative_ev'),
            'xp' => __('mastery.xp'),
            'cannot_load_next' => __('mastery.cannot_load_next'),
            'loading_error' => __('mastery.loading_error'),
            'action_check' => __('mastery.actions.check'),
            'action_bet_25' => __('mastery.actions.bet_25'),
            'action_bet_33' => __('mastery.actions.bet_33'),
            'action_bet_50' => __('mastery.actions.bet_50'),
            'action_bet_66' => __('mastery.actions.bet_66'),
            'action_bet_75' => __('mastery.actions.bet_75'),
            'action_bet_pot' => __('mastery.actions.bet_pot'),
            'action_overbet_125' => __('mastery.actions.overbet_125'),
            'action_overbet_150' => __('mastery.actions.overbet_150'),
            'action_fold' => __('mastery.actions.fold'),
            'action_call' => __('mastery.actions.call'),
            'action_raise' => __('mastery.actions.raise'),
            'action_raise_2_5x' => __('mastery.actions.raise_2_5x'),
            'action_raise_3x' => __('mastery.actions.raise_3x'),
            'action_all_in' => __('mastery.actions.all_in'),
        ];
    @endphp

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
            i18n: @json($masteryI18n),
           
        };
    </script>

    <main class="postflop-page">
        <section class="postflop-header">
            <div>
                <span class="postflop-kicker">{{ __('mastery.kicker') }}</span>
                <h1>{{ __('mastery.title') }}</h1>
                <p>{{ __('mastery.subtitle') }}</p>
            </div>

            <div class="street-tabs">
                <a href="{{ route('spot-training.index') }}">{{ __('mastery.tabs.preflop') }}</a>
                <a href="{{ route('postflop-training.index') }}">{{ __('mastery.tabs.flop') }}</a>
                <a href="{{ route('postflop-turn.index') }}">{{ __('mastery.tabs.turn') }}</a>
                <a href="{{ route('postflop-river.index') }}">{{ __('mastery.tabs.river') }}</a>
                <a href="{{ route('mastery-training.index') }}" class="is-active">{{ __('mastery.tabs.mastery') }}</a>
            </div>

            <form method="POST" action="{{ route('mastery-training.reset') }}">
                @csrf
                <button type="submit" class="ghost-btn">{{ __('mastery.reset') }}</button>
            </form>
        </section>

        <section class="postflop-layout">
            <div class="postflop-table-card">
                <div class="postflop-table" id="postflopTable">
                    <div class="table-felt">
                        <div class="board-zone">
                            <span id="boardStreetLabel">{{ __('mastery.board_placeholder') }}</span>
                            <div class="board-cards" id="boardCards"></div>
                            <strong id="spotPot">{{ __('mastery.pot_placeholder') }}</strong>
                            <small id="spotSpr">{{ __('mastery.spr_placeholder') }}</small>
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
                        {{ __('mastery.next_spot') }}
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
                    <h2 id="spotTitle">{{ __('mastery.loading_spot') }}</h2>
                    <p class="spot-meta" id="spotMeta">--</p>

                    <div class="module-filter" id="moduleFilter">
                        <button type="button" data-module="">{{ __('mastery.filters.all') }}</button>
                        <button type="button" data-module="three_bet_pots">{{ __('mastery.filters.three_bet_pots') }}</button>
                        <button type="button" data-module="four_bet_pots">{{ __('mastery.filters.four_bet_pots') }}</button>
                        <button type="button" data-module="blind_vs_blind_advanced">{{ __('mastery.filters.blind_vs_blind') }}</button>
                        <button type="button" data-module="multiway">{{ __('mastery.filters.multiway') }}</button>
                        <button type="button" data-module="short_stack_lab">{{ __('mastery.filters.short_stack_lab') }}</button>
                        <button type="button" data-module="tournament_lab">{{ __('mastery.filters.tournament_lab') }}</button>
                    </div>
                </div>

                <div class="postflop-box actions-box">
                    <h3>{{ __('mastery.previous_action') }}</h3>
                    <ol id="spotActions"></ol>
                </div>

                <div class="postflop-box decision-box" id="decisionResultBox" hidden>
                    <div class="feedback" id="feedbackBox" hidden></div>
                    <div class="grade-box" id="gradeBox" hidden></div>
                    <div class="frequency-box" id="frequencyBox" hidden></div>
                    <div class="ev-box" id="evBox" hidden></div>
                </div>

                <div class="postflop-box texture-box" id="textureBox" hidden>
                    <h3>{{ __('mastery.spot_analysis') }}</h3>

                    <div class="metric-row">
                        <span>{{ __('mastery.board_label') }}</span>
                        <strong id="boardTexture">--</strong>
                    </div>

                    <div class="metric-row">
                        <span>{{ __('mastery.range_advantage') }}</span>
                        <strong id="rangeAdvantage">--</strong>
                    </div>

                    <div class="metric-row">
                        <span>{{ __('mastery.nut_advantage') }}</span>
                        <strong id="nutAdvantage">--</strong>
                    </div>

                    <div class="metric-row">
                        <span>{{ __('mastery.effective_stack') }}</span>
                        <strong id="effectiveStack">--</strong>
                    </div>
                </div>

                <div class="postflop-box summary-box">
                    <h3>{{ __('mastery.session_title') }}</h3>

                    <div class="summary-grid">
                        <div><span>{{ __('mastery.total') }}</span><strong id="summaryTotal">0</strong></div>
                        <div><span>{{ __('mastery.correct') }}</span><strong id="summaryCorrect">0</strong></div>
                        <div><span>{{ __('mastery.wrong') }}</span><strong id="summaryWrong">0</strong></div>
                        <div><span>{{ __('mastery.accuracy') }}</span><strong id="summaryAccuracy">0%</strong></div>
                    </div>

                    <div class="leaks-box">
                        <h4>{{ __('mastery.mastery_summary') }}</h4>
                        <div id="leaksList"></div>
                    </div>
                </div>
            </aside>
        </section>
    </main>

    <script src="{{ asset('js/mastery-training.js') }}"></script>
</x-app-layout>
