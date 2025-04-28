<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\AlimentoConsumido;
use App\Services\DietaService;
use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlimentoConsumidoController extends Controller
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

        $alimentos_consumidos = AlimentoConsumido::where('user_id', $user->id)
            ->whereDate('data', \Carbon\Carbon::today())
            ->get();

        $dieta = $this->dietaService->gerarDieta($user);
        $validacaoDieta = $this->dietaService->validarDieta($user, $alimentos_consumidos);

        $consumidos = [
            'calorias' => $alimentos_consumidos->sum('calorias'),
            'proteinas' => $alimentos_consumidos->sum('proteinas'),
            'carboidratos' => $alimentos_consumidos->sum('carboidratos'),
            'gorduras' => $alimentos_consumidos->sum('gorduras'),
            'agua' => $alimentos_consumidos->sum('agua'),
            'fibras' => $alimentos_consumidos->sum('fibras'),
            'sodio' => $alimentos_consumidos->sum('sodio'),
        ];

        $metas = [
            'calorias' => $dieta['calorias'] ?? 0,
            'proteinas' => $dieta['proteinas'] ?? 0,
            'carboidratos' => $dieta['carboidratos'] ?? 0,
            'gorduras' => $dieta['gorduras'] ?? 0,
            'agua' => $dieta['agua'] ?? 0,
            'fibras' => $dieta['fibras'] ?? 0,
            'sodio' => $dieta['sodio'] ?? 0,
        ];

        return view('usuario.AlimentoConsumido.index', compact('alimentos_consumidos', 'dieta', 'validacaoDieta', 'consumidos', 'metas'));
    }

    public function create()
    {
        $alimentos = Alimento::all();
        $dieta = $this->dietaService->gerarDieta(auth()->user());
        $validacaoDieta = $this->dietaService->validarDieta(auth()->user(), AlimentoConsumido::where('user_id', auth()->user()->id)->get());

        return view('usuario.AlimentoConsumido.create', compact('alimentos','dieta', 'validacaoDieta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'calorias' => 'required|numeric',
            'proteinas' => 'required|numeric',
            'carboidratos' => 'required|numeric',
            'gorduras' => 'required|numeric',
            'agua' => 'nullable|numeric',
            'fibras' => 'nullable|numeric',
            'sodio' => 'nullable|numeric',
            'porcao' => 'nullable',
            'refeicao' => 'required|in:café,almoço,lanche,jantar',
            'data' => 'required|date',
        ]);

        $alimento = Alimento::firstOrCreate(
            ['nome' => $request->descricao],
            [
                'calorias' => $request->calorias,
                'proteinas' => $request->proteinas,
                'carboidratos' => $request->carboidratos,
                'gorduras' => $request->gorduras,
                'agua' => $request->agua,
                'fibras' => $request->fibras,
                'sodio' => $request->sodio,
                'porcao' => $request->porcao,
            ]
        );

        AlimentoConsumido::create([
            'user_id' => auth()->user()->id,
            'alimento_id' => $alimento->id,
            'descricao' => $request->descricao,
            'calorias' => $request->calorias,
            'proteinas' => $request->proteinas,
            'carboidratos' => $request->carboidratos,
            'gorduras' => $request->gorduras,
            'agua' => $request->agua,
            'fibras' => $request->fibras,
            'sodio' => $request->sodio,
            'porcao' => $request->porcao,
            'refeicao' => $request->refeicao,
            'data' => $request->data,
        ]);

        $this->achievementService->checkAchievements(auth()->user());

        $alimentos_consumidos = AlimentoConsumido::where('user_id', auth()->user()->id)->get();
        $validacao = $this->dietaService->validarDieta(auth()->user(), $alimentos_consumidos);
        if ($validacao != 'Dieta dentro dos limites.') {
            Log::warning('Dieta excedida!', ['validacao' => $validacao]);
            return back()->with('erro', $validacao);
        }

        return redirect()->route('alimento_consumidos')->with('success', 'Alimento registrado com sucesso!');
    }

    public function edit(AlimentoConsumido $AlimentoConsumido)
    {
        $alimentos = Alimento::all();
        $dieta = $this->dietaService->gerarDieta(auth()->user());
        $validacaoDieta = $this->dietaService->validarDieta(auth()->user(), AlimentoConsumido::where('user_id', auth()->user()->id)->get());

        return view('usuario.AlimentoConsumido.edit', compact('alimentos','AlimentoConsumido', 'dieta', 'validacaoDieta'));
    }

    public function update(Request $request, AlimentoConsumido $AlimentoConsumido)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'calorias' => 'required|numeric',
            'proteinas' => 'required|numeric',
            'carboidratos' => 'required|numeric',
            'gorduras' => 'required|numeric',
            'agua' => 'nullable|numeric',
            'fibras' => 'nullable|numeric',
            'sodio' => 'nullable|numeric',
            'refeicao' => 'required|in:café,almoço,lanche,jantar',
            'data' => 'required|date',
        ]);

        $AlimentoConsumido->update([
            'descricao' => $request->descricao,
            'calorias' => $request->calorias,
            'proteinas' => $request->proteinas,
            'carboidratos' => $request->carboidratos,
            'gorduras' => $request->gorduras,
            'agua' => $request->agua,
            'fibras' => $request->fibras,
            'sodio' => $request->sodio,
            'refeicao' => $request->refeicao,
            'data' => $request->data,
        ]);

        $alimentos_consumidos = AlimentoConsumido::where('user_id', auth()->user()->id)->get();
        $validacao = $this->dietaService->validarDieta(auth()->user(), $alimentos_consumidos);
        if ($validacao != 'Dieta dentro dos limites.') {
            Log::warning('Dieta excedida após atualização!', ['validacao' => $validacao]);
            return back()->with('erro', $validacao);
        }

        return redirect()->route('alimento_consumidos')->with('success', 'Alimento atualizado com sucesso!');
    }

    public function destroy(AlimentoConsumido $AlimentoConsumido)
    {
        $AlimentoConsumido->delete();
        return redirect()->route('alimento_consumidos')->with('success', 'Alimento excluído com sucesso!');
    }
}
