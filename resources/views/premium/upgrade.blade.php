<x-app-layout>
    <link href="{{ asset('assets/css/premium-upgrade.css') }}" rel="stylesheet">

    <main class="premium-page">
        <section class="premium-hero">
            <span class="premium-kicker">ApexCash Premium</span>

            <h1>Entrena sin límites y desbloquea el nivel avanzado</h1>

            <p>
                Accede a todos los spots, Mastery Training, Certificación oficial,
                Hand Lab ilimitado y estadísticas avanzadas para acelerar tu progreso.
            </p>

            <div class="premium-actions">
                <a href="#plans" class="premium-btn primary">Ver planes</a>
                <a href="{{ route('dashboard') }}" class="premium-btn secondary">Volver al dashboard</a>
            </div>
        </section>

        <section class="premium-comparison" id="plans">
            <div class="plan-card free">
                <span class="plan-label">Free</span>
                <h2>Entrenamiento diario básico</h2>
                <p class="plan-price">0 €</p>

                <ul>
                    <li>20 spots diarios de Preflop</li>
                    <li>10 spots diarios de Flop</li>
                    <li>10 spots diarios de Turn</li>
                    <li>10 spots diarios de River</li>
                    <li>5 análisis diarios de Hand Lab</li>
                    <li>Dashboard básico</li>
                    <li>Progreso limitado</li>
                </ul>
            </div>

            <div class="plan-card premium featured">
                <span class="plan-label">Premium</span>
                <h2>Acceso completo ApexCash</h2>
                <p class="plan-price">Próximamente</p>

                <ul>
                    <li>Todos los spots sin límite diario</li>
                    <li>Mastery Training completo</li>
                    <li>Certificación oficial ApexCash</li>
                    <li>Hand Lab ilimitado</li>
                    <li>Leaks avanzados</li>
                    <li>Historial completo</li>
                    <li>Certificados y progreso avanzado</li>
                </ul>

                <button class="premium-btn primary disabled" disabled>
                    Pago disponible próximamente
                </button>
            </div>
        </section>
    </main>
</x-app-layout>