<x-guest-layout>
    <div class="auth-form-header">
        <span>{{ __('auth.verify.badge') }}</span>
        <h2>{{ __('auth.verify.title') }}</h2>
        <p>{{ __('auth.verify.subtitle') }}</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="auth-success">
            {{ __('auth.verify.sent') }}
        </div>
    @endif

    <div class="auth-form">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit" class="auth-submit">
                {{ __('auth.verify.resend') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="auth-link-button">
                {{ __('auth.verify.logout') }}
            </button>
        </form>
    </div>
</x-guest-layout>
