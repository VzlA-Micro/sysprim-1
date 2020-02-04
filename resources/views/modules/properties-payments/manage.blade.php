@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.my-properties') }}">Mis Inmuebles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.details', ['id' => $property->id]) }}">{{ $property->code_cadastral }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.payments.manage', ['id' => $property->id]) }}">Mis Declaraciones</a></li>
                </ul>
            </div>
            @if(\Carbon\Carbon::now()->format('m') >= '01' || \Carbon\Carbon::now()->format('m') <= '03')
                <div class="col s12 m4">
                    <a href="#mode" class="btn-app white green-text modal-trigger">
                        <i class="icon-payment"></i>
                        <span class="truncate">Declarar Inmueble</span>
                    </a>
                </div>
            @else
                <div class="col s12 m4">
                    <a href="{{ route('properties.payments.manage', ['id' => $property->id]) }}" class="btn-app white green-text">
                        <i class="icon-payment"></i>
                        <span class="truncate">Declarar Inmueble</span>
                    </a>
                </div>
            @endif
            <div class="col s12 m4">
                <a href="{{ route('properties.payments.history', ['id' => $property->id]) }}" class="btn-app white orange-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Historial de Pagos</span>
                </a>
            </div>
            <div id="mode" class="modal">
                <div class="">
                    <div class="modal-content">
                        <h5 class="">Modos de pago</h5>
                        <p>Elige la forma en la realizara su pago de Vehiculo</p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{  route('properties.taxes.create',['id' => $property->id, 'status' => 'full']) }}"
                           class="modal-close waves-effect waves-green btn-small">Pago Completo</a>
                        <a href="{{ route('properties.taxes.create',['id' => $property->id, 'status' => 'trimestral']) }}"
                           class="modal-close waves-effect waves-green btn-small">Pago Trimestral</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection