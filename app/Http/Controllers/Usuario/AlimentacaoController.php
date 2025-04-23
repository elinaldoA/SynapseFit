<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Alimentacao;
use App\Services\DietaService;
use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlimentacaoController extends Controller
{
    protected $dietaService;
    protected $achievementService;

    public function __construct(DietaService $dietaService, AchievementService $achievementService)
    {
        $this->dietaService = $dietaService;
        $this->achievementService = $achievementService;
    }

    public function index()
    {
        $user = auth()->user();

        $alimentacoes = Alimentacao::where('user_id', $user->id)
            ->whereDate('data', \Carbon\Carbon::today())
            ->get();

        $dieta = $this->dietaService->gerarDieta($user);
        $validacaoDieta = $this->dietaService->validarDieta($user, $alimentacoes);

        $consumidos = [
            'calorias' => $alimentacoes->sum('calorias'),
            'proteinas' => $alimentacoes->sum('proteinas'),
            'carboidratos' => $alimentacoes->sum('carboidratos'),
            'gorduras' => $alimentacoes->sum('gorduras'),
            'agua' => $alimentacoes->sum('agua'),
            'fibras' => $alimentacoes->sum('fibras'),
            'sodio' => $alimentacoes->sum('sodio'),
        ];

        $metas = [
            'calorias' => $dieta['calorias'] ?? 0,
            'proteinas' => $dieta['proteinas'] ?? 0,
            'carboidratos' => $dieta['carboidratos'] ?? 0,
            'gorduras' => $dieta['gorduras'] ?? 0,
            'agua' => $dieta['agua'] ?? 0,
        ];

        return view('usuario.alimentacao.index', compact('alimentacoes', 'dieta', 'validacaoDieta', 'consumidos', 'metas'));
    }

    public function create()
    {
        $dieta = $this->dietaService->gerarDieta(auth()->user());
        $validacaoDieta = $this->dietaService->validarDieta(auth()->user(), Alimentacao::where('user_id', auth()->user()->id)->get());

        return view('usuario.alimentacao.create', compact('dieta', 'validacaoDieta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'calorias' => 'required|numeric',
            'proteinas' => 'required|numeric',
            'carboidratos' => 'required|numeric',
            'gorduras' => 'required|numeric',
            'agua' => 'nullable|numeric',
            'fibras' => 'nullable|numeric',
            'sodio' => 'nullable|numeric',
            'descricao' => 'nullable|string',
            'refeicao' => 'required|in:café,almoço,lanche,jantar',
            'data' => 'required|date',
        ]);

        $alimentacao = Alimentacao::create([
            'user_id' => auth()->user()->id,
            'calorias' => $request->calorias,
            'proteinas' => $request->proteinas,
            'carboidratos' => $request->carboidratos,
            'gorduras' => $request->gorduras,
            'agua' => $request->agua,
            'fibras' => $request->fibras,
            'sodio' => $request->sodio,
            'descricao' => $request->descricao,
            'refeicao' => $request->refeicao,
            'data' => $request->data,
        ]);

        // Verifica se o usuário atingiu conquistas
        $this->achievementService->checkAchievements(auth()->user());

        $alimentacoes = Alimentacao::where('user_id', auth()->user()->id)->get();
        $validacao = $this->dietaService->validarDieta(auth()->user(), $alimentacoes);
        if ($validacao != 'Dieta dentro dos limites.') {
            Log::warning('Dieta excedida!', ['validacao' => $validacao]);
            return back()->with('erro', $validacao);
        }

        return redirect()->route('alimentacao')->with('success', 'Alimento registrado com sucesso!');
    }

    public function edit(Alimentacao $alimentacao)
    {
        $dieta = $this->dietaService->gerarDieta(auth()->user());
        $validacaoDieta = $this->dietaService->validarDieta(auth()->user(), Alimentacao::where('user_id', auth()->user()->id)->get());

        return view('usuario.alimentacao.edit', compact('alimentacao', 'dieta', 'validacaoDieta'));
    }

    public function update(Request $request, Alimentacao $alimentacao)
    {
        $request->validate([
            'calorias' => 'required|numeric',
            'proteinas' => 'required|numeric',
            'carboidratos' => 'required|numeric',
            'gorduras' => 'required|numeric',
            'agua' => 'nullable|numeric',
            'fibras' => 'nullable|numeric',
            'sodio' => 'nullable|numeric',
            'descricao' => 'nullable|string',
            'refeicao' => 'required|in:café,almoço,lanche,jantar',
            'data' => 'required|date',
        ]);

        $alimentacao->update([
            'calorias' => $request->calorias,
            'proteinas' => $request->proteinas,
            'carboidratos' => $request->carboidratos,
            'gorduras' => $request->gorduras,
            'agua' => $request->agua,
            'fibras' => $request->fibras,
            'sodio' => $request->sodio,
            'descricao' => $request->descricao,
            'refeicao' => $request->refeicao,
            'data' => $request->data,
        ]);

        $alimentacoes = Alimentacao::where('user_id', auth()->user()->id)->get();
        $validacao = $this->dietaService->validarDieta(auth()->user(), $alimentacoes);
        if ($validacao != 'Dieta dentro dos limites.') {
            Log::warning('Dieta excedida após atualização!', ['validacao' => $validacao]);
            return back()->with('erro', $validacao);
        }

        return redirect()->route('alimentacao')->with('success', 'Alimento atualizado com sucesso!');
    }

    public function destroy(Alimentacao $alimentacao)
    {
        $alimentacao->delete();
        return redirect()->route('alimentacao')->with('success', 'Alimento excluído com sucesso!');
    }
}
