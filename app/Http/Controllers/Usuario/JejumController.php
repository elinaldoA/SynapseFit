<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Jejum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JejumController extends Controller
{
    public function index()
    {
        $jejum = Jejum::where('user_id', Auth::id())->first();

        $diasDaSemana = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];
        $diasMarcados = [];

        if ($jejum && in_array($jejum->status, ['ativo', 'pausado'])) {
            $hoje = Carbon::now()->locale('pt_BR')->isoFormat('ddd');
            $diasMarcados = [ucfirst($hoje)];
        }

        $progresso = 0;
        $mensagemProgresso = 'Aguardando dados para calcular o progresso';

        if ($jejum) {
            if ($jejum->peso_atual && $jejum->peso_meta) {
                $pesoAtual = $jejum->peso_atual;
                $pesoMeta = $jejum->peso_meta;
                $pesoInicial = $pesoAtual > $pesoMeta ? $pesoAtual : $pesoMeta;

                $progresso = 100 - (($pesoAtual - $pesoMeta) / ($pesoInicial - $pesoMeta) * 100);
                $progresso = max(0, min($progresso, 100));

                $mensagemProgresso = number_format($progresso, 1) . '% atingido';
            }
        }

        return view('usuario.jejum.index', compact('jejum', 'diasDaSemana', 'diasMarcados', 'progresso', 'mensagemProgresso'));
    }

    public function create()
    {
        return view('usuario.jejum.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'protocolo' => 'required|string',
            'duracao_jejum' => 'required|integer',
            'inicio' => 'required|date_format:H:i',
            'objetivo' => 'required|string',
            'peso_atual' => 'nullable|numeric',
            'peso_meta' => 'required|numeric',
            'doenca_cronica' => 'required|boolean',
            'descricao_doenca' => 'nullable|string',
            'outra_doenca' => 'nullable|string',
            'observacoes' => 'nullable|string',
        ]);

        // Conversão de duração de jejum para inteiro (caso seja string)
        $duracaoJejum = (int) $request->duracao_jejum;

        // Definir os horários de início e fim do jejum
        $inicio = Carbon::createFromFormat('H:i', $request->inicio);
        $fim = (clone $inicio)->addHours($duracaoJejum);  // Garantindo que o fim é calculado corretamente

        // Criar o novo registro de jejum
        Jejum::create([
            'user_id' => Auth::id(),
            'protocolo' => $request->protocolo,
            'duracao_jejum' => $duracaoJejum,
            'inicio' => $inicio,
            'fim' => $fim,
            'objetivo' => $request->objetivo,
            'peso_atual' => $request->peso_atual,
            'peso_meta' => $request->peso_meta,
            'jejum_previamente_feito' => $request->has('jejum_previamente_feito'),
            'doenca_cronica' => $request->doenca_cronica,
            'descricao_doenca' => $request->descricao_doenca,
            'outra_doenca' => $request->outra_doenca,
            'observacoes' => $request->observacoes,
            'status' => 'inativo',  // Por padrão, o jejum começa como inativo
        ]);

        return redirect()->route('jejum.index')->with('success', 'Plano de jejum criado com sucesso!');
    }

    public function toggle(Request $request)
    {
        $jejum = Jejum::where('user_id', Auth::id())->firstOrFail();

        switch ($request->acao) {
            case 'pausar':
                $jejum->update([
                    'status' => 'pausado',
                    'pausado_em' => now(),
                    'tempo_decorrido' => $this->calcularTempoDecorrido($jejum)
                ]);
                break;

            case 'retomar':
                $jejum->update([
                    'status' => 'ativo',
                    'inicio' => now()->subSeconds($jejum->tempo_decorrido)->format('H:i'),
                    'pausado_em' => null
                ]);
                break;

            case 'ativar':
                $jejum->update([
                    'status' => 'ativo',
                    'inicio' => now()->format('H:i'),
                    'pausado_em' => null,
                    'tempo_decorrido' => 0
                ]);
                break;

            default:
                return back()->with('error', 'Ação inválida');
        }

        return back()->with('success', 'Status do jejum atualizado!');
    }

    private function calcularTempoDecorrido($jejum)
    {
        if ($jejum->status === 'ativo') {
            $inicio = Carbon::createFromTimeString($jejum->inicio);
            return now()->diffInSeconds($inicio);
        }

        return $jejum->tempo_decorrido;
    }

    public function destroy(Jejum $jejum)
    {
        $jejum->delete();
        return redirect()->route('jejum.index')->with('success', 'Jejum cancelado com sucesso!');
    }
}
