@extends('layouts.app')

@section('content')
    @include('sweet::alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                    <li class="breadcrumb-item"><a
                                href="{{ route('companies.details', ['id' => $company->id]) }}">{{ $company->name }}</a>
                    </li>
                </ul>
            </div>
            @if($company->status=='disabled')
                <div class="col s112 m12">
                    <div class="alert alert-danger" style="margin-top: 1.5rem">
                        <span>{{ "La empresa ".$company->name." ha sido  bloqueada  temporalmente, No puede realizar declaraciones, por favor dirigirse a la oficina de Atención al Contribuyente del SEMAT en la Torre David."}}</span>
                    </div>
                </div>
            @endif
            @if(session("message") )
                <div class="col s112 m12">
                    <div class="alert alert-danger center-align">
                        <strong>{{session("message")}}</strong>
                    </div>
                </div>
            @endif


            <div class="col s12 m9">

                <div class="card">
                    <div class="card-header center-align">
                        <h5>Mi Empresa: {{ $company->name}}</h5>
                    </div>
                    @if (Storage::disk('companies')->has($company->image))
                        <div class="card-image">
                            <img src="{{ route('companies.image', ['filename' => $company->image]) }}"
                                 class="materialboxed" data-caption="{{ $company->address }}" alt="" srcset=""
                                 style="max-height:350px;">
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
                            <div class="col s12 m6 center-align">
                                <a href="{{ route('companies.edit', ['id' => $company->id]) }}"
                                   class="btn blue btn-rounded waves-light">
                                    Más Detalles
                                    <i class="icon-more_horiz right"></i>
                                </a>
                            </div>

                            <div class="col s12 m6 center-align">
                                <a href="{{ route('companies.carnet', ['id' => $company->id]) }}"
                                   class="btn green btn-rounded waves-light col s12">
                                    Descargar Carnet
                                    <i class="icon-perm_contact_calendar right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @if($company->status!='disabled')
                {{-- Mostrar seccion si es administrador o no --}}
                <div class="col s12 m3" style="margin-top: -7px">
                    <div class="row">
                        @can('Declarar Actividad Económica')
                            <div class="col s12">

                                <a href="{{ route('companies.my-payments', ['company' => $company->name]) }}"
                                   class="btn-app white green-text">
                                    <i class="icon-payment"></i>
                                    <span class="truncate">Declaración/Act-Ecónomica</span>
                                </a>
                            </div>
                        @endcan
                        <div class="col s12">
                            <a href="{{ route('rate.taxpayers.company.create', ['company' => $company->id]) }}"
                               class="btn-app white green-text">
                                <i class="icon-picture_as_pdf"></i>
                                <span class="truncate">Declaración/Tasas</span>
                            </a>
                        </div>
                        <div class="col s12">
                            <a href="{{ route('company.vehicle.read', ['idCompany' => $company->id]) }}"
                               class="btn-app white purple-text">
                                <i class="icon-directions_car"></i>
                                <span class="truncate">Vehículos</span>
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
            @endif

        </div>
    </div>
@endsection