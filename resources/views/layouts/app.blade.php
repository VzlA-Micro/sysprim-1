<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!--<script src="{{asset('js/openpgp.min.js')}}"></script>-->
    <!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-157083345-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-157083345-1');
    </script>-->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="semat, semat en linea, alcaldia de iribarren semat, semat iribarren, semat barquisimeto, alcaldia de iribarren, pago de impuestos iribarren, recaudacion iribarren, impuestos iribarren">
    <meta name="description" content="SEMAT. El Servicio Municipal de Administración Tributaria es el encargado de la recaudación de impuestos dentro del municipio Iribarren. semat">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - Alcaldía de Iribarren</title>
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner.min.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('css/material-components.min.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/material-gradient.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/icons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('css/style.css') }}">--}}
    <link rel="shortcut icon" type="image´/png" href="{{ asset('images/sysprim/sysprim_icono color.ico') }}">




    @yield('styles')
</head>
<body class="grey lighten-4 @guest auth-view auth-background @endguest">
    @include('includes.preloader')
    @auth
        @include('includes.app.header')
    @endauth
    @guest
        @include('includes.auth.header')
    @endguest
    <main>
        @if(Route::currentRouteName() == '' || Route::currentRouteName() == 'login')
            
        @endif
        @yield('content')
    </main>

    @auth
        @include('includes.app.footer')
    @endauth
    @guest
        @include('includes.auth.footer')
    @endguest
    
    @include('includes.scripts')
    @yield('scripts')

</body>
</html>