@extends('layouts.app')

@section('content')
    @include('sweet::alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.my-vehicles')}}">Mis Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="#">Detalles De Vehículos</a></li>
                </ul>
            </div>
            <div class="col s12 m8">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Mi Vehiculo: {{ $vehicle->license_plate}}</h5>
                    </div>

                    @if (Storage::disk('vehicles')->has($vehicle->image))
                        <div class="card-image">
                            <img src="{{ route('vehicles.image', ['filename' => $vehicle->image]) }}"
                                 class="materialboxed" alt="" srcset=""
                                 style="max-height:350px;">
                            {{-- <span class="card-title grey-text"><b>Dirección:</b> {{ $company->address }}</span> --}}
                        </div>
                    @endif

                    <div class="card-content">
                        <ul>
                            <li><b>Licencia: </b>{{ $vehicle->license_plate }}</li>
                            {{--
                            <li><b>Marca: </b>{{ $vehicle->model->brand->name }}</li>
                            <li><b>Modelo: </b>{{ $vehicle->model->name }}</li>
                            --}}
                            <li><b>Serial del Motor: </b>{{ $vehicle->serial_engine }}</li>
                            <li><b>Serial De Carrocería: </b>{{ $vehicle->body_serial }}</li>
                            <li><b>Año: </b>{{ $vehicle->year }}</li>
                            <li><b></b></li>
                        </ul>
                    </div>
                <!--<div class="card-footer">
                        <div class="row" style="margin-bottom:0">
                            <div class="col s12 center-align">
                                <a href="" class="btn blue btn-rounded waves-light">
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
                    </div>-->
                </div>
            </div>

           <div class="col s12 m4" style="margin-top: -7px">
                <div class="row">
                    <div class="col s12">
                        <a href="#mode" class="modal-trigger btn-app white green-text">
                            <i class="icon-payment"></i>
                            <span class="truncate">Mis Declaraciones</span>
                        </a>
                    </div>

                {{-- "{{route('taxes.vehicle',['id'=>$vehicle->id])}}" Modal Trigger  --}}


                    <!-- Modal Structure -->
                    <div id="mode" class="modal">
                        <div class="">
                            <div class="modal-content">
                                <h5 class="">Modos de pago</h5>
                                <p>Elige la forma en la realizara su pago de Vehiculo</p>
                            </div>
                            <div class="modal-footer">
                                <a href="{{route('taxes.vehicle',['id'=>$vehicle->id."-".true])}}"
                                   class="modal-close waves-effect waves-green btn-small">Pago Completo</a>
                                <a href="{{route('taxes.vehicle',['id'=>$vehicle->id."-".false])}}"
                                   class="modal-close waves-effect waves-green btn-small">Pago Trimestral</a>
                            </div>
                        </div>

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