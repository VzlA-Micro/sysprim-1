@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="#">Mis Vehículos</a></li>
                </ul>
            </div>
            @include('sweet::alert')
            @foreach($show as $vehicle)
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('vehicles.details',['id'=>$vehicle->id])}}" class="btn-app white purple-text">
                    <i class="icon-directions_car"></i>
                    {{--<span class="truncate">{{ $vehicle->model->brand->name."-".$vehicle->model->name}}</span>--}}
                    <span class="truncate">{{ $vehicle->license_plate}}</span>
                </a>
            </div>
            @endforeach
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('vehicles.register') }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Agregar nuevo vehiculo...</span>
                </a>
            </div>
        </div>
    </div>
@endsection