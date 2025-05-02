@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Treinos</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('treinos.create') }}" class="btn btn-success mb-3">Novo Treino</a>

    <div class="card shadow">
        <div class="card-body">
            <!-- Formulário de busca -->
            <form method="GET" action="{{ route('treinos') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="pesquisar" class="form-control"
                        placeholder="Buscar por usuário, exercício ou tipo..." value="{{ request('pesquisar') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                        @if (request('pesquisar'))
                            <a href="{{ route('treinos') }}" class="btn btn-outline-secondary ml-2">
                                <i class="fa fa-eraser"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Exercício</th>
                        <th>Tipo</th>
                        <th>Séries</th>
                        <th>Repetições</th>
                        <th>Carga (kg)</th>
                        <th>Descanso (s)</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($treinos as $treino)
                        <tr>
                            <td>{{ $treino->user->name }}</td>
                            <td>{{ $treino->exercise->name }}</td>
                            <td>{{ $treino->type }}</td>
                            <td>{{ $treino->series }}</td>
                            <td>{{ $treino->repeticoes }}</td>
                            <td>{{ $treino->carga ?? '-' }}</td>
                            <td>{{ $treino->descanso }}</td>
                            <td>{{ $treino->data_treino ?? '-' }}</td>
                            <td>
                                <a href="{{ route('treinos.edit', $treino) }}" class="btn btn-sm btn-warning"><i
                                        class="fa fa-edit"></i></a>
                                <!-- Botão para abrir o modal -->
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#modalExcluir{{ $treino->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>

                                <!-- Modal individual para esse treino -->
                                <div class="modal fade" id="modalExcluir{{ $treino->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modalExcluirLabel{{ $treino->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('treinos.destroy', $treino) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="modalExcluirLabel{{ $treino->id }}">
                                                        Confirmar Exclusão</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal"
                                                        aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja excluir o treino de
                                                    <strong>{{ $treino->user->name }}</strong>?
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
                            <td colspan="9">Nenhum treino encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $treinos->appends(['pesquisar' => request('pesquisar')])->links() }}
            </div>
        </div>
    </div>
@endsection
