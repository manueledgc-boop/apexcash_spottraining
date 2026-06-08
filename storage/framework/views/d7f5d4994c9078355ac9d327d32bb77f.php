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

    <main class="dashboard-page">
        <section class="dashboard-hero">
            <div>
                <span class="dashboard-badge">APEXCASH SPOT TRAINING</span>
                <h1>Bienvenido, <?php echo e(auth()->user()->name); ?></h1>
                <p>Entrena decisiones concretas de cash 6-max. V1 se enfoca en spots preflop con feedback inmediato.</p>
            </div>

            <a href="<?php echo e(route('spot-training.index')); ?>" class="dashboard-main-btn">
                Empezar Spot Training
            </a>
        </section>

        <section class="dashboard-stats">
            <article>
                <span>Modo actual</span>
                <strong>Preflop</strong>
            </article>

            <article>
                <span>Persistencia</span>
                <strong>Sesión</strong>
            </article>

            <article>
                <span>Base de datos</span>
                <strong>No requerida</strong>
            </article>

            <article>
                <span>Estado</span>
                <strong>V1</strong>
            </article>
        </section>

        <section class="dashboard-modes">
            <a href="<?php echo e(route('spot-training.index')); ?>" class="dashboard-card active">
                <span>Disponible</span>
                <h2>Spot Training Preflop</h2>
                <p>Practica open raises, defensa de ciegas, BTN vs 3Bet y 3Bet vs open.</p>
                <strong>Entrar →</strong>
            </a>

            <article class="dashboard-card locked">
                <span>Próximamente</span>
                <h2>Spot Training Postflop</h2>
                <p>Boards secos, boards húmedos, cbets, barrels, bluffcatchers y value betting.</p>
            </article>

            <article class="dashboard-card locked">
                <span>Pausado</span>
                <h2>Cash Session completa</h2>
                <p>La mesa jugable completa queda fuera de V1. Primero construiremos entrenamiento útil y estable.</p>
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