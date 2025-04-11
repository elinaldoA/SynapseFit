@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Meus Treinos</h1>

    <div class="row">
        @foreach ($workouts as $workout)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-left-{{ isset($currentTag[$workout->type]) ? 'success' : 'warning' }}">
                    <div class="card-body">
                        <h5 class="card-title">Treino {{ $workout->type }}</h5>
                        @if (isset($currentTag[$workout->type]))
                            <p class="card-text">Último treino: {{ \Carbon\Carbon::parse($currentTag[$workout->type]->data_treino)->format('d/m/Y') }}</p>
                            <a href="{{ route('workouts.show', $workout->type) }}" class="btn btn-success">Continuar</a>
                        @else
                            <p class="card-text text-muted">Treino ainda não iniciado</p>
                            <a href="{{ route('workouts.show', $workout->type) }}" class="btn btn-primary">Começar</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
