@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <h1 class="mb-4">Jejum Intermitente</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (!$jejum)
            <div class="text-center">
                <p>Você ainda não criou um plano de jejum intermitente.</p>
                <a href="{{ route('jejum.create') }}" class="btn btn-primary">Criar Plano de Jejum</a>
            </div>
        @else
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Seu Plano de Jejum</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Protocolo:</strong> {{ $jejum->protocolo }}</p>
                            <p><strong>Duração:</strong> {{ $jejum->duracao_jejum }} horas</p>
                            <p><strong>Início:</strong> {{ $jejum->inicio }}</p>
                            <p><strong>Objetivo:</strong> {{ $jejum->objetivo }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Peso Atual:</strong> {{ $jejum->peso_atual ?? 'Não informado' }} kg</p>
                            <p><strong>Meta de Peso:</strong> {{ $jejum->peso_meta }} kg</p>
                            <p><strong>Status:</strong>
                                <span class="badge
                                    @if ($jejum->status == 'ativo') bg-success
                                    @elseif($jejum->status == 'pausado') bg-warning text-dark
                                    @else bg-secondary @endif">
                                    {{ ucfirst($jejum->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($jejum->status !== 'inativo')
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Cronômetro de Jejum</h3>
                    </div>
                    <div class="card-body text-center">
                        <div id="cronometro" data-duracao="{{ $jejum->duracao_jejum }}" data-inicio="{{ $jejum->inicio }}"
                            data-status="{{ $jejum->status }}" data-pausado-em="{{ $jejum->pausado_em }}">
                            <div id="relogio" class="cronometro-circulo">00:00:00</div>
                            <style>
                                .cronometro-circulo {
                                    width: 250px;
                                    height: 250px;
                                    border: 6px solid #007bff;
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 2.5rem;
                                    font-weight: bold;
                                    margin: 0 auto;
                                    color: #007bff;
                                    box-shadow: 0 0 15px rgba(0, 123, 255, 0.3);
                                    transition: all 0.3s ease-in-out;
                                    background: #f8f9fa;
                                }
                            </style>
                        </div>
                    </div>
                </div>
            @endif

            @if (isset($progresso))
                <div class="mb-4">
                    <h4>Progresso para o objetivo</h4>
                    <div class="progress mb-1">
                        <div class="progress-bar {{ $progresso > 0 ? 'bg-success' : 'bg-secondary' }}" role="progressbar"
                            style="width: {{ $progresso }}%;" aria-valuenow="{{ $progresso }}" aria-valuemin="0"
                            aria-valuemax="100">
                            {{ $mensagemProgresso }}
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-4">
                <h4>Dias da Semana</h4>
                <div class="d-flex justify-content-between">
                    @foreach ($diasDaSemana as $dia)
                        @php
                            $ativo = in_array($dia, $diasMarcados ?? []);
                        @endphp
                        <div style="width: 13%; text-align: center;">
                            <div style="width: 40px; height: 40px; border-radius: 50%;
                                background-color: {{ $ativo ? '#28a745' : '#e0e0e0' }};
                                color: {{ $ativo ? '#fff' : '#000' }};
                                margin: auto; line-height: 40px;">
                                {{ $dia }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('jejum.toggle') }}">
                    @csrf
                    @method('PUT')

                    @if ($jejum->status === 'ativo')
                        <button type="submit" name="acao" value="pausar" class="btn btn-warning">Pausar Jejum</button>
                        <button type="button" id="cancelar-jejum" class="btn btn-danger">Cancelar Jejum</button>
                    @elseif($jejum->status === 'pausado')
                        <button type="submit" name="acao" value="retomar" class="btn btn-success">Retomar Jejum</button>
                        <button type="button" id="cancelar-jejum" class="btn btn-danger">Cancelar Jejum</button>
                    @else
                        <button type="submit" name="acao" value="ativar" class="btn btn-primary">Ativar Jejum</button>
                    @endif

                </form>

                <form id="form-cancelar" method="POST" action="{{ route('jejum.destroy', $jejum->id) }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            <!-- Modal Bootstrap -->
            <div class="modal fade" id="modalCancelarJejum" tabindex="-1" role="dialog" aria-labelledby="modalCancelarJejumLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="modalCancelarJejumLabel">Cancelar Jejum</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar">X</button>
                        </div>
                        <div class="modal-body">
                            Tem certeza que deseja cancelar seu jejum intermitente? <strong>Todos os dados serão perdidos.</strong>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                            <button type="button" class="btn btn-danger" id="confirmar-cancelamento">Sim, cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <br /><br />
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cronometroContainer = document.getElementById('cronometro');
            const relogio = document.getElementById('relogio');
            const cancelarJejumBtn = document.getElementById('cancelar-jejum');
            const formCancelar = document.getElementById('form-cancelar');
            const confirmarBtn = document.getElementById('confirmar-cancelamento');

            if (!cronometroContainer) return;

            const duracaoTotal = parseInt(cronometroContainer.dataset.duracao) * 3600;
            const horaInicio = cronometroContainer.dataset.inicio;
            const statusJejum = cronometroContainer.dataset.status;
            const pausadoEm = cronometroContainer.dataset.pausadoEm;

            let tempoRestante = 0;
            let intervalo;

            function parseHorarioParaDataCompleta(horario) {
                const [hora, minuto] = horario.split(':');
                const agora = new Date();
                return new Date(agora.getFullYear(), agora.getMonth(), agora.getDate(), hora, minuto, 0);
            }

            function iniciarCronometro() {
                clearInterval(intervalo);
                const agora = new Date();
                const inicio = parseHorarioParaDataCompleta(horaInicio);
                let tempoDecorrido = 0;

                if (statusJejum === 'pausado' && pausadoEm) {
                    const pausa = new Date(pausadoEm);
                    tempoDecorrido = (pausa - inicio) / 1000;
                } else if (statusJejum === 'ativo') {
                    tempoDecorrido = (agora - inicio) / 1000;
                }

                tempoRestante = Math.max(0, duracaoTotal - tempoDecorrido);
                if (tempoRestante <= 0) {
                    relogio.innerHTML = 'Jejum Concluído!';
                    return;
                }

                atualizarRelogio();
                if (statusJejum === 'ativo') {
                    intervalo = setInterval(() => {
                        tempoRestante--;
                        if (tempoRestante <= 0) {
                            clearInterval(intervalo);
                            relogio.innerHTML = 'Jejum Concluído!';
                        } else {
                            atualizarRelogio();
                        }
                    }, 1000);
                }
            }

            function atualizarRelogio() {
                const horas = Math.floor(tempoRestante / 3600);
                const minutos = Math.floor((tempoRestante % 3600) / 60);
                const segundos = Math.floor(tempoRestante % 60);
                relogio.innerHTML =
                    `${String(horas).padStart(2, '0')}:${String(minutos).padStart(2, '0')}:${String(segundos).padStart(2, '0')}`;
            }

            if (statusJejum === 'ativo' || statusJejum === 'pausado') {
                iniciarCronometro();
                if (statusJejum === 'pausado') relogio.innerHTML += ' (Pausado)';
            }

            if (cancelarJejumBtn) {
                cancelarJejumBtn.addEventListener('click', function() {
                    const modal = new bootstrap.Modal(document.getElementById('modalCancelarJejum'));
                    modal.show();
                });
            }

            if (confirmarBtn) {
                confirmarBtn.addEventListener('click', function() {
                    formCancelar.submit();
                });
            }

            function verificarAtivacaoAutomatica() {
                if (statusJejum === 'inativo') {
                    const agora = new Date();
                    const horaInicioObj = parseHorarioParaDataCompleta(horaInicio);
                    if (agora >= horaInicioObj) {
                        fetch("{{ route('jejum.toggle') }}", {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ acao: 'ativar' })
                        }).then(() => window.location.reload());
                    }
                }
            }

            setInterval(verificarAtivacaoAutomatica, 60000);
            verificarAtivacaoAutomatica();
        });
    </script>
@endsection
