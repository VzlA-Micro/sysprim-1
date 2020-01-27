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
                    <li class="breadcrumb-item"><a href="#!">{{ $property[0]->code_cadastral }}</a></li>
                </ul>
            </div>
            <div class="col s12 m8">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Mi Inmueble: {{$property[0]->code_cadastral}}</h5>
                    </div>

                    <div class="card-content">
                        <ul>
                            <li><b>Direccion: </b>{{ $property[0]->address }}</li>
                            <li><b>Tipo de Construccion: </b>{{$catasConstruct->name}}</li>
                            <li><b>Lugar: </b>{{$catasTerreno->name}}</li>
                            <li><b>Parroquia: </b>{{$parish->name}}</li>
                            <li><b>Area De Construccion: </b>{{ $property[0]->area_build}} MT2</li>
                            <li><b>Area De Terreno: </b>{{ $property[0]->area_ground}} MT2</li>
                            <li><b></b></li>
                        </ul>
                    </div>
                    @can('Actualizar Mis Inmuebles')
                    <div class="card-footer">
                        <div class="row" style="margin-bottom:0">
                            <div class="col s12 center-align">
                                <a href="{{ route('companies.edit', ['id' => $property[0]->id]) }}" class="btn blue btn-rounded waves-light">Editar</a>
                            </div>
                           <!-- <div class="col s12 m6 center-align">
                                <a href="" class="btn red btn-rounded waves-light col s12">Eliminar</a>
                            </div>-->
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
            {{-- Mostrar seccion si es administrador o no --}}
           <div class="col s12 m4" style="margin-top: -7px">
                <div class="row">
                    <div class="col s12">
                        <a href="{{route('inmueble.my-propertys')}}" class="btn-app white green-text">
                            <i class="icon-payment"></i>
                            <span class="truncate">Mis Pagos</span>
                        </a>
                    </div>
                    {{--<div class="col s12">
                       <a href="" class="btn-app white orange-text">
                           <i class="icon-warning"></i>
                           <span class="truncate">Mis Multas</span>
                       </a>
                   </div>--}}
               </div>
           </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection