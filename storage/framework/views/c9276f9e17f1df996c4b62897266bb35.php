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
                <span class="hand-lab-kicker"><?php echo e(__('hand_lab.admin_kicker')); ?></span>
                <h1><?php echo e(__('hand_lab.admin_pending_reviews')); ?></h1>
                <p><?php echo e(__('hand_lab.admin_pending_reviews_subtitle')); ?></p>
            </div>

            <div class="hand-lab-header-actions">
                <a href="<?php echo e(route('hand-lab.index')); ?>" class="ghost-link"><?php echo e(__('hand_lab.back_to_hand_lab')); ?></a>
            </div>
        </section>

        <?php if(session('status')): ?>
            <section class="hand-review-list">
                <article class="lab-box admin-review-alert">
                    <?php echo e(session('status')); ?>

                </article>
            </section>
        <?php endif; ?>

        <section class="hand-review-list">
            <?php $__empty_1 = true; $__currentLoopData = $pendingSpots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('admin.hand-lab.show', $spot)); ?>" class="hand-review-card">
                    <div>
                        <span class="lab-box-kicker"><?php echo e(__('hand_lab.status_pending')); ?></span>
                        <h2><?php echo e($spot->spot_type ?: __('hand_lab.lab_spot')); ?></h2>
                        <p>
                            #<?php echo e($spot->id); ?> ·
                            <?php echo e($spot->hero_position); ?> vs <?php echo e($spot->villain_position); ?> ·
                            <?php echo e(strtoupper($spot->street)); ?> ·
                            <?php echo e(__('hand_lab.your_decision')); ?>: <?php echo e($spot->selected_action ?: '--'); ?>

                        </p>
                    </div>

                    <div class="hand-review-status is-pending">
                        <?php echo e(__('hand_lab.review_now')); ?>

                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <article class="lab-box hand-review-empty">
                    <span class="lab-box-kicker"><?php echo e(__('hand_lab.admin_pending_reviews')); ?></span>
                    <h2><?php echo e(__('hand_lab.admin_no_pending_title')); ?></h2>
                    <p><?php echo e(__('hand_lab.admin_no_pending_text')); ?></p>
                </article>
            <?php endif; ?>

            <?php if($pendingSpots->hasPages()): ?>
                <div class="admin-review-pagination">
                    <?php echo e($pendingSpots->links()); ?>

                </div>
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
<?php /**PATH C:\laragon\www\apexcash\resources\views/admin/hand-lab/index.blade.php ENDPATH**/ ?>