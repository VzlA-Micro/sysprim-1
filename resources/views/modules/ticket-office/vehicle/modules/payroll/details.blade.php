@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.manage') }}">Gestionar Pagos</a></li>
                    <li class="breadcrumb-item"><a href="#" class="prev-view" >Ver Pagos</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Detalles de Planilla</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Resumen de Autoliquidación</h5>
                        <h5> Periodo Fiscal:<span>{{$response['taxes']->fiscal_period." - ".$response['taxes']->fiscal_period_end}}</span></h5>
                        <h5> Código:<b> {{$response['taxes']->code}}</b></h5>
                    </div>
                    <div class="row padding-2 left-align">
                        <div class="col m6">
                            <ul>
                                <li><b>Placa: </b>{{ $response['vehicle'][0]->license_plate }}</li>
                                <li><b>Color: </b>{{ $response['vehicle'][0]->color }}</li>
                                <li><b>Marca: </b>{{ $response['model']->brand->name }}</li>
                                <li><b>Modelo:</b>{{ $response['model']->name}} </li>
                                <li><b>Fecha: </b>{{ $response['taxes']->created_at->format('d-m-Y') }}</li>
                            </ul>
                            <ul>
                            </ul>
                        </div>
                        <div class="col m6">

                        </div>
                    </div>

                    <div class="divider"></div>
                    <div class="card-header center-align">
                        <h5>Detalles de Patente de Vehículo</h5>
                    </div>
                    <form method="post" action="{{ route('company.taxes.save')}}" id='register-taxes'
                          class="card-content row">
                        @csrf
                        <input type="hidden" name="taxe_id" id="taxes_id" value="{{$response['taxes']->id}}">
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="base" id="base" class="validate money"
                                   value="{{$response['vehicleTaxes'][0]->base_imponible}}"
                                   readonly>
                            <label for="base">Base Imponible<b> (Bs)</b></label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="previous_debt" id="previous_debt" class="validate recargo money"
                                   pattern="^[0-9]{0,12}([.][0-9]{2,2})?$"
                                   value="{{$response['vehicleTaxes'][0]->previous_debt}}" readonly>
                            <label for="previous_debt">Deuda Anterior<b> (Bs)</b></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="discount" id="discount" class="validate money"
                                   value="{{$response['vehicleTaxes'][0]->discount}}"
                                   readonly>
                            <label for="discount">Descuento<b> (Bs)</b></label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="recharge" id="recharge" class="validate money"
                                   pattern="[0-9.,]+"
                                   value="{{$response['vehicleTaxes'][0]->recharge}}"
                                   readonly>
                            <label for="recharge">Recargo<b> (Bs)</b></label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="rechargeMora" id="rechargeMora" class="validate money"
                                   pattern="[0-9.,]+"
                                   value="{{$response['vehicleTaxes'][0]->recharge_mora}}"
                                   readonly>
                            <label for="rechargeMora">Interés por mora<b> (Bs)</b></label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="fiscal_credits" id="fiscal_credits"
                                   class="validate number-only" readonly pattern="[0-9.,]+"
                                   value="{{$response['vehicleTaxes'][0]->fiscal_credits}}"
                            >
                            <label for="fiscal_credits">Credito fiscal<b> (Bs)</b></label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="total" id="total"
                                   class="validate number-only" pattern="[0-9.,]+"
                                   value="{{number_format($response['taxes']->amount,2, ',', '.')}}"
                            >
                            <label for="fiscal_credits">Total<b> (Bs)</b></label>
                        </div>

                            <div class="row" style="padding: 1rem">
                                <div class="input-field col s12">
                                    <!-- Modal trigger -->
                                    @if(!$response['taxes']->payments->isEmpty())
                                        <h4 class="center-align">Registro de Pago:</h4>
                                        <table class="centered highlight responsive-table" id="payments">
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
                                            @foreach($response['taxes']->payments as $taxe)
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
                                            @if($response['taxes']->status==='ticket-office')
                                                <a class="btn green col s12 ">
                                                    <i class="icon-more_horiz left "></i>
                                                    ESTADO: SIN PROCESAR AÚN
                                                </a>

                                            @elseif($response['taxes']->status==='process')
                                                <a href="#" class="btn green col s12">
                                                    <i class="icon-more_horiz left "></i>
                                                    ESTADO: SIN CONCILIAR AÚN

                                                </a>
                                            @elseif($response['taxes']->status==='verified')

                                                <a href="#" class="btn blue col s12">
                                                    <i class="icon-more_horiz left"></i>
                                                    ESTADO: VERIFICADA.
                                                </a>


                                            @elseif($response['taxes']->status=='cancel')

                                                <a href="#" class="btn red col s12">
                                                    <i class="icon-more_horiz left"></i>
                                                    ESTADO: CANCELADA.
                                                </a>
                                            @endif

                                            @if($response['taxes']->status=='process'||$response['taxes']->status=='ticket-office'||$response['taxes']->status=='temporal'||$response['taxes']->status=='verified')

                                                <div class="col l12">
                                                    <h4 class="center-align mt-2">Acciones</h4>
                                                </div>


                                                <div class="input-field col s12">

                                                    @can('Anular Pagos')
                                                        <a href="#"
                                                           class="btn col s12 m6 red waves-effect waves-ligt reconcile"
                                                           data-status="cancel" style="margin-top:10px;">
                                                            ANULAR PLANILLA.
                                                            <i class="icon-close right"></i>
                                                        </a>
                                                    @endcan
                                                    @can('Verificar Pagos - Manual')
                                                        @if($response['verified']&&$response['taxes']->status!=='verified')
                                                            <a href="#"
                                                               class="btn col s12 m6 blue waves-effect waves-light reconcile"
                                                               data-status="verified" style="margin-top:10px;">
                                                                VERIFICAR PLANILLA.
                                                                <i class="icon-verified_user right"></i>
                                                            </a>
                                                        @endif
                                                    @endcan
                                                    @if($response['taxes']->status=='verified')
                                                        <button type="button" id="send-email-verified"
                                                                class="btn col s12 m6 green waves-effect waves-light"
                                                                value="{{$response['taxes']->id}}" style="margin-top:10px;">Enviar Correo Verificado.
                                                            <i class="icon-send right"></i>
                                                        </button>
                                                    @endif

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
    <script src="{{ asset('js/dev/taxes.js') }}"></script>
    <script src="{{ asset('js/dev/payments.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection