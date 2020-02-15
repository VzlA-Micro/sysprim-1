@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.publicity.home') }}">Taquilla - Publicidad</a></li>
                    @if(session()->has('property'))
                        <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.read-property') }}">Consultar Inmuebles Urbanos</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.details-property',['id' => $property->id]) }}">Detalles del Inmueble</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('properties.ticket-office.property-taxes',['id'=>$property->id]) }}">Registro de Pagos</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('publicity.ticket-office.manage') }}">Gestionar Pagos</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('publicity.ticket-office.payments.taxes') }}">Pagar Planillas</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="{{ route('publicity.ticket-office.payments.details',['id' => $taxes->id]) }}">Detalles de Planilla</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <form method="post" action="{{ route('properties.taxes.store') }}" class="card" id="property-taxes">
                    <div class="card-header center-align">
                        <h4>Detalles de Planilla - Prop. y Publicidad</h4>
                    </div>
                    <div class="card-content row">
                        <div class="col s12 m6">
                            <ul>
                                @if($type == 'user')
                                    <li><b>Propietario: </b>{{ $owner->name . ' ' . $owner->surname }}</li>
                                    <li><b>Cédula: </b>{{ $owner->ci }}</li>
                                @elseif($type == 'company')
                                    <li><b>Propietario: </b>{{ $owner->name }}</li>
                                    <li><b>RIF: </b>{{ $owner->RIF }}</li>
                                @endif
                                {{-- <li><b>Tipo de Publicidad </b>{{ $publicity->advertisingType->name }}</li> --}}
                                    <li><b>Código de Publicidad: </b>{{ $publicity->code }}</li>
                                    <li><b>Nombre: </b>{{ $publicity->name }}</li>

                            </ul>
                        </div>
                        <div class="col s12 m6">
                            <ul>
                                <li><b>Fecha de Inicio: </b>{{ $publicity->date_start }}</li>
                                <li><b>Fecha de Fin: </b>{{ $publicity->date_end }}</li>
                                {{--<li><b>Direccion: </b>{{ $property[0]->address }}</li>--}}
                                {{--<li><b>Periodo Fiscal: {{ $response['period'] }} </b></li>--}}
                            </ul>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="card-header center-align">
                        <h4>Detalles del Impuesto</h4>
                    </div>
                    <div class="card-content row">
                        @csrf
                        {{--<input type="hidden" name="property_id" id="property_id" value="{{ $property[0]->id }}">
                        <input type="hidden" name="owner_id" id="owner_id" value="{{ $owner->id }}">
                        <input type="hidden" name="owner_type" id="owner_type" value="{{ $owner_type }}">
                        <input type="hidden" name="status" id="status" value="{{ $status }}">--}}
                        {{--<input type="hidden" name="totalGround" id="totalGround" class="validate money" value="" readonly>--}}
                        <input type="hidden" name="publicity_id" id="publicity_id" value="{{ $publicity->id }}">
                        <div class="input-field col s12 m9">
                            <i class="icon-confirmation_number prefix"></i>
                            <select name="advertising_type_id" id="advertising_type_id" disabled>
                                <option value="null" disabled selected>Elija un tipo</option>
                                @foreach($advertisingTypes as $type)
                                    <option value="{{ $type->id }}" @if($publicity->advertising_type_id == $type->id){{ "selected" }} @endif>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <label>Tipo de Publicidad</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <i class="icon-assignment prefix"></i>
                            <input type="text" name="value" id="value" value="{{ $publicity->advertisingType->value }}" readonly>
                            <label for="value">Valor U.T</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="base_imponible" id="base_imponible" value="{{ number_format($publicityTaxe->pivot->base_imponible,2,',','.') }}" readonly>
                            <label for="base_imponible">Base Imponible<b> (Bs)</b></label>
                        </div>
                        {{--<div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input type="text" name="interest" id="interest" class="validate money" value="{{ $interest }}" readonly>
                            <label for="interest">Interés por Mora:(Bs)</label>
                        </div>--}}
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input type="text" name="increment" id="increment" class="validate money" value="{{ number_format($publicityTaxe->pivot->increment,2,',','.') }}" readonly>
                            <label for="increment">Incremento</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input type="text" name="fiscal_credit" id="fiscal_credit" class="validate money_keyup" value="{{ number_format($publicityTaxe->pivot->fiscal_credit,2,',','.') }}" readonly>
                            <label for="fiscal_credit">Crédito Fiscal</label>
                        </div>
                        <div class="input-field col s12">
                            <div class="divider"></div>
                        </div>
                        <div class="col s12">
                            <div class="row">
                                <div class="col s12 m6">
                                    <table class="centered responsive-table" style="font-size: 10px;!important;">
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

                                        {{--<thead>--}}
                                        {{--<tr>--}}
                                        {{--<th>RECARGO</th>--}}
                                        {{--<th>VALOR</th>--}}
                                        {{--</tr>--}}
                                        {{--</thead>--}}
                                        {{--<tbody>--}}
                                        {{--<tr>--}}
                                        {{--<td>{{'20%'}}</td>--}}
                                        {{--<td>{{$recharge}}</td>--}}
                                        {{--</tr>--}}
                                        {{--</tbody>--}}
                                    </table>
                                    @if($publicity->licor == "SI")
                                        <table class="centered responsive-table" style="font-size: 10px;!important;">
                                            <thead>
                                            <tr>
                                                <th>REFERENTE A LICORES O CIGARRILLOS</th>
                                                <th>TARIFA (U.T)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{ $publicity->licor }}</td>
                                                <td>5000UT</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                    @if($publicity->state_location == "SI")
                                        <table class="centered responsive-table" style="font-size: 10px;!important;">
                                            <thead>
                                            <tr>
                                                <th>UBICADO EN ESPACIOS RESERVADOS DE LA ALCALDÍA</th>
                                                <th>TARIFA (U.T)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{ $publicity->state_location }}</td>
                                                <td>5000UT</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                                <div class="col s12 m6">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input type="text" name="amount" id="amount" class="validate" value="{{ number_format($taxes->amount,2,',','.') }}" readonly>
                                            <label for="amount">Total a Pagar:(Bs)</label>
                                        </div>
                                        <input type="hidden" id="bank" name="bank" value="0">
                                        <input type="hidden" id="payments" name="payments" value="1">
                                        <input type="hidden" name="taxes_id" value="{{$taxes->id}}" id="taxes_id">
                                        <div class="col s12"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            @if($taxes != null)
                                <h4 class="center-align">Registro de Pago:</h4>
                                <table class="centered highlight" id="payments" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Código</th>
                                        <th>Forma de Pago</th>
                                        <th>Status</th>
                                        <th>Ref o Código</th>
                                        <th>Monto</th>
                                        <th>Acción</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($taxes->payments as $taxe)
                                        <tr>
                                            <td>{{$taxe->created_at->format('d-m-Y')}}</td>
                                            <td>{{$taxe->code}}</td>
                                            <td>{{$taxe->type_payment}}</td>
                                            <td>{{$taxe->statusName}}</td>
                                            <td>{{$taxe->ref}}</td>
                                            <td>{{number_format($taxe->amount,2)." Bs"}}</td>
                                            <td>
                                                @if($taxe->status==='cancel')
                                                    <div class="input-field col s12 m12">
                                                        <button type="button"
                                                                class="btn waves-effect waves-light  col s12 red"
                                                                value="">
                                                            <i class="icon-do_not_disturb_alt"></i></button>
                                                    </div>
                                                @elseif($taxe->status=='verified'||$taxes->status=='verified-sysprim')
                                                    <div class="input-field col s12 m12">
                                                        <button type="button"
                                                                class="btn waves-effect waves-light green col s12"
                                                                value="#" data-status="#">
                                                            <i class="icon-check"></i></button>
                                                    </div>
                                                @else
                                                    <div class="input-field col s12 m6">
                                                        <button type="button"
                                                                class="change-status btn waves-effect waves-light green col s12"
                                                                value="{{$taxe->id}}" data-status="verified">
                                                            <i class="icon-check"></i></button>
                                                    </div>
                                                    <div class="input-field col s12 m6">
                                                        <button type="button"
                                                                class="change-status btn waves-effect waves-light red col s12"
                                                                value="{{$taxe->id}}" data-status="cancel">
                                                            <i class="icon-cancel"></i></button>
                                                    </div>
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="col s12">
                            <div class="row">
                                @if($taxes->status==='ticket-office')
                                    <a class="btn green col s12 ">
                                        <i class="icon-more_horiz left "></i>
                                        ESTADO: SIN PROCESAR AÚN
                                    </a>
                                @elseif($taxes->status==='process')
                                    <a href="#" class="btn green col s12">
                                        <i class="icon-more_horiz left "></i>
                                        ESTADO: SIN CONCILIAR AÚN
                                    </a>
                                @elseif($taxes->status==='verified'||$taxes->status=='verified-sysprim')
                                    <a href="#" class="btn blue col s12">
                                        <i class="icon-more_horiz left"></i>
                                        ESTADO: VERIFICADA.
                                    </a>
                                @elseif($taxes->status=='cancel')
                                    <a href="#" class="btn red col s12">
                                        <i class="icon-more_horiz left"></i>
                                        ESTADO: CANCELADA.
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer center-align">
                        <div class="row">
                            @if($taxes->status=='process'||$taxes->status=='ticket-office'||$taxes->status=='temporal'||$taxes->status=='verified'||$taxes->status=='verified-sysprim')
                                <div class="col s12">
                                    <h4 class="center-align">Acciones</h4>
                                </div>
                                @can('Anular Pagos')
                                    <div class="col s12 m4 center-align" style="margin-top:10px">
                                        <a href="#" class="btn red waves-effect waves-ligt reconcile" data-status="cancel">
                                            ANULAR PLANILLA.
                                            <i class="icon-close right"></i>
                                        </a>
                                    </div>
                                @endcan
                                @can('Verificar Pagos - Manual')
                                    @if( $taxes->status!='verified' && $verified && $taxes->status!='verified-sysprim' )
                                        <div class="col s12 m4 center-align" style="margin-top:10px">
                                            <a href="#" class="btn blue waves-effect waves-light reconcile" data-status="verified">
                                                VERIFICAR PLANILLA.
                                                <i class="icon-verified_user right"></i>
                                            </a>
                                        </div>
                                    @endif
                                @endcan
                                @if($taxes->status=='verified'||$taxes->status=='verified-sysprim')
                                    <div class="col s12 m4 center-align" style="margin-top:10px">
                                        <button type="button" id="send-email-verified" class="btn green waves-effect waves-light" value="{{$taxes->id}}">
                                            Enviar Correo Verificado.
                                            <i class="icon-mail_outline right"></i>
                                        </button>
                                    </div>
                                @endif
                                @if($taxes->status!='cancel')
                                    <div class="col s12 m4 center-align" style="margin-top:10px">
                                        <a href="{{route('ticket-office.download.pdf',['id'=>$taxes->id])}}" id="#" class="btn red darken-4 waves-effect waves-light" target="_blank" >Ver Planilla(PDF).
                                            <i class="icon-picture_as_pdf right"></i>
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/publicity-.js') }}"></script>
    <script src="{{ asset('js/dev/payments.js') }}"></script>

@endsection