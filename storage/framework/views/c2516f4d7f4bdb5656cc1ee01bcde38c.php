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

    <?php
        $isPending = $spot->review_status === 'pending';
        $isApproved = $spot->review_status === 'approved';
        $isRejected = $spot->review_status === 'rejected';
        $sourceLabel = $isApproved
            ? __('hand_lab.source_community_library')
            : __('hand_lab.pending_review_source');
    ?>

    <main class="hand-lab-page">
        <section class="hand-lab-header">
            <div>
                <span class="hand-lab-kicker"><?php echo e(__('hand_lab.my_hand_reviews_kicker')); ?></span>
                <h1><?php echo e($spot->spot_type ?: __('hand_lab.lab_spot')); ?></h1>
                <p><?php echo e($spot->hero_position); ?> vs <?php echo e($spot->villain_position); ?> · <?php echo e(strtoupper($spot->street)); ?></p>
            </div>

            <div class="hand-lab-header-actions">
                <a href="<?php echo e(route('hand-lab.reviews.index')); ?>" class="ghost-link"><?php echo e(__('hand_lab.back_to_reviews')); ?></a>
            </div>
        </section>

        <section class="hand-review-detail-layout">
            <article class="lab-box hand-review-detail-card">
                <span class="lab-box-kicker">
                    <?php if($isPending): ?>
                        <?php echo e(__('hand_lab.status_pending')); ?>

                    <?php elseif($isApproved): ?>
                        <?php echo e(__('hand_lab.status_reviewed')); ?>

                    <?php else: ?>
                        <?php echo e(__('hand_lab.status_not_approved')); ?>

                    <?php endif; ?>
                </span>

                <?php if($isPending): ?>
                    <h2><?php echo e(__('hand_lab.review_pending_title')); ?></h2>
                    <p><?php echo e(__('hand_lab.review_pending_text')); ?></p>
                <?php elseif($isApproved): ?>
                    <h2><?php echo e(__('hand_lab.review_completed_title')); ?></h2>

                    <div class="hand-review-result-grid">
                        <div><strong><?php echo e(__('hand_lab.your_decision')); ?></strong><span><?php echo e($spot->selected_action ?: '--'); ?></span></div>
                        <div><strong><?php echo e(__('hand_lab.best_action')); ?></strong><span><?php echo e($spot->best_action ?: '--'); ?></span></div>
                    </div>

                    <?php if($spot->gto_explanation): ?>
                        <h3>GTO</h3>
                        <p><?php echo e($spot->gto_explanation); ?></p>
                    <?php endif; ?>

                    <?php if($spot->exploit_explanation): ?>
                        <h3><?php echo e(__('hand_lab.micro_limits')); ?></h3>
                        <p><?php echo e($spot->exploit_explanation); ?></p>
                    <?php endif; ?>

                    <?php if($spot->leak_label): ?>
                        <h3><?php echo e(__('hand_lab.leak_detected')); ?></h3>
                        <p><?php echo e($spot->leak_label); ?></p>
                    <?php endif; ?>

                    <div class="lab-warning">
                        <strong><?php echo e(__('hand_lab.source')); ?>:</strong> <?php echo e($sourceLabel); ?>

                    </div>
                <?php elseif($isRejected): ?>
                    <h2><?php echo e(__('hand_lab.review_not_approved_title')); ?></h2>
                    <p><?php echo e(__('hand_lab.review_not_approved_text')); ?></p>

                    <div class="lab-warning">
                        <strong><?php echo e(__('hand_lab.reason')); ?>:</strong>
                        <?php echo e($spot->review_note ?: $spot->review_reason ?: __('hand_lab.reason_insufficient_information')); ?>

                    </div>
                <?php endif; ?>
            </article>

            <article class="lab-box hand-review-detail-card">
                <span class="lab-box-kicker"><?php echo e(__('hand_lab.previous_action')); ?></span>
                <h2><?php echo e(__('hand_lab.action_history')); ?></h2>
                <ol class="lab-action-list">
                    <?php $__currentLoopData = ($spot->action_history ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php echo e(strtoupper($action['street'] ?? '')); ?> ·
                            <?php echo e($action['actor'] ?? '--'); ?>

                            <?php echo e(ucfirst(str_replace('_', ' ', $action['type'] ?? '--'))); ?>

                            <?php if(($action['size'] ?? 0) > 0): ?>
                                <?php echo e(rtrim(rtrim(number_format((float) $action['size'], 1), '0'), '.')); ?> BB
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
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
<?php /**PATH C:\laragon\www\apexcash\resources\views/hand-lab/review-show.blade.php ENDPATH**/ ?>