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
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.vehicle.home') }}">Taquilla
                            Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticketOffice.vehicle.payments')}}">Gestionar Pagos</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Generar Planilla</a></li>
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
                            <div class="input-field col s4">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="licensePlate" id="licensePlate" minlength="7" maxlength="7"
                                       pattern="[0-9A-Za-z]+">
                                <label for="licensePlate">Placa del Vehículo</label>
                            </div>
                            <input type="text" id="vehicle_id" value="" name="vehicle_id" class="hide">
                            <div class="input-field col s12 m4">
                                <i class="icon-person prefix"></i>
                                <input type="text" name="brandTo" id="brandTo" disabled>
                                <label for="brandTo">Marca</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="icon-perm_contact_calendar prefix"></i>
                                <input type="text" name="modelTo" id="modelTo" class="validate number-only" required
                                       disabled>
                                <label for="modelTo">Modelo</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="icon-directions prefix"></i>
                                <input type="text" name="colorTo" id="colorTo" disabled>
                                <label for="colorTo">Color</label>
                            </div>
                            <div class="input-field col s12 m4 ">
                                <i class="icon-supervisor_account prefix"></i>
                                <input type="text" name="personTo" id="personTo" disabled>
                                <label for="personTo">Usuario Web</label>
                            </div>
                            @php
                            $cont=(int)date('Y');
                            @endphp
                            <div class="input-field col s12 m4">
                                <i class="icon-date_range prefix"></i>
                                <select id="fiscal_period" name="fiscal_period" disabled>
                                    <option value="null">Seleccione</option>
                                    @while($cont >= 2010)
                                        <option value="{{$cont.'-01-01'}}">{{$cont}}</option>
                                        @php $cont--; @endphp
                                    @endwhile
                                </select>
                                <label>Periodo Fiscal</label>
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
                                    <button class="btn peach waves-effect waves-light" id="general-next">
                                        <i class="icon-navigate_next right"></i>
                                        Siguiente
                                    </button>
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
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="base" id="base" class="validate money"
                                       value=""
                                       readonly>
                                <label for="base">Base Imponible<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="tasa" id="tasa" class="validate recargo money"
                                       pattern="^[0-9.,]+"
                                       value="" readonly>
                                <label for="tasa">Deuda Anterior<b> (Bs)</b></label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="discount" id="discount" class="validate money"
                                       pattern="[0-9.,-]+"
                                       readonly>
                                <label for="discount">Descuento<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="recharge" id="recharge" class="validate money"
                                       pattern="[0-9.,]+"
                                       value=""
                                       readonly>
                                <label for="recharge">Recargo<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="rechargeMora" id="rechargeMora" class="validate money"
                                       pattern="[0-9.,]+"
                                       value=""
                                       readonly>
                                <label for="rechargeMora">Interés por mora<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="fiscal_credits" id="fiscal_credits"
                                       class="validate number-only" pattern="[0-9.,]+"
                                       value="0"
                                >
                                <label for="fiscal_credits">Credito fiscal<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                                </i>
                                <input type="text" name="total" id="total" class="validate money"
                                       pattern="[0-9.,]+"
                                       value=""
                                       readonly>
                                <label for="total">Total<b> (Bs)</b></label>
                                <input type="hidden" id="totalAux" name="totalAux" value="">
                                <input type="hidden" id="taxesId" name="taxesId" value="">
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
                        <img src="{{asset('images/scan.gif')}}" class="img-responsive" alt="Image" width="100%" height="100%">
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
    <script src="{{asset('js/validations.js') }}"></script>
    <script src="{{asset('js/dev/vehicleTaxes.js')}}"></script>
    <script src="{{asset('js/dev/vehicleTicketOffice.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#bank-point').formSelect();
        })
    </script>
@endsection