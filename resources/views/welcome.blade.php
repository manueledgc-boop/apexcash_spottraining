<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>ApexCash - Entrenamiento de Poker Cash Games</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ApexCash es un sistema de entrenamiento de poker Cash Games con spots, XP, leaks, GTO simplificado y ajustes para microlímites NL2-NL10.">

    <link href="{{ asset('assets/css/apexcash-landing.css') }}" rel="stylesheet">
</head>
<body>

<div class="page landing-v2">

    <header class="topbar">
        <a href="{{ url('/') }}" class="brand">
            <div class="brand-mark">A</div>
            <div>
                <strong>APEXCASH</strong>
                <span>Cash Game Training System</span>
            </div>
        </a>

        <nav class="nav">
            <a href="#training">Entrenamiento</a>
            <a href="#method">Método</a>
            <a href="#progress">Progreso</a>
            <a href="#modules">Módulos</a>

            <div class="language-selector">
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('lang.switch', 'es') }}" {{ app()->getLocale() == 'es' ? 'selected' : '' }}>
                        Español
                    </option>
                    <option value="{{ route('lang.switch', 'en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>
                        English
                    </option>
                </select>
            </div>

            <a href="{{ route('login') }}" class="login-link">
                Entrar
            </a>
        </nav>
    </header>

    <main class="hero">
        <section class="hero-content">
            <div class="badge">ENTRENAMIENTO REAL PARA CASH GAMES</div>

            <h1>Deja de adivinar en las mesas. Entrena tus decisiones antes de perder tu bankroll.</h1>

            <p>
                ApexCash es un gimnasio mental de poker: practicas spots de Preflop, Flop, Turn y River,
                recibes feedback inmediato, detectas leaks y aprendes la diferencia entre teoría GTO y ajustes reales para microlímites.
            </p>

            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn primary">
                    Empezar a entrenar
                </a>

                <a href="{{ route('login') }}" class="btn secondary">
                    Ya tengo cuenta
                </a>
            </div>

            <div class="hero-stats">
                <div>
                    <strong>250+</strong>
                    <span>spots de entrenamiento</span>
                </div>
                <div>
                    <strong>4</strong>
                    <span>calles: Preflop a River</span>
                </div>
                <div>
                    <strong>2</strong>
                    <span>enfoques: GTO + NL2-NL10</span>
                </div>
            </div>
        </section>

        <section class="training-preview" aria-label="ApexCash training preview">
            <div class="preview-glow"></div>

            <div class="trainer-card">
                <div class="trainer-top">
                    <span>SPOT EN VIVO</span>
                    <strong>River · Bluff Catch</strong>
                </div>

                <div class="mini-table">
                    <div class="mini-seat seat-top">VILLANO · BTN</div>
                    <div class="mini-seat seat-left">SB</div>
                    <div class="mini-seat seat-right">BB</div>

                    <div class="mini-pot">
                        <span>Pot</span>
                        <strong>42 BB</strong>
                    </div>

                    <div class="mini-card card-one">A♠</div>
                    <div class="mini-card card-two">J♥</div>

                    <div class="mini-hero">HERO · BB</div>
                </div>

                <div class="decision-row">
                    <button>Fold</button>
                    <button class="is-best">Call</button>
                    <button>Raise</button>
                </div>

                <div class="feedback-preview">
                    <span>Feedback inmediato</span>
                    <p>
                        Call correcto: bloqueas valor fuerte, el rival tiene suficientes faroles fallidos
                        y el tamaño polarizado no representa tantas combinaciones de nuts.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <section id="training" class="section-block">
        <div class="section-heading">
            <span>NO ES TEORÍA PASIVA</span>
            <h2>Aprendes jugando decisiones, no mirando tablas infinitas.</h2>
            <p>
                Cada ejercicio te pone en una situación concreta. Eliges una acción, recibes evaluación
                y el sistema guarda tus aciertos, errores, precisión, XP y leaks.
            </p>
        </div>

        <div class="features">
            <article>
                <span>01</span>
                <h3>Spots reales de Cash</h3>
                <p>
                    Open raises, defensa de ciegas, c-bets, barrels, value bets, bluff catchers,
                    overbets y decisiones difíciles de river.
                </p>
            </article>

            <article>
                <span>02</span>
                <h3>Feedback que corrige</h3>
                <p>
                    No solo te dice si acertaste. Te explica por qué una línea gana más EV
                    y cuándo debes ajustar contra el pool de límites bajos.
                </p>
            </article>

            <article>
                <span>03</span>
                <h3>Leaks persistentes</h3>
                <p>
                    ApexCash detecta tus módulos débiles y tus peores spots para que no entrenes a ciegas.
                </p>
            </article>
        </div>
    </section>

    <section id="method" class="split-section">
        <div>
            <span class="section-kicker">EL DIFERENCIAL</span>
            <h2>GTO simplificado + explotación para microlímites.</h2>
            <p>
                La teoría pura es necesaria, pero en NL2-NL10 muchos rivales no juegan como un solver.
                ApexCash enseña ambos mundos: lo correcto en teoría y lo más rentable contra jugadores reales.
            </p>
        </div>

        <div class="method-grid">
            <article>
                <span>GTO</span>
                <h3>Comprende la estrategia base</h3>
                <p>
                    Rangos, ventaja de nuts, ventaja de rango, SPR, blockers, tamaños y frecuencia recomendada.
                </p>
            </article>

            <article>
                <span>NL2-NL10</span>
                <h3>Ajusta contra el pool real</h3>
                <p>
                    Más valor contra calling stations, menos faroles malos, mejores folds contra líneas fuertes
                    y bluff catchers más disciplinados.
                </p>
            </article>
        </div>
    </section>

    <section id="progress" class="section-block">
        <div class="section-heading">
            <span>PROGRESIÓN GUIADA</span>
            <h2>Subes de nivel calle por calle.</h2>
            <p>
                El sistema mide XP, precisión y rendimiento por módulo. No se trata de avanzar rápido:
                se trata de dominar fundamentos antes de tomar decisiones más complejas.
            </p>
        </div>

        <div class="mode-grid">
            <article class="mode-card active">
                <span>COMPLETO</span>
                <h3>Preflop</h3>
                <p>Open Raise, defensa de ciegas, 3Bet pots y decisiones base para entrar fuerte a la mano.</p>
                <strong>≈100 spots</strong>
            </article>

            <article class="mode-card active">
                <span>COMPLETO</span>
                <h3>Flop</h3>
                <p>C-Bet IP, check back, defensa vs c-bet, check raise, value bet y semi bluff.</p>
                <strong>56 spots</strong>
            </article>

            <article class="mode-card active">
                <span>COMPLETO</span>
                <h3>Turn</h3>
                <p>Barrels, probes, defensa, value bets y check raises en la calle donde los rangos se definen.</p>
                <strong>50 spots</strong>
            </article>

            <article class="mode-card active">
                <span>COMPLETO</span>
                <h3>River</h3>
                <p>Value bet, thin value, bluff, bluff catch y overbet. La calle donde más dinero se gana o se pierde.</p>
                <strong>50 spots</strong>
            </article>
        </div>
    </section>

    <section id="modules" class="split-section">
        <div>
            <span class="section-kicker">ENTRENAMIENTO MEDIBLE</span>
            <h2>Cada decisión deja datos.</h2>
            <p>
                ApexCash registra tu progreso para convertir el entrenamiento en un proceso objetivo:
                sabes dónde mejoras, dónde fallas y qué debes repetir.
            </p>
        </div>

        <div class="method-grid">
            <article>
                <span>XP + Accuracy</span>
                <h3>Progreso visible</h3>
                <p>
                    Cada respuesta suma experiencia según su calidad: Best, Good, Marginal, Mistake o Blunder.
                </p>
            </article>

            <article>
                <span>Spot Stats</span>
                <h3>Seguimiento individual</h3>
                <p>
                    Veces visto, aciertos, fallos, precisión y última aparición de cada spot.
                </p>
            </article>
        </div>
    </section>

    <section class="final-cta">
        <span>ENTRENA ANTES DE JUGAR</span>
        <h2>Comete los errores aquí, no en las mesas reales.</h2>
        <p>
            Si tu objetivo es mejorar en Cash Games, necesitas volumen de decisiones,
            feedback inmediato y un sistema que te diga exactamente dónde estás fallando.
        </p>

        <div class="hero-actions centered">
            <a href="{{ route('register') }}" class="btn primary">
                Crear cuenta
            </a>

            <a href="{{ route('login') }}" class="btn secondary">
                Entrar
            </a>
        </div>
    </section>

</div>

</body>
</html>
