@extends('layouts.usuario')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Registrar Consumo de Água</h1>

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
        <div class="card-header">Novo Registro</div>
        <div class="card-body">
            <form action="{{ route('hidratacao.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="quantidade">Quantidade (L)</label>
                    <input type="number" name="quantidade" id="quantidade" step="0.01" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ route('hidratacao') }}" class="btn btn-secondary ml-2">Voltar</a>
            </form>
        </div>
    </div>
@endsection
