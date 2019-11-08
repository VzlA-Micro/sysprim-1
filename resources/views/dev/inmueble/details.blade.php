@extends('layouts.app')

@section('content')
    @include('sweet::alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                {{-- Configurar nombre si es usuario o es administrador --}}
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mis Inmuebles</a>
                <a href="" class="breadcrumb"></a>
            </div>
            <div class="col s12 m8">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Mi Inmueble: {{$property[0]->codigo_catastral}}</h5>
                    </div>

                    <div class="card-content">
                        <ul>
                            <li><b>Direccion: </b>{{ $property[0]->direccion }}</li>
                            <li><b>Tipo de Construccion: </b>{{ $catasConstruct->name }}</li>
                            <li><b>Lugar: </b>{{ $catasTerreno->name }}</li>
                            <li><b>Parroquia: </b>{{ $parish->name }}</li>
                            <li><b>Area De Construccion: </b>{{ $property[0]->area_build}} MT2</li>
                            <li><b>Area De Terreno: </b>{{ $property[0]->area_ground}} MT2</li>
                            <li><b></b></li>
                        </ul>
                    </div>
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
                    <div class="col s12">
                        <a href="" class="btn-app white orange-text">
                            <i class="icon-warning"></i>
                            <span class="truncate">Mis Multas</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection