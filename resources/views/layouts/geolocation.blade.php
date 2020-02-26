<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material-components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material-gradient.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="shortcut icon" type="image´/png" href="{{ asset('images/sysprim/sysprim_icono color.ico') }}">
    <meta name="theme-color" content="#a51d1d">
    @yield('styles')
    <title>Geolocalización - GeoSEMAT</title>
</head>
<body>
    @include('includes.map.header')
    
    @yield('content')

    @include('includes.scripts')
    @include('includes.map.footer')
    @yield('scripts')
</body>
</html>