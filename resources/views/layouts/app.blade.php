<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material-components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material-gradient.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner.css') }}">
</head>
<body class="grey lighten-4 @guest auth-view @endguest">
    @include('includes.preloader')
    @auth
        @include('includes.header')
    @endauth
    <main>
        @yield('content')
    </main>

    @auth
        @include('includes.footer')
    @endauth

    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/materialize.min.js') }}"></script>
    <script src="{{ asset('js/owner.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/dev/user.js') }}"></script>
    <script src="{{ asset('js/dev/company.js') }}"></script>
</body>
</html>