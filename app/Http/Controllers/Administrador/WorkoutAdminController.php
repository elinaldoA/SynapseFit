<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Workout::with(['user', 'exercise'])->orderBy('type', 'asc');

        if ($request->filled('pesquisar')) {
            $termo = $request->get('pesquisar');

            $query->where(function ($q) use ($termo) {
                $q->where('type', 'like', '%' . $termo . '%')
                ->orWhereHas('user', function ($subQuery) use ($termo) {
                    $subQuery->where('name', 'like', '%' . $termo . '%');
                })
                ->orWhereHas('exercise', function ($subQuery) use ($termo) {
                    $subQuery->where('name', 'like', '%' . $termo . '%');
                });
            });
        }

        $treinos = $query->paginate(10);

        return view('administrador.treinos.index', compact('treinos'));
    }

    public function create()
    {
        $users = User::all();
        $exercises = Exercise::all();
        return view('administrador.treinos.create', compact('users','exercises'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'exercise_id' => 'required|exists:exercises,id',
            'type' => 'required|in:A,B,C',
            'series' => 'required|integer|min:1',
            'repeticoes' => 'required|integer|min:1',
            'descanso' => 'required|numeric|min:0',
            'carga' => 'nullable|numeric|min:0',
            'data_treino' => 'nullable|date',
        ]);

        Workout::create($request->all());

        return redirect()->route('treinos')->with('success','Treino criado com sucesso');
    }

    public function show(Workout $treino)
    {
        $treino->load(['user','exercise']);
        return view('administrador.treinos.show', compact('treino'));
    }

    public function edit(Workout $treino)
    {
        $users = User::all();
        $exercises = Exercise::all();
        return view('administrador.treinos.edit', compact('treino','users','exercises'));
    }

    public function update(Request $request, Workout $treino)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'exercise_id' => 'required|exists:exercises,id',
            'type' => 'required|in:A,B,C',
            'series' => 'required|integer|min:1',
            'repeticoes' => 'required|integer|min:1',
            'descanso' => 'required|numeric|min:0',
            'carga' => 'nullable|numeric|min:0',
            'data_treino' => 'nullable|date',
        ]);

        $treino->update($request->all());

        return redirect()->route('treinos')->with('success','Treino criado com sucesso');
    }

    public function destroy(Workout $treino)
    {
        $treino->delete();
        return redirect()->route('treinos')->with('success','Treino excluído com sucesso');
    }
}
