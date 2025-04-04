@extends('layouts.usuario')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Controle de Ingestão de Água</h1>

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

    <!-- INDEX VIEW -->
    <div class="card mb-4 border-left-info shadow">
        <div class="card-header">Meta de Hidratação</div>
        <div class="card-body">
            <p><strong>Status:</strong> {{ $status['mensagem'] }}</p>
            <p><strong>Consumido:</strong> {{ number_format($status['consumido_ml'] / 1000, 2) }}L</p>
            <p><strong>Meta Diária:</strong> {{ number_format($status['meta_ml'] / 1000, 2) }}L</p>
            @if(isset($status['faltando_ml']))
                <p><strong>Faltando:</strong> {{ number_format($status['faltando_ml'] / 1000, 2) }}L</p>
            @endif
            <a href="{{ route('hidratacao.create') }}" class="btn btn-primary mt-2">Registrar Consumo</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Registros de Hoje</div>
        <ul class="list-group list-group-flush">
            @forelse($registros as $registro)
                <li class="list-group-item">
                    {{ number_format($registro->quantidade / 1000, 2) }}L - {{ date('H:i', strtotime($registro->registrado_em)) }}
                </li>
            @empty
                <li class="list-group-item">Nenhum registro hoje.</li>
            @endforelse
        </ul>
    </div>
@endsection
