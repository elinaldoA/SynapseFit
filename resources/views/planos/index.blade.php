@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Planos disponíveis</h1>

    <div class="row">
        @foreach($plans as $plano)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header text-center font-weight-bold">
                        {{ $plano->name }}
                    </div>
                    <div class="card-body text-center">
                        <p>{{ $plano->description }}</p>
                        <h4>R$ {{ number_format($plano->price, 2, ',', '.') }}</h4>
                        <p>Duração: {{ $plano->duration_in_days }} dias</p>
                        <a href="{{ route('planos.confirmar', $plano) }}" class="btn btn-primary">
                            Assinar plano
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
