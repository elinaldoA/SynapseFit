@extends('layouts.usuario')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Meus Alimentos Consumidos') }}</h1>

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

    <!-- Exibição das métricas da dieta em cards -->
    <div class="row mb-4">
        @foreach(['calorias', 'proteinas', 'carboidratos', 'gorduras', 'agua'] as $tipo)
            @php
                // Usando os valores passados para calcular progresso
                $consumido = $consumidos[$tipo];
                $meta = $metas[$tipo];
                $restante = max(0, $meta - $consumido); // Calcula o que falta para atingir a meta
                $progresso = $meta > 0 ? ($consumido / $meta) : 0; // Progresso atual
                $statusClass = $progresso > 1 ? 'bg-danger' : ($progresso > 0.9 ? 'bg-warning' : 'bg-success');
            @endphp

            <div class="col-md-4 mb-3">
                <div class="card text-center {{ $statusClass }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ ucfirst($tipo) }}</h5>
                        <p class="card-text">
                            Consumido: {{ number_format($consumido, 2) }} / {{ number_format($meta, 2) }}
                            {{ $tipo == 'agua' ? 'L' : 'g' }}<br>
                            Restante: {{ number_format($restante, 2) }} {{ $tipo == 'agua' ? 'L' : 'g' }}
                        </p>

                        <!-- Barra de progresso -->
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ min(100, ($progresso * 100)) }}%" aria-valuenow="{{ min(100, ($progresso * 100)) }}" aria-valuemin="0" aria-valuemax="100">
                                {{ number_format(min(100, ($progresso * 100)), 2) }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Aviso sobre a validação da dieta -->
    @if (session('validacaoDieta'))
        <div class="alert alert-warning mt-3">
            <strong>Atenção!</strong> {{ session('validacaoDieta') }}
        </div>
    @endif

    <!-- Restante da tabela de alimentos consumidos -->
    <div class="card mt-3 mb-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Alimentos Consumidos</span>
            <span>
                <a href="{{ route('alimentacao.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Adicionar Alimento</a>
            </span>
        </div>

        <div class="card-body">
            @if ($alimentacoes->isEmpty())
                <p>Nenhum alimento registrado. Adicione um alimento consumido.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Alimento</th>
                            <th>Quantidade</th>
                            <th>Calorias</th>
                            <th>Proteínas</th>
                            <th>Carboidratos</th>
                            <th>Gorduras</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alimentacoes as $alimentacao)
                            <tr>
                                <td>{{ $alimentacao->alimento }}</td>
                                <td>{{ $alimentacao->quantidade }} {{ $alimentacao->unidade }}</td>
                                <td>{{ $alimentacao->calorias }}</td>
                                <td>{{ $alimentacao->proteinas }}</td>
                                <td>{{ $alimentacao->carboidratos }}</td>
                                <td>{{ $alimentacao->gorduras }}</td>
                                <td>
                                    <a href="{{ route('alimentacao.edit', $alimentacao->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('alimentacao.destroy', $alimentacao->id) }}" method="POST" style="display: inline;">
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
