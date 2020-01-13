@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Mis Publicidades</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.details', ['id' => $publicity->id]) }}">{{ $publicity->name }}</a></li>
                </ul>
            </div>
            <div class="col s12 m9">
            	<div class="card">
            		<div class="card-header center-align">
            			<h4>Detalles de Publicidad</h4>
            		</div>
            			@if (Storage::disk('publicities')->has($publicity->image))
                        <div class="card-image">
                            <img src="{{ route('publicity.image', ['filename' => $publicity->image]) }}">
                            {{-- <span class="card-title grey-text"><b>Dirección:</b> {{ $company->address }}</span> --}}
                        </div>
                    	@endif
            		<div class="card-content">
            			<ul>
            				{{-- @foreach($publicity->advertisingTypes as $type) --}}
                            <li><b>Tipo de Publicidad </b>{{ $publicity->advertisingType->name }}</li>
                            {{-- @endforeach --}}
                            <li><b>Nombre: </b>{{ $publicity->name }}</li>
                            <li><b>Fecha de Inicio: </b>{{ $publicity->date_start }}</li>
                            <li><b>Fecha de Fin: </b>{{ $publicity->date_end }}</li>
                            @if($publicity->unit == "qnt")
                            <li><b>Unidad: </b>Cantidad</li>
                            <li><b>Cantidad: </b>{{ $publicity->quantity }} unidades</li>
                            @elseif($publicity->unit == "mts")
                            <li><b>Unidad: </b>Metros</li>
                            <li><b>Ancho: </b>{{ $publicity->width }}mts</li>
                            <li><b>Alto: </b>{{ $publicity->height }}mts</li>
                            @endif
                            @if($publicity->side != null && $publicity->floor != null)
                            <li><b>Cantidad de Caras: </b>{{ $publicity->side }}</li>
                            <li><b>Cantidad de Pisos: </b>{{ $publicity->floor }}</li>
                            @endif
                            @if($publicity->advertising_type_id == 1) 
                            <li><b>Puntos de Publicidad: </b>{{ $publicity->side }}</li>
                            @endif
                        </ul>
            		</div>
            		<div class="card-footer center-align">
                        <a href="{{ route('publicity.edit', ['id' => $publicity->id]) }}" class="btn btn-large peach btn-rounded waves-effect waves-light">
                            <i class="icon-send right"></i>
                            Editar
                        </a>      
                    </div>
            	</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection