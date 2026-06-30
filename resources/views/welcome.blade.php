<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('landing.meta_title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('landing.meta_description') }}">

    <link href="{{ asset('assets/css/apexcash-landing.css') }}?v=20260626v3" rel="stylesheet">
    <link href="{{ asset('assets/css/apexcash-cookies.css') }}" rel="stylesheet">
</head>
<body>

<div class="apex-landing">

    <header class="apex-nav">
        <a href="{{ url('/') }}" class="apex-brand">
            <img src="{{ asset('images/apexcash-icon.png') }}" alt="ApexCash" class="apex-brand-logo">

            <div>
                <strong>APEXCASH</strong>
                <span>{{ __('landing.brand_subtitle') }}</span>
            </div>
        </a>

        <nav class="apex-nav-links">
            <a href="#product">{{ __('landing.nav_product') }}</a>
            <a href="#roadmap">{{ __('landing.nav_roadmap') }}</a>
            <a href="#handlab">{{ __('landing.nav_handlab') }}</a>
            <a href="#plans">{{ __('landing.nav_plans') }}</a>

            <div class="language-selector">
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('lang.switch', 'es') }}" {{ app()->getLocale() === 'es' ? 'selected' : '' }}>
                        ES
                    </option>
                    <option value="{{ route('lang.switch', 'en') }}" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>
                        EN
                    </option>
                </select>
            </div>

            <a href="{{ route('login') }}" class="apex-login">{{ __('landing.login') }}</a>

            <a href="{{ route('register') }}" class="apex-nav-cta">
                {{ __('landing.nav_cta') }}
            </a>
        </nav>
    </header>

    <main class="apex-hero">
    <section class="apex-hero-copy">
        <div class="apex-badge">
            🚀 {{ __('landing.founder_memberes') }}
        </div>

        <h1>
            {{ __('landing.forma_parte_nacimiento') }}
        </h1>

        <p>
            {{ __('landing.estamos_seleccionando') }}
            <strong>{{ __('landing.fecha_lanzamiento') }}</strong>.
        </p>

        <div class="apex-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="apex-btn apex-btn-primary">
                    🚀 {{ __('landing.solicitar_acceso') }}
                </a>
            @else
                <a href="{{ route('register') }}" class="apex-btn apex-btn-primary">
                    {{ __('landing.crear_cuenta_gratuita') }}
                </a>
            @endauth

            <a href="{{ route('founder-members') }}" class="apex-btn apex-btn-secondary">
                {{ __('landing.conocer_programa') }}
            </a>
        </div>

        <div class="apex-trust-row">
            <span>🏅 Founder Badge 2026</span>
            <span>🎯 {{ __('landing.acceso_anticipado') }}</span>
            <span>📅 {{ __('landing.lanzamiento1') }}</span>
        </div>
    </section>

    <section class="apex-product-frame apex-hero-frame">
        <div class="browser-bar">
            <span></span><span></span><span></span>
            <small>apexcashtrainer.com</small>
        </div>

        <img src="{{ asset('images/welcome1.png') }}" alt="ApexCash Trainer Founder Members">
    </section>
