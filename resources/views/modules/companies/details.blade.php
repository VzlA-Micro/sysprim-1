@extends('layouts.app2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mi Empresa</a>
                <a href="" class="breadcrumb">{{ $company->name }}</a>
            </div>
            <div class="col s12 m8">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Mi Empresa: {{ $company->name }}</h5>
                    </div>
                    @if (Storage::disk('companies')->has($company->image))
                    <div class="card-image">
                        <img src="{{ route('companies.image', ['filename' => $company->image]) }}" alt="" srcset="">
                        <span class="card-title grey-text"><b>Dirección:</b> {{ $company->address }}</span>
                    </div>
                    @endif
                    <div class="card-content">
                        <ul>
                            <li><b>RIF: </b>{{ $company->RIF }}</li>
                            <li><b>Licencia: </b>{{ $company->license }}</li>
                            <li><b>Fecha de Apertura: </b>{{ $company->opening_date }}</li>
                            <li><b>Dirección: </b>{{ $company->address }}</li>
                            <li><b></b></li>
                            <li><b></b></li>
                            <li><b></b></li>
                        </ul>
                    </div>
                    <div class="card-action">
                        <div class="row" style="margin-bottom:0">
                            <div class="col s12 m6 center-align">
                                <a href="{{ route('companies.edit', ['id' => $company->id]) }}" class="btn blue col s12">Modificar</a>
                            </div>
                            <div class="col s12 m6 center-align">
                                <a href="" class="btn red col s12">Eliminar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m4" style="margin-top: -7px">

                <div class="row">
                    <div class="col s12">
                        <a href="{{ route('companies.my-payments', ['company' => $company->name]) }}" class="btn-app white green-text">
                            <i class="icon-payment"></i>
                            <span class="truncate">Mis Pagos</span>
                        </a>
                    </div>
                    <div class="col s12">
                        <a href="{{ route('vehicles.my-vehicles') }}" class="btn-app white red-text">
                            <i class="icon-local_shipping"></i>
                            <span class="truncate">Mis Vehículos</span>
                        </a>
                    </div>
    
                </div>
            </div>
        </div>
    </div>
@endsection