<?php

namespace App\Http\Controllers\Usuario;

use App\Models\User;
use App\Helpers\NivelHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $usuarioAtual = Auth::user();
        $periodo = $request->query('periodo', 'geral'); // Padrão para 'geral'

        // Definir a consulta inicial (geral: todos os usuários)
        $query = User::where('role', '!=', 'admin');

        // Filtragem por período
        if ($periodo == 'mensal') {
            $query->where('created_at', '>=', Carbon::now()->subMonth()); // Últimos 30 dias
        } elseif ($periodo == 'semanal') {
            $query->where('created_at', '>=', Carbon::now()->subWeek()); // Últimos 7 dias
        }

        // Obter os 10 usuários com mais pontos (filtrados pelo período)
        $usuarios = $query->orderBy('pontos', 'desc')->take(10)->get();

        // Adicionar nível aos usuários
        $usuarios->each(function ($usuario) {
            $usuario->nivel = NivelHelper::getNivel($usuario->pontos);
        });

        // Determinar a posição do usuário atual
        $posicao = $usuarios->search(fn($usuario) => $usuario->id === $usuarioAtual->id);
        if ($posicao !== false) {
            $posicao += 1;
        } else {
            $posicao = null;
        }

        // Obter o nível atual do usuário
        $nivelAtual = NivelHelper::getNivel($usuarioAtual->pontos);

        // Calcular o próximo nível, se houver
        $proximoNivel = null;
        if ($nivelAtual && !empty($nivelAtual['proximo'])) {
            $faltam = $nivelAtual['proximo']['pontos_minimos'] - $usuarioAtual->pontos;
            $totalNivel = max($nivelAtual['proximo']['pontos_minimos'] - $nivelAtual['pontos_minimos'], 1);
            $percentual = intval((($usuarioAtual->pontos - $nivelAtual['pontos_minimos']) / $totalNivel) * 100);

            $proximoNivel = [
                'nome' => $nivelAtual['proximo']['nome'],
                'faltam' => max($faltam, 0),
                'percentual' => min(max($percentual, 0), 100),
            ];
        }

        // Retornar a view com os dados filtrados
        return view('usuario.ranking.index', compact('usuarios', 'usuarioAtual', 'posicao', 'proximoNivel', 'periodo'));
    }
}
