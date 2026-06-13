# ApexCash Dashboard Top Polish

## Archivos

Copiar:

resources/views/layouts/navigation.blade.php
resources/views/dashboard.blade.php
public/assets/css/apexcash-dashboard-polish.css

## Imágenes necesarias

Asegúrate de tener:

public/images/apexcash-icon.png

Opcionalmente, también:

public/images/apexcash-logo-dark.png
public/favicon/apexcash.ico

## Qué corrige

- Quita el logo Laravel del navbar.
- Usa icono ApexCash en la barra superior.
- Cambia "Spot Training" por "Training".
- Añade accesos visuales a Progress y Leaks.
- Mejora el hero del dashboard.
- Añade XP, nivel, accuracy global y spots.
- Convierte el panel derecho en ruta Preflop → Flop → Turn → River.
- Mantiene candados según $flopUnlocked, $turnUnlocked y $riverUnlocked.

## Importante

Si tu proyecto no usa:

resources/views/layouts/navigation.blade.php

entonces el menú está dentro de:

resources/views/layouts/app.blade.php

En ese caso, copia el contenido de navigation.blade.php en la zona del nav de app.blade.php.

## Limpiar caché

php artisan optimize:clear

Luego recarga:

Ctrl + F5
