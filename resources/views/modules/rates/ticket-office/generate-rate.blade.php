@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="#">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rate.ticketoffice.menu') }}">Taquilla - Tasas y Certificaciones</a></li>

                </ul>
            </div>




            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form action="#" method="post" class="card" id="#">
                    <ul class="tabs">
                        <li class="tab col s4" id="one"><a href="#user-tab"><i class="icon-filter_1"></i>Datos Generales</a></li>
                        <li class="tab col s4 disabled" id="two"><a href="#rate-tab"><i class="icon-filter_2"></i> Datos de la Tasa</a></li>
                        <li class="tab col s4" id="three"> <a href="#payments"><i class="icon-filter_3"></i>Pagar Tasas</a></li>

                    </ul>

                    <div id="user-tab">
                        <div class="card-header center-align">
                            <h5>Datos Generales-Taquilla</h5>
                        </div>
                        <div class="card-content row">
                            <input type="hidden" name="id" value="" id="id">
                            <input type="hidden" name="type" value="" id="type">


                            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="V: Venezolano; E: Extranjero">
                                <i class="icon-public prefix"></i>
                                <select name="type_document" id="type_document" required>
                                    <option value="null" selected disabled>...</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                    <option value="J">J</option>
                                    <option value="G">G</option>
                                </select>
                                <label for="type_document"></label>
                            </div>
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="document" type="text" name="document" data-validate="documento" maxlength="8" class="validate number-only rate" pattern="[0-9]+" title="Solo puede escribir números." required>
                                <label for="document">Cedula o RIF</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="name" type="text" name="name" class="validate rate" data-validate="nombre" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required >
                                <label for="name">Nombre</label>
                            </div>

                            <input id="surname" type="hidden" name="surname" class="validate" value="" >
                            <input id="user_name" type="hidden" name="name_user" class="validate" value="" >


                            <input id="user" type="hidden" name="user" class="validate" value="true">




                            <div class="input-field col s12 m12">
                                <i class="icon-directions prefix"></i>
                                <textarea name="address" id="address" cols="30" rows="12" data-validate="direccion" class="materialize-textarea rate" required></textarea>
                                <label for="address">Dirección</label>
                            </div>



                            <div class="input-field col s12 right-align">
                                <a href="#" id='data-next' class="btn peach waves-effect waves-light">
                                    Siguiente
                                    <i class="icon-navigate_next right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="rate-tab">
                        <div class="card-header center-align">
                            <h4>Datos de la Tasa</h4>
                        </div>


                        <div class="col l12">


                        @foreach($rates as $rate)
                        <div class="input-field col s3 m3">
                            <p>
                                <label>
                                    <input type="checkbox" class="rate"  value="{{$rate->id}}"/>
                                    <span>{{$rate->name}}</span>
                                </label>
                            </p>
                        </div>

                        @endforeach

                        </div>


                        <div class="card-content row">
                            <div class="input-field col s12 right-align">
                                <a href="#" class="btn peach waves-effect waves light" id="register-rates">
                                    Siguiente
                                    <i class="icon-navigate_next right"></i>
                                </a>
                            </div>
                        </div>

                    </div>



                    <div id="payments">
                        <div class="card-header center-align">
                            <h4>Datos de Pago</h4>
                        </div>

                        <div class="col l12">


                            <div class="col s12">
                                @can('Registrar Pago')
                                    <ul class="collapsible" style="box-shadow: none !important;">
                                        @can('Registrar Pago - Punto de Venta')
                                            <li>
                                                <div class="collapsible-header"><i class="icon-payment"></i>PUNTO DE
                                                    VENTA
                                                </div>
                                                <div class="collapsible-body">
                                                    <form id="register-payment" method="GET" action="#">
                                                        <div class="row">
                                                            <input type="text" name="payments_type" id="payments_type"
                                                                   value="PPV" class="validate hide" required>
                                                            <input type="hidden" name="taxes_id" value=""
                                                                   class="taxes_id">

                                                            <div class="input-field col s12 m6 ">
                                                                <i class="icon-confirmation_number prefix "></i>
                                                                <input type="text" name="lot" id="lot" value=""
                                                                       class="validate"
                                                                       required readonly>
                                                                <label for="lot">LOTE</label>
                                                            </div>
                                                            <div class="input-field col s12 m6 ">
                                                                <i class="icon-confirmation_number prefix "></i>
                                                                <input type="text" name="name_bank" id="name_bank"
                                                                       value=""
                                                                       class="validate" required
                                                                       readonly>
                                                                <label for="bank">BANCO</label>
                                                            </div>
                                                            <input type="text" name="bank" id="bank" value=""
                                                                   class="validate hide"
                                                                   required>

                                                            <div class="input-field col s12 m6 ">
                                                                <i class="icon-confirmation_number prefix "></i>
                                                                <input type="text" name="ref" id="ref" value=""
                                                                       class="validate"
                                                                       required minlength="3" maxlength="10">
                                                                <label for="ref">Ref o Código</label>
                                                            </div>


                                                            <div class="input-field col s12 m6 ">
                                                                <i class="prefix">
                                                                    <img src="{{ asset('images/isologo-BsS.png') }}"
                                                                         style="width: 2rem"
                                                                         alt="">
                                                                </i>
                                                                <input type="text" name="amount_total" id="amount"
                                                                       value=""
                                                                       class="validate money_keyup"
                                                                       required>
                                                                <label for="amount">Monto de punto de Venta</label>
                                                            </div>


                                                            <div class="input-field col s12 m12">
                                                                <i class="prefix">
                                                                    <img src="{{ asset('images/isologo-BsS.png') }}"
                                                                         style="width: 2rem"
                                                                         alt="">
                                                                </i>
                                                                <input type="text" name="amount" id="amount_total"
                                                                       value=""
                                                                       class="validate money amount"
                                                                       required readonly>
                                                                <label for="amount_total">Total a Pagar</label>
                                                            </div>
                                                            <div class="card-footer center-align">
                                                                <button type="submit"
                                                                        class="btn btn-large btn-rounded peach waves-effect waves-light">
                                                                    REGISTRAR PAGO<i class="icon-send right"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </li>
                                        @endcan
                                        @can('Registrar Pago - Transferencias')
                                            <li>
                                                <div class="collapsible-header"><i class="icon-payment"></i>TRANSFERENCIA
                                                </div>
                                                <div class="collapsible-body">
                                                    <form id="register-payment-tr" method="POST" action="#">
                                                        <div class="row">

                                                            <form id="register-payment-tr" method="#" action="#">
                                                                <div class="row">

                                                                    <input type="hidden" name="taxes_id"
                                                                           id="taxes_id_tr" class="taxes_id" value="">
                                                                    <div class="input-field col m6 s12">
                                                                        <i class="icon-satellite prefix"></i>
                                                                        <select name="bank" id="bank_tr">
                                                                            <option value="null" selected disabled>
                                                                                Seleciona una opción
                                                                            </option>
                                                                            <option value="44">BOD</option>
                                                                            <option value="77">Banco Bicentenario
                                                                            </option>
                                                                            <option value="55">Banesco</option>
                                                                            <option value="99">BNC</option>
                                                                            <option value="33">100% Banco</option>
                                                                        </select>
                                                                        <label>Banco</label>
                                                                    </div>

                                                                    <div class="input-field col m6 s12">
                                                                        <i class="icon-satellite prefix"></i>
                                                                        <select name="bank_destinations"
                                                                                id="bank_destinations_tr">
                                                                            <option value="null" selected disabled>
                                                                                Seleciona una opción
                                                                            </option>
                                                                            <option value="44">BOD</option>
                                                                            <option value="77">Banco Bicentenario
                                                                            </option>
                                                                            <option value="55">Banesco</option>
                                                                            <option value="99">BNC</option>
                                                                            <option value="33">100% Banco</option>
                                                                        </select>
                                                                        <label>Destino</label>
                                                                    </div>

                                                                    <input type="text" name="payments_type"
                                                                           value="PPT" class="validate hide" required>

                                                                    <div class="input-field col s12 m6 ">
                                                                        <i class="icon-confirmation_number prefix "></i>
                                                                        <input type="text" name="ref" id="ref_tr"
                                                                               value="" class="validate"
                                                                               required minlength="3" maxlength="10">
                                                                        <label for="ref">Referencia</label>
                                                                    </div>

                                                                    <div class="input-field col s12 m6 ">
                                                                        <i class="icon-person  prefix "></i>
                                                                        <input type="text" name="person" id="person"
                                                                               value=""
                                                                               class="validate" required>
                                                                        <label for="person">Nombre</label>
                                                                    </div>


                                                                    <div class="input-field col s4 m2">
                                                                        <i class="icon-phone prefix tooltipped"
                                                                           data-position="S"
                                                                           data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet<br>251: Local"></i>
                                                                        <select name="country_code"
                                                                                id="country_code_user" required>
                                                                            <option value="null" selected disabled>...
                                                                            </option>
                                                                            <option value="+58412">(412)</option>
                                                                            <option value="+58414">(414)</option>
                                                                            <option value="+58416">(416)</option>
                                                                            <option value="+58424">(424)</option>
                                                                            <option value="+58426">(426)</option>
                                                                            <option value="+58426">(251)</option>
                                                                        </select>
                                                                        <label for="country_code">Operadora</label>
                                                                    </div>
                                                                    <div class="input-field col s8 m4 tooltipped"
                                                                         data-position="bottom"
                                                                         data-tooltip="Solo puede escribir números">
                                                                        <label for="phone_user">Teléfono</label>
                                                                        <input id="phone_user" type="tel" name="phone"
                                                                               class="validate number-only"
                                                                               pattern="[0-9]+"
                                                                               title="Solo puede escribir números."
                                                                               placeholder="Ej. 1234567" maxlength="7"
                                                                               minlength="7"
                                                                               required>
                                                                    </div>

                                                                    <div class="input-field col s12 m6">
                                                                        <i class="prefix">
                                                                            <img src="{{ asset('images/isologo-BsS.png') }}"
                                                                                 style="width: 2rem"
                                                                                 alt="">
                                                                        </i>
                                                                        <input type="text" name="amount_total"
                                                                               id="amount_tr" value=""
                                                                               class="validate money_keyup"
                                                                               required>
                                                                        <label for="amount_tr">Monto</label>
                                                                    </div>


                                                                    <div class="input-field col s12 m12">
                                                                        <i class="prefix">
                                                                            <img src="{{ asset('images/isologo-BsS.png') }}"
                                                                                 style="width: 2rem"
                                                                                 alt="">
                                                                        </i>
                                                                        <input type="text" name="amount"
                                                                               id="amount_total_tr" value=""
                                                                               class="validate money amount"
                                                                               required>
                                                                        <label for="amount_total_tr">Total a
                                                                            Pagar</label>
                                                                    </div>
                                                                    <div class="card-footer center-align">
                                                                        <button type="submit"
                                                                                class="btn btn-large btn-rounded peach waves-effect waves-light">
                                                                            REGISTRAR PAGO<i
                                                                                    class="icon-send right"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </form>
                                                </div>
                                            </li>

                                        @endcan
                                        @can('Registrar Pago - Depositos')
                                            <li>
                                                <div class="collapsible-header"><i class="icon-payment"></i>DEPOSITO
                                                </div>
                                                <div class="collapsible-body">
                                                    <form id="register-payment-depo" class="payment-form" method="POST"
                                                          action="#">
                                                        <input type="hidden" name="taxes_id"
                                                               class="taxes_id" value="">

                                                        <div class="row">
                                                            <input type="hidden" name="payments_type"
                                                                   id="payments_type_depo" value="PPB" class="validate"
                                                                   required>
                                                            <div class="input-field col s4" style="padding-top: 1rem">
                                                                <h5>Forma de pago:</h5>
                                                                <p>
                                                                    <label>
                                                                        <input name="form-payment" type="radio"
                                                                               value="PPE" class="check-payment"/>
                                                                        <span>EFECTIVO</span>
                                                                    </label>
                                                                </p>
                                                                <p>
                                                                    <label>
                                                                        <input name="form-payment" type="radio"
                                                                               value="PPC" class="check-payment"/>
                                                                        <span>CHEQUE</span>
                                                                    </label>
                                                                </p>
                                                            </div>


                                                            <div class="input-field col s12 m12 ">
                                                                <i class="icon-confirmation_number prefix "></i>
                                                                <input type="text" name="ref" id="ref_depo" value=""
                                                                       class="validate"
                                                                       required minlength="3"  readonly>
                                                                <label for="ref_depo">N DE CHEQUE</label>
                                                            </div>


                                                            <div class="col s12 m6">
                                                                <input type="radio" id="banesco" name="bank" value="55"
                                                                       class="bank-div">
                                                                <label class="btn-radio banesco-green" for="banesco">
                                                                    <i class="i-banesco-logo"></i>
                                                                </label>
                                                            </div>

                                                            <div class="col s12 m6">
                                                                <input type="radio" id="bnc" name="bank" value="99"
                                                                       class="bank-div">
                                                                <label class="btn-radio bnc-blue" for="bnc">
                                                                    <i class="i-bnc"></i>
                                                                </label>
                                                            </div>

                                                            <div class="col s12 m6" id="bod-div">
                                                                <input type="radio" id="bod" name="bank" value="44"
                                                                       class="bank-div">
                                                                <label class="btn-radio bod-green" for="bod">
                                                                    <i class="i-bod"></i>
                                                                </label>
                                                            </div>


                                                            <div class="col s12 m6">
                                                                <input type="radio" id="percent-banco" name="bank"
                                                                       value="33" class="bank-div">
                                                                <label class="btn-radio x100-banco-yellow"
                                                                       for="percent-banco">
                                                                    <i class="i-percent-banco"></i>
                                                                </label>
                                                            </div>


                                                        </div>
                                                        <div class="row">


                                                            <div class="input-field col s12" style="padding-top: 1rem">
                                                                <i class="prefix">
                                                                    <img src="{{ asset('images/isologo-BsS.png') }}"
                                                                         style="width: 2rem"
                                                                         alt="">
                                                                </i>
                                                                <input type="text" name="amount_total"
                                                                       id="amount_total_depo" value=""
                                                                       class="validate money amount"
                                                                       required>
                                                                <label for="amount_total_depo">Total a Pagar</label>
                                                            </div>
                                                            <div class="col s12 center-align">
                                                                <button type="submit"
                                                                        class="btn btn-large btn-rounded peach waves-effect waves-light">
                                                                    REGISTRAR PAGO<i class="icon-send right"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </li>
                                        @endcan
                                    </ul>
                                @endcan
                            </div>
                        </div>


                        <div class="card-content row">
                            <div class="input-field col s12 right-align">
                                <a href="#" class="btn peach waves-effect waves light" id="register-rates">
                                    Finalizar
                                    <i class="icon-navigate_next right"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/rate-tickoffice.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection