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
    <link href="<?php echo e(asset('assets/css/spot-training.css')); ?>" rel="stylesheet">

    <script>
        window.ApexSpotTraining = {
            initialSpot: <?php echo json_encode($initialSpot, 15, 512) ?>,
            initialSummary: <?php echo json_encode($summary, 15, 512) ?>,
            initialLeaks: <?php echo json_encode($leaks, 15, 512) ?>,
            initialModule: <?php echo json_encode($initialModule ?? null, 15, 512) ?>,
            initialMode: <?php echo json_encode($initialMode ?? 'normal', 15, 512) ?>,
            lifetime: <?php echo json_encode($lifetime, 15, 512) ?>,
            nextUrl: <?php echo json_encode(route('spot-training.next'), 15, 512) ?>,
            answerUrl: <?php echo json_encode(route('spot-training.answer'), 15, 512) ?>,
            csrf: <?php echo json_encode(csrf_token(), 15, 512) ?>,
            i18n: <?php echo json_encode(__('preflop'), 15, 512) ?>,
        };
    </script>

    <main class="spot-page">
        <section class="spot-header">
            <div>
                <span class="spot-kicker"><?php echo e(__('preflop.kicker')); ?></span>
                <h1><?php echo e(__('preflop.title')); ?></h1>
                <p><?php echo e(__('preflop.subtitle')); ?></p>
            </div>

            <form method="POST" action="<?php echo e(route('spot-training.reset')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="ghost-btn"><?php echo e(__('preflop.reset_practice')); ?></button>
            </form>
        </section>

        <section class="spot-layout">
            <div class="spot-table-card">
                <div class="spot-table" id="spotTable">
                    <div class="table-felt">
                        <div class="board-zone">
                            <span><?php echo e(__('preflop.board_label')); ?></span>
                            <strong id="spotPot"><?php echo e(__('preflop.pot_placeholder')); ?></strong>
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
                        <?php echo e(__('preflop.next_spot')); ?>

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
                    <h2 id="spotTitle"><?php echo e(__('preflop.loading_spot')); ?></h2>
                    <p class="spot-meta" id="spotMeta">--</p>

                    <div class="module-filter" id="moduleFilter">
                        <button type="button" data-module=""><?php echo e(__('preflop.modules.all')); ?></button>
                        <button type="button" data-module="open_raise"><?php echo e(__('preflop.modules.open_raise')); ?></button>
                        <button type="button" data-module="bb_vs_btn"><?php echo e(__('preflop.modules.bb_vs_btn')); ?></button>
                        <button type="button" data-module="btn_vs_3bet"><?php echo e(__('preflop.modules.btn_vs_3bet')); ?></button>
                        <button type="button" data-module="threebet_vs_open"><?php echo e(__('preflop.modules.threebet_vs_open')); ?></button>
                        <button type="button" data-module="sb_vs_btn"><?php echo e(__('preflop.modules.sb_vs_btn')); ?></button>
                        <button type="button" data-module="bb_vs_sb"><?php echo e(__('preflop.modules.bb_vs_sb')); ?></button>
                    </div>
                </div>

                <div class="spot-box actions-box">
                    <h3><?php echo e(__('preflop.previous_action')); ?></h3>
                    <ol id="spotActions"></ol>
                </div>

                <div class="spot-box decision-box" id="decisionResultBox" hidden>
                    <div class="feedback" id="feedbackBox" hidden></div>
                    <div class="grade-box" id="gradeBox" hidden></div>
                    <div class="frequency-box" id="frequencyBox" hidden></div>
                    <div class="ev-box" id="evBox" hidden></div>
                </div>

                <div class="spot-box summary-box">
                    <h3><?php echo e(__('preflop.current_session')); ?></h3>

                    <div class="summary-grid">
                        <div><span><?php echo e(__('preflop.summary.total')); ?></span><strong id="summary<?php echo e(__('preflop.summary.total')); ?>">0</strong></div>
                        <div><span><?php echo e(__('preflop.summary.correct')); ?></span><strong id="summaryCorrect">0</strong></div>
                        <div><span><?php echo e(__('preflop.summary.wrong')); ?></span><strong id="summaryWrong">0</strong></div>
                        <div><span><?php echo e(__('preflop.summary.accuracy')); ?></span><strong id="summaryAccuracy">0%</strong></div>
                    </div>

                    <div class="leaks-box">
                        <h4><?php echo e(__('preflop.preflop_summary')); ?></h4>
                        <div id="leaksList"></div>

                    </div>
                </div>
            </aside>
        </section>
    </main>

    <script src="<?php echo e(asset('js/spot-training.js')); ?>"></script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\apexcash\resources\views/spot-training/index.blade.php ENDPATH**/ ?>