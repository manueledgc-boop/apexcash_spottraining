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
    <link href="<?php echo e(asset('assets/css/apexcash-dashboard.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/apexcash-dashboard-polish.css')); ?>" rel="stylesheet">

    <?php
        $total = (int) ($global->total_spots ?? 0);
        $correct = (int) ($global->correct_spots ?? 0);
        $wrong = (int) ($global->wrong_spots ?? 0);
        $accuracy = (float) ($global->accuracy ?? 0);
        $xp = (int) ($global->xp ?? 0);
        $level = (int) ($global->level ?? 1);
        $levelBase = max(0, ($level - 1) * 250);
        $levelProgress = max(0, $xp - $levelBase);
        $levelPercent = min(100, round(($levelProgress / 250) * 100));
        $worstLeak = $leaks->first();

        $flopModules = $postflopModules ?? [
            'cbet_ip',
            'check_back_ip',
            'defense_vs_cbet',
            'check_raise',
            'value_bet',
            'semi_bluff',
        ];

        $turnModules = [
            'turn_barrel',
            'turn_probe_bet',
            'turn_defense',
            'turn_value_bet',
            'turn_check_raise',
        ];

        $riverModules = [
            'river_value_bet',
            'river_bluff_catch',
            'river_bluff',
            'river_thin_value',
            'river_overbet',
        ];

        $trainingRouteForModule = function (?string $module) use ($flopModules, $turnModules, $riverModules) {
            if (in_array($module, $flopModules, true)) {
                return 'postflop-training.index';
            }

            if (in_array($module, $turnModules, true)) {
                return 'postflop-turn.index';
            }

            if (in_array($module, $riverModules, true)) {
                return 'postflop-river.index';
            }

            return 'spot-training.index';
        };
    ?>

    <main class="dashboard-page">
        <section class="dashboard-hero dashboard-hero-v2">
            <div class="dashboard-hero-main">
                <span class="dashboard-badge">APEXCASH TRAINING DASHBOARD</span>

                <h1>Hola, <?php echo e(auth()->user()->name); ?></h1>

                <p>
                    Tu progreso ya está guardado: XP, precisión, módulos desbloqueados,
                    leaks reales y errores concretos que debes corregir.
                </p>

                <div class="dashboard-hero-metrics">
                    <div>
                        <span>Nivel</span>
                        <strong><?php echo e($level); ?></strong>
                    </div>

                    <div>
                        <span>XP Global</span>
                        <strong><?php echo e($xp); ?></strong>
                    </div>

                    <div>
                        <span>Accuracy</span>
                        <strong><?php echo e(number_format($accuracy, 1)); ?>%</strong>
                    </div>

                    <div>
                        <span>Spots</span>
                        <strong><?php echo e($total); ?></strong>
                    </div>
                </div>

                <div class="dashboard-next-goal">
                    <span>Siguiente objetivo</span>
                    <strong><?php echo e($nextGoal); ?></strong>
                </div>
            </div>

            <div class="dashboard-quick-panel">
                <span class="quick-panel-title">Ruta ApexCash</span>

                <div class="stage-route-list">
                    <a href="<?php echo e(route('spot-training.index')); ?>" class="stage-route-card is-open">
                        <span>01</span>
                        <div>
                            <strong>Preflop</strong>
                            <small><?php echo e(number_format((float) ($preflopGlobal->accuracy ?? 0), 1)); ?>% accuracy</small>
                        </div>
                        <em>Entrar</em>
                    </a>

                    <?php if($flopUnlocked): ?>
                        <a href="<?php echo e(route('postflop-training.index')); ?>" class="stage-route-card is-open">
                            <span>02</span>
                            <div>
                                <strong>Flop</strong>
                                <small><?php echo e(number_format((float) ($flopGlobal->accuracy ?? 0), 1)); ?>% accuracy</small>
                            </div>
                            <em>Entrar</em>
                        </a>
                    <?php else: ?>
                        <div class="stage-route-card is-locked">
                            <span>02</span>
                            <div>
                                <strong>Flop</strong>
                                <small>Bloqueado por progreso</small>
                            </div>
                            <em>🔒</em>
                        </div>
                    <?php endif; ?>

                    <?php if($turnUnlocked): ?>
                        <a href="<?php echo e(route('postflop-turn.index')); ?>" class="stage-route-card is-open">
                            <span>03</span>
                            <div>
                                <strong>Turn</strong>
                                <small><?php echo e(number_format((float) ($turnGlobal->accuracy ?? 0), 1)); ?>% accuracy</small>
                            </div>
                            <em>Entrar</em>
                        </a>
                    <?php else: ?>
                        <div class="stage-route-card is-locked">
                            <span>03</span>
                            <div>
                                <strong>Turn</strong>
                                <small>Bloqueado por progreso</small>
                            </div>
                            <em>🔒</em>
                        </div>
                    <?php endif; ?>

                    <?php if($riverUnlocked): ?>
                        <a href="<?php echo e(route('postflop-river.index')); ?>" class="stage-route-card is-open">
                            <span>04</span>
                            <div>
                                <strong>River</strong>
                                <small><?php echo e(number_format((float) ($riverGlobal->accuracy ?? 0), 1)); ?>% accuracy</small>
                            </div>
                            <em>Entrar</em>
                        </a>
                    <?php else: ?>
                        <div class="stage-route-card is-locked">
                            <span>04</span>
                            <div>
                                <strong>River</strong>
                                <small>Bloqueado por progreso</small>
                            </div>
                            <em>🔒</em>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if($worstLeak): ?>
                    <?php
                        $worstLeakRoute = $trainingRouteForModule($worstLeak->module);
                    ?>

                    <a href="<?php echo e(route($worstLeakRoute, ['module' => $worstLeak->module])); ?>" class="worst-leak-cta">
                        Practicar peor leak →
                    </a>
                <?php endif; ?>
            </div>
        </section>

        <?php if($criticalLeak): ?>
        <?php
            $criticalErrors = max(0, (int) $criticalLeak->total - (int) $criticalLeak->correct);
        ?>

        <section class="critical-leak-panel">
            <div>
                <span>🚨 LEAK CRÍTICO DETECTADO</span>
                <h2><?php echo e($criticalLeak->module_label); ?></h2>
                <p>
                    Accuracy <?php echo e(number_format((float) $criticalLeak->accuracy, 1)); ?>%.
                    Has fallado <?php echo e($criticalErrors); ?> de <?php echo e($criticalLeak->total); ?> spots en este módulo.
                </p>
            </div>

            <?php
                $criticalLeakRoute = $trainingRouteForModule($criticalLeak->module);
            ?>

            <a href="<?php echo e(route($criticalLeakRoute, ['module' => $criticalLeak->module])); ?>">
                Practicar ahora
            </a>
        </section>
    <?php endif; ?>

        <section class="progress-panel">
            <div>
                <span>Nivel <?php echo e($level); ?></span>
                <strong><?php echo e($xp); ?> XP</strong>
                <p>Siguiente objetivo: <?php echo e($nextGoal); ?> </p>
            </div>
            <div class="xp-bar" aria-label="Progreso de XP">
                <span style="width: <?php echo e($levelPercent); ?>%"></span>
            </div>
        </section>

        <section class="dashboard-stats">
            <article><span>Spots completados</span><strong><?php echo e($total); ?></strong></article>
            <article><span>Precisión global</span><strong><?php echo e(number_format($accuracy, 1)); ?>%</strong></article>
            <article><span>Aciertos</span><strong><?php echo e($correct); ?></strong></article>
            <article><span>Errores</span><strong><?php echo e($wrong); ?></strong></article>
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card">
                <span>Ruta ApexCash</span>
                <h2>Progresión</h2>

                <div class="metric-row">
                    <span>Preflop</span>
                    <strong>
                        <?php echo e(number_format((float) ($preflopGlobal->accuracy ?? 0), 1)); ?>%
                        <?php echo e($flopUnlocked ? '✅' : '🔒'); ?>

                    </strong>
                </div>

                <div class="metric-row">
                    <span>Flop</span>
                    <strong>
                        <?php echo e(number_format((float) ($flopGlobal->accuracy ?? 0), 1)); ?>%
                        <?php echo e($turnUnlocked ? '✅' : '🔒'); ?>

                    </strong>
                </div>

                <div class="metric-row">
                    <span>Turn</span>
                    <strong>
                        <?php echo e(number_format((float) ($turnGlobal->accuracy ?? 0), 1)); ?>%
                        <?php echo e($riverUnlocked ? '✅' : '🔒'); ?>

                    </strong>
                </div>

                <div class="metric-row">
                    <span>River</span>
                    <strong>
                        <?php echo e(number_format((float) ($riverGlobal->accuracy ?? 0), 1)); ?>%
                        <?php echo e($masteryUnlocked ? '🏆' : '🔒'); ?>

                    </strong>
                </div>
            </article>

            <article class="dashboard-card">
                <span>Precisión por etapa</span>
                <h2>Entrenamiento</h2>

                <div class="metric-row"><span>Preflop</span><strong><?php echo e(number_format((float) ($preflopGlobal->accuracy ?? 0), 1)); ?>%</strong></div>
                <div class="metric-row"><span>Flop</span><strong><?php echo e(number_format((float) ($flopGlobal->accuracy ?? 0), 1)); ?>%</strong></div>
                <div class="metric-row"><span>Turn</span><strong><?php echo e(number_format((float) ($turnGlobal->accuracy ?? 0), 1)); ?>%</strong></div>
                <div class="metric-row"><span>River</span><strong><?php echo e(number_format((float) ($riverGlobal->accuracy ?? 0), 1)); ?>%</strong></div>
            </article>
        </section>

        <section class="dashboard-grid">
            <article class="dashboard-card active">
                <span>Mejor módulo</span>
                <h2><?php echo e($bestModule->module_label ?? 'Sin muestra suficiente'); ?></h2>
                <p>
                    <?php if($bestModule): ?>
                        <?php echo e(number_format((float) $bestModule->accuracy, 1)); ?>% de precisión en <?php echo e($bestModule->total_spots); ?> spots.
                    <?php else: ?>
                        Necesitas al menos 10 spots por módulo para detectar fortalezas reales.
                    <?php endif; ?>
                </p>
            </article>

            <article class="dashboard-card danger-card">
                <span>Peor módulo</span>
                <h2>
                    <?php if($worstModule): ?>
                        <?php echo e($worstModule->module_label); ?>

                    <?php elseif($bestModule): ?>
                        Aún no disponible
                    <?php else: ?>
                        Sin muestra suficiente
                    <?php endif; ?>
                </h2>
                <p>
                    <?php if($worstModule): ?>
                        <?php echo e(number_format((float) $worstModule->accuracy, 1)); ?>% de precisión. Este módulo debe entrenarse primero.
                    <?php elseif($bestModule): ?>
                        Practica al menos otro módulo con 10 spots para comparar resultados.
                    <?php else: ?>
                        Necesitas al menos 10 spots en dos módulos distintos para detectar un módulo débil real.
                    <?php endif; ?>
                </p>
            </article>

            <a href="<?php echo e(route('spot-training.index')); ?>" class="dashboard-card active">
                <span>Entrenamiento</span>
                <h2>Spot Training Preflop</h2>
                <p>Open Raise, BB vs BTN, BTN vs 3Bet, 3Bet vs Open, SB vs BTN y BB vs SB.</p>
                <strong>Entrar →</strong>
            </a>
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card table-card">
                <span>Leaks persistentes</span>
                <h2>Módulos débiles</h2>
                <?php $__empty_1 = true; $__currentLoopData = $leaks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leak): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $leakRoute = $trainingRouteForModule($leak->module);
                    ?>
                    <a class="metric-row" href="<?php echo e(route($leakRoute, ['module' => $leak->module])); ?>">
                        <span><?php echo e($leak->module_label); ?></span>
                        <strong><?php echo e(number_format((float) $leak->accuracy, 1)); ?>% · <?php echo e($leak->total); ?> spots</strong>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>Aún no hay suficientes respuestas guardadas.</p>
                <?php endif; ?>
            </article>

            <article class="dashboard-card table-card">
                <span>Peores spots</span>
                <h2>Errores concretos</h2>

                <?php $__empty_1 = true; $__currentLoopData = $worstSpots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $spotRoute = $trainingRouteForModule($spot->module);
                    ?>
                    <a class="metric-row" href="<?php echo e(route($spotRoute, ['spot_id' => $spot->spot_id])); ?>">
                        <span>
                            <?php echo e($spot->hero_cards ?: 'Spot'); ?>

                            ·
                            <?php echo e($spot->concept_label ?: ($spot->spot_title ?: $spot->spot_id)); ?>

                        </span>

                        <strong>
                            <?php echo e(number_format((float) $spot->accuracy, 1)); ?>%
                            ·
                            <?php echo e($spot->wrong); ?> errores
                        </strong>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>Necesitas responder más spots para detectar errores concretos.</p>
                <?php endif; ?>
            </article>

            
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card table-card">
                <span>Estadísticas por módulo</span>
                <h2>Resumen técnico</h2>

                <?php $__empty_1 = true; $__currentLoopData = $moduleStats->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $acc = (float) $stat->accuracy;

                        if ($acc >= 85) {
                            $badgeClass = 'mastery-dominated';
                            $badgeLabel = '🔥 Dominado';
                        } elseif ($acc >= 60) {
                            $badgeClass = 'mastery-progress';
                            $badgeLabel = '⚡ En progreso';
                        } else {
                            $badgeClass = 'mastery-weak';
                            $badgeLabel = '🚨 Necesita trabajo';
                        }
                    ?>

                    <div class="metric-row">
                        <div>
                            <span><?php echo e($stat->module_label); ?></span>
                            <div class="mastery-badge <?php echo e($badgeClass); ?>">
                                <?php echo e($badgeLabel); ?>

                            </div>
                        </div>

                        <strong>
                            <?php echo e(number_format((float) $stat->accuracy, 1)); ?>%
                            ·
                            <?php echo e($stat->total_spots); ?> spots
                        </strong>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>Cuando empieces a entrenar aparecerá aquí la precisión por módulo.</p>
                <?php endif; ?>
            </article>

            <article class="dashboard-card table-card">
                <span>Concept leaks</span>
                <h2>Patrones débiles</h2>

                <?php $__empty_1 = true; $__currentLoopData = $conceptLeaks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $concept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $conceptRoute = $trainingRouteForModule($concept->module);
                    ?>
                    <a
                        class="metric-row"
                        href="<?php echo e(route($conceptRoute, ['concept' => $concept->concept])); ?>"
                    >
                        <span>
                            <?php echo e($concept->concept_label ?: $concept->concept); ?>


                            <?php if($concept->family_label): ?>
                                <small><?php echo e($concept->family_label); ?></small>
                            <?php endif; ?>
                        </span>

                        <strong>
                            <?php echo e(number_format((float) $concept->accuracy, 1)); ?>%
                            ·
                            <?php echo e($concept->wrong); ?> errores
                        </strong>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>Necesitas más respuestas con taxonomía para detectar patrones.</p>
                <?php endif; ?>
            </article>

            <a href="<?php echo e(route('postflop-training.index')); ?>" class="dashboard-card table-card active">
                <span>Nuevo entrenamiento</span>
                <h2>Spot Training Postflop</h2>
                <p>
                    Entrena decisiones en flop: c-bets, check back, defensa vs c-bet,
                    check-raise, value bets, semi-bluffs y boards por textura.
                </p>
                <strong>Entrar →</strong>
            </a>

            <?php if($turnUnlocked): ?>

                <a href="<?php echo e(route('postflop-turn.index')); ?>"
                class="dashboard-card table-card active">

                    <span>Nuevo entrenamiento</span>
                    <h2>Postflop Turn</h2>

                    <p>
                        Entrena second barrel, probe bets,
                        defensa vs barrel, value bets
                        y decisiones críticas de turn.
                    </p>

                    <strong>Entrar →</strong>

                </a>

                <?php else: ?>

                <article class="dashboard-card table-card">

                    <span>Bloqueado</span>
                    <h2>Postflop Turn</h2>

                    <p>
                        Necesitas alcanzar los requisitos
                        de XP y precisión en Flop.
                    </p>

                    <strong>🔒</strong>

                </article>

                <?php endif; ?>

            <?php if($riverUnlocked): ?>

                <a href="<?php echo e(route('postflop-river.index')); ?>"
                class="dashboard-card table-card active">

                    <span>Nuevo entrenamiento</span>
                    <h2>Postflop River</h2>

                    <p>
                        Entrena value bets, thin value,
                        bluff catchers, faroles polarizados
                        y overbets de river.
                    </p>

                    <strong>Entrar →</strong>

                </a>

                <?php else: ?>

                <article class="dashboard-card table-card">

                    <span>Bloqueado</span>
                    <h2>Postflop River</h2>

                    <p>
                        Necesitas alcanzar los requisitos
                        de XP y precisión en Turn.
                    </p>

                    <strong>🔒</strong>

                </article>

                <?php endif; ?>

            <article class="dashboard-card table-card">
                <span>Últimos resultados</span>
                    <h2>Actividad reciente</h2>
                    <?php $__empty_1 = true; $__currentLoopData = $recentResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="metric-row">
                            <span><?php echo e($result->module_label); ?> · <?php echo e($result->selected_action); ?></span>
                            <strong class="grade-pill grade-<?php echo e($result->grade); ?>"><?php echo e(strtoupper($result->grade)); ?></strong>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p>Todavía no has respondido spots.</p>
                    <?php endif; ?>
                </article>
        </section>
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
<?php /**PATH C:\laragon\www\apexcash\resources\views/dashboard.blade.php ENDPATH**/ ?>