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
                    <li class="breadcrumb-item"><a href="{{ route('properties.details', ['id' => $property[0]->id]) }}">{{ $property[0]->code_cadastral }}</a></li>
                </ul>
            </div>
            <div class="col s12 m8">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Mi Inmueble: {{$property[0]->code_cadastral}}</h5>
                    </div>

                    <div class="card-content">
                        <ul>
                            <li><b>Alias del Inmueble: </b>{{ $property[0]->alias }}</li>
                            <li><b>Direccion: </b>{{ $property[0]->address }}</li>
                            <li><b>Tipo(s) de Construccion(es): </b>
                                @foreach($propertyBuildings as $propertyBuilding)
                                    <b>[</b>{{ $propertyBuilding->buildingValue->name }}<b>]</b>,
                                @endforeach
                            </li>
                            <li><b>Lugar: </b>{{$catasTerreno->name}}</li>
                            <li><b>Parroquia: </b>{{$parish->name}}</li>
                            <li><b>Area De Construccion: </b>{{ $property[0]->area_build}} MT2</li>
                            <li><b>Area De Terreno: </b>{{ $property[0]->area_ground}} MT2</li>
                            <li><b></b></li>
                        </ul>
                    </div>
                    @can('Actualizar Mis Inmuebles')
                    {{-- <div class="card-footer">
                        <div class="row" style="margin-bottom:0">
                        <!-- <div class="col s12 center-align">
                                <a href="{{ route('companies.edit', ['id' => $property[0]->id]) }}" class="btn blue btn-rounded waves-light">Editar</a>
                            </div>
                        </div>
                    </div> --}}
                    @endcan
                </div>
            </div>
            {{-- Mostrar seccion si es administrador o no --}}
           <div class="col s12 m4" style="margin-top: -7px">
                <div class="row">
                    {{--@if(\Carbon\Carbon::now()->format('m') >= '01' || \Carbon\Carbon::now()->format('m') <= '03')
                    <div class="col s12">
                        <a href="#mode" class="btn-app white green-text modal-trigger">
                            <i class="icon-payment"></i>
                            <span class="truncate">Mis Declaraciones</span>
                        </a>
                    </div>
                    @else--}}
                    @can('Mis Pagos - Inmuebles')
                    <div class="col s12">
                        <a href="{{ route('properties.payments.manage', ['id' => $property[0]->id]) }}" class="btn-app white green-text">
                            <i class="icon-payment"></i>
                            <span class="truncate">Mis Declaraciones</span>
                        </a>
                    </div>
                    @endcan
                    {{--@endif--}}
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