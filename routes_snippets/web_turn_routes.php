<?php

// Añade el use arriba de routes/web.php:
use App\Http\Controllers\PostflopTurnTrainingController;

// Añade dentro del grupo auth + verified:
Route::get('/spot-training/postflop/turn', [PostflopTurnTrainingController::class, 'index'])
    ->name('postflop-turn-training.index');

Route::get('/spot-training/postflop/turn/api/next', [PostflopTurnTrainingController::class, 'next'])
    ->name('postflop-turn-training.next');

Route::post('/spot-training/postflop/turn/api/answer', [PostflopTurnTrainingController::class, 'answer'])
    ->name('postflop-turn-training.answer');

Route::post('/spot-training/postflop/turn/reset', [PostflopTurnTrainingController::class, 'reset'])
    ->name('postflop-turn-training.reset');
