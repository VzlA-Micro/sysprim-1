@extends('layouts.app')

@section('content')
    @include('sweet::alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    @if($status=="company")
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a
                                    href="{{ route('companies.details', ['id' => $vehicle[0]->company[0]->id]) }}">{{$vehicle[0]->company[0]->name}}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                    href="{{ route('company.vehicle.read', ['idCompany' => $vehicle[0]->company[0]->id])}}">Vehículos</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Detalles De Vehículos</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.my-vehicles')}}">Mis Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="#">Detalles De Vehículos</a></li>
                    @endif
                </ul>
            </div>
            @if($vehicle[0]->status=='disabled')
                <div class="col s112 m12">
                    <div class="message message-danger center-align">
                        <div class="message-body">
                            <span>{{ "El vehículo ".$vehicle[0]->license_plate." ha sido  bloqueado  temporalmente, No puede realizar declaraciones, por favor dirigirse a la oficina de Atención al Contribuyente del SEMAT en la Torre David."}}</span>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col s12 m8">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Mi Vehiculo: {{ $vehicle[0]->license_plate}}</h5>
                    </div>

                    @if (Storage::disk('vehicles')->has($vehicle[0]->image))
                        <div class="card-image">
                            <img src="{{ route('vehicles.image', ['filename' => $vehicle[0]->image]) }}"
                                 class="materialboxed" alt="Vehicle Image" width="100%" height="100%" srcset=""
                                 style="max-height:350px;">
                            {{-- <span class="card-title grey-text"><b>Dirección:</b> {{ $company->address }}</span> --}}
                        </div>
                    @endif

                    <div class="card-content">
                        <ul>
                            <li><b>Placa: </b>{{ $vehicle[0]->license_plate }}</li>
                            <li><b>Marca: </b>{{ $vehicle[0]->model->brand->name }}</li>
                            <li><b>Modelo: </b>{{ $vehicle[0]->model->name }}
                            <li><b>Color: </b>{{ $vehicle[0]->color }}</li>
                            @if($vehicle[0]->serial_engine != null || $vehicle[0]->serial_engine != '')
                            <li><b>Serial del Motor: </b>{{ $vehicle[0]->serial_engine }}</li>
                            @endif
                            @if($vehicle[0]->body_serial != null || $vehicle[0]->body_serial != '')
                            <li><b>Serial De Carrocería: </b>{{ $vehicle[0]->body_serial }}</li>
                            @endif
                            <li><b>Año: </b>{{ $vehicle[0]->year }}</li>
                            <li><b></b></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col s12 m4" style="margin-top: -7px">

                <div class="row">
                    @if($vehicle[0]->status!='disabled')
                        @can('Mis Pagos - Vehiculos')
                            @if($status=="company")
                                <div class="col s12">
                                    <a href="{{url('vehicles/manage/'.$vehicle[0]->id."-".$vehicle[0]->company[0]->id)}}"
                                       class="btn-app white blue-text">
                                        <i class="icon-payment"></i>
                                        <span class="truncate">Mis Declaraciones</span>
                                    </a>
                                </div>
                            @else
                                <div class="col s12">
                                    <a href="{{url('vehicles/manage/'.$vehicle[0]->id)}}"
                                       class="btn-app white blue-text">
                                        <i class="icon-payment"></i>
                                        <span class="truncate">Mis Declaraciones</span>
                                    </a>
                                </div>
                        @endif
                    @endcan
                @endif
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