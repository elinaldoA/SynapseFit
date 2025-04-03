<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\AlimentacaoController; // Controlador para alimentação
use App\Http\Controllers\DietaController; // Controlador para dieta

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
    Route::get('/alimentacao', [AlimentacaoController::class, 'index'])->name('alimentacao'); // Listar alimentos consumidos
    Route::get('/alimentacao/create', [AlimentacaoController::class, 'create'])->name('alimentacao.create'); // Formulário para criar alimento consumido
    Route::post('/alimentacao', [AlimentacaoController::class, 'store'])->name('alimentacao.store'); // Salvar novo alimento consumido
    Route::get('/alimentacao/{alimentacao}/edit', [AlimentacaoController::class, 'edit'])->name('alimentacao.edit'); // Formulário para editar alimento consumido
    Route::put('/alimentacao/{alimentacao}', [AlimentacaoController::class, 'update'])->name('alimentacao.update'); // Atualizar alimento consumido
    Route::delete('/alimentacao/{alimentacao}', [AlimentacaoController::class, 'destroy'])->name('alimentacao.destroy'); // Excluir alimento consumido
});
