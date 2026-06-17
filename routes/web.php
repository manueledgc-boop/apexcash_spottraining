<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostflopRiverTrainingController;
use App\Http\Controllers\PostflopTrainingController;
use App\Http\Controllers\PostflopTurnTrainingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpotTrainingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasteryTrainingController;

Route::view('/', 'welcome')->name('home');

Route::get('/set-language/{locale}', function ($locale) {
    if (! in_array($locale, ['es', 'en'], true)) {
        abort(404);
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('lang.switch');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | PREFLOP
    |--------------------------------------------------------------------------
    | Preflop siempre está disponible.
    */
    Route::get('/spot-training', [SpotTrainingController::class, 'index'])
        ->name('spot-training.index');

    Route::get('/spot-training/api/next', [SpotTrainingController::class, 'next'])
        ->name('spot-training.next');

    Route::post('/spot-training/api/answer', [SpotTrainingController::class, 'answer'])
        ->name('spot-training.answer');

    Route::post('/spot-training/reset', [SpotTrainingController::class, 'reset'])
        ->name('spot-training.reset');

    /*
    |--------------------------------------------------------------------------
    | FLOP
    |--------------------------------------------------------------------------
    | Requiere XP global + muestra mínima + precisión en Preflop.
    */
    Route::middleware('training.unlocked:flop')->group(function () {
        Route::get('/spot-training/postflop', [PostflopTrainingController::class, 'index'])
            ->name('postflop-training.index');

        Route::get('/spot-training/postflop/api/next', [PostflopTrainingController::class, 'next'])
            ->name('postflop-training.next');

        Route::post('/spot-training/postflop/api/answer', [PostflopTrainingController::class, 'answer'])
            ->name('postflop-training.answer');

        Route::post('/spot-training/postflop/reset', [PostflopTrainingController::class, 'reset'])
            ->name('postflop-training.reset');
    });

    /*
    |--------------------------------------------------------------------------
    | TURN
    |--------------------------------------------------------------------------
    | Requiere XP global + muestra mínima + precisión en Flop.
    */
    Route::middleware('training.unlocked:turn')->group(function () {
        Route::get('/postflop-turn', [PostflopTurnTrainingController::class, 'index'])
            ->name('postflop-turn.index');

        Route::get('/postflop-turn/api/next', [PostflopTurnTrainingController::class, 'next'])
            ->name('postflop-turn.next');

        Route::post('/postflop-turn/api/answer', [PostflopTurnTrainingController::class, 'answer'])
            ->name('postflop-turn.answer');

        Route::post('/postflop-turn/reset', [PostflopTurnTrainingController::class, 'reset'])
            ->name('postflop-turn.reset');
    });

    /*
    |--------------------------------------------------------------------------
    | RIVER
    |--------------------------------------------------------------------------
    | Requiere XP global + muestra mínima + precisión en Turn.
    */
    Route::middleware('training.unlocked:river')->group(function () {
        Route::get('/postflop-river', [PostflopRiverTrainingController::class, 'index'])
            ->name('postflop-river.index');

        Route::get('/postflop-river/api/next', [PostflopRiverTrainingController::class, 'next'])
            ->name('postflop-river.next');

        Route::post('/postflop-river/api/answer', [PostflopRiverTrainingController::class, 'answer'])
            ->name('postflop-river.answer');

        Route::post('/postflop-river/reset', [PostflopRiverTrainingController::class, 'reset'])
            ->name('postflop-river.reset');
    });

    Route::middleware('training.unlocked:mastery')->group(function () {
        Route::get('/mastery', [MasteryTrainingController::class, 'index'])
            ->name('mastery-training.index');

        Route::get('/mastery/api/next', [MasteryTrainingController::class, 'next'])
            ->name('mastery-training.next');

        Route::post('/mastery/api/answer', [MasteryTrainingController::class, 'answer'])
            ->name('mastery-training.answer');

        Route::post('/mastery/reset', [MasteryTrainingController::class, 'reset'])
            ->name('mastery-training.reset');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
