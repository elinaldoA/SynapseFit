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

    @if (session('erro'))
        <div class="alert alert-warning mt-3">
            <strong>Atenção!</strong>
            <ul>
                @foreach (session('erro') as $erro)
                    <li>{{ $erro }}</li>
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
                    <label for="alimento">Alimento</label>
                    <input type="text" name="alimento" id="alimento" class="form-control" value="{{ old('alimento', $alimentacao->alimento) }}" required>
                </div>

                <div class="form-group">
                    <label for="quantidade">Quantidade</label>
                    <input type="number" name="quantidade" id="quantidade" class="form-control" value="{{ old('quantidade', $alimentacao->quantidade) }}" required step="0.01">
                </div>

                <div class="form-group">
                    <label for="calorias">Calorias</label>
                    <input type="number" name="calorias" id="calorias" class="form-control" value="{{ old('calorias', $alimentacao->calorias) }}" required step="0.01">
                </div>

                <div class="form-group">
                    <label for="proteinas">Proteínas (g)</label>
                    <input type="number" name="proteinas" id="proteinas" class="form-control" value="{{ old('proteinas', $alimentacao->proteinas) }}" required step="0.01">
                </div>

                <div class="form-group">
                    <label for="carboidratos">Carboidratos (g)</label>
                    <input type="number" name="carboidratos" id="carboidratos" class="form-control" value="{{ old('carboidratos', $alimentacao->carboidratos) }}" required step="0.01">
                </div>

                <div class="form-group">
                    <label for="gorduras">Gorduras (g)</label>
                    <input type="number" name="gorduras" id="gorduras" class="form-control" value="{{ old('gorduras', $alimentacao->gorduras) }}" required step="0.01">
                </div>

                <div class="form-group">
                    <label for="agua">Água (L)</label>
                    <input type="number" name="agua" id="agua" class="form-control" value="{{ old('agua', $alimentacao->agua) }}" step="0.01">
                </div>

                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>
        </div>
    </div>
@endsection
