@extends('layouts.admin')

@section('main-content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">🏆 Ranking - Top 10 Usuários</h1>

    {{-- Filtros de tempo --}}
    <div class="flex space-x-2 mb-4">
        <a href="?periodo=geral" class="px-4 py-2 rounded-full bg-indigo-500 text-dark hover:bg-indigo-600">Geral</a>
        <a href="?periodo=mensal" class="px-4 py-2 rounded-full bg-indigo-500 text-dark hover:bg-indigo-600">Mensal</a>
        <a href="?periodo=semanal" class="px-4 py-2 rounded-full bg-indigo-500 text-dark hover:bg-indigo-600">Semanal</a>
    </div>

    @if($posicao !== null)
        <div class="bg-gray-100 rounded-lg p-4 mb-6 shadow-inner">
            <p class="text-lg font-semibold">
                Você está em <strong class="text-indigo-600">{{ $posicao }}º</strong> lugar com
                <strong class="text-indigo-600">{{ $usuarioAtual->pontos }}</strong> pontos.
            </p>
            @if($proximoNivel)
                <div class="mt-2 text-sm text-gray-600">
                    Faltam <strong>{{ $proximoNivel['faltam'] }}</strong> pontos para o próximo nível: <strong>{{ $proximoNivel['nome'] }}</strong>
                    <div class="w-full bg-gray-300 rounded-full h-2 mt-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $proximoNivel['percentual'] }}%"></div>
                    </div>
                </div>
            @endif
        </div>
    @else
        <p class="text-lg mb-4">Você ainda não está no ranking.</p>
    @endif

    <table class="min-w-full shadow-md rounded-lg overflow-hidden">
        <thead class="bg-indigo-500 text-white">
            <tr>
                <th class="py-2 px-4 text-left">Posição</th>
                <th class="py-2 px-4 text-left">Usuário</th>
                <th class="py-2 px-4 text-left">Nível</th>
                <th class="py-2 px-4 text-left">Pontos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $index => $usuario)
            <tr class="border-b @if($usuario->id === $usuarioAtual->id) bg-yellow-100 font-semibold @endif">
                <td class="py-2 px-4">
                    @if($index === 0) 🥇
                    @elseif($index === 1) 🥈
                    @elseif($index === 2) 🥉
                    @else #{{ $index + 1 }}
                    @endif
                </td>
                <td class="py-2 px-4 flex items-center space-x-2">
                    <img src="{{ $usuario->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($usuario->full_name).'&background=4f46e5&color=fff' }}"
                         class="w-8 h-8 rounded-full" alt="avatar">
                    <span>{{ $usuario->full_name }}</span>
                </td>
                <td class="py-2 px-4">
                    <span class="inline-block px-2 py-1 rounded-full text-white" style="background-color: {{ $usuario->nivel['cor'] }};">
                        <i class="fa {{ $usuario->nivel['icone'] }} mr-2"></i>{{ $usuario->nivel['nome'] }}
                    </span>
                    <br>
                    <span class="text-sm text-gray-500">{{ $usuario->nivel['descricao'] }}</span>
                </td>
                <td class="py-2 px-4">{{ $usuario->pontos }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
