@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rate.ticketoffice.menu') }}">Taquilla - Tasas y Certificaciones</a></li>
                </ul>
            </div>

            <div class="col s12 m3 animated bounceIn">
                <a href="{{route('rate.ticketoffice.generate')}}" class="btn-app white blue-text">
                    <i class="icon-picture_as_pdf"></i>
                    <span class="truncate">Generar Planilla</span>
                </a>
            </div>


            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('rate.ticketoffice.payments')}}" class="btn-app white amber-text">
                    <i class="icon-payment"></i>
                    <span class="truncate">Pagar Planilla</span>
                </a>
            </div>


        </div>
    </div>
@endsection