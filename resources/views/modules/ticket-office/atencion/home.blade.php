@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m3">
                <a href="{{ route('users.manage') }}" class="btn-app white cyan-text">
                    <i class="icon-people_outline"></i>
                    <span class="truncate">Gestionar Contribuyente</span>
                </a>
            </div>
            <div class="col s12 m3">
                <a href="{{ route('companies.manage') }}" class="btn-app white light-green-text">
                    <i class="icon-work"></i>
                    <span class="truncate">Gestionar Empresas</span>
                </a>
            </div>
            <div class="col s12 m3">
                <a href="{{ route('payments.manage') }}" class="btn-app white orange-text text-darken-2">
                    <i class="icon-payment"></i>
                    <span class="truncate">Gestionar Pagos</span>
                </a>
            </div>
            <div class="col s12 m3">
                <a href="{{ route('inmueble.my-property') }}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-location_city"></i>
                    <span class="truncate">Gestionar Inmuebles</span>
                </a>
            </div>
            <div class="col s12 m3">
                <a href="{{ route('vehicles.my-vehicles') }}" class="btn-app white red-text text-darken-2">
                    <i class="icon-directions_car"></i>
                    <span class="truncate">Gestionar Vehículos</span>
                </a>
            </div>
        </div>
    </div>
@endsection