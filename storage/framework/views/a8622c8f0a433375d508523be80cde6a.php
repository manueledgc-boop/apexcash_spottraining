<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <link href="<?php echo e(asset('assets/css/hand-lab.css')); ?>" rel="stylesheet">

    <main class="hand-lab-page">
        <section class="hand-lab-header">
            <div>
                <span class="hand-lab-kicker"><?php echo e(__('hand_lab.kicker')); ?></span>
                <h1><?php echo e(__('hand_lab.title')); ?></h1>
                <p><?php echo e(__('hand_lab.subtitle')); ?></p>
            </div>

            <div class="hand-lab-header-actions">
                <?php if(($reviewCount ?? 0) > 0): ?>
                    <a href="<?php echo e(route('hand-lab.reviews.index')); ?>" class="ghost-link hand-review-link">
                        <?php echo e(__('hand_lab.my_hand_reviews')); ?> (<?php echo e($reviewCount); ?>)
                    </a>
                <?php else: ?>
                    <span class="ghost-link hand-review-link is-disabled" aria-disabled="true">
                        <?php echo e(__('hand_lab.my_hand_reviews')); ?> (0)
                    </span>
                <?php endif; ?>
            </div>
        </section>

        <section class="hand-lab-layout" id="handLabBuilderStage">
            <div class="hand-lab-table-card">
                <div class="hand-lab-table" id="handLabTable">
                    <div class="table-felt">
                        <div class="lab-board-zone">
                            <span><?php echo e(__('hand_lab.board')); ?></span>
                            <div class="lab-board-cards" id="labBoardCards">
                                <div class="empty-card">--</div><div class="empty-card">--</div><div class="empty-card">--</div><div class="empty-card">--</div><div class="empty-card">--</div>
                            </div>
                            <strong id="labPot"><?php echo e(__('hand_lab.pot')); ?>: 1.5 BB</strong>
                            <small id="labStreetLabel"><?php echo e(__('hand_lab.street')); ?>: <?php echo e(__('hand_lab.preflop')); ?></small>
                        </div>

                        <button type="button" class="lab-seat seat-utg" data-position="UTG"><span>UTG</span><strong><?php echo e(__('hand_lab.empty')); ?></strong><small>100 BB</small></button>
                        <button type="button" class="lab-seat seat-hj" data-position="HJ"><span>HJ</span><strong><?php echo e(__('hand_lab.empty')); ?></strong><small>100 BB</small></button>
                        <button type="button" class="lab-seat seat-co" data-position="CO"><span>CO</span><strong><?php echo e(__('hand_lab.empty')); ?></strong><small>100 BB</small></button>
                        <button type="button" class="lab-seat seat-btn" data-position="BTN"><span>BTN</span><strong><?php echo e(__('hand_lab.empty')); ?></strong><small>100 BB</small></button>
                        <button type="button" class="lab-seat seat-sb" data-position="SB"><span>SB</span><strong><?php echo e(__('hand_lab.empty')); ?></strong><small>100 BB</small></button>
                        <button type="button" class="lab-seat seat-bb" data-position="BB"><span>BB</span><strong><?php echo e(__('hand_lab.empty')); ?></strong><small>100 BB</small></button>
                    </div>
                </div>

                <div class="lab-hero-cards-panel">
                    <span><?php echo e(__('hand_lab.hero_cards')); ?></span>
                    <div class="lab-hero-cards" id="labHeroCards"><div class="empty-card">--</div><div class="empty-card">--</div></div>
                </div>

                <div class="lab-table-footer">
                    <div class="lab-stage-pill" id="labHeroVillainSummary"><?php echo e(__('hand_lab.select_hero_first')); ?></div>
                    <button type="button" class="primary-lab-btn" id="createSpotBtn"><?php echo e(__('hand_lab.create_spot')); ?></button>
                </div>
            </div>

            <aside class="hand-lab-panel is-waiting" id="handLabPanel">
                <article class="lab-box lab-player-gate" id="labPlayerGate">
                    <span class="lab-box-kicker">HAND LAB</span>
                    <h3><?php echo e(__('hand_lab.select_hero_villain_title')); ?></h3>
                    <p id="labPlayerGateText">
                        <?php echo e(__('hand_lab.select_hero_villain_intro')); ?>

                    </p>
                </article>
                <div class="lab-box">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.step_1')); ?></span>
                    <h2><?php echo e(__('hand_lab.hand_setup')); ?></h2>

                    <label class="lab-field">
                        <span><?php echo e(__('hand_lab.format')); ?></span>
                        <select id="labFormat">
                            <option value="cash">Cash 6-max</option>
                            <option value="tournament"><?php echo e(__('hand_lab.tournament_6max')); ?></option>
                        </select>
                    </label>

                    <div class="lab-grid-2">
                        <label class="lab-field"><span><?php echo e(__('hand_lab.hero_stack')); ?></span><input id="heroStack" type="number" min="1" step="0.5" value="100"></label>
                        <label class="lab-field"><span><?php echo e(__('hand_lab.villain_stack')); ?></span><input id="villainStack" type="number" min="1" step="0.5" value="100"></label>
                    </div>
                </div>

                <div class="lab-box">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.step_2')); ?></span>
                    <h2><?php echo e(__('hand_lab.hero_cards')); ?></h2>
                    <div class="lab-card-builder">
                        <label class="lab-field"><span><?php echo e(__('hand_lab.hero_card_1')); ?></span><select class="card-select" id="heroCard1"></select></label>
                        <label class="lab-field"><span><?php echo e(__('hand_lab.hero_card_2')); ?></span><select class="card-select" id="heroCard2"></select></label>
                    </div>
                </div>

                
                <div class="lab-box lab-street-box" data-street-box="preflop">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.step_3')); ?></span>
                    <h2><?php echo e(__('hand_lab.preflop_actions')); ?></h2>

                    <div class="lab-forced-blinds"><strong><?php echo e(__('hand_lab.forced_preflop')); ?></strong><span>SB posts 0.5 BB · BB posts 1 BB</span></div>

                    <div class="lab-action-builder street-action-builder" data-street="preflop">
                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.actor')); ?></span>
                            <select data-action-actor>
                                <option value="UTG">UTG</option><option value="HJ">HJ</option><option value="CO">CO</option><option value="BTN">BTN</option><option value="SB">SB</option><option value="BB">BB</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.action')); ?></span>
                            <select data-action-type>
                                <option value="fold">Fold</option><option value="check">Check</option><option value="limp">Limp</option><option value="call">Call</option><option value="bet">Bet</option><option value="raise">Raise</option><option value="allin">All-in</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.size_bb')); ?></span>
                            <input data-action-size type="number" min="0" step="0.5" value="0">
                        </label>
                    </div>

                    <button type="button" class="secondary-lab-btn" data-add-action="preflop">
                        <?php echo e(__('hand_lab.add_action')); ?>

                    </button>

                    <ol class="lab-action-list" data-action-list="preflop"></ol>
                </div>

                <div class="lab-box">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.step_4')); ?></span>
                    <h2><?php echo e(__('hand_lab.flop_cards')); ?></h2>
                    <div class="lab-board-builder lab-board-builder-flop">
                        <label class="lab-field"><span>Flop 1</span><select class="card-select" id="boardCard1"></select></label>
                        <label class="lab-field"><span>Flop 2</span><select class="card-select" id="boardCard2"></select></label>
                        <label class="lab-field"><span>Flop 3</span><select class="card-select" id="boardCard3"></select></label>
                    </div>
                </div>

                
                <div class="lab-box lab-street-box" data-street-box="flop">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.step_5')); ?></span>
                    <h2><?php echo e(__('hand_lab.flop_actions')); ?></h2>

                    

                    <div class="lab-action-builder street-action-builder" data-street="flop">
                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.actor')); ?></span>
                            <select data-action-actor>
                                <option value="UTG">UTG</option><option value="HJ">HJ</option><option value="CO">CO</option><option value="BTN">BTN</option><option value="SB">SB</option><option value="BB">BB</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.action')); ?></span>
                            <select data-action-type>
                                <option value="fold">Fold</option><option value="check">Check</option><option value="limp">Limp</option><option value="call">Call</option><option value="bet">Bet</option><option value="raise">Raise</option><option value="allin">All-in</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.size_bb')); ?></span>
                            <input data-action-size type="number" min="0" step="0.5" value="0">
                        </label>
                    </div>

                    <button type="button" class="secondary-lab-btn" data-add-action="flop">
                        <?php echo e(__('hand_lab.add_action')); ?>

                    </button>

                    <ol class="lab-action-list" data-action-list="flop"></ol>
                </div>

                <div class="lab-box">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.step_6')); ?></span>
                    <h2><?php echo e(__('hand_lab.turn_card')); ?></h2>
                    <div class="lab-single-card-builder">
                        <label class="lab-field"><span>Turn</span><select class="card-select" id="boardCard4"></select></label>
                    </div>
                </div>

                
                <div class="lab-box lab-street-box" data-street-box="turn">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.step_7')); ?></span>
                    <h2><?php echo e(__('hand_lab.turn_actions')); ?></h2>

                    

                    <div class="lab-action-builder street-action-builder" data-street="turn">
                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.actor')); ?></span>
                            <select data-action-actor>
                                <option value="UTG">UTG</option><option value="HJ">HJ</option><option value="CO">CO</option><option value="BTN">BTN</option><option value="SB">SB</option><option value="BB">BB</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.action')); ?></span>
                            <select data-action-type>
                                <option value="fold">Fold</option><option value="check">Check</option><option value="limp">Limp</option><option value="call">Call</option><option value="bet">Bet</option><option value="raise">Raise</option><option value="allin">All-in</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.size_bb')); ?></span>
                            <input data-action-size type="number" min="0" step="0.5" value="0">
                        </label>
                    </div>

                    <button type="button" class="secondary-lab-btn" data-add-action="turn">
                        <?php echo e(__('hand_lab.add_action')); ?>

                    </button>

                    <ol class="lab-action-list" data-action-list="turn"></ol>
                </div>

                <div class="lab-box">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.step_8')); ?></span>
                    <h2><?php echo e(__('hand_lab.river_card')); ?></h2>
                    <div class="lab-single-card-builder">
                        <label class="lab-field"><span>River</span><select class="card-select" id="boardCard5"></select></label>
                    </div>
                </div>

                
                <div class="lab-box lab-street-box" data-street-box="river">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.step_9')); ?></span>
                    <h2><?php echo e(__('hand_lab.river_actions')); ?></h2>

                    

                    <div class="lab-action-builder street-action-builder" data-street="river">
                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.actor')); ?></span>
                            <select data-action-actor>
                                <option value="UTG">UTG</option><option value="HJ">HJ</option><option value="CO">CO</option><option value="BTN">BTN</option><option value="SB">SB</option><option value="BB">BB</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.action')); ?></span>
                            <select data-action-type>
                                <option value="fold">Fold</option><option value="check">Check</option><option value="limp">Limp</option><option value="call">Call</option><option value="bet">Bet</option><option value="raise">Raise</option><option value="allin">All-in</option>
                            </select>
                        </label>

                        <label class="lab-field">
                            <span><?php echo e(__('hand_lab.size_bb')); ?></span>
                            <input data-action-size type="number" min="0" step="0.5" value="0">
                        </label>
                    </div>

                    <button type="button" class="secondary-lab-btn" data-add-action="river">
                        <?php echo e(__('hand_lab.add_action')); ?>

                    </button>

                    <ol class="lab-action-list" data-action-list="river"></ol>
                </div>

                <div class="lab-box lab-preview-box" id="labPreviewBox" hidden>
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.preview')); ?></span>
                    <h2><?php echo e(__('hand_lab.spot_created')); ?></h2>
                    <p id="labPreviewText"></p>
                    <div class="lab-warning"><?php echo e(__('hand_lab.v1_notice')); ?></div>
                </div>
            </aside>
        </section>

        <section class="lab-eval-layout" id="handLabEvalStage" hidden>
            <div class="lab-eval-table-card">
                <div class="lab-eval-meta">
                    <span><?php echo e(__('hand_lab.lab_spot')); ?></span>
                    <strong id="evalSpotType">SRP</strong>
                    <em id="evalSpotDetails">BTN vs BB · Turn</em>
                </div>

                <div class="lab-eval-table">
                    <div class="table-felt eval-felt">
                        <div class="lab-board-zone eval-board-zone">
                            <span><?php echo e(__('hand_lab.board')); ?></span>
                            <div class="lab-board-cards" id="evalBoardCards"></div>
                            <strong id="evalPot"><?php echo e(__('hand_lab.pot')); ?>: 0 BB</strong>
                            <small id="evalSpr">SPR: --</small>
                        </div>

                        <div class="eval-seat seat-utg" data-eval-position="UTG">
                            <span>UTG</span>
                            <strong><?php echo e(__('hand_lab.empty')); ?></strong>
                            <small></small>
                        </div>

                        <div class="eval-seat seat-hj" data-eval-position="HJ">
                            <span>HJ</span>
                            <strong><?php echo e(__('hand_lab.empty')); ?></strong>
                            <small></small>
                        </div>

                        <div class="eval-seat seat-co" data-eval-position="CO">
                            <span>CO</span>
                            <strong><?php echo e(__('hand_lab.empty')); ?></strong>
                            <small></small>
                        </div>

                        <div class="eval-seat seat-btn" data-eval-position="BTN">
                            <span>BTN</span>
                            <strong><?php echo e(__('hand_lab.empty')); ?></strong>
                            <small></small>
                        </div>

                        <div class="eval-seat seat-sb" data-eval-position="SB">
                            <span>SB</span>
                            <strong><?php echo e(__('hand_lab.empty')); ?></strong>
                            <small></small>
                        </div>

                        <div class="eval-seat seat-bb" data-eval-position="BB">
                            <span>BB</span>
                            <strong><?php echo e(__('hand_lab.empty')); ?></strong>
                            <small></small>
                        </div>
                    </div>
                </div>

                <div class="lab-eval-bottom">
                    <div>
                        <span><?php echo e(__('hand_lab.hero_cards')); ?></span>
                        <div class="lab-hero-cards" id="evalHeroCards"></div>
                    </div>

                    <div class="lab-decision-buttons" id="labDecisionButtons"></div>
                </div>
            </div>

            <aside class="lab-eval-panel">
                <div class="lab-box">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.previous_action')); ?></span>
                    <h2 id="evalActionTitle"><?php echo e(__('hand_lab.action_history')); ?></h2>
                    <ol class="lab-action-list eval-action-list" id="evalActionList"></ol>
                </div>

                <div class="lab-box" id="labFeedbackBox" hidden>
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.evaluation')); ?></span>
                    <h2 id="labFeedbackTitle"><?php echo e(__('hand_lab.analysis_ready')); ?></h2>
                    <p id="labFeedbackText"></p>

                    <div class="lab-warning" id="labAiNotice"></div>

                    <div class="lab-final-actions">
                        <button type="button" class="primary-lab-btn" id="createAnotherSpotBtn">
                            <?php echo e(__('hand_lab.create_another_spot')); ?>

                        </button>

                    <!--    <button type="button" class="secondary-lab-btn" id="practiceRelatedBtn">
                            <?php echo e(__('hand_lab.practice_related_spots')); ?>

                        </button> -->
                    </div>
                </div>
            </aside>
        </section>
    </main>

    <script>
        window.ApexHandLabText = <?php echo json_encode(__('hand_lab'), 15, 512) ?>;
        window.ApexHandLabRoutes = {
            store: <?php echo json_encode(route('hand-lab.spots.store'), 15, 512) ?>,
        };
    </script>
    <script src="<?php echo e(asset('assets/js/hand-lab.js')); ?>"></script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\apexcash\resources\views/hand-lab/index.blade.php ENDPATH**/ ?>