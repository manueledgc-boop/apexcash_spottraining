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
        $cardText = function (?string $card): string {
            if (!$card) return '--';
            $rank = substr($card, 0, -1);
            $suit = substr($card, -1);
            $symbol = ['s' => '♠', 'h' => '♥', 'd' => '♦', 'c' => '♣'][$suit] ?? $suit;
            return $rank.$symbol;
        };

        $formatSize = function ($value): string {
            $number = (float) ($value ?? 0);
            return rtrim(rtrim(number_format($number, 1), '0'), '.');
        };
    ?>

    <main class="hand-lab-page">
        <section class="hand-lab-header">
            <div>
                <span class="hand-lab-kicker"><?php echo e(__('hand_lab.admin_kicker')); ?></span>
                <h1><?php echo e($spot->spot_type ?: __('hand_lab.lab_spot')); ?></h1>
                <p>#<?php echo e($spot->id); ?> · <?php echo e($spot->hero_position); ?> vs <?php echo e($spot->villain_position); ?> · <?php echo e(strtoupper($spot->street)); ?></p>
            </div>

            <div class="hand-lab-header-actions">
                <a href="<?php echo e(route('admin.hand-lab.index')); ?>" class="ghost-link"><?php echo e(__('hand_lab.back_to_pending_reviews')); ?></a>
            </div>
        </section>

        <section class="hand-review-detail-layout admin-review-layout">
            <article class="lab-box hand-review-detail-card">
                <span class="lab-box-kicker"><?php echo e(__('hand_lab.admin_spot_summary')); ?></span>
                <h2><?php echo e(__('hand_lab.lab_spot')); ?></h2>

                <div class="hand-review-result-grid">
                    <div><strong><?php echo e(__('hand_lab.hero')); ?></strong><span><?php echo e($spot->hero_position); ?> · <?php echo e(collect($spot->hero_cards ?? [])->map($cardText)->implode(' ')); ?></span></div>
                    <div><strong><?php echo e(__('hand_lab.villain')); ?></strong><span><?php echo e($spot->villain_position); ?></span></div>
                    <div><strong><?php echo e(__('hand_lab.board')); ?></strong><span><?php echo e(collect($spot->board_cards ?? [])->map($cardText)->implode(' ') ?: '--'); ?></span></div>
                    <div><strong><?php echo e(__('hand_lab.pot')); ?></strong><span><?php echo e($formatSize($spot->pot_bb)); ?> BB</span></div>
                    <div><strong>SPR</strong><span><?php echo e($spot->spr ? $formatSize($spot->spr) : '--'); ?></span></div>
                    <div><strong><?php echo e(__('hand_lab.your_decision')); ?></strong><span><?php echo e($spot->selected_action ?: '--'); ?></span></div>
                </div>

                <h3><?php echo e(__('hand_lab.action_history')); ?></h3>
                <ol class="lab-action-list">
                    <?php $__currentLoopData = ($spot->action_history ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php echo e(strtoupper($action['street'] ?? '')); ?> ·
                            <?php echo e($action['actor'] ?? '--'); ?>

                            <?php echo e(ucfirst(str_replace('_', ' ', $action['type'] ?? '--'))); ?>

                            <?php if(($action['size'] ?? 0) > 0): ?>
                                <?php echo e($formatSize($action['size'])); ?> BB
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </article>

            <article class="lab-box hand-review-detail-card admin-review-form-card">
                <span class="lab-box-kicker"><?php echo e(__('hand_lab.admin_review_actions')); ?></span>
                <h2><?php echo e(__('hand_lab.admin_approve_title')); ?></h2>

                <form method="POST" action="<?php echo e(route('admin.hand-lab.approve', $spot)); ?>" class="admin-review-form">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <label class="lab-field">
                        <span><?php echo e(__('hand_lab.best_action')); ?></span>
                        <input type="text" name="best_action" value="<?php echo e(old('best_action')); ?>" placeholder="Call / Fold / Raise / Bet 75%" required>
                        <?php $__errorArgs = ['best_action'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="admin-form-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <label class="lab-field">
                        <span>GTO</span>
                        <textarea name="gto_explanation" rows="5" required><?php echo e(old('gto_explanation')); ?></textarea>
                        <?php $__errorArgs = ['gto_explanation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="admin-form-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <label class="lab-field">
                        <span><?php echo e(__('hand_lab.micro_limits')); ?></span>
                        <textarea name="exploit_explanation" rows="5"><?php echo e(old('exploit_explanation')); ?></textarea>
                        <?php $__errorArgs = ['exploit_explanation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="admin-form-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <label class="lab-field">
                        <span><?php echo e(__('hand_lab.leak_detected')); ?></span>
                        <input type="text" name="leak_label" value="<?php echo e(old('leak_label')); ?>" placeholder="Overcalling vs 3Bet">
                        <?php $__errorArgs = ['leak_label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="admin-form-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <label class="lab-field">
                        <span><?php echo e(__('hand_lab.admin_concepts')); ?></span>
                        <input type="text" name="concepts" value="<?php echo e(old('concepts')); ?>" placeholder="BTN vs BB, 3Bet Pot, Preflop">
                        <?php $__errorArgs = ['concepts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="admin-form-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <button type="submit" class="primary-lab-btn admin-review-submit">
                        <?php echo e(__('hand_lab.admin_approve_button')); ?>

                    </button>
                </form>

                <hr class="admin-review-divider">

                <h2><?php echo e(__('hand_lab.admin_reject_title')); ?></h2>
                <form method="POST" action="<?php echo e(route('admin.hand-lab.reject', $spot)); ?>" class="admin-review-form">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <label class="lab-field">
                        <span><?php echo e(__('hand_lab.reason')); ?></span>
                        <select name="review_reason" required>
                            <?php $__currentLoopData = $rejectionReasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['review_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="admin-form-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <label class="lab-field">
                        <span><?php echo e(__('hand_lab.admin_optional_note')); ?></span>
                        <textarea name="review_note" rows="4"><?php echo e(old('review_note')); ?></textarea>
                        <?php $__errorArgs = ['review_note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="admin-form-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <button type="submit" class="secondary-lab-btn admin-review-reject">
                        <?php echo e(__('hand_lab.admin_reject_button')); ?>

                    </button>
                </form>
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
<?php /**PATH C:\laragon\www\apexcash\resources\views/admin/hand-lab/show.blade.php ENDPATH**/ ?>