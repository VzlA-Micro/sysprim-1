@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    @if(session()->has('company'))
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.details', ['id' => session('company')->id]) }}">{{ session('company')->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Mis Publicidades</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.register.types') }}">Registrar</a></li>

                </ul>
            </div>
            <div class="col s12 m6 animated bounceIn">
                @if(session()->has('company'))
                <a href="{{ route('publicity.register.create',['id' => 1, 'company_id' => session('company')->id]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Publicidad eventual u ocasional</span>
                </a>
                @else
                <a href="{{ route('publicity.register.create',['id' => 1]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Publicidad eventual u ocasional</span>
                </a>
                @endif
            </div>
            <div class="col s12 m6 animated bounceIn">
                @if(session()->has('company'))
                <a href="{{ route('publicity.register.create',['id' => 2, 'company_id' => session('company')->id]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Publicidad por cantidad de ejemplares</span>
                </a>
                @else
                <a href="{{ route('publicity.register.create',['id' => 2]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Publicidad por cantidad de ejemplares</span>
                </a>
                @endif
            </div>
            <div class="col s12 m6 animated bounceIn">
                @if(session()->has('company'))
                <a href="{{ route('publicity.register.create',['id' => 3,'company_id' => session('company')->id]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Publicidad por tiempo de duración</span>
                </a>
                @else
                <a href="{{ route('publicity.register.create',['id' => 3]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Publicidad por tiempo de duración</span>
                </a>
                @endif
            </div>
            <div class="col s12 m6 animated bounceIn">
                @if(session()->has('company'))
                <a href="{{ route('publicity.register.create',['id' => 4,'company_id' => session('company')->id]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Publicidad por tamaño</span>
                </a>
                @else
                <a href="{{ route('publicity.register.create',['id' => 4]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Publicidad por tamaño</span>
                </a>
                @endif
            </div>
            <div class="col s12 m6 animated bounceIn">
                @if(session()->has('company'))
                <a href="{{ route('publicity.register.create',['id' => 5, 'company_id' => session('company')->id]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Publicidad por vallas publicitarias o pizarras electricas</span>
                </a>
                @else
                <a href="{{ route('publicity.register.create',['id' => 5]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Publicidad por vallas publicitarias o pizarras electricas</span>
                </a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection