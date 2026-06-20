<x-app-layout>
    <link href="{{ asset('assets/css/hand-lab.css') }}" rel="stylesheet">

    <main class="hand-lab-page">
        <section class="hand-lab-header">
            <div>
                <span class="hand-lab-kicker">{{ __('hand_lab.kicker') }}</span>
                <h1>{{ __('hand_lab.title') }}</h1>
                <p>{{ __('hand_lab.subtitle') }}</p>
            </div>

            <div class="hand-lab-header-actions">
                @if(($reviewCount ?? 0) > 0)
                    <a href="{{ route('hand-lab.reviews.index') }}" class="ghost-link hand-review-link">
                        {{ __('hand_lab.my_hand_reviews') }} ({{ $reviewCount }})
                    </a>
                @else
                    <span class="ghost-link hand-review-link is-disabled" aria-disabled="true">
                        {{ __('hand_lab.my_hand_reviews') }} (0)
                    </span>
                @endif
            </div>
        </section>

        <section class="hand-lab-layout" id="handLabBuilderStage">
            <div class="hand-lab-table-card">
                <div class="hand-lab-table" id="handLabTable">
                    <div class="table-felt">
                        <div class="lab-board-zone">
                            <span>{{ __('hand_lab.board') }}</span>
                            <div class="lab-board-cards" id="labBoardCards">
                                <div class="empty-card">--</div><div class="empty-card">--</div><div class="empty-card">--</div><div class="empty-card">--</div><div class="empty-card">--</div>
                            </div>
                            <strong id="labPot">{{ __('hand_lab.pot') }}: 1.5 BB</strong>
                            <small id="labStreetLabel">{{ __('hand_lab.street') }}: {{ __('hand_lab.preflop') }}</small>
                        </div>

                        <button type="button" class="lab-seat seat-utg" data-position="UTG"><span>UTG</span><strong>{{ __('hand_lab.empty') }}</strong><small>100 BB</small></button>
                        <button type="button" class="lab-seat seat-hj" data-position="HJ"><span>HJ</span><strong>{{ __('hand_lab.empty') }}</strong><small>100 BB</small></button>
                        <button type="button" class="lab-seat seat-co" data-position="CO"><span>CO</span><strong>{{ __('hand_lab.empty') }}</strong><small>100 BB</small></button>
                        <button type="button" class="lab-seat seat-btn" data-position="BTN"><span>BTN</span><strong>{{ __('hand_lab.empty') }}</strong><small>100 BB</small></button>
                        <button type="button" class="lab-seat seat-sb" data-position="SB"><span>SB</span><strong>{{ __('hand_lab.empty') }}</strong><small>100 BB</small></button>
                        <button type="button" class="lab-seat seat-bb" data-position="BB"><span>BB</span><strong>{{ __('hand_lab.empty') }}</strong><small>100 BB</small></button>
                    </div>
                </div>

                <div class="lab-hero-cards-panel">
                    <span>{{ __('hand_lab.hero_cards') }}</span>
                    <div class="lab-hero-cards" id="labHeroCards"><div class="empty-card">--</div><div class="empty-card">--</div></div>
                </div>

                <div class="lab-table-footer">
                    <div class="lab-stage-pill" id="labHeroVillainSummary">{{ __('hand_lab.select_hero_first') }}</div>
                    <button type="button" class="primary-lab-btn" id="createSpotBtn">{{ __('hand_lab.create_spot') }}</button>
                </div>
            </div>

            <aside class="hand-lab-panel is-waiting" id="handLabPanel">
                <article class="lab-box lab-player-gate" id="labPlayerGate">
                    <span class="lab-box-kicker">HAND LAB</span>
                    <h3>{{ __('hand_lab.select_hero_villain_title') }}</h3>
                    <p id="labPlayerGateText">
                        {{ __('hand_lab.select_hero_villain_intro') }}
                    </p>
                </article>
                <div class="lab-box">
                    <span class="lab-box-kicker">{{ __('hand_lab.step_1') }}</span>
                    <h2>{{ __('hand_lab.hand_setup') }}</h2>

                    <label class="lab-field">
                        <span>{{ __('hand_lab.format') }}</span>
                        <select id="labFormat">
                            <option value="cash">Cash 6-max</option>
                            <option value="tournament">{{ __('hand_lab.tournament_6max') }}</option>
                        </select>
                    </label>

                    <div class="lab-grid-2">
                        <label class="lab-field"><span>{{ __('hand_lab.hero_stack') }}</span><input id="heroStack" type="number" min="1" step="0.5" value="100"></label>
                        <label class="lab-field"><span>{{ __('hand_lab.villain_stack') }}</span><input id="villainStack" type="number" min="1" step="0.5" value="100"></label>
                    </div>
                </div>

                <div class="lab-box">
                    <span class="lab-box-kicker">{{ __('hand_lab.step_2') }}</span>
                    <h2>{{ __('hand_lab.hero_cards') }}</h2>
                    <div class="lab-card-builder">
                        <label class="lab-field"><span>{{ __('hand_lab.hero_card_1') }}</span><select class="card-select" id="heroCard1"></select></label>
                        <label class="lab-field"><span>{{ __('hand_lab.hero_card_2') }}</span><select class="card-select" id="heroCard2"></select></label>
                    </div>
                </div>

                
                <div class="lab-box lab-street-box" data-street-box="preflop">
                    <span class="lab-box-kicker">{{ __('hand_lab.step_3') }}</span>
                    <h2>{{ __('hand_lab.preflop_actions') }}</h2>

                    <div class="lab-forced-blinds"><strong>{{ __('hand_lab.forced_preflop') }}</strong><span>SB posts 0.5 BB · BB posts 1 BB</span></div>

                    <div class="lab-action-builder street-action-builder" data-street="preflop">
                        <label class="lab-field">
                            <span>{{ __('hand_lab.actor') }}</span>
                            <select data-action-actor>
                                <option value="UTG">UTG</option><option value="HJ">HJ</option><option value="CO">CO</option><option value="BTN">BTN</option><option value="SB">SB</option><option value="BB">BB</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span>{{ __('hand_lab.action') }}</span>
                            <select data-action-type>
                                <option value="fold">Fold</option><option value="check">Check</option><option value="limp">Limp</option><option value="call">Call</option><option value="bet">Bet</option><option value="raise">Raise</option><option value="allin">All-in</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span>{{ __('hand_lab.size_bb') }}</span>
                            <input data-action-size type="number" min="0" step="0.5" value="0">
                        </label>
                    </div>

                    <button type="button" class="secondary-lab-btn" data-add-action="preflop">
                        {{ __('hand_lab.add_action') }}
                    </button>

                    <ol class="lab-action-list" data-action-list="preflop"></ol>
                </div>

                <div class="lab-box">
                    <span class="lab-box-kicker">{{ __('hand_lab.step_4') }}</span>
                    <h2>{{ __('hand_lab.flop_cards') }}</h2>
                    <div class="lab-board-builder lab-board-builder-flop">
                        <label class="lab-field"><span>Flop 1</span><select class="card-select" id="boardCard1"></select></label>
                        <label class="lab-field"><span>Flop 2</span><select class="card-select" id="boardCard2"></select></label>
                        <label class="lab-field"><span>Flop 3</span><select class="card-select" id="boardCard3"></select></label>
                    </div>
                </div>

                
                <div class="lab-box lab-street-box" data-street-box="flop">
                    <span class="lab-box-kicker">{{ __('hand_lab.step_5') }}</span>
                    <h2>{{ __('hand_lab.flop_actions') }}</h2>

                    

                    <div class="lab-action-builder street-action-builder" data-street="flop">
                        <label class="lab-field">
                            <span>{{ __('hand_lab.actor') }}</span>
                            <select data-action-actor>
                                <option value="UTG">UTG</option><option value="HJ">HJ</option><option value="CO">CO</option><option value="BTN">BTN</option><option value="SB">SB</option><option value="BB">BB</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span>{{ __('hand_lab.action') }}</span>
                            <select data-action-type>
                                <option value="fold">Fold</option><option value="check">Check</option><option value="limp">Limp</option><option value="call">Call</option><option value="bet">Bet</option><option value="raise">Raise</option><option value="allin">All-in</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span>{{ __('hand_lab.size_bb') }}</span>
                            <input data-action-size type="number" min="0" step="0.5" value="0">
                        </label>
                    </div>

                    <button type="button" class="secondary-lab-btn" data-add-action="flop">
                        {{ __('hand_lab.add_action') }}
                    </button>

                    <ol class="lab-action-list" data-action-list="flop"></ol>
                </div>

                <div class="lab-box">
                    <span class="lab-box-kicker">{{ __('hand_lab.step_6') }}</span>
                    <h2>{{ __('hand_lab.turn_card') }}</h2>
                    <div class="lab-single-card-builder">
                        <label class="lab-field"><span>Turn</span><select class="card-select" id="boardCard4"></select></label>
                    </div>
                </div>

                
                <div class="lab-box lab-street-box" data-street-box="turn">
                    <span class="lab-box-kicker">{{ __('hand_lab.step_7') }}</span>
                    <h2>{{ __('hand_lab.turn_actions') }}</h2>

                    

                    <div class="lab-action-builder street-action-builder" data-street="turn">
                        <label class="lab-field">
                            <span>{{ __('hand_lab.actor') }}</span>
                            <select data-action-actor>
                                <option value="UTG">UTG</option><option value="HJ">HJ</option><option value="CO">CO</option><option value="BTN">BTN</option><option value="SB">SB</option><option value="BB">BB</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span>{{ __('hand_lab.action') }}</span>
                            <select data-action-type>
                                <option value="fold">Fold</option><option value="check">Check</option><option value="limp">Limp</option><option value="call">Call</option><option value="bet">Bet</option><option value="raise">Raise</option><option value="allin">All-in</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span>{{ __('hand_lab.size_bb') }}</span>
                            <input data-action-size type="number" min="0" step="0.5" value="0">
                        </label>
                    </div>

                    <button type="button" class="secondary-lab-btn" data-add-action="turn">
                        {{ __('hand_lab.add_action') }}
                    </button>

                    <ol class="lab-action-list" data-action-list="turn"></ol>
                </div>

                <div class="lab-box">
                    <span class="lab-box-kicker">{{ __('hand_lab.step_8') }}</span>
                    <h2>{{ __('hand_lab.river_card') }}</h2>
                    <div class="lab-single-card-builder">
                        <label class="lab-field"><span>River</span><select class="card-select" id="boardCard5"></select></label>
                    </div>
                </div>

                
                <div class="lab-box lab-street-box" data-street-box="river">
                    <span class="lab-box-kicker">{{ __('hand_lab.step_9') }}</span>
                    <h2>{{ __('hand_lab.river_actions') }}</h2>

                    

                    <div class="lab-action-builder street-action-builder" data-street="river">
                        <label class="lab-field">
                            <span>{{ __('hand_lab.actor') }}</span>
                            <select data-action-actor>
                                <option value="UTG">UTG</option><option value="HJ">HJ</option><option value="CO">CO</option><option value="BTN">BTN</option><option value="SB">SB</option><option value="BB">BB</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span>{{ __('hand_lab.action') }}</span>
                            <select data-action-type>
                                <option value="fold">Fold</option><option value="check">Check</option><option value="limp">Limp</option><option value="call">Call</option><option value="bet">Bet</option><option value="raise">Raise</option><option value="allin">All-in</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span>{{ __('hand_lab.size_bb') }}</span>
                            <input data-action-size type="number" min="0" step="0.5" value="0">
                        </label>
                    </div>

                    <button type="button" class="secondary-lab-btn" data-add-action="river">
                        {{ __('hand_lab.add_action') }}
                    </button>

                    <ol class="lab-action-list" data-action-list="river"></ol>
                </div>

                <div class="lab-box lab-preview-box" id="labPreviewBox" hidden>
                    <span class="lab-box-kicker">{{ __('hand_lab.preview') }}</span>
                    <h2>{{ __('hand_lab.spot_created') }}</h2>
                    <p id="labPreviewText"></p>
                    <div class="lab-warning">{{ __('hand_lab.v1_notice') }}</div>
                </div>
            </aside>
        </section>

        <section class="lab-eval-layout" id="handLabEvalStage" hidden>
            <div class="lab-eval-table-card">
                <div class="lab-eval-meta">
                    <span>{{ __('hand_lab.lab_spot') }}</span>
                    <strong id="evalSpotType">SRP</strong>
                    <em id="evalSpotDetails">BTN vs BB · Turn</em>
                </div>

                <div class="lab-eval-table">
                    <div class="table-felt eval-felt">
                        <div class="lab-board-zone eval-board-zone">
                            <span>{{ __('hand_lab.board') }}</span>
                            <div class="lab-board-cards" id="evalBoardCards"></div>
                            <strong id="evalPot">{{ __('hand_lab.pot') }}: 0 BB</strong>
                            <small id="evalSpr">SPR: --</small>
                        </div>

                        <div class="eval-seat seat-utg" data-eval-position="UTG">
                            <span>UTG</span>
                            <strong>{{ __('hand_lab.empty') }}</strong>
                            <small></small>
                        </div>

                        <div class="eval-seat seat-hj" data-eval-position="HJ">
                            <span>HJ</span>
                            <strong>{{ __('hand_lab.empty') }}</strong>
                            <small></small>
                        </div>

                        <div class="eval-seat seat-co" data-eval-position="CO">
                            <span>CO</span>
                            <strong>{{ __('hand_lab.empty') }}</strong>
                            <small></small>
                        </div>

                        <div class="eval-seat seat-btn" data-eval-position="BTN">
                            <span>BTN</span>
                            <strong>{{ __('hand_lab.empty') }}</strong>
                            <small></small>
                        </div>

                        <div class="eval-seat seat-sb" data-eval-position="SB">
                            <span>SB</span>
                            <strong>{{ __('hand_lab.empty') }}</strong>
                            <small></small>
                        </div>

                        <div class="eval-seat seat-bb" data-eval-position="BB">
                            <span>BB</span>
                            <strong>{{ __('hand_lab.empty') }}</strong>
                            <small></small>
                        </div>
                    </div>
                </div>

                <div class="lab-eval-bottom">
                    <div>
                        <span>{{ __('hand_lab.hero_cards') }}</span>
                        <div class="lab-hero-cards" id="evalHeroCards"></div>
                    </div>

                    <div class="lab-decision-buttons" id="labDecisionButtons"></div>
                </div>
            </div>

            <aside class="lab-eval-panel">
                <div class="lab-box">
                    <span class="lab-box-kicker">{{ __('hand_lab.previous_action') }}</span>
                    <h2 id="evalActionTitle">{{ __('hand_lab.action_history') }}</h2>
                    <ol class="lab-action-list eval-action-list" id="evalActionList"></ol>
                </div>

                <div class="lab-box" id="labFeedbackBox" hidden>
                    <span class="lab-box-kicker">{{ __('hand_lab.evaluation') }}</span>
                    <h2 id="labFeedbackTitle">{{ __('hand_lab.analysis_ready') }}</h2>
                    <p id="labFeedbackText"></p>

                    <div class="lab-warning" id="labAiNotice"></div>

                    <div class="lab-final-actions">
                        <button type="button" class="primary-lab-btn" id="createAnotherSpotBtn">
                            {{ __('hand_lab.create_another_spot') }}
                        </button>

                        <button type="button" class="secondary-lab-btn" id="practiceRelatedBtn">
                            {{ __('hand_lab.practice_related_spots') }}
                        </button>
                    </div>
                </div>
            </aside>
        </section>
    </main>

    <script>
        window.ApexHandLabText = @json(__('hand_lab'));
        window.ApexHandLabRoutes = {
            store: @json(route('hand-lab.spots.store')),
        };
    </script>
    <script src="{{ asset('assets/js/hand-lab.js') }}"></script>
</x-app-layout>
