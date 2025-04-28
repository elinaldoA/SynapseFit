@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Relatório de Assinaturas</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Ativas</h5>
                    <p class="card-text display-4">{{ $ativas }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Expiradas</h5>
                    <p class="card-text display-4">{{ $expiradas }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total</h5>
                    <p class="card-text display-4">{{ $total }}</p>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('assinaturas') }}" class="btn btn-secondary">Voltar para Assinaturas</a>
</div>
@endsection
