<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use Illuminate\Http\Request;

class AlimentosController extends Controller
{
    /**
     * Exibe a lista de alimentos com busca.
     */
    public function index(Request $request)
    {
        $query = Alimento::query();

        if ($request->filled('pesquisar')) {
            $query->where('nome', 'like', '%' . $request->pesquisar . '%')
                  ->orWhere('refeicao', 'like', '%' . $request->pesquisar . '%');
        }

        $alimentos = $query->orderBy('nome')->paginate(10);

        return view('administrador.alimentos.index', compact('alimentos'));
    }

    /**
     * Mostra o formulário para criar um novo alimento.
     */
    public function create()
    {
        return view('administrador.alimentos.create');
    }

    /**
     * Armazena um novo alimento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'refeicao' => 'required|string',
            'calorias' => 'required|numeric',
            'proteinas' => 'required|numeric',
            'carboidratos' => 'required|numeric',
            'gorduras' => 'required|numeric',
            'agua' => 'nullable|numeric',
            'fibras' => 'nullable|numeric',
            'sodio' => 'nullable|numeric',
            'porcao' => 'required|string|max:100',
        ]);

        Alimento::create($request->all());

        return redirect()->route('alimentos.index')->with('success', 'Alimento criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um alimento.
     */
    public function edit(Alimento $alimento)
    {
        return view('administrador.alimentos.edit', compact('alimento'));
    }

    /**
     * Atualiza os dados de um alimento.
     */
    public function update(Request $request, Alimento $alimento)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'refeicao' => 'required|string',
            'calorias' => 'required|numeric',
            'proteinas' => 'required|numeric',
            'carboidratos' => 'required|numeric',
            'gorduras' => 'required|numeric',
            'agua' => 'nullable|numeric',
            'fibras' => 'nullable|numeric',
            'sodio' => 'nullable|numeric',
            'porcao' => 'required|string|max:100',
        ]);

        $alimento->update($request->all());

        return redirect()->route('alimentos')->with('success', 'Alimento atualizado com sucesso!');
    }

    /**
     * Remove um alimento do sistema.
     */
    public function destroy(Alimento $alimento)
    {
        $alimento->delete();

        return redirect()->route('alimentos')->with('success', 'Alimento excluído com sucesso!');
    }
}
