<header>
    <nav class="container-fluid iribarren-wine-gradient">
        <div class="nav-wrapper">
            <a href="{{ url('/') }}" class="brand-logo font-audiowide">SEMAT</a>
            {{-- Sidenav Trigger --}}
            <a href="#" data-target="sidenav-menu" class="sidenav-trigger"><i class="icon-menu"></i></a>
            {{-- Authenticacion links --}}
            <ul id="nav-movile" class="right hide-on-med-and-down">
                {{-- User dropdown trigger --}}
                <li>
                    <a href="#" class="dropdown-trigger avatar-trigger" data-target="user-dropdown">
                        <i class="icon-more_vert"></i>
                        {{-- <img src="" alt="" class="avatar"> --}}
                    </a>
                </li>
                {{-- Dropdown menu structure --}}
                <ul class="dropdown-content" id="user-dropdown">
                    <!-- <li><a href=""><i class="icon-account_box"></i>Cuenta</a></li> -->
                    <!-- <li><a href=""><i class="icon-settings"></i>Configuración</a></li> -->
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="icon-exit_to_app"></i>
                            Cerrar Sesión
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </ul>
        </div>
        <ul id="sidenav-menu" class="sidenav sidenav-fixed">
            <li>
                <a href="" class="logo-container font-audiowide center-align">
                    <img src="{{ asset('images/semat.png') }}" alt="" srcset="">                    
                </a>
            </li>
            @php 
                $name = strtolower(Auth::user()->name);
                $surname = strtolower(Auth::user()->surname);
            @endphp 
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="{{ asset('images/bg-user.jpg') }}" class="responsive-img">
                    </div>
                    @if (Storage::disk('users')->has(Auth::user()->image))
                    <a href="#user"><img class="circle hide-on-large-only" src="{{ route('users.getImage', ['filename' => Auth::user()->image]) }}"></a>
                    @else 
                    <a href="#user"><img class="circle hide-on-large-only" src="{{ asset('images/user.png') }}"></a>
                    @endif
                    <a href="!#"><span class="white-text name">Bienvenido, </span></a>
                    <a href="#email"><span class="white-text email"style="font-weight: 800">
                        {{ ucwords($name) . " " . ucwords($surname) }}
                        </span>
                    </a>
                </div>
            </li>
            <li class="waves-efect waves-light"><a href="{{ route('profile') }}"><i class="icon-account_circle left"></i>Mi Cuenta</a></li>
            <li class="divider"></li>
            <li class="waves-efect waves-light hide-on-large-only"><a href="{{ route('home') }}" class="waves-effect waves-black"><i class="icon-home left"></i>Inicio</a></li>
            <li class="divider hide-on-large-only"></li>
            <li class="waves-efect waves-light hide-on-large-only">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-sidenav-form').submit();">
                    <i class="icon-exit_to_app"></i>
                    {{ __('Desconectar') }}
                </a>
            </li>
            <form id="logout-sidenav-form" action="{{ route('logout') }}" method="post" style="display: none;">
                @csrf
            </form>
            <!-- <li><a href="#!" class="subheader"><i class="icon-dashboard left"></i>Opciones:</a></li>      -->
            <li>
                <a href="#" class="waves-effect waves-blue hide-on-med-and-down show-on-large-only" id="company-solvent">
                    <i class="far fa-calendar-check left"></i>
                    Pagos Verificados
                </a>
            </li>
            <li>
                <a href="#" id='company-process' class="waves-effect waves-blue hide-on-med-and-down show-on-large-only">
                    <i class="fa fa-money-check left"></i>
                    Pagos en Proceso
                </a>
            </li>
            <li>
                <a href="#" id='company-registered' class="waves-effect waves-blue hide-on-med-and-down show-on-large-only">
                    <i class="fas fa-map-marked left"></i>
                    Empresas Registradas
                </a>
            </li>
            <li>
                <a href="#" id='company-process-verified' class="waves-effect waves-blue hide-on-med-and-down show-on-large-only">
                    <i class="fas fa-map-marked-alt left"></i>
                    Relación Actual
                </a>
            </li>
            <li>
                <a href="{{ route('home') }}" class="waves-effect waves-blue hide-on-med-and-down show-on-large-only">
                <i class="icon-arrow_back left"></i>
                    Volver a SEMAT
                </a>
            </li>
        </ul>
    </nav>
</header>