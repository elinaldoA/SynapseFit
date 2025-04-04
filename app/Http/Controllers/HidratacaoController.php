<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsumoAgua;
use App\Services\AguaService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HidratacaoController extends Controller
{
    protected $aguaService;

    public function __construct(AguaService $aguaService)
    {
        $this->aguaService = $aguaService;
    }

    public function index()
    {
        $user = Auth::user();
        $status = $this->aguaService->verificarMetaDiaria($user);

        $registros = ConsumoAgua::where('user_id', $user->id)
            ->whereDate('registrado_em', Carbon::today())
            ->orderBy('registrado_em', 'desc')
            ->get();

        return view('hidratacao.index', compact('status', 'registros'));
    }

    public function create()
    {
        return view('hidratacao.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'quantidade' => 'required|numeric|min:0.05|max:2000',
        ]);

        ConsumoAgua::create([
            'user_id' => Auth::id(),
            'quantidade' => $request->quantidade,
            'registrado_em' => Carbon::now(),
        ]);

        return redirect()->route('hidratacao')->with('success', 'Água registrada com sucesso!');
    }

    public function edit($id)
    {
        $registro = ConsumoAgua::where('user_id', Auth::id())->findOrFail($id);
        return view('hidratacao.edit', compact('registro'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantidade' => 'required|numeric|min:0.05|max:2000',
        ]);

        $registro = ConsumoAgua::where('user_id', Auth::id())->findOrFail($id);
        $registro->update([
            'quantidade' => $request->quantidade,
            'registrado_em' => Carbon::now(),
        ]);

        return redirect()->route('hidratacao')->with('success', 'Registro de água atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $registro = ConsumoAgua::where('user_id', Auth::id())->findOrFail($id);
        $registro->delete();

        return redirect()->route('hidratacao')->with('success', 'Registro de água removido com sucesso!');
    }
}
