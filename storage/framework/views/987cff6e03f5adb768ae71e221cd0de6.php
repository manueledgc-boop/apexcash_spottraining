<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'ApexCash')); ?></title>

    <link rel="icon" href="<?php echo e(asset('favicon/apexcash.ico')); ?>">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <link href="<?php echo e(asset('assets/css/apexcash-auth.css')); ?>" rel="stylesheet">
</head>
<body class="font-sans antialiased">
    <main class="auth-shell">
        <section class="auth-brand-panel">
            <a href="<?php echo e(url('/')); ?>" class="auth-logo-link" aria-label="ApexCash home">
                <img src="<?php echo e(asset('images/apexcash-icon.png')); ?>" alt="ApexCash" class="auth-logo">
                <div class="auth-brand-copy"><h1>APEXCASH</h1></div>
            </a>

            <div class="auth-brand-copy">
                <span class="auth-kicker"><?php echo e(__('auth.layout.kicker')); ?></span>
                <h1><?php echo e(__('auth.layout.title')); ?></h1>
                <p><?php echo e(__('auth.layout.subtitle')); ?></p>
            </div>

            <div class="auth-stage-card">
                <div class="auth-stage-row is-active">
                    <span>01</span>
                    <strong><?php echo e(__('auth.layout.stages.preflop.title')); ?></strong>
                    <small><?php echo e(__('auth.layout.stages.preflop.text')); ?></small>
                </div>
                <div class="auth-stage-row">
                    <span>02</span>
                    <strong><?php echo e(__('auth.layout.stages.flop.title')); ?></strong>
                    <small><?php echo e(__('auth.layout.stages.flop.text')); ?></small>
                </div>
                <div class="auth-stage-row">
                    <span>03</span>
                    <strong><?php echo e(__('auth.layout.stages.turn.title')); ?></strong>
                    <small><?php echo e(__('auth.layout.stages.turn.text')); ?></small>
                </div>
                <div class="auth-stage-row">
                    <span>04</span>
                    <strong><?php echo e(__('auth.layout.stages.river.title')); ?></strong>
                    <small><?php echo e(__('auth.layout.stages.river.text')); ?></small>
                </div>
            </div>
        </section>

        <section class="auth-form-panel">
            <div class="auth-card">
                <?php echo e($slot); ?>

            </div>

            <p class="auth-footer-note">
                <?php echo e(__('auth.layout.footer_note')); ?>

            </p>
        </section>
    </main>
</body>
</html>
<?php /**PATH C:\laragon\www\apexcash\resources\views/layouts/guest.blade.php ENDPATH**/ ?>