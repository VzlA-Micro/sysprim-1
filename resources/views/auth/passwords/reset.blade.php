@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <form method="POST" action="{{ route('password.update') }}" class="card">
                    <div class="card-header center-align">
                        <h5>Resetear Contraseña</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="input-field col s12">
                            <label for="email">{{ __('E-Mail') }}</label>
                            <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}" required>
                        </div>
                        <div class="input-field col s12">
                            <input id="password" type="password" name="password" required>
                            <label for="password">{{ __('Contraseña') }}</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="password-confirm" type="password" name="password_confirmation" required>
                            <label for="password-confirm">{{ __('Confirmar Contraseña') }}</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-outline-success waves-effect waves-green">
                            <i class="icon-send right"></i>
                            {{ __('Resetear Contraseña') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection