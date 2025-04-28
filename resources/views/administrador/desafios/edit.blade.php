@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <h2 class="mb-4">Editar Desafio</h2>

        <form action="{{ route('desafios.update', $desafio->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $desafio->titulo) }}" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea name="descricao" id="descricao" class="form-control" rows="4" required>{{ old('descricao', $desafio->descricao) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select name="categoria" id="categoria" class="form-control" required>
                    <option value="treino" {{ $desafio->categoria === 'treino' ? 'selected' : '' }}>Treino</option>
                    <option value="hidratacao" {{ $desafio->categoria === 'agua' ? 'selected' : '' }}>Hidrataçao</option>
                    <option value="alimentacao" {{ $desafio->categoria === 'alimentacao' ? 'selected' : '' }}>Alimentação</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="meta" class="form-label">Meta</label>
                <input type="number" name="meta" id="meta" class="form-control" value="{{ old('meta', $desafio->meta) }}" required>
            </div>

            <div class="mb-3">
                <label for="duracao_dias" class="form-label">Duração (em dias)</label>
                <input type="number" name="duracao_dias" id="duracao_dias" class="form-control" value="{{ old('duracao_dias', $desafio->duracao_dias) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="{{ route('desafios.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
