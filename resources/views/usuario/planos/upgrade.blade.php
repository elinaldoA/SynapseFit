@extends('layouts.admin')

@section('title', 'Upgrade de plano')

@section('main-content')
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
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

    <div class="card mb-4 shadow">
        <div class="card-header bg-success text-white">Seu Plano Atual</div>
        <div class="card-body">
            @if ($planoAtual)
                <p><strong>Plano:</strong> {{ $planoAtual->plan->name }}</p>
                <p><strong>Vencimento:</strong> {{ $planoAtual->end_date->format('d/m/Y') }}</p>
            @else
                <p>Você ainda não possui um plano ativo.</p>
            @endif
        </div>
    </div>

    <div class="row">
        @foreach ($planos as $plano)
            @if (!$planoAtual || $plano->price > $planoAtual->plan->price)
                <div class="col-md-4 mb-4">
                    <div class="card border-primary shadow h-100">
                        <div class="card-header bg-primary text-white text-center">
                            <strong>{{ $plano->name }}</strong>
                        </div>
                        <div class="card-body text-center">
                            <p>{{ $plano->description }}</p>
                            <h4 class="text-success">R$ {{ number_format($plano->price, 2, ',', '.') }}</h4>
                            <p><strong>Duração:</strong> {{ $plano->duration_in_days }} dias</p>

                            <form action="{{ route('planos.assinar', $plano) }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="payment_method_{{ $plano->id }}">Escolha o método de pagamento:</label>
                                    <select name="payment_method" id="payment_method_{{ $plano->id }}" class="form-control" required>
                                        <option value="">Selecione...</option>
                                        <option value="pix">Pix</option>
                                        <option value="credito">Cartão de Crédito</option>
                                        <option value="debito">Cartão de Débito</option>
                                        <option value="boleto">Boleto</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-outline-primary mt-2">
                                    Assinar este plano
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <script>
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', () => {
                const botao = form.querySelector('button[type="submit"]');
                if (botao) {
                    botao.disabled = true;
                    botao.innerHTML = 'Processando...';
                }
            });
        });
    </script>
@endsection
