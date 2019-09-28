@extends('layouts.app2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m6 offest-m3 l4 offset-l4">
                <form action="" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrarse</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                                <input id="ci" type="text" name="ci" required>
                                <label for="ci">Cedula</label>
                            </div>
                        <div class="input-field col s12 m6">
                            <input id="name" type="text" name="name" required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="surname" type="text" name="surname" required>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="phone" type="text" name="phone" required>
                            <label for="phone">Teléfono</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="type" id="type">
                                <option value="null" disabled selected>Elige un tipo...</option>
                                <option value="natural">Natural</option>
                                <option value="business">Juridica</option>
                              </select>
                              <label for="type">Tipo de Persona</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                            <label for="email">E-mail</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="password" type="password" name="password" required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="password-confirm" type="password" name="password_confirmation" required>
                            <label for="password-confirm">Confirmar contraseña</label>
                        </div>
                    </div>
                    <div class="card-action center">
                        <button type="submit" class="btn green">Registarse</button>
                    </div>
                    <div class="card-footer center-align">
                        <a href="{{ route('login') }}">¿Ya tienes una cuenta? Inicia sesión aquí.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
