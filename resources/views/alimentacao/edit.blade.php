@extends('layouts.usuario')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Editar Alimento') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4 border-light shadow">
        <div class="card-header">
            <span>Editar alimento consumido</span>
        </div>

        <div class="card-body">
            <form action="{{ route('alimentacao.update', $alimentacao->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="refeicao">Refeição</label>
                    <select name="refeicao" class="form-control" required>
                        <option value="">Selecione uma refeição</option>
                        @foreach (\App\Models\Alimentacao::refeicoesPadrao() as $refeicao)
                            <option value="{{ $refeicao }}"
                                {{ old('refeicao', $alimentacao->refeicao) === $refeicao ? 'selected' : '' }}>
                                {{ ucfirst($refeicao) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="calorias">Calorias</label>
                    <input type="number" step="0.01" name="calorias" class="form-control"
                        value="{{ old('calorias', $alimentacao->calorias) }}" required>
                </div>

                <div class="form-group">
                    <label for="proteinas">Proteínas (g)</label>
                    <input type="number" step="0.01" name="proteinas" class="form-control"
                        value="{{ old('proteinas', $alimentacao->proteinas) }}" required>
                </div>

                <div class="form-group">
                    <label for="carboidratos">Carboidratos (g)</label>
                    <input type="number" step="0.01" name="carboidratos" class="form-control"
                        value="{{ old('carboidratos', $alimentacao->carboidratos) }}" required>
                </div>

                <div class="form-group">
                    <label for="gorduras">Gorduras (g)</label>
                    <input type="number" step="0.01" name="gorduras" class="form-control"
                        value="{{ old('gorduras', $alimentacao->gorduras) }}" required>
                </div>

                <div class="form-group">
                    <label for="agua">Água (ml)</label>
                    <input type="number" step="0.01" name="agua" class="form-control"
                        value="{{ old('agua', $alimentacao->agua) }}">
                </div>

                <div class="form-group">
                    <label for="fibras">Fibras (g)</label>
                    <input type="number" step="0.01" name="fibras" class="form-control"
                        value="{{ old('fibras', $alimentacao->fibras) }}">
                </div>

                <div class="form-group">
                    <label for="sodio">Sódio (mg)</label>
                    <input type="number" step="0.01" name="sodio" class="form-control"
                        value="{{ old('sodio', $alimentacao->sodio) }}">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição / Observações</label>
                    <textarea name="descricao" class="form-control" rows="2">{{ old('descricao', $alimentacao->descricao) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="data">Data de consumo</label>
                    <input type="date" name="data" class="form-control"
                    value="{{ old('data', isset($alimentacao->data) ? date('Y-m-d', strtotime($alimentacao->data)) : '') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('alimentacao') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
