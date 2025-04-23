@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Meus Treinos</h1>

    {{-- Alerta de bloqueio do dia --}}
    @if ($bloqueadoHoje)
        <div class="alert alert-warning text-center">
            Você já realizou um treino hoje. O próximo será liberado amanhã.
        </div>
    @endif

    {{-- Lista de treinos --}}
    <div class="row">
        @foreach ($workouts as $workout)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-left-{{ isset($currentTag[$workout->type]) ? 'success' : 'warning' }}">
                    <div class="card-body">
                        <h5 class="card-title">Treino {{ $workout->type }}</h5>

                        @if (isset($currentTag[$workout->type]))
                            <p class="card-text">
                                Último treino: {{ \Carbon\Carbon::parse($currentTag[$workout->type]->data_treino)->format('d/m/Y') }}
                            </p>
                        @else
                            <p class="card-text text-muted">Treino ainda não iniciado</p>
                        @endif

                        {{-- Botão de ação --}}
                        @if ($workout->type === $tipoLiberado && !$bloqueadoHoje)
                            <a href="{{ route('workouts.show', $workout->type) }}" class="btn btn-primary">Começar</a>
                        @else
                            <button class="btn btn-secondary" disabled>Bloqueado</button>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
