@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Meu treino') }}</h1>

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
                        <tr data-series="{{ $remainingSeries }}" data-rest="{{ $workout->descanso }}" data-id="{{ $workout->id }}">
                            <td>{{ $workout->exercise->name }}</td>
                            <td class="series-count">{{ $remainingSeries }}</td>
                            <td>{{ $workout->repeticoes }}</td>
                            <td>{{ $workout->descanso }} seg</td>
                            <td>
                                <input type="number" class="form-control carga-input" placeholder="Carga (kg)" value="{{ $progress[$workout->id]->carga ?? $workout->carga }}" min="0" step="0.5" />
                            </td>
                            <td>
                                <button class="btn btn-success startSet" @if ($remainingSeries == 0) style="display: none;" @endif>Iniciar Série</button>
                                <button class="btn btn-danger endSet" @if ($remainingSeries == 0) style="display: none;" @endif>Finalizar Série</button>
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
                    <div id="restTimer" class="circle-timer" style="position: relative; width: 150px; height: 150px; margin: 0 auto;">
                        <svg width="150" height="150" viewBox="0 0 150 150" style="display: block; margin: 0 auto;">
                            <circle cx="75" cy="75" r="70" stroke="#ddd" stroke-width="10" fill="none" />
                            <circle id="circle" cx="75" cy="75" r="70" stroke="green" stroke-width="10" fill="none" stroke-dasharray="439.82" stroke-dashoffset="0" />
                        </svg>
                        <div id="timeDisplay" class="time-display" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 24px;">
                            00:00
                        </div>
                    </div>
                    <button id="skipRest" class="btn btn-warning mt-3">Pular Descanso</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmEndWorkoutModal" tabindex="-1" role="dialog" aria-labelledby="confirmEndWorkoutModalLabel" aria-hidden="true">
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
    <div class="modal fade" id="congratulationsModal" tabindex="-1" role="dialog" aria-labelledby="congratulationsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="congratulationsModalLabel">
                        <i class="fas fa-trophy"></i> Parabéns, {{Auth::user()->name}}!
                    </h5>
                </div>
                <div class="modal-body">
                    <p><i class="fas fa-dumbbell"></i> Você completou o treino com sucesso e deu um grande passo para alcançar seus objetivos!</p>
                    <p>Continue assim e vença cada desafio!</p>
                    <p><strong>Total de Carga Levantada:</strong> <span id="totalCarga"></span> kg</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-check-circle"></i> Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startWorkout = document.getElementById('startWorkout');
            const endWorkout = document.getElementById('endWorkout');
            const startSetButtons = document.querySelectorAll('.startSet');
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

            startWorkout.addEventListener('click', function() {
                startWorkout.disabled = true;
                endWorkout.disabled = false;  // Habilita o botão "Finalizar Treino"
                startSetButtons.forEach(btn => btn.disabled = false);
                saveButtonStates();
            });

            endWorkout.addEventListener('click', function() {
                confirmEndWorkoutModal.show();
            });

            document.getElementById('confirmEndWorkout').addEventListener('click', function() {
                confirmEndWorkoutModal.hide();
                // Exibir o total de carga no modal de Parabéns
                document.getElementById('totalCarga').textContent = totalCarga.toFixed(2);
                congratulationsModal.show();
            });

            document.querySelectorAll('.startSet').forEach(button => {
                button.addEventListener('click', function() {
                    let row = this.closest('tr');
                    let endSetButton = row.querySelector('.endSet');
                    this.disabled = true;
                    endSetButton.disabled = false;
                });
            });

            document.querySelectorAll('.endSet').forEach(button => {
                button.addEventListener('click', function() {
                    let row = this.closest('tr');
                    let seriesCount = row.querySelector('.series-count');
                    let restTime = parseInt(row.getAttribute('data-rest'));
                    let currentSeries = parseInt(seriesCount.textContent);

                    // Somar a carga total
                    let carga = parseFloat(row.querySelector('.carga-input').value.trim()) || 0;
                    totalCarga += carga;

                    if (currentSeries > 1) {
                        seriesCount.textContent = currentSeries - 1;
                        startRestTimer(restTime, row);
                    } else if (currentSeries === 1) {
                        seriesCount.textContent = 'Finalizado';
                        this.disabled = true;
                        row.querySelector('.startSet').disabled = true;
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
                let remainingSeries = row.querySelector('.series-count').textContent.trim();

                if (remainingSeries === 'Finalizado') {
                    remainingSeries = 0;
                }

                const carga = row.querySelector('.carga-input').value.trim();
                let status = 'Em andamento'; // Default status

                if (remainingSeries === 0) {
                    status = 'Finalizado'; // Treino finalizado
                }

                fetch('/save-progress', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ workout_id: workoutId, series_completed: remainingSeries, carga: carga, status: status })
                })
                .then(response => response.json())
                .then(data => console.log('Progresso salvo', data))
                .catch(error => console.error('Erro ao salvar progresso', error));
            }

            function restoreButtonStates() {
                // Código para restaurar os estados dos botões após recarregar a página
            }

            function saveButtonStates() {
                // Código para salvar os estados dos botões antes de navegar ou recarregar a página
            }
        });
    </script>
@endsection
