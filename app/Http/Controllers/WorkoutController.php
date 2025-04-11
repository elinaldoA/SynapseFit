<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\WorkoutProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class WorkoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // Pega os tipos distintos de treinos do usuário
        $workouts = $user->workouts()
            ->distinct('type')
            ->with('exercise')
            ->orderBy('type')
            ->get(['type']);

        // Pega o progresso dos treinos agrupado por tipo, com data truncada
        $currentWorkouts = WorkoutProgress::where('user_id', $user->id)
            ->latest('data_treino')
            ->get()
            ->map(function ($item) {
                $item->data_treino = \Carbon\Carbon::parse($item->data_treino)->toDateString();
                return $item;
            })
            ->groupBy('type');

        $currentTag = [];
        $nextTag = [];

        foreach ($workouts as $workout) {
            if (isset($currentWorkouts[$workout->type])) {
                $currentTag[$workout->type] = $currentWorkouts[$workout->type]->first();
            } else {
                $nextTag[$workout->type] = $workout;
            }
        }

        // 🔒 Bloqueio por dia e ciclo de treinos
        $ultimoTreino = WorkoutProgress::where('user_id', $user->id)
            ->orderByDesc('data_treino')
            ->first();

        $bloqueadoHoje = false;
        $tipoLiberado = null;

        if ($ultimoTreino) {
            $hoje = now()->toDateString();
            $dataTreino = \Carbon\Carbon::parse($ultimoTreino->data_treino)->toDateString();
            $bloqueadoHoje = $dataTreino === $hoje;
            $tipoLiberado = $this->getNextWorkoutType($ultimoTreino->type);
        } else {
            // Se for o primeiro treino, libera o A
            $tipoLiberado = 'A';
        }

        return view('workouts.index', compact(
            'workouts',
            'currentTag',
            'nextTag',
            'bloqueadoHoje',
            'tipoLiberado'
        ));
    }


    public function show($type)
    {
        $user = Auth::user();

        $workouts = $user->workouts()
            ->where('type', $type)
            ->with('exercise')
            ->get();

        $progress = WorkoutProgress::whereIn('workout_id', $workouts->pluck('id'))
            ->get()
            ->keyBy('workout_id');

        return view('workouts.show', compact('workouts', 'type', 'progress'));
    }

    public function exportToPdf()
    {
        $user = Auth::user();

        $workouts = $user->workouts()->with('exercise')->get();
        $groupedWorkouts = $workouts->groupBy('type');

        $pdf = Pdf::loadView('workouts.pdf', compact('groupedWorkouts'));

        return $pdf->stream('treinos_' . $user->name . '.pdf');
    }

    public function saveProgress(Request $request)
    {
        $validated = $request->validate([
            'workout_id' => 'required|exists:workouts,id',
            'series_completed' => 'required|integer',
            'carga' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $workout = Workout::findOrFail($validated['workout_id']);

        $progress = WorkoutProgress::updateOrCreate(
            [
                'workout_id' => $validated['workout_id'],
                'user_id' => Auth::id(),
            ],
            [
                'series_completed' => $validated['series_completed'],
                'carga' => $validated['carga'],
                'status' => $validated['status'],
                'data_treino' => now(),
                'type' => $workout->type,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Progresso salvo com sucesso.',
            'next' => $this->getNextWorkoutType($workout->type),
        ]);
    }

    // Método extra opcional para ajudar no ciclo de treino (A > B > C)
    protected function getNextWorkoutType($currentType)
    {
        $cycle = ['A', 'B', 'C'];
        $index = array_search($currentType, $cycle);
        return $index !== false ? $cycle[($index + 1) % count($cycle)] : null;
    }
}
