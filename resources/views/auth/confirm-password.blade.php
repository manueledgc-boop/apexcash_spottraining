<x-guest-layout>
    <div class="auth-form-header">
        <span>Área segura</span>
        <h2>Confirma tu contraseña</h2>
        <p>Para proteger tu cuenta y tu progreso, confirma tu contraseña antes de continuar.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

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

        <button type="submit" class="auth-submit">
            Confirmar y continuar
        </button>
    </form>
</x-guest-layout>
