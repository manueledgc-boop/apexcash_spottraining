<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <title>ApexCash - Poker Training</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?php echo e(asset('assets/css/apexcash-landing.css')); ?>" rel="stylesheet">
</head>
<body>

<div class="page">

    <header class="topbar">
        <a href="<?php echo e(url('/')); ?>" class="brand">
            <div class="brand-mark">A</div>
            <div>
                <strong>APEXCASH</strong>
                <span><?php echo e(__('landing.brand_subtitle')); ?></span>
            </div>
        </a>

        <nav class="nav">
            <a href="#training"><?php echo e(__('landing.nav_training')); ?></a>
            <a href="#method"><?php echo e(__('landing.nav_method')); ?></a>
            <a href="#progress"><?php echo e(__('landing.nav_progress')); ?></a>

            <div class="language-selector">
                <select onchange="window.location.href=this.value">
                    <option value="<?php echo e(route('lang.switch', 'es')); ?>" <?php echo e(app()->getLocale() == 'es' ? 'selected' : ''); ?>>
                        Español
                    </option>
                    <option value="<?php echo e(route('lang.switch', 'en')); ?>" <?php echo e(app()->getLocale() == 'en' ? 'selected' : ''); ?>>
                        English
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
            <div class="badge"><?php echo e(__('landing.badge')); ?></div>

            <h1><?php echo e(__('landing.hero_title')); ?></h1>

            <p><?php echo e(__('landing.hero_subtitle')); ?></p>

            <div class="hero-actions">
                <a href="<?php echo e(route('login')); ?>" class="btn secondary">
                    <?php echo e(__('landing.login')); ?>

                </a>

                <a href="<?php echo e(route('register')); ?>" class="btn primary">
                    <?php echo e(__('landing.register')); ?>

                </a>
            </div>

            <div class="hero-stats">
                <div>
                    <strong><?php echo e(__('landing.stat_1_value')); ?></strong>
                    <span><?php echo e(__('landing.stat_1_label')); ?></span>
                </div>
                <div>
                    <strong><?php echo e(__('landing.stat_2_value')); ?></strong>
                    <span><?php echo e(__('landing.stat_2_label')); ?></span>
                </div>
                <div>
                    <strong><?php echo e(__('landing.stat_3_value')); ?></strong>
                    <span><?php echo e(__('landing.stat_3_label')); ?></span>
                </div>
            </div>
        </section>

        <section class="training-preview" aria-label="ApexCash training preview">
            <div class="preview-glow"></div>

            <div class="trainer-card">
                <div class="trainer-top">
                    <span><?php echo e(__('landing.preview_badge')); ?></span>
                    <strong><?php echo e(__('landing.preview_title')); ?></strong>
                </div>

                <div class="mini-table">
                    <div class="mini-seat seat-top"><?php echo e(__('landing.preview_villain')); ?></div>
                    <div class="mini-seat seat-left">BTN</div>
                    <div class="mini-seat seat-right">BB</div>

                    <div class="mini-pot">
                        <span><?php echo e(__('landing.preview_pot')); ?></span>
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
                    <span><?php echo e(__('landing.preview_feedback_label')); ?></span>
                    <p><?php echo e(__('landing.preview_feedback_text')); ?></p>
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
                <span><?php echo e(__('landing.mode_1_status')); ?></span>
                <h3><?php echo e(__('landing.mode_1_title')); ?></h3>
                <p><?php echo e(__('landing.mode_1_text')); ?></p>
                <strong><?php echo e(__('landing.mode_1_cta')); ?></strong>
            </article>

            <article class="mode-card">
                <span><?php echo e(__('landing.mode_2_status')); ?></span>
                <h3><?php echo e(__('landing.mode_2_title')); ?></h3>
                <p><?php echo e(__('landing.mode_2_text')); ?></p>
                <strong><?php echo e(__('landing.mode_2_cta')); ?></strong>
            </article>

            <article class="mode-card">
                <span><?php echo e(__('landing.mode_3_status')); ?></span>
                <h3><?php echo e(__('landing.mode_3_title')); ?></h3>
                <p><?php echo e(__('landing.mode_3_text')); ?></p>
                <strong><?php echo e(__('landing.mode_3_cta')); ?></strong>
            </article>
        </div>
    </section>

    <section class="final-cta">
        <span><?php echo e(__('landing.final_kicker')); ?></span>
        <h2><?php echo e(__('landing.final_title')); ?></h2>
        <p><?php echo e(__('landing.final_text')); ?></p>

        <div class="hero-actions centered">
            <a href="<?php echo e(route('login')); ?>" class="btn secondary">
                <?php echo e(__('landing.login')); ?>

            </a>

            <a href="<?php echo e(route('register')); ?>" class="btn primary">
                <?php echo e(__('landing.register')); ?>

            </a>
        </div>
    </section>

</div>

</body>
</html><?php /**PATH C:\laragon\www\apexcash\resources\views/welcome.blade.php ENDPATH**/ ?>