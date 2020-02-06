@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.home') }}">Taquilla - Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.manager-property') }}">Modulo - Inmuebles Urbanos</a></li>
                </ul>
            </div>

            <div class="col s12 m3 animated bounceIn">
                <a href="{{route('property.ticket-office.create-property')}}" class="btn-app white light-blue-text">
                    <i class="icon-add_box"></i>
                    <span class="truncate">Registrar Inmuebles Urbanos</span>
                </a>
            </div>


            <div class="col s12 m3 animated bounceIn">
                <a href="{{route('property.ticket-office.read-property')}}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-list"></i>
                    <span class="truncate">Consultar Inmuebles Urbanos</span>
                </a>
            </div>

           {{--@can('Verificar Pagos - Archivo')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('payments.verify.manage') }}" class="btn-app white orange-text text-darken-4">
                    <i class="icon-file_upload"></i>
                    <span class="truncate">Verificación de Pagos</span>
                </a>
            </div>
            @endcan--}}
        </div>
    </div>
@endsection