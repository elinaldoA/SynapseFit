@extends('layouts.admin')

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
        <!-- Gráfico do IMC -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="text-center">IMC</h5>
                    <canvas id="imcChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico do Percentual de Gordura -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="text-center">Percentual de Gordura</h5>
                    <canvas id="gorduraChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico das Calorias Recomendadas -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="text-center">Calorias Recomendadas</h5>
                    <canvas id="caloriasChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Exibindo informações adicionais -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5>Peso Ideal Inferior</h5>
                    <p>{{ $pesoIdealInferior }} kg</p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5>Peso Ideal Superior</h5>
                    <p>{{ $pesoIdealSuperior }} kg</p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5>Massa Magra</h5>
                    <p>{{ $massaMagra }} kg</p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5>Massa Gordura</h5>
                    <p>{{ $massaGordura }} kg</p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5>Água Corporal</h5>
                    <p>{{ $aguaCorporal }} %</p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5>Gordura Visceral</h5>
                    <p>{{ $visceralFat }} %</p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5>Idade Corporal</h5>
                    <p>{{ $idadeCorporal }} anos</p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5>BMR (Taxa de Metabolismo Basal)</h5>
                    <p>{{ $bmr }} kcal/dia</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Obter os dados passados pelo controlador
        var imc = @json($imc);
        var percentualGordura = @json($percentualGordura);
        var caloriasRecomendadas = @json($caloriasRecomendadas);

        // Gráfico de IMC
        var imcChartCtx = document.getElementById('imcChart').getContext('2d');
        new Chart(imcChartCtx, {
            type: 'bar',
            data: {
                labels: ['IMC'],
                datasets: [{
                    label: 'IMC',
                    data: [imc],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico do Percentual de Gordura
        var gorduraChartCtx = document.getElementById('gorduraChart').getContext('2d');
        new Chart(gorduraChartCtx, {
            type: 'pie',
            data: {
                labels: ['Gordura', 'Massa Magra'],
                datasets: [{
                    data: [percentualGordura, 100 - percentualGordura],
                    backgroundColor: ['#ff6384', '#36a2eb'],
                    borderWidth: 1
                }]
            }
        });

        // Gráfico das Calorias Recomendadas
        var caloriasChartCtx = document.getElementById('caloriasChart').getContext('2d');
        new Chart(caloriasChartCtx, {
            type: 'doughnut',
            data: {
                labels: ['Calorias Recomendadas'],
                datasets: [{
                    data: [caloriasRecomendadas],
                    backgroundColor: ['#ffcc00'],
                    borderWidth: 1
                }]
            }
        });
    </script>
@endsection
