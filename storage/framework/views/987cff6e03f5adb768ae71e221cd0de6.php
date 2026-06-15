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
                <span class="auth-kicker">Cash Game Training System</span>
                <h1>Entrena decisiones. Detecta leaks. Sube de nivel.</h1>
                <p>
                    ApexCash convierte tu estudio de poker en un sistema medible:
                    Preflop, Flop, Turn y River con XP, precisión, leaks y feedback inmediato.
                </p>
            </div>

            <div class="auth-stage-card">
                <div class="auth-stage-row is-active">
                    <span>01</span>
                    <strong>Preflop</strong>
                    <small>Base sólida</small>
                </div>
                <div class="auth-stage-row">
                    <span>02</span>
                    <strong>Flop</strong>
                    <small>C-bets y defensa</small>
                </div>
                <div class="auth-stage-row">
                    <span>03</span>
                    <strong>Turn</strong>
                    <small>Barrels y probes</small>
                </div>
                <div class="auth-stage-row">
                    <span>04</span>
                    <strong>River</strong>
                    <small>Value, bluffs y calls</small>
                </div>
            </div>
        </section>

        <section class="auth-form-panel">
            <div class="auth-card">
                <?php echo e($slot); ?>

            </div>

            <p class="auth-footer-note">
                ApexCash V1 · Entrenamiento estructurado para Cash Games
            </p>
        </section>
    </main>
</body>
</html>
<?php /**PATH C:\laragon\www\apexcash\resources\views/layouts/guest.blade.php ENDPATH**/ ?>