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
        $postflopRiverI18n = [
            'default_title' => __('postflop.river.default_title'),
            'default_difficulty' => __('postflop.river.default_difficulty'),
            'confidence' => __('postflop.confidence'),
            'pot' => __('postflop.pot'),
            'spr' => __('postflop.spr'),
            'effective_stack' => __('postflop.effective_stack'),
            'no_leaks' => __('postflop.river.no_leaks'),
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
                'BET_50' => __('postflop.actions.bet_50'),
                'BET_66' => __('postflop.actions.bet_66'),
                'BET_75' => __('postflop.actions.bet_75'),
                'FOLD' => __('postflop.actions.fold'),
                'CALL' => __('postflop.actions.call'),
                'RAISE' => __('postflop.actions.raise'),
            ],
        ];
    ?>

    <script>
        window.ApexPostflopRiverTraining = {
            initialSpot: <?php echo json_encode($initialSpot, 15, 512) ?>,
            initialSummary: <?php echo json_encode($summary, 15, 512) ?>,
            initialLeaks: <?php echo json_encode($leaks, 15, 512) ?>,
            initialModule: <?php echo json_encode($initialModule ?? null, 15, 512) ?>,
            initialMode: <?php echo json_encode($initialMode ?? 'normal', 15, 512) ?>,
            lifetime: <?php echo json_encode($lifetime, 15, 512) ?>,
            nextUrl: <?php echo json_encode(route('postflop-river.next'), 15, 512) ?>,
            answerUrl: <?php echo json_encode(route('postflop-river.answer'), 15, 512) ?>,
            csrf: <?php echo json_encode(csrf_token(), 15, 512) ?>,
            i18n: <?php echo json_encode($postflopRiverI18n, 15, 512) ?>,
        };
    </script>

    <main class="postflop-page">
        <section class="postflop-header">
            <div>
                <span class="postflop-kicker"><?php echo e(__('postflop.river.kicker')); ?></span>
                <h1><?php echo e(__('postflop.river.title')); ?></h1>
                <p><?php echo e(__('postflop.river.subtitle')); ?></p>
            </div>

            <div class="street-tabs">
                <a href="<?php echo e(route('spot-training.index')); ?>"><?php echo e(__('postflop.tabs.preflop')); ?></a>
                <a href="<?php echo e(route('postflop-training.index')); ?>"><?php echo e(__('postflop.tabs.flop')); ?></a>
                <a href="<?php echo e(route('postflop-turn.index')); ?>"><?php echo e(__('postflop.tabs.turn')); ?></a>
                <a href="<?php echo e(route('postflop-river.index')); ?>" class="is-active"><?php echo e(__('postflop.tabs.river')); ?></a>
            </div>

            <form method="POST" action="<?php echo e(route('postflop-river.reset')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="ghost-btn"><?php echo e(__('postflop.river.reset')); ?></button>
            </form>
        </section>

        <section class="postflop-layout">
            <div class="postflop-table-card">
                <div class="postflop-table" id="postflopTable">
                    <div class="table-felt">
                        <div class="board-zone">
                            <span><?php echo e(__('postflop.river.board_label')); ?></span>
                            <div class="board-cards" id="boardCards"></div>
                            <strong id="spotPot"><?php echo e(__('postflop.pot')); ?>: -- BB</strong>
                            <small id="spotSpr"><?php echo e(__('postflop.spr')); ?>: --</small>
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
                        <?php echo e(__('postflop.next_spot')); ?>

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
                    <h2 id="spotTitle"><?php echo e(__('postflop.loading_spot')); ?></h2>
                    <p class="spot-meta" id="spotMeta">--</p>

                    <div class="module-filter" id="moduleFilter">
                        <button type="button" data-module=""><?php echo e(__('postflop.filters.all')); ?></button>
                        <button type="button" data-module="river_value_bet"><?php echo e(__('postflop.filters.river_value_bet')); ?></button>
                        <button type="button" data-module="river_bluff_catch"><?php echo e(__('postflop.filters.river_bluff_catch')); ?></button>
                        <button type="button" data-module="river_bluff"><?php echo e(__('postflop.filters.river_bluff')); ?></button>
                        <button type="button" data-module="river_thin_value"><?php echo e(__('postflop.filters.river_thin_value')); ?></button>
                        <button type="button" data-module="river_overbet"><?php echo e(__('postflop.filters.river_overbet')); ?></button>
                    </div>
                </div>

                <div class="postflop-box actions-box">
                    <h3><?php echo e(__('postflop.previous_action')); ?></h3>
                    <ol id="spotActions"></ol>
                </div>

                <div class="postflop-box decision-box" id="decisionResultBox" hidden>
                    <div class="feedback" id="feedbackBox" hidden></div>
                    <div class="grade-box" id="gradeBox" hidden></div>
                    <div class="frequency-box" id="frequencyBox" hidden></div>
                    <div class="ev-box" id="evBox" hidden></div>
                </div>

                <div class="postflop-box texture-box" id="textureBox" hidden>
                    <h3><?php echo e(__('postflop.spot_analysis')); ?></h3>

                    <div class="metric-row">
                        <span><?php echo e(__('postflop.board')); ?></span>
                        <strong id="boardTexture">--</strong>
                    </div>

                    <div class="metric-row">
                        <span><?php echo e(__('postflop.range_advantage')); ?></span>
                        <strong id="rangeAdvantage">--</strong>
                    </div>

                    <div class="metric-row">
                        <span><?php echo e(__('postflop.nut_advantage')); ?></span>
                        <strong id="nutAdvantage">--</strong>
                    </div>

                    <div class="metric-row">
                        <span><?php echo e(__('postflop.effective_stack')); ?></span>
                        <strong id="effectiveStack">--</strong>
                    </div>
                </div>

                <div class="postflop-box summary-box">
                    <h3><?php echo e(__('postflop.river.session')); ?></h3>

                    <div class="summary-grid">
                        <div><span><?php echo e(__('postflop.total')); ?></span><strong id="summaryTotal">0</strong></div>
                        <div><span><?php echo e(__('postflop.correct')); ?></span><strong id="summaryCorrect">0</strong></div>
                        <div><span><?php echo e(__('postflop.wrong')); ?></span><strong id="summaryWrong">0</strong></div>
                        <div><span><?php echo e(__('postflop.accuracy')); ?></span><strong id="summaryAccuracy">0%</strong></div>
                    </div>

                    <div class="leaks-box">
                        <h4><?php echo e(__('postflop.river.summary')); ?></h4>
                        <div id="leaksList"></div>
                    </div>
                </div>
            </aside>
        </section>
    </main>

    <script src="<?php echo e(asset('js/postflop-river-training.js')); ?>"></script>
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
<?php /**PATH C:\laragon\www\apexcash\resources\views/spot-training/river.blade.php ENDPATH**/ ?>