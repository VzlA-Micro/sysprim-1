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
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla - Actividad
                            Económica</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.manage') }}">Gestionar Pagos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.manage') }}">Generar Planilla</a></li>
                </ul>
            </div>

            <div class="col s12">
                <form action="#" class="card" id="register-taxes" enctype="multipart/form-data">
                    <ul class="tabs">
                        <li class="tab col s6" id="one"><a href="#general-tab"><i class="icon-filter_1"></i> DATOS
                                GENERALES</a></li>
                        <li class="tab col s6 disabled" id="two"><a href="#details-tab"><i class="icon-filter_2"></i>
                                DETALLES</a>
                        </li>
                    </ul>


                    <div id="general-tab" class="content">
                        <div class="card-header center-align">
                            <h4>DATOS GENERALES</h4>
                        </div>
                        <div class="card-content row">

                            <input type="hidden" id="tributo" value="">
                            <div class="input-field col s12">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="licensePlate" id="licensePlate" minlength="7" maxlength="7"
                                       pattern="[0-9A-Za-z]+">
                                <label for="licensePlate">Placa del Vehículo</label>
                            </div>
                            <input type="text" id="vehicle_id" value="" name="vehicle_id" class="hide">
                            <div class="input-field col s12 m3">
                                <i class="icon-person prefix"></i>
                                <input type="text" name="brandTo" id="brandTo" readonly>
                                <label for="brandTo">Marca</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="icon-perm_contact_calendar prefix"></i>
                                <input type="text" name="modelTo" id="modelTo" class="validate number-only" required
                                       readonly>
                                <label for="modelTo">Modelo</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="icon-directions prefix"></i>
                                <input type="text" name="colorTo" id="colorTo" readonly>
                                <label for="colorTo">Color</label>
                            </div>
                            <div class="input-field col s12 m3 ">
                                <i class="icon-supervisor_account prefix"></i>
                                <input type="text" name="personTo" id="personTo" readonly>
                                <label for="personTo">Usuario Web</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="fiscal_periodTo" id="fiscal_periodTo" class="fiscal_period"
                                       readonly>
                                <label for="fiscal_periodTo">Periodo Fiscal</label>
                            </div>


                        </div>
                        <div class="card-footer" style="padding-bottom: .2rem">
                            <div class="row">
                                <div class="col s12">
                                    <!--<button data-target="modal-tick"
                                            class="btn btn-rounded green modal-trigger " id="scan">
                                        Escanear QR
                                        <i class="icon-filter_center_focus right"></i>
                                    </button>-->
                                </div>
                                <div class="col s12 right-align">
                                    <a href="#" class="btn peach waves-effect waves-light" id="general-next">
                                        <i class="icon-navigate_next right"></i>
                                        Siguiente
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="details-tab">
                        <div class="card-header center-align">
                            <h4>DETALLES DE DECLARACIÓN </h4>
                        </div>
                        <div class="card-content" id="details">
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="base" id="base" class="validate money"
                                       value=""
                                       readonly>
                                <label for="base">Base Imponible<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="tasa" id="tasa" class="validate recargo money"
                                       pattern="^[0-9.,]+"
                                       value="" readonly>
                                <label for="tasa">Deuda Anterior<b> (Bs)</b></label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="discount" id="discount" class="validate money"
                                       pattern="[0-9.,-]+"
                                       readonly>
                                <label for="discount">Descuento<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="recharge" id="recharge" class="validate money"
                                       pattern="[0-9.,]+"
                                       value=""
                                       readonly>
                                <label for="recharge">Recargo<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="rechargeMora" id="rechargeMora" class="validate money"
                                       pattern="[0-9.,]+"
                                       value=""
                                       readonly>
                                <label for="rechargeMora">Interés por mora<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="fiscal_credits" id="fiscal_credits"
                                       class="validate number-only" pattern="[0-9.,]+"
                                       value="0"
                                >
                                <label for="fiscal_credits">Credito fiscal<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="total" id="total" class="validate money"
                                       pattern="[0-9.,]+"
                                       value=""
                                       readonly>
                                <label for="total">Total<b> (Bs)</b></label>

                            </div>

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
                                @can('Generar Planilla')
                                    <div class="col s6 right-align">
                                        <a href="#" class="btn peach waves-effect waves-light" id="details-next">
                                            <i class="fas fa-file-pdf right"></i>
                                            Generar Planilla
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </form>
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
                        <label for="search">CODIGO QR </label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/dev/vehicleTicketOffice.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#bank-point').formSelect();
        })
    </script>
@endsection