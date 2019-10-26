@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m6 offset-m3 l4 offset-l4 animated bounceInDown">
                @if(session('notification'))
                <div class="alert alert-success" style="margin-top: 1.5rem">
                    <span>{{ session('notification') }}</span>
                </div>
                @endif
                <form action="{{ route('login') }}" method="post" class="card bg-light-opacity-8">
                    <div class="card-header center-align">
                        <h5>{{ __('Iniciar Sesión') }}</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12">
                            <i class="icon-mail_outline prefix"></i>
                            <input type="email" name="email" id="email" class="validate" required>
                            <label for="email">{{ __('E-Mail') }}</label>
                            {{-- <span class="helper-text" data-success="Good" data-error="Wrong"></span> --}}
                            @error('email')
                                <div class="alert alert-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-lock_outline prefix"></i>
                            <input type="password" name="password" id="password" class="validate" minlength="8" required>
                            <label for="password">{{ __('Contraseña') }}</label>
                            {{-- <span class="helper-text" data-success="Good" data-error="Wrong"></span> --}}
                            @error('password')
                                <div class="alert alert-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <label for="remember">
                            <input type="checkbox" name="remember" id="remember" class="filled-in blue" {{ old('remember') ? 'checked' : '' }}>
                            <span>{{ __('Recordarme') }}</span>
                        </label>
                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded iribarren-wine waves-effect waves-light">
                                {{ __('Iniciar Sesión') }}
                        </button>
                    </div>
                    <div class="card-footer center-align">
                        @if (Route::has('password.request'))
                            <a class="iribarren-yellow-text" href="{{ route('password.request') }}">{{ __('¿Olvidaste tu contraseña?') }}</a>
                        @endif
                    </div>
                    <div class="card-footer center-align">
                        <a class="iribarren-yellow-text" href="{{ route('register') }}">¿No estás registrado? Registrate aquí.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection