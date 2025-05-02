@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Alimentos</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('alimentos.create') }}" class="btn btn-success mb-3">Novo alimento</a>

    <div class="card shadow">
        <div class="card-body">
            <!-- Formulário de busca -->
            <form method="GET" action="{{ route('alimentos') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="pesquisar" class="form-control"
                        placeholder="Buscar por descrição ou refeição..." value="{{ request('pesquisar') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                        @if (request('pesquisar'))
                            <a href="{{ route('alimentos') }}" class="btn btn-outline-secondary ml-2">
                                <i class="fa fa-eraser"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
            <table class="table table-hover text-center">
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
                    @forelse($alimentos as $alimento)
                        <tr>
                            <td>{{ $alimento->nome }}</td>
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
                                <a href="{{ route('alimentos.edit', $alimento) }}" class="btn btn-sm btn-warning"><i
                                        class="fa fa-edit"></i></a>
                                <!-- Botão para abrir o modal -->
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#modalExcluir{{ $alimento->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>

                                <!-- Modal individual para esse alimento -->
                                <div class="modal fade" id="modalExcluir{{ $alimento->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modalExcluirLabel{{ $alimento->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('alimentos.destroy', $alimento) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="modalExcluirLabel{{ $alimento->id }}">
                                                        Confirmar Exclusão</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal"
                                                        aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja excluir o alimento de
                                                    <strong>{{ $alimento->nome }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal"><i class="fas fa-angle-left"></i></button>
                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">Nenhum alimento encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $alimentos->appends(['pesquisar' => request('pesquisar')])->links() }}
            </div>
        </div>
    </div>
@endsection
