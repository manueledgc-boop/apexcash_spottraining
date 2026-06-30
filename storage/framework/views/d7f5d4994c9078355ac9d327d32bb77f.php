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
    ?>

    <main class="dashboard-page">
        <section class="dashboard-hero dashboard-hero-v2">
            <div class="dashboard-hero-main">
                <span class="dashboard-badge"><?php echo e(__('dashboard.badge')); ?></span>

                <h1><?php echo e(__('dashboard.hello', ['name' => auth()->user()->name])); ?></h1>

                <p><?php echo e(__('dashboard.hero_text')); ?></p>

                <div class="dashboard-hero-metrics">
                    <div>
                        <span><?php echo e(__('dashboard.level')); ?></span>
                        <strong><?php echo e($level); ?></strong>
                    </div>

                    <div>
                        <span><?php echo e(__('dashboard.global_xp')); ?></span>
                        <strong><?php echo e($xp); ?></strong>
                    </div>

                    <div>
                        <span><?php echo e(__('dashboard.accuracy')); ?></span>
                        <strong><?php echo e(number_format($accuracy, 1)); ?>%</strong>
                    </div>

                    <div>
                        <span><?php echo e(__('dashboard.spots')); ?></span>
                        <strong><?php echo e($total); ?></strong>
                    </div>
                </div>

                <div class="dashboard-next-goal">
                    <span><?php echo e(__('dashboard.next_goal')); ?></span>
                    <strong><?php echo e($nextGoal); ?></strong>
                </div>
            </div>

            <div class="dashboard-quick-panel">
                <span class="quick-panel-title"><?php echo e(__('dashboard.apexcash_route')); ?></span>

                <div class="stage-route-list">
                    <a href="<?php echo e(route('spot-training.index')); ?>" class="stage-route-card is-open">
                        <span>01</span>
                        <div>
                            <strong><?php echo e(__('dashboard.preflop')); ?></strong>
                            <small><?php echo e(number_format((float) ($preflopGlobal->accuracy ?? 0), 1)); ?>% <?php echo e(__('dashboard.accuracy_lower')); ?></small>
                        </div>
                        <em><?php echo e(__('dashboard.enter')); ?></em>
                    </a>

                    <?php if($flopUnlocked ?? false): ?>
                        <a href="<?php echo e(route('postflop-training.index')); ?>" class="stage-route-card is-open">
                            <span>02</span>
                            <div>
                                <strong><?php echo e(__('dashboard.flop')); ?></strong>
                                <small><?php echo e(number_format((float) ($flopGlobal->accuracy ?? 0), 1)); ?>% <?php echo e(__('dashboard.accuracy_lower')); ?></small>
                            </div>
                            <em><?php echo e(__('dashboard.enter')); ?></em>
                        </a>
                    <?php else: ?>
                        <div class="stage-route-card is-locked">
                            <span>02</span>
                            <div>
                                <strong><?php echo e(__('dashboard.flop')); ?></strong>
                                <small><?php echo e(__('dashboard.locked_by_progress')); ?></small>
                            </div>
                            <em>🔒</em>
                        </div>
                    <?php endif; ?>

                    <?php if($turnUnlocked ?? false): ?>
                        <a href="<?php echo e(route('postflop-turn.index')); ?>" class="stage-route-card is-open">
                            <span>03</span>
                            <div>
                                <strong><?php echo e(__('dashboard.turn')); ?></strong>
                                <small><?php echo e(number_format((float) ($turnGlobal->accuracy ?? 0), 1)); ?>% <?php echo e(__('dashboard.accuracy_lower')); ?></small>
                            </div>
                            <em><?php echo e(__('dashboard.enter')); ?></em>
                        </a>
                    <?php else: ?>
                        <div class="stage-route-card is-locked">
                            <span>03</span>
                            <div>
                                <strong><?php echo e(__('dashboard.turn')); ?></strong>
                                <small><?php echo e(__('dashboard.locked_by_progress')); ?></small>
                            </div>
                            <em>🔒</em>
                        </div>
                    <?php endif; ?>

                    <?php if($riverUnlocked ?? false): ?>
                        <a href="<?php echo e(route('postflop-river.index')); ?>" class="stage-route-card is-open">
                            <span>04</span>
                            <div>
                                <strong><?php echo e(__('dashboard.river')); ?></strong>
                                <small><?php echo e(number_format((float) ($riverGlobal->accuracy ?? 0), 1)); ?>% <?php echo e(__('dashboard.accuracy_lower')); ?></small>
                            </div>
                            <em><?php echo e(__('dashboard.enter')); ?></em>
                        </a>
                    <?php else: ?>
                        <div class="stage-route-card is-locked">
                            <span>04</span>
                            <div>
                                <strong><?php echo e(__('dashboard.river')); ?></strong>
                                <small><?php echo e(__('dashboard.locked_by_progress')); ?></small>
                            </div>
                            <em>🔒</em>
                        </div>
                    <?php endif; ?>

                    <?php if($masteryUnlocked): ?>
                        <a href="<?php echo e(route('mastery-training.index')); ?>" class="stage-route-card is-open">
                            <span>05</span>
                            <div>
                                <strong><?php echo e(__('dashboard.mastery_full')); ?></strong>
                                <small>
                                    <?php echo e(number_format((float) ($masteryGlobal->accuracy ?? 0), 1)); ?>% <?php echo e(__('dashboard.accuracy_lower')); ?>

                                </small>
                            </div>
                            <em><?php echo e(__('dashboard.enter')); ?></em>
                        </a>
                    <?php else: ?>
                        <div class="stage-route-card is-locked">
                            <span>05</span>
                            <div>
                                <strong><?php echo e(__('dashboard.mastery_full')); ?></strong>
                                <small><?php echo e(__('dashboard.locked_by_progress')); ?></small>
                            </div>
                            <em>🔒</em>
                        </div>
                    <?php endif; ?>

                    <?php if($certificationUnlocked ?? false): ?>
                        <a href="<?php echo e(route('certification.index')); ?>" class="stage-route-card is-open">
                            <span>06</span>
                            <div>
                                <strong><?php echo e(__('dashboard.certification')); ?></strong>
                                <small><?php echo e(__('dashboard.final_exam_available')); ?></small>
                            </div>
                            <em><?php echo e(__('dashboard.enter')); ?></em>
                        </a>
                    <?php else: ?>
                        <div class="stage-route-card is-locked">
                            <span>06</span>
                            <div>
                                <strong><?php echo e(__('dashboard.certification')); ?></strong>
                                <small><?php echo e(__('dashboard.locked_by_progress')); ?></small>
                            </div>
                            <em>🔒</em>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </section>

        <?php if($criticalLeak): ?>
        <?php
            $criticalErrors = max(0, (int) $criticalLeak->total - (int) $criticalLeak->correct);
        ?>

        <section class="critical-leak-panel">
            <div>
                <span><?php echo e(__('dashboard.critical_leak_detected')); ?></span>
                <h2><?php echo e($criticalLeak->module_label); ?></h2>
                <p>
                    <?php echo e(__('dashboard.critical_leak_text', [
                        'accuracy' => number_format((float) $criticalLeak->accuracy, 1),
                        'errors' => $criticalErrors,
                        'total' => $criticalLeak->total,
                    ])); ?>

                </p>
            </div>

            <?php
                $criticalLeakRoute = $routeForModule($criticalLeak->module);
            ?>

            <a href="<?php echo e(route($criticalLeakRoute, ['module' => $criticalLeak->module])); ?>">
                <?php echo e(__('dashboard.practice_now')); ?>

            </a>
        </section>
    <?php endif; ?>

        <section class="progress-panel">
            <div>
                <span><?php echo e(__('dashboard.level_with_number', ['level' => $level])); ?></span>
                <strong><?php echo e($xp); ?> XP</strong>
                <p><?php echo e(__('dashboard.next_goal_with_value', ['goal' => $nextGoal])); ?></p>
            </div>
            <div class="xp-bar" aria-label="<?php echo e(__('dashboard.xp_progress_aria')); ?>">
                <span style="width: <?php echo e($levelPercent); ?>%"></span>
            </div>
        </section>

        <section class="dashboard-stats">
            <article><span><?php echo e(__('dashboard.completed_spots')); ?></span><strong><?php echo e($total); ?></strong></article>
            <article><span><?php echo e(__('dashboard.global_accuracy')); ?></span><strong><?php echo e(number_format($accuracy, 1)); ?>%</strong></article>
            <article><span><?php echo e(__('dashboard.correct')); ?></span><strong><?php echo e($correct); ?></strong></article>
            <article><span><?php echo e(__('dashboard.errors')); ?></span><strong><?php echo e($wrong); ?></strong></article>
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card">
                <span><?php echo e(__('dashboard.apexcash_route')); ?></span>
                <h2><?php echo e(__('dashboard.progression')); ?></h2>

                <div class="metric-row">
                    <span><?php echo e(__('dashboard.preflop')); ?></span>
                    <strong>
                        <?php echo e(number_format((float) ($preflopGlobal->accuracy ?? 0), 1)); ?>%
                        <?php echo e($flopUnlocked ? '✅' : '⏳'); ?>

                    </strong>
                </div>

                <div class="metric-row">
                    <span><?php echo e(__('dashboard.flop')); ?></span>
                    <strong>
                        <?php echo e(number_format((float) ($flopGlobal->accuracy ?? 0), 1)); ?>%
                        <?php if(!$flopUnlocked): ?>
                            🔒
                        <?php elseif(!$turnUnlocked): ?>
                            ⏳
                        <?php else: ?>
                            ✅
                        <?php endif; ?>
                    </strong>
                </div>

                <div class="metric-row">
                    <span><?php echo e(__('dashboard.turn')); ?></span>
                    <strong>
                        <?php echo e(number_format((float) ($turnGlobal->accuracy ?? 0), 1)); ?>%
                        <?php if(!$turnUnlocked): ?>
                            🔒
                        <?php elseif(!$riverUnlocked): ?>
                            ⏳
                        <?php else: ?>
                            ✅
                        <?php endif; ?>
                    </strong>
                </div>

                <div class="metric-row">
                    <span><?php echo e(__('dashboard.river')); ?></span>
                    <strong>
                        <?php echo e(number_format((float) ($riverGlobal->accuracy ?? 0), 1)); ?>%
                        <?php if(!$riverUnlocked): ?>
                            🔒
                        <?php elseif(!$masteryUnlocked): ?>
                            ⏳
                        <?php else: ?>
                            ✅
                        <?php endif; ?>
                    </strong>
                </div>

                <div class="metric-row">
                    <span><?php echo e(__('dashboard.mastery')); ?></span>
                    <strong>
                        <?php echo e(number_format((float) ($masteryGlobal->accuracy ?? 0), 1)); ?>%
                        <?php if(!$masteryUnlocked): ?>
                            🔒
                        <?php elseif(!($certificationUnlocked ?? false)): ?>
                            ⏳
                        <?php else: ?>
                            🎓
                        <?php endif; ?>
                    </strong>
                </div>

                <div class="metric-row">
                    <span><?php echo e(__('dashboard.certification_short')); ?></span>
                    <strong>
                        <?php if($certificationUnlocked ?? false): ?>
                            <?php echo e(__('dashboard.available')); ?> 🎓
                        <?php else: ?>
                            🔒
                        <?php endif; ?>
                    </strong>
                </div>
            </article>

            <article class="dashboard-card">
                <span><?php echo e(__('dashboard.accuracy_by_stage')); ?></span>
                <h2><?php echo e(__('dashboard.training')); ?></h2>

                <div class="metric-row"><span><?php echo e(__('dashboard.preflop')); ?></span><strong><?php echo e(number_format((float) ($preflopGlobal->accuracy ?? 0), 1)); ?>%</strong></div>
                <div class="metric-row"><span><?php echo e(__('dashboard.flop')); ?></span><strong><?php echo e(number_format((float) ($flopGlobal->accuracy ?? 0), 1)); ?>%</strong></div>
                <div class="metric-row"><span><?php echo e(__('dashboard.turn')); ?></span><strong><?php echo e(number_format((float) ($turnGlobal->accuracy ?? 0), 1)); ?>%</strong></div>
                <div class="metric-row"><span><?php echo e(__('dashboard.river')); ?></span><strong><?php echo e(number_format((float) ($riverGlobal->accuracy ?? 0), 1)); ?>%</strong></div>
            </article>
        </section>

        <section class="dashboard-grid">
            <article class="dashboard-card active">
                <span><?php echo e(__('dashboard.best_module')); ?></span>
                <h2><?php echo e($bestModule->module_label ?? __('dashboard.not_enough_sample')); ?></h2>
                <p>
                    <?php if($bestModule): ?>
                        <?php echo e(__('dashboard.best_module_text', [
                            'accuracy' => number_format((float) $bestModule->accuracy, 1),
                            'spots' => $bestModule->total_spots,
                        ])); ?>

                    <?php else: ?>
                        <?php echo e(__('dashboard.need_10_spots_strengths')); ?>

                    <?php endif; ?>
                </p>
            </article>

            <article class="dashboard-card danger-card">
                <span><?php echo e(__('dashboard.module_to_improve')); ?></span>
                <h2>
                    <?php if($worstModule): ?>
                        <?php echo e($worstModule->module_label); ?>

                    <?php elseif($bestModule): ?>
                        <?php echo e(__('dashboard.not_available_yet')); ?>

                    <?php else: ?>
                        <?php echo e(__('dashboard.not_enough_sample')); ?>

                    <?php endif; ?>
                </h2>
                <p>
                    <?php if($worstModule): ?>
                        <?php echo e(__('dashboard.worst_module_text', [
                            'accuracy' => number_format((float) $worstModule->accuracy, 1),
                        ])); ?>

                    <?php elseif($bestModule): ?>
                        <?php echo e(__('dashboard.practice_another_module')); ?>

                    <?php else: ?>
                        <?php echo e(__('dashboard.need_two_modules')); ?>

                    <?php endif; ?>
                </p>
            </article>

            <a href="<?php echo e(route('spot-training.index')); ?>" class="dashboard-card active">
                <span><?php echo e(__('dashboard.training')); ?></span>
                <h2><?php echo e(__('dashboard.preflop_training_title')); ?></h2>
                <p><?php echo e(__('dashboard.preflop_training_text')); ?></p>
                <strong><?php echo e(__('dashboard.enter_arrow')); ?></strong>
            </a>
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card table-card">
                <span><?php echo e(__('dashboard.persistent_leaks')); ?></span>
                <h2><?php echo e(__('dashboard.weak_modules')); ?></h2>
                <?php $__empty_1 = true; $__currentLoopData = $leaks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leak): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $leakRoute = $routeForModule($leak->module);
                    ?>
                    <a class="metric-row" href="<?php echo e(route($leakRoute, ['module' => $leak->module])); ?>">
                        <span><?php echo e($leak->module_label); ?></span>
                        <strong><?php echo e(number_format((float) $leak->accuracy, 1)); ?>% · <?php echo e($leak->total); ?> <?php echo e(__('dashboard.spots_lower')); ?></strong>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p><?php echo e(__('dashboard.not_enough_answers')); ?></p>
                <?php endif; ?>
            </article>

            <article class="dashboard-card table-card">
                <span><?php echo e(__('dashboard.worst_spots')); ?></span>
                <h2><?php echo e(__('dashboard.concrete_errors')); ?></h2>

                <?php $__empty_1 = true; $__currentLoopData = $worstSpots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $spotRoute = $routeForModule($spot->module);
                    ?>
                    <a class="metric-row" href="<?php echo e(route($spotRoute, ['spot_id' => $spot->spot_id])); ?>">
                        <span>
                            <?php echo e($spot->hero_cards ?: __('dashboard.spot')); ?>

                            ·
                            <?php echo e($spot->concept_label ?: ($spot->spot_title ?: $spot->spot_id)); ?>

                        </span>

                        <strong>
                            <?php echo e(number_format((float) $spot->accuracy, 1)); ?>%
                            ·
                            <?php echo e($spot->wrong); ?> <?php echo e(__('dashboard.errors_lower')); ?>

                        </strong>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p><?php echo e(__('dashboard.need_more_spots_for_errors')); ?></p>
                <?php endif; ?>
            </article>
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card table-card">
                <span><?php echo e(__('dashboard.stats_by_module')); ?></span>
                <h2><?php echo e(__('dashboard.technical_summary')); ?></h2>

                <?php $__empty_1 = true; $__currentLoopData = $moduleStats->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $acc = (float) $stat->accuracy;

                        if ($acc >= 85) {
                            $badgeClass = 'mastery-dominated';
                            $badgeLabel = __('dashboard.status_dominated');
                        } elseif ($acc >= 60) {
                            $badgeClass = 'mastery-progress';
                            $badgeLabel = __('dashboard.status_progress');
                        } else {
                            $badgeClass = 'mastery-weak';
                            $badgeLabel = __('dashboard.status_weak');
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
                            <?php echo e($stat->total_spots); ?> <?php echo e(__('dashboard.spots_lower')); ?>

                        </strong>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p><?php echo e(__('dashboard.module_accuracy_empty')); ?></p>
                <?php endif; ?>
            </article>

            <article class="dashboard-card table-card">
                <span><?php echo e(__('dashboard.concept_leaks')); ?></span>
                <h2><?php echo e(__('dashboard.weak_patterns')); ?></h2>

                <?php $__empty_1 = true; $__currentLoopData = $conceptLeaks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $concept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $conceptRoute = $routeForModule($concept->module);
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
                            <?php echo e($concept->wrong); ?> <?php echo e(__('dashboard.errors_lower')); ?>

                        </strong>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p><?php echo e(__('dashboard.taxonomy_empty')); ?></p>
                <?php endif; ?>
            </article>

            <a href="<?php echo e(route('postflop-training.index')); ?>" class="dashboard-card table-card active">
                <span><?php echo e(__('dashboard.new_training')); ?></span>
                <h2><?php echo e(__('dashboard.postflop_training_title')); ?></h2>
                <p><?php echo e(__('dashboard.postflop_training_text')); ?></p>
                <strong><?php echo e(__('dashboard.enter_arrow')); ?></strong>
            </a>

            <?php if($turnUnlocked): ?>

                <a href="<?php echo e(route('postflop-turn.index')); ?>"
                class="dashboard-card table-card active">

                    <span><?php echo e(__('dashboard.new_training')); ?></span>
                    <h2><?php echo e(__('dashboard.postflop_turn_title')); ?></h2>

                    <p><?php echo e(__('dashboard.postflop_turn_text')); ?></p>

                    <strong><?php echo e(__('dashboard.enter_arrow')); ?></strong>

                </a>

                <?php else: ?>

                <article class="dashboard-card table-card">

                    <span><?php echo e(__('dashboard.locked')); ?></span>
                    <h2><?php echo e(__('dashboard.postflop_turn_title')); ?></h2>

                    <p><?php echo e(__('dashboard.unlock_turn_text')); ?></p>

                    <strong>🔒</strong>

                </article>

                <?php endif; ?>

            <?php if($riverUnlocked): ?>

                <a href="<?php echo e(route('postflop-river.index')); ?>"
                class="dashboard-card table-card active">

                    <span><?php echo e(__('dashboard.new_training')); ?></span>
                    <h2><?php echo e(__('dashboard.postflop_river_title')); ?></h2>

                    <p><?php echo e(__('dashboard.postflop_river_text')); ?></p>

                    <strong><?php echo e(__('dashboard.enter_arrow')); ?></strong>

                </a>

                <?php else: ?>

                <article class="dashboard-card table-card">

                    <span><?php echo e(__('dashboard.locked')); ?></span>
                    <h2><?php echo e(__('dashboard.postflop_river_title')); ?></h2>

                    <p><?php echo e(__('dashboard.unlock_river_text')); ?></p>

                    <strong>🔒</strong>

                </article>

                <?php endif; ?>

                <?php if($masteryUnlocked ?? false): ?>

                    <a href="<?php echo e(route('mastery-training.index')); ?>"
                    class="dashboard-card table-card active">

                        <span><?php echo e(__('dashboard.advanced_training')); ?></span>

                        <h2><?php echo e(__('dashboard.mastery')); ?></h2>

                        <p><?php echo e(__('dashboard.mastery_text')); ?></p>

                        <strong><?php echo e(__('dashboard.enter_arrow')); ?></strong>

                    </a>

                <?php else: ?>

                    <article class="dashboard-card table-card">

                        <span><?php echo e(__('dashboard.locked')); ?></span>

                        <h2><?php echo e(__('dashboard.mastery')); ?></h2>

                        <p><?php echo e(__('dashboard.unlock_mastery_text')); ?></p>

                        <strong>🔒</strong>

                    </article>

                <?php endif; ?>

                <?php if($certificationUnlocked ?? false): ?>

                    <a href="<?php echo e(route('certification.index')); ?>"
                    class="dashboard-card table-card active">

                        <span><?php echo e(__('dashboard.final_exam')); ?></span>

                        <h2><?php echo e(__('dashboard.certification')); ?></h2>

                        <p><?php echo e(__('dashboard.certification_text')); ?></p>

                        <strong><?php echo e(__('dashboard.enter_arrow')); ?></strong>

                    </a>

                <?php else: ?>

                    <article class="dashboard-card table-card">

                        <span><?php echo e(__('dashboard.locked')); ?></span>

                        <h2><?php echo e(__('dashboard.certification')); ?></h2>

                        <p><?php echo e(__('dashboard.unlock_certification_text')); ?></p>

                        <strong>🔒</strong>

                    </article>

                <?php endif; ?>

            <article class="dashboard-card table-card">
                <span><?php echo e(__('dashboard.latest_results')); ?></span>
                    <h2><?php echo e(__('dashboard.recent_activity')); ?></h2>
                    <?php $__empty_1 = true; $__currentLoopData = $recentResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="metric-row">
                            <span><?php echo e($result->module_label); ?> · <?php echo e($result->selected_action); ?></span>
                            <strong class="grade-pill grade-<?php echo e($result->grade); ?>"><?php echo e(strtoupper($result->grade)); ?></strong>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p><?php echo e(__('dashboard.no_spots_answered_yet')); ?></p>
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