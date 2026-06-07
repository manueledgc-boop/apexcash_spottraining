<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>ApexCash - Poker Training</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('assets/css/apexcash-landing.css') }}" rel="stylesheet">
</head>
<body>

<div class="page">

    <header class="topbar">
        <div class="brand">
            <div class="brand-mark">A</div>
            <div>
                <strong>APEXCASH</strong>
                <span>Train Cash Games</span>
            </div>
        </div>

        <nav class="nav">
            <a href="#features">{{ __('app.nav_training') }}</a>
            <a href="#modes">{{ __('app.nav_modes') }}</a>
            <div class="language-selector">
                <select onchange="window.location.href=this.value">
                    <option
                        value="{{ route('lang.switch', 'es') }}"
                        {{ app()->getLocale() == 'es' ? 'selected' : '' }}>
                        Español
                    </option>

                    <option
                        value="{{ route('lang.switch', 'en') }}"
                        {{ app()->getLocale() == 'en' ? 'selected' : '' }}>
                        English
                    </option>
                </select>
            </div>
            <a href="{{ route('login') }}" class="login-link">
                {{ __('app.login') }}
            </a>

        </nav>
    </header>

    <main class="hero">
        <section class="hero-content">
            <div class="badge">{{ __('app.badge') }}</div>

            <h1>{{ __('app.hero_title') }}</h1>

            <p>{{ __('app.hero_subtitle') }}</p>

            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn primary">{{ __('app.start_now') }}</a>
                <a href="#modes" class="btn secondary">{{ __('app.see_modes') }}</a>
            </div>

            <div class="hero-stats">
                <div>
                    <strong>100 BB</strong>
                    <span>{{ __('app.stack_initial') }}</span>
                </div>
                <div>
                    <strong>6-Max</strong>
                    <span>{{ __('app.cash_training') }}</span>
                </div>
                <div>
                    <strong>0€</strong>
                    <span>{{ __('app.no_real_risk') }}</span>
                </div>
            </div>
        </section>

        <section class="table-preview">
            <div class="glow"></div>

            <div class="poker-card card-one">A♠</div>
            <div class="poker-card card-two">K♥</div>

            <div class="mini-table">
                <div class="seat top">BOT REG</div>
                <div class="seat left">BOT TIGHT</div>
                <div class="seat right">BOT AGGRO</div>
                <div class="pot">POT 12.5 BB</div>
                <div class="hero-seat">HERO</div>
            </div>
        </section>
    </main>

    <section id="features" class="features">
        <article>
            <span>01</span>
            <h3>Sesiones reales</h3>
            <p>Entrena volumen como en una mesa cash real, pero en entorno controlado.</p>
        </article>

        <article>
            <span>02</span>
            <h3>Bots humanos</h3>
            <p>Rivales con estilos distintos: tight, reg, agresivo y perfiles más duros.</p>
        </article>

        <article>
            <span>03</span>
            <h3>Mejora medible</h3>
            <p>Stats, leaks y progreso para saber si realmente estás mejorando.</p>
        </article>
    </section>

    <section id="modes" class="modes">
        <h2>Elige cómo quieres entrenar</h2>

        <div class="mode-grid">
            <a href="{{ route('dashboard') }}" class="mode-card active">
                <span>Disponible</span>
                <h3>Cash Training</h3>
                <p>Juega sesiones completas contra bots y mejora tu toma de decisiones.</p>
                <strong>Entrar →</strong>
            </a>

            <div class="mode-card locked">
                <span>Próximamente</span>
                <h3>Spot Training</h3>
                <p>Practica spots concretos: 3bet pots, defensa de ciegas, river calls y más.</p>
            </div>

            <div class="mode-card locked">
                <span>Próximamente</span>
                <h3>Estadísticas</h3>
                <p>Analiza VPIP, PFR, 3Bet, winrate, sesiones y leaks principales.</p>
            </div>
        </div>
    </section>

</div>

</body>
</html>