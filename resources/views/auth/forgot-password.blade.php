<x-guest-layout>
    <div class="auth-form-header">
        <span>{{ __('auth.forgot.badge') }}</span>
        <h2>{{ __('auth.forgot.title') }}</h2>
        <p>{{ __('auth.forgot.subtitle') }}</p>
    </div>

    <x-auth-session-status class="auth-status" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
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
                placeholder="{{ __('auth.placeholders.email') }}"
            >
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <button type="submit" class="auth-submit">
            {{ __('auth.forgot.submit') }}
        </button>

        <div class="auth-switch">
            <span>{{ __('auth.forgot.remembered') }}</span>
            <a href="{{ route('login') }}">{{ __('auth.forgot.back_login') }}</a>
        </div>
    </form>
</x-guest-layout>
