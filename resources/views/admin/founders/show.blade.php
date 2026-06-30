<x-app-layout>
    <link href="{{ asset('assets/css/apexcash-dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/apexcash-dashboard-polish.css') }}" rel="stylesheet">

    <main class="dashboard-page">
        <section class="dashboard-hero dashboard-hero-v2">
            <div class="dashboard-hero-main">
                <span class="dashboard-badge">Founder Application</span>
                <h1>{{ $application->user->name }}</h1>
                <p>{{ $application->user->email }}</p>
            </div>
        </section>

        @if(session('status'))
            <section class="critical-leak-panel">
                <div>
                    <span>Estado</span>
                    <h2>{{ session('status') }}</h2>
                </div>
            </section>
        @endif

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card table-card">
                <span>Perfil</span>
                <h2>Datos del jugador</h2>

                <div class="metric-row">
                    <span>País</span>
                    <strong>{{ $application->country ?: 'No indicado' }}</strong>
                </div>

                <div class="metric-row">
                    <span>Experiencia</span>
                    <strong>{{ $application->poker_experience }}</strong>
                </div>

                <div class="metric-row">
                    <span>Modalidad</span>
                    <strong>{{ $application->main_format }}</strong>
                </div>

                <div class="metric-row">
                    <span>Nivel</span>
                    <strong>{{ $application->usual_level }}</strong>
                </div>

                <div class="metric-row">
                    <span>Feedback</span>
                    <strong>{{ $application->willing_to_give_feedback ? 'Sí' : 'No' }}</strong>
                </div>

                <div class="metric-row">
                    <span>Estado</span>
                    <strong>{{ strtoupper($application->status) }}</strong>
                </div>
            </article>

            <article class="dashboard-card table-card">
                <span>Revisión</span>
                <h2>Acciones</h2>

                @if($application->status === 'pending')
                    <form method="POST" action="{{ route('admin.founders.approve', $application) }}" style="margin-bottom: 14px;">
                        @csrf
                        @method('PATCH')

                        <button type="submit" class="apex-btn apex-btn-primary">
                            ✅ Aprobar Founder
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.founders.reject', $application) }}">
                        @csrf
                        @method('PATCH')

                        <button type="submit" class="apex-btn apex-btn-secondary">
                            ❌ Rechazar
                        </button>
                    </form>
                @else
                    <p>
                        Esta solicitud ya fue revisada.
                    </p>

                    @if($application->reviewer)
                        <p>
                            Revisada por: <strong>{{ $application->reviewer->name }}</strong>
                        </p>
                    @endif

                    @if($application->reviewed_at)
                        <p>
                            Fecha: <strong>{{ $application->reviewed_at->format('d/m/Y H:i') }}</strong>
                        </p>
                    @endif
                @endif
            </article>
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card">
                <span>Motivación</span>
                <h2>¿Por qué quiere entrar?</h2>
                <p>{{ $application->motivation }}</p>
            </article>

            <article class="dashboard-card">
                <span>Expectativas</span>
                <h2>¿Qué espera de ApexCash?</h2>
                <p>{{ $application->expectations ?: 'No indicado.' }}</p>
            </article>
        </section>

        <section class="dashboard-grid">
            <a href="{{ route('admin.founders.index') }}" class="dashboard-card active">
                <span>Volver</span>
                <h2>Solicitudes Founder</h2>
                <p>Regresar al listado de solicitudes.</p>
                <strong>← Volver</strong>
            </a>
        </section>
    </main>
</x-app-layout>