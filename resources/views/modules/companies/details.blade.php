@extends('layouts.app')

@section('content')
    @include('sweet::alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                {{-- Configurar nombre si es usuario o es administrador --}}
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mis Empresas</a>
                <a href="" class="breadcrumb">{{ $company->name }}</a>
            </div>
            <div class="col s12 m8">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Mi Empresa: {{ $company->name}}</h5>
                    </div>
                    @if (Storage::disk('companies')->has($company->image))
                    <div class="card-image">
                        <img src="{{ route('companies.image', ['filename' => $company->image]) }}" class="materialboxed" data-caption="{{ $company->address }}" alt="" srcset="" style="max-height:350px;">
                        {{-- <span class="card-title grey-text"><b>Dirección:</b> {{ $company->address }}</span> --}}
                    </div>
                    @endif
                    <div class="card-content">
                        <ul>
                            <li><b>RIF: </b>{{ $company->RIF }}</li>
                            <li><b>Licencia: </b>{{ $company->license }}</li>
                            <li><b>Dirección: </b>{{ $company->address }}</li>
                            <li><b></b></li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="row" style="margin-bottom:0">
                            <div class="col s12 center-align">
                                <a href="{{ route('companies.edit', ['id' => $company->id]) }}" class="btn blue btn-rounded waves-light">
                                    Más Detalles
                                    <i class="icon-more_horiz right"></i>
                                </a>
                            </div>
                           {{-- <div class="col s12 m6 center-align">
                                <a href="" class="btn green btn-rounded waves-light col s12">
                                    Descargar Carnet
                                    <i class="icon-perm_contact_calendar right"></i>
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- Mostrar seccion si es administrador o no --}}
            <div class="col s12 m4" style="margin-top: -7px">
                <div class="row">
                    <div class="col s12">
                        <a href="{{ route('companies.my-payments', ['company' => $company->name]) }}" class="btn-app white green-text">
                            <i class="icon-payment"></i>
                            <span class="truncate">Mis Pagos</span>
                        </a>
                    </div>
                    <!-- <div class="col s12">
                        <a href="" class="btn-app white orange-text">
                            <i class="icon-warning"></i>
                            <span class="truncate">Mis Multas</span>
                        </a>
                    </div> -->
                    
                </div>
            </div>
        </div>
    </div>
@endsection