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
                <a href="<?php echo e(route('spot-training.index')); ?>">Preflop</a>
                <a href="<?php echo e(route('postflop-training.index')); ?>">Flop</a>
                <a href="<?php echo e(route('postflop-turn.index')); ?>">Turn</a>
                <a href="<?php echo e(route('postflop-river.index')); ?>">River</a>
                <a href="<?php echo e(route('mastery-training.index')); ?>" class="is-active">Mastery</a>
            </div>

            <form method="POST" action="<?php echo e(route('mastery-training.reset')); ?>">
                <?php echo csrf_field(); ?>
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