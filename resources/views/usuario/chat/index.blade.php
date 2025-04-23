@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h3>Chat com IA 🤖</h3>

    <div class="card p-3 mb-3" style="height: 400px; overflow-y: auto;">
        @foreach ($messages as $msg)
            <div class="{{ $msg->is_bot ? 'text-end' : 'text-start' }}">
                <div class="p-2 mb-2 {{ $msg->is_bot ? 'bg-light' : 'bg-primary text-white' }} rounded">
                    <small>{{ $msg->is_bot ? 'SynapseBot' : 'Você' }}</small><br>
                    {{ $msg->message }}
                </div>
            </div>
        @endforeach
    </div>

    <form action="{{ route('chat.enviar') }}" method="POST">
        @csrf
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Digite sua pergunta..." required>
            <button class="btn btn-success">Enviar</button>
        </div>
    </form>
</div>
@endsection
