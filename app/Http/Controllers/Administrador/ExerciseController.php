<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index(Request $request)
    {
        $query = Exercise::query();

        if ($request->filled('nome')) {
            $query->where('name', 'like', '%' . $request->nome . '%');
        }

        $exercises = $query->orderBy('created_at')->paginate(10);

        return view('administrador.exercicios.index', compact('exercises'));
    }

    public function create()
    {
        return view('administrador.exercicios.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Hipertrofia,Emagrecimento,Resistência',
            'muscle_group' => 'required|in:Peito,Costas,Ombros,Bíceps,Tríceps,Core,Pernas,Glúteos',
            'level' => 'required|in:Iniciante,Intermediário,Avançado',
            'video_url' => 'nullable|url',
        ]);

        Exercise::create($request->all());

        return redirect()->route('exercicios')->with('success', 'Exercicio criado com sucesso!');
    }
    public function show(Exercise $exercise)
    {
        return view('exercicios.show', compact('exercise'));
    }
    public function edit(Exercise $exercise)
    {
        return view('administrador.exercicios.edit', compact('exercise'));
    }
    public function update(Request $request, Exercise $exercise)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Hipertrofia,Emagrecimento,Resistência',
            'muscle_group' => 'required|in:Peito,Costas,Ombros,Bíceps,Tríceps,Core,Pernas,Glúteos',
            'level' => 'required|in:Iniciante,Intermediário,Avançado',
            'video_url' => 'nullable|url',
        ]);

        $exercise->update($request->all());
        return redirect()->route('exercicios')->with('success','Exercício atualizado com sucesso!');
    }
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('exercicios')->with('success','Exercício deletado com sucesso!');
    }
}
