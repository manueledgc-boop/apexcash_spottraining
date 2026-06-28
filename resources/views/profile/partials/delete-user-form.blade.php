<section class="space-y-6">
    <header class="apex-profile-title">
        <span class="apex-profile-icon">⚠️</span>
        <div>
            <h2>Zona de peligro</h2>
            <p>
                Si eliminas tu cuenta, todos tus datos, progreso, estadísticas y resultados serán eliminados permanentemente.
            </p>
        </div>
    </header>

    <button
        type="button"
        class="apex-btn apex-btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        Eliminar cuenta
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 apex-modal-dark">
            @csrf
            @method('delete')

            <h2 style="font-size: 22px; font-weight: 900; color: #fff;">
                ¿Seguro que quieres eliminar tu cuenta?
            </h2>

            <p style="margin-top: 10px; color: #9fb2a8; line-height: 1.6;">
                Esta acción no se puede deshacer. Para confirmar, introduce tu contraseña.
            </p>

            <div class="mt-6 apex-field">
                <x-input-label for="password" value="Contraseña" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Contraseña"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>

                <button type="submit" class="apex-btn apex-btn-danger">
                    Sí, eliminar cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>