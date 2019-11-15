<header>
    <nav class="container-fluid iribarren-wine-gradient">
        <div class="nav-wrapper">
            <a href="{{ url('/') }}" class="brand-logo font-ubuntu">SEMAT</a>
            {{-- Sidenav Trigger --}}
            <a href="#" data-target="sidenav-menu" class="sidenav-trigger"><i class="icon-menu"></i></a>
            {{-- Authenticacion links --}}
            <ul id="nav-movile" class="right hide-on-med-and-down">
                {{-- Boton de prueba --}}
                <li><a href="{{ route('home') }}" class="tooltipped" data-position="bottom"
                       data-tooltip="{{ __('Inicio') }}"><i class="icon-home"></i></a></li>
                <li>
                    <a href="" class="dropdown-trigger tooltipped" data-position="left" data-tooltip="Notificaciones"
                       data-target="notification-dropdown">
                        <i class="icon-notifications">
                            @if(session()->has('notifications')&& session('notifications')->count()>0)
                                <span class="new badge red" data-badge-caption="nuevo"
                                      style="position: absolute; top: 10px; right: 25px;">{{ session('notifications')->count() }}</span>
                            @endif
                        </i>
                    </a>
                </li>
                {{-- Notification dropdown content --}}
                <div class="dropdown-content collection" id="notification-dropdown">
                    <a class="collection-header center-align">
                        <span class=" center-align grey-text">NOTIFICACIONES</span>
                    </a>

                    @if(session()->has('notifications')&& session('notifications')->count()>0)
                        @foreach(session('notifications') as $notification)
                            <a href="" class="collection-item avatar">
                                <i class="icon-message circle"></i>
                                <p class="collection-title">{{$notification->title}}</p>
                                <p class="collection-subtitle">@php echo $notification->content @endphp </p>
                            </a>
                        @endforeach
                        <a href="{{ route('notifications.read') }}" class="collection-footer center-align">
                            <span>Ver todas las notificaciones</span>
                        </a>
                    @endif
                </div>
                {{-- User dropdown trigger --}}
                <li>
                    <a href="#" class="dropdown-trigger avatar-trigger" data-target="user-dropdown">
                        <i class="icon-more_vert"></i>
                        {{-- <img src="" alt="" class="avatar"> --}}
                    </a>
                </li>
                {{-- Dropdown menu structure --}}
                <ul class="dropdown-content" id="user-dropdown">
                    <li><a href=""><i class="icon-account_box"></i>Cuenta</a></li>
                    <li><a href=""><i class="icon-settings"></i>Configuración</a></li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="icon-exit_to_app"></i>
                            {{ __('Desconectar') }}
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
                    <img src="{{ asset('images/alcaldia_logo.png') }}" alt="" srcset="">                    
                </a>
            </li>
            @guest
                <li><a href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a></li>
                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}">{{ __('Registrarse') }}</a></li>
                @endif
                @else

                    @php 
                        $name = strtolower(Auth::user()->name);
                        $surname = strtolower(Auth::user()->surname);
                    @endphp 
                    <li>
                        <div class="user-view">
                          <div class="background">
                            <img src="{{ asset('images/bg-user.jpg') }}" class="responsive-img">
                          </div>
                          <a href="!#"><span class="white-text name">Bienvenido, </span></a>
                          <a href="#email"><span class="white-text email"style="font-weight: 800">
                            {{ ucwords($name) . " " . ucwords($surname) }}
                            </span>
                          </a>
                        </div>
                    </li>
                    <li class="waves-efect waves-light">
                        <a href="{{ route('profile') }}"><i class="icon-account_circle left"></i>Mi Cuenta</a>
                    </li>
                    <li class="divider"></li>
                    <li class="waves-efect waves-light hide-on-large-only">
                        <a href="{{ route('home') }}"class="waves-effect waves-black"><i class="icon-home left"></i>Inicio</a>
                    </li>
                    <li class="waves-efect waves-light hide-on-large-only"><a href=""><i class="icon-notifications"></i>Notificaciones</a></li>
                    <li class="divider hide-on-large-only"></li>
                    <li><a href="#!" class="subheader"><i class="icon-dashboard left"></i>Opciones:</a></li>
                    {{-- <li class="waves-efect waves-light"><a href=""><i class="icon-group_add left"></i>Gestionar Usuarios</a></li> --}}
                    @if (\Auth::user()->role_id == 1 || Auth::user()->role_id == 4)
                        <li class="waves-efect waves-light"><a href="{{ route('users.manage') }}"><i class="icon-people_outline"></i>Gestionar Usuarios</a></li>
                        <!-- <li class="waves-efect waves-light"><a href="{{ route('companies.manage') }}"><i class="icon-work"></i>Gestionar Empresas</a></li> -->
                        <!-- <li class="waves-efect waves-light"><a href="{{ route('fines.manage') }}"><i class="icon-warning"></i>Gestionar Multas</a></li> -->
                        <li class="waves-efect waves-light"><a href="{{ route('geosysprim') }}"><i class="icon-public"></i>GeoSEMAT</a></li>
                        <li class="waves-efect waves-light"><a href="{{ route('dashboard') }}"><i class="icon-multiline_chart"></i>Estadisticas</a></li>
                        <li class="waves-efect waves-light"><a href="{{ route('payments.verify.manage') }}"><i class="icon-file_upload"></i>Verificación de Pagos</a></li>
                        <li class="no-padding">
                            <ul class="collapsible collapsible-accordion">
                                <li class="bold">
                                    <a href="#!" class="collapsible-header"><i class="icon-settings left" style="margin-left:15px;"></i>Configuración <i class="icon-arrow_drop_down right"></i></a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li class="waves-efect waves-light"><a href="{{ route('ciu.manage') }}"><i class="icon-assignment"></i>Gestionar CIIU</a></li>
                                            <li class="waves-efect waves-light truncate"><a href="{{ route('tax-unit.manage') }}"><i class="icon-assignment"></i>Gestionar Unidad Tributaria</a></li>
                                            
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="no-padding">
                            <ul class="collapsible collapsible-accordion">
                                <li class="bold">
                                    <a href="#!" class="collapsible-header"><i class="icon-personal_video left" style="margin-left:15px;"></i>Taquilla <i class="icon-arrow_drop_down right"></i></a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <!-- <li><a href="{{ route('companies.my-business') }}"><i class="icon-work left"></i>Atencion al Cliente</a></li> -->
                                            <!-- <li><a href=""><i class="icon-person left"></i>Gestionar Contribuyentes</a></li> -->
                                            <li><a href="{{ route('companies.manage') }}"><i class="icon-work left"></i>Gestionar Empresas</a></li>
                                            <li><a href="{{ route('payments.manage') }}"><i class="icon-payment left"></i>Gestionar Pagos</a></li>
                                            <!--<li><a href="{{ route('inmueble.my-property') }}"><i class="icon-location_city left"></i>Gestionar Inmuebles</a></li>-->
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="waves-efect waves-light"><a href="{{ route('security.manage') }}"><i class="icon-security"></i>Seguridad</a></li>
                    @endif
                    @if (\Auth::user()->role_id == 2)
                        <li class="waves-efect waves-light"><a href="{{ route('users.manage') }}"><i class="icon-people_outline"></i>Gestionar Usuarios</a></li>
                        <li class="waves-efect waves-light"><a href="{{ route('companies.manage') }}"><i class="icon-work"></i>Gestionar Empresas</a></li>
                        <li class="waves-efect waves-light"><a href=""><i class="icon-local_shipping"></i>Gestionar Vehículos</a></li>
                        <li class="waves-efect waves-light"><a href="{{ route('payments.manage') }}"><i class="icon-payment"></i>Gestionar Pagos</a></li>
                    @endif
                    @if (\Auth::user()->role_id == 3)
                        <li class="waves-efect waves-light"><a href="{{ route('companies.my-business') }}"><i class="icon-work left"></i>Mis Empresas</a></li>
                        {{-- <li class="waves-efect waves-light"><a href="{{ route('inmueble.my-property') }}"><i class="icon-work left"></i>Mis Vehículos</a></li>
                        <li class="waves-efect waves-light"><a href="{{ route('vehicles.my-vehicles') }}"><i class="icon-work left"></i>Mis Inmuebles</a></li> --}}
                    @endif
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
                    @endguest
        </ul>
    </nav>
</header>