<x-app-layout>
    <link href="{{ asset('assets/css/apexcash-dashboard.css') }}" rel="stylesheet">

    <main class="dashboard-page">
        <section class="dashboard-hero">
            <div>
                <span class="dashboard-badge">APEXCASH SPOT TRAINING</span>
                <h1>Bienvenido, {{ auth()->user()->name }}</h1>
                <p>Entrena decisiones concretas de cash 6-max. V1 se enfoca en spots preflop con feedback inmediato.</p>
            </div>

            <a href="{{ route('spot-training.index') }}" class="dashboard-main-btn">
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
            <a href="{{ route('spot-training.index') }}" class="dashboard-card active">
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
</x-app-layout>
