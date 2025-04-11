@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('usuarios') }}</h1>

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

    <div class="card mt-3 mb-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Pesquisar</span>
        </div>

        <div class="card-body">
            <form action="{{ route('usuarios') }}">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <label class="form-label" for="name">Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="form-control" value="{{ request('descricao') }}"
                        placeholder="Descricao do usuario" />
                    </div>
                    <div class="col-md-3 col-sm-12 mt-3 pt-4">
                        <button type="submit" class="btn btn-info btn-sm">Pesquisar</button>
                        <a href="{{ route('usuarios') }}" class="btn btn-warning btn-sm">Limpar</a>
                    </div>
                </div>
            </form>
            <br/>
            <div class="card-header d-flex justify-content-between">
                <span>Todos</span>
                <span>
                    <a href="{{ route('usuarios.create') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                </span>
            </div>
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Sexo</th>
                        <th>Idade</th>
                        <th>Objetivo</th>
                        <th>Assinatura</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->name }} {{ $usuario->last_name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ ucfirst($usuario->sex) }}</td>
                        <td>{{ $usuario->age }}</td>
                        <td>{{ ucfirst($usuario->objetivo) }}</td>
                        <td>
                            @php
                                $assinatura = $usuario->subscriptions->sortByDesc('end_date')->first();
                            @endphp

                            @if ($assinatura)
                                @php
                                    $badgeClass = $assinatura->payment_status === 'pendente' ? 'warning' : 'success';
                                    $statusTexto = $assinatura->payment_status === 'pendente' ? 'Pendente' : 'Pago';
                                @endphp

                                <span class="badge badge-{{ $badgeClass }}">
                                    {{ $assinatura->plan->name ?? 'Plano removido' }}<br>
                                    {{ $assinatura->start_date->format('d/m/Y') }} até
                                    {{ $assinatura->end_date->format('d/m/Y') }}<br>
                                    <strong>Status:</strong> {{ $assinatura->is_active ? 'Ativa' : 'Inativa' }}<br>
                                    <strong>Pagamento:</strong> {{ $statusTexto }}
                                </span>
                            @else
                                <span class="badge badge-danger">Sem assinatura</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $usuarios->links() }}
        </div>
    </div>
@endsection
