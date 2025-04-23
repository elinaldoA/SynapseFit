@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Editar Exercício</h1>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('exercicios.update', $exercise) }}">
                @csrf
                @method('PUT')
                @include('administrador.exercicios.form')
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('exercicios') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
