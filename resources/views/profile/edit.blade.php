<x-app-layout>
    <link href="{{ asset('assets/css/apexcash-profile.css') }}" rel="stylesheet">

    <div class="apex-profile-page">
        <div class="apex-profile-shell">

            <section class="apex-profile-hero">
                <span class="apex-profile-chip">APEXCASH ACCOUNT</span>

                <h1>Mi cuenta</h1>

                <p>
                    Gestiona tu información personal, la seguridad de tu cuenta y tu acceso a ApexCash.
                </p>
            </section>

            <div class="apex-profile-grid">
                <section class="apex-profile-card">
                    @include('profile.partials.update-profile-information-form')
                </section>

                <section class="apex-profile-card">
                    @include('profile.partials.update-password-form')
                </section>

                <section class="apex-profile-card apex-profile-card--wide">
    <div class="apex-profile-title">
        <span class="apex-profile-icon">⭐</span>
        <div>
            <h2>ApexCash Premium</h2>
            <p>Desbloquea el entrenamiento completo y lleva tu progreso al siguiente nivel.</p>
        </div>
    </div>

    <div class="apex-account-row">
        <span class="apex-account-label">Plan actual</span>
        <span class="apex-plan-badge">{{ strtoupper(auth()->user()->plan ?? 'free') }}</span>
    </div>

    @if ((auth()->user()->plan ?? 'free') === 'premium')
        <div class="apex-account-row">
            <span class="apex-account-label">Estado</span>
            <span class="apex-account-value">Premium activo</span>
        </div>

        <div class="apex-account-row">
            <span class="apex-account-label">Válido hasta</span>
            <span class="apex-account-value">
                {{ auth()->user()->premium_until ? auth()->user()->premium_until->format('d/m/Y') : 'Sin fecha de vencimiento' }}
            </span>
        </div>

        <div class="apex-profile-actions" style="margin-top: 22px;">
            <a href="{{ route('premium.upgrade') }}" class="apex-btn apex-btn-primary">
                Gestionar Premium
            </a>
        </div>
        @elseif ((auth()->user()->plan ?? 'free') === 'admin')
            <div class="apex-account-row">
                <span class="apex-account-label">Estado</span>
                <span class="apex-account-value">Acceso completo administrador</span>
            </div>
        @else
            <div class="apex-premium-benefits" style="margin-top: 20px;">
                <p>Con Premium tendrás acceso a:</p>

                <ul style="margin: 14px 0 0; padding-left: 0; list-style: none; display: grid; gap: 10px; color: #dce8e2;">
                    <li>✅ Hand Lab ilimitado</li>
                    <li>✅ Mastery Training</li>
                    <li>✅ Certificación Oficial ApexCash</li>
                    <li>✅ Estadísticas avanzadas</li>
                    <li>✅ Nuevos módulos antes que nadie</li>
                </ul>
            </div>

            <div class="apex-profile-actions" style="margin-top: 24px;">
                <a href="{{ route('premium.upgrade') }}" class="apex-btn apex-btn-primary">
                    Actualizar a Premium
                </a>
            </div>
        @endif

        <div class="apex-account-row" style="margin-top: 22px;">
            <span class="apex-account-label">Correo verificado</span>
            <span class="apex-account-value">
                {{ auth()->user()->hasVerifiedEmail() ? 'Sí' : 'No' }}
            </span>
        </div>

        <div class="apex-account-row">
            <span class="apex-account-label">Miembro desde</span>
            <span class="apex-account-value">
                {{ auth()->user()->created_at?->format('d/m/Y') }}
            </span>
        </div>
    </section>

                <section class="apex-profile-card apex-profile-card--danger apex-profile-card--wide">
                    @include('profile.partials.delete-user-form')
                </section>
            </div>

        </div>
    </div>
</x-app-layout>