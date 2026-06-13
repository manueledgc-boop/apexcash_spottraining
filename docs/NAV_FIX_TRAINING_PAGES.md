# Fix navbar ApexCash en Preflop / Flop / Turn / River

## Problema detectado

El dashboard se veía bien porque cargaba `apexcash-dashboard-polish.css` desde `dashboard.blade.php`.

Pero las páginas de training:

- `/spot-training`
- `/spot-training/postflop`
- `/postflop-turn`
- `/postflop-river`

usan `layouts/app.blade.php`, y ese layout NO cargaba el CSS del navbar. Por eso el logo tomaba su tamaño real y rompía la parte superior.

## Archivos corregidos

Copiar:

```text
resources/views/layouts/app.blade.php
resources/views/layouts/navigation.blade.php
public/assets/css/apexcash-dashboard-polish.css
```

## Imagen correcta del navbar

En el navbar debe usarse SOLO:

```text
public/images/apexcash-icon.png
```

No uses el logo completo en el navbar.

Los logos completos son para:

```text
landing
login
registro
```

## Comandos

```bash
php artisan optimize:clear
php artisan view:clear
```

Luego recarga con:

```text
Ctrl + F5
```

## Resultado esperado

La parte superior debe verse igual en:

```text
/dashboard
/spot-training
/spot-training/postflop
/postflop-turn
/postflop-river
```
