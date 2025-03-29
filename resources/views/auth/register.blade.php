@extends('layouts.auth')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Register') }}</h1>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger border-left-danger" role="alert">
                                        <ul class="pl-4 my-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('register') }}" class="user">
                                    @csrf

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="name" placeholder="{{ __('Nome') }}" value="{{ old('name') }}" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="last_name" placeholder="{{ __('Sobrenome') }}" value="{{ old('last_name') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" placeholder="{{ __('E-Mail') }}" value="{{ old('email') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" placeholder="{{ __('Senha') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password_confirmation" placeholder="{{ __('Confirmar senha') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="number" step="0.01" class="form-control form-control-user" name="weight" placeholder="{{ __('Peso em Kg - ex: 88.00') }}" value="{{ old('weight') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="number" step="0.01" class="form-control form-control-user" name="height" placeholder="{{ __('Altura em M - ex: 1.70') }}" value="{{ old('height') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control" name="sex" required>
                                            <option value="" disabled selected>{{ __('Selecione o Sexo') }}</option>
                                            <option value="male" @if(old('sex') == 'male') selected @endif>{{ __('Masculino') }}</option>
                                            <option value="female" @if(old('sex') == 'female') selected @endif>{{ __('Feminino') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select id="objetivo" class="form-control @error('objetivo') is-invalid @enderror" name="objetivo" required>
                                            <option value="" disabled selected>{{ __('Selecione o Objetivo') }}</option>
                                            <option value="hipertrofia" {{ old('objetivo') == 'hipertrofia' ? 'selected' : '' }}>{{ __('Hipertrofia') }}</option>
                                            <option value="emagrecimento" {{ old('objetivo') == 'emagrecimento' ? 'selected' : '' }}>{{ __('Emagrecimento') }}</option>
                                            <option value="resistencia" {{ old('objetivo') == 'resistencia' ? 'selected' : '' }}>{{ __('Resistência') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user" name="age" placeholder="{{ __('Idade') }}" value="{{ old('age') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </form>

                                <hr>

                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">
                                        {{ __('Already have an account? Login!') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
