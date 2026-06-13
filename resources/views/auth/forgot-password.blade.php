<x-guest-layout>
    <div class="auth-form-header">
        <span>Recuperar acceso</span>
        <h2>¿Olvidaste tu contraseña?</h2>
        <p>Introduce tu email y te enviaremos un enlace para crear una nueva contraseña.</p>
    </div>

    <x-auth-session-status class="auth-status" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                placeholder="tu@email.com"
            >
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <button type="submit" class="auth-submit">
            Enviar enlace de recuperación
        </button>

        <div class="auth-switch">
            <span>¿Ya recordaste tu contraseña?</span>
            <a href="{{ route('login') }}">Volver al login</a>
        </div>
    </form>
</x-guest-layout>
