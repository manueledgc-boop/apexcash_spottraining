# ApexCash Postflop Training V1

Archivos incluidos:

- `app/Http/Controllers/PostflopTrainingController.php`
- `app/Services/PostflopTrainingService.php`
- `app/SpotTraining/Postflop/PostflopSpotRepository.php`
- `resources/views/spot-training/postflop.blade.php`
- `public/assets/css/postflop-training.css`
- `public/js/postflop-training.js`
- `routes/web.POSTFLOP_SNIPPET.php`

## Instalación

1. Copia cada archivo en la misma ruta dentro del proyecto.
2. Abre `routes/web.php`.
3. Añade arriba:

```php
use App\Http\Controllers\PostflopTrainingController;
```

4. Dentro del grupo `Route::middleware(['auth', 'verified'])->group(function () { ... });` añade:

```php
Route::get('/spot-training/postflop', [PostflopTrainingController::class, 'index'])
    ->name('spot-training.postflop.index');

Route::get('/spot-training/postflop/api/next', [PostflopTrainingController::class, 'next'])
    ->name('spot-training.postflop.next');

Route::post('/spot-training/postflop/api/answer', [PostflopTrainingController::class, 'answer'])
    ->name('spot-training.postflop.answer');

Route::post('/spot-training/postflop/reset', [PostflopTrainingController::class, 'reset'])
    ->name('spot-training.postflop.reset');
```

5. Entra a:

```text
/spot-training/postflop
```

## Nota

Este V1 usa las mismas tablas existentes de training (`training_results`, `training_sessions`, `user_training_stats`, `user_leaks`, `user_spot_stats`). No necesita migraciones nuevas.
