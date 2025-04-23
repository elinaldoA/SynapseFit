<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\TalkfitConversa;
use Illuminate\Http\Request;
use App\Models\User;

class TalkfitController extends Controller
{
    // Lista todas as conversas do usuário logado
    public function index()
    {
        $user = auth()->user();

        $conversas = TalkfitConversa::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->with(['user1', 'user2'])
            ->get();

        return view('usuario.talkfit.index', compact('conversas'));
    }

    // Exibe o formulário para iniciar uma nova conversa
    public function novo()
    {
        // Pega todos os usuários (exceto o usuário autenticado)
        $usuarios = User::where('id', '!=', auth()->id())->get();

        return view('usuario.talkfit.novo', compact('usuarios'));
    }

    // Mostra a conversa e suas mensagens
    public function show($id)
    {
        $conversa = TalkfitConversa::with('mensagens.remetente')->findOrFail($id);

        // Verifica se o usuário faz parte da conversa
        if ($conversa->user1_id !== auth()->id() && $conversa->user2_id !== auth()->id()) {
            abort(403);
        }

        $destinatario = $conversa->user1_id == auth()->id() ? $conversa->user2 : $conversa->user1;
        $mensagens = $conversa->mensagens;

        return view('usuario.talkfit.show', compact('conversa', 'mensagens', 'destinatario'));
    }

    // Envia nova mensagem
    public function store(Request $request, $id)
    {
        $request->validate([
            'conteudo' => 'required|string'
        ]);

        $conversa = TalkfitConversa::findOrFail($id);

        // Verifica se o usuário faz parte da conversa
        if ($conversa->user1_id !== auth()->id() && $conversa->user2_id !== auth()->id()) {
            abort(403);
        }

        $conversa->mensagens()->create([
            'remetente_id' => auth()->id(),
            'mensagem' => $request->conteudo,
        ]);

        return redirect()->route('talkfit.show', $conversa->id);
    }

    // Inicia uma nova conversa (ou recupera existente)
    public function iniciarConversa($userId)
    {
        $authId = auth()->id();

        // Garante que user1 seja sempre o menor ID (para evitar duplicação)
        $conversa = TalkfitConversa::firstOrCreate([
            'user1_id' => min($authId, $userId),
            'user2_id' => max($authId, $userId),
        ]);

        return redirect()->route('talkfit.show', $conversa->id);
    }
}