</main>

    <section id="product" class="apex-section">
        <div class="apex-section-head">
            <span>{{ __('landing.product_kicker') }}</span>
            <h2>{{ __('landing.product_title') }}</h2>
            <p>{{ __('landing.product_text') }}</p>
        </div>

        <div class="apex-feature-grid">
            <article>
                <strong>01</strong>
                <h3>{{ __('landing.product_card_1_title') }}</h3>
                <p>{{ __('landing.product_card_1_text') }}</p>
            </article>

            <article>
                <strong>02</strong>
                <h3>{{ __('landing.product_card_2_title') }}</h3>
                <p>{{ __('landing.product_card_2_text') }}</p>
            </article>

            <article>
                <strong>03</strong>
                <h3>{{ __('landing.product_card_3_title') }}</h3>
                <p>{{ __('landing.product_card_3_text') }}</p>
            </article>
        </div>
    </section>

    <section class="apex-showcase">
        <div class="apex-showcase-copy">
            <span>{{ __('landing.spot_kicker') }}</span>
            <h2>{{ __('landing.spot_title') }}</h2>
            <p>{{ __('landing.spot_text') }}</p>

            <ul class="apex-check-list">
                <li>{{ __('landing.spot_bullet_1') }}</li>
                <li>{{ __('landing.spot_bullet_2') }}</li>
                <li>{{ __('landing.spot_bullet_3') }}</li>
            </ul>
        </div>

        <div class="apex-product-frame">
            <div class="browser-bar">
                <span></span><span></span><span></span>
                <small>{{ __('landing.spot_image_label') }}</small>
            </div>

            <img src="{{ asset('images/welcome2.png') }}" alt="{{ __('landing.spot_image_alt') }}">
        </div>
    </section>

    <section id="roadmap" class="apex-section apex-roadmap-section">
        <div class="apex-section-head">
            <span>{{ __('landing.roadmap_kicker') }}</span>
            <h2>{{ __('landing.roadmap_title') }}</h2>
            <p>{{ __('landing.roadmap_text') }}</p>
        </div>

        <div class="apex-roadmap">
            <article>
                <span>1</span>
                <h3>{{ __('landing.stage_preflop') }}</h3>
                <p>{{ __('landing.stage_preflop_text') }}</p>
            </article>

            <article>
                <span>2</span>
                <h3>{{ __('landing.stage_flop') }}</h3>
                <p>{{ __('landing.stage_flop_text') }}</p>
            </article>

            <article>
                <span>3</span>
                <h3>{{ __('landing.stage_turn') }}</h3>
                <p>{{ __('landing.stage_turn_text') }}</p>
            </article>

            <article>
                <span>4</span>
                <h3>{{ __('landing.stage_river') }}</h3>
                <p>{{ __('landing.stage_river_text') }}</p>
            </article>

            <article class="premium-step">
                <span>5</span>
                <h3>{{ __('landing.stage_mastery') }}</h3>
                <p>{{ __('landing.stage_mastery_text') }}</p>
            </article>

            <article class="premium-step">
                <span>6</span>
                <h3>{{ __('landing.stage_certification') }}</h3>
                <p>{{ __('landing.stage_certification_text') }}</p>
            </article>
        </div>
    </section>

    <section class="apex-showcase reverse">
        <div class="apex-product-frame">
            <div class="browser-bar">
                <span></span><span></span><span></span>
                <small>{{ __('landing.dashboard_image_label') }}</small>
            </div>

            <img src="{{ asset('images/welcome3.png') }}" alt="{{ __('landing.dashboard_image_alt') }}">
        </div>

        <div class="apex-showcase-copy">
            <span>{{ __('landing.dashboard_kicker') }}</span>
            <h2>{{ __('landing.dashboard_title') }}</h2>
            <p>{{ __('landing.dashboard_text') }}</p>

            <ul class="apex-check-list">
                <li>{{ __('landing.dashboard_bullet_1') }}</li>
                <li>{{ __('landing.dashboard_bullet_2') }}</li>
                <li>{{ __('landing.dashboard_bullet_3') }}</li>
            </ul>
        </div>
    </section>

    <section id="handlab" class="apex-showcase">
        <div class="apex-showcase-copy">
            <span>{{ __('landing.handlab_kicker') }}</span>
            <h2>{{ __('landing.handlab_title') }}</h2>
            <p>{{ __('landing.handlab_text') }}</p>

            <ul class="apex-check-list">
                <li>{{ __('landing.handlab_bullet_1') }}</li>
                <li>{{ __('landing.handlab_bullet_2') }}</li>
                <li>{{ __('landing.handlab_bullet_3') }}</li>
            </ul>
        </div>

        <div class="apex-product-frame">
            <div class="browser-bar">
                <span></span><span></span><span></span>
                <small>{{ __('landing.handlab_image_label') }}</small>
            </div>

            <img src="{{ asset('images/welcome4.png') }}" alt="{{ __('landing.handlab_image_alt') }}">
        </div>
    </section>

    <section id="plans" class="apex-section apex-pricing-section">
        <div class="apex-section-head">
            <span>{{ __('landing.plans_kicker') }}</span>
            <h2>{{ __('landing.plans_title') }}</h2>
            <p>{{ __('landing.plans_text') }}</p>
        </div>

        <div class="apex-pricing-grid">
            <article class="apex-plan">
                <span class="plan-badge">{{ __('landing.free_badge') }}</span>
                <h3>{{ __('landing.free_title') }}</h3>
                <p class="plan-price">{{ __('landing.free_price') }}</p>

                <ul>
                    <li>{{ __('landing.free_item_1') }}</li>
                    <li>{{ __('landing.free_item_2') }}</li>
                    <li>{{ __('landing.free_item_3') }}</li>
                    <li>{{ __('landing.free_item_4') }}</li>
                    <li>{{ __('landing.free_item_5') }}</li>
                    <li>{{ __('landing.free_item_6') }}</li>
                </ul>

                <a href="{{ route('register') }}" class="apex-btn apex-btn-secondary full">
                    {{ __('landing.free_cta') }}
                </a>
            </article>

            <article class="apex-plan premium">
                <span class="plan-badge">{{ __('landing.premium_badge') }}</span>
                <h3>{{ __('landing.premium_title') }}</h3>
                <p class="plan-price">{{ __('landing.premium_price') }}</p>

                <ul>
                    <li>{{ __('landing.premium_item_1') }}</li>
                    <li>{{ __('landing.premium_item_2') }}</li>
                    <li>{{ __('landing.premium_item_3') }}</li>
                    <li>{{ __('landing.premium_item_4') }}</li>
                    <li>{{ __('landing.premium_item_5') }}</li>
                    <li>{{ __('landing.premium_item_6') }}</li>
                </ul>

                <a href="{{ route('register') }}" class="apex-btn apex-btn-primary full">
                    {{ __('landing.premium_cta') }}
                </a>
            </article>
        </div>
    </section>

    <section class="apex-showcase reverse">
        <div class="apex-product-frame">
            <div class="browser-bar">
                <span></span><span></span><span></span>
                <small>{{ __('landing.cert_image_label') }}</small>
            </div>

            <img src="{{ asset('images/welcome5.png') }}" alt="{{ __('landing.cert_image_alt') }}">
        </div>

        <div class="apex-showcase-copy">
            <span>{{ __('landing.cert_kicker') }}</span>
            <h2>{{ __('landing.cert_title') }}</h2>
            <p>{{ __('landing.cert_text') }}</p>

            <ul class="apex-check-list">
                <li>{{ __('landing.cert_bullet_1') }}</li>
                <li>{{ __('landing.cert_bullet_2') }}</li>
                <li>{{ __('landing.cert_bullet_3') }}</li>
            </ul>
        </div>
    </section>

    <section class="apex-faq">
        <div class="apex-section-head">
            <span>{{ __('landing.faq_kicker') }}</span>
            <h2>{{ __('landing.faq_title') }}</h2>
        </div>

        <div class="faq-grid">
            <article>
                <h3>{{ __('landing.faq_1_q') }}</h3>
                <p>{{ __('landing.faq_1_a') }}</p>
            </article>

            <article>
                <h3>{{ __('landing.faq_2_q') }}</h3>
                <p>{{ __('landing.faq_2_a') }}</p>
            </article>

            <article>
                <h3>{{ __('landing.faq_3_q') }}</h3>
                <p>{{ __('landing.faq_3_a') }}</p>
            </article>

            <article>
                <h3>{{ __('landing.faq_4_q') }}</h3>
                <p>{{ __('landing.faq_4_a') }}</p>
            </article>
        </div>
    </section>

    <section class="apex-final-cta">
        <div>
            <span>{{ __('landing.final_kicker') }}</span>
            <h2>{{ __('landing.final_title') }}</h2>
            <p>{{ __('landing.final_text') }}</p>

            <div class="apex-actions centered">
                <a href="{{ route('register') }}" class="apex-btn apex-btn-primary">
                    {{ __('landing.final_primary') }}
                </a>

                <a href="{{ route('login') }}" class="apex-btn apex-btn-secondary">
                    {{ __('landing.final_secondary') }}
                </a>
            </div>
        </div>

        <div class="apex-final-image">
            <img src="{{ asset('images/welcome6.png') }}" alt="{{ __('landing.final_image_alt') }}">
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

<div id="apexcash-cookie-banner" class="cookie-banner" hidden>
    <div class="cookie-copy">
        <strong>🍪 {{ __('landing.cookies_title') }}</strong>
        <p>{{ __('landing.cookies_text') }}</p>
    </div>

    <div class="cookie-actions">
        <button type="button" id="cookies-essential" class="cookie-link-btn">
            Solo necesarias
        </button>

        <button type="button" id="cookies-accept" class="cookie-primary-btn">
            Aceptar todas
        </button>
    </div>
</div>

<script src="{{ asset('assets/js/apexcash-cookies.js') }}"></script>
</body>
</html>