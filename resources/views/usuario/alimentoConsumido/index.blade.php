@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <h2>Alimentos Consumidos Hoje</h2>

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

        <div class="card shadow">
            <div class="card-body">
                <a href="{{ route('alimento_consumidos.create') }}" class="btn btn-primary mb-3">Adicionar Alimento</a>

                <div class="row">
                    @foreach ($consumidos as $key => $value)
                        <div class="col-md-3 mb-3">
                            <div class="card p-3">
                                <strong>{{ ucfirst($key) }}:</strong> {{ $value }} / {{ $metas[$key] ?? '—' }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Refeição</th>
                            <th>Calorias</th>
                            <th>Proteínas</th>
                            <th>Carboidratos</th>
                            <th>Gorduras</th>
                            <th>Água</th>
                            <th>Fibras</th>
                            <th>Sódio</th>
                            <th>Porção</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alimentos_consumidos as $alimento)
                            <tr>
                                <td>{{ $alimento->descricao }}</td>
                                <td>{{ ucfirst($alimento->refeicao) }}</td>
                                <td>{{ $alimento->calorias }}</td>
                                <td>{{ $alimento->proteinas }}</td>
                                <td>{{ $alimento->carboidratos }}</td>
                                <td>{{ $alimento->gorduras }}</td>
                                <td>{{ $alimento->agua }}</td>
                                <td>{{ $alimento->fibras }}</td>
                                <td>{{ $alimento->sodio }}</td>
                                <td>{{ $alimento->porcao }}</td>
                                <td>
                                    <a href="{{ route('alimento_consumidos.edit', $alimento->id) }}"
                                        class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('alimento_consumidos.destroy', $alimento->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Excluir este alimento?')"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
