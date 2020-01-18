@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

                <div class="col s12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('rate.taxpayers.menu')}}">Gestión de Tasas</a></li>
                        <li class="breadcrumb-item"><a href="{{route('rate.taxpayers.register')}}">Declarar Tasa</a></li>
                        <li class="breadcrumb-item"><a href="{{route('rate.taxpayers.details',['id'=>$taxes->id])}}">Detalles de Autoliquidación</a></li>
                    </ul>
                </div>

            <div class="col s12 m10 offset-m1">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Resumen de Autoliquidación Tasa.</h5>
                    </div>
                    <div class="row padding-2 left-align">
                        <div class="col m6">
                            <h5>Datos Generales.</h5>
                            <ul>

                                @if($type=='user')
                                <li><b>Nombre: </b>{{ $data->name.' '.$data->surname}}</li>
                                <li><b>RIF O Cedula: </b>{{ $data->ci }}</li>
                                <li><b>Dirección: </b>{{ $data->address }}</li>
                                <li><b>Fecha: </b>{{ $taxes->created_at->format('d-m-Y') }}</li>
                                @else
                                    <li><b>Nombre: </b>{{ $data->name}}</li>
                                    <li><b>RIF O Cedula: </b>{{ $data->RIF }}</li>
                                    <li><b>Dirección: </b>{{ $data->address }}</li>
                                    <li><b>Fecha: </b>{{ $taxes->created_at->format('d-m-Y') }}</li>
                                @endif

                            </ul>


                        </div>
                        <div class="col m6">

                        </div>
                    </div>




                    <div class="divider"></div>
                    <div class="card-header center-align">
                        <h5>Detalles de Tasa</h5>
                    </div>
                    <form method="post" action="#" id='register-taxes'
                          class="card-content row">
                        @csrf
                        @foreach($taxes->rateTaxes as $rate)

                            <div class="input-field col s12 m6">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="code" id="code_{{$rate->code}}" class="code" value="{{ $rate->code }}"
                                       required readonly>
                                <label for="code_{{$rate->code}}">Código</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-assignment prefix"></i>
                                <input type="text" name="rate" id="rate_{{$rate->code}}" value="{{ $rate->name }}" required readonly>
                                <label for="rate_{{$rate->code}}">Tasa</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="cant_tax_unit[]" id="cant_tax_unit_{{$rate->code}}" class="validate"
                                       value="{{ $rate->cant_tax_unit }}" readonly>
                                <label for="cant_tax_unit_{{$rate->code}}">Cantidad U.T</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="total_ciu[]" id="total{{$rate->code}}" class="validate total_ciu money"
                                       pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{$rate->totalRate}}" readonly>
                                <label for="mount_{{$rate->code}}">Impuesto Causado <b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12">
                                    <div class="divider"></div>
                            </div>

                        @endforeach

                        <div class="col l12 s12">
                            <div class="col l6 s12">
                                <table class="centered responsive-table" style="font-size: 10px;!important;">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="col s12">
                                </div>

                            </div>

                            <div class="col l6 s12">

                                <div class=" input-field col s12 m12 ">
                                    <i class=" prefix">
                                        <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                    </i>
                                    <input type="text" name="total" class="validate total money"
                                           value="{{$taxes->amount}}" readonly>
                                    <label for="total_pagar">Total a Pagar:(Bs)</label>
                                </div>
                                <input type="hidden" name="taxes_id" value="{{$taxes->id}}" id="taxes_id">
                            </div>


                            <div class="row" style="padding: 1rem">
                                <div class="input-field col s12">
                                    {{-- Modal trigger --}}
                                    @if($taxes->status!='verified')
                                        <a href="{{ route('rate.taxpayers.calculate',['id'=>$taxes->id]) }}"
                                           class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger">
                                            Calcular de nuevo
                                            <i class="icon-refresh right"></i></a>

                                        <!-- <a href="#" id="download-calculate"  class="btn btn-rounded col s4 peach waves-effect waves-light modal-trigger">
                                             Descargar Calculo.
                                             <i class="icon-cloud_download right"></i>
                                         </a>-->
                                        <a href="{{ route('rate.taxpayers.typePayment',['id'=>$taxes->id]) }}"  class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger" id="continue">
                                            Continuar
                                            <i class="icon-more_horiz right"></i>
                                        {{-- Modal structure --}}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/taxes.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection