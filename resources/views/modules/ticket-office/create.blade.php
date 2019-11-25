@extends('layouts.app')

@section('styles')
@endsection

@section('content')

    @php setlocale(LC_MONETARY, 'en_US');@endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('home.ticket-office') }}" class="breadcrumb">Taquilla</a>
                <a href="#!" class="breadcrumb">Pagar Impuestos</a>

            </div>
            <div class="col s12">
                <form action="#" method="post" class="card" id="register-taxes" enctype="multipart/form-data">
                    <ul class="tabs">
                        <li class="tab col s4 " id="one"><a href="#general-tab"><i class="icon-filter_1"></i> DATOS
                                GENERALES</a></li>
                        <li class="tab col s4 disabled" id="two"><a href="#details-tab"><i class="icon-filter_2"></i>
                                Detalles</a></li>
                        <li class="tab col s4 disabled" id="three"><a href="#payment-tab"><i class="icon-filter_3"></i>CONCILIAR
                                PAGO</a></li>
                    </ul>


                    <div id="general-tab" class="content">
                        <div class="card-header center-align">
                            <h4>DATOS GENERALES</h4>
                        </div>
                        <div class="card-content row">


                            <div class="input-field col s12">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="search-code" id="search-code">
                                <label for="license">Licencia o Código</label>
                            </div>


                            <div class="input-field col s12 m6">
                                <i class="icon-person prefix"></i>
                                <input type="text" name="name_company" id="name_company" value="" readonly>
                                <label for="name_company">Razon Social</label>
                            </div>


                            <input type="text" id="company_id" value="" name="company_id" class="hide">


                            <div class="input-field col s8 m6 tooltipped" data-position="bottom"
                                 data-tooltip="EL RIF solo debe contener número sin - ni caracteres extraños. Ej: 1234567890">
                                <i class="icon-perm_contact_calendar prefix"></i>
                                <input type="text" name="RIF" id="RIF" class="validate number-only" pattern="[0-9]+"
                                       maxlength="10" minlength="6" title="Solo puede escribir números." required
                                       readonly>
                                <label for="RIF">RIF</label>
                            </div>

                            <div class="input-field col s12 m4">
                                <i class="icon-directions prefix"></i>
                                <input type="text" name="address" id="address" value="" readonly>
                                <label for="address">Direccion</label>
                            </div>
                            <div class="input-field col s4 m4 ">
                                <i class="icon-supervisor_account prefix"></i>
                                <input type="text" name="person" id="person" value="" readonly>
                                <label for="fiscal_period">Pers. Responsable</label>
                            </div>

                            <div class="input-field col s4 m4">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="fiscal_period" id="fiscal_period" class="fiscal_period"
                                       value="">
                                <label for="fiscal_period">Periodo Fiscal</label>
                            </div>

                            <div class="col s12 right-align">
                                <div class="row">
                                    <div class="col s6">
                                        <div class="input-field left-align">
                                            <button data-target="modal-tick"
                                                    class="btn btn-rounded green modal-trigger " id="scan">
                                                Escanear QR
                                                <i class="icon-filter_center_focus right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col s6">
                                        <div class="input-field">
                                            <a href="#" class="btn peach waves-effect waves-light" id="general-next">
                                                <i class="icon-navigate_next right"></i>
                                                Siguiente
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="details-tab">
                        <div class="card-header center-align">
                            <h4>DETALLES DE DECLARACIÓN </h4>
                        </div>
                        <div class="card-content" id="details">
                            @csrf
                            <input type="hidden" name="fiscal_period" id="fiscal_period" value="">


                            <div id="ciu">

                            </div>
                        <!-- <div class="input-field col s12 m2">
                            <div class="input-field col s12 m2">
                                <i class="icon-assignment prefix"></i>
                                <input type="text" name="code" id="code" value="" readonly>
                                <label for="code"></label>
                            </div>
                            <div class="input-field col s12 m10">
                                <i class="icon-assignment prefix"></i>
                                <textarea name="name" id="name" cols="30" rows="10" class="materialize-textarea" readonly></textarea>
                                <label for="name"></label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="base[]" id="base" class="validate money" value="" readonly>
                                <label for="base">Base Imponible</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="deductions[]" id="deductions" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="" readonly>
                                <label for="deductions">Deducciones</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="withholding[]" id="withholdings" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="" readonly>
                                <label for="withholdings">Retenciones</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="fiscal_credits[]" id="fiscal_credits" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="" readonly>
                                <label for="fiscal_credits">Creditos Fiscales</label>
                            </div>
                            !-->

                        </div>
                        <div class="card-footer ">
                            <div class="row">
                            </div>
                            <div class="row">
                                <div class="col s6 left-align">
                                    <a href="#" class="btn peach waves-effect waves-light" id="previous-details">
                                        <i class="icon-navigate_before left"></i>
                                        Anterior
                                    </a>
                                </div>
                                <div class="col s6 right-align">
                                    <a href="#" class="btn peach waves-effect waves-light" id="details-next">
                                        <i class="icon-navigate_next right"></i>
                                        Siguiente
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <div id="payment-tab" class="card">
                    <div class="card-header center-align">
                        <h4>REGISTRAR PAGO</h4>
                    </div>

                    <div class="card-content row">
                        <h5>Forma de pago:</h5>
                        <ul class="collapsible" style="box-shadow: none !important;">
                            <li>
                                <div class="collapsible-header"><i class="icon-payment"></i>PUNTO DE VENTA</div>
                                <div class="collapsible-body">
                                    <form id="register-payment" method="GET" action="#">
                                        <div class="row">
                                            <input type="text" name="payments_type" id="payments_type"
                                                   value="PUNTO DE VENTA" class="validate hide" required>
                                            <input type="hidden" name="taxes_id" id="taxes_id" value="">

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
                                                <input type="text" name="amount" id="amount" value=""
                                                       class="validate money_keyup"
                                                       required>
                                                <label for="amount">Monto de punto de Venta</label>
                                            </div>


                                            <div class="input-field col s12 m12">
                                                <i class="prefix">
                                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem"
                                                         alt="">
                                                </i>
                                                <input type="text" name="amount_total" id="amount_total" value=""
                                                       class="validate money"
                                                       required readonly>
                                                <label for="amount_total">Total a Pagar</label>
                                            </div>

                                            <div class="card-footer center-align">
                                                <button type="submit"
                                                        class="btn btn-large btn-rounded peach waves-effect waves-light">
                                                    REGISTRAR PAGO<i class="icon-send right"></i></button>
                                            </div>

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
                                                <input type="hidden" name="taxes_id" id="taxes_id_tr" value="">
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
                                                       value="TRANSFERENCIA" class="validate hide" required>
                                                <div class="input-field col s12 m6 ">
                                                    <i class="icon-confirmation_number prefix "></i>
                                                    <input type="text" name="ref" id="ref_tr" value="" class="validate"
                                                           required minlength="10" maxlength="10">
                                                    <label for="ref">Referencia</label>
                                                </div>

                                                <div class="input-field col s12 m6 ">
                                                    <i class="icon-person  prefix "></i>
                                                    <input type="text" name="person" id="person" value=""
                                                           class="validate"
                                                           required>
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
                                                    <input type="text" name="amount_total" id="amount_total_tr" value=""
                                                           class="validate money"
                                                           required>
                                                    <label for="amount_total_tr">Total a Pagar</label>
                                                </div>

                                                <div class="card-footer center-align">
                                                    <button type="submit"
                                                            class="btn btn-large btn-rounded peach waves-effect waves-light">
                                                        REGISTRAR PAGO<i class="icon-send right"></i></button>
                                                </div>

                                            </div>
                                        </form>

                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <div id="modal-tick" class="modal">
            <div class="modal-content">
                <h4 class="center-align">Escanear QR</h4>
                <div class="col l12">
                    <div class="col s12 center-align">
                        <img src="{{asset('images/scan.gif')}}" class="img-responsive">
                    </div>
                    <div class="input-field col s10">
                        <i class="icon-search prefix"></i>
                        <input id="search" type="search" value="">
                        <label for="search">CODIGO QR</label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>


    <div class="fixed-action-btn">
        <a class="btn-floating btn-large light-blue darken-4">
            <i class="large fas fa-cash-register"></i>
        </a>
        <ul>
            <li><a class="btn-floating light-blue darken-1 tooltipped" data-position="left" id="open-cashier"
                   data-tooltip="Abrir caja"><i class="fas fa-sign-in-alt"></i></a></li>
            <li><a class="btn-floating light-blue darken-2 tooltipped" id="close-cashier" data-position="left"
                   data-tooltip="Cerrar caja"><i class="icon-close"></i></a></li>
            <li><a class="btn-floating light-blue darken-3 tooltipped" data-position="left" data-tooltip="Ver pagos"><i
                            class="fas fa-money-check"></i></a></li>
        </ul>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/dev/ticketOffice.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#bank-point').formSelect();
        })
    </script>
@endsection