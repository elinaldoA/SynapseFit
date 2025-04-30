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
        $periodo = $request->query('periodo', 'geral');

        $query = User::where('role', '!=', 'admin');

        if ($periodo == 'mensal') {
            $query->where('created_at', '>=', Carbon::now()->subMonth());
        } elseif ($periodo == 'semanal') {
            $query->where('created_at', '>=', Carbon::now()->subWeek());
        }

        $usuarios = $query->orderBy('pontos', 'desc')->take(10)->get();

        $usuarios->each(function ($usuario) {
            $usuario->nivel = NivelHelper::getNivel($usuario->pontos);
        });

        $posicao = $usuarios->search(fn($usuario) => $usuario->id === $usuarioAtual->id);
        if ($posicao !== false) {
            $posicao += 1;
        } else {
            $posicao = null;
        }

        $nivelAtual = NivelHelper::getNivel($usuarioAtual->pontos);

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

        return view('usuario.ranking.index', compact('usuarios', 'usuarioAtual', 'posicao', 'proximoNivel', 'periodo'));
    }
}
