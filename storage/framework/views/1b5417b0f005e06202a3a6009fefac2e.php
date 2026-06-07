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
            nextUrl: <?php echo json_encode(route('spot-training.next'), 15, 512) ?>,
            answerUrl: <?php echo json_encode(route('spot-training.answer'), 15, 512) ?>,
            csrf: <?php echo json_encode(csrf_token(), 15, 512) ?>,
        };
    </script>

    <main class="spot-page">
        <section class="spot-header">
            <div>
                <span class="spot-kicker">APEXCASH SPOT TRAINING V1</span>
                <h1>Entrenador de decisiones preflop</h1>
                <p>Practica spots concretos, recibe feedback inmediato y repite hasta que la decisión correcta sea automática.</p>
            </div>
            <form method="POST" action="<?php echo e(route('spot-training.reset')); ?>">
                <?php echo csrf_field(); ?>
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
<?php endif; ?>
<?php /**PATH C:\laragon\www\apexcash\resources\views/spot-training/index.blade.php ENDPATH**/ ?>