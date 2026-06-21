@include('errors.layout', [
    'code' => 500,
    'title' => 'Error interno',
    'message' => 'ApexCash encontró un problema inesperado. Vuelve al dashboard e intenta nuevamente.'
])