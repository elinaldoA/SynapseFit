@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Novo Alimento</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('alimentos.store') }}" method="POST">
                @csrf

                @include('administrador.alimentos.partials.form')

                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i></button>
                <a href="{{ route('alimentos') }}" class="btn btn-info"><i class="fas fa-angle-left"></i></a>
            </form>
        </div>
    </div>
@endsection
