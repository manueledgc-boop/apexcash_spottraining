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

    <main class="hand-lab-page">
        <section class="hand-lab-header">
            <div>
                <span class="hand-lab-kicker"><?php echo e(__('hand_lab.my_hand_reviews_kicker')); ?></span>
                <h1><?php echo e(__('hand_lab.my_hand_reviews')); ?></h1>
                <p><?php echo e(__('hand_lab.my_hand_reviews_subtitle')); ?></p>
            </div>

            <div class="hand-lab-header-actions">
                <a href="<?php echo e(route('hand-lab.index')); ?>" class="ghost-link"><?php echo e(__('hand_lab.back_to_hand_lab')); ?></a>
            </div>
        </section>

        <section class="hand-review-list">
            <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $isPending = $review->review_status === 'pending';
                    $isApproved = $review->review_status === 'approved';
                    $statusLabel = $isPending
                        ? __('hand_lab.status_pending')
                        : ($isApproved ? __('hand_lab.status_reviewed') : __('hand_lab.status_not_approved'));
                ?>

                <a href="<?php echo e(route('hand-lab.reviews.show', $review)); ?>" class="hand-review-card">
                    <div>
                        <span class="lab-box-kicker"><?php echo e($statusLabel); ?></span>
                        <h2><?php echo e($review->spot_type ?: __('hand_lab.lab_spot')); ?></h2>
                        <p>
                            <?php echo e($review->hero_position); ?> vs <?php echo e($review->villain_position); ?> · <?php echo e(strtoupper($review->street)); ?> ·
                            <?php echo e(__('hand_lab.your_decision')); ?>: <?php echo e($review->selected_action ?: '--'); ?>

                        </p>
                    </div>

                    <div class="hand-review-status <?php echo e($isPending ? 'is-pending' : ($isApproved ? 'is-approved' : 'is-rejected')); ?>">
                        <?php echo e($statusLabel); ?>

                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <article class="lab-box hand-review-empty">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.my_hand_reviews')); ?></span>
                    <h2><?php echo e(__('hand_lab.no_reviews_title')); ?></h2>
                    <p><?php echo e(__('hand_lab.no_reviews_text')); ?></p>
                    <a href="<?php echo e(route('hand-lab.index')); ?>" class="primary-lab-btn hand-review-empty-btn"><?php echo e(__('hand_lab.create_another_spot')); ?></a>
                </article>
            <?php endif; ?>
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
<?php /**PATH C:\laragon\www\apexcash\resources\views/hand-lab/reviews.blade.php ENDPATH**/ ?>