<x-app-layout>
    <link href="{{ asset('assets/css/apexcash-dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/apexcash-dashboard-polish.css') }}" rel="stylesheet">

    <main class="dashboard-page">
        <section class="dashboard-hero dashboard-hero-v2">
            <div class="dashboard-hero-main">
                <span class="dashboard-badge">Admin</span>
                <h1>Founder Members</h1>
                <p>Solicitudes recibidas para el programa Founder Members 2026.</p>
            </div>
        </section>

        <section class="dashboard-card table-card">
            <span>Solicitudes</span>
            <h2>Founder Applications</h2>

            @forelse($applications as $application)
                <a class="metric-row" href="{{ route('admin.founders.show', $application) }}">
                    <span>
                        {{ $application->user->name }}
                        ·
                        {{ $application->main_format }}
                        ·
                        {{ $application->usual_level }}
                    </span>

                    <strong>
                        @if($application->status === 'pending')
                            🟡 Pendiente
                        @elseif($application->status === 'approved')
                            🟢 Aprobada
                        @else
                            🔴 Rechazada
                        @endif
                    </strong>
                </a>
            @empty
                <p>No hay solicitudes Founder todavía.</p>
            @endforelse

            <div style="margin-top: 24px;">
                {{ $applications->links() }}
            </div>
        </section>
    </main>
</x-app-layout>