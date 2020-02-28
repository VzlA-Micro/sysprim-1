@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    @if($status=="company")
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a
                                    href="{{ route('companies.details',['id'=>$vehicle[0]->company[0]->id]) }}">{{$vehicle[0]->company[0]->name}}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('company.vehicle.read', ['idCompany' => $vehicle[0]->company[0]->id])}}">Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="{{route('vehicles.details',['id'=>$vehicle[0]->id.'-'.true])}}">Detalles De Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="#">Mis Declaraciones</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.my-vehicles') }}" class="breadcrumb">Mis
                                Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="{{route('vehicles.details',['id'=>$vehicle[0]->id])}}">Detalles
                                De Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="#">Mis Declaraciones</a></li>
                    @endif
                </ul>
            </div>
            @can('Declarar Vehiculos')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{route('taxes.vehicle',['id'=>$id."-".'true'])}}" class="btn-app white green-text">
                    <i class="icon-payment"></i>
                    <span class="truncate">Mis Declaraciones</span>
                </a>
            </div>
            @endcan
            @can('Historial de Pagos - Vehiculos')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ url('/vehicle/payments/history/'.$id)}}" class="btn-app white orange-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Historial de Pagos</span>
                </a>
            </div>
            @endcan
        {{--<div class="col s12 m4 animated bounceIn">
            @if(Carbon\Carbon::now()->format('m')==='01')
                <a href="#mode" class="modal-trigger btn-app white green-text">
                    <i class="icon-payment"></i>
                    <span class="truncate">Mis Declaraciones</span>
                </a>
            @else
                <a href="{{url('/taxes/vehicles/'.$id."-false")}}"
                   class="btn-app white green-text">
                    <i class="icon-payment"></i>
                    <span class="truncate">Mis Declaraciones</span>
                </a>
            @endif
        </div>--}}


        {{-- "{{route('taxes.vehicle',['id'=>$vehicle->id])}}" Modal Trigger  --}}


        <!-- Modal Structure -->
            <div id="mode" class="modal">
                <div class="">
                    <div class="modal-content">
                        <h5 class="">Modos de pago</h5>
                        <p>Elige la forma en la realizara su pago de Vehiculo</p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{route('taxes.vehicle',['id'=>$id."-".false])}}"
                           class="modal-close waves-effect waves-green btn-small">Pago Completo</a>
                        <a href="{{route('taxes.vehicle',['id'=>$id."-".true])}}"
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
@section('scripts')

@endsection