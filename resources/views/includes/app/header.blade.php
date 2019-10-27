<header>
    <nav class="container-fluid iribarren-wine-gradient">
        <div class="nav-wrapper">
            <a href="{{ url('/') }}" class="brand-logo font-audiowide">SEMAT</a>
            {{-- Sidenav Trigger --}}
            <a href="#" data-target="sidenav-menu" class="sidenav-trigger"><i class="icon-menu"></i></a>
            {{-- Authenticacion links --}}
            <ul id="nav-movile" class="right hide-on-med-and-down">
                {{-- Boton de prueba --}}
                <li><a href="{{ route('bank.upload') }}"><i class="icon-file_upload"></i></a></li>
                <li><a href="{{ route('home') }}" class="tooltipped" data-position="bottom"
                       data-tooltip="{{ __('Home') }}"><i class="icon-home"></i></a></li>
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
                    @endif
                    <a href="{{ route('notifications.read') }}" class="collection-footer center-align">
                        <span>Ver todas las notificaciones</span>
                    </a>
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
                    <li><a href=""><i class="icon-account_box"></i>Account</a></li>
                    <li><a href=""><i class="icon-settings"></i>Settings</a></li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="icon-exit_to_app"></i>
                            {{ __('Logout') }}
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
                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @endif
                @else
                    <li><a href=""
                           class="subheader">Bienvenido, {{ Auth::user()->name . " " . Auth::user()->surname }}</a></li>
                    <li class="waves-efect waves-light"><a href="{{ route('profile') }}"><i
                                    class="icon-account_circle left"></i>Mi Cuenta</a></li>
                    <li class="divider"></li>
                    <li class="waves-efect waves-light hide-on-large-only"><a href="{{ route('home') }}"
                                                                              class="waves-effect waves-black"><i
                                    class="icon-home left"></i>Home</a></li>
                    <li class="waves-efect waves-light hide-on-large-only"><a href=""><i class="icon-notifications"></i>Notifications</a>
                    </li>
                    <li class="divider hide-on-large-only"></li>
                    <li><a href="#!" class="subheader"><i class="icon-dashboard left"></i>Opciones:</a></li>
                    {{-- <li class="waves-efect waves-light"><a href=""><i class="icon-group_add left"></i>Gestionar Usuarios</a></li> --}}
                    <li class="waves-efect waves-light"><a href="{{ route('companies.my-business') }}"><i
                                    class="icon-work left"></i>Mis Empresas</a></li>
                    @if (Auth::user()->email === 'sysprim@gmail.com')
                        <li class="waves-efect waves-light hide-on-large-only"><a href="{{ route('users.manage') }}"><i
                                        class="icon-people_outline"></i>Gestionar Usuarios</a></li>
                        <li class="waves-efect waves-light hide-on-large-only"><a
                                    href="{{ route('companies.manage') }}"><i class="icon-work"></i>Gestionar
                                Empresas</a></li>
                        <li class="waves-efect waves-light hide-on-large-only"><a href="{{ route('payments.manage') }}"><i
                                        class="icon-payment"></i>Gestionar Pagos</a></li>
                        <li class="waves-efect waves-light hide-on-large-only"><a href="{{ route('fines.manage') }}"><i
                                        class="icon-warning"></i>Gestionar Multas</a></li>
                        <li class="waves-efect waves-light hide-on-large-only"><a href="{{ route('ciu.manage') }}"><i
                                        class="icon-assignment"></i>Gestionar CIIU</a></li>

                    @endif
                    {{-- <li class="waves-efect waves-light"><a href="{{ route('payments.my-payments') }}"><i class="icon-payment left"></i>Mis Pagos</a></li>
                    <li class="waves-efect waves-light"><a href="{{ route('vehicles.my-vehicles') }}"><i class="icon-local_shipping left"></i>Mis Vehículos</a></li> --}}
                    <li class="divider hide-on-large-only"></li>
                    <li class="waves-efect waves-light hide-on-large-only">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-sidenav-form').submit();">
                            <i class="icon-exit_to_app"></i>
                            {{ __('Logout') }}
                        </a>
                    </li>
                    <form id="logout-sidenav-form" action="{{ route('logout') }}" method="post" style="display: none;">
                        @csrf
                    </form>
                    @endguest
        </ul>
    </nav>
</header>