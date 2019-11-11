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
            <div class="col s12" id="content">

                <form action="#" method="post" class="card" id="register-taxes" enctype="multipart/form-data">
                    <ul class="tabs">

                        <li class="tab col s4 " id="one"><a href="#general-tab"><i class="icon-filter_1"></i> DATOS
                                GENERALES</a></li>
                        <li class="tab col s4" id="two"><a href="#details-tab"><i class="icon-filter_2"></i>
                                Detalles</a></li>


                        <li class="tab col s4 disabled" id="three"><a href="#payment-tab"><i class="icon-filter_3"></i>CONCILIAR
                                PAGO</a></li>
                    </ul>
                    <div id="general-tab">
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
                                <input type="text" name="address" id="address" value="">
                                <label for="address">Direccion</label>
                            </div>
                            <div class="input-field col s4 m4 ">
                                <i class="icon-supervisor_account prefix"></i>
                                <input type="text" name="person" id="person" value="">
                                <label for="fiscal_period">Pers. Responsable</label>
                            </div>

                            <div class="input-field col s4 m4">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="fiscal_period" id="fiscal_period" class="fiscal_period" value="">
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
                        <div class="card-content row" id="details">
                            @csrf
                            <input type="hidden" name="fiscal_period" id="fiscal_period" value="">


                            <div id="ciu">


                            </div>
                        <!-- <div class="input-field col s12 m2">
                            <div class="input-field col s12 m2">
>>>>>>> c1b60444e71dbbb41aa783ea5cf936918a96619f
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
                                    <a href="#" class="btn peach waves-effect waves-light">
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
                <form id="register-payment" class="card" method="GET" action="#">
                    <div id="payment-tab">
                        <div class="card-header center-align">
                            <h4>CONCILIAR PAGO</h4>
                        </div>
                        <div class="card-content row">
                            <input type="hidden" name="taxes_id" id="taxes_id" value="">
                            <div class="input-field col s12 m6 ">
                                <i class="icon-confirmation_number prefix "></i>
                                <input type="text" name="lot" id="lot" value="" class="validate" required>
                                <label for="lot">Lote</label>
                            </div>
                            <div class="input-field col s12 m6 ">

                                <i class="icon-confirmation_number prefix "></i>
                                <input type="text" name="ref" id="ref" value="" class="validate" required>
                                <label for="ref">Referencia</label>
                            </div>
                            <div class="input-field col s12 m6 ">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="amount" id="amount" value="" class="validate money_keyup"
                                       required>
                                <label for="amount">Monto de punto de Venta</label>
                            </div>

                            <div class="input-field col s12 m6 ">
                                <i class="icon-touch_app prefix "></i>
                                <select id="bank" name="bank">
                                    <option value="33">100%BANCO</option>
                                    <option value="44">BOD</option>
                                </select>
                                <label for="code">Banco</label>
                            </div>
                            <div class="input-field col s12 m12">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="amount_total" id="amount_total" value="" class="validate money"
                                       required readonly>
                                <label for="amount_total">Total a Pagar</label>
                            </div>
                        </div>
                        <div class="card-footer center-align">
                            <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                                Conciliar pago<i class="icon-send right"></i></button>
                        </div>
                    </div>
                </form>

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
            <li><a class="btn-floating light-blue darken-1 tooltipped" data-position="left" data-tooltip="Abrir caja"><i class="fas fa-sign-in-alt"></i></a></li>
            <li><a class="btn-floating light-blue darken-2 tooltipped" data-position="left" data-tooltip="Cerrar caja"><i class="icon-close"></i></a></li>
            <li><a class="btn-floating light-blue darken-3 tooltipped" data-position="left" data-tooltip="Ver pagos"><i class="fas fa-money-check"></i></a></li>
        </ul>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/dev/ticketOffice.js') }}"></script>
    <script src="https://kit.fontawesome.com/e3f4029a28.js" crossorigin="anonymous"></script>
@endsection