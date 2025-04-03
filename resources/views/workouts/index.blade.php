@extends('layouts.usuario')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Meus Treinos') }}</h1>

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
        <div class="card-header d-flex justify-content-between">
            <span>Meus Treinos</span>
            <!--<span>
                <a href="{{ route('workouts.export') }}" class="btn btn-primary btn-sm"><i class="fa fa-file-pdf-o"></i> Exportar PDF</a>
            </span>-->
        </div>

        <div class="card-body">
            <!-- Exibindo as fichas únicas -->
            @foreach ($workouts as $workout)
                <div class="table-header">
                    <h3>Ficha {{ strtoupper($workout->type) }}</h3>
                    <a href="{{ route('workouts.show', ['type' => $workout->type]) }}" class="btn btn-info btn-sm">Ver Detalhes</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
