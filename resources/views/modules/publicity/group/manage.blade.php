@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="#">Gestionar Grupos de Publicidad</a></li>
                </ul>
            </div>
            {{-- @can('') --}}
            <div class="col s12 m4 animated bounceIn">
             <a href="{{route('group-publicity.register')}}" class="btn-app white purple-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Grupo de Publicidad</span>
                </a>
            </div>
            {{-- @endcan --}}
            {{-- @can('') --}}
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('group-publicity.read') }}" class="btn-app white blue-text">
                    <i class="icon-list"></i>
                    <span class="truncate">Ver Grupo de Publicidad</span>
                </a>
            </div>
            {{-- @endcan --}}
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection