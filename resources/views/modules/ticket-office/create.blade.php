@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/receipt.css') }}">
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
                <form action="" method="post" class="card">
                    <ul class="tabs">
                        <li class="tab col s4"><a href="#user-company-tab"><i class="icon-filter_1"></i> Representante y Empresa</a></li>
                        <li class="tab col s4"><a href="#details-tab"><i class="icon-filter_2"></i> Detalles</a></li>
                        <li class="tab col s4"><a href="#payment-tab"><i class="icon-filter_3"></i> Pagar Impuestos</a></li>
                    </ul>
                    <div id="user-company-tab">
                        <div class="card-header center-align">
                            <h4>Representante y Empresa</h4>
                        </div>
                        <div class="card-content row">
                            <div class="input-field col s10">
                                <i class="icon-search prefix"></i>
                                <input id="search" type="search" value="">
                                <label for="search">CODIGO QR</label>
                            </div>
                            <div class="input-field col s2 center-align">
                                <button class="btn btn-floating peach">
                                    <i class="icon-search"></i>
                                </button>
                            </div>
                            <div class="input-field col s4">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="license" id="license" value="" >
                                <label for="license">Licencia o Código</label>
                            </div>

                            <div class="input-field col s12  m4">
                                <i class="icon-person prefix"></i>
                                <input type="text" name="name_company" id="name_company" value="" readonly>
                                <label for="name_company">Razon Social</label>
                            </div>

                            <div class="input-field col s8 m4 tooltipped" data-position="bottom" data-tooltip="EL RIF solo debe contener número sin - ni caracteres extraños. Ej: 1234567890">
                                <i class="icon-perm_contact_calendar prefix tooltipped"></i>
                                <input type="text" name="RIF" id="RIF" class="validate number-only" pattern="[0-9]+" maxlength="10" minlength="6" title="Solo puede escribir números." required readonly>
                                <label for="RIF">RIF</label>
                            </div>

                            <div class="input-field col s12 m4">
                                <i class="icon-directions prefix"></i>
                                <input type="text" name="address" id="address" value="" >
                                <label for="address">Direccion</label>
                            </div>
                            <div class="input-field col s4 m4 ">
                                <i class="icon-supervisor_account prefix"></i>
                                <input type="text" name="person" id="person" value="" >
                                <label for="fiscal_period">Pers. Responsable</label>
                            </div>

                            <div class="input-field col s4 m4">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="fiscal_period" id="fiscal_period" value="" >
                                <label for="fiscal_period">Periodo Fiscal</label>
                            </div>
                            <div class="col s12 right-align">
                                <a href="" class="btn peach waves-effect waves-light">
                                    <i class="icon-navigate_next right"></i>
                                    Siguiente
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="details-tab">
                        <div class="card-header center-align">
                            <h4>Detalles</h4>
                        </div>
                        <div class="card-content row">
                            @csrf
                            <input type="hidden" id="company_id" name="company_id" value="">
                            <input type="hidden" name="fiscal_period" id="fiscal_period" value="">
                            <input type="hidden" name="ciu_id[]" value="">



                            <div id="ciu">



                            </div>
                           <!-- <div class="input-field col s12 m2">
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
                                <div class="col s12 right-align">
                                    <h4><span class="green-text">Total: </span>000000.00 BSS</h4>
                                </div>
                                <div class="col s12 right-align">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6 left-align">
                                    <a href="" class="btn peach waves-effect waves-light">
                                        <i class="icon-navigate_before left"></i>
                                        Anterior
                                    </a>
                                </div>
                                <div class="col s6 right-align">
                                    <a href="" class="btn peach waves-effect waves-light">
                                        <i class="icon-navigate_next right"></i>
                                        Siguiente
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="payment-tab">
                        <div class="card-header center-align">
                            <h4>Pagar Impuestos</h4>
                        </div>
                        <div class="card-content row">
                            <input type="hidden" name="taxes_id" value="">
                            <div class="input-field col s12 m6 ">
                                <i class="icon-confirmation_number prefix "></i>
                                <input type="text" name="lot" id="lot" value="" class="validate" required >
                                <label for="lot">Lote</label>
                            </div>
                            <div class="input-field col s12 m6 ">
                                <i class="icon-confirmation_number prefix "></i>
                                <input type="text" name="ref" id="ref" value="" class="validate" required >
                                <label for="ref">Referencia</label>
                            </div>
                            <div class="input-field col s12 m6 ">
                                <i class="icon-touch_app prefix "></i>
                                <input type="text" name="amount" id="amount" value="" class="validate" required>
                                <label for="amount">Monto</label>
                            </div>
                            <div class="input-field col s12 m6 ">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <select>
                                    <option>100%banco</option>
                                    <option>BOD</option>
                                </select>
                                <label for="code">Banco</label>
                            </div>
                        </div>
                        <div class="card-footer center-align">
                            <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">Registrar<i class="icon-send right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/dev/ticketOffice.js') }}"></script>
@endsection