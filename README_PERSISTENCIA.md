# ApexCash - Persistencia real de Spot Training

Cambios incluidos:

- Mantiene los 150 spots preflop de la fase anterior.
- Crea persistencia real por usuario.
- Guarda cada respuesta en `training_results`.
- Crea sesiones de entrenamiento en `training_sessions`.
- Acumula estadísticas globales y por módulo en `user_training_stats`.
- Detecta leaks persistentes en `user_leaks`.
- Añade XP y niveles básicos.
- Actualiza dashboard para mostrar nivel, XP, spots completados, precisión global y peor leak.
- Actualiza Spot Training para cargar leaks persistentes cuando la sesión actual está vacía.

Archivos principales:

- database/migrations/2026_06_08_000001_create_training_sessions_table.php
- database/migrations/2026_06_08_000002_create_training_results_table.php
- database/migrations/2026_06_08_000003_create_user_training_stats_table.php
- database/migrations/2026_06_08_000004_create_user_leaks_table.php
- app/Models/TrainingSession.php
- app/Models/TrainingResult.php
- app/Models/UserTrainingStat.php
- app/Models/UserLeak.php
- app/Services/SpotTrainingService.php
- app/Http/Controllers/DashboardController.php
- resources/views/dashboard.blade.php

Después de copiar los archivos:

```bash
php artisan migrate
php artisan route:list --path=spot-training
```

Prueba manual:

1. Entra con un usuario.
2. Abre `/spot-training`.
3. Responde 5-10 spots.
4. Vuelve al dashboard.
5. Deben aparecer XP, precisión, spots completados y peor leak.

Commit sugerido:

```bash
git add .
git commit -m "Add persistent spot training stats and leaks"
git push
```
