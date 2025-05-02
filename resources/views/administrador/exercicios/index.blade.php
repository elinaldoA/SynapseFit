@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Exercícios</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card mt-3 mb-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Pesquisar</span>
        </div>

        <div class="card-body">
            <form action="{{ route('exercicios') }}">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <label class="form-label">Nome do exercício</label>
                        <input type="text" name="nome" class="form-control" value="{{ request('nome') }}"
                            placeholder="Nome">
                    </div>
                    <div class="col-md-3 col-sm-12 mt-3 pt-4">
                        <button type="submit" class="btn btn-info btn-sm">Pesquisar</button>
                        <a href="{{ route('exercicios') }}" class="btn btn-warning btn-sm">Limpar</a>
                    </div>
                </div>
            </form>
            <br />

            <div class="card-header d-flex justify-content-between">
                <span>Todos os Exercícios</span>
                <a href="{{ route('exercicios.create') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
            </div>

            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Grupo Muscular</th>
                        <th>Nível</th>
                        <th>Orientação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exercises as $exercise)
                        <tr>
                            <td>{{ $exercise->name }}</td>
                            <td>{{ $exercise->muscle_group }}</td>
                            <td>{{ $exercise->level }}</td>
                            <td>
                                @if ($exercise->video_url)
                                    @if (Str::contains($exercise->video_url, 'youtube.com') || Str::contains($exercise->video_url, 'youtu.be'))
                                        @php
                                            // Extrair ID do vídeo do YouTube
                                            preg_match(
                                                '/(?:youtube\.com\/.*v=|youtu\.be\/)([a-zA-Z0-9_-]+)/',
                                                $exercise->video_url,
                                                $matches,
                                            );
                                            $videoId = $matches[1] ?? null;
                                        @endphp
                                        @if ($videoId)
                                            <iframe width="200" height="113"
                                                src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0"
                                                allowfullscreen></iframe>
                                        @else
                                            <a href="{{ $exercise->video_url }}" target="_blank"
                                                class="btn btn-sm btn-info">Assistir</a>
                                        @endif
                                    @else
                                        <a href="{{ $exercise->video_url }}" target="_blank"
                                            class="btn btn-sm btn-info">Assistir</a>
                                    @endif
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('exercicios.edit', $exercise) }}"
                                    class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                <!-- Botão para abrir o modal -->
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#modalExcluirExercicio{{ $exercise->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>

                                <!-- Modal de confirmação -->
                                <div class="modal fade" id="modalExcluirExercicio{{ $exercise->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="modalExcluirExercicioLabel{{ $exercise->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('exercicios.destroy', $exercise) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"
                                                        id="modalExcluirExercicioLabel{{ $exercise->id }}">Confirmar
                                                        Exclusão</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal"
                                                        aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja excluir o exercício
                                                    <strong>{{ $exercise->name }}</strong>?
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
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $exercises->links() }}
            </div>
        </div>
    </div>
@endsection
