<section>
    <header class="apex-profile-title">
        <span class="apex-profile-icon">👤</span>
        <div>
            <h2>Información personal</h2>
            <p>Actualiza tu nombre y dirección de correo electrónico.</p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="apex-profile-form">
        @csrf
        @method('patch')

        <div class="apex-field">
            <x-input-label for="name" value="Nombre" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="apex-field">
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="apex-verify-box">
                    <p>
                        Tu correo electrónico aún no está verificado.

                        <button form="send-verification" class="apex-link-button" type="submit">
                            Reenviar verificación
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="apex-saved" style="margin-top: 10px;">
                            Se ha enviado un nuevo enlace de verificación.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="apex-profile-actions">
            <x-primary-button class="apex-btn apex-btn-primary">
                Guardar cambios
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2200)"
                    class="apex-saved"
                >
                    Guardado correctamente.
                </p>
            @endif
        </div>
    </form>
</section>