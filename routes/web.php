<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpotTrainingController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['es', 'en'])) {
        abort(404);
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('lang.switch');

Route::view('/dashboard', 'dashboard')
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
