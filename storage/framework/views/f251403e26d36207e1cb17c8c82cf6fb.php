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
    <link href="<?php echo e(asset('assets/css/postflop-training.css')); ?>" rel="stylesheet">

    <?php
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
    ?>

    <script>
        window.ApexMasteryTraining = {
            initialSpot: <?php echo json_encode($initialSpot, 15, 512) ?>,
            initialSummary: <?php echo json_encode($summary, 15, 512) ?>,
            initialLeaks: <?php echo json_encode($leaks, 15, 512) ?>,
            initialModule: <?php echo json_encode($initialModule ?? null, 15, 512) ?>,
            initialMode: <?php echo json_encode($initialMode ?? 'normal', 15, 512) ?>,
            lifetime: <?php echo json_encode($lifetime, 15, 512) ?>,
            nextUrl: <?php echo json_encode(route('mastery-training.next'), 15, 512) ?>,
            answerUrl: <?php echo json_encode(route('mastery-training.answer'), 15, 512) ?>,
            csrf: <?php echo json_encode(csrf_token(), 15, 512) ?>,
            i18n: <?php echo json_encode($masteryI18n, 15, 512) ?>,
        };
    </script>

    <main class="postflop-page">
        <section class="postflop-header">
            <div>
                <span class="postflop-kicker"><?php echo e(__('mastery.kicker')); ?></span>
                <h1><?php echo e(__('mastery.title')); ?></h1>
                <p><?php echo e(__('mastery.subtitle')); ?></p>
            </div>

            <div class="street-tabs">
                <a href="<?php echo e(route('spot-training.index')); ?>"><?php echo e(__('mastery.tabs.preflop')); ?></a>
                <a href="<?php echo e(route('postflop-training.index')); ?>"><?php echo e(__('mastery.tabs.flop')); ?></a>
                <a href="<?php echo e(route('postflop-turn.index')); ?>"><?php echo e(__('mastery.tabs.turn')); ?></a>
                <a href="<?php echo e(route('postflop-river.index')); ?>"><?php echo e(__('mastery.tabs.river')); ?></a>
                <a href="<?php echo e(route('mastery-training.index')); ?>" class="is-active"><?php echo e(__('mastery.tabs.mastery')); ?></a>
            </div>

            <form method="POST" action="<?php echo e(route('mastery-training.reset')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="ghost-btn"><?php echo e(__('mastery.reset')); ?></button>
            </form>
        </section>

        <section class="postflop-layout">
            <div class="postflop-table-card">
                <div class="postflop-table" id="postflopTable">
                    <div class="table-felt">
                        <div class="board-zone">
                            <span id="boardStreetLabel"><?php echo e(__('mastery.board_placeholder')); ?></span>
                            <div class="board-cards" id="boardCards"></div>
                            <strong id="spotPot"><?php echo e(__('mastery.pot_placeholder')); ?></strong>
                            <small id="spotSpr"><?php echo e(__('mastery.spr_placeholder')); ?></small>
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
                        <?php echo e(__('mastery.next_spot')); ?>

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
                    <h2 id="spotTitle"><?php echo e(__('mastery.loading_spot')); ?></h2>
                    <p class="spot-meta" id="spotMeta">--</p>

                    <div class="module-filter" id="moduleFilter">
                        <button type="button" data-module=""><?php echo e(__('mastery.filters.all')); ?></button>
                        <button type="button" data-module="three_bet_pots"><?php echo e(__('mastery.filters.three_bet_pots')); ?></button>
                        <button type="button" data-module="four_bet_pots"><?php echo e(__('mastery.filters.four_bet_pots')); ?></button>
                        <button type="button" data-module="blind_vs_blind_advanced"><?php echo e(__('mastery.filters.blind_vs_blind')); ?></button>
                        <button type="button" data-module="multiway"><?php echo e(__('mastery.filters.multiway')); ?></button>
                        <button type="button" data-module="short_stack_lab"><?php echo e(__('mastery.filters.short_stack_lab')); ?></button>
                        <button type="button" data-module="tournament_lab"><?php echo e(__('mastery.filters.tournament_lab')); ?></button>
                    </div>
                </div>

                <div class="postflop-box actions-box">
                    <h3><?php echo e(__('mastery.previous_action')); ?></h3>
                    <ol id="spotActions"></ol>
                </div>

                <div class="postflop-box decision-box" id="decisionResultBox" hidden>
                    <div class="feedback" id="feedbackBox" hidden></div>
                    <div class="grade-box" id="gradeBox" hidden></div>
                    <div class="frequency-box" id="frequencyBox" hidden></div>
                    <div class="ev-box" id="evBox" hidden></div>
                </div>

                <div class="postflop-box texture-box" id="textureBox" hidden>
                    <h3><?php echo e(__('mastery.spot_analysis')); ?></h3>

                    <div class="metric-row">
                        <span><?php echo e(__('mastery.board_label')); ?></span>
                        <strong id="boardTexture">--</strong>
                    </div>

                    <div class="metric-row">
                        <span><?php echo e(__('mastery.range_advantage')); ?></span>
                        <strong id="rangeAdvantage">--</strong>
                    </div>

                    <div class="metric-row">
                        <span><?php echo e(__('mastery.nut_advantage')); ?></span>
                        <strong id="nutAdvantage">--</strong>
                    </div>

                    <div class="metric-row">
                        <span><?php echo e(__('mastery.effective_stack')); ?></span>
                        <strong id="effectiveStack">--</strong>
                    </div>
                </div>

                <div class="postflop-box summary-box">
                    <h3><?php echo e(__('mastery.session_title')); ?></h3>

                    <div class="summary-grid">
                        <div><span><?php echo e(__('mastery.total')); ?></span><strong id="summaryTotal">0</strong></div>
                        <div><span><?php echo e(__('mastery.correct')); ?></span><strong id="summaryCorrect">0</strong></div>
                        <div><span><?php echo e(__('mastery.wrong')); ?></span><strong id="summaryWrong">0</strong></div>
                        <div><span><?php echo e(__('mastery.accuracy')); ?></span><strong id="summaryAccuracy">0%</strong></div>
                    </div>

                    <div class="leaks-box">
                        <h4><?php echo e(__('mastery.mastery_summary')); ?></h4>
                        <div id="leaksList"></div>
                    </div>
                </div>
            </aside>
        </section>
    </main>

    <script src="<?php echo e(asset('js/mastery-training.js')); ?>"></script>
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
<?php /**PATH C:\laragon\www\apexcash\resources\views/spot-training/mastery.blade.php ENDPATH**/ ?>