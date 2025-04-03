<?php

namespace App\Http\Controllers;

use App\Models\Alimentacao;
use App\Services\DietaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Importando o Log facade

class AlimentacaoController extends Controller
{
    protected $dietaService;

    public function __construct(DietaService $dietaService)
    {
        $this->dietaService = $dietaService;
        Log::debug('AlimentacaoController instanciado.', ['dietaService' => $dietaService]);
    }

    // Exibir todos os alimentos consumidos
    public function index()
    {
        Log::debug('Exibindo alimentos consumidos.', ['user_id' => auth()->user()->id]);

        // Obtendo as alimentações do usuário
        $alimentacoes = Alimentacao::where('user_id', auth()->user()->id)->get();
        Log::debug('Alimentos encontrados:', ['alimentacoes' => $alimentacoes]);

        // Obter as métricas da dieta
        $dieta = $this->dietaService->gerarDieta(auth()->user());
        $validacaoDieta = $this->dietaService->validarDieta(auth()->user(), $alimentacoes);

        // Calcular os totais consumidos
        $consumidos = [
            'calorias' => $alimentacoes->sum('calorias'),
            'proteinas' => $alimentacoes->sum('proteinas'),
            'carboidratos' => $alimentacoes->sum('carboidratos'),
            'gorduras' => $alimentacoes->sum('gorduras'),
            'agua' => $alimentacoes->sum('agua'),
        ];

        // Verificação para evitar divisão por zero
        $metas = [
            'calorias' => $dieta['calorias'] ?? 0,
            'proteinas' => $dieta['proteinas'] ?? 0,
            'carboidratos' => $dieta['carboidratos'] ?? 0,
            'gorduras' => $dieta['gorduras'] ?? 0,
            'agua' => $dieta['agua'] ?? 0,
        ];

        // Passando as variáveis para a view
        return view('alimentacao.index', [
            'alimentacoes' => $alimentacoes,
            'dieta' => $dieta,
            'validacaoDieta' => $validacaoDieta,
            'consumidos' => $consumidos,
            'metas' => $metas
        ]);
    }


    // Mostrar o formulário de criação
    public function create()
    {
        Log::debug('Exibindo formulário de criação.');

        // Obter as métricas da dieta
        $dieta = $this->dietaService->gerarDieta(auth()->user());
        $validacaoDieta = $this->dietaService->validarDieta(auth()->user(), Alimentacao::where('user_id', auth()->user()->id)->get());

        return view('alimentacao.create', compact('dieta', 'validacaoDieta'));
    }

    // Armazenar a alimentação no banco de dados
    public function store(Request $request)
    {
        // Validação dos dados
        Log::debug('Iniciando validação de dados de alimentação.', ['request' => $request->all()]);
        $request->validate([
            'alimento' => 'required|string',
            'quantidade' => 'required|numeric',
            'calorias' => 'required|numeric',
            'proteinas' => 'required|numeric',
            'carboidratos' => 'required|numeric',
            'gorduras' => 'required|numeric',
            'agua' => 'nullable|numeric',
        ]);

        Log::debug('Validação dos dados concluída, salvando alimentação.', ['data' => $request->all()]);

        // Registrar o consumo no banco de dados
        $alimentacao = Alimentacao::create([
            'user_id' => auth()->user()->id,
            'alimento' => $request->alimento,
            'quantidade' => $request->quantidade,
            'calorias' => $request->calorias,
            'proteinas' => $request->proteinas,
            'carboidratos' => $request->carboidratos,
            'gorduras' => $request->gorduras,
            'agua' => $request->agua,
        ]);

        Log::debug('Alimentação registrada com sucesso.', ['alimentacao' => $alimentacao]);

        // Validar se os limites da dieta foram excedidos
        $alimentacoes = Alimentacao::where('user_id', auth()->user()->id)->get();
        $validacao = $this->dietaService->validarDieta(auth()->user(), $alimentacoes);
        Log::debug('Validação da dieta', ['validacao' => $validacao]);

        if ($validacao != 'Dieta dentro dos limites.') {
            Log::warning('Dieta excedida!', ['validacao' => $validacao]);
            return back()->with('erro', $validacao);
        }

        Log::debug('Alimentação dentro dos limites. Redirecionando...');
        return redirect()->route('alimentacao.index')->with('success', 'Alimento registrado com sucesso!');
    }

    // Exibir o formulário de edição
    public function edit(Alimentacao $alimentacao)
    {
        Log::debug('Exibindo formulário de edição.', ['alimentacao' => $alimentacao]);

        // Obter as métricas da dieta
        $dieta = $this->dietaService->gerarDieta(auth()->user());
        $validacaoDieta = $this->dietaService->validarDieta(auth()->user(), Alimentacao::where('user_id', auth()->user()->id)->get());

        return view('alimentacao.edit', compact('alimentacao', 'dieta', 'validacaoDieta'));
    }

    // Atualizar a alimentação
    public function update(Request $request, Alimentacao $alimentacao)
    {
        Log::debug('Iniciando atualização de alimentação.', ['alimentacao' => $alimentacao, 'request' => $request->all()]);

        // Validação dos dados
        $request->validate([
            'alimento' => 'required|string',
            'quantidade' => 'required|numeric',
            'calorias' => 'required|numeric',
            'proteinas' => 'required|numeric',
            'carboidratos' => 'required|numeric',
            'gorduras' => 'required|numeric',
            'agua' => 'nullable|numeric',
        ]);

        // Atualizar os dados no banco
        $alimentacao->update([
            'alimento' => $request->alimento,
            'quantidade' => $request->quantidade,
            'calorias' => $request->calorias,
            'proteinas' => $request->proteinas,
            'carboidratos' => $request->carboidratos,
            'gorduras' => $request->gorduras,
            'agua' => $request->agua,
        ]);

        Log::debug('Alimentação atualizada com sucesso.', ['alimentacao' => $alimentacao]);

        // Validar se os limites da dieta foram excedidos
        $alimentacoes = Alimentacao::where('user_id', auth()->user()->id)->get();
        $validacao = $this->dietaService->validarDieta(auth()->user(), $alimentacoes);
        Log::debug('Validação da dieta', ['validacao' => $validacao]);

        if ($validacao != 'Dieta dentro dos limites.') {
            Log::warning('Dieta excedida após atualização!', ['validacao' => $validacao]);
            return back()->with('erro', $validacao);
        }

        Log::debug('Alimentação dentro dos limites após atualização. Redirecionando...');
        return redirect()->route('alimentacao')->with('success', 'Alimento atualizado com sucesso!');
    }

    // Excluir um alimento
    public function destroy(Alimentacao $alimentacao)
    {
        Log::debug('Excluindo alimento.', ['alimentacao' => $alimentacao]);
        $alimentacao->delete();
        return redirect()->route('alimentacao.index')->with('success', 'Alimento excluído com sucesso!');
    }
}
