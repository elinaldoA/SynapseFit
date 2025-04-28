@extends('layouts.admin')

@section('main-content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold"><i class="fas fa-stopwatch me-2"></i> Editar Jejum Intermitente</h1>

    <form method="POST" action="{{ route('jejum.update', $jejum->id) }}">
        @csrf
        @method('PUT')

        <!-- Card Jejum -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-semibold">
                Dados do Jejum
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="protocolo" class="form-label">Protocolo de Jejum</label>
                    <select name="protocolo" class="form-control" required>
                        <option value="12:12" {{ $jejum->protocolo == '12:12' ? 'selected' : '' }}>12:12</option>
                        <option value="14:10" {{ $jejum->protocolo == '14:10' ? 'selected' : '' }}>14:10</option>
                        <option value="16:8" {{ $jejum->protocolo == '16:8' ? 'selected' : '' }}>16:8</option>
                        <option value="18:6" {{ $jejum->protocolo == '18:6' ? 'selected' : '' }}>18:6</option>
                        <option value="24:0" {{ $jejum->protocolo == '24:0' ? 'selected' : '' }}>OMAD (24h)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="duracao_jejum" class="form-label">Duração do Jejum</label>
                    <select name="duracao_jejum" class="form-control" required>
                        <option value="12" {{ $jejum->duracao_jejum == 12 ? 'selected' : '' }}>12 horas</option>
                        <option value="14" {{ $jejum->duracao_jejum == 14 ? 'selected' : '' }}>14 horas</option>
                        <option value="16" {{ $jejum->duracao_jejum == 16 ? 'selected' : '' }}>16 horas</option>
                        <option value="18" {{ $jejum->duracao_jejum == 18 ? 'selected' : '' }}>18 horas</option>
                        <option value="24" {{ $jejum->duracao_jejum == 24 ? 'selected' : '' }}>24 horas (OMAD)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="inicio" class="form-label">Data e Hora de Início</label>
                    <input type="datetime-local" name="inicio" class="form-control" value="{{ old('inicio', \Carbon\Carbon::parse($jejum->inicio)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="mb-3">
                    <label for="objetivo" class="form-label">Objetivo com o Jejum</label>
                    <select name="objetivo" class="form-control" required>
                        <option value="Emagrecimento" {{ $jejum->objetivo == 'Emagrecimento' ? 'selected' : '' }}>Emagrecimento</option>
                        <option value="Melhora de saúde" {{ $jejum->objetivo == 'Melhora de saúde' ? 'selected' : '' }}>Melhora de saúde</option>
                        <option value="Aumento de energia" {{ $jejum->objetivo == 'Aumento de energia' ? 'selected' : '' }}>Aumento de energia</option>
                        <option value="Desintoxicação" {{ $jejum->objetivo == 'Desintoxicação' ? 'selected' : '' }}>Desintoxicação</option>
                        <option value="Longevidade" {{ $jejum->objetivo == 'Longevidade' ? 'selected' : '' }}>Longevidade</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Card Informações do Usuário -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white fw-semibold">
                Informações Pessoais
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="peso_atual" class="form-label">Peso Atual (kg)</label>
                    <input type="number" step="0.1" name="peso_atual" class="form-control" value="{{ $jejum->peso_atual ?? '' }}">
                </div>

                <div class="mb-3">
                    <label for="peso_meta" class="form-label">Meta de Peso (kg)</label>
                    <input type="number" step="0.1" name="peso_meta" class="form-control" value="{{ $jejum->peso_meta }}" required>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="jejum_previamente_feito" class="form-check-input" value="1" id="jejum_previamente_feito" {{ $jejum->jejum_previamente_feito ? 'checked' : '' }}>
                    <label class="form-check-label" for="jejum_previamente_feito">Já praticou jejum anteriormente?</label>
                </div>

                <div class="mb-3">
                    <label for="doenca_cronica" class="form-label">Possui alguma doença crônica?</label>
                    <select name="doenca_cronica" class="form-control" id="doenca-cronica" required>
                        <option value="0" {{ $jejum->doenca_cronica == 0 ? 'selected' : '' }}>Não</option>
                        <option value="1" {{ $jejum->doenca_cronica == 1 ? 'selected' : '' }}>Sim</option>
                    </select>
                </div>

                <div class="mb-3" id="doenca-lista" style="{{ $jejum->doenca_cronica == 1 ? 'display: block;' : 'display: none;' }}">
                    <label for="descricao_doenca" class="form-label">Selecione a doença</label>
                    <select name="descricao_doenca" class="form-select" id="descricao-doenca">
                        <option value="Nenhuma" {{ $jejum->descricao_doenca == 'Nenhuma' ? 'selected' : '' }}>Nenhuma das anteriores</option>
                        <option value="Hipertensão" {{ $jejum->descricao_doenca == 'Hipertensão' ? 'selected' : '' }}>Hipertensão</option>
                        <option value="Diabetes" {{ $jejum->descricao_doenca == 'Diabetes' ? 'selected' : '' }}>Diabetes</option>
                        <option value="Asma" {{ $jejum->descricao_doenca == 'Asma' ? 'selected' : '' }}>Asma</option>
                        <option value="Doença cardiovascular" {{ $jejum->descricao_doenca == 'Doença cardiovascular' ? 'selected' : '' }}>Doença cardiovascular</option>
                        <option value="Artrite" {{ $jejum->descricao_doenca == 'Artrite' ? 'selected' : '' }}>Artrite</option>
                        <option value="Obesidade" {{ $jejum->descricao_doenca == 'Obesidade' ? 'selected' : '' }}>Obesidade</option>
                        <option value="Outras" {{ $jejum->descricao_doenca == 'Outras' ? 'selected' : '' }}>Outras</option>
                    </select>
                </div>

                <div class="mb-3" id="descricao-outro" style="{{ $jejum->descricao_doenca == 'Outras' ? 'display: block;' : 'display: none;' }}">
                    <label for="outra_doenca" class="form-label">Qual?</label>
                    <input type="text" name="outra_doenca" class="form-control" value="{{ $jejum->outra_doenca }}">
                </div>
            </div>
        </div>

        <!-- Observações -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white fw-semibold">
                Observações adicionais
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <textarea name="observacoes" class="form-control" rows="3" placeholder="Anotações, restrições alimentares, etc.">{{ $jejum->observacoes }}</textarea>
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary px-4 m-1">
                <i class="fas fa-check me-2"></i>Salvar Alterações
            </button>
            <a href="{{ route('jejum.index') }}" class="btn btn-outline-secondary px-4 m-1">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const doencaCronicaSelect = document.getElementById('doenca-cronica');
        const doencaListaDiv = document.getElementById('doenca-lista');
        const descricaoDoencaSelect = document.getElementById('descricao-doenca');
        const descricaoOutroDiv = document.getElementById('descricao-outro');

        doencaCronicaSelect.addEventListener('change', function () {
            doencaListaDiv.style.display = this.value === '1' ? 'block' : 'none';
        });

        descricaoDoencaSelect.addEventListener('change', function () {
            descricaoOutroDiv.style.display = this.value === 'Outras' ? 'block' : 'none';
        });
    });
</script>

@endsection
