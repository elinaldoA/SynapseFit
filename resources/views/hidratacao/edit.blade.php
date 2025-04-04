@extends('layouts.usuario')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Editar Registro de Água</h1>

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
        <div class="card-header">Editar</div>
        <div class="card-body">
            <form action="{{ route('hidratacao.update', $registro->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="quantidade">Quantidade (L)</label>
                    <input type="number" name="quantidade" id="quantidade" step="0.01" class="form-control" value="{{ $registro->quantidade }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('hidratacao') }}" class="btn btn-secondary ml-2">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
