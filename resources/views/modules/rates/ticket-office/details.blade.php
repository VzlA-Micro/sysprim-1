@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

                <div class="col s12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>>
                        <li class="breadcrumb-item"><a href="{{ route('ticket-office.pay.web') }}" class="prev-view">Lista de Planillas</a></li>
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
                        <div class="col m12 center-align">
                            <h5> Código:<b> {{$taxes->code}}</b></h5>
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


                                    @if(!$taxes->payments->isEmpty())
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
                                                        @elseif($taxe->status=='verified'||$taxe->status=='verified-sysprim')
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
                                    <div class="row ">
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
                                        @elseif($taxes->status==='verified' ||$taxes->status==='verified-sysprim')

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

                                        @if($taxes->status=='process'||$taxes->status=='ticket-office'||$taxes->status=='temporal'||$taxes->status=='verified'||$taxes->status=='verified-sysprim')

                                            <div class="col l12">
                                                <h4 class="center-align mt-2">Acciones</h4>
                                            </div>

                                            <div class="input-field col s12">

                                                @can('Anular Pagos')
                                                    <a href="#"
                                                       class="btn btn-rounded col s3 red waves-effect waves-ligt reconcile"
                                                       data-status="cancel">
                                                        ANULAR PLANILLA.
                                                        <i class="icon-close right"></i>
                                                    </a>
                                                @endcan
                                                @can('Verificar Pagos - Manual')
                                                    @if($verified&&$taxes->status!=='verified'&&$taxes->status!='verified-sysprim')
                                                        <a href="#"
                                                           class="btn btn-rounded col s3 blue waves-effect waves-light reconcile"
                                                           data-status="verified">
                                                            VERIFICAR PLANILLA.
                                                            <i class="icon-verified_user right"></i>
                                                        </a>
                                                    @endif
                                                @endcan
                                                @if($taxes->status=='verified'||$taxes->status=='verified-sysprim')
                                                    <button type="button" id="send-email-verified"
                                                            class="btn btn-rounded col s3 green waves-effect waves-light"
                                                            value="{{$taxes->id}}">Enviar Correo Verificado.
                                                        <i class="icon-send right"></i>
                                                    </button>
                                                @endif
                                                    @can('Ver Planilla PDF')
                                                    @if($taxes->status!='cancel')
                                                        <a href="{{route('ticket-office.download.pdf',['id'=>$taxes->id])}}" id="#"
                                                           class="btn btn-rounded col s3 red darken-4 waves-effect waves-light" target="_blank" >Ver Planilla (PDF).
                                                            <i class="icon-picture_as_pdf right"></i>
                                                        </a>
                                                    @endif
                                                    @endcan
                                            </div>
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
    <script src="{{ asset('js/dev/payments.js') }}"></script>
    <script src="{{ asset('js/dev/taxes.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection