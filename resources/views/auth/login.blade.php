@extends('layouts.app')

@section('styles')
    <style type="text/css">
        header,
        main,
        footer {
          padding-right: 400px !important;
        }

        .sidenav {
            width: 400px !important;
        }

        @media only screen and (max-width: 992px) {
            header,
            main,
            footer {
                padding-right: 0 !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row show-on-down-only hide-on-med-and-up">
            <div class="col s12 m4 offset-m4 animated bounceInDown">
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
                            <input type="email" name="email" id="email_input" class="validate" required>
                            <label for="email_input">{{ __('E-Mail') }}</label>
                            {{-- <span class="helper-text" data-success="Good" data-error="Wrong"></span> --}}
                            @error('email')
                                <div class="alert alert-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-lock_outline prefix"></i>
                            <input type="password" name="password" id="password_input" class="validate" minlength="8" required>
                            <label for="password_input">{{ __('Contraseña') }}</label>
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
                            <input type="checkbox" name="remember" id="remember_check" class="filled-in blue" {{ old('remember') ? 'checked' : '' }}>
                            <span>{{ __('Recordarme') }}</span>
                        </label>
                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                                <i class="icon-send right"></i>
                                {{ __('Iniciar Sesión') }}
                        </button>
                    </div>
                    <div class="card-footer center-align">
                        @if (Route::has('password.request'))
                            <a class="iribarren-wine-text" href="{{ route('password.request') }}">{{ __('¿Olvidaste tu contraseña?') }}</a>
                        @endif
                    </div>
                    <div class="card-footer center-align">
                        <a class="iribarren-wine-text" href="{{ route('register') }}">¿No estás registrado? Registrate aquí.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://kit.fontawesome.com/e3f4029a28.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/jquery.backstretch.min.js') }}"></script>
    <script>
        $.backstretch([
            "images/bg-1.jpg",
            "images/bg-4.jpeg",
            "images/bg-2.jpg",
            "images/bg-3.jpeg"
        ], {duration: 3000, fade: 750});

        $('.sidenav#side-login').sidenav({
            edge:'right',

        });

    </script>
@endsection