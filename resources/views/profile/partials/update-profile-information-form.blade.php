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
            type="email"
            :value="$user->email"
            disabled
            class="bg-gray-100 cursor-not-allowed opacity-75"
        />

        <input
            type="hidden"
            name="email"
            value="{{ $user->email }}"
        />

        @if ($user->google_id)
            <p class="mt-2 text-sm text-green-600">
                ✓ Esta cuenta está vinculada con Google.
            </p>
        @else
            <p class="mt-2 text-sm text-gray-500">
                El correo electrónico está asociado a tu cuenta y no puede modificarse.
            </p>
        @endif

        <x-input-error class="mt-2" :messages="$errors->get('email')" />
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