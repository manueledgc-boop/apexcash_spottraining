<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpotTrainingController;
use App\Http\Controllers\PostflopTrainingController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/set-language/{locale}', function ($locale) {
    if (! in_array($locale, ['es', 'en'])) {
        abort(404);
    }

    session(['locale' => $locale]);

    return redirect()->back();

})->name('lang.switch');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/spot-training', [SpotTrainingController::class, 'index'])
        ->name('spot-training.index');

    Route::get('/spot-training/api/next', [SpotTrainingController::class, 'next'])
        ->name('spot-training.next');

    Route::post('/spot-training/api/answer', [SpotTrainingController::class, 'answer'])
        ->name('spot-training.answer');

    Route::post('/spot-training/reset', [SpotTrainingController::class, 'reset'])
        ->name('spot-training.reset');

    Route::get('/spot-training/postflop', [PostflopTrainingController::class, 'index'])
        ->name('postflop-training.index');

    Route::get('/spot-training/postflop/api/next', [PostflopTrainingController::class, 'next'])
        ->name('postflop-training.next');

    Route::post('/spot-training/postflop/api/answer', [PostflopTrainingController::class, 'answer'])
        ->name('postflop-training.answer');

    Route::post('/spot-training/postflop/reset', [PostflopTrainingController::class, 'reset'])
        ->name('postflop-training.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
