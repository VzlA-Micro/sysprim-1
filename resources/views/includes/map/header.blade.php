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
                    <li><a href=""><i class="icon-account_box"></i>Account</a></li>
                    <li><a href=""><i class="icon-settings"></i>Settings</a></li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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
            <li><a href="" class="subheader">Bienvenido, {{ Auth::user()->name . " " . Auth::user()->surname }}</a></li>
            <li class="waves-efect waves-light"><a href="{{ route('profile') }}"><i class="icon-account_circle left"></i>Mi Cuenta</a></li>
            <li class="divider"></li>
            <li class="waves-efect waves-light hide-on-large-only"><a href="{{ route('home') }}" class="waves-effect waves-black"><i class="icon-home left"></i>Home</a></li>
            <li class="divider hide-on-large-only"></li>
            <li><a href="#!" class="subheader"><i class="icon-dashboard left"></i>Opciones:</a></li>     
            <li><a href="" class="waves-effect waves-blue">Gestionar Algo</a></li>
            <li><a href="" class="waves-effect waves-blue">Gestionar Algo</a></li>
            <li><a href="" class="waves-effect waves-blue">Gestionar Algo</a></li>
            <li><a href="" class="waves-effect waves-blue">Gestionar Algo</a></li>
            <li><a href="{{ route('home') }}" class="waves-effect waves-blue">Volver a SEMAT</a></li>
        </ul>
    </nav>
</header>