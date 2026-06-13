# ApexCash Auth — Instalación

## Copiar archivos Blade

resources/views/layouts/guest.blade.php
resources/views/auth/login.blade.php
resources/views/auth/register.blade.php
resources/views/auth/forgot-password.blade.php
resources/views/auth/reset-password.blade.php
resources/views/auth/confirm-password.blade.php
resources/views/auth/verify-email.blade.php

## Copiar CSS

public/assets/css/apexcash-auth.css

## Ubicar imágenes

Copia tus imágenes así:

public/images/apexcash-logo-dark.png
public/images/apexcash-logo-light.png
public/images/apexcash-icon.png
public/images/apexcash-logo.svg

Y el favicon:

public/favicon/apexcash.ico

## Referencias usadas

El guest layout usa:

asset('images/apexcash-logo-dark.png')
asset('favicon/apexcash.ico')
asset('assets/css/apexcash-auth.css')

## Limpiar caché

php artisan optimize:clear

Si el navegador mantiene CSS viejo:

Ctrl + F5

## Nota

No incluye login con Google. Eso queda para una fase posterior.
