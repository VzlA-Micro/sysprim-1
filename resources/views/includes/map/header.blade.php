<header>    
    <ul id="sidenav-menu" class="sidenav sidenav-fixed">
        <li><a href="" class="subheader">Bienvenido, {{ Auth::user()->name . " " . Auth::user()->surname }}</a></li>
        <li class="waves-efect waves-light"><a href="{{ route('profile') }}"><i class="icon-account_circle left"></i>Mi Cuenta</a></li>
        <li class="divider"></li>
        <li class="waves-efect waves-light hide-on-large-only"><a href="{{ route('home') }}" class="waves-effect waves-black"><i class="icon-home left"></i>Home</a></li>
        <li class="waves-efect waves-light hide-on-large-only"><a href=""><i class="icon-notifications"></i>Notifications</a></li>
        <li class="divider hide-on-large-only"></li>
        <li><a href="#!" class="subheader"><i class="icon-dashboard left"></i>Opciones:</a></li>    
        <li><a href=""><i class="icon-"></i>Buscar Empresas</a></li>
        <li><a href=""><i class="icon-"></i>Buscar Empresas </a></li>
        <li><a href=""><i class="icon-"></i>Buscar Empresas</a></li>
        <li><a href=""><i class="icon-"></i>Buscar Empresas </a></li>
    </ul>
</header>