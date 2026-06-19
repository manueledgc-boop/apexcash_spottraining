<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('legal.cookies_meta_title') }}</title>

    <link href="{{ asset('assets/css/apexcash-legal.css') }}" rel="stylesheet">
</head>
<body>
    <main class="legal-page">
        <section class="legal-card">
            <span class="legal-badge">{{ __('legal.badge') }}</span>

            <h1>{{ __('legal.cookies_title') }}</h1>

            <p>{{ __('legal.cookies_intro') }}</p>

            <h2>{{ __('legal.technical_title') }}</h2>
            <p>{{ __('legal.technical_text') }}</p>

            <h2>{{ __('legal.analytics_title') }}</h2>
            <p>{{ __('legal.analytics_text') }}</p>

            <h2>{{ __('legal.acceptance_title') }}</h2>
            <p>{{ __('legal.acceptance_text') }}</p>

            <a href="{{ route('home') }}" class="legal-back">{{ __('legal.back_home') }}</a>
        </section>
    </main>
</body>
</html>
