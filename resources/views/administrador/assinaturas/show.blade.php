@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Detalhes da Assinatura</h1>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">{{ $assinatura->user->name }}</h5>
            <p><strong>Plano:</strong> {{ $assinatura->plan->name }}</p>
            <p><strong>Tipo:</strong> {{ $assinatura->tipo }}</p>
            <p><strong>Início:</strong> {{ $assinatura->start_date->format('d/m/Y') }}</p>
            <p><strong>Fim:</strong> {{ $assinatura->end_date->format('d/m/Y') }}</p>
            <p><strong>Status:</strong> {{ $assinatura->status }}</p>
            <p><strong>Dias Restantes:</strong> {{ $assinatura->dias_restantes }}</p>

            <a href="{{ route('assinaturas') }}" class="btn btn-secondary mt-3">Voltar</a>
        </div>
    </div>
</div>
@endsection
