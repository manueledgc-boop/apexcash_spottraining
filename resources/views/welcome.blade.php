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
        <a href="{{ url('/') }}" class="brand">
            <div class="brand-mark">A</div>
            <div>
                <strong>APEXCASH</strong>
                <span>{{ __('landing.brand_subtitle') }}</span>
            </div>
        </a>

        <nav class="nav">
            <a href="#training">{{ __('landing.nav_training') }}</a>
            <a href="#method">{{ __('landing.nav_method') }}</a>
            <a href="#progress">{{ __('landing.nav_progress') }}</a>

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
                {{ __('landing.login') }}
            </a>
        </nav>
    </header>

    <main class="hero">
        <section class="hero-content">
            <div class="badge">{{ __('landing.badge') }}</div>

            <h1>{{ __('landing.hero_title') }}</h1>

            <p>{{ __('landing.hero_subtitle') }}</p>

            <div class="hero-actions">
                <a href="{{ route('login') }}" class="btn secondary">
                    {{ __('landing.login') }}
                </a>

                <a href="{{ route('register') }}" class="btn primary">
                    {{ __('landing.register') }}
                </a>
            </div>

            <div class="hero-stats">
                <div>
                    <strong>{{ __('landing.stat_1_value') }}</strong>
                    <span>{{ __('landing.stat_1_label') }}</span>
                </div>
                <div>
                    <strong>{{ __('landing.stat_2_value') }}</strong>
                    <span>{{ __('landing.stat_2_label') }}</span>
                </div>
                <div>
                    <strong>{{ __('landing.stat_3_value') }}</strong>
                    <span>{{ __('landing.stat_3_label') }}</span>
                </div>
            </div>
        </section>

        <section class="training-preview" aria-label="ApexCash training preview">
            <div class="preview-glow"></div>

            <div class="trainer-card">
                <div class="trainer-top">
                    <span>{{ __('landing.preview_badge') }}</span>
                    <strong>{{ __('landing.preview_title') }}</strong>
                </div>

                <div class="mini-table">
                    <div class="mini-seat seat-top">{{ __('landing.preview_villain') }}</div>
                    <div class="mini-seat seat-left">BTN</div>
                    <div class="mini-seat seat-right">BB</div>

                    <div class="mini-pot">
                        <span>{{ __('landing.preview_pot') }}</span>
                        <strong>4.0 BB</strong>
                    </div>

                    <div class="mini-card card-one">A♠</div>
                    <div class="mini-card card-two">K♥</div>

                    <div class="mini-hero">HERO · SB</div>
                </div>

                <div class="decision-row">
                    <button>Fold</button>
                    <button>Call</button>
                    <button class="is-best">3Bet</button>
                </div>

                <div class="feedback-preview">
                    <span>{{ __('landing.preview_feedback_label') }}</span>
                    <p>{{ __('landing.preview_feedback_text') }}</p>
                </div>
            </div>
        </section>
    </main>

    <section id="training" class="section-block">
        <div class="section-heading">
            <span>{{ __('landing.training_kicker') }}</span>
            <h2>{{ __('landing.training_title') }}</h2>
            <p>{{ __('landing.training_text') }}</p>
        </div>

        <div class="features">
            <article>
                <span>01</span>
                <h3>{{ __('landing.feature_1_title') }}</h3>
                <p>{{ __('landing.feature_1_text') }}</p>
            </article>

            <article>
                <span>02</span>
                <h3>{{ __('landing.feature_2_title') }}</h3>
                <p>{{ __('landing.feature_2_text') }}</p>
            </article>

            <article>
                <span>03</span>
                <h3>{{ __('landing.feature_3_title') }}</h3>
                <p>{{ __('landing.feature_3_text') }}</p>
            </article>
        </div>
    </section>

    <section id="method" class="split-section">
        <div>
            <span class="section-kicker">{{ __('landing.method_kicker') }}</span>
            <h2>{{ __('landing.method_title') }}</h2>
            <p>{{ __('landing.method_text') }}</p>
        </div>

        <div class="method-grid">
            <article>
                <span>{{ __('landing.method_card_1_label') }}</span>
                <h3>{{ __('landing.method_card_1_title') }}</h3>
                <p>{{ __('landing.method_card_1_text') }}</p>
            </article>

            <article>
                <span>{{ __('landing.method_card_2_label') }}</span>
                <h3>{{ __('landing.method_card_2_title') }}</h3>
                <p>{{ __('landing.method_card_2_text') }}</p>
            </article>
        </div>
    </section>

    <section id="progress" class="section-block">
        <div class="section-heading">
            <span>{{ __('landing.progress_kicker') }}</span>
            <h2>{{ __('landing.progress_title') }}</h2>
            <p>{{ __('landing.progress_text') }}</p>
        </div>

        <div class="mode-grid">
            <article class="mode-card active">
                <span>{{ __('landing.mode_1_status') }}</span>
                <h3>{{ __('landing.mode_1_title') }}</h3>
                <p>{{ __('landing.mode_1_text') }}</p>
                <strong>{{ __('landing.mode_1_cta') }}</strong>
            </article>

            <article class="mode-card">
                <span>{{ __('landing.mode_2_status') }}</span>
                <h3>{{ __('landing.mode_2_title') }}</h3>
                <p>{{ __('landing.mode_2_text') }}</p>
                <strong>{{ __('landing.mode_2_cta') }}</strong>
            </article>

            <article class="mode-card">
                <span>{{ __('landing.mode_3_status') }}</span>
                <h3>{{ __('landing.mode_3_title') }}</h3>
                <p>{{ __('landing.mode_3_text') }}</p>
                <strong>{{ __('landing.mode_3_cta') }}</strong>
            </article>
        </div>
    </section>

    <section class="final-cta">
        <span>{{ __('landing.final_kicker') }}</span>
        <h2>{{ __('landing.final_title') }}</h2>
        <p>{{ __('landing.final_text') }}</p>

        <div class="hero-actions centered">
            <a href="{{ route('login') }}" class="btn secondary">
                {{ __('landing.login') }}
            </a>

            <a href="{{ route('register') }}" class="btn primary">
                {{ __('landing.register') }}
            </a>
        </div>
    </section>

</div>

</body>
</html>