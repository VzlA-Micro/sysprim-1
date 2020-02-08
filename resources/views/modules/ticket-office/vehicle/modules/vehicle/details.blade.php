@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.vehicle.home') }}">Taquilla Vehículo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.vehicle.manage') }}">Gestionar
                            Vehículo</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.vehicle.read') }}">Ver Vehículos</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Detalles</a></li>
                </ul>
            </div>
            <div class="col s12 m8 l8">
                <form action="#" method="POST" class="card" enctype="multipart/form-data">
                    <div class="card-header center-align">
                        <h5>{{$vehicle->license_plate}}</h5>
                    </div>
                    <div class="card-content row">
                        @csrf

                        <input type="hidden" name="id" id="id" value="{{ $vehicle->id }}">

                        <h5 class="center">Datos del propietario</h5>

                        @if(isset($vehicle->company[0]))
                            <div class="input-field col s6 tooltipped" data-position="bottom"
                                 data-tooltip="V: Venezolano; E: Extranjero">
                                <i class="icon-public prefix"></i>
                                <select name="nationality" id="nationality" required disabled>
                                    <option value="null">...</option>
                                    <option value="V" selected>{{$vehicle->company[0]->typeDocument}}</option>
                                    <option value="E" >E</option>
                                    <option value="E" >G</option>
                                    <option value="E" >V</option>
                                </select>
                                <label for="nationality">Nacionalidad</label>
                            </div>

                            <div class="input-field col s6 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="ci" type="text" name="ci" class="validate number-data" maxlength="10" pattern="[0-9]+"
                                       title="Solo puede escribir números." required
                                       value="{{$vehicle->company[0]->document }}"
                                       readonly disabled>
                                <label for="ci">Cedula</label>
                            </div>

                            <div class="input-field col s12 m12 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="name_user" type="text" name="name" class="validate"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)."
                                       value="{{$vehicle->company[0]->name }}" required disabled>
                                <label for="name">Nombre</label>
                            </div>
                        @elseif(isset($person))
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="name_user" type="text" name="name" class="validate"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)."
                                       value="{{$person->name }}" required readonly>
                                <label for="name">Nombre</label>
                            </div>

                            <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="surname" type="text" name="surname" class="validate"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)."
                                       value="{{$person->surname}}" required readonly>
                                <label for="surname">Apellido</label>
                            </div>

                            <div class="input-field col s6 tooltipped" data-position="bottom"
                                 data-tooltip="V: Venezolano; E: Extranjero">
                                <i class="icon-public prefix"></i>
                                <select name="nationality" id="nationality" required disabled>
                                    <option value="null">...</option>
                                    <option value="V" @if ($person->typeDocument=='V'){{"selected"}}@endif>V
                                    </option>
                                    <option value="E" @if ($person->typeDocument=='E'){{"selected"}}@endif>E
                                    </option>
                                </select>
                                <label for="nationality">Nacionalidad</label>
                            </div>

                            <div class="input-field col s6 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="ci" type="text" name="ci" class="validate" pattern="[0-9]+"
                                       title="Solo puede escribir números." required
                                       value="{{$person->document }}"
                                       readonly>
                                <label for="ci">Cedula</label>
                            </div>

                            @endif
                        {{--@else

                        <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="name_user" type="text" name="name" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$vehicle->users[0]->name }}" required readonly>
                            <label for="name">Nombre</label>
                        </div>

                        <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="surname" type="text" name="surname" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$vehicle->users[0]->surname}}" required readonly>
                            <label for="surname">Apellido</label>
                        </div>

                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="V: Venezolano; E: Extranjero">
                            <i class="icon-public prefix"></i>
                            <select name="nationality" id="nationality" required disabled>
                                <option value="null">...</option>
                                <option value="V" @if ($vehicle->users[0]->typeDocument=='V'){{"selected"}}@endif>V
                                </option>
                                <option value="E" @if ($vehicle->users[0]->typeDocument=='E'){{"selected"}}@endif>E
                                </option>
                            </select>
                            <label for="nationality">Nacionalidad</label>
                        </div>

                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede escribir números. Ej: 12345678">
                            <input id="ci" type="text" name="ci" class="validate" pattern="[0-9]+"
                                   title="Solo puede escribir números." required
                                   value="{{$vehicle->users[0]->document }}"
                                   readonly>
                            <label for="ci">Cedula</label>
                        </div>

                        @endif--}}

                        <div id="change">

                        </div>

                        <h5 class="center">Datos del vehículo</h5>

                        {{--<div class="input-field col s6">
                            <i class="icon-person prefix"></i>
                            <select name="status" id="status" required disabled>
                                <option value="propietario"@if ($vehicle->users[0]->status_user_vehicle=='propietario'){{"selected"}}@endif>Propietario
                                </option>
                                <option value="responsable"@if ($vehicle->users[0]->status_user_vehicle=='responsable'){{"selected"}}@endif>Responsable
                                </option>
                            </select>
                            <label for="status">Condición Legal</label>
                        </div>--}}


                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: L1S2M3">
                            <i class="icon-crop_16_9 prefix"></i>
                            <input type="text" name="license_plate" id="license_plate"
                                   value="{{$vehicle->license_plate}}" minlength="7" maxlength="7"
                                   pattern="[0-9A-Za-z]+"
                                   title="Solo puede escribir números y letra en mayúsculas." class="validate" disabled
                                   required>
                            <label for="license_plate">Placa</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="icon-airport_shuttle prefix"></i>
                            <select name="type" id="type" disabled required>
                                {{--<option value="null" disabled selected>Selecciona el tipo de vehiculo</option>--}}
                                @foreach($type as $types)
                                    <option value="{{$types->id}}"@if ($types->id==$vehicle->type_vehicle_id){{"selected"}}@endif>{{$types->name}}</option>
                                @endforeach
                            </select>
                            <label for="type">Tipo De Vehiculo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input type="text" name="bodySerial" minlength="15" maxlength="17" id="bodySerial" class="validate" pattern="[A-Za-z0-9]+"
                                   title="Solo puede escribir letras y numeros." value="{{$vehicle->body_serial}}"
                                   disabled required>
                            <label for="bodySerial">Serial de carroceria</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-opacity prefix"></i>
                            <input type="text" name="color" maxlength="20" id="color" class="validate" pattern="[A-Za-z]+"
                                   title="Solo puede escribir letras." value="{{$vehicle->color}}" disabled required>
                            <label for="color">Color</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-select_all prefix"></i>
                            <input type="text" name="serialEngine" id="serialEngine" class="validate "
                                   pattern="[A-Za-z0-9]+" minlength="15" maxlength="17" title="Solo puede escribir letras y numeros." disabled
                                   value="{{$vehicle->serial_engine}}" required>
                            <label for="serialEngine">Serial del motor</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-event_note prefix"></i>
                            <input type="text" name="year" id="year" class="validate number-date" pattern="[0-9]+" minlength="4"
                                   maxlength="4"
                                   title="Solo puede escribir numeros." disabled value="{{$vehicle->year}}" required>
                            <label for="year">Año</label>
                        </div>
                        <div id="group-MB">
                            <div class="input-field col s6">
                                <i class="icon-directions_car prefix"></i>
                                <select name="brand" id="brand" disabled required>
                                    <option value="null" disabled selected>Selecciona la marca</option>
                                    @foreach($brand as $brands)
                                        <option value="{{$brands->id}}"@if ($brands->id==$vehicle->model->brand->id){{"selected"}}@endif>{{$brands->name}}</option>
                                    @endforeach

                                </select>
                                <label for="brand">Marca</label>
                            </div>
                            {{--<div class="input-field col s6">
                                <i class="icon-local_shipping prefix"></i>
                                <select name="model" id="model" disabled required>
                                    <option value="null" disabled selected>Selecciona el módelo</option>
                                    @foreach($model as $models)
                                        <option value="{{$models->id}}"@if ($models->id==$vehicle->model->id){{"selected"}}@endif>{{$models->name}}</option>
                                    @endforeach
                                </select>
                                <label for="model">Módelo</label>
                            </div>--}}
                            <div class="input-field col s6">
                                <i class="icon-local_shipping prefix"></i>
                                <select name="model" id="model" disabled required>
                                    <option value="{{$vehicle->model->id}}" )>{{$vehicle->model->name}}</option>
                                </select>
                                <label for="model">Módelo</label>
                            </div>
                        </div>

                            @if($vehicle->status===null||$vehicle->status==='enabled')
                                <div class="input-field col s12 m6" id="estado">
                                    <a href="#"
                                       class="btn btn-large waves-effect waves-light green col s12 btn-rounded "
                                    >Habilitado
                                        <i class="icon-check right"></i>
                                    </a>
                                </div>

                            @else
                                <div class="input-field col s12 m6" id="estado">
                                    <a href="#" class="btn btn-large waves-effect waves-light red col s12 btn-rounded "
                                    >Deshabilitado
                                        <i class="icon-refresh right"></i>
                                    </a>
                                </div>

                            @endif


                        <div class="row">

                            <div class="col s12 m6">
                                <a href="#" class="btn btn-large btn-rounded waves-effect waves-light peach col s12 "
                                   id="change-users">
                                    Cambiar Propietario
                                    <i class="icon-refresh right"></i>
                                </a>
                                <a href="#" class=" hide btn btn-large btn-rounded waves-effect waves-light blue col s12"
                                   id="save-change">
                                    Guardar Cambios
                                    <i class="icon-save right"></i>
                                </a>
                            </div>

                            @can('Actualizar Vehiculos')
                                <div class="col s12 m6" style="margin-top:10px">
                                    <a href="#" class="btn btn-large btn-rounded waves-effect waves-light blue col s12 "
                                       id="update-vehicle">
                                        Actualizar
                                        <i class="icon-mode_edit right"></i>
                                    </a>
                                    <a href="#" class="btn btn-large hide btn-rounded waves-effect waves-light blue col s12 "
                                       id="update-vehicle-save">
                                     Guardar Cambios
                                        <i class="icon-mode_edit right"></i>
                                    </a>
                                </div>
                            @endcan



                            @can('Habilitar/Deshabilitar Vehiculo')
                                @if($vehicle->status===null||$vehicle->status==='enabled')
                                    <div class="col s12 m6" id="button-status">
                                        <button type="button"
                                                class="btn btn-large waves-effect waves-light red col s12 "
                                                id="vehicle-status" value="disabled">
                                            Deshabilitar Vehículo
                                            <i class="icon-sync_disabled right"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="col s12 m6" id="button-status">
                                        <button type="button"
                                                class="btn btn-large waves-effect waves-light green col s12 "
                                                id="vehicle-status" value="enabled">
                                            Activar Vehículo
                                            <i class="icon-check right"></i>
                                        </button>
                                    </div>
                                @endif
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
            <div class="col m4">
                <form action="#" id="form-user" method="post" class="card testimonial-card">
                    <div class="card-header center-align">
                        <h5>Usuario Web</h5>
                    </div>
                    <div class="card-up"></div>
                    <div class="avatar avatar-centered">
                        @if (Storage::disk('users')->has($vehicle->users[0]->image))
                            <img src="{{ route('users.getImage', ['filename' => $vehicle->users[0]->image]) }}" alt=""
                                 class="circle responsive-img">
                        @else
                            <img src="{{ asset('images/user.png') }}" alt="" class="circle responsive-img">
                        @endif
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="V: Venezolano; E: Extrangero">
                            <i class="icon-public prefix"></i>
                            <select name="nationalitys" id="nationalitys" required disabled>
                                <option value="null">...</option>
                                <option value="V" @if ($vehicle->users[0]->typeDocument=='V'){{"selected"}}@endif>V
                                </option>
                                <option value="E" @if ($vehicle->users[0]->typeDocument=='E'){{"selected"}}@endif>E
                            </option>
                            </select>
                            <label for="nationalitys">Nacionalidad</label>
                        </div>
                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede escribir números. Ej: 12345678">
                            <input id="ci" type="text" name="ci" class="validate" pattern="[0-9]+"
                                   minlength="7" maxlength="8" title="Solo puede escribir números." required
                                   value="{{$vehicle->users[0]->document }}"
                                   readonly>
                            <label for="ci">Cedula</label>
                        </div>
                        <div class="input-field col s12 m12 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="name_user" type="text" name="name" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$vehicle->users[0]->name }}" required readonly>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m12 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="surname" type="text" name="surname" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$vehicle->users[0]->surname}}" required readonly>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s6 ">
                            <i class="icon-phone prefix tooltipped" data-position="S" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet<br>251:
                        Local"></i>
                            <select name="country_code" id="country_code_user" required disabled>
                                <option value="null" selected disabled>...</option>
                                <option value="+58412" @if ($vehicle->users[0]->operator=='+58412'){{"selected"}}@endif >
                                    (412)
                                </option>
                                <option value="+58414" @if ($vehicle->users[0]->operator=='+58414'){{"selected"}}@endif>
                                    (414)
                                </option>
                                <option value="+58416" @if ($vehicle->users[0]->operator=='+58416'){{"selected"}}@endif>
                                    (416)
                                </option>
                                <option value="+58424" @if ($vehicle->users[0]->operator=='+58424'){{"selected"}}@endif>
                                    (424)
                                </option>
                                <option value="+58426" @if ($vehicle->users[0]->operator=='+58426'){{"selected"}}@endif>
                                    (426)
                                </option>
                                <option value="+58251" @if ($vehicle->users[0]->operator=='+58251'){{"selected"}}@endif>
                                    (251)
                                </option>
                            </select>
                            <label for="country_code">Operadora</label>
                        </div>
                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede escribir números">
                            <label for="phone">Teléfono</label>
                            <input id="phone_user" type="tel" name="phone" value="{{ $vehicle->users[0]->numberPhone }}"
                                   class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números."
                                   placeholder="Ej. 1234567" maxlength="7" minlength="7" required readonly>
                        </div>


                        <div class="input-field col s12 tooltipped" data-position="bottom"
                             data-tooltip="Ej: correo@mail.com">
                            <i class="icon-mail_outline prefix"></i>
                            <input id="email" type="email" name="email" class="validate"
                                   value="{{ $vehicle->users[0]->email }}" required readonly>
                            <label for="email">E-mail</label>
                        </div>
                        <div id="changeUserWeb">

                        </div>
                        @can('Cambiar Usuario - Vehiculo')

                        @endcan
                        <div class="input-field col s12 m12 ">
                            <a id="changeUW" href="#" class="center btn btn-large waves-effect waves-light peach col s12 btn-rounded ">Cambiar Usuario Web
                                <i class="icon-mode_edit right"></i>
                            </a>
                            <a id="saveUW" href="#" class="hide btn btn-large waves-effect waves-light blue col s12 btn-rounded ">Guardar Cambios
                                <i class="icon-save right"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        {{--
                @can('Historial de Pago - Empresas')
                    <div class="col s12 m12">
                        <div class="card">
                            <div class="card-header center-align">
                                <h5>Historial de Pagos</h5>
                            </div>
                            <div class="card-content">
                                <table class="centered highlight" id="history" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Código</th>
                                        <th>Periodo Fiscal</th>
                                        <th>Tipo de Declaración</th>
                                        <th>Ramo</th>
                                        <th class="tooltipped" data-position="right"
                                            data-tooltip="Sin conciliar aún<br>Cancelado<br>Verificado">Estado
                                        </th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($company->taxesCompanies as $taxe)



                                        <tr>

                                            <td>{{$taxe->created_at->format('d-m-Y H:i')}}</td>
                                            <td>{{ $taxe->code }}</td>
                                            @if($taxe->type==='definitive')
                                                <td>{{ \App\Helpers\TaxesMonth::convertFiscalPeriod($taxe->fiscal_period).'--'.\App\Helpers\TaxesMonth::convertFiscalPeriod($taxe->fiscal_period_end)}}</td>
                                            @else
                                                <td>{{ \App\Helpers\TaxesMonth::convertFiscalPeriod($taxe->fiscal_period_end)}}</td>
                                            @endif

                                            <td>{{$taxe->typeTaxes}}</td>
                                            <td>{{$taxe->branch}}</td>


                                            @if($taxe->status==='process')
                                                <td>

                                                    <button class="btn green">
                                                        <i class="icon-more_horiz left"></i>
                                                        SIN CONCILIAR AÚN
                                                    </button>
                                                </td>

                                            @elseif($taxe->status==='verified')
                                                <td>
                                                    <button class="btn green">
                                                        <i class="icon-more_horiz left"></i>
                                                        VERIFICADA.
                                                    </button>
                                                </td>



                                            @elseif($taxe->status=='cancel')
                                                <td>
                                                    <button class="btn green">
                                                        <i class="icon-more_horiz left"></i>
                                                        CANCELADA.
                                                    </button>
                                                </td>
                                            @endif


                                            @if($taxe->type!='definitive')
                                                <td><a href="{{route('taxes.download',[$taxe->id])}}"
                                                       class="btn orange waves-effect waves-light col l6"><i
                                                                class="icon-description left"></i>Descargar
                                                        planilla.</a>

                                                    <a href="{{url('payments/taxes/'.$taxe->id)  }}"
                                                       class="btn indigo waves-effect waves-light col l6"><i
                                                                class="icon-pageview left"></i>Detalles</a>
                                                </td>



                                            @else
                                                <td>
                                                    <a href="{{route('taxes.definitive.pdf',[$taxe->id])}}"
                                                       class="btn orange waves-effect waves-light col l6"><i
                                                                class="icon-description left"></i>Descargar
                                                        planilla.</a>

                                                    <a href="{{url('taxes/definitive/'.$taxe->id)  }}"
                                                       class="btn indigo waves-effect waves-light col l6"><i
                                                                class="icon-pageview left"></i>Detalles</a>
                                                <!-- <a href="{{route('taxes.download',['id',$taxe->id])}}" class="btn orange waves-effect waves-light"><i class="icon-description left"></i>Descargar planilla.</a>-->
                                                </td>

                                            @endif
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endcan
        --}}

    </div>

    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script>
        $('#history').DataTable({
            responsive: true,
            scroller: true,
            "scrollX": true,
            "pageLength": 10,
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Todavia este contribuyente ningun pago.",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "<i class='icon-navigate_next'></i>",
                    "sPrevious": "<i class='icon-navigate_before'></i>"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            }
        });
    </script>
    <script src="{{ asset('js/dev/vehicleTicketOffice.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection