<header class=" z-depth-1">
    @if (Route::currentRouteName() == "login" || Route::currentRouteName() == "")
    <ul class="sidenav sidenav-fixed hide-on-small-only z-depth-1" id="side-login">
        <li>
            <a href="" class="logo-container font-ubuntu center-align">
                <img src="{{ asset('images/semat.webp') }}" alt="Logo" width="100%" height="100%" srcset="">
            </a>
        </li>
        <div class="row">
            <div class="col s12 animated bounceInDown">
                @if(session('notification'))
                <div class="alert alert-success" style="margin-top: 1rem">
                    <span>{{ session('notification') }}</span>
                </div>
                @endif
                <form action="{{ route('login') }}" method="post" class="" >
                    <div class="row">
                        <div class="col s12 center-align">
                            
                        </div>
                    </div>
                    <div class="row">
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
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>
                            {{ __('Ingresar') }}
                        </button>
                    </div>
                    <div class="card-footer center-align">
                        @if (Route::has('password.request'))
                            <a class="iribarren-wine-text" href="{{ route('password.request') }}">{{ __('¿Olvidaste tu contraseña?') }}
                            </a>
                        @endif
                    </div>
                    <div class="card-footer center-align">
                        <a class="iribarren-wine-text" href="{{ route('register') }}">¿No estás registrado? Registrate aquí.</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="message message-red-semat animated fadeIn">
                    <div class="message-body">
                        <span>Para una mejor experiencia de usuario, recomendamos utilizar los siguientes navegadores:</span><br><br>
                        <span style="font-size: 22px"><i class="fab fa-firefox"></i> Mozilla Firefox 65.0+</span><br>
                        <span style="font-size: 22px"><i class="fab fa-chrome"></i> Google Chrome 62.0+</span><br><br>
                        <span><b>Nota:</b> <b>NO</b> se recomienda usar <i class="fab fa-internet-explorer"></i> <b>Internet Explorer</b> para esta aplicación.</span>
                    </div>
                </div>
                {{--<div class="alert alert-warning animated fadeIn">

                </div>--}}
            </div>
        </div>
        {{-- <div class="row" id="timer">
            <div class="col s12">
                <h4>
                    <a href="{{ route('register') }}" class="black-text text-darken-4"><marquee behavior="" direction="">Registrate en SYSPRIM antes de:</marquee></a>
                </h4>
            </div>
            <div class="col s3" id="days"></div>
            <div class="col s3" id="hours"></div>
            <div class="col s3" id="minutes"></div>
            <div class="col s3" id="seconds"></div>
            <!-- <div class="col s12">
                <div >
                    <div id="days"></div>
                    <div id="hours"></div>
                    <div id="minutes"></div>
                    <div id="seconds"></div>
                </div>
            </div> -->
        </div> --}}
    </ul>
    @endif
</header>