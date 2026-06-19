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
    <link href="<?php echo e(asset('assets/css/certification-index.css')); ?>" rel="stylesheet">

    <main class="cert-page">
        <div class="cert-shell">
            <?php if(session('error')): ?>
                <div class="cert-alert cert-alert-error">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="cert-alert cert-alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <section class="cert-hero">
                <div class="cert-hero-content">
                    <span class="cert-kicker"><?php echo e(__('certification.kicker')); ?></span>
                    <h1><?php echo e(__('certification.hero_title')); ?></h1>
                    <p>
                        <?php echo __('certification.hero_text', [
                            'stages' => __('certification.hero_stages'),
                        ]); ?>

                    </p>
                    <p class="cert-hero-note">
                        <?php echo e(__('certification.hero_note')); ?>

                    </p>
                </div>

                <div class="cert-status-card">
                    <div class="cert-status-icon">
                        <?php if($passedAttempt): ?>
                            🎓
                        <?php elseif(!$certificationUnlocked): ?>
                            🔒
                        <?php elseif($activeAttempt): ?>
                            ⏳
                        <?php else: ?>
                            ✅
                        <?php endif; ?>
                    </div>
                    <div class="cert-status-label"><?php echo e(__('certification.status')); ?></div>
                    <div class="cert-status-value">
                        <?php if($passedAttempt): ?>
                            <?php echo e(__('certification.status_passed')); ?>

                        <?php elseif(!$certificationUnlocked): ?>
                            <?php echo e(__('certification.status_locked')); ?>

                        <?php elseif($activeAttempt): ?>
                            <?php echo e(__('certification.status_active')); ?>

                        <?php else: ?>
                            <?php echo e(__('certification.status_available')); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <?php
                $stages = [
                    [__('certification.stage_preflop'), '✅'],
                    [__('certification.stage_flop'), '✅'],
                    [__('certification.stage_turn'), '✅'],
                    [__('certification.stage_river'), '✅'],
                    [__('certification.stage_mastery'), '✅'],
                    [__('certification.stage_certification'), $passedAttempt ? '🎓' : ($certificationUnlocked ? '⏳' : '🔒'), true],
                ];
            ?>

            <section class="cert-route-card">
                <div class="cert-section-head">
                    <span><?php echo e(__('certification.route_title')); ?></span>
                    <strong><?php echo e(__('certification.route_subtitle')); ?></strong>
                </div>

                <div class="cert-route">
                    <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $label = $stage[0];
                            $icon = $stage[1];
                            $isFinal = $stage[2] ?? false;
                        ?>

                        <div class="cert-route-step <?php echo e($isFinal ? 'is-final' : ''); ?>">
                            <div class="cert-route-icon"><?php echo e($icon); ?></div>
                            <div class="cert-route-title"><?php echo e($label); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>

            <section class="cert-info-grid">
                <article class="cert-info-card cert-exam-card">
                    <div class="cert-card-icon">🧩</div>
                    <h2><?php echo e(__('certification.exam_structure')); ?></h2>
                    <div class="cert-big-number">75</div>
                    <p><?php echo e(__('certification.total_questions')); ?></p>

                    <div class="cert-block-list">
                        <span>15 <?php echo e(__('certification.stage_preflop')); ?></span>
                        <span>15 <?php echo e(__('certification.stage_flop')); ?></span>
                        <span>15 <?php echo e(__('certification.stage_turn')); ?></span>
                        <span>15 <?php echo e(__('certification.stage_river')); ?></span>
                        <span>15 <?php echo e(__('certification.stage_mastery')); ?></span>
                    </div>
                </article>

                <article class="cert-info-card">
                    <div class="cert-card-icon">🎯</div>
                    <h2><?php echo e(__('certification.passing_requirements')); ?></h2>

                    <div class="cert-requirements">
                        <div>
                            <strong>75%</strong>
                            <span><?php echo e(__('certification.global_minimum')); ?></span>
                        </div>
                        <div>
                            <strong>60%</strong>
                            <span><?php echo e(__('certification.block_minimum')); ?></span>
                        </div>
                    </div>

                    <p class="cert-muted">
                        <?php echo e(__('certification.block_warning')); ?>

                    </p>
                </article>

                <article class="cert-info-card">
                    <div class="cert-card-icon">⏱️</div>
                    <h2><?php echo e(__('certification.exam_rules')); ?></h2>

                    <ul class="cert-rules">
                        <li><?php echo e(__('certification.rule_60_minutes')); ?></li>
                        <li><?php echo e(__('certification.rule_timer_visible')); ?></li>
                        <li><?php echo e(__('certification.rule_answer_required')); ?></li>
                        <li><?php echo e(__('certification.rule_can_correct')); ?></li>
                        <li><?php echo e(__('certification.rule_no_back')); ?></li>
                        <li><?php echo e(__('certification.rule_no_pause')); ?></li>
                        <li><?php echo e(__('certification.rule_no_feedback')); ?></li>
                    </ul>
                </article>
            </section>

            <section class="cert-action-card">
                <?php if(!$certificationUnlocked): ?>
                    <div class="cert-action-center">
                        <div class="cert-action-icon">🔒</div>
                        <h2><?php echo e(__('certification.locked_title')); ?></h2>
                        <p><?php echo e(__('certification.locked_text')); ?></p>
                    </div>
                <?php elseif($latestAttempt && $latestAttempt->isLockedForRetry()): ?>
                    <div class="cert-action-center">
                        <div class="cert-action-icon">⏳</div>
                        <h2><?php echo e(__('certification.retry_locked_title')); ?></h2>
                        <p><?php echo e(__('certification.retry_locked_text', ['date' => $latestAttempt->next_attempt_at->format('d/m/Y H:i')])); ?></p>
                    </div>
                <?php elseif($activeAttempt): ?>
                    <div class="cert-action-split">
                        <div>
                            <span class="cert-kicker"><?php echo e(__('certification.active_kicker')); ?></span>
                            <h2><?php echo e(__('certification.active_title')); ?></h2>
                            <p><?php echo e(__('certification.active_text')); ?></p>
                        </div>
                        <a href="<?php echo e(route('certification.exam', $activeAttempt)); ?>" class="cert-main-button">
                            <?php echo e(__('certification.continue_exam')); ?>

                        </a>
                    </div>
                <?php else: ?>
                    <div class="cert-action-split">
                        <div>
                            <span class="cert-kicker"><?php echo e(__('certification.before_start')); ?></span>
                            <h2><?php echo e(__('certification.start_title')); ?></h2>
                            <p>
                                <?php echo e(__('certification.start_text')); ?>

                            </p>
                            <p class="cert-muted">
                                <?php echo e(__('certification.possible_results')); ?>

                            </p>
                        </div>

                        <form method="POST" action="<?php echo e(route('certification.start')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="cert-main-button">
                                <?php echo e(__('certification.start_button')); ?>

                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </section>

            <?php if($passedAttempt): ?>
                <section class="cert-passed-card">
                    <div class="cert-passed-icon">🎓</div>
                    <div>
                        <h3><?php echo e(__('certification.passed_title')); ?></h3>
                        <p><?php echo e(__('certification.result')); ?>: <strong><?php echo e($passedAttempt->resultBadge()); ?></strong></p>
                        <p><?php echo e(__('certification.code')); ?>: <strong><?php echo e($passedAttempt->certificate_code); ?></strong></p>
                    </div>
                </section>
            <?php endif; ?>

            <section class="cert-legal-card">
                <strong><?php echo e(__('certification.legal_note_label')); ?></strong>
                <?php echo e(__('certification.legal_note_text')); ?>

            </section>
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
<?php /**PATH C:\laragon\www\apexcash\resources\views/certification/index.blade.php ENDPATH**/ ?>