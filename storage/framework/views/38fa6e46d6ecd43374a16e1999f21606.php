<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo e(__('landing.meta_title')); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo e(__('landing.meta_description')); ?>">

    <link href="<?php echo e(asset('assets/css/apexcash-landing.css')); ?>?v=20260615logo2" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/apexcash-cookies.css')); ?>" rel="stylesheet">
</head>
<body>

<div class="page landing-v2">

    <header class="topbar">
        <a href="<?php echo e(url('/')); ?>" class="brand">
            <img
                src="<?php echo e(asset('images/apexcash-icon.png')); ?>"
                alt="ApexCash"
                class="brand-logo"
            >

            <div class="brand-text">
                <strong>APEXCASH</strong>
                <span><?php echo e(__('landing.brand_subtitle')); ?></span>
            </div>
        </a>

        <nav class="nav">
            <a href="#training"><?php echo e(__('landing.nav_training')); ?></a>
            <a href="#method"><?php echo e(__('landing.nav_method')); ?></a>
            <a href="#progress"><?php echo e(__('landing.nav_progress')); ?></a>
            <a href="#modules"><?php echo e(__('landing.nav_modules')); ?></a>

            <div class="language-selector">
                <select onchange="window.location.href=this.value">
                    <option value="<?php echo e(route('lang.switch', 'es')); ?>" <?php echo e(app()->getLocale() == 'es' ? 'selected' : ''); ?>>
                        <?php echo e(__('landing.language_es')); ?>

                    </option>
                    <option value="<?php echo e(route('lang.switch', 'en')); ?>" <?php echo e(app()->getLocale() == 'en' ? 'selected' : ''); ?>>
                        <?php echo e(__('landing.language_en')); ?>

                    </option>
                </select>
            </div>

            <a href="<?php echo e(route('login')); ?>" class="login-link">
                <?php echo e(__('landing.login')); ?>

            </a>
        </nav>
    </header>

    <main class="hero">
        <section class="hero-content">
            <div class="badge"><?php echo e(__('landing.hero_badge')); ?></div>

            <h1><?php echo e(__('landing.hero_title')); ?></h1>

            <p><?php echo e(__('landing.hero_text')); ?></p>

            <div class="hero-actions">
                <a href="<?php echo e(route('register')); ?>" class="btn primary">
                    <?php echo e(__('landing.hero_primary')); ?>

                </a>

                <a href="<?php echo e(route('login')); ?>" class="btn secondary">
                    <?php echo e(__('landing.hero_secondary')); ?>

                </a>
            </div>

            <div class="hero-stats">
                <div>
                    <strong><?php echo e(__('landing.hero_stat_1_value')); ?></strong>
                    <span><?php echo e(__('landing.hero_stat_1_label')); ?></span>
                </div>
                <div>
                    <strong><?php echo e(__('landing.hero_stat_2_value')); ?></strong>
                    <span><?php echo e(__('landing.hero_stat_2_label')); ?></span>
                </div>
                <div>
                    <strong><?php echo e(__('landing.hero_stat_3_value')); ?></strong>
                    <span><?php echo e(__('landing.hero_stat_3_label')); ?></span>
                </div>
            </div>
        </section>

        <section class="training-preview" aria-label="<?php echo e(__('landing.preview_aria')); ?>">
            <div class="preview-glow"></div>

            <div class="trainer-card">
                <div class="trainer-top">
                    <span><?php echo e(__('landing.preview_badge')); ?></span>
                    <strong><?php echo e(__('landing.preview_title')); ?></strong>
                </div>

                <div class="mini-table">
                    <div class="mini-seat seat-top"><?php echo e(__('landing.preview_villain')); ?></div>
                    <div class="mini-seat seat-left"><?php echo e(__('landing.preview_sb')); ?></div>
                    <div class="mini-seat seat-right"><?php echo e(__('landing.preview_bb')); ?></div>

                    <div class="mini-pot">
                        <span><?php echo e(__('landing.preview_pot')); ?></span>
                        <strong><?php echo e(__('landing.preview_pot_value')); ?></strong>
                    </div>

                    <div class="mini-card card-one">A♠</div>
                    <div class="mini-card card-two">J♥</div>

                    <div class="mini-hero"><?php echo e(__('landing.preview_hero')); ?></div>
                </div>

                <div class="decision-row">
                    <button><?php echo e(__('landing.action_fold')); ?></button>
                    <button class="is-best"><?php echo e(__('landing.action_call')); ?></button>
                    <button><?php echo e(__('landing.action_raise')); ?></button>
                </div>

                <div class="feedback-preview">
                    <span><?php echo e(__('landing.feedback_label')); ?></span>
                    <p><?php echo e(__('landing.feedback_text')); ?></p>
                </div>
            </div>
        </section>
    </main>

    <section id="training" class="section-block">
        <div class="section-heading">
            <span><?php echo e(__('landing.training_kicker')); ?></span>
            <h2><?php echo e(__('landing.training_title')); ?></h2>
            <p><?php echo e(__('landing.training_text')); ?></p>
        </div>

        <div class="features">
            <article>
                <span>01</span>
                <h3><?php echo e(__('landing.feature_1_title')); ?></h3>
                <p><?php echo e(__('landing.feature_1_text')); ?></p>
            </article>

            <article>
                <span>02</span>
                <h3><?php echo e(__('landing.feature_2_title')); ?></h3>
                <p><?php echo e(__('landing.feature_2_text')); ?></p>
            </article>

            <article>
                <span>03</span>
                <h3><?php echo e(__('landing.feature_3_title')); ?></h3>
                <p><?php echo e(__('landing.feature_3_text')); ?></p>
            </article>
        </div>
    </section>

    <section id="method" class="split-section">
        <div>
            <span class="section-kicker"><?php echo e(__('landing.method_kicker')); ?></span>
            <h2><?php echo e(__('landing.method_title')); ?></h2>
            <p><?php echo e(__('landing.method_text')); ?></p>
        </div>

        <div class="method-grid">
            <article>
                <span><?php echo e(__('landing.method_card_1_label')); ?></span>
                <h3><?php echo e(__('landing.method_card_1_title')); ?></h3>
                <p><?php echo e(__('landing.method_card_1_text')); ?></p>
            </article>

            <article>
                <span><?php echo e(__('landing.method_card_2_label')); ?></span>
                <h3><?php echo e(__('landing.method_card_2_title')); ?></h3>
                <p><?php echo e(__('landing.method_card_2_text')); ?></p>
            </article>
        </div>
    </section>

    <section id="progress" class="section-block">
        <div class="section-heading">
            <span><?php echo e(__('landing.progress_kicker')); ?></span>
            <h2><?php echo e(__('landing.progress_title')); ?></h2>
            <p><?php echo e(__('landing.progress_text')); ?></p>
        </div>

        <div class="mode-grid">
            <article class="mode-card active">
                <span><?php echo e(__('landing.stage_status_complete')); ?></span>
                <h3><?php echo e(__('landing.stage_preflop_title')); ?></h3>
                <p><?php echo e(__('landing.stage_preflop_text')); ?></p>
            </article>

            <article class="mode-card active">
                <span><?php echo e(__('landing.stage_status_complete')); ?></span>
                <h3><?php echo e(__('landing.stage_flop_title')); ?></h3>
                <p><?php echo e(__('landing.stage_flop_text')); ?></p>
            </article>

            <article class="mode-card active">
                <span><?php echo e(__('landing.stage_status_complete')); ?></span>
                <h3><?php echo e(__('landing.stage_turn_title')); ?></h3>
                <p><?php echo e(__('landing.stage_turn_text')); ?></p>
            </article>

            <article class="mode-card active">
                <span><?php echo e(__('landing.stage_status_complete')); ?></span>
                <h3><?php echo e(__('landing.stage_river_title')); ?></h3>
                <p><?php echo e(__('landing.stage_river_text')); ?></p>
            </article>
        </div>
    </section>

    <section id="modules" class="split-section">
        <div>
            <span class="section-kicker"><?php echo e(__('landing.modules_kicker')); ?></span>
            <h2><?php echo e(__('landing.modules_title')); ?></h2>
            <p><?php echo e(__('landing.modules_text')); ?></p>
        </div>

        <div class="method-grid">
            <article>
                <span><?php echo e(__('landing.module_card_1_label')); ?></span>
                <h3><?php echo e(__('landing.module_card_1_title')); ?></h3>
                <p><?php echo e(__('landing.module_card_1_text')); ?></p>
            </article>

            <article>
                <span><?php echo e(__('landing.module_card_2_label')); ?></span>
                <h3><?php echo e(__('landing.module_card_2_title')); ?></h3>
                <p><?php echo e(__('landing.module_card_2_text')); ?></p>
            </article>
        </div>
    </section>

    <section class="final-cta">
        <span><?php echo e(__('landing.final_kicker')); ?></span>
        <h2><?php echo e(__('landing.final_title')); ?></h2>
        <p><?php echo e(__('landing.final_text')); ?></p>

        <div class="hero-actions centered">
            <a href="<?php echo e(route('register')); ?>" class="btn primary">
                <?php echo e(__('landing.register')); ?>

            </a>

            <a href="<?php echo e(route('login')); ?>" class="btn secondary">
                <?php echo e(__('landing.login')); ?>

            </a>
        </div>
    </section>

</div>

<div id="apexcash-cookie-banner" class="cookie-banner">
    <div>
        <strong><?php echo e(__('landing.cookies_title')); ?></strong>
        <p><?php echo e(__('landing.cookies_text')); ?></p>
    </div>

    <div class="cookie-actions">
        <a href="<?php echo e(route('cookies')); ?>"><?php echo e(__('landing.cookies_more')); ?></a>
        <button type="button" id="accept-cookies"><?php echo e(__('landing.cookies_accept')); ?></button>
    </div>
</div>

<script src="<?php echo e(asset('assets/js/apexcash-cookies.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\laragon\www\apexcash\resources\views/welcome.blade.php ENDPATH**/ ?>