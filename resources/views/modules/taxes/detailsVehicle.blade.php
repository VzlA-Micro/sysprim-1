@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    @if(isset($vehicle[0]->company[0]->id))
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a
                                    href="{{ route('companies.details',['id'=>$vehicle[0]->company[0]->id]) }}">{{$vehicle[0]->company[0]->name}}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                    href="{{ route('company.vehicle.read', ['idCompany' => $vehicle[0]->company[0]->id])}}">Vehículos</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{url('/vehicles/details/'.$vehicle[0]->id.'-'.true)}}">Detalles
                                De
                                Vehículos</a></li>
                        <li class="breadcrumb-item"><a
                                    href="{{url('vehicles/manage/'.$vehicle[0]->id."-".$vehicle[0]->company[0]->id)}}">Mis
                                Declaraciones</a></li>
                        <li class="breadcrumb-item"><a href="#">Detalles De Declaracion</a></li>

                    @else
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.my-vehicles')}}">Mis Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/vehicles/details/'.$vehicle[0]->id)}}">Detalles De
                                Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="{{url('vehicles/manage/'.$vehicle[0]->id)}}">Mis
                                Declaraciones</a></li>
                        <li class="breadcrumb-item"><a href="#">Pagar Mis Impuesto</a></li>
                    @endif
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">

                @if( $statusTax=== 'process')
                <div class="message message-warning ">
                    <div class="message-body ">
                        <div class="row">
                            <div class="col s2 center-align ">
                                <h3><i class="icon-access_alarms orange-text"></i></h3>
                            </div>
                            <div class="col s10 left-align ">
                                <h5>Pago Declarado</h5>
                                <p>Ya has declarado tu pago, actualmete se encuentra en proceso de verificación.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($statusTax==='verified')
                <div class="message message-success ">
                    <div class="message-body ">
                        <div class="row">
                            <div class="col s2 center-align ">
                                <h3><i class="icon-check green-text"></i></h3>
                            </div>
                            <div class="col s10 left-align ">
                                <h5>Pago Verificado</h5>
                                <p>Su pago ha sido verificado éxitosamente.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <div class="card">
                        <div class="card-header center-align">
                            <h5>Resumen de Autoliquidación</h5>
                        </div>
                        <div class="row padding-2 left-align">
                            <div class="col m6">
                                <ul>
                                    <li><b>Periodo Fiscal: </b>{{ $period }}</li>
                                    <li><b>Fecha: </b>{{$taxes->created_at}}</li>
                                    <li><b>U.T (Unidad Tributaria): </b>{{$rateYear}}</li>
                                </ul>
                            </div>
                            <div class="col m6">
                                <ul>
                                    <li><b>Placa: </b>{{ $vehicle[0]->license_plate}}</li>
                                    {{--
                                    <li><b>Marca: </b>{{ $vehicle[0]->model->brand->name}}</li>
                                    <li><b>Modelo: </b>{{ $vehicle[0]->model->name}}</li>
                                    --}}
                                    <li><b>Tipo De Vehículo: </b>{{$vehicle[0]->type->name}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="divider"></div>
                        <div class="card-header center-align">
                            <h5>Detalles de Impuesto</h5>
                        </div>
                        <form method="post" action="{{route('vehicles.taxes.save')}}" id='register-taxes'
                              class="card-content row">
                            @csrf
                            @if(isset($vehicle[0]->company[0]->id))
                                <input type="hidden" name="companyId" id="companyId"
                                       value="{{$vehicle[0]->company[0]->id}}">
                            @endif
                            <input type="hidden" id="vehicleId" name="vehicleId" value="{{$vehicle[0]->id}}">
                            <div class="input-field col s12 m6">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="type" id="type" class="code"
                                       value="{{$vehicle[0]->type->name}}"
                                       required readonly>
                                <label for="type">Tipo De Vehiculo</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-assignment prefix"></i>
                                <input type="text" name="ciu" id="ciu" value="{{$rateYear}}" required readonly>
                                <label for="ciu">Tarifa U.T</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                                </i>
                                <input type="text" name="base" id="base" class="validate money"
                                       value="{{$grossTaxes}}"
                                       readonly>
                                <label for="base">Base Imponible<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                                </i>
                                <input type="text" name="previous_debt" id="previous_debt"
                                       class="validate recargo money"
                                       pattern="^[0-9]{0,12}([.][0-9]{2,2})?$"
                                       value="{{$previousDebt}}" readonly>
                                <label for="previous_debt">Deuda Anterior<b> (Bs)</b></label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                                </i>
                                <input type="text" name="discount" id="discount" class="validate money"
                                       value="{{$valueDiscount}}"
                                       readonly>
                                <label for="discount">Descuento<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                                </i>
                                <input type="text" name="recharge" id="recharge" class="validate money"
                                       pattern="[0-9.,]+"
                                       value="{{$recharge}}"
                                       readonly>
                                <label for="recharge">Recargo<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="rechargeMora" id="rechargeMora" class="validate money"
                                       pattern="[0-9.,]+"
                                       value="{{$valueMora}}"
                                       readonly>
                                <label for="rechargeMora">Interés por mora<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="fiscal_credits" id="fiscal_credits"
                                       class="validate money_keyup" pattern="[0-9.,]+"
                                       value="" maxlength="15"
                                >
                                <label for="fiscal_credits">Credito fiscal<b> (Bs)</b></label>
                            </div>
                        <!--<div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="interest[]" id="interest" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="" readonly>
                            <label for="interest">Interes por mora<b> (Bs)</b></label>
                        </div>-->
                            <div class="input-field col s12">
                                <div class="divider"></div>
                            </div>

                            <div class="col l12 s12">
                                <div class="col l6 s12">
                                    <table class="centered responsive-table" style="font-size: 10px;!important;">
                                        <thead>
                                        <tr>
                                            <th>RECARGO</th>
                                            <th>VALOR</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{'20%'}}</td>
                                            <td>{{$recharge}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col l6 s12">
                                    {{--<div class="col s12 m12 ">
                                        <input type="text" name="interest" class="validate money"
                                               value="{{$grossTaxes}}"
                                               readonly>
                                        <label for="interest">Impuesto Bruto:(Bs)</label>
                                    </div>
                                    <div class="col s12 m12 ">
                                        <input type="text" name="previousDebt" class="validate money"
                                               value="{{$previousDebt}}"
                                               readonly>
                                        <label for="previousDebt">Deuda Anterior:(Bs)</label>
                                    </div>
                                    <div class="col s12 m12 ">
                                        @if(isset($valueDiscount))
                                            <input type="text" name="recargo" class="validate money"
                                                   value="{{$valueDiscount}}" readonly>
                                        @else
                                            <input type="text" name="recargo" class="validate money" value="0" readonly>
                                        @endif
                                        <label for="recargo">Descuento:(Bs)</label>
                                    </div>--}}
                                    <div class="col s12 m12">
                                        <input type="text" name="total" id="total" class="validate money left-align"
                                               value="{{$total}}"
                                               readonly>
                                        <label for="total_pagar">Total a Pagar:(Bs)</label>
                                    </div>
                                    <input type="hidden" id="bank" name="bank" value="0">
                                    <input type="hidden" id="totalAux" name="totalAux" value="{{$totalAux}}">
                                    <input type="hidden" id="payments" name="payments" value="1">
                                    <input type="hidden" name="taxes_id" value="{{$taxes->id}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">

                                    <a href=""
                                       class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger">
                                        Calcular de nuevo
                                        <i class="icon-refresh right"></i>
                                    </a>

                                    <button type="submit"
                                            class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger"
                                            id="continue">
                                        Continuar
                                        <i class="icon-more_horiz right"></i>
                                    </button>


                                    {{-- Modal structure --}}
                                    <div id="modal1" class="modal modal-fixed-footer">
                                        <div class="modal-content">
                                            <h4 class="center-align">Formas de pago</h4>
                                            <div class="row">
                                                <div class="col s12 center-align">
                                                    <p>Por favor, elija la forma en como desea pagar su actividad .</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col s12 m4 center-align">
                                                    <img src="{{ asset('images/png/001-point-of-service.png') }}"
                                                         class="responsive-img circle" alt="Payment Image" width="100%" height="100%">
                                                    <a href="#" data-target='ppv'
                                                       class="btn btn-large yellow darken-4 waves-effect waves-light tick payments"
                                                       data-payments="PPV">
                                                        Taquilla
                                                        <i class="icon-payment right"></i>
                                                    </a>
                                                </div>
                                                <div class="col s12 m4 center-align">
                                                    <div class="img"></div>
                                                    <img src="{{ asset('images/png/009-smartphone-1.png') }}"
                                                         class="responsive-img circle" alt="Payment Image" width="100%" height="100%">
                                                    <a href="#" data-target='ptb'
                                                       class="btn btn-large blue waves-effect waves-light  dropdown-trigger payments"
                                                       data-payments="PTB">
                                                        Transferencia
                                                        <i class="icon-compare_arrows right"></i>
                                                    </a>
                                                    <ul id='ptb' class='dropdown-content'>
                                                        <li><a href="#!" data-bank="55" class="bank">Banesco</a></li>
                                                        <li><a href="#!" data-bank="33" class="bank">100% Banco</a></li>
                                                        <li><a href="#!" data-bank="99" class="bank">BNC</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col s12 m4 center-align">
                                                    <img src="{{ asset('images/png/030-bank.png') }}"
                                                         class="responsive-img circle" alt="Payment Image" width="100%" height="100%">
                                                    <a href="#" data-target='ppb'
                                                       class="btn btn-large red waves-effect waves-light dropdown-trigger payments"
                                                       data-payments="PPB">
                                                        Deposito
                                                        <i class="icon-account_balance right"></i>
                                                    </a>
                                                    {{-- Dropdown trigger --}}
                                                    <ul id='ppb' class='dropdown-content'>
                                                        <li><a href="#!" data-bank="77" class="bank">Banco
                                                                Bicentenario</a>
                                                        </li>
                                                        <li><a href="#!" data-bank="55" class="bank">Banesco</a></li>
                                                        <li><a href="#!" data-bank="44" class="bank">BOD</a></li>
                                                        <li><a href="#!" data-bank="33" class="bank">100% Banco</a></li>
                                                        <li><a href="#!" data-bank="99" class="bank">BNC</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/vehicleTaxes.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection