@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Gestão Financeira - Assinaturas') }}</h1>

    <!-- Exibindo mensagens de sucesso ou erro -->
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
    <div class="card mt-3 mb-4 border-light shadow">
        <div class="card-body">
            <!-- Filtros de Período e Plano -->
            <form method="GET" action="{{ route('financeiro') }}">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="start_date">Data Início</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate->toDateString() }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">Data Fim</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate->toDateString() }}">
                    </div>
                    <div class="col-md-3">
                        <label for="plan_id">Plano</label>
                        <select name="plan_id" class="form-control">
                            <option value="">Todos os Planos</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $planId == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="payment_method">Método de Pagamento</label>
                        <select name="payment_method" class="form-control">
                            <option value="">Todos os Métodos</option>
                            @foreach ($paymentMethods as $method)
                                <option value="{{ $method }}" {{ $paymentMethod == $method ? 'selected' : '' }}>
                                    {{ $method }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary mt-4">Filtrar</button>
                        <a href="{{ route('financeiro') }}" class="btn btn-warning mt-4">Limpar</a>
                    </div>
                </div>
            </form>

            <!-- Painel com as métricas financeiras -->
            <div class="row mb-4">
                <!-- Total Arrecadado -->
                <div class="col-md-3">
                    <div class="card shadow-sm border-primary">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">Total Arrecadado</h5>
                            <p class="card-text text-success">R$ {{ number_format($totalArrecadado, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Assinaturas Ativas -->
                <div class="col-md-3">
                    <div class="card shadow-sm border-success">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success">Assinaturas Ativas</h5>
                            <p class="card-text">{{ $ativos }} / {{ $totalAssinaturas }}</p>
                        </div>
                    </div>
                </div>

                <!-- Assinaturas Inativas -->
                <div class="col-md-3">
                    <div class="card shadow-sm border-danger">
                        <div class="card-body text-center">
                            <h5 class="card-title text-danger">Assinaturas Inativas</h5>
                            <p class="card-text">{{ $inativos }} / {{ $totalAssinaturas }}</p>
                        </div>
                    </div>
                </div>

                <!-- Resumo por Plano -->
                <div class="col-md-3">
                    <div class="card shadow-sm border-warning">
                        <div class="card-body">
                            <h5 class="card-title text-warning">Resumo por Plano</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($resumoPorPlano as $planId => $total)
                                    <li class="list-group-item">
                                        {{ \App\Models\Plan::find($planId)->name }}: <span class="font-weight-bold">R$
                                            {{ number_format($total, 2, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Tabela de Assinaturas -->
            <h3 class="h5 mb-4">Assinaturas no Período</h3>
            <div class="table-responsive table-hover">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Plano</th>
                            <th>Data de Início</th>
                            <th>Data de Término</th>
                            <th>Status</th>
                            <th>Método de Pagamento</th>
                            <th>Status</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assinaturas as $assinatura)
                            <tr>
                                <td>{{ $assinatura->user->name }}</td>
                                <td>{{ $assinatura->plan->name }}</td>
                                <td>{{ $assinatura->start_date->format('d/m/Y') }}</td>
                                <td>{{ $assinatura->end_date->format('d/m/Y') }}</td>
                                <td>{{ $assinatura->is_active ? 'Ativa' : 'Inativa' }}</td>
                                <td>{{ $assinatura->payment_method }}</td>
                                <td>{{ $assinatura->payment_status }}</td>
                                <td>R$ {{ number_format($assinatura->plan->price, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Links de Paginação -->
            <div class="d-flex justify-content-center">
                {{ $assinaturas->links() }}
            </div>
        </div>
    </div>
@endsection
