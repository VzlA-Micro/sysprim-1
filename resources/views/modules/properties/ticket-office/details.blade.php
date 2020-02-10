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
                    <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.home') }}">Taquilla - Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.ticket-office.manage') }}">Gestionar Pagos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.ticket-office.payments.taxes') }}">Pagar Planillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.ticket-office.payments.details',['id' => $taxes->id]) }}">Detalles de Planilla</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <form method="post" action="{{ route('properties.taxes.store') }}" class="card" id="property-taxes">
                    <div class="card-header center-align">
                        <h4>Detalles de Planilla - Inmueble</h4>
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
                                <li><b>Codigo Catastral: </b>{{ $propertyTaxe->code_cadastral }}</li>
                            </ul>
                        </div>
                        <div class="col s12 m6">
                            <ul>
                                <li><b>Direccion: </b>{{ $propertyTaxe->address }}</li>
                                <li><b>Periodo Fiscal: {{ $taxes->fiscal_period }} </b></li>
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
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="totalGround" id="totalGround" class="validate money" value="{{ number_format($amounts['totalGround'],2,',','.') }}" readonly>
                            <label for="totalGround">Total por Terreno</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="totalBuild" id="totalBuild" class="validate money" value="{{ number_format($amounts['totalBuild'],2,',','.') }}" readonly>
                            <label for="totalBuild">Total por Construcción</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="fiscal_credit" id="fiscal_credit" class="validate" value="{{ number_format($propertyTaxe->pivot->fiscal_credit,2,',','.') }}" readonly>
                            <label for="fiscal_credit">Crédito Fiscal</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="base_imponible" id="base_imponible" class="validate money" value="{{ number_format($propertyTaxe->pivot->base_imponible,2,',','.') }}" readonly>
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
                                            <td>{{ $amounts['alicuota']->name }}</td>
                                            <td>{{ $amounts['alicuota']->value * 100 }}%</td>
                                            <td>{{ number_format($propertyTaxe->pivot->alicuota,2,',','.') }}</td>
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
                                                <td>PAGO COMPLETO (PRIMER MES DEL PRIMER TRIMESTRE)</td>
                                                <td>20%</td>
                                                <td>{{ number_format($propertyTaxe->pivot->discount,2,',','.') }}</td>
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
                                    <input type="hidden" name="alicuota" id="alicuota" value="{{ $propertyTaxe->pivot->alicuota }}">
                                    <input type="hidden" name="discount" id="discount" value="{{ $propertyTaxe->pivot->discount }}">
                                    <div class="row">
                                        <div class="input-field col s12 m12 ">
                                            <i class="prefix">
                                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                            </i>
                                            <input type="text" name="interest" id="interest" class="validate money" value="{{ number_format($propertyTaxe->pivot->interest,2,',','.') }}" readonly>
                                            <label for="interest">Interés por Mora:(Bs)</label>
                                        </div>
                                        <div class="input-field col s12 m12 ">
                                            <i class="prefix">
                                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                            </i>
                                            <input type="text" name="recharge" id="recharge" class="validate money" value="{{ number_format($propertyTaxe->pivot->recharge,2,',','.') }}" readonly>
                                            <label for="recharge">Recargo Interes:(Bs)</label>
                                        </div>
                                        <div class="input-field col s12 m12">
                                            <i class="prefix">
                                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                            </i>
                                            <input id="amount" type="text" name="amount" class="validate" value="{{ number_format($taxes->amount,2,',','.') }}" readonly>
                                            <label for="amount">Total a Pagar:(Bs)</label>
                                        </div>
                                        <input type="hidden" id="bank" name="bank" value="0">
                                        <input type="hidden" id="payments" name="payments" value="1">
                                        <input type="hidden" name="taxes_id" value="{{$taxes->id}}" id="taxes_id">
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
                            <div class="row">
                                @if($taxes->status=='process'||$taxes->status=='ticket-office'||$taxes->status=='temporal'||$taxes->status=='verified'||$taxes->status=='verified-sysprim')
                                    <div class="col s12">
                                        <h4 class="center-align">Acciones</h4>
                                    </div>
                                    @can('Anular Pagos')
                                        <div class="col s12 m4">
                                            <a href="#" class="btn red waves-effect waves-ligt reconcile" data-status="cancel">
                                                ANULAR PLANILLA.
                                                <i class="icon-close right"></i>
                                            </a>
                                        </div>
                                    @endcan
                                    @can('Verificar Pagos - Manual')
                                        @if( $taxes->status!='verified' && $verified && $taxes->status!='verified-sysprim' )
                                            <div class="col s12 m4">
                                                <a href="#" class="btn blue waves-effect waves-light reconcile" data-status="verified">
                                                    VERIFICAR PLANILLA.
                                                    <i class="icon-verified_user right"></i>
                                                </a>
                                            </div>
                                        @endif
                                    @endcan
                                    @if($taxes->status=='verified'||$taxes->status=='verified-sysprim')
                                        <div class="col s12 m4">
                                            <button type="button" id="send-email-verified" class="btn green waves-effect waves-light" value="{{$taxes->id}}">
                                                Enviar Correo Verificado.
                                                <i class="icon-mail_outline right"></i>
                                            </button>
                                        </div>
                                    @endif
                                    @if($taxes->status!='cancel')
                                        <div class="col s12 m4">
                                            <a href="{{route('ticket-office.download.pdf',['id'=>$taxes->id])}}" id="#" class="btn red darken-4 waves-effect waves-light" target="_blank" >Ver Planilla(PDF).
                                                <i class="icon-picture_as_pdf right"></i>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer center-align">
                        {{--<a href="" class="btn btn-rounded peach waves-effect waves-light">
                            Calcular de nuevo
                            <i class="icon-refresh right"></i>
                        </a>
                        <button type="submit" href="#" class="btn btn-rounded peach waves-effect waves-light modal-trigger ">
                            Continuar
                            <i class="icon-more_horiz right"></i>
                        </button>--}}
                    <div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/taxesProperty.js') }}"></script>
    <script src="{{ asset('js/dev/payments.js') }}"></script>

@endsection