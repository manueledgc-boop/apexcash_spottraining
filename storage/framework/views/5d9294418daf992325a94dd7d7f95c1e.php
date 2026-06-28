<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ApexCash · Error <?php echo e($code ?? 'Error'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/apexcash-errors.css')); ?>">
</head>
<body>
    <main class="apex-error-page">
        <section class="apex-error-card">
            <div class="apex-error-logo">ApexCash</div>

            <div class="apex-error-code"><?php echo e($code ?? 'Error'); ?></div>

            <h1 class="apex-error-title">
                <?php echo e($title ?? 'Algo salió mal'); ?>

            </h1>

            <p class="apex-error-message">
                <?php echo e($message ?? 'Se produjo un error inesperado en ApexCash.'); ?>

            </p>

            <div class="apex-error-actions">
                <a href="<?php echo e(url('/')); ?>" class="apex-error-btn apex-error-btn-secondary">
                    Inicio
                </a>

                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="apex-error-btn apex-error-btn-primary">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="apex-error-btn apex-error-btn-primary">
                        Iniciar sesión
                    </a>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html><?php /**PATH C:\laragon\www\apexcash\resources\views/errors/layout.blade.php ENDPATH**/ ?>