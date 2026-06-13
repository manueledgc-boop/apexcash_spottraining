<x-guest-layout>
    <div class="auth-form-header">
        <span>Bienvenido de nuevo</span>
        <h2>Entra a tu dashboard</h2>
        <p>Continúa tu progreso, revisa tus leaks y sigue avanzando calle por calle.</p>
    </div>

    <x-auth-session-status class="auth-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form">
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
                autocomplete="username"
                placeholder="tu@email.com"
            >
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="password">Contraseña</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
            >
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <div class="auth-options-row">
            <label for="remember_me" class="auth-check">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Olvidé mi contraseña</a>
            @endif
        </div>

        <button type="submit" class="auth-submit">
            Entrar al dashboard
        </button>

        <div class="auth-switch">
            <span>¿Todavía no tienes cuenta?</span>
            <a href="{{ route('register') }}">Crear cuenta ApexCash</a>
        </div>
    </form>
</x-guest-layout>
