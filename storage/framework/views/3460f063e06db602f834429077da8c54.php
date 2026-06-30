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
    <link href="<?php echo e(asset('assets/css/apexcash-profile.css')); ?>" rel="stylesheet">

    <div class="apex-profile-page">
        <div class="apex-profile-shell">

            <section class="apex-profile-hero">
                <span class="apex-profile-chip">APEXCASH ACCOUNT</span>

                <h1>Mi cuenta</h1>

                <p>
                    Gestiona tu información personal, la seguridad de tu cuenta y tu acceso a ApexCash.
                </p>
            </section>

            <div class="apex-profile-grid">
                <section class="apex-profile-card">
                    <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </section>

                <section class="apex-profile-card">
                    <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </section>

                <section class="apex-profile-card apex-profile-card--wide">
    <div class="apex-profile-title">
        <span class="apex-profile-icon">⭐</span>
        <div>
            <h2>ApexCash Premium</h2>
            <p>Desbloquea el entrenamiento completo y lleva tu progreso al siguiente nivel.</p>
        </div>
    </div>

    <div class="apex-account-row">
        <span class="apex-account-label">Plan actual</span>
        <span class="apex-plan-badge"><?php echo e(strtoupper(auth()->user()->plan ?? 'free')); ?></span>
    </div>

    <?php if((auth()->user()->plan ?? 'free') === 'premium'): ?>
        <div class="apex-account-row">
            <span class="apex-account-label">Estado</span>
            <span class="apex-account-value">Premium activo</span>
        </div>

        <div class="apex-account-row">
            <span class="apex-account-label">Válido hasta</span>
            <span class="apex-account-value">
                <?php echo e(auth()->user()->premium_until ? auth()->user()->premium_until->format('d/m/Y') : 'Sin fecha de vencimiento'); ?>

            </span>
        </div>

        <div class="apex-profile-actions" style="margin-top: 22px;">
            <a href="<?php echo e(route('premium.upgrade')); ?>" class="apex-btn apex-btn-primary">
                Gestionar Premium
            </a>
        </div>
        <?php elseif((auth()->user()->plan ?? 'free') === 'admin'): ?>
            <div class="apex-account-row">
                <span class="apex-account-label">Estado</span>
                <span class="apex-account-value">Acceso completo administrador</span>
            </div>
        <?php else: ?>
            <div class="apex-premium-benefits" style="margin-top: 20px;">
                <p>Con Premium tendrás acceso a:</p>

                <ul style="margin: 14px 0 0; padding-left: 0; list-style: none; display: grid; gap: 10px; color: #dce8e2;">
                    <li>✅ Hand Lab ilimitado</li>
                    <li>✅ Mastery Training</li>
                    <li>✅ Certificación Oficial ApexCash</li>
                    <li>✅ Estadísticas avanzadas</li>
                    <li>✅ Nuevos módulos antes que nadie</li>
                </ul>
            </div>

            <div class="apex-profile-actions" style="margin-top: 24px;">
                <a href="<?php echo e(route('premium.upgrade')); ?>" class="apex-btn apex-btn-primary">
                    Actualizar a Premium
                </a>
            </div>
        <?php endif; ?>

        <div class="apex-account-row" style="margin-top: 22px;">
            <span class="apex-account-label">Correo verificado</span>
            <span class="apex-account-value">
                <?php echo e(auth()->user()->hasVerifiedEmail() ? 'Sí' : 'No'); ?>

            </span>
        </div>

        <div class="apex-account-row">
            <span class="apex-account-label">Miembro desde</span>
            <span class="apex-account-value">
                <?php echo e(auth()->user()->created_at?->format('d/m/Y')); ?>

            </span>
        </div>
    </section>

                <section class="apex-profile-card apex-profile-card--danger apex-profile-card--wide">
                    <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </section>
            </div>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\apexcash\resources\views/profile/edit.blade.php ENDPATH**/ ?>