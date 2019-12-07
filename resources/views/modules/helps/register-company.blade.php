@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
        	<div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('helps.manage') }}">Ayuda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('helps.manage') }}">Registrar Mi Empresa</a></li>
                </ul>
            </div>
            <div class="col s12 z-depth-2" style="padding: 0">
                <div class="carousel carousel-slider">
                    <a class="carousel-item" href="#one!"><img class="responsive-img materialboxed" style="z-index:1" src="{{ asset('images/help/Registrar-Empresa-1.png') }}"></a>
                    <a class="carousel-item" href="#two!"><img class="responsive-img materialboxed" style="z-index:1" src="{{ asset('images/help/Registrar-Empresa-2.png') }}"></a>
                    <a class="carousel-item" href="#three!"><img class="responsive-img materialboxed" style="z-index:1" src="{{ asset('images/help/Registrar-Empresa-3.png') }}"></a>
                    <a class="carousel-item" href="#four!"><img class="responsive-img materialboxed" style="z-index:1" src="{{ asset('images/help/Registrar-Empresa-4.png') }}"></a>
                    <a class="carousel-item" href="#five!"><img class="responsive-img materialboxed" style="z-index:1" src="{{ asset('images/help/Registrar-Empresa-5.png') }}"></a>
                    <a class="carousel-item" href="#six!"><img class="responsive-img materialboxed" style="z-index:1" src="{{ asset('images/help/Registrar-Empresa-6.png') }}"></a>
                    <a class="carousel-item" href="#seven!"><img class="responsive-img materialboxed" style="z-index:1" src="{{ asset('images/help/Registrar-Empresa-6.png') }}"></a>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection