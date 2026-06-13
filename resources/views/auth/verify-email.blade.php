<x-guest-layout>
    <div class="auth-form-header">
        <span>Verificación</span>
        <h2>Confirma tu email</h2>
        <p>
            Antes de empezar, verifica tu correo. Esto permite proteger tu cuenta,
            guardar tu XP y mantener tu progreso de entrenamiento.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="auth-success">
            Te hemos enviado un nuevo enlace de verificación.
        </div>
    @endif

    <div class="auth-form">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit" class="auth-submit">
                Reenviar email de verificación
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="auth-link-button">
                Cerrar sesión
            </button>
        </form>
    </div>
</x-guest-layout>
