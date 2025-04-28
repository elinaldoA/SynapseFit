@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Assinaturas dos Usuários</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Plano</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Início</th>
                        <th>Fim</th>
                        <th>Dias Restantes</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assinaturas as $assinatura)
                        <tr>
                            <td>{{ $assinatura->user->name ?? '---' }}</td>
                            <td>{{ $assinatura->plan->name ?? '---' }}</td>
                            <td>{{ $assinatura->tipo }}</td>
                            <td>
                                <span class="badge {{ $assinatura->status === 'Ativa' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $assinatura->status }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($assinatura->start_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($assinatura->end_date)->format('d/m/Y') }}</td>
                            <td>{{ $assinatura->dias_restantes }} dias</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <form action="{{ route('assinaturas.renovar', $assinatura->id) }}" method="POST" onsubmit="return confirm('Deseja renovar esta assinatura?')">
                                        @csrf
                                        <button class="btn btn-sm btn-success" title="Renovar">
                                            <i class="fa fa-sync-alt"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('assinaturas.cancelar', $assinatura->id) }}" method="POST" onsubmit="return confirm('Deseja cancelar esta assinatura?')">
                                        @csrf
                                        <button class="btn btn-sm btn-danger" title="Cancelar">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Nenhuma assinatura encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
                {{ $assinaturas->links() }}
            </div>
        </div>
    </div>
@endsection
