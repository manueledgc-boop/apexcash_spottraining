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
    <link href="<?php echo e(asset('assets/css/certification-result.css')); ?>" rel="stylesheet">

    <?php
        $globalScore = (float) ($attempt->global_score ?? 0);
        $totalCorrect = (int) ($attempt->total_correct ?? 0);
        $totalQuestions = (int) ($attempt->total_questions ?? 75);
        $durationSeconds = (int) ($attempt->duration_seconds ?? 0);
        $durationMinutes = max(0, (int) floor($durationSeconds / 60));
        $durationRemainder = max(0, $durationSeconds % 60);
        $durationLabel = $durationSeconds > 0
            ? $durationMinutes . ' min' . ($durationRemainder > 0 ? ' ' . $durationRemainder . ' s' : '')
            : '—';

        $isPassed = (bool) $attempt->passed;
        $isDistinction = (bool) $attempt->distinction;

        $resultIcon = $isDistinction ? '🏆' : ($isPassed ? '✅' : '❌');
        $resultTitle = $isDistinction ? 'APROBADO CON DISTINCIÓN' : ($isPassed ? 'CERTIFICATION APROBADA' : 'CERTIFICATION NO SUPERADA');
        $resultTone = $isDistinction ? 'distinction' : ($isPassed ? 'passed' : 'failed');

        $blockScores = [
            'Preflop' => (float) ($attempt->preflop_score ?? 0),
            'Flop' => (float) ($attempt->flop_score ?? 0),
            'Turn' => (float) ($attempt->turn_score ?? 0),
            'River' => (float) ($attempt->river_score ?? 0),
            'Mastery' => (float) ($attempt->mastery_score ?? 0),
        ];
    ?>

    <main class="cert-result-page">
        <div class="cert-result-shell">
            <?php if(session('error')): ?>
                <div class="cert-result-alert <?php echo e(str_contains(session('error'), 'Tiempo agotado') ? 'is-warning' : 'is-error'); ?>">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <section class="cert-result-hero cert-result-hero--<?php echo e($resultTone); ?>">
                <div class="cert-result-badge"><?php echo e($resultIcon); ?></div>

                <p class="cert-result-kicker">Resultado Certification ApexCash</p>
                <h1><?php echo e($resultTitle); ?></h1>

                <?php if($isPassed): ?>
                    <p class="cert-result-message">
                        Has superado satisfactoriamente la Certification ApexCash.
                    </p>

                    <?php if($attempt->certificate_code): ?>
                        <div class="cert-result-code">
                            Código certificado: <strong><?php echo e($attempt->certificate_code); ?></strong>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="cert-result-message">
                        No has alcanzado los requisitos mínimos de aprobación.
                    </p>

                    <?php if($attempt->next_attempt_at): ?>
                        <div class="cert-result-retry">
                            Podrás volver a intentarlo el<br>
                            <strong><?php echo e($attempt->next_attempt_at->format('d/m/Y H:i')); ?></strong>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </section>

            <section class="cert-result-summary" aria-label="Resumen del examen">
                <article class="cert-result-card">
                    <span>Resultado global</span>
                    <strong><?php echo e(number_format($globalScore, 1)); ?>%</strong>
                    <small>Mínimo requerido: 75%</small>
                </article>

                <article class="cert-result-card">
                    <span>Aciertos</span>
                    <strong><?php echo e($totalCorrect); ?> / <?php echo e($totalQuestions); ?></strong>
                    <small>Preguntas totales</small>
                </article>

                <article class="cert-result-card">
                    <span>Duración</span>
                    <strong><?php echo e($durationLabel); ?></strong>
                    <small>Tiempo máximo: 60 min</small>
                </article>
            </section>

            <section class="cert-result-blocks">
                <div class="cert-result-section-head">
                    <p>Bloques evaluados</p>
                    <h2>Resultado por bloque</h2>
                    <span>Para aprobar necesitas mínimo 60% en cada bloque.</span>
                </div>

                <div class="cert-result-block-grid">
                    <?php $__currentLoopData = $blockScores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $score): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $blockPassed = $score >= 60; ?>
                        <article class="cert-result-block <?php echo e($blockPassed ? 'is-ok' : 'is-bad'); ?>">
                            <div>
                                <span><?php echo e($label); ?></span>
                                <strong><?php echo e(number_format($score, 1)); ?>%</strong>
                            </div>
                            <em><?php echo e($blockPassed ? '✅' : '❌'); ?></em>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>

            <section class="cert-result-next cert-result-next--<?php echo e($resultTone); ?>">
                <?php if($isPassed): ?>
                    <h2>¿Qué sigue ahora?</h2>
                    <p>
                        La certificación marca el final de la formación. No el final del aprendizaje.
                        Continúa entrenando para mantener tu nivel, detectar nuevos leaks y mejorar tu precisión.
                    </p>
                <?php else: ?>
                    <h2>Tu referencia actual</h2>
                    <p>
                        Este resultado no es el final del proceso. Usa los bloques débiles como guía,
                        vuelve a entrenar y presenta la Certification cuando el sistema desbloquee tu próximo intento.
                    </p>
                <?php endif; ?>
            </section>

            <div class="cert-result-actions">
                <a href="<?php echo e(route('certification.index')); ?>" class="cert-result-btn cert-result-btn--ghost">
                    Volver a Certification
                </a>

                <a href="<?php echo e(route('dashboard')); ?>" class="cert-result-btn cert-result-btn--primary">
                    Ir al Dashboard
                </a>
            </div>
        </div>
    </main>
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
<?php /**PATH C:\laragon\www\apexcash\resources\views/certification/result.blade.php ENDPATH**/ ?>