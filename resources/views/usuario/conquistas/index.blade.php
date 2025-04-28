@extends('layouts.admin')

@section('main-content')
<div class="container py-4">
    <h1 class="text-2xl font-bold mb-4">Minhas Conquistas 🎖️</h1>

    @if($conquistas->isEmpty())
        <p class="text-gray-600">Você ainda não desbloqueou nenhuma conquista.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($conquistas as $conquista)
                <div class="bg-white shadow-lg rounded-2xl p-4 border border-gray-100">
                    <h2 class="text-lg font-semibold text-indigo-600">{{ $conquista->titulo }}</h2>
                    <p class="text-sm text-gray-600">{{ $conquista->descricao }}</p>
                    <p class="text-xs text-gray-400 mt-2">Desbloqueada em {{ $conquista->created_at->format('d/m/Y') }}</p>
                </div><br/>
            @endforeach
        </div>
    @endif
</div>
@endsection
