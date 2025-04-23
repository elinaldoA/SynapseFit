<?php

namespace App\Http\Controllers\Usuario;

use App\Models\User;
use App\Helpers\NivelHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    public function index()
    {
        // Recupera os 10 primeiros usuários, ordenados por pontos
        $usuarios = User::orderBy('pontos', 'desc')->take(10)->get();

        $usuarioAtual = Auth::user();
        $posicao = $usuarios->search(function ($usuario) use ($usuarioAtual) {
            return $usuario->id === $usuarioAtual->id;
        });

        // Filtra os usuários removendo os com role 'admin'
        $usuarios = $usuarios->filter(function ($usuario) {
            return $usuario->role !== 'admin'; // Exclui usuários com role 'admin'
        });

        // Adiciona o nível para todos os usuários restantes
        foreach ($usuarios as $usuario) {
            $usuario->nivel = NivelHelper::getNivel($usuario->pontos);
        }

        // Se a posição do usuário atual foi encontrada, converte de zero-based para one-based
        if ($posicao !== false) {
            $posicao = $posicao + 1;
        }

        // Retorna a view com os dados necessários
        return view('usuario.ranking.index', compact('usuarios', 'usuarioAtual', 'posicao'));
    }
}
