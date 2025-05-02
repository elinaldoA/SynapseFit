@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <h1>Alimento Consumido</h1>

        @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-left-danger" role="alert">
                <ul class="pl-4 my-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card mb-4 border-light shadow">
            <div class="card-header">Editar Registro</div>
            <div class="card-body">
                <form action="{{ route('alimento_consumidos.update', $AlimentoConsumido->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-2">
                        <label for="descricao">Nome do Alimento</label>
                        <input list="alimentos" name="descricao" id="descricao" class="form-control" required
                            value="{{ old('descricao', $AlimentoConsumido->descricao) }}">
                        <datalist id="alimentos">
                            @foreach ($alimentos as $alimento)
                                <option value="{{ $alimento->nome }}">
                            @endforeach
                        </datalist>
                    </div>

                    <div class="form-row">
                        @foreach (['calorias', 'proteinas', 'carboidratos', 'gorduras', 'agua', 'fibras', 'sodio','porcao'] as $field)
                            <div class="form-group col-md-4">
                                <label for="{{ $field }}">{{ ucfirst($field) }}</label>
                                <input type="text" name="{{ $field }}" id="{{ $field }}"
                                    class="form-control" value="{{ old($field, $AlimentoConsumido->$field) }}">
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="refeicao">Refeição</label>
                        <select name="refeicao" id="refeicao" class="form-control" required>
                            <option value="">Selecione</option>
                            @foreach (['café', 'almoço', 'lanche', 'jantar'] as $ref)
                                <option value="{{ $ref }}"
                                    {{ old('refeicao', $AlimentoConsumido->refeicao) == $ref ? 'selected' : '' }}>
                                    {{ ucfirst($ref) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="data">Data</label>
                        <input type="date" name="data" id="data" class="form-control"
                            value="{{ old('data', \Carbon\Carbon::parse($AlimentoConsumido->data)->toDateString()) }}"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i></button>
                    <a href="{{ route('alimento_consumidos')}}" class="btn btn-info"><i class="fas fa-angle-left"></i></a>
                </form>
            </div>
        </div>
    </div>

    <script>
        const alimentos = @json($alimentos->pluck('nome', 'nome')->toArray());
        const dados = @json($alimentos->keyBy('nome'));

        document.getElementById('descricao').addEventListener('input', function() {
            const nome = this.value;
            if (dados[nome]) {
                document.getElementById('calorias').value = dados[nome].calorias;
                document.getElementById('proteinas').value = dados[nome].proteinas;
                document.getElementById('carboidratos').value = dados[nome].carboidratos;
                document.getElementById('gorduras').value = dados[nome].gorduras;
                document.getElementById('agua').value = dados[nome].agua;
                document.getElementById('fibras').value = dados[nome].fibras;
                document.getElementById('sodio').value = dados[nome].sodio;
                document.getElementById('porcao').value = dados[nome].porcao;
                document.getElementById('refeicao').value = dados[nome].refeicao;
            }
        });
    </script>
@endsection
