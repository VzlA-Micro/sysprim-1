@extends('layouts.app')

@section('styles')
@endsection

@section('content')

    @php setlocale(LC_MONETARY, 'en_US');@endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.manage') }}">Gestionar Pagos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticket-office.taxes.getTaxes') }}">Pagar Planillas</a></li>
                </ul>
            </div>
            <div class="col s12">
                <div class="card">
                    <ul class="tabs">
                        <li class="tab col s6 " id="one"><a href="#select-tab"><i class="icon-filter_1"></i> Elegir Planilla</a></li>
                        <li class="tab col s6 disabled" id="two"><a href="#payment-tab"><i class="icon-filter_2"></i> Pagar</a></li>
                    </ul>
                    <div id="select-tab" class="content">
                        <div class="card-content row">
                            <table class="centered highlight" id="receipt" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Contribuyente</th>
                                    <th>Licencia</th>
                                    <th>Código</th>
                                    <th>Periodo Fiscal</th>
                                    <th>Planilla</th>
                                    <th>Monto</th>
                                    @can('Detalles Planilla')
                                    <th>Acción</th>
                                    @endcan
                                </tr>
                                </thead>

                                <tbody id="receipt-body">


                                @if($taxes!==null)
                                    @foreach($taxes as $taxe)
                                        <tr>
                                            <td>{{$taxe->companies[0]->name}}</td>
                                            <td>{{$taxe->companies[0]->license}}</td>
                                            <td>{{$taxe->code}}</td>
                                            <td>{{$taxe->fiscal_period}}</td>
                                            <td class="center-align">
                                                <label>
                                                    <input type="checkbox" name="payroll" class="payroll" value="{{$taxe->id}}"/>
                                                        <span></span>
                                                </label>
                                            </td>
                                            <td>{{number_format($taxe->amount,2)}}</td>
                                            @can('Detalles Planilla')
                                            <td> 
                                                <a href="{{url('payments/taxes/'.$taxe->id)  }}" class="btn indigo waves-effect waves-light">
                                                    <i class="icon-pageview left"></i>
                                                    Detalles
                                                </a>
                                            </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                @else

                                    <tr>
                                        <td colspan="7">Todavia no se genera una planilla</td>
                                    </tr>

                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer" style="padding-bottom: .2rem">
                            <div class="row">
                                <div class="col s6 center-align">
                                    @can('Escanear QR')
                                    <button data-target="modal-tick"
                                            class="btn btn-rounded green modal-trigger " id="scan">
                                        Escanear QR
                                        <i class="icon-filter_center_focus right"></i>
                                    </button>
                                    @endcan
                                </div>
                                <div class="col s6 right-align">
                                    <a href="#" class="btn peach waves-effect waves-light" id="select-next">
                                        <i class="icon-navigate_next right"></i>
                                        Siguiente
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <div id="payment-tab" class="card">
                    <div class="card-header center-align">
                        <h4>REGISTRAR PAGO</h4>
                    </div>

                    <div class="card-content row">
                        <div class="col s12">
                            <h5>Forma de pago:</h5>
                        </div>
                        <div class="col s12">
                            <ul class="collapsible" style="box-shadow: none !important;">
                                <li>
                                    <div class="collapsible-header"><i class="icon-payment"></i>PUNTO DE VENTA</div>
                                    <div class="collapsible-body">
                                        <form id="register-payment" method="GET" action="#">
                                            <div class="row">
                                                <input type="text" name="payments_type" id="payments_type"
                                                       value="PPV" class="validate hide" required>
                                                <input type="hidden" name="taxes_id" id="taxes_id" value="" class="taxes_id">

                                                <div class="input-field col s12 m6 ">
                                                    <i class="icon-confirmation_number prefix "></i>
                                                    <input type="text" name="lot" id="lot" value="" class="validate"
                                                           required readonly>
                                                    <label for="lot">LOTE</label>
                                                </div>
                                                <div class="input-field col s12 m6 ">
                                                    <i class="icon-confirmation_number prefix "></i>
                                                    <input type="text" name="name_bank" id="name_bank" value=""
                                                           class="validate" required
                                                           readonly>
                                                    <label for="bank">BANCO</label>
                                                </div>
                                                <input type="text" name="bank" id="bank" value="" class="validate hide"
                                                       required>

                                                <div class="input-field col s12 m6 ">
                                                    <i class="icon-confirmation_number prefix "></i>
                                                    <input type="text" name="ref" id="ref" value="" class="validate"
                                                           required minlength="3" maxlength="10">
                                                    <label for="ref">Terminal</label>
                                                </div>


                                                <div class="input-field col s12 m6 ">
                                                    <i class="prefix">
                                                        <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem"
                                                             alt="">
                                                    </i>
                                                    <input type="text" name="amount_total" id="amount" value=""
                                                           class="validate money_keyup"
                                                           required>
                                                    <label for="amount">Monto de punto de Venta</label>
                                                </div>


                                                <div class="input-field col s12 m12">
                                                    <i class="prefix">
                                                        <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem"
                                                             alt="">
                                                    </i>
                                                    <input type="text" name="amount" id="amount_total" value=""
                                                           class="validate money amount"
                                                           required readonly>
                                                    <label for="amount_total">Total a Pagar</label>
                                                </div>
                                                @can('Registrar Pago')
                                                <div class="card-footer center-align">
                                                    <button type="submit"
                                                            class="btn btn-large btn-rounded peach waves-effect waves-light">
                                                        REGISTRAR PAGO<i class="icon-send right"></i></button>
                                                </div>
                                                @endcan
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            @if(\Auth::user()->role_id===1)
                                <li>
                                    <div class="collapsible-header"><i class="icon-payment"></i>TRANSFERENCIA</div>

                                    <div class="collapsible-body">

                            <form id="register-payment-tr" method="POST" action="#">
                                <div class="row">
                                    <input type="hidden" name="taxes_id" id="taxes_id_tr" class="taxes_id" value="">
                                    <div class="input-field col m6 s12">
                                        <i class="icon-satellite prefix"></i>
                                        <select name="bank">
                                            <option value="44">BOD</option>
                                            <option value="77">Banco Bicentenario</option>
                                            <option value="55">Banesco</option>
                                            <option value="99">BNC</option>
                                            <option value="33">100% Banco</option>
                                        </select>
                                        <label>Banco</label>
                                    </div>

                                    <div class="input-field col m6 s12">
                                        <i class="icon-satellite prefix"></i>
                                        <select name="bank_destinations">
                                            <option value="44">BOD</option>
                                            <option value="77">Banco Bicentenario</option>
                                            <option value="55">Banesco</option>
                                            <option value="99">BNC</option>
                                            <option value="33">100% Banco</option>
                                        </select>
                                        <label>Destino</label>
                                    </div>


                                    <input type="text" name="payments_type" id="payments_type"
                                           value="PPT" class="validate hide" required>

                                    <div class="input-field col s12 m6 ">
                                        <i class="icon-confirmation_number prefix "></i>
                                        <input type="text" name="ref" id="ref_tr" value="" class="validate"
                                               required minlength="10" maxlength="10">
                                        <label for="ref">Referencia</label>
                                    </div>

                                    <div class="input-field col s12 m6 ">
                                        <i class="icon-person  prefix "></i>
                                        <input type="text" name="person" id="person" value=""
                                               class="validate" required>
                                        <label for="ref">Nombre</label>
                                    </div>


                                    <div class="input-field col s4 m2">
                                        <i class="icon-phone prefix tooltipped" data-position="S"
                                           data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet<br>251: Local"></i>
                                        <select name="country_code" id="country_code_company" required>
                                            <option value="null" selected disabled>...</option>
                                            <option value="+58412">(412)</option>
                                            <option value="+58414">(414)</option>
                                            <option value="+58416">(416)</option>
                                            <option value="+58424">(424)</option>
                                            <option value="+58426">(426)</option>
                                            <option value="+58426">(251)</option>
                                        </select>
                                        <label for="country_code">Operadora</label>
                                    </div>
                                    <div class="input-field col s8 m4 tooltipped" data-position="bottom"
                                         data-tooltip="Solo puede escribir números">
                                        <label for="phone">Teléfono</label>
                                        <input id="phone" type="tel" name="phone"
                                               class="validate number-only" pattern="[0-9]+"
                                                               title="Solo puede escribir números."
                                                               placeholder="Ej. 1234567" maxlength="7" minlength="7"
                                                               required>
                                        </div>


                                                    <div class="input-field col s12 m6">
                                                        <i class="prefix">
                                                            <img src="{{ asset('images/isologo-BsS.png') }}"
                                                                 style="width: 2rem"
                                                                 alt="">
                                                        </i>
                                                        <input type="text" name="amount" id="amount_tr" value=""
                                                               class="validate money_keyup"
                                                               required>
                                                        <label for="amount_tr">Monto</label>
                                                    </div>


                                                    <div class="input-field col s12 m6">
                                                        <i class="prefix">
                                                            <img src="{{ asset('images/isologo-BsS.png') }}"
                                                                 style="width: 2rem"
                                                                 alt="">
                                                        </i>
                                                        <input type="text" name="amount_total" id="amount_total_tr"  value=""
                                                               class="validate money amount"
                                                               required>
                                                        <label for="amount_total_tr">Total a Pagar</label>
                                                    </div>
                                                    @can('Registrar Pago')
                                                    <div class="card-footer center-align">
                                                        <button type="submit"
                                                                class="btn btn-large btn-rounded peach waves-effect waves-light">
                                                            REGISTRAR PAGO<i class="icon-send right"></i></button>
                                                    </div>
                                                    @endcan
                                                </div>
                                            </form>

                                        </div>
                                    </li>
                                @endif

                                <li>
                                    <div class="collapsible-header"><i class="icon-payment"></i>DEPOSITO</div>
                                    <div class="collapsible-body">
                                        <form id="register-payment-depo" class="payment-form" method="POST" action="#">
                                            <input type="hidden" name="taxes_id" id="taxes_id_tr" class="taxes_id" value="">
                                            <div class="row">
                                                <input type="text" name="payments_type" id="payments_type" value="PPB" class="validate hide" required>

                                                <div class="col s12 m6">
                                                    <input type="radio" id="banesco" name="bank" value="55" class="bank-div">
                                                    <label class="btn-radio banesco-green" for="banesco">
                                                        <i class="i-banesco-logo"></i>
                                                    </label>
                                                </div>

                                                <div class="col s12 m6">
                                                    <input type="radio" id="bnc" name="bank" value="99" class="bank-div">
                                                    <label class="btn-radio bnc-blue" for="bnc">
                                                        <i class="i-bnc"></i>
                                                    </label>
                                                </div>

                                                <div class="col s12 m6" id="bod-div">
                                                    <input type="radio" id="bod" name="bank" value="44" class="bank-div">
                                                    <label class="btn-radio bod-green" for="bod">
                                                        <i class="i-bod"></i>
                                                    </label>
                                                </div>


                                                <div class="col s12 m6">
                                                    <input type="radio" id="percent-banco" name="bank" value="33" class="bank-div">
                                                    <label class="btn-radio x100-banco-yellow" for="percent-banco">
                                                        <i class="i-percent-banco"></i>
                                                    </label>
                                                </div>


                                                <div class="input-field col s12" style="padding-top: 1rem">
                                                    <i class="prefix">
                                                        <img src="{{ asset('images/isologo-BsS.png') }}"
                                                             style="width: 2rem"
                                                             alt="">
                                                    </i>
                                                    <input type="text" name="amount_total" id="amount_total_depo"  value="" class="validate money amount"
                                                           required>
                                                    <label for="amount_total_depo">Total a Pagar</label>
                                                </div>

                                                @can('Registrar Pago')
                                                <div class="col s12 center-align">
                                                    <button type="submit"
                                                            class="btn btn-large btn-rounded peach waves-effect waves-light">
                                                        REGISTRAR PAGO<i class="icon-send right"></i>
                                                    </button>
                                                </div>
                                                @endcan
                                            </div>

                                        </form>

                                    </div>
                                </li>
                        </ul>
                        </div>
                        
                </div>
            </div>
            </div>
        </div>
    </div>
        <div id="modal-tick" class="modal">
            <div class="modal-content">
                <h4 class="center-align">Escanear QR O Ingresar Código</h4>
                <div class="col l12">
                    <div class="col s12 center-align">
                        <img src="{{asset('images/scan.gif')}}" class="img-responsive">
                    </div>
                    <div class="input-field col s10">
                        <i class="icon-search prefix"></i>
                        <input id="search" type="search" value="">
                        <label for="search">CÓDIGO</label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>

    @can('Taquilla - Caja')
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large light-blue darken-4">
            <i class="large fas fa-cash-register"></i>
        </a>
        <ul>
            @can('Abrir/Cerrar Caja')
            <li><a class="btn-floating light-blue darken-1 tooltipped" data-position="left" id="open-cashier" data-tooltip="Abrir caja"><i class="fas fa-sign-in-alt"></i></a></li>
            <li><a class="btn-floating light-blue darken-2 tooltipped" id="close-cashier" data-position="left" data-tooltip="Cerrar caja"><i class="icon-close"></i></a></li>
            @endcan
            @can('Ver Planillas')
            <li><a class="btn-floating light-blue darken-3 tooltipped" data-position="left" data-tooltip="Ver pagos"><i class="fas fa-money-check"></i></a></li>
            @endcan
        </ul>
    </div>
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/generate-receipt.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>

@endsection