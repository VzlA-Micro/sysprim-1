@extends('layouts.app')

@section('content')
    @include('sweet::alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    @if(isset($idCompany))
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.details', ['id' => $company->id]) }}">{{ session('company')}}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.my-vehicles')}}">Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="#">Detalles De Vehículos</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.my-vehicles')}}">Mis Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="#">Detalles De Vehículos</a></li>
                    @endif
                </ul>
            </div>
            <div class="col s12 m8">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Mi Vehiculo: {{ $vehicle[0]->license_plate}}</h5>
                    </div>

                    @if (Storage::disk('vehicles')->has($vehicle[0]->image))
                        <div class="card-image">
                            <img src="{{ route('vehicles.image', ['filename' => $vehicle[0]->image]) }}"
                                 class="materialboxed" alt="" srcset=""
                                 style="max-height:350px;">
                            {{-- <span class="card-title grey-text"><b>Dirección:</b> {{ $company->address }}</span> --}}
                        </div>
                    @endif

                    <div class="card-content">
                        <ul>
                            <li><b>Licencia: </b>{{ $vehicle[0]->license_plate }}</li>
                            {{--
                            <li><b>Marca: </b>{{ $vehicle->model->brand->name }}</li>
                            <li><b>Modelo: </b>{{ $vehicle->model->name }}</li>
                            --}}
                            <li><b>Serial del Motor: </b>{{ $vehicle[0]->serial_engine }}</li>
                            <li><b>Serial De Carrocería: </b>{{ $vehicle[0]->body_serial }}</li>
                            <li><b>Año: </b>{{ $vehicle[0]->year }}</li>
                            <li><b></b></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col s12 m4" style="margin-top: -7px">

                <div class="row">
                    <div class="col s12">
                        <a href="{{url('vehicles/manage/'.$vehicle[0]->id)}}" class="modal-trigger btn-app white green-text">
                            <i class="icon-payment"></i>
                            <span class="truncate">Mis Declaraciones</span>
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