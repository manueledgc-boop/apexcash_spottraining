<x-guest-layout>
    <div class="auth-form-header">
        <span>{{ __('auth.register.badge') }}</span>
        <h2>{{ __('auth.register.title') }}</h2>
        <p>{{ __('auth.register.subtitle') }}</p>
    </div>

    <div class="auth-benefits">
        <div><strong>{{ __('auth.register.benefits.xp.title') }}</strong><span>{{ __('auth.register.benefits.xp.text') }}</span></div>
        <div><strong>{{ __('auth.register.benefits.leaks.title') }}</strong><span>{{ __('auth.register.benefits.leaks.text') }}</span></div>
        <div><strong>{{ __('auth.register.benefits.spots.title') }}</strong><span>{{ __('auth.register.benefits.spots.text') }}</span></div>
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
                autofocus
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
