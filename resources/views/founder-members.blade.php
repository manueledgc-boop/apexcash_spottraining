<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>ApexCash Trainer Founder Members 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Solicita acceso al programa Founder Members 2026 de ApexCash Trainer.">

    <link href="{{ asset('assets/css/apexcash-landing.css') }}?v=founders2026" rel="stylesheet">
    <link href="{{ asset('assets/css/apexcash-cookies.css') }}" rel="stylesheet">
</head>
<body>

<div class="apex-landing">

    <header class="apex-nav">
        <a href="{{ url('/') }}" class="apex-brand">
            <img src="{{ asset('images/apexcash-icon.png') }}" alt="ApexCash" class="apex-brand-logo">
            <div>
                <strong>APEXCASH</strong>
                <span>Founder Members 2026</span>
            </div>
        </a>

        <nav class="apex-nav-links">
            <a href="{{ url('/') }}">Inicio</a>
            <a href="#benefits">Beneficios</a>
            <a href="#roadmap">Roadmap</a>
            <a href="#faq">FAQ</a>

            @auth
                <a href="{{ route('dashboard') }}" class="apex-nav-cta">
                    Solicitar acceso
                </a>
            @else
                <a href="{{ route('register') }}" class="apex-nav-cta">
                    Crear cuenta
                </a>
            @endauth
        </nav>
    </header>

    <main class="apex-hero">
        <section class="apex-hero-copy">
            <div class="apex-badge">
                🚀 ApexCash Trainer Founder Members 2026
            </div>

            <h1>
                Ayúdanos a construir el futuro del entrenamiento de poker
            </h1>

            <p>
                Antes del lanzamiento oficial de ApexCash Trainer estamos seleccionando
                a los primeros jugadores que quieran formar parte del proyecto desde sus inicios.
            </p>

            <p>
                <strong>Lanzamiento oficial: 1 de septiembre de 2026.</strong>
            </p>

            <div class="apex-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="apex-btn apex-btn-primary">
                        🚀 Solicitar acceso Founder
                    </a>
                @else
                    <a href="{{ route('register') }}" class="apex-btn apex-btn-primary">
                        Crear cuenta gratuita
                    </a>
                @endauth

                <a href="#how-it-works" class="apex-btn apex-btn-secondary">
                    Cómo funciona
                </a>
            </div>
        </section>

        <section class="apex-product-frame apex-hero-frame">
            <div class="browser-bar">
                <span></span><span></span><span></span>
                <small>Founder Member #0001</small>
            </div>

            <div style="padding:40px;text-align:center;">
                <div style="font-size:64px;">🏅</div>
                <h2>Founder Member</h2>
                <p>2026</p>
                <strong>ApexCash Trainer</strong>
            </div>
        </section>
    </main>

    <section class="apex-section">
        <div class="apex-section-head">
            <span>¿Qué es?</span>
            <h2>No es una promoción. Es una invitación.</h2>
            <p>
                Founder Members 2026 es el programa de lanzamiento de ApexCash Trainer.
                Los usuarios aceptados tendrán acceso anticipado a todas las funciones mientras
                construimos y mejoramos la plataforma junto a la comunidad.
            </p>
        </div>
    </section>

    <section id="benefits" class="apex-section">
        <div class="apex-section-head">
            <span>Beneficios</span>
            <h2>Como Founder Member tendrás acceso a:</h2>
        </div>

        <div class="apex-feature-grid">
            <article>
                <strong>01</strong>
                <h3>Acceso anticipado</h3>
                <p>Podrás utilizar las funciones Premium disponibles durante la fase Founder.</p>
            </article>

            <article>
                <strong>02</strong>
                <h3>Badge permanente</h3>
                <p>Recibirás el distintivo Founder Member 2026 en tu perfil.</p>
            </article>

            <article>
                <strong>03</strong>
                <h3>Participación directa</h3>
                <p>Podrás enviar sugerencias, reportar errores y ayudar a decidir mejoras.</p>
            </article>
        </div>
    </section>

    <section class="apex-showcase">
        <div class="apex-showcase-copy">
            <span>Funciones incluidas</span>
            <h2>Acceso completo durante Founder Members</h2>

            <ul class="apex-check-list">
                <li>Preflop Trainer</li>
                <li>Flop Trainer</li>
                <li>Turn Trainer</li>
                <li>River Trainer</li>
                <li>Mastery Training</li>
                <li>Hand Lab</li>
                <li>Certificación</li>
                <li>MTT Standard cuando esté disponible</li>
            </ul>
        </div>

        <div class="apex-product-frame">
            <div class="browser-bar">
                <span></span><span></span><span></span>
                <small>ApexCash Premium Early Access</small>
            </div>

            <img src="{{ asset('images/welcome3.png') }}" alt="ApexCash dashboard">
        </div>
    </section>

    <section id="how-it-works" class="apex-section apex-roadmap-section">
        <div class="apex-section-head">
            <span>Proceso</span>
            <h2>Cómo formar parte del programa</h2>
        </div>

        <div class="apex-roadmap">
            <article>
                <span>1</span>
                <h3>Crea tu cuenta gratuita</h3>
                <p>Regístrate normalmente en ApexCash Trainer.</p>
            </article>

            <article>
                <span>2</span>
                <h3>Solicita acceso Founder</h3>
                <p>Desde tu dashboard podrás enviar tu solicitud.</p>
            </article>

            <article>
                <span>3</span>
                <h3>Revisamos tu perfil</h3>
                <p>No todo el mundo entra automáticamente. Queremos usuarios comprometidos.</p>
            </article>

            <article>
                <span>4</span>
                <h3>Acceso aprobado</h3>
                <p>Si eres aceptado, desbloquearemos tu acceso Founder Member.</p>
            </article>
        </div>
    </section>

    <section id="roadmap" class="apex-section apex-roadmap-section">
        <div class="apex-section-head">
            <span>Roadmap</span>
            <h2>Camino al lanzamiento oficial</h2>
            <p>El lanzamiento oficial será el 1 de septiembre de 2026.</p>
        </div>

        <div class="apex-roadmap">
            <article>
                <span>✅</span>
                <h3>Junio</h3>
                <p>Preflop, Flop, Turn, River, Mastery, Certificación y Hand Lab base.</p>
            </article>

            <article>
                <span>🚧</span>
                <h3>Julio</h3>
                <p>Optimización, SEO, mejoras de dashboard y experiencia móvil.</p>
            </article>

            <article>
                <span>🚧</span>
                <h3>Agosto</h3>
                <p>MTT Standard, mejoras Founder y preparación del lanzamiento.</p>
            </article>

            <article>
                <span>🚀</span>
                <h3>1 Septiembre</h3>
                <p>Lanzamiento oficial de ApexCash Trainer.</p>
            </article>
        </div>
    </section>

    <section id="faq" class="apex-faq">
        <div class="apex-section-head">
            <span>FAQ</span>
            <h2>Preguntas frecuentes</h2>
        </div>

        <div class="faq-grid">
            <article>
                <h3>¿Tiene coste formar parte?</h3>
                <p>No durante esta etapa. Founder Members es acceso anticipado al proyecto.</p>
            </article>

            <article>
                <h3>¿Todo el mundo será aceptado?</h3>
                <p>No. Revisaremos las solicitudes para proteger la calidad del programa.</p>
            </article>

            <article>
                <h3>¿Qué pasa después del lanzamiento?</h3>
                <p>Cuando ApexCash Premium sea comercial, los Founder Members tendrán ventajas exclusivas.</p>
            </article>

            <article>
                <h3>¿Habrá comunidad privada?</h3>
                <p>Sí, más adelante abriremos una comunidad privada para los Founder Members más activos.</p>
            </article>
        </div>
    </section>

    <section class="apex-final-cta">
        <div>
            <span>Founder Members 2026</span>
            <h2>Solicita tu acceso antes del lanzamiento oficial</h2>
            <p>
                Estamos buscando a los primeros jugadores que quieran ayudarnos a construir ApexCash Trainer.
            </p>

            <div class="apex-actions centered">
                @auth
                    <a href="{{ route('dashboard') }}" class="apex-btn apex-btn-primary">
                        🚀 Solicitar acceso Founder
                    </a>
                @else
                    <a href="{{ route('register') }}" class="apex-btn apex-btn-primary">
                        Crear cuenta gratuita
                    </a>
                @endauth

                <a href="{{ url('/') }}" class="apex-btn apex-btn-secondary">
                    Volver al inicio
                </a>
            </div>
        </div>
    </section>

    <footer class="apex-footer">
        <div class="footer-brand">
            <strong>APEXCASH</strong>
            <span>© {{ date('Y') }}</span>
        </div>

        <nav class="footer-links">
            <a href="{{ route('privacy') }}">Privacy</a>
            <a href="{{ route('cookies') }}">Cookies</a>
            <a href="{{ route('terms') }}">Terms</a>
            <a href="{{ route('contact') }}">Contact</a>
        </nav>
    </footer>

</div>

<script src="{{ asset('assets/js/apexcash-cookies.js') }}"></script>
</body>
</html>