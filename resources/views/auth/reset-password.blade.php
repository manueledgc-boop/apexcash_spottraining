<x-guest-layout>
    <div class="auth-form-header">
        <span>{{ __('auth.reset.badge') }}</span>
        <h2>{{ __('auth.reset.title') }}</h2>
        <p>{{ __('auth.reset.subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="auth-field">
            <label for="email">{{ __('auth.fields.email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                required
                autofocus
                autocomplete="username"
                placeholder="{{ __('auth.placeholders.email') }}"
            >
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="password">{{ __('auth.fields.new_password') }}</label>
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
            <label for="password_confirmation">{{ __('auth.fields.confirm_new_password') }}</label>
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
            {{ __('auth.reset.submit') }}
        </button>
    </form>
</x-guest-layout>
