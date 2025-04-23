@extends('layouts.admin')

@section('main-content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">🏆 Ranking - Top 10 Usuários</h1>

    @if($posicao !== null)
        <p class="text-lg mb-4">
            Você está em <strong>{{ $posicao }}º</strong> lugar com <strong>{{ $usuarioAtual->pontos }}</strong> pontos.
        </p>
    @else
        <p class="text-lg mb-4">Você ainda não está no ranking.</p>
    @endif

    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
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
                <td class="py-2 px-4">{{ $usuario->full_name }}</td>

                <!-- Exibindo o nível com mais informações -->
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
