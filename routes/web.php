<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// ROTAS AUTENTICADAS
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // TREINOS
    Route::get('/workouts', [WorkoutController::class, 'index'])->name('workouts');
    Route::get('/workouts/type/{type}', [WorkoutController::class, 'show'])->name('workouts.show');
    Route::post('/save-progress', [WorkoutController::class, 'saveProgress'])->name('workouts.saveProgress');
    Route::get('/get-progress/{userId}', [WorkoutController::class, 'getProgress']);
    Route::get('/workouts/export', [WorkoutController::class, 'exportToPdf'])->name('workouts.export');
});
