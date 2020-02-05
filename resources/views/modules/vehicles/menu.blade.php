@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    @if(isset($company))
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a
                                    href="{{ route('companies.details', ['id' => $company->id]) }}">{{ $company->name}}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Vehículos</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="#">Mis Vehículos</a></li>
                    @endif

                </ul>
            </div>
            {{-- @include('sweet::alert') --}}
            @can('Consultar Mis Vehiculos')
                @foreach($show as $vehicle)
                    @if(isset($company))
                        <div class="col s12 m4 animated bounceIn">
                            <a href="{{ route('vehicles.details',['id'=>$vehicle->id.'-'.true])}}"
                               class="btn-app white purple-text">
                                <i class="icon-directions_car"></i>
                                {{--<span class="truncate">{{ $vehicle->model->brand->name."-".$vehicle->model->name}}</span>--}}
                                <span class="truncate">{{ $vehicle->license_plate}}</span>
                            </a>
                        </div>
                    @else
                        @if(isset($vehicle->company[0]->id))
                            <div class="col s12 m4 animated bounceIn">
                                <a href="{{ route('vehicles.details',['id'=>$vehicle->id.'-'.false])}}"
                                   class="btn-app white purple-text">
                                    <i class="icon-directions_car"></i>
                                    <span class="truncate">{{ $vehicle->license_plate}}</span>
                                    <span class="truncate">(Juridíco)</span>
                                </a>
                            </div>
                        @else
                            <div class="col s12 m4 animated bounceIn">
                                <a href="{{ route('vehicles.details',['id'=>$vehicle->id.'-'.false])}}"
                                   class="btn-app white purple-text">
                                    <i class="icon-directions_car"></i>
                                    <span class="truncate">{{ $vehicle->license_plate}}</span>
                                    <span class="truncate">(Natural)</span>
                                </a>
                            </div>
                        @endif

                    @endif
                @endforeach
            @endcan
            @can('Registrar Mis Vehiculos')
                @if(isset($company))
                    <div class="col s12 m4 animated bounceIn">
                        <a href="{{ route('vehicles.register',['register'=>'COMPANY-'.$company->id]) }}"
                           class="btn-app white orange-text">
                            <i class="icon-add_circle"></i>
                            <span class="truncate">Agregar nuevo vehiculo...</span>
                        </a>
                    </div>
                @else
                    <div class="col s12 m4 animated bounceIn">
                        <a href="{{ route('vehicles.register',['register'=>'']) }}" class="btn-app white orange-text">
                            <i class="icon-add_circle"></i>
                            <span class="truncate">Agregar nuevo vehiculo...</span>
                            <span class="truncate white-text">w</span>
                        </a>
                    </div>
                @endif
            @endcan
        </div>
    </div>
@endsection