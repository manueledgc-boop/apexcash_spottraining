<?php

// 1) Arriba en routes/web.php añade este use:
use App\Http\Controllers\PostflopTrainingController;

// 2) Dentro del grupo Route::middleware(['auth', 'verified'])->group(function () { ... }); añade:
Route::get('/spot-training/postflop', [PostflopTrainingController::class, 'index'])
    ->name('spot-training.postflop.index');

Route::get('/spot-training/postflop/api/next', [PostflopTrainingController::class, 'next'])
    ->name('spot-training.postflop.next');

Route::post('/spot-training/postflop/api/answer', [PostflopTrainingController::class, 'answer'])
    ->name('spot-training.postflop.answer');

Route::post('/spot-training/postflop/reset', [PostflopTrainingController::class, 'reset'])
    ->name('spot-training.postflop.reset');
