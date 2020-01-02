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
                    <li class="breadcrumb-item"><a href="{{ route('payments.manage') }}">Generar Planilla</a></li>
                </ul>
            </div>

            <div class="col s12">
                <form action="#" method="post" class="card" id="register-taxes" enctype="multipart/form-data">
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

                            <input type="hidden" id="tributo" value="{{$unid_tribu[0]->value}}">
                            <div class="input-field col s12">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="search-code" id="search-code" >
                                <label for="search-code">Licencia O RIF</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="icon-person prefix"></i>
                                <input type="text" name="name_company" id="name_company" value="" readonly>
                                <label for="name_company">Razon Social</label>
                            </div>
                            <input type="text" id="company_id" value="" name="company_id" class="hide">
                            <div class="input-field col s12 m3 tooltipped" data-position="bottom"
                                 data-tooltip="EL RIF solo debe contener número sin - ni caracteres extraños. Ej: 1234567890">
                                <i class="icon-perm_contact_calendar prefix"></i>
                                <input type="text" name="RIF" id="RIF" class="validate number-only" pattern="[0-9]+"
                                       maxlength="10" minlength="6" title="Solo puede escribir números." required
                                       readonly>
                                <label for="RIF">RIF</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="icon-directions prefix"></i>
                                <input type="text" name="address" id="address" value="" readonly>
                                <label for="address">Direccion</label>
                            </div>
                            <div class="input-field col s12 m3 ">
                                <i class="icon-supervisor_account prefix"></i>
                                <input type="text" name="person" id="person" value="" readonly>
                                <label for="person">Pers. Responsable</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="icon-picture_as_pdf prefix"></i>
                                <select name="type" id="type">
                                    <option value="null" disabled selected>Seleciona una Opción</option>
                                    <option value="definitive">Definitiva</option>
                                    <option value="actuated">Anticipada</option>
                                </select>
                                <label for="type">Tipo de Planilla</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="fiscal_period" id="fiscal_period" class="fiscal_period"
                                       value="">
                                <label for="fiscal_period">Periodo Fiscal</label>
                            </div>






                        </div>
                        <div class="card-footer" style="padding-bottom: .2rem">
                            <div class="row">
                                <div class="col s12" >
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
                            @csrf



                            <div id="ciu">

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
    <script src="{{ asset('js/dev/ticketOffice.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#bank-point').formSelect();
        })
    </script>
@endsection