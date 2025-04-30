<?php

use App\Http\Controllers\Administrador\AlimentosController;
use App\Http\Controllers\Administrador\AssinaturaController;
<<<<<<< HEAD
use App\Http\Controllers\Administrador\DesafioController;
=======
>>>>>>> e911801 (Correções gerais)
use App\Http\Controllers\Administrador\ExerciseController;
use App\Http\Controllers\Administrador\FinanceiroController;
use App\Http\Controllers\Administrador\UserController;
use App\Http\Controllers\Administrador\WorkoutAdminController;
use App\Http\Controllers\Usuario\ChatIAController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Usuario\AchievementController;
use App\Http\Controllers\Usuario\AlimentoConsumidoController;
use App\Http\Controllers\Usuario\WorkoutController;
use App\Http\Controllers\Usuario\HidratacaoController;
use App\Http\Controllers\Usuario\JejumController;
use App\Http\Controllers\Usuario\PlanoController;
use App\Http\Controllers\Usuario\RankingController;
<<<<<<< HEAD
use App\Http\Controllers\Usuario\UsuarioDesafioController;
=======
>>>>>>> e911801 (Correções gerais)

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// ROTAS AUTENTICADAS
Route::middleware(['auth'])->group(function () {
    Route::get('/planos', [PlanoController::class, 'index'])->name('planos.index');
    Route::post('/planos/{plan}/assinar', [PlanoController::class, 'assinar'])->name('planos.assinar');
    Route::get('/planos/sucesso', [PlanoController::class, 'sucesso'])->name('planos.sucesso');
    Route::get('/planos/upgrade', [PlanoController::class, 'upgrade'])->name('planos.upgrade');
    Route::get('/chat', [ChatIAController::class, 'index'])->name('chat.index');
    Route::post('/chat/enviar', [ChatIAController::class, 'enviar'])->name('chat.enviar');
});

