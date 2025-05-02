@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Editar Usuário') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $usuario->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Sobrenome</label>
                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $usuario->last_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $usuario->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="height">Altura (m)</label>
                    <input type="number" step="0.01" class="form-control" name="height" value="{{ old('height', $usuario->height) }}" required>
                </div>

                <div class="form-group">
                    <label for="weight">Peso (kg)</label>
                    <input type="number" step="0.01" class="form-control" name="weight" value="{{ old('weight', $usuario->weight) }}" required>
                </div>

                <div class="form-group">
                    <label for="sex">Sexo</label>
                    <select class="form-control" name="sex" required>
                        <option value="male" {{ $usuario->sex == 'male' ? 'selected' : '' }}>Masculino</option>
                        <option value="female" {{ $usuario->sex == 'female' ? 'selected' : '' }}>Feminino</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="age">Idade</label>
                    <input type="number" class="form-control" name="age" value="{{ old('age', $usuario->age) }}" required>
                </div>

                <div class="form-group">
                    <label for="objetivo">Objetivo</label>
                    <select class="form-control" name="objetivo" required>
                        <option value="hipertrofia" {{ $usuario->objetivo == 'hipertrofia' ? 'selected' : '' }}>Hipertrofia</option>
                        <option value="emagrecimento" {{ $usuario->objetivo == 'emagrecimento' ? 'selected' : '' }}>Emagrecimento</option>
                        <option value="resistencia" {{ $usuario->objetivo == 'resistencia' ? 'selected' : '' }}>Resistência</option>
                    </select>
                </div>

                <div class="form-group d-flex justify-content-start">
                    <button type="submit" class="btn btn-success m-1"><i class="fas fa-save"></i></button>
                    <a href="{{ route('usuarios') }}" class="btn btn-info m-1"><i class="fas fa-angle-left"></i></a>
                </div>
            </form>
        </div>
    </div>
@endsection
