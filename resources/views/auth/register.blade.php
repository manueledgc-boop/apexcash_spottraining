<x-guest-layout>
    <div class="auth-form-header">
        <span>{{ __('auth.register.badge') }}</span>
        <h2>{{ __('auth.register.title') }}</h2>
        <p>{{ __('auth.register.subtitle') }}</p>
    </div>

    <div class="auth-benefits">
        <div>
            <strong>{{ __('auth.register.benefits.xp.title') }}</strong>
            <span>{{ __('auth.register.benefits.xp.text') }}</span>
        </div>

        <div>
            <strong>{{ __('auth.register.benefits.leaks.title') }}</strong>
            <span>{{ __('auth.register.benefits.leaks.text') }}</span>
        </div>

        <div>
            <strong>{{ __('auth.register.benefits.spots.title') }}</strong>
            <span>{{ __('auth.register.benefits.spots.text') }}</span>
        </div>
    </div>

    <div class="auth-social">
        <a href="{{ route('google.redirect') }}" class="auth-google-btn">
            <svg viewBox="0 0 48 48" aria-hidden="true">
                <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.6 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12S17.4 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.3-.4-3.5z"/>
                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 19 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.5-5.2l-6.2-5.2C29.2 35.9 26.7 37 24 37c-5.2 0-9.6-3.3-11.2-8l-6.6 5.1C9.5 39.5 16.2 44 24 44z"/>
                <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-1.1 3.1-3.3 5.6-6.2 7.2l6.2 5.2C39.9 37 44 31.1 44 24c0-1.3-.1-2.3-.4-3.5z"/>
            </svg>

            <span>{{ __('auth.google.continue') }}</span>
        </a>

        <div class="auth-divider">
            <span>{{ __('auth.google.or_email') }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <label for="name">{{ __('auth.fields.name') }}</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autocomplete="name"
                placeholder="{{ __('auth.placeholders.name') }}"
            >
            <x-input-error :messages="$errors->get('name')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="email">{{ __('auth.fields.email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                placeholder="{{ __('auth.placeholders.email') }}"
            >
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="password">{{ __('auth.fields.password') }}</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="{{ __('auth.placeholders.new_password') }}"
            >
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="password_confirmation">{{ __('auth.fields.password_confirmation') }}</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="{{ __('auth.placeholders.password_confirmation') }}"
            >
            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
        </div>

        <button type="submit" class="auth-submit">
            {{ __('auth.register.submit') }}
        </button>

        <div class="auth-switch">
            <span>{{ __('auth.register.already_registered') }}</span>
            <a href="{{ route('login') }}">{{ __('auth.register.login') }}</a>
        </div>
    </form>
</x-guest-layout>