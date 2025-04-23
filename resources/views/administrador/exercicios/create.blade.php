@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Novo Exercício</h1>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('exercicios.store') }}">
                @csrf
                @include('administrador.exercicios.form')
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ route('exercicios') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
