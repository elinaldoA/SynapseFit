<div class="form-group">
    <label for="name">Nome</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $exercise->name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="category">Categoria</label>
    <select name="category" class="form-control" required>
        <option value="">Selecione</option>
        <option value="Hipertrofia" {{ old('category', $exercise->category ?? '') == 'Hipertrofia' ? 'selected' : '' }}>Hipertrofia</option>
        <option value="Emagrecimento" {{ old('category', $exercise->category ?? '') == 'Emagrecimento' ? 'selected' : '' }}>Emagrecimento</option>
        <option value="Resistência" {{ old('category', $exercise->category ?? '') == 'Resistência' ? 'selected' : '' }}>Resistência</option>
    </select>
</div>

<div class="form-group">
    <label for="muscle_group">Grupo Muscular</label>
    <select name="muscle_group" class="form-control" required>
        <option value="">Selecione</option>
        <option value="Peito" {{ old('muscle_group', $exercise->muscle_group ?? '') == 'Peito' ? 'selected' : '' }}>Peito</option>
        <option value="Costas" {{ old('muscle_group', $exercise->muscle_group ?? '') == 'Costas' ? 'selected' : '' }}>Costas</option>
        <option value="Ombros" {{ old('muscle_group', $exercise->muscle_group ?? '') == 'Ombros' ? 'selected' : '' }}>Ombros</option>
        <option value="Bíceps" {{ old('muscle_group', $exercise->muscle_group ?? '') == 'Bíceps' ? 'selected' : '' }}>Bíceps</option>
        <option value="Tríceps" {{ old('muscle_group', $exercise->muscle_group ?? '') == 'Tríceps' ? 'selected' : '' }}>Tríceps</option>
        <option value="Core" {{ old('muscle_group', $exercise->muscle_group ?? '') == 'Core' ? 'selected' : '' }}>Abdomên</option>
        <option value="Pernas" {{ old('muscle_group', $exercise->muscle_group ?? '') == 'Pernas' ? 'selected' : '' }}>Pernas</option>
        <option value="Glúteos" {{ old('muscle_group', $exercise->muscle_group ?? '') == 'Glúteos' ? 'selected' : '' }}>Glúteos</option>
    </select>
</div>

<div class="form-group">
    <label for="level">Nível</label>
    <select name="level" class="form-control" required>
        <option value="">Selecione</option>
        <option value="Iniciante" {{ old('level', $exercise->level ?? '') == 'Iniciante' ? 'selected' : '' }}>Iniciante</option>
        <option value="Intermediário" {{ old('level', $exercise->level ?? '') == 'Intermediário' ? 'selected' : '' }}>Intermediário</option>
        <option value="Avançado" {{ old('level', $exercise->level ?? '') == 'Avançado' ? 'selected' : '' }}>Avançado</option>
    </select>
</div>

<div class="form-group">
    <label for="video_url">Link do Vídeo (opcional)</label>
    <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $exercise->video_url ?? '') }}">
</div>
