@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    @if(session()->has('company'))
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.details', ['id' => session('company')->id]) }}">{{ session('company')->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="{{ route('properties.my-properties') }}">Mis Inmuebles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.details', ['id' => $property[0]->id]) }}">{{ $property[0]->code_cadastral }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.payments.manage',['id' => $property[0]->id]) }}">Mis Declaraciones</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.payments.create', ['id' => $property[0]->id]) }}">Declarar Inmueble</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <form method="post" action="{{ route('properties.taxes.store') }}" class="card" id="property-taxes">
                    <div class="card-header center-align">
                        <h4>Resumen de Autoliquidación - Inmueble</h4>
                    </div>
                    <div class="card-content row">
                        <div class="col s12 m6">
                            <ul>
                                @if($owner_type == 'user')
                                <li><b>Propietario: </b>{{ $owner->name . ' ' . $owner->surname }}</li>
                                <li><b>Cédula: </b>{{ $owner->ci }}</li>
                                @elseif($owner_type == 'company')
                                <li><b>Propietario: </b>{{ $owner->name }}</li>
                                <li><b>RIF: </b>{{ $owner->RIF }}</li>
                                @endif
                                <li><b>Codigo Catastral: </b>{{ $property[0]->code_cadastral }}</li>
                            </ul>
                        </div>
                        <div class="col s12 m6">
                            <ul>
                                <li><b>Direccion: </b>{{ $property[0]->address }}</li>
                                <li><b>Periodo Fiscal: {{ $response['period'] }} </b></li>
                            </ul>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="card-header center-align">
                        <h4>Detalles del Impuesto</h4>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <input type="hidden" name="property_id" id="property_id" value="{{ $property[0]->id }}">
                        <input type="hidden" name="owner_id" id="owner_id" value="{{ $owner->id }}">
                        <input type="hidden" name="owner_type" id="owner_type" value="{{ $owner_type }}">
                        <input type="hidden" name="status" id="status" value="{{ $status }}">
                        {{--<input type="hidden" name="totalGround" id="totalGround" class="validate money" value="" readonly>--}}
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="totalGround" id="totalGround" class="validate money" value="{{ $totalGround }}" readonly>
                            <label for="totalGround">Total por Terreno</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="totalBuild" id="totalBuild" class="validate money" value="{{ $totalBuild }}" readonly>
                            <label for="totalBuild">Total por Construcción</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="withholding" id="withholdings" class="validate money" value="0" readonly>
                            <label for="withholdings">Exedente</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="base_imponible" id="base_imponible" class="validate money" value="{{ $baseImponible }}" readonly>
                            <label for="base_imponible">Base Imponible Total</label>
                        </div>
                        <div class="col s12">
                            <div class="row">
                                <div class="col s12 m6">
                                    <table class="centered" style="font-size: 10px;!important;">
                                        <thead>
                                            <tr>
                                                <th>ALICUOTA</th>
                                                <th>VALOR</th>
                                                <th>COSTO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $response['declaration']['alicuota']->name }}</td>
                                                <td>{{ $response['declaration']['alicuota']->value * 100 }}%</td>
                                                <td>{{ $discount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @if($status == 'full')
                                        <table class="centered" style="font-size: 10px;!important;">
                                            <thead>
                                            <tr>
                                                <th>DESCUENTO</th>
                                                <th>VALOR</th>
                                                <th>COSTO</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>PAGO COMPLETO (PRIMER TRIMESTRE)</td>
                                                <td>20%</td>
                                                <td>{{ number_format($response['declaration']['discount'],2,',','.') }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                    {{--<div class="row" style="margin-top: 1rem">
                                        <div class="col s12 m6 ">
                                            <button type="button" id="fraccionado"
                                                    class="btn btn-rounded peach waves-effect waves-light ">Pago Fraccionado
                                            </button>
                                        </div>
                                        <div class="col s12 m6 ">
                                            <button type="button" id="descuento"
                                                    class="btn btn-rounded peach waves-effect waves-light ">20% Descuento
                                            </button>
                                        </div>
                                    </div>--}}
                                </div>
                                <div class="col s12 m6">
                                    <input type="hidden" name="alicuota" id="alicuota" value="{{ $response['declaration']['porcentaje'] }}">
                                    <input type="hidden" name="discount" id="discount" value="{{ $response['declaration']['discount'] }}">
                                    <div class="row">
                                        <div class="input-field col s12 m12 ">
                                            <i class="prefix">
                                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                            </i>
                                            <input type="text" name="interest" id="interest" class="validate money" value="{{ number_format($response['declaration']['interest'],2,',','.') }}" readonly>
                                            <label for="interest">Interés por Mora:(Bs)</label>
                                        </div>
                                        <div class="input-field col s12 m12 ">
                                            <i class="prefix">
                                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                            </i>
                                            <input type="text" name="recharge" id="recharge" class="validate money" value="{{ number_format($response['declaration']['recharge'],2,',','.') }}" readonly>
                                            <label for="recharge">Recargo Interes:(Bs)</label>
                                        </div>
                                        <div class="input-field col s12 m12">
                                            <i class="prefix">
                                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                            </i>
                                            <input id="amount" type="text" name="amount" class="validate" value="{{ $total }}" readonly>
                                            <label for="amount">Total a Pagar:(Bs)</label>
                                        </div>
                                        <input type="hidden" id="bank" name="bank" value="0">
                                        <input type="hidden" id="payments" name="payments" value="1">
                                        <input type="hidden" name="taxes_id" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer center-align">
                        <a href="" class="btn btn-rounded peach waves-effect waves-light">
                            Calcular de nuevo
                            <i class="icon-refresh right"></i>
                        </a>
                        <button type="submit" href="#" class="btn btn-rounded peach waves-effect waves-light modal-trigger ">
                            Continuar
                            <i class="icon-more_horiz right"></i>
                        </button>

                    <div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/taxesProperty.js') }}"></script>
@endsection