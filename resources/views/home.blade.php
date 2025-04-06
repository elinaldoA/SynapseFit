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

    @if (Auth::user()->role == 'admin')
    <div class="row">
        <!-- Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Users') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Bioimpedancias') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['bioimpedancias'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-weight fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Dietas') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['dietas'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Consumo de água') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['aguaLitros'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tint fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="row">
            <!-- Corpo Humano Card -->
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body text-center">
                        <div class="body-image">
                            <img src="{{ asset('img/homem.jpg') }}" alt="Corpo Humano" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico ao lado da imagem -->
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title text-center">Gráfico de Bioimpedância</h5>
                        <!-- Gráfico -->
                        <div id="grafico-bioimpedancia">
                            <canvas id="bioimpedanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Altura Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-ruler fa-fw"></i> Altura</h5>
                        <p class="card-text">{{ Auth::user()->height ?? 'Não disponível' }} M</p>
                    </div>
                </div>
            </div>

            <!-- IMC Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-weight fa-fw"></i> IMC</h5>
                        <p class="card-text">{{ $imc ?? 'Não disponível' }}</p>
                        <p class="card-text">
                            @if ($imc < 18.5)
                                <span class="text-danger">Abaixo do peso</span> - Recomenda-se aumentar a ingestão calórica
                                com foco em alimentação rica em proteínas e carboidratos.
                            @elseif ($imc >= 18.5 && $imc < 24.9)
                                <span class="text-success">Peso normal</span> - Continue mantendo hábitos saudáveis.
                            @elseif ($imc >= 25 && $imc < 29.9)
                                <span class="text-warning">Sobrepeso</span> - Considerar aumento de atividades físicas,
                                focando em exercícios aeróbicos e musculação.
                            @elseif ($imc >= 30 && $imc < 34.9)
                                <span class="text-danger">Obesidade grau 1</span> - É importante buscar um plano alimentar
                                controlado, com aumento da atividade física.
                            @elseif ($imc >= 35 && $imc < 39.9)
                                <span class="text-danger">Obesidade grau 2</span> - Aconselha-se acompanhamento médico e
                                nutricional.
                            @else
                                <span class="text-danger">Obesidade grau 3</span> - Aconselha-se avaliação médica imediata
                                para definir um plano de tratamento.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Percentual de Gordura Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-pump-medical fa-fw"></i> Percentual de Gordura</h5>
                        <p class="card-text">{{ $percentualGordura ?? 'Não disponível' }}%</p>
                        <p class="card-text">
                            @if (Auth::user()->sex == 'masculino')
                                @if ($percentualGordura >= 25)
                                    <span class="text-danger">Excesso de gordura</span> - Considerar redução do consumo de
                                    gorduras saturadas e aumento da atividade física.
                                @elseif ($percentualGordura >= 10 && $percentualGordura <= 20)
                                    <span class="text-success">Percentual saudável</span> - Manter alimentação equilibrada e
                                    treinos.
                                @elseif ($percentualGordura < 10)
                                    <span class="text-info">Atleta</span> - Continue com seu regime de treinamento e
                                    alimentação.
                                @endif
                            @else
                                @if ($percentualGordura >= 32)
                                    <span class="text-danger">Excesso de gordura</span> - Considerar dieta balanceada com
                                    redução de gorduras e aumento de atividades físicas.
                                @elseif ($percentualGordura >= 20 && $percentualGordura <= 30)
                                    <span class="text-success">Percentual saudável</span> - Excelente! Mantenha a rotina de
                                    exercícios e alimentação equilibrada.
                                @elseif ($percentualGordura < 20)
                                    <span class="text-info">Atleta</span> - Excelente condição física.
                                @endif
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Peso Atual Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-weight-hanging fa-fw"></i> Peso Atual</h5>
                        <p class="card-text">{{ Auth::user()->weight ?? 'Não disponível' }} kg</p>
                    </div>
                </div>
            </div>

            <!-- Peso Ideal Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-balance-scale fa-fw"></i> Peso Ideal</h5>
                        <p class="card-text">{{ $pesoIdealSuperior ?? 'Não disponível' }} kg</p>
                    </div>
                </div>
            </div>

            <!-- Massa Magra Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-dumbbell fa-fw"></i> Massa Magra</h5>
                        <p class="card-text">{{ $massaMagra ?? 'Não disponível' }} kg</p>
                        <p class="card-text">
                            @if ($massaMagra > 0 && $massaMagra < 50)
                                <span class="text-warning">Baixa</span> - Recomenda-se focar no treino de musculação para
                                aumento de massa muscular.
                            @elseif ($massaMagra >= 50 && $massaMagra <= 75)
                                <span class="text-success">Média</span> - Excelente! Continue com seu treino de força e
                                alimentação rica em proteínas.
                            @else
                                <span class="text-info">Alta</span> - Continue com seu regime, mas sempre mantenha o
                                equilíbrio no treino e alimentação.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Massa Gordura Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-tint fa-fw"></i> Massa Gordura</h5>
                        <p class="card-text">{{ $massaGordura ?? 'Não disponível' }} kg</p>
                        <p class="card-text">
                            @if ($massaGordura > 0 && $massaGordura < 20)
                                <span class="text-success">Baixa</span> - Isso é ótimo! Continue com sua alimentação
                                balanceada e treinos consistentes.
                            @elseif ($massaGordura >= 20 && $massaGordura <= 30)
                                <span class="text-warning">Média</span> - Continue com sua dieta e atividades físicas para
                                manter esse nível saudável.
                            @else
                                <span class="text-danger">Alta</span> - Considere um plano de emagrecimento, focando em
                                exercícios cardiovasculares e dieta.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Água Corporal Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-tint fa-fw"></i> Água Corporal</h5>
                        <p class="card-text">{{ $aguaCorporal ?? 'Não disponível' }} kg</p>
                        <p class="card-text">
                            @if (Auth::user()->sex == 'masculino')
                                {{ $aguaCorporal > 50 && $aguaCorporal < 65 ? 'Dentro da faixa saudável' : 'Fora da faixa saudável' }}
                            @else
                                {{ $aguaCorporal > 45 && $aguaCorporal < 60 ? 'Dentro da faixa saudável' : 'Fora da faixa saudável' }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Gordura Visceral Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-bone fa-fw"></i> Gordura Visceral</h5>
                        <p class="card-text">{{ $visceralFat ?? 'Não disponível' }}</p>
                        <p class="card-text">
                            @if ($visceralFat > 12)
                                <span class="text-danger">Excesso de gordura visceral</span> - É importante trabalhar para
                                reduzir a gordura visceral com exercícios e dieta.
                            @else
                                <span class="text-success">Faixa saudável</span> - Continue mantendo seus hábitos
                                saudáveis.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Idade Corporal Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-calendar-day fa-fw"></i> Idade Corporal</h5>
                        <p class="card-text">{{ $idadeCorporal ?? 'Não disponível' }} anos</p>
                        <p class="card-text">
                            @if ($idadeCorporal <= 30)
                                <span class="text-success">Saudável</span> - Ótimo! Continue cuidando de sua saúde.
                            @elseif ($idadeCorporal <= 40)
                                <span class="text-warning">Moderada</span> - Pode ser interessante avaliar seu estilo de
                                vida.
                            @else
                                <span class="text-danger">Acima da média</span> - Considere ajustes para melhorar sua
                                saúde.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- BMR Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-fire fa-fw"></i> BMR</h5>
                        <p class="card-text">{{ $bmr ?? 'Não disponível' }} kcal/dia</p>
                    </div>
                </div>
            </div>

            <!-- Massa Muscular Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-dumbbell fa-fw"></i> Massa Muscular</h5>
                        <p class="card-text">{{ $massaMuscular ?? 'Não disponível' }}</p>
                    </div>
                </div>
            </div>

            <!-- Massa Óssea Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-bone fa-fw"></i> Massa Óssea</h5>
                        <p class="card-text">{{ $massaOssea ?? 'Não disponível' }}</p>
                    </div>
                </div>
            </div>

            <!-- Impedância Segmentar Card -->
            <div class="col-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-random fa-fw"></i> Impedância Segmentar</h5>
                        <p class="card-text">{{ $impedanciaSegmentos ?? 'Não disponível' }}</p>
                        <p class="card-text">
                            @if ($impedanciaSegmentos !== 'Não disponível')
                                @if ($impedanciaSegmentos < 300)
                                    <span class="text-success">Massa magra predominante</span> - Excelente!
                                @elseif ($impedanciaSegmentos >= 300 && $impedanciaSegmentos < 400)
                                    <span class="text-warning">Equilíbrio</span> - Continue com seu equilíbrio saudável.
                                @else
                                    <span class="text-danger">Excesso de gordura</span> - Trabalhe para reduzir a gordura
                                    corporal.
                                @endif
                            @else
                                Dados não disponíveis
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var ctx = document.getElementById('bioimpedanceChart').getContext('2d');
            var bioimpedanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['IMC', 'Percentual de Gordura', 'Peso Ideal', 'Massa Magra', 'Massa Gordura'],
                    datasets: [{
                        label: 'Bioimpedância',
                        data: [{{ $imc }}, {{ $percentualGordura }}, {{ $pesoIdealSuperior }},
                            {{ $massaMagra }}, {{ $massaGordura }}
                        ],
                        backgroundColor: ['#FF5733', '#FFBD33', '#33FF57', '#3357FF', '#57FF33'],
                        borderColor: ['#FF5733', '#FFBD33', '#33FF57', '#3357FF', '#57FF33'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw + ' %';
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endif
@endsection
