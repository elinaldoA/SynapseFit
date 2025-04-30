<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Services\WorkoutService;
use App\Services\AchievementService;
use App\Helpers\NivelHelper;
use App\Models\Achievement;
use App\Models\WorkoutProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    protected $workoutService;
    protected $achievementService;

    public function __construct(WorkoutService $workoutService, AchievementService $achievementService)
    {
        $this->middleware('auth');
        $this->workoutService = $workoutService;
        $this->achievementService = $achievementService;
    }

    public function index()
    {
        $user = Auth::user();

        $workouts = $this->workoutService->getWorkoutsGroupedByType($user);
        $currentWorkouts = $this->workoutService->getCurrentWorkoutProgress($user);

        $currentTag = [];
        $nextTag = [];

        foreach ($workouts as $workout) {
            if (isset($currentWorkouts[$workout->type])) {
                $currentTag[$workout->type] = $currentWorkouts[$workout->type]->first();
            } else {
                $nextTag[$workout->type] = $workout;
            }
        }

        $ultimoTreino = WorkoutProgress::where('user_id', $user->id)
            ->orderByDesc('data_treino')
            ->first();

        $bloqueadoHoje = false;
        $tipoLiberado = 'A';

        if ($ultimoTreino) {
            $bloqueadoHoje = $ultimoTreino->data_treino->toDateString() === now()->toDateString();
            $tipoLiberado = $this->workoutService->getNextWorkoutType($ultimoTreino->type);
        }

        $pontos = Achievement::where('user_id', $user->id)->count() * 50;
        $nivel = NivelHelper::getNivel($pontos);

        // 👉 Adicionado: buscar toda a evolução do usuário
        $evolucaoCompleta = WorkoutProgress::with(['workout.exercise'])
            ->where('user_id', $user->id)
            ->orderBy('data_treino', 'asc')
            ->get();

        return view('usuario.workouts.index', compact(
            'workouts',
            'currentTag',
            'nextTag',
            'bloqueadoHoje',
            'tipoLiberado',
            'pontos',
            'nivel',
            'evolucaoCompleta'
        ));
    }


    public function show($type)
    {
        $user = Auth::user();
        $workouts = $user->workouts()->where('type', $type)->with('exercise')->get();
        $progress = WorkoutProgress::whereIn('workout_id', $workouts->pluck('id'))->get()->keyBy('workout_id');

        return view('usuario.workouts.show', compact('workouts', 'type', 'progress'));
    }

    public function saveProgress(Request $request)
    {
        $validated = $request->validate([
            'workout_id' => 'required|exists:workouts,id',
            'series_completed' => 'required|integer',
            'carga' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $user = Auth::user();

        [$progress, $pontosGanhos] = $this->workoutService->saveProgress($validated, $user);

        $this->achievementService->checkAchievements($user);

        return response()->json([
            'success' => true,
            'message' => 'Progresso salvo com sucesso.',
            'next' => $this->workoutService->getNextWorkoutType($progress->type),
            'ranking_url' => route('ranking')
        ]);
    }
}
