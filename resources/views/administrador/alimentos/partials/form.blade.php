<div class="form-row">
    <div class="form-group col-md-6">
        <label for="nome">Descrição</label>
        <input type="text" name="nome" class="form-control" required
               value="{{ old('nome', $alimento->nome ?? '') }}">
    </div>
    <div class="form-group col-md-6">
        <label for="refeicao">Refeição</label>
        <input type="text" name="refeicao" class="form-control" required
               value="{{ old('refeicao', $alimento->refeicao ?? '') }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="calorias">Calorias</label>
        <input type="number" step="0.01" name="calorias" class="form-control" required
               value="{{ old('calorias', $alimento->calorias ?? '') }}">
    </div>
    <div class="form-group col-md-4">
        <label for="proteinas">Proteínas</label>
        <input type="number" step="0.01" name="proteinas" class="form-control" required
               value="{{ old('proteinas', $alimento->proteinas ?? '') }}">
    </div>
    <div class="form-group col-md-4">
        <label for="carboidratos">Carboidratos</label>
        <input type="number" step="0.01" name="carboidratos" class="form-control" required
               value="{{ old('carboidratos', $alimento->carboidratos ?? '') }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="gorduras">Gorduras</label>
        <input type="number" step="0.01" name="gorduras" class="form-control" required
               value="{{ old('gorduras', $alimento->gorduras ?? '') }}">
    </div>
    <div class="form-group col-md-4">
        <label for="agua">Água (ml)</label>
        <input type="number" step="0.01" name="agua" class="form-control"
               value="{{ old('agua', $alimento->agua ?? '') }}">
    </div>
    <div class="form-group col-md-4">
        <label for="fibras">Fibras</label>
        <input type="number" step="0.01" name="fibras" class="form-control"
               value="{{ old('fibras', $alimento->fibras ?? '') }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="sodio">Sódio</label>
        <input type="number" step="0.01" name="sodio" class="form-control"
               value="{{ old('sodio', $alimento->sodio ?? '') }}">
    </div>
    <div class="form-group col-md-4">
        <label for="porcao">Porção</label>
        <input type="text" name="porcao" class="form-control" required
               value="{{ old('porcao', $alimento->porcao ?? '') }}">
    </div>
</div>
