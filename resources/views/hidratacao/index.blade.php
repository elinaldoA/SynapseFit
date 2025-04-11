@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800 text-center">Controle de Ingestão de Água</h1>

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

    <!-- Informações de Hidratação -->
    <div class="text-center mb-4">
        <p><strong>Status:</strong> {{ $status['mensagem'] }}</p>
        <p><strong>Consumido:</strong> {{ number_format($status['consumido_ml'] / 1000, 2) }}L</p>
        <p><strong>Meta Diária:</strong> {{ number_format($status['meta_ml'] / 1000, 2) }}L</p>

        @isset($status['faltando_ml'])
            <p><strong>Faltando:</strong> {{ number_format($status['faltando_ml'] / 1000, 2) }}L</p>
        @endisset
    </div>

    <!-- Velocímetro -->
    <div class="text-center mb-4">
        <div id="velocimetro" style="width: 100%; max-width: 400px; height: 250px; margin: auto;"></div>
        <p class="mt-2"><strong>Progresso:</strong> {{ number_format(($status['consumido_ml'] / $status['meta_ml']) * 100, 2) }}%</p>
    </div>

    <!-- Registrar Consumo -->
    <div class="text-center mb-4">
        <a href="{{ route('hidratacao.create') }}" class="btn btn-primary mt-3">Registrar Consumo</a>
    </div>

    <!-- Registros de Hoje -->
    <div class="mt-4">
        <h5 class="text-center">Registros de Hoje</h5>
        <ul class="list-group list-group-flush text-center">
            @forelse($registros as $registro)
                <li class="list-group-item">
                    {{ number_format($registro->quantidade / 1000, 2) }}L - {{ date('H:i', strtotime($registro->registrado_em)) }}
                </li>
            @empty
                <li class="list-group-item">Nenhum registro hoje.</li>
            @endforelse
        </ul>
    </div>

    <!-- Carregar as dependências do JustGage -->
    <script src="https://cdn.jsdelivr.net/npm/raphael@2.3.0/raphael.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/justgage@1.4.0/justgage.min.js"></script>

    <script>
        // Obtendo o valor do percentual de hidratação
        var consumido = {{ $status['consumido_ml'] }};
        var meta = {{ $status['meta_ml'] }};
        var percentual = (consumido / meta) * 100;

        // Criando o velocímetro com JustGage
        var g = new JustGage({
            id: "velocimetro",
            value: percentual,
            min: 0,
            max: 100,
            title: "Progresso de Hidratação",
            label: "%",
            levelColors: ["#ff0000", "#ffff00", "#00ff00"], // Definindo cores para diferentes níveis
            gaugeWidthScale: 0.1,
            pointer: true,
            customSectors: [
                { lo: 0, hi: 50, color: "#ff0000" },   // Vermelho para menos de 50%
                { lo: 51, hi: 75, color: "#ffff00" },  // Amarelo para 51% a 75%
                { lo: 76, hi: 100, color: "#00ff00" }  // Verde para 76% a 100%
            ]
        });
    </script>
@endsection
