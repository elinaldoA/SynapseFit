@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Editar Treino</h1>

    <form method="POST" action="{{ route('treinos.update', $treino) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="user_id">Nome *</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $treino->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="exercise_id">Exercício *</label>
            <select name="exercise_id" id="exercise_id" class="form-control" required>
                @foreach($exercises as $exercise)
                    <option value="{{ $exercise->id }}" {{ $treino->exercise_id == $exercise->id ? 'selected' : '' }}>
                        {{ $exercise->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="type">Tipo *</label>
            <select name="type" id="type" class="form-control" required>
                <option value="A" {{ $treino->type == 'A' ? 'selected' : '' }}>Ficha A</option>
                <option value="B" {{ $treino->type == 'B' ? 'selected' : '' }}>Ficha B</option>
                <option value="C" {{ $treino->type == 'C' ? 'selected' : '' }}>Ficha C</option>
            </select>
        </div>

        <div class="form-group">
            <label for="series">Séries</label>
            <input type="number" class="form-control" name="series" id="series" value="{{ $treino->series }}">
        </div>

        <div class="form-group">
            <label for="repeticoes">Repetições</label>
            <input type="number" class="form-control" name="repeticoes" id="repeticoes" value="{{ $treino->repeticoes }}">
        </div>

        <div class="form-group">
            <label for="carga">Carga (kg)</label>
            <input type="number" step="0.01" class="form-control" name="carga" id="carga" value="{{ $treino->carga }}">
        </div>

        <div class="form-group">
            <label for="descanso">Descanso (segundos)</label>
            <input type="number" class="form-control" name="descanso" id="descanso" value="{{ $treino->descanso }}">
        </div>

        <div class="form-group">
            <label for="data_treino">Data do Treino</label>
            <input type="date" class="form-control" name="data_treino" id="data_treino" value="{{ $treino->data_treino }}">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('treinos') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
