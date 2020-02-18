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
                    <li class="breadcrumb-item"><a href="{{ route('properties.my-properties') }}">Mis Inmuebles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.details', ['id' => $property->id]) }}">{{ $property->code_cadastral }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.payments.manage', ['id' => $property->id]) }}">Mis Declaraciones</a></li>
                </ul>
            </div>
            {{--@if(\Carbon\Carbon::now()->format('m') >= '01' || \Carbon\Carbon::now()->format('m') <= '03')--}}
            @can('Declarar Inmuebles')
            <div class="col s12 m4">
                <a href="{{  route('properties.taxes.create',['id' => $property->id, 'status' => 'full']) }}" class="btn-app white red-text modal-trigger">
                    <i class="icon-report"></i>
                    <span class="truncate">Declarar Inmueble</span>
                </a>
            </div>
            @endcan
            {{--@else
                <div class="col s12 m4">
                    <a href="{{ route('properties.payments.manage', ['id' => $property->id]) }}" class="btn-app white green-text">
                        <i class="icon-payment"></i>
                        <span class="truncate">Declarar Inmueble</span>
                    </a>
                </div>
            @endif--}}
            @can('Historial de Pagos - Inmuebles')
            <div class="col s12 m4">
                <a href="{{ route('properties.payments.history', ['id' => $property->id]) }}" class="btn-app white orange-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Historial de Pagos</span>
                </a>
            </div>
            @endcan
            {{--<div id="mode" class="modal modal-sm">
                <div class="">
                    <div class="modal-content">
                        <h5 class="center-align">Forma de Pago</h5>
                        <p>Seleccione la forma en que realizará el pago de su Inmueble.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{  route('properties.taxes.create',['id' => $property->id, 'status' => 'full']) }}"
                           class="modal-close green waves-effect waves-green btn-small"><i class="icon-payment right"></i>Pago Completo Anual</a>
                        --}}{{--<a href="{{ route('properties.taxes.create',['id' => $property->id, 'status' => 'trimestral']) }}"
                           class="modal-close waves-effect waves-green btn-small">Pago Trimestral</a>--}}{{--
                    </div>
                </div>
            </div>--}}
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection