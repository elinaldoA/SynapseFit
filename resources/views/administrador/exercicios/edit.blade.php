@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Editar Exercício</h1>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('exercicios.update', $exercise) }}">
                @csrf
                @method('PUT')
                @include('administrador.exercicios.form')
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i></button>
                <a href="{{ route('exercicios') }}" class="btn btn-info"><i class="fas fa-angle-left"></i></a>
            </form>
        </div>
    </div>
@endsection
