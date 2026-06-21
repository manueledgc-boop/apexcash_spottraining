@include('errors.layout', [
    'code' => 404,
    'title' => 'Página no encontrada',
    'message' => 'La página que intentas abrir no existe, fue movida o ya no está disponible.'
])