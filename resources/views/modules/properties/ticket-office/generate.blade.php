@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.home') }}">Taquilla - Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.ticket-office.manage') }}">Gestionar Pagos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.ticket-office.generate') }}">Generar Planilla</a></li>
                </ul>
            </div>
            <div class="col s12">
                <form action="{{--{{ route('properties.ticket-office.store') }}--}}" method="post" class="card" id="generate-payroll">
                    @csrf
                    <ul class="tabs">
                        <li class="tab col s6" id="one"><a href="#general-tab"><i class="icon-filter_1"></i> DATOS GENERALES</a></li>
                        <li class="tab col s6 disabled" id="two"><a href="#details-tab"><i class="icon-filter_2"></i>DETALLES</a></li>
                    </ul>

                    <div id="general-tab">
                        {{--<form action="--}}{{--{{ route('properties.ticket-office.store') }}--}}{{--" method="post" id="register-payroll">--}}
                        <div class="card-header center-align">
                            <h4>DATOS GENERALES</h4>
                        </div>
                        <div class="card-content row">
                            <input type="hidden" name="property_id" id="property_id">
                            <input type="hidden" name="user_id" id="user_id">
                            <input type="hidden" name="taxe_id" id="taxe_id">
                            <div class="input-field col s12">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="code_cadastral" id="code_cadastral" maxlength="35" class="validate code-only">
                                <label for="code_cadastral">Código Catastral</label>
                            </div>
                            {{--<div class="input-field col m6 s12">
                                <i class="icon-map prefix"></i>
                                <select name="value_cadastral_ground_id" id="value_cadastral_ground_id"  required disabled>
                                    <option value="null" disabled selected>Seleccionar ubicacion Catastral</option>
                                    @foreach($catastralTerreno as $terreno):
                                    <option value="{{ $terreno->id }}">{{ $terreno->name}}</option>
                                    @endforeach
                                </select>
                                <label>Ubicación Catastral</label>
                            </div>
                            <div class="input-field col m6 s12">
                                <i class="icon-domain prefix"></i>
                                <select name="value_cadastral_build_id[]" id="value_cadastral_build_id" required disabled multiple>
                                    <option value="null" disabled selected>Seleccionar Tipo de Construccion</option>
                                    @foreach($catastralConstruccion as $construccion):
                                    <option value="{{ $construccion->id }}">{{ $construccion->name}}</option>
                                    @endforeach
                                </select>
                                <label>Tipo de Construccion</label>
                            </div>--}}
                            <div class="input-field col s12 m6">
                                <i class="icon-panorama_horizontal prefix"></i>
                                <input type="text" name="area_ground" id="area_ground" class="validate number-only" pattern="[0-9.]+"
                                       data-tooltip="Solo puede usar números y caracter especial(.) . Ej: 15.47"
                                       required readonly>
                                <label for="area_ground">Area de Terreno</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-location_city prefix"></i>
                                <input type="text" name="area_build" id="area_build" class="validate number-only" pattern="[0-9.]+"
                                       data-tooltip="Solo puede usar números y caracter especial(.) . Ej: 15.47"
                                       required readonly>
                                <label for="area_build">Area de Construcción</label>
                            </div>
                            <div class="input-field col m6 s12">
                                <i class="icon-domain prefix"></i>
                                <select name="type_inmueble_id" id="type_inmueble_id" required disabled>
                                    <option value="null" disabled selected>Seleccionar Tipo de Inmueble</option>
                                    @foreach($alicuota as $value):
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                <label>Tipo de Inmueble</label>
                            </div>

                            <div class="input-field col m6 s12">
                                <i class="icon-satellite prefix"></i>
                                <select name="parish_id" id="parish_id" required disabled>
                                    <option value="null" disabled selected>Seleccionar una Parroquia</option>
                                    @foreach($parish as $parish):
                                    <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                                    @endforeach
                                </select>
                                <label>Parroquia</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-supervisor_account prefix"></i>
                                <input type="text" name="person" id="person" value="" readonly>
                                <label for="person">Usuario Web</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-directions prefix"></i>
                                <textarea name="address" id="address" cols="30" rows="12" class="materialize-textarea" required readonly></textarea>
                                <label for="address">Dirección</label>
                            </div>
                            @php
                                $cont=(int)date('Y');
                                $date=2019;
                            @endphp
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <select id="fiscal_period" name="fiscal_period" disabled>
                                    <option value="null" disabled selected>Seleccione un año...</option>
                                    @for($cont;$cont>=$date;$cont--)
                                        <option value="{{$cont.'-01-01'}}">{{$cont}}</option>
                                    @endfor
                                </select>
                                <label>Periodo Fiscal</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-supervisor_account prefix"></i>
                                <select name="status" id="status" disabled required>
                                    <option value="null" disabled>Selecciona la Forma de Pago</option>
                                    <option value="full" selected>Pago Completo Anual</option>
                                    {{--<option value="trimestral">Pago Trimestral</option>--}}
                                </select>
                                <label>Forma de Pago</label>
                            </div>
                        </div>
                        <div class="card-footer right-align">
                            <a href="#" class="btn peach waves-effect waves-light" id="general-next">
                                <i class="icon-navigate_next right"></i>
                                Siguiente
                            </a>
                        </div>
                    </div>
                    <div id="details-tab">
                        <div class="card-header center-align">
                            <h4>Detalles del Impuesto</h4>
                        </div>
                        <div class="card-content row">
                            {{--<input type="hidden" name="property_id" id="property_id" value="{{ $property[0]->id }}">--}}
                            <input type="hidden" name="owner_id" id="owner_id" value="">
                            {{--<input type="hidden" name="owner_type" id="owner_type" value="{{ $owner_type }}">--}}
                            {{--<input type="hidden" name="status" id="status" value="{{ $status }}">--}}
                            <input type="hidden" name="status" id="statusTax" value="">
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <label for="terrain_amount">Total por Terreno</label>
                                <input type="text" name="terrain_amount" id="terrain_amount" class="validate money" value="" readonly>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <label for="build_amount">Total por Construcción</label>
                                <input type="text" name="build_amount" id="build_amount" class="validate money" value="" readonly>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="fiscal_credit" id="fiscal_credit" class="validate money_keyup" maxlength="13">
                                <label for="fiscal_credit">Crédito Fiscal</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <label for="base_imponible">Base Imponible Total</label>
                                <input type="text" name="base_imponible" id="base_imponible" class="validate money" value="" readonly>
                            </div>
                            {{--<input type="hidden" name="alicuota" id="alicuota" value="">--}}
                            <input type="hidden" name="discount" id="discount" value="">
                            <div class="input-field col s12 m4">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <label for="interest">Interés por Mora:(Bs)</label>
                                <input type="text" name="interest" id="interest" class="validate money" value="" readonly>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <label for="recharge">Recargo Interes:(Bs)</label>
                                <input type="text" name="recharge" id="recharge" class="validate money" value="" readonly>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <label for="amount">Total a Pagar:(Bs)</label>
                                <input id="amount" type="text" name="amount" class="validate" value="" readonly>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" href="#" class="btn btn-rounded peach waves-effect waves-light modal-trigger ">
                                Continuar
                                <i class="icon-more_horiz right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/data/properties-ticket-office.js') }}"></script>
@endsection