# APEXCASH — FIX COMPLETO REVISADO

Este paquete corrige la progresión completa de ApexCash:

- XP global.
- Precisión por etapa.
- Muestra mínima antes de desbloquear.
- Bloqueo real por backend.
- Dashboard usando una única fuente de verdad.
- Rutas correctas para leaks, peor leak, leak crítico, peores spots y concept leaks.
- Mantiene `turn_probe`, que es el identificador real usado por el proyecto.

## Archivos incluidos

Copiar estos archivos sobre tu proyecto:

```text
routes/web.php
bootstrap/app.php
app/Http/Controllers/DashboardController.php
app/Http/Middleware/EnsureTrainingStageUnlocked.php
app/Services/TrainingProgressionService.php
resources/views/dashboard.blade.php
```

## Reglas actuales

```text
Preflop: siempre disponible
Flop:   1000 XP global + 30 spots Preflop + 70% accuracy Preflop
Turn:   3000 XP global + 30 spots Flop + 70% accuracy Flop
River:  6000 XP global + 30 spots Turn + 70% accuracy Turn
Mastery: 10000 XP global + 30 spots River + 75% accuracy River
```

## Por qué era necesario

Antes el dashboard mostraba candados, pero las rutas no estaban protegidas. Un usuario podía entrar escribiendo directamente:

```text
/spot-training/postflop
/postflop-turn
/postflop-river
```

Ahora eso queda bloqueado por middleware:

```text
training.unlocked:flop
training.unlocked:turn
training.unlocked:river
```

## Comandos después de copiar

```bash
php artisan optimize:clear
php artisan route:clear
```

## Verificación

```bash
php artisan route:list
```

Debes ver las rutas de Flop, Turn y River protegidas por el middleware correspondiente.