Route::middleware(['auth', 'check.subscription'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Conquistas
    Route::get('/conquistas', [AchievementController::class, 'index'])->name('conquistas');
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking');

    // TREINOS
    Route::get('/workouts', [WorkoutController::class, 'index'])->name('workouts');
    Route::get('/workouts/type/{type}', [WorkoutController::class, 'show'])->name('workouts.show');
    Route::post('/save-progress', [WorkoutController::class, 'saveProgress'])->name('workouts.saveProgress');
    Route::get('/get-progress/{userId}', [WorkoutController::class, 'getProgress']);
    Route::get('/workouts/export', [WorkoutController::class, 'exportToPdf'])->name('workouts.export');

    // ROTAS DE ALIMENTAÇÃO
    Route::get('/alimentoConsumido', [AlimentoConsumidoController::class, 'index'])->name('alimento_consumidos');
    Route::get('/alimentoConsumido/create', [AlimentoConsumidoController::class, 'create'])->name('alimento_consumidos.create');
    Route::post('/alimentoConsumido', [AlimentoConsumidoController::class, 'store'])->name('alimento_consumidos.store');
    Route::get('/alimentoConsumido/{AlimentoConsumido}/edit', [AlimentoConsumidoController::class, 'edit'])->name('alimento_consumidos.edit');
    Route::put('/alimentoConsumido/{AlimentoConsumido}', [AlimentoConsumidoController::class, 'update'])->name('alimento_consumidos.update');
    Route::delete('/alimentoConsumido/{AlimentoConsumido}', [AlimentoConsumidoController::class, 'destroy'])->name('alimento_consumidos.destroy');
    //JEJUM
    Route::resource('jejum', JejumController::class)->only([
        'index', 'create', 'store','destroy'
    ]);

    Route::put('/jejum/toggle', [JejumController::class, 'toggle'])->name('jejum.toggle');

    // ROTAS DE HIDRATAÇÃO
    Route::get('/hidratacao', [HidratacaoController::class, 'index'])->name('hidratacao');
    Route::get('/hidratacao/create', [HidratacaoController::class, 'create'])->name('hidratacao.create');
    Route::post('/hidratacao', [HidratacaoController::class, 'store'])->name('hidratacao.store');
    Route::get('/hidratacao/{hidratacao}/edit', [HidratacaoController::class, 'edit'])->name('hidratacao.edit');
    Route::put('/hidratacao/{hidratacao}', [HidratacaoController::class, 'update'])->name('hidratacao.update');
    Route::delete('/hidratacao/{hidratacao}', [HidratacaoController::class, 'destroy'])->name('hidratacao.destroy');

    //LISTAGEM DE USUÁRIOS
    Route::get('/administrador/usuarios/index', [UserController::class, 'index'])->name('usuarios');
    Route::get('/administrador/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/administrador/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/administrador/usuarios/{usuario}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/administrador/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/administrador/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    //LISTAGEM ASSINATURAS DE USUÁRIOS
    Route::get('/administrador/assinaturas/index', [AssinaturaController::class, 'index'])->name('assinaturas');
    Route::post('/administrador/assinaturas/{id}/renovar', [AssinaturaController::class, 'renovar'])->name('assinaturas.renovar');
    Route::post('/administrador/assinaturas/{id}/cancelar', [AssinaturaController::class, 'cancelar'])->name('assinaturas.cancelar');
    //LISTAGEM DE ALIMENTOS
    Route::get('/administrador/alimentos/index', [AlimentosController::class, 'index'])->name('alimentos');
    Route::get('/administrador/alimentos/create', [AlimentosController::class, 'create'])->name('alimentos.create');
    Route::post('/administrador/alimentos', [AlimentosController::class, 'store'])->name('alimentos.store');
    Route::get('/administrador/alimentos/{alimento}/edit', [AlimentosController::class, 'edit'])->name('alimentos.edit');
    Route::put('/administrador/alimentos/{alimento}', [AlimentosController::class, 'update'])->name('alimentos.update');
    Route::delete('/administrador/alimentos/{alimento}', [AlimentosController::class, 'destroy'])->name('alimentos.destroy');
    //LISTAGEM DE EXERCICIOS
    Route::get('/administrador/exercicios/index', [ExerciseController::class, 'index'])->name('exercicios');
    Route::get('/administrador/exercicios/create', [ExerciseController::class, 'create'])->name('exercicios.create');
    Route::post('/administrador/exercicios', [ExerciseController::class, 'store'])->name('exercicios.store');
    Route::get('/administrador/exercicios/{exercise}/edit', [ExerciseController::class, 'edit'])->name('exercicios.edit');
    Route::put('/administrador/exercicios/{exercise}', [ExerciseController::class, 'update'])->name('exercicios.update');
    Route::delete('/administrador/exercicios/{exercise}', [ExerciseController::class, 'destroy'])->name('exercicios.destroy');
    //LISTAGEM DE TREINOS
    Route::get('/administrador/treinos/index', [WorkoutAdminController::class, 'index'])->name('treinos');
    Route::get('/administrador/treinos/create', [WorkoutAdminController::class, 'create'])->name('treinos.create');
    Route::post('/administrador/treinos', [WorkoutAdminController::class, 'store'])->name('treinos.store');
    Route::get('/administrador/treinos/{treino}/edit', [WorkoutAdminController::class, 'edit'])->name('treinos.edit');
    Route::put('/administrador/treinos/{treino}', [WorkoutAdminController::class, 'update'])->name('treinos.update');
    Route::delete('/administrador/treinos/{treino}', [WorkoutAdminController::class, 'destroy'])->name('treinos.destroy');
    //FINANCEIRO
    Route::get('/administrador/financeiro', [FinanceiroController::class, 'index'])->name('financeiro');
    Route::post('/notificacoes/salvar', [NotificacaoController::class, 'salvar'])->name('notificacoes.salvar');
    Route::get('/notificacoes/enviar', [NotificacaoController::class, 'enviar'])->name('notificacoes.enviar');

    Route::get('/notifications/mark-as-read/{id}', function ($id) {
        $notification = auth()->user()->unreadNotifications->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    })->name('notifications.read');
    Route::get('/notifications/mark-all-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('notifications.read.all');
});

