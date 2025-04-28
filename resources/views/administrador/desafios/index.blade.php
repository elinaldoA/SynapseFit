@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <h2 class="mb-4">Desafios Ativos</h2>

        <a href="{{ route('desafios.create') }}" class="btn btn-success mb-3">+ Criar novo desafio</a>

        @foreach ($desafios as $desafio)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $desafio->titulo }}</h5>
                    <p class="card-text">{{ $desafio->descricao }}</p>
                    <p><strong>Categoria:</strong> {{ ucfirst($desafio->categoria) }}</p>
                    <p><strong>Meta:</strong> {{ $desafio->meta }} | <strong>Duração:</strong> {{ $desafio->duracao_dias }} dias</p>

                    {{-- Participantes do desafio --}}
                    <hr>
                    <h6 class="mt-3">Participantes:</h6>
                    @if ($desafio->usuarios->isEmpty())
                        <p class="text-muted">Nenhum participante ainda.</p>
                    @else
                        <ul class="list-group mb-3">
                            @foreach ($desafio->usuarios as $usuario)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $usuario->name }}
                                    <span class="badge bg-info">
                                        Progresso: {{ $usuario->pivot->progresso }} / {{ $desafio->meta }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- Ações do admin --}}
                    <div class="mt-3">
                        <a href="{{ route('desafios.edit', $desafio->id) }}" class="btn btn-warning btn-sm">Editar</a>

                        <form action="{{ route('desafios.destroy', $desafio->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Tem certeza que deseja excluir este desafio?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
