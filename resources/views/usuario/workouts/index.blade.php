@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1 class="mb-4">💪 Meus Treinos</h1>

    {{-- Alerta de bloqueio do dia --}}
    @if ($bloqueadoHoje)
        <div class="alert alert-warning text-center">
            🚫 Você já realizou um treino hoje. O próximo será liberado amanhã.
        </div>
    @endif

    {{-- Lista de treinos --}}
    <div class="row">
        @foreach ($workouts as $workout)
            @php
                $hasTreinado = isset($currentTag[$workout->type]);
                $isLiberado = $workout->type === $tipoLiberado && !$bloqueadoHoje;
            @endphp
            <div class="col-md-4 mb-4">
                <div class="card border-left-{{ $hasTreinado ? 'success' : 'warning' }} shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title">
                            🏋️‍♂️ Treino {{ $workout->type }}
                        </h5>

                        @if ($hasTreinado)
                            <p class="card-text text-success">
                                Último treino em: <strong>{{ \Carbon\Carbon::parse($currentTag[$workout->type]->data_treino)->format('d/m/Y') }}</strong>
                            </p>
                        @else
                            <p class="card-text text-muted">Treino ainda não iniciado</p>
                        @endif

                        <div class="mt-3">
                            @if ($isLiberado)
                                <a href="{{ route('workouts.show', $workout->type) }}" class="btn btn-primary w-100">
                                    Começar
                                </a>
                            @else
                                <button class="btn btn-secondary w-100" disabled title="Treino indisponível no momento">
                                    Bloqueado
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Linha do tempo da evolução --}}
    <hr class="my-5">
    <h2>📈 Linha do Tempo dos Treinos</h2>

    <style>
        .timeline {
            position: relative;
            margin: 2rem 0;
            padding-left: 30px;
            border-left: 4px solid #3490dc;
        }
        .timeline-entry {
            position: relative;
            margin-bottom: 1.8rem;
        }
        .timeline-entry::before {
            content: "";
            position: absolute;
            left: -13px;
            top: 0.5rem;
            width: 18px;
            height: 18px;
            background-color: #3490dc;
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 0 0 3px rgba(52, 144, 220, 0.3);
        }
        .timeline-entry .badge {
            font-size: 0.85rem;
        }
        .timeline-entry .status-success::before { background-color: #38c172 !important; }
        .timeline-entry .status-pending::before { background-color: #ffed4a !important; }
        .timeline-entry .status-failed::before { background-color: #e3342f !important; }
    </style>

    <div class="timeline">
        @forelse($evolucaoCompleta as $progress)
            @php
                $status = strtolower($progress->status);
                $statusClass = match($status) {
                    'concluído', 'completo', 'finalizado' => 'status-success',
                    'pendente', 'em andamento' => 'status-pending',
                    'falhou', 'incompleto' => 'status-failed',
                    default => '',
                };
            @endphp
            <div class="timeline-entry {{ $statusClass }}">
                <button class="btn btn-outline-primary btn-sm"
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        title="Ficha: {{ $progress->workout->type }} | Exercício: {{ $progress->workout->exercise->name ?? '-' }} | Séries: {{ $progress->series_completed }} | Carga: {{ $progress->carga ?? '-' }} | Status: {{ ucfirst($progress->status) }}">
                    {{ \Carbon\Carbon::parse($progress->data_treino)->format('d/m/Y') }}
                </button>
            </div>
        @empty
            <p class="text-muted">Nenhum progresso registrado ainda.</p>
        @endforelse
    </div>
</div>

{{-- Tooltip Init --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    });
</script>
@endsection
