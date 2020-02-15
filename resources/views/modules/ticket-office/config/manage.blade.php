@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{-- route('settings.manage') --}}">Configuración de Taquilla</a></li>
                </ul>
            </div>

            {{-- @can('Gestionar CIIU') --}}
            <div class="col s6 m3 animated bounceIn" id="reset">
                <a href="#" class="btn-app white red-text text-darken-1">
                    <i class="fas fa-times-circle"></i>
                    <span class="truncate">Cancelar Todos Los Turnos</span>
                </a>
            </div>
            {{-- @endcan --}}
            {{-- @can('Gestionar Unidad Tribuaria') --}}
            <div class="col s6 m3 animated bounceIn" id="reset-ticket">
                <a href="#" class="btn-app white blue-text text-darken-4 ">
                    <i class="icon-remove_from_queue"></i>
                    <span class="truncate">Habilitar Taquillas</span>
                </a>
            </div>
            {{-- @endcan --}}
           
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/sysq.js') }}"></script>
@endsection