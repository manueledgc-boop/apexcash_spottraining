<x-guest-layout>
    <div class="auth-form-header">
        <span>Crea tu cuenta</span>
        <h2>Empieza por Preflop</h2>
        <p>Guarda XP, desbloquea módulos y entrena con más de 250 spots de Cash Games.</p>
    </div>

    <div class="auth-benefits">
        <div><strong>XP</strong><span>progreso persistente</span></div>
        <div><strong>Leaks</strong><span>errores detectados</span></div>
        <div><strong>250+</strong><span>spots de práctica</span></div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <label for="name">Nombre</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Tu nombre"
            >
            <x-input-error :messages="$errors->get('name')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
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
                autocomplete="new-password"
                placeholder="Mínimo 8 caracteres"
            >
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Repite tu contraseña"
            >
            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
        </div>

        <button type="submit" class="auth-submit">
            Crear cuenta y empezar
        </button>

        <div class="auth-switch">
            <span>¿Ya estás registrado?</span>
            <a href="{{ route('login') }}">Entrar</a>
        </div>
    </form>
</x-guest-layout>
