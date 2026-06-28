<section>
    <header class="apex-profile-title">
        <span class="apex-profile-icon">🔒</span>
        <div>
            <h2>Seguridad</h2>
            <p>Actualiza tu contraseña para mantener protegida tu cuenta.</p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="apex-profile-form">
        @csrf
        @method('put')

        <div class="apex-field">
            <x-input-label for="update_password_current_password" value="Contraseña actual" />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="apex-field">
            <x-input-label for="update_password_password" value="Nueva contraseña" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="apex-field">
            <x-input-label for="update_password_password_confirmation" value="Confirmar contraseña" />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="apex-profile-actions">
            <x-primary-button class="apex-btn apex-btn-primary">
                Actualizar contraseña
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2200)"
                    class="apex-saved"
                >
                    Contraseña actualizada.
                </p>
            @endif
        </div>
    </form>
</section>