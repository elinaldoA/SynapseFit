@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800 text-center">{{ __('Meus Alimentos Consumidos') }}</h1>

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

    <div class="row mb-4">
        @foreach(['calorias', 'proteinas', 'carboidratos', 'gorduras', 'fibras', 'sodio'] as $tipo)
            @php
                $consumido = $consumidos[$tipo] ?? 0;
                $meta = $metas[$tipo] ?? 1;
                $restante = max(0, $meta - $consumido);
                $progresso = $meta > 0 ? ($consumido / $meta) : 0;
                $statusClass = $progresso > 1 ? 'bg-danger' : ($progresso > 0.9 ? 'bg-warning' : 'bg-success');
                $unidade = ($tipo === 'sodio') ? 'mg' : 'g';
            @endphp

            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="card text-center {{ $statusClass }} text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title text-white">{{ ucfirst($tipo) }}</h5>
                        <p class="card-text">
                            <i class="fas fa-utensils"></i> Consumido: {{ number_format($consumido, 2) }} / {{ number_format($meta, 2) }} {{ $unidade }}<br>
                            <i class="fas fa-hourglass-end"></i> Restante: {{ number_format($restante, 2) }} {{ $unidade }}
                        </p>

                        <div class="progress bg-white">
                            <div class="progress-bar" role="progressbar" style="width: {{ min(100, ($progresso * 100)) }}%" aria-valuenow="{{ min(100, ($progresso * 100)) }}" aria-valuemin="0" aria-valuemax="100">
                                {{ number_format(min(100, ($progresso * 100)), 2) }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if (session('validacaoDieta'))
        <div class="alert alert-warning mt-3">
            <strong>Atenção!</strong> {{ session('validacaoDieta') }}
        </div>
    @endif
    <div class="card mt-3 mb-4 border-light shadow">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <span>Alimentos Consumidos</span>
            <a href="{{ route('alimentacao.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Adicionar Alimento
            </a>
        </div>

        <div class="card-body table-responsive">
            @if ($alimentacoes->isEmpty())
                <p>Nenhum alimento registrado. Adicione um alimento consumido.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Refeição</th>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Calorias</th>
                            <th>Proteínas</th>
                            <th>Carboidratos</th>
                            <th>Gorduras</th>
                            <th>Fibras</th>
                            <th>Sódio</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alimentacoes as $alimentacao)
                            <tr>
                                <td>{{ ucfirst($alimentacao->refeicao) }}</td>
                                <td>{{ \Carbon\Carbon::parse($alimentacao->data)->format('d/m/Y') }}</td>
                                <td>{{ $alimentacao->descricao ?? '-' }}</td>
                                <td>{{ $alimentacao->calorias }} kcal</td>
                                <td>{{ $alimentacao->proteinas }} g</td>
                                <td>{{ $alimentacao->carboidratos }} g</td>
                                <td>{{ $alimentacao->gorduras }} g</td>
                                <td>{{ $alimentacao->fibras }} g</td>
                                <td>{{ $alimentacao->sodio }} mg</td>
                                <td class="text-center">
                                    <a href="{{ route('alimentacao.edit', $alimentacao->id) }}" class="btn btn-warning btn-sm mb-1">Editar</a>
                                    <form action="{{ route('alimentacao.destroy', $alimentacao->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
