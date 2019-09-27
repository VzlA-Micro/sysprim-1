<header>
    <nav class="container-fluid blue-gradient">
        <div class="nav-wrapper">
            <a href="{{ url('/') }}" class="brand-logo font-audiowide">SysPRIM</a>
            {{-- Sidenav Trigger --}}
            <a href="#" data-target="sidenav-menu" class="sidenav-trigger"><i class="icon-menu"></i></a>
            {{-- Authenticacion links --}}
            <ul id="nav-movile" class="right hide-on-med-and-down">
                @guest
                    <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @endif
                @else
                    <li><a href="{{ route('home') }}"><i class="icon-home"></i></a></li>
                    <li><a href=""><i class="icon-notifications"></i></a></li>
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
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="icon-exit_to_app"></i>
                            {{ __('Logout') }}
                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                @endguest
            </ul>
        </div>
        <ul id="sidenav-menu" class="sidenav sidenav-fixed sidenav-background">
            <li><a href="" class="logo-container font-audiowide center-align white-text">SysPRIM</a></li>
            @guest
                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @endif
            @else
                <li class="waves-efect waves-light"><a href="" class="waves-effect waves-black"><i class="icon-home left"></i>Home</a></li>
                <li class="waves-efect waves-light"><a href=""><i class="icon-notifications"></i>Notifications</a></li>
                <li class="waves-efect waves-light">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();>">
                        <i class="icon-exit_to_app"></i>
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </nav>
</header>