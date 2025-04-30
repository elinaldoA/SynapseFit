@extends('layouts.admin')

@section('main-content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold"><i class="fas fa-stopwatch me-2"></i> Configurar Jejum Intermitente</h1>

    <form method="POST" action="{{ route('jejum.store') }}">
        @csrf

        <!-- Card Jejum -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-semibold">
                Dados do Jejum
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="protocolo" class="form-label">Protocolo de Jejum</label>
                    <select name="protocolo" class="form-control" required>
                        <option value="">Selecione um protocolo</option>
                        @foreach (['16:8' => '16h de jejum, 8h de alimentação',
                                '18:6' => '18h de jejum, 6h de alimentação',
                                '20:4' => '20h de jejum, 4h de alimentação',
                                'OMAD' => '1 refeição por dia (jejum de 23h)'] as $value)
                            <option value="{{ $value }}" {{ old('protocolo') == $value ? 'selected' : '' }}>
                                {{ $value == '24:0' ? 'OMAD (24h)' : $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="duracao_jejum" class="form-label">Duração do Jejum</label>
                    <select name="duracao_jejum" class="form-control" required>
                        <option value="">Selecione a duração</option>
                        @foreach (['12' => '12 horas', '14' => '14 horas', '16' => '16 horas', '18' => '18 horas', '24' => '24 horas (OMAD)'] as $key => $label)
                            <option value="{{ $key }}" {{ old('duracao_jejum') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="inicio" class="form-label">Hora de Início</label>
                    <input type="time" name="inicio" class="form-control" value="{{ old('inicio') }}" required>
                </div>

                <div class="mb-3">
                    <label for="objetivo" class="form-label">Objetivo com o Jejum</label>
                    <select name="objetivo" class="form-control" required>
                        <option value="">Selecione um objetivo</option>
                        @foreach (['Emagrecimento', 'Melhora de saúde', 'Aumento de energia', 'Desintoxicação', 'Longevidade'] as $obj)
                            <option value="{{ $obj }}" {{ old('objetivo') == $obj ? 'selected' : '' }}>
                                {{ $obj }}
                            </option>
                        @endforeach
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
                    <input type="number" step="0.1" name="peso_atual" class="form-control" value="{{ old('peso_atual', Auth::user()->weight ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="peso_meta" class="form-label">Meta de Peso (kg)</label>
                    <input type="number" step="0.1" name="peso_meta" class="form-control" value="{{ old('peso_meta') }}" required>
                </div>

                <div class="form-check mb-3">
                    <input type="hidden" name="jejum_previamente_feito" value="0">
                    <input type="checkbox" name="jejum_previamente_feito" class="form-check-input" value="1" id="jejum_previamente_feito" {{ old('jejum_previamente_feito') ? 'checked' : '' }}>
                    <label class="form-check-label" for="jejum_previamente_feito">Já praticou jejum anteriormente?</label>
                </div>

                <div class="mb-3">
                    <label for="doenca_cronica" class="form-label">Possui alguma doença crônica?</label>
                    <select name="doenca_cronica" class="form-control" id="doenca-cronica" required>
                        <option value="0" {{ old('doenca_cronica') == '0' ? 'selected' : '' }}>Não</option>
                        <option value="1" {{ old('doenca_cronica') == '1' ? 'selected' : '' }}>Sim</option>
                    </select>
                </div>

                <div class="mb-3" id="doenca-lista" style="{{ old('doenca_cronica') == '1' ? '' : 'display:none;' }}">
                    <label for="descricao_doenca" class="form-label">Selecione a doença</label>
                    <select name="descricao_doenca" class="form-select" id="descricao-doenca">
                        @foreach (['Nenhuma', 'Hipertensão', 'Diabetes', 'Asma', 'Doença cardiovascular', 'Artrite', 'Obesidade', 'Outras'] as $d)
                            <option value="{{ $d }}" {{ old('descricao_doenca') == $d ? 'selected' : '' }}>
                                {{ $d }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="descricao-outro" style="{{ old('descricao_doenca') == 'Outras' ? '' : 'display:none;' }}">
                    <label for="outra_doenca" class="form-label">Qual?</label>
                    <input type="text" name="outra_doenca" class="form-control" value="{{ old('outra_doenca') }}">
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
                    <textarea name="observacoes" class="form-control" rows="3" placeholder="Anotações, restrições alimentares, etc.">{{ old('observacoes') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary px-4 m-1">
                <i class="fas fa-check me-2"></i></button>
            <a href="{{ route('jejum.index') }}" class="btn btn-outline-secondary px-4 m-1"><i class="fa fa-angle-left"></i></a>
        </div>
    </form>
</div>

<!-- Script de interações -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const doencaCronicaSelect = document.getElementById('doenca-cronica');
        const doencaListaDiv = document.getElementById('doenca-lista');
        const descricaoDoencaSelect = document.getElementById('descricao-doenca');
        const descricaoOutroDiv = document.getElementById('descricao-outro');

        function toggleDoenca() {
            doencaListaDiv.style.display = doencaCronicaSelect.value === '1' ? 'block' : 'none';
        }

        function toggleOutraDoenca() {
            descricaoOutroDiv.style.display = descricaoDoencaSelect.value === 'Outras' ? 'block' : 'none';
        }

        doencaCronicaSelect.addEventListener('change', toggleDoenca);
        descricaoDoencaSelect.addEventListener('change', toggleOutraDoenca);

        toggleDoenca();
        toggleOutraDoenca();
    });
</script>
@endsection
