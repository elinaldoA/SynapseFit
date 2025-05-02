@extends('layouts.admin')

@section('main-content')
    <!-- Título -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Gestão Financeira - Assinaturas') }}</h1>

    <!-- Mensagens de Retorno -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-left-success" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filtros de Pesquisa -->
    <div class="card shadow border-light mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('financeiro') }}">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="start_date">Data de Início</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate->toDateString() }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="end_date">Data de Fim</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate->toDateString() }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="plan_id">Plano</label>
                        <select id="plan_id" name="plan_id" class="form-control">
                            <option value="">Todos os Planos</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $planId == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="payment_method">Método de Pagamento</label>
                        <select id="payment_method" name="payment_method" class="form-control">
                            <option value="">Todos os Métodos</option>
                            @foreach ($paymentMethods as $method)
                                <option value="{{ $method }}" {{ $paymentMethod == $method ? 'selected' : '' }}>{{ $method }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('financeiro') }}" class="btn btn-outline-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Painel de Métricas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body text-center">
                    <h6 class="text-primary">Total Arrecadado</h6>
                    <p class="text-success font-weight-bold mb-0">R$ {{ number_format($totalArrecadado, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-left-success">
                <div class="card-body text-center">
                    <h6 class="text-success">Assinaturas Ativas</h6>
                    <p class="mb-0">{{ $ativos }} / {{ $totalAssinaturas }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-left-danger">
                <div class="card-body text-center">
                    <h6 class="text-danger">Assinaturas Inativas</h6>
                    <p class="mb-0">{{ $inativos }} / {{ $totalAssinaturas }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-left-warning">
                <div class="card-body">
                    <h6 class="text-warning">Resumo por Plano</h6>
                    <ul class="list-group list-group-flush">
                        @foreach ($resumoPorPlano as $planId => $total)
                            <li class="list-group-item py-1 px-0 d-flex justify-content-between">
                                <span>{{ \App\Models\Plan::find($planId)->name }}</span>
                                <strong>R$ {{ number_format($total, 2, ',', '.') }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Assinaturas -->
    <h5 class="mb-3">Assinaturas no Período</h5>
    <div class="table-responsive table-hover">
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Usuário</th>
                    <th>Plano</th>
                    <th>Início</th>
                    <th>Término</th>
                    <th>Status</th>
                    <th>Pagamento</th>
                    <th>Status do Pagamento</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assinaturas as $assinatura)
                    <tr>
                        <td>{{ $assinatura->user->name }}</td>
                        <td>{{ $assinatura->plan->name }}</td>
                        <td>{{ $assinatura->start_date->format('d/m/Y') }}</td>
                        <td>{{ $assinatura->end_date->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $assinatura->is_active ? 'success' : 'secondary' }}">
                                {{ $assinatura->is_active ? 'Ativa' : 'Inativa' }}
                            </span>
                        </td>
                        <td>{{ $assinatura->payment_method }}</td>
                        <td>{{ $assinatura->payment_status }}</td>
                        <td>R$ {{ number_format($assinatura->plan->price, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Nenhuma assinatura encontrada para os filtros aplicados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $assinaturas->links() }}
    </div>
@endsection
