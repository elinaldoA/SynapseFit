@extends('layouts.admin')

@section('main-content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Alimentos Consumidos Hoje</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-left-danger" role="alert">
                <h5 class="font-weight-bold">Erros encontrados:</h5>
                <ul class="pl-4 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Resumo Nutricional</h6>
                <a href="{{ route('alimento_consumidos.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-1"></i> Novo Alimento
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($consumidos as $key => $value)
                        <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-uppercase text-primary mb-1">
                                        {{ ucfirst($key) }}
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $value }} / {{ $metas[$key] ?? '—' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
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
                                <th class="text-center">Ações</th>
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
                                    <td class="text-center">
                                        <a href="{{ route('alimento_consumidos.edit', $alimento->id) }}"
                                            class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('alimento_consumidos.destroy', $alimento->id) }}" method="POST"
                                              class="d-inline-block" onsubmit="return confirm('Excluir este alimento?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($alimentos_consumidos->isEmpty())
                                <tr>
                                    <td colspan="11" class="text-center text-muted">Nenhum alimento registrado hoje.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
