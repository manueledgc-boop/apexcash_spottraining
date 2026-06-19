<x-guest-layout>
    <div class="auth-form-header">
        <span>{{ __('auth.login.badge') }}</span>
        <h2>{{ __('auth.login.title') }}</h2>
        <p>{{ __('auth.login.subtitle') }}</p>
    </div>

    <x-auth-session-status class="auth-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <label for="email">{{ __('auth.fields.email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
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
                autocomplete="current-password"
                placeholder="{{ __('auth.placeholders.password') }}"
            >
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <div class="auth-options-row">
            <label for="remember_me" class="auth-check">
                <input id="remember_me" type="checkbox" name="remember">
                <span>{{ __('auth.login.remember') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">{{ __('auth.login.forgot_password') }}</a>
            @endif
        </div>

        <button type="submit" class="auth-submit">
            {{ __('auth.login.submit') }}
        </button>

        <div class="auth-switch">
            <span>{{ __('auth.login.no_account') }}</span>
            <a href="{{ route('register') }}">{{ __('auth.login.create_account') }}</a>
        </div>
    </form>
</x-guest-layout>
