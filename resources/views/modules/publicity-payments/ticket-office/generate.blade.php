@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.publicity.home') }}">Taquilla - Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.ticket-office.manage') }}">Gestionar Pagos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.ticket-office.generate') }}">Generar Planilla</a></li>
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
                            <input type="hidden" name="publicity_id" id="publicity_id">
                            <input type="hidden" name="user_id" id="user_id">
                            <input type="hidden" name="taxe_id" id="taxe_id">
                            <div class="input-field col s12">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="code" id="code" maxlength="12" class="validate code-only">
                                <label for="code">Código de Publicidad</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-linked_camera prefix"></i>
                                <select name="advertising_type_id" id="advertising_type_id" disabled>
                                    <option value="null" disabled selected>Elija un tipo</option>
                                    @foreach($advertisingTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-format_size prefix"></i>
                                <input type="text" name="name" id="name" disabled>
                                <label for="name">Nombre</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_start" id="date_start" class="datepicker date_start" disabled>
                                <label for="date_start">Fecha de Inicio</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_end" id="date_end" class="datepicker" disabled>
                                <label for="date_end">Fecha de Fin</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-supervisor_account prefix"></i>
                                <input type="text" name="person" id="person" value="" readonly>
                                <label for="person">Usuario Web</label>
                            </div>
                            {{--<div class="input-field col s12 m6">--}}
                                {{--<i class="icon-directions prefix"></i>--}}
                                {{--<textarea name="address" id="address" cols="30" rows="12" class="materialize-textarea" required readonly></textarea>--}}
                                {{--<label for="address">Dirección</label>--}}
                            {{--</div>--}}
                            @php
                                $cont=(int)date('Y');
                            @endphp
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <select id="fiscal_period" disabled >
                                    <option value="null" disabled selected>Seleccione</option>
                                    @while($cont >= 2010)
                                        <option value="{{$cont.'-01-01'}}">{{$cont}}</option>
                                        @php $cont--; @endphp
                                    @endwhile
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
                            <div class="input-field col s8 m9">
                                <i class="icon-confirmation_number prefix"></i>
                                <select name="advertising_type_id" id="advertising_type_id" disabled>
                                    <option value="null" disabled>Elija un tipo</option>
                                    @foreach($advertisingTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="icon-assignment prefix"></i>
                                <input type="text" name="value" id="value" value="" readonly>
                                <label for="value">Valor U.T</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="base_imponible" id="base_imponible" value="" readonly required>
                                <label for="base_imponible">Base Imponible<b> (Bs)</b></label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                                </i>
                                <input type="text" name="increment" id="increment" class="validate money" value="" readonly required>
                                <label for="increment">Incremento</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="fiscal_credit" id="fiscal_credit" class="validate money_keyup" maxlength="13">
                                <label for="fiscal_credit">Crédito Fiscal</label>
                            </div>
                            <div class="input-field col s12">
                                <div class="divider"></div>
                            </div>
                            <div class="col s12">
                                <div class="row">
                                    <div class="col s12 m6">
                                        {{--<table class="centered responsive-table" style="font-size: 10px;!important;">
                                            <thead>
                                            <tr>
                                                <th>TIPO DE PUBLICIDAD</th>
                                                <th>TARIFA (U.T)</th>
                                                @if($publicity->advertisingType->id == 1)
                                                    <th>DÍAS DE EXHIBICIÓN</th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{ $publicity->advertisingType->name }}</td>
                                                <td>{{ $publicity->advertisingType->value }}</td>
                                                @if($publicity->advertisingType->id == 1)
                                                    <td>{{ $daysDiff }}</td>
                                                @endif
                                            </tr>
                                            </tbody>
                                        </table>--}}
                                    </div>
                                    <div class="col s12 m6">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" name="amount" id="amount" class="validate" value="" readonly required>
                                                <label for="amount">Total a Pagar:(Bs)</label>
                                            </div>
                                            <div class="col s12"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer center-align">
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
    <script src="{{ asset('js/data/publicity-ticket-office-payments.js') }}"></script>
@endsection