@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Meu treino') }}</h1>

    <div class="card-header">
        <strong>Nome:</strong> {{ Auth::user()->name }} <br>
        <strong>Objetivo:</strong> {{ Auth::user()->objetivo ?? 'Não definido' }}
    </div>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card mt-3 mb-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Ficha: {{ ucfirst($type) }}</span>
        </div>

        <div class="card-body text-center">
            <button id="startWorkout" class="btn btn-success">Iniciar Treino</button>
            <button id="endWorkout" class="btn btn-danger" disabled>Finalizar Treino</button>

            <br><br>

            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>Exercício</th>
                        <th>Orientação</th>
                        <th>Séries</th>
                        <th>Repetições</th>
                        <th>Descanso</th>
                        <th>Carga</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workouts as $workout)
                        @php
                            $progressData = $progress[$workout->id] ?? null;
                            $remainingSeries = $progressData ? $progressData->remaining_series : $workout->series;
                        @endphp
                        <tr data-series="{{ $remainingSeries }}" data-rest="{{ $workout->descanso }}"
                            data-id="{{ $workout->id }}">
                            <td>{{ $workout->exercise->name }}</td>
                            <td>
                                @if ($workout->exercise->video_url)
                                    @php
                                        // Verificar se o link é do YouTube
                                        $videoUrl = $workout->exercise->video_url;

                                        // Se o link for do YouTube, converter para o formato embed
                                        if (strpos($videoUrl, 'youtube.com/watch?v=') !== false) {
                                            // Extrair o ID do vídeo do link do YouTube
                                            preg_match('/[\\?\\&]v=([^\\?\\&]*)/', $videoUrl, $matches);
                                            $videoId = $matches[1];
                                            $videoUrl = "https://www.youtube.com/embed/$videoId";
                                        }
                                    @endphp

                                    <!-- Botão que abre o modal -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#videoModal{{ $workout->exercise->id }}">
                                        <i class="fa fa-video"></i> {{ __('Assistir') }}
                                    </button>

                                    <!-- Modal para cada vídeo -->
                                    <div class="modal fade" id="videoModal{{ $workout->exercise->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="videoModalLabel{{ $workout->exercise->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="videoModalLabel{{ $workout->exercise->id }}">
                                                        {{ __('Vídeo de Orientação') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Exibir o vídeo embutido -->
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe class="embed-responsive-item" src="{{ $videoUrl }}"
                                                            allowfullscreen></iframe>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">{{ __('Fechar') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">{{ __('Não disponível') }}</span>
                                @endif
                            </td>
                            <td class="series-count" data-value="{{ $remainingSeries }}">
                                {{ str_repeat('✔ ', 3 - $remainingSeries) }}{{ $remainingSeries > 0 ? $remainingSeries : '' }}
                            </td>
                            <td>{{ $workout->repeticoes }}</td>
                            <td>{{ $workout->descanso }} seg</td>
                            <td>
                                <input type="number" class="form-control carga-input" placeholder="Carga (kg)"
                                    value="{{ $progress[$workout->id]->carga ?? $workout->carga }}" min="0"
                                    step="0.5" />
                            </td>
                            <td>
                                <button class="btn btn-danger endSet"
                                    @if ($remainingSeries == 0) style="display: none;" @endif>Finalizar</button>
                                <button class="btn btn-primary finishAllSets"
                                    @if ($remainingSeries == 0) style="display: none;" @endif><i
                                        class="fa fa-check-double"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Descanso -->
    <div class="modal fade" id="restModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tempo de Descanso</h5>
                </div>
                <div class="modal-body text-center">
                    <div id="restTimer" class="circle-timer"
                        style="position: relative; width: 150px; height: 150px; margin: 0 auto;">
                        <svg width="150" height="150" viewBox="0 0 150 150" style="display: block; margin: 0 auto;">
                            <circle cx="75" cy="75" r="70" stroke="#ddd" stroke-width="10" fill="none" />
                            <circle id="circle" cx="75" cy="75" r="70" stroke="green" stroke-width="10"
                                fill="none" stroke-dasharray="439.82" stroke-dashoffset="0" />
                        </svg>
                        <div id="timeDisplay" class="time-display"
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 24px;">
                            00:00
                        </div>
                    </div>
                    <button id="skipRest" class="btn btn-warning mt-3">Pular Descanso</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmEndWorkoutModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmEndWorkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmEndWorkoutModalLabel">Confirmar Finalização</h5>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja finalizar o treino?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmEndWorkout">Finalizar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Parabéns -->
    <div class="modal fade" id="congratulationsModal" tabindex="-1" role="dialog"
        aria-labelledby="congratulationsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="congratulationsModalLabel">
                        <i class="fas fa-trophy"></i> Parabéns, {{ Auth::user()->name }}!
                    </h5>
                </div>
                <div class="modal-body">
                    <p><i class="fas fa-dumbbell"></i> Você completou o treino com sucesso e deu um grande passo para
                        alcançar seus objetivos!</p>
                    <p>Continue assim e vença cada desafio!</p>
                    <p><strong>Total de Carga Levantada:</strong> <span id="totalCarga"></span> kg</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal"><i
                            class="fas fa-check-circle"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const finishAllSetsButtons = document.querySelectorAll('.finishAllSets');
            const startWorkout = document.getElementById('startWorkout');
            const endWorkout = document.getElementById('endWorkout');
            const endSetButtons = document.querySelectorAll('.endSet');
            const restModal = new bootstrap.Modal(document.getElementById('restModal'));
            const restTimer = document.getElementById('restTimer');
            const skipRest = document.getElementById('skipRest');
            const timeDisplay = document.getElementById('timeDisplay');
            const circle = document.getElementById('circle');
            const confirmEndWorkoutModal = new bootstrap.Modal(document.getElementById('confirmEndWorkoutModal'));
            const congratulationsModal = new bootstrap.Modal(document.getElementById('congratulationsModal'));
            let timerInterval;
            let totalCarga = 0;

            restoreButtonStates();
            window.addEventListener('beforeunload', saveButtonStates);

            // ✅ Lógica para o botão "Finalizar todas as séries"
            finishAllSetsButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr'); // Pega a linha do exercício específico
                    const seriesCount = row.querySelector('.series-count');
                    const endSetButton = row.querySelector('.endSet');
                    const finishAllSetsButton = row.querySelector('.finishAllSets');

                    let remainingSeries = parseInt(seriesCount.textContent);

                    // Finaliza todas as 3 séries clicando no botão "Finalizar Série"
                    while (remainingSeries > 0) {
                        endSetButton.click(); // Simula o clique no botão "Finalizar Série"
                        remainingSeries--;
                    }

                    // Desabilita o botão "Finalizar Todas as Séries" após ser clicado
                    this.disabled = true;
                });
            });

            startWorkout.addEventListener('click', function() {
                startWorkout.disabled = true;
                endWorkout.disabled = false;
                restoreAllSets();
                updateButtonStates();

                // ✅ Garante que os eventos de clique sejam adicionados novamente
                finishAllSetsButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const row = this.closest('tr');
                        const seriesCount = row.querySelector('.series-count');
                        const endSetButton = row.querySelector('.endSet');

                        let remainingSeries = parseInt(seriesCount.textContent);

                        while (remainingSeries > 0) {
                            endSetButton.click();
                            remainingSeries--;
                        }

                        this.disabled = true;
                    });
                });

                saveButtonStates();
            });


            endWorkout.addEventListener('click', function() {
                confirmEndWorkoutModal.show();
            });

            document.getElementById('confirmEndWorkout').addEventListener('click', function() {
                confirmEndWorkoutModal.hide();
                document.getElementById('totalCarga').textContent = totalCarga.toFixed(2);
                congratulationsModal.show();

                setTimeout(function() {
                    location.reload();
                }, 1000);

                restoreAllButtonsAfterWorkout();
            });

            document.querySelectorAll('.endSet').forEach(button => {
                button.addEventListener('click', function() {
                    let row = this.closest('tr');
                    let seriesCount = row.querySelector('.series-count');
                    let restTime = parseInt(row.getAttribute('data-rest'));
                    let currentSeries = parseInt(seriesCount.dataset.value, 10) || 3;

                    let carga = parseFloat(row.querySelector('.carga-input').value.trim()) || 0;
                    totalCarga += carga;

                    if (currentSeries > 1) {
                        currentSeries -= 1;
                        seriesCount.dataset.value = currentSeries;
                        seriesCount.innerHTML = `${'✔ '.repeat(3 - currentSeries)}${currentSeries}`;
                        startRestTimer(restTime, row);
                    } else if (currentSeries === 1) {
                        seriesCount.dataset.value = 3;
                        seriesCount.innerHTML = '✔ ✔ ✔';
                        this.disabled = true;
                        row.querySelector('.endSet').disabled = true;
                        row.querySelector('.finishAllSets').disabled = true;
                        startRestTimer(restTime, row);
                    }

                    saveWorkoutProgress(row);
                });
            });

            function startRestTimer(seconds, row) {
                if (timerInterval) {
                    clearInterval(timerInterval);
                }

                restModal.show();
                let remainingTime = seconds;
                timeDisplay.textContent = formatTime(remainingTime);

                const totalLength = 439.82;
                const dashoffset = totalLength - (totalLength * (remainingTime / seconds));
                circle.style.strokeDashoffset = dashoffset;

                timerInterval = setInterval(() => {
                    remainingTime--;
                    timeDisplay.textContent = formatTime(remainingTime);

                    const dashoffset = totalLength - (totalLength * (remainingTime / seconds));
                    circle.style.strokeDashoffset = dashoffset;

                    if (remainingTime <= 5) {
                        timeDisplay.style.color = 'red';
                        timeDisplay.style.fontWeight = 'bold';
                    } else {
                        timeDisplay.style.color = 'black';
                        timeDisplay.style.fontWeight = 'normal';
                    }

                    if (remainingTime <= 0) {
                        clearInterval(timerInterval);
                        restModal.hide();
                        row.querySelector('.startSet').disabled = false;
                    }
                }, 1000);
            }

            skipRest.addEventListener('click', function() {
                clearInterval(timerInterval);
                restModal.hide();
                document.querySelectorAll('.startSet').forEach(btn => btn.disabled = false);
            });

            function formatTime(seconds) {
                let minutes = Math.floor(seconds / 60);
                let secs = seconds % 60;
                return `${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            }

            function saveWorkoutProgress(row) {
                const workoutId = row.getAttribute('data-id');
                let remainingSeries = parseInt(row.querySelector('.series-count').dataset.value, 10) || 3;
                let carga = row.querySelector('.carga-input').value.trim();
                let status = remainingSeries === 3 ? 'Finalizado' : 'Em andamento';

                fetch('/save-progress', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                        },
                        body: JSON.stringify({
                            workout_id: workoutId,
                            series_completed: remainingSeries,
                            carga: carga,
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => console.log('Progresso salvo', data))
                    .catch(error => console.error('Erro ao salvar progresso', error));
            }


            function saveButtonStates() {
                const buttonStates = {};

                // Itera sobre todos os botões de "Iniciar Série" e "Finalizar Série"
                document.querySelectorAll('.startSet').forEach(button => {
                    button.addEventListener('click', function() {
                        let row = this.closest('tr');
                        let endSetButton = row.querySelector('.endSet');
                        // Desabilita o botão "Iniciar Série" ao clicar nele
                        this.disabled = true;
                        // Habilita o botão "Finalizar Série" ao clicar no botão "Iniciar Série"
                        endSetButton.disabled = false;
                    });
                });


                // Salva os estados dos botões de treino
                const workoutButtonsState = {
                    startWorkoutDisabled: document.getElementById('startWorkout').disabled,
                    endWorkoutDisabled: document.getElementById('endWorkout').disabled
                };

                // Adiciona os estados dos botões de treino ao objeto de estados
                buttonStates['workout'] = workoutButtonsState;

                // Salva os estados no localStorage
                localStorage.setItem('buttonStates', JSON.stringify(buttonStates));
            }

            function restoreButtonStates() {
                const buttonStates = JSON.parse(localStorage.getItem('buttonStates')) || {};

                if (buttonStates['workout']) {
                    const startWorkoutButton = document.getElementById('startWorkout');
                    const endWorkoutButton = document.getElementById('endWorkout');

                    if (startWorkoutButton) {
                        startWorkoutButton.disabled = buttonStates['workout'].startWorkoutDisabled;
                    }

                    if (endWorkoutButton) {
                        endWorkoutButton.disabled = buttonStates['workout'].endWorkoutDisabled;

                        // Se o treino já foi iniciado, habilita os botões de "Finalizar Série"
                        if (!startWorkoutButton.disabled) {
                            document.querySelectorAll('.endSet, .finishAllSets').forEach(btn => {
                                btn.style.display = 'inline-block';
                                btn.disabled = false;
                            });
                        }
                    }
                }
            }


            function updateButtonStates() {
                const isWorkoutActive = !endWorkout.disabled;
                document.querySelectorAll('.endSet').forEach(btn => btn.disabled = !isWorkoutActive);
                document.querySelectorAll('.finishAllSets').forEach(btn => btn.disabled = !isWorkoutActive);
            }

            function restoreAllButtonsAfterWorkout() {
                // Restaura os botões de treino após o fim do treino
                startWorkout.disabled = false; // Habilita o botão "Iniciar Treino"
                endWorkout.disabled = true; // Desabilita o botão "Finalizar Treino"

                // Restaura os botões de série e seus contadores
                document.querySelectorAll('tr').forEach(row => {
                    const endSetButton = row.querySelector('.endSet');
                    const finishAllSetsButton = row.querySelector('.finishAllSets');
                    const seriesCount = row.querySelector('.series-count');

                    if (endSetButton) {
                        endSetButton.disabled = false; // Habilita o botão "Finalizar Série"
                    }
                    if (finishAllSetsButton) {
                        finishAllSetsButton.disabled =
                            false; // Habilita o botão "Finalizar Todas as Séries"
                    }
                    if (seriesCount) {
                        seriesCount.dataset.value = 3; // Reinicia o contador de séries no dataset
                        seriesCount.textContent = '3'; // Atualiza a interface com 3 séries restantes
                    }
                });

                updateButtonStates(); // Agora a função está definida e pode ser chamada
                saveButtonStates(); // Salva o estado atualizado
            }



            function restoreAllSets() {
                document.querySelectorAll('.finishAllSets').forEach(button => {
                    button.disabled = false; // Habilita o botão "Finalizar Todas as Séries"
                });

                // Reinicia os contadores de séries
                document.querySelectorAll('.series-count').forEach(count => {
                    count.textContent = 3;
                });
            }
        });
    </script>
@endsection
