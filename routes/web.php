<?php

use App\Http\Controllers\AlimentacaoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\HidratacaoController;

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

    // ROTAS DE ALIMENTAÇÃO
    Route::get('/alimentacao', [AlimentacaoController::class, 'index'])->name('alimentacao');
    Route::get('/alimentacao/create', [AlimentacaoController::class, 'create'])->name('alimentacao.create');
    Route::post('/alimentacao', [AlimentacaoController::class, 'store'])->name('alimentacao.store');
    Route::get('/alimentacao/{alimentacao}/edit', [AlimentacaoController::class, 'edit'])->name('alimentacao.edit');
    Route::put('/alimentacao/{alimentacao}', [AlimentacaoController::class, 'update'])->name('alimentacao.update');
    Route::delete('/alimentacao/{alimentacao}', [AlimentacaoController::class, 'destroy'])->name('alimentacao.destroy');
    // ROTAS DE HIDRATAÇÃO
    Route::get('/hidratacao', [HidratacaoController::class, 'index'])->name('hidratacao');
    Route::get('/hidratacao/create', [HidratacaoController::class, 'create'])->name('hidratacao.create');
    Route::post('/hidratacao', [HidratacaoController::class, 'store'])->name('hidratacao.store');
    Route::get('/hidratacao/{hidratacao}/edit', [HidratacaoController::class, 'edit'])->name('hidratacao.edit');
    Route::put('/hidratacao/{hidratacao}', [HidratacaoController::class, 'update'])->name('hidratacao.update');
    Route::delete('/hidratacao/{hidratacao}', [HidratacaoController::class, 'destroy'])->name('hidratacao.destroy');
});
