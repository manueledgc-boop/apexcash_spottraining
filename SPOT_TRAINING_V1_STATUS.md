# APEXCASH SPOT TRAINING V1 — ESTADO DEL PROYECTO

## Decisión principal

Se pausa la mesa cash jugable completa. ApexCash V1 se replantea como un entrenador de spots de cash 6-max, empezando por preflop.

## Qué se conserva

- Laravel + Breeze/Auth.
- Login, registro, dashboard y layout principal.
- Estilo visual base del dashboard.
- Estructura limpia para seguir trabajando.

## Qué se eliminó o pausó

- Cash Engine jugable.
- Bankroll ficticio.
- Cash Sessions persistentes.
- Bots persistentes.
- Side pots.
- Rake.
- Historial completo de manos cash.
- Estadísticas derivadas de cash sessions.
- Assets JS/CSS de cash table anterior.

## Nueva V1

ApexCash Spot Training V1 incluye:

- `/spot-training` como pantalla principal de entrenamiento.
- Mesa visual de escenario, no mesa jugable completa.
- Spots preflop generados desde `SpotTrainingService`.
- Respuestas en sesión temporal, sin base de datos.
- Feedback inmediato.
- Resumen temporal: total, aciertos, fallos y precisión.

## Rutas activas nuevas

- `GET /spot-training`
- `GET /spot-training/api/next`
- `POST /spot-training/api/answer`
- `POST /spot-training/reset`

## Archivos principales nuevos

- `app/Http/Controllers/SpotTrainingController.php`
- `app/Services/SpotTrainingService.php`
- `resources/views/spot-training/index.blade.php`
- `public/assets/css/spot-training.css`
- `public/js/spot-training.js`

## Módulos iniciales

- Open Raise por posición.
- BB vs BTN open.
- BTN vs 3Bet SB/BB.
- 3Bet vs open CO/BTN.

## Siguiente fase recomendada

1. Probar `php artisan route:list`.
2. Probar login y entrar a `/spot-training`.
3. Ajustar diseño visual de la mesa.
4. Ampliar biblioteca de spots preflop.
5. Separar spots en archivos config JSON/PHP.
6. Más adelante guardar progreso en base de datos.
