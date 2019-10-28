<header>
    <nav class="container-fluid iribarren-wine-gradient">
        <div class="nav-wrapper container">
            <a href="{{ url('/') }}" class="brand-logo left font-audiowide">
                <!-- <img src="{{ asset('images/alcaldia_logo.png') }}" alt=""> -->
                Iribarren
            </a>
            {{-- Sidenav Trigger --}}
            <a href="#" class="brand-logo right font-audiowide">
                <!-- <img src="{{ asset('images/semat_logo.png') }}" alt=""> -->
                SEMAT
            </a>
        </div>
    </nav>
    @if (Route::currentRouteName() == "login" || Route::currentRouteName() == "")
    <ul class="sidenav sidenav-fixed hide-on-small-only valign-wrapper z-depth-1" id="side-login">
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
                            <h5>{{ __('Iniciar Sesión') }}</h5>
                            
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
    </ul>
    @endif
</header>