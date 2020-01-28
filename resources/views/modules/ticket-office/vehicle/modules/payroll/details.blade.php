@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li>
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
                        <h5> Periodo Fiscal:<span></span></h5>
                        <h5> Código:<b> {{$response['taxes'][0]->code}}</b></h5>
                    </div>
                    <div class="row padding-2 left-align">
                        <div class="col m6">
                            <ul>
                                <li><b>Placa: </b>{{ $response['vehicle'][0]->license_plate }}</li>
                                <li><b>Color: </b>{{ $response['vehicle'][0]->color }}</li>
                                <li><b>Marca: </b>{{ $response['model']->brand->name }}</li>
                                <li><b>Modelo: </b>{{ $response['model']->name}} </li>
                                <li><b>Fecha: </b>{{ $response['taxes'][0]->created_at->format('d-m-Y') }}</li>
                            </ul>
                            <ul>
                            </ul>
                        </div>
                        <div class="col m6">

                        </div>
                    </div>

                    <div class="divider"></div>
                    <div class="card-header center-align">
                        <h5>Detalles de Actividad Económica</h5>
                    </div>
                    <form method="post" action="{{ route('company.taxes.save')}}" id='register-taxes'
                          class="card-content row">
                        @csrf

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="base" id="base" class="validate money"
                                   value="{{$response['vehicleTaxes'][0]->base_imponible}}"
                                   readonly>
                            <label for="base">Base Imponible<b> (Bs)</b></label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="previous_debt" id="previous_debt" class="validate recargo money"
                                   pattern="^[0-9]{0,12}([.][0-9]{2,2})?$"
                                   value="{{$response['vehicleTaxes'][0]->previous_debt}}" readonly>
                            <label for="previous_debt">Deuda Anterior<b> (Bs)</b></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="discount" id="discount" class="validate money"
                                   value="{{$response['vehicleTaxes'][0]->discount}}"
                                   readonly>
                            <label for="discount">Descuento<b> (Bs)</b></label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="recharge" id="recharge" class="validate money"
                                   pattern="[0-9.,]+"
                                   value="{{$response['vehicleTaxes'][0]->recharge}}"
                                   readonly>
                            <label for="recharge">Recargo<b> (Bs)</b></label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="rechargeMora" id="rechargeMora" class="validate money"
                                   pattern="[0-9.,]+"
                                   value="{{$response['vehicleTaxes'][0]->recharge_mora}}"
                                   readonly>
                            <label for="rechargeMora">Interés por mora<b> (Bs)</b></label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="fiscal_credits" id="fiscal_credits"
                                   class="validate number-only" pattern="[0-9.,]+"
                                   value="{{$response['vehicleTaxes'][0]->fiscal_credits}}"
                            >
                            <label for="fiscal_credits">Credito fiscal<b> (Bs)</b></label>
                        </div>




                            <div class="row" style="padding: 1rem">
                                <div class="input-field col s12">
                                    <!-- Modal trigger -->
                                    @if(!$response['taxes'][0]->payments->isEmpty())
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

                                                <tr>
                                                    <td>{{$response['taxes'][0]->created_at->format('d-m-Y')}}</td>
                                                    <td>{{$response['taxes'][0]->code}}</td>
                                                    <td>{{$response['taxes'][0]->type_payment}}</td>
                                                    <td>{{$response['taxes'][0]->statusName}}</td>
                                                    <td>{{$response['taxes'][0]->ref}}</td>
                                                    <td>{{number_format($response['taxes'][0]->amount,2)." Bs"}}</td>
                                                    <td>
                                                        @if($response['taxes'][0]->status==='cancel')
                                                            <div class="input-field col s12 m12">
                                                                <button type="button"
                                                                        class="btn waves-effect waves-light  col s12 red"
                                                                        value="">
                                                                    <i class="icon-do_not_disturb_alt"></i></button>
                                                            </div>
                                                        @elseif($response['taxes'][0]->status=='verified')
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
                                                                        value="{{$response['taxes'][0]->id}}" data-status="verified">
                                                                    <i class="icon-check"></i></button>
                                                            </div>
                                                            <div class="input-field col s12 m6">
                                                                <button type="button"
                                                                        class="change-status btn waves-effect waves-light red col s12"
                                                                        value="{{$response['taxes'][0]->id}}" data-status="cancel">
                                                                    <i class="icon-cancel"></i></button>
                                                            </div>
                                                        @endif

                                                    </td>

                                                </tr>

                                            </tbody>
                                        </table>
                                        @endif
                                       {{--<div class="row ">
                                            @if($response['taxes'][0]->status==='ticket-office')
                                                <a class="btn green col s12 ">
                                                    <i class="icon-more_horiz left "></i>
                                                    ESTADO: SIN PROCESAR AÚN
                                                </a>

                                            @elseif($response['taxes'][0]->status==='process')
                                                <a href="#" class="btn green col s12">
                                                    <i class="icon-more_horiz left "></i>
                                                    ESTADO: SIN CONCILIAR AÚN

                                                </a>
                                            @elseif($response['taxes'][0]->status==='verified')

                                                <a href="#" class="btn blue col s12">
                                                    <i class="icon-more_horiz left"></i>
                                                    ESTADO: VERIFICADA.
                                                </a>


                                            @elseif($response['taxes'][0]->status=='cancel')

                                                <a href="#" class="btn red col s12">
                                                    <i class="icon-more_horiz left"></i>
                                                    ESTADO: CANCELADA.
                                                </a>
                                            @endif

                                            @if($response['taxes'][0]->status=='process'||$response['taxes'][0]->status=='ticket-office'||$response['taxes'][0]->status=='temporal'||$response['taxes'][0]->status=='verified')

                                                <div class="col l12">
                                                    <h4 class="center-align mt-2">Acciones</h4>
                                                </div>


                                                <div class="input-field col s12">

                                                    @can('Anular Pagos')
                                                        <a href="#"
                                                           class="btn btn-rounded col s4 red waves-effect waves-ligt reconcile"
                                                           data-status="cancel">
                                                            ANULAR PLANILLA.
                                                            <i class="icon-close right"></i>
                                                        </a>
                                                    @endcan
                                                    @can('Verificar Pagos - Manual')
                                                        @if($response['verified']&&$response['taxes'][0]->status!=='verified')
                                                            <a href="#"
                                                               class="btn btn-rounded col s4 blue waves-effect waves-light reconcile"
                                                               data-status="verified">
                                                                VERIFICAR PLANILLA.
                                                                <i class="icon-verified_user right"></i>
                                                            </a>
                                                        @endif
                                                    @endcan
                                                    @if($response['taxes'][0]->status=='verified')
                                                        <button type="button" id="send-email-verified"


                                                                class="btn btn-rounded col s4 green waves-effect waves-light"
                                                                value="{{$response['taxes'][0]->id}}">Enviar Correo Verificado.
                                                            <i class="icon-send right"></i>
                                                        </button>
                                                    @endif

                                                </div>
                                            @endif



                                        </div>--}}
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