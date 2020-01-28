@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                </ul>
            </div>
            @can('Taquilla - Actividad Económica')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{route('home.ticket-office') }}" class="btn-app white light-green-text">
                    <i class="icon-personal_video"></i>
                    <span class="truncate">Taquilla Empresas</span>
                </a>
            </div>
            @endcan

            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('ticketOffice.vehicle.home') }}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-personal_video"></i>
                    <span class="truncate">Taquilla Vehículos</span>
                </a>
            </div>


            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('rate.ticketoffice.menu')}}" class="btn-app white  blue-text accent-3">
                    <i class="icon-personal_video"></i>
                    <span class="truncate">Taquilla - Tasas y Certificaciones</span>
                </a>
            </div>


            @can('Verificar Pagos - Archivo')
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('payments.verify.manage') }}" class="btn-app white orange-text text-darken-4">
                        <i class="icon-file_upload"></i>
                        <span class="truncate">Verificación de Pagos</span>
                    </a>
                </div>
            @endcan



            @can('Ver Planillas')
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{route('ticket-office.pay.web')}}" class="btn-app white indigo-text">
                        <i class="icon-library_books"></i>
                        <span class="truncate">Lista de Planillas</span>
                    </a>
                </div>
            @endcan
            @can('Ver Pagos')
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('ticket-office.type.payments') }}" class="btn-app white indigo-text">
                        <i class="icon-format_list_bulleted"></i>
                        <span class="truncate">Ver Pagos</span>
                    </a>
                </div>
            @endcan

            

            <!-- Modal Structure -->
            <div id="modal1" class="modal modal-sm">
                <div class="modal-content">
                    <h4 class="center-align">Taquillas</h4>
                    <div class="row content">
                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection