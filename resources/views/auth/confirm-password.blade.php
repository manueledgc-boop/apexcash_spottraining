<x-guest-layout>
    <div class="auth-form-header">
        <span>{{ __('auth.confirm.badge') }}</span>
        <h2>{{ __('auth.confirm.title') }}</h2>
        <p>{{ __('auth.confirm.subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

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

        <button type="submit" class="auth-submit">
            {{ __('auth.confirm.submit') }}
        </button>
    </form>
</x-guest-layout>
