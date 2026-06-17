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

    <div class="max-w-5xl mx-auto px-6 py-8">

        <div class="bg-slate-900 rounded-xl p-8 border border-slate-700">

            <h1 class="text-3xl font-bold mb-4">
                ApexCash Certification
            </h1>

            <?php if(session('error')): ?>
                <div class="bg-red-900 text-red-100 p-4 rounded mb-4">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="bg-green-900 text-green-100 p-4 rounded mb-4">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(!$certificationUnlocked): ?>

                <div class="text-center py-8">

                    <div class="text-6xl mb-4">🔒</div>

                    <h2 class="text-2xl font-semibold mb-2">
                        Bloqueado por progreso
                    </h2>

                    <p class="text-slate-300">
                        Debes completar la ruta ApexCash antes de acceder
                        al examen de certificación.
                    </p>

                </div>

            <?php else: ?>

                <div class="text-center py-8">

                    <div class="text-6xl mb-4">🎓</div>

                    <h2 class="text-2xl font-semibold mb-4">
                        Examen Final ApexCash
                    </h2>

                    <div class="space-y-2 text-slate-300">

                        <p>75 preguntas totales.</p>

                        <p>15 Preflop</p>
                        <p>15 Flop</p>
                        <p>15 Turn</p>
                        <p>15 River</p>
                        <p>15 Mastery</p>

                        <br>

                        <p>75% mínimo global para aprobar.</p>

                        <p>60% mínimo en cada bloque.</p>

                        <p>
                            Si suspendes deberás esperar
                            7 días antes de volver a presentarte.
                        </p>

                    </div>

                    <form
                        method="POST"
                        action="<?php echo e(route('certification.start')); ?>"
                        class="mt-8"
                    >
                        <?php echo csrf_field(); ?>

                        <button
                            type="submit"
                            class="px-8 py-4 bg-emerald-600 hover:bg-emerald-500 rounded-lg font-bold"
                        >
                            Comenzar Examen
                        </button>

                    </form>

                </div>

            <?php endif; ?>

            <?php if($passedAttempt): ?>

                <div class="mt-10 border-t border-slate-700 pt-6">

                    <h3 class="text-xl font-semibold mb-2">
                        Certificación obtenida
                    </h3>

                    <p>
                        Estado:
                        <?php echo e($passedAttempt->resultBadge()); ?>

                    </p>

                    <p>
                        Código:
                        <?php echo e($passedAttempt->certificate_code); ?>

                    </p>

                </div>

            <?php endif; ?>

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
<?php endif; ?><?php /**PATH C:\laragon\www\apexcash\resources\views/certification/index.blade.php ENDPATH**/ ?>