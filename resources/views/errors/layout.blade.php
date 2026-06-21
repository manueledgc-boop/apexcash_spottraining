<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ApexCash · Error {{ $code ?? 'Error' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/apexcash-errors.css') }}">
</head>
<body>
    <main class="apex-error-page">
        <section class="apex-error-card">
            <div class="apex-error-logo">ApexCash</div>

            <div class="apex-error-code">{{ $code ?? 'Error' }}</div>

            <h1 class="apex-error-title">
                {{ $title ?? 'Algo salió mal' }}
            </h1>

            <p class="apex-error-message">
                {{ $message ?? 'Se produjo un error inesperado en ApexCash.' }}
            </p>

            <div class="apex-error-actions">
                <a href="{{ url('/') }}" class="apex-error-btn apex-error-btn-secondary">
                    Inicio
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="apex-error-btn apex-error-btn-primary">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="apex-error-btn apex-error-btn-primary">
                        Iniciar sesión
                    </a>
                @endauth
            </div>
        </section>
    </main>
</body>
</html>