@extends('layouts.app')

@section('styles')
    {{--<link rel="stylesheet" href="{{ asset('css/countdown-timer.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/subtle-slideshow.css') }}">--}}
    <style type="text/css">
        body {
            
            background-repeat: no-repeat !important;
            background-size: cover !important;
            height: 100% !important;
        }

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
        <div id="slides">
          <div class="slide">
            <span class="animate down" style="background-image: url({{ asset('images/bqto-1.webp') }})"></span>
          </div>
          <div class="slide">
            <span class="animate in" style="background-image: url({{ asset('images/bqto-4.webp') }})"></span>
          </div>
          <div class="slide">
            <span class="animate down" style="background-image: url({{ asset('images/bqto-2.webp') }})"></span>
          </div>
          <div class="slide">
            <span class="animate out" style="background-image: url({{ asset('images/bqto-3.webp') }})"></span>
          </div>
        </div>
        <div class="row show-on-medium-and-down hide-on-large-only">
            <div class="col s12 m6 offset-m3 animated bounceInDown">
                @if(session('notification'))
                <div class="alert alert-success" style="margin-top: 1.5rem">
                    <span>{{ session('notification') }}</span>
                </div>
                @endif
                <article class="message bg-opacity-8" style="margin-top: 1.5rem">
                    <div class="message-body">
                        <span><b>Bienvenido(a) Contribuyente</b> al nuevo <b>Sistema para la Recaudación de Impuestos Municipales del SEMAT (SysPRIM)</b>. Por favor, Inicia Sesión ó <a href="{{ route('register') }}" style="color:#126887;font-weight: 900; text-decoration: underline;">Regístrate aquí</a> para comenzar a contribuir. Y Recuerda: <b>¡No deber es tu deber!</b><br>
                            <!-- <b>Nota:</b> Por el momento, solo se realizan <b>pagos de Actividad Económica</b>. El equipo de desarrollo esta trabajando para usted.  -->
                        </span>
                    </div>
                </article>
                <form action="{{ route('login') }}" method="post" class="card bg-light-opacity-8">
                    <div class="card-header center-align">
                        <h5>
                            <img src="{{ asset('images/semat.webp') }}" class="responsive-img" alt="Logo semat" width="100%" height="100%" srcset="">
                            
                        </h5>
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
                                {{ __('Ingresar') }}
                        </button>
                    </div>
                    <div class="card-footer center-align">
                        @if (Route::has('password.request'))
                            <a class="iribarren-wine-text" href="{{ route('password.request') }}">{{ __('¿Olvidaste tu contraseña?') }}</a>
                        @endif
                    </div>
                    <div class="card-footer center-align">
                        {{-- <a href="{{ route('register') }}" class="btn iribarren-wine waves-effect waves-light white-text pulse">¿No estás registrado? Registrate aquí.</a> --}}
                        <a class="iribarren-wine-text" href="{{ route('register') }}">¿No estás registrado? Registrate aquí.</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col s12 hide-on-med-and-down animated bounceInDown"  style="padding-top: 1.5rem">
                <article class="message bg-opacity-8">

                    <div class="message-body">
                        <div class="row" style="margin-bottom: 0">
                            <div class="col s1">
                                <i class="icon-info medium"></i>
                            </div>
                            <div class="col s10">
                                <span><b>Bienvenido(a) Contribuyente</b> al nuevo <b>Sistema para la Recaudación de Impuestos Municipales del SEMAT (SysPRIM)</b>. Por favor, Inicia Sesión ó <a href="{{ route('register') }}" style="color:#126887;font-weight: 900; text-decoration: underline;">Regístrate aquí</a> para comenzar a contribuir. Y Recuerda: <b>¡No deber es tu deber!</b><br>
                                    <!-- <b>Nota:</b> Por el momento, solo se realizan <b>pagos de Actividad Económica</b>. El equipo de desarrollo esta trabajando para usted.  --></span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/countdown-timer.js') }}"></script>
    <script src="{{ asset('js/jquery.subtle-slideshow.js') }}"></script>
    <script>
        $('.sidenav#side-login').sidenav({
            edge:'right',
        });

        $('#slides').slideshow({
            randomize: false,      // Randomize the play order of the slides.
            slideDuration: 6000,  // Duration of each induvidual slide.
            fadeDuration: 1000,    // Duration of the fading transition. Should be shorter than slideDuration.
            animate: true,        // Turn css animations on or off.
            pauseOnTabBlur: true, // Pause the slideshow when the tab is out of focus. This prevents glitches with setTimeout().
            enableLog: false      // Enable log messages to the console. Useful for debugging.
          });

    </script>
@endsection