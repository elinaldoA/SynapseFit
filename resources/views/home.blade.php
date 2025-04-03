@extends('layouts.usuario')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <!-- Coluna para o Corpo Humano -->
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body text-center">
                    <div class="body-image">
                        <img src="{{ asset('img/homem.jpg') }}" alt="Corpo Humano" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna para os Dados de Bioimpedância -->
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h3>Informações de Bioimpedância</h3>
                    <table class="table table-bordered">
                        <tr>
                            <th>Altura:</th>
                            <td>{{ Auth::user()->height ?? 'Não disponível' }} M</td>
                        </tr>
                        <tr>
                            <th>IMC:</th>
                            <td>{{ $imc ?? 'Não disponível' }}</td>
                        </tr>
                        <tr>
                            <th>Percentual de Gordura:</th>
                            <td>{{ $percentualGordura ?? 'Não disponível' }}%</td>
                        </tr>
                        <tr>
                            <th>Peso Atual:</th>
                            <td>{{ Auth::user()->weight ?? 'Não disponível' }} kg</td>
                        </tr>
                        <tr>
                            <th>Peso Ideal:</th>
                            <td>{{ $pesoIdealSuperior ?? 'Não disponível' }} kg</td>
                        </tr>
                        <tr>
                            <th>Massa Magra:</th>
                            <td>{{ $massaMagra ?? 'Não disponível' }} kg</td>
                        </tr>
                        <tr>
                            <th>Massa Gordura:</th>
                            <td>{{ $massaGordura ?? 'Não disponível' }} kg</td>
                        </tr>
                        <tr>
                            <th>Água Corporal:</th>
                            <td>{{ $aguaCorporal ?? 'Não disponível' }} kg</td>
                        </tr>
                        <tr>
                            <th>Gordura Visceral:</th>
                            <td>{{ $visceralFat ?? 'Não disponível' }}</td>
                        </tr>
                        <tr>
                            <th>Idade Corporal:</th>
                            <td>{{ $idadeCorporal ?? 'Não disponível' }} anos</td>
                        </tr>
                        <tr>
                            <th>BMR:</th>
                            <td>{{ $bmr ?? 'Não disponível' }} kcal/dia</td>
                        </tr>
                        <tr>
                            <th>Massa Muscular:</th>
                            <td>{{ $massaMuscular ?? 'Não disponível' }}</td>
                        </tr>
                        <tr>
                            <th>Massa Ossea:</th>
                            <td>{{ $massaOssea ?? 'Não disponível' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        .body-image img {
            max-width: 100%;
            height: auto;
        }
        .bioimpedance-info table th {
            width: 40%;
        }
        .bioimpedance-info table td {
            width: 60%;
        }
    </style>
@endsection
