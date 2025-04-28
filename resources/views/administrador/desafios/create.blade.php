@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h2 class="mb-4">Criar Novo Desafio</h2>

    <form method="POST" action="{{ route('desafios.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-control">
                <option value="individual">Individual</option>
                <option value="grupo">Grupo</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select name="categoria" class="form-control">
                <option value="treino">Treino</option>
                <option value="agua">Hidratação</option>
                <option value="alimentacao">Alimentação</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Duração (dias)</label>
            <input type="number" name="duracao_dias" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Meta (ex: 7 treinos, 14L de água)</label>
            <input type="number" name="meta" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Desafio</button>
    </form>
</div>
@endsection
