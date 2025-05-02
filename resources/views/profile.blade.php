@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Perfil') }}</h1>

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

    <div class="row">

        <div class="col-lg-4 order-lg-2">

            <div class="card shadow mb-4">
                <div class="card-profile-image mt-4">
                    <figure class="rounded-circle avatar avatar font-weight-bold" style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->name[0] }}"></figure>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h5 class="font-weight-bold">{{  Auth::user()->fullName }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-8 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Minha conta</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('profile.update') }}" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <h6 class="heading-small text-muted mb-4">Informações do usuário</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Nome<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Nome" value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="last_name">Sobrenome</label>
                                        <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Sobrenome" value="{{ old('last_name', Auth::user()->last_name) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="height">Altura (cm)</label>
                                        <input type="number" id="height" class="form-control" name="height" placeholder="Altura" value="{{ old('height', Auth::user()->height) }}" step="0.01" min="0">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="weight">Peso (kg)</label>
                                        <input type="number" id="weight" class="form-control" name="weight" placeholder="Peso" value="{{ old('weight', Auth::user()->weight) }}" step="0.1" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="sex">Sexo</label>
                                        <select name="sex" id="sex" class="form-control">
                                            <option value="male" {{ old('sex', Auth::user()->sex) == 'male' ? 'selected' : '' }}>Masculino</option>
                                            <option value="female" {{ old('sex', Auth::user()->sex) == 'female' ? 'selected' : '' }}>Feminino</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="age">Idade</label>
                                        <input type="number" id="age" class="form-control" name="age" placeholder="Idade" value="{{ old('age', Auth::user()->age) }}" min="18">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="objetivo">Objetivo</label>
                                        <select name="objetivo" id="objetivo" class="form-control">
                                            <option value="hipertrofia" {{ old('objetivo', Auth::user()->objetivo) == 'hipertrofia' ? 'selected' : '' }}>Hipertrofia</option>
                                            <option value="emagrecimento" {{ old('objetivo', Auth::user()->objetivo) == 'emagrecimento' ? 'selected' : '' }}>Emagrecimento</option>
                                            <option value="resistencia" {{ old('objetivo', Auth::user()->objetivo) == 'resistencia' ? 'selected' : '' }}>Resistência</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="current_password">Senha atual</label>
                                        <input type="password" id="current_password" class="form-control" name="current_password" placeholder="Senha atual">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Nova senha</label>
                                        <input type="password" id="new_password" class="form-control" name="new_password" placeholder="Nova senha">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="confirm_password">Confirme sua senha</label>
                                        <input type="password" id="confirm_password" class="form-control" name="password_confirmation" placeholder="Confirme sua senha">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
