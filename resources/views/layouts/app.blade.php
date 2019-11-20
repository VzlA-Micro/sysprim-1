<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - Alcaldía de Iribarren</title>
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material-components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material-gradient.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner.css') }}">
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

    @include('includes.petro-data')    

    @include('includes.scripts')
    @yield('scripts')
</body>
</html>