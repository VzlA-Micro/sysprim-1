@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mis Empresas</a>
                <a href="{{ route('companies.details', ['id' => $company->id]) }}"
                   class="breadcrumb">{{ $company->name }}</a>
                <a href="#!" class="breadcrumb">Modificar</a>
            </div>
            <div class="col s12 m8 l8">
                <form action="#" method="post" class="card" enctype="multipart/form-data">
                    <div class="card-header center-align">
                        <h5>{{$company->name}}</h5>
                    </div>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    <div class="card-content row">
                        @csrf
                        <input type="hidden" name="id" name="id" value="{{ $company->id }}">
                        <div class="input-field col s6 m3">
                            <i class="icon-perm_contact_calendar prefix tooltipped" data-position="bottom" data-tooltip="J = Juridico<br>G = Gubernamental<br>V = Venezolano<br>E = Extrangero"></i>
                            <select name="document_type" id="document_type" disabled>
                                <option value="null" selected disabled>...</option>
                                <option value="J" @if ($company->typeDocument=='J'){{"selected"}}@endif>J</option>
                                <option value="V" @if ($company->typeDocument=='V'){{"selected"}}@endif>V</option>
                                <option value="G" @if ($company->typeDocument=='G'){{"selected"}}@endif>G</option>
                                <option value="E" @if ($company->typeDocument=='E'){{"selected"}}@endif>E</option>
                            </select>
                            <label for="document_type">Documento</label>
                        </div>

                        <div class="input-field col s8 m3 tooltipped" data-position="bottom" data-tooltip="EL RIF solo debe contener número sin - ni caracteres extraños. Ej: 1234567890">
                            <input type="text" name="RIF" id="RIF" value="{{$company->document}}" class="validate number-only" pattern="[0-9]+" maxlength="10" minlength="6" title="Solo puede escribir números." required readonly>
                            <label for="RIF">RIF</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="left" data-tooltip="Razón social o nombre de la empresa.">
                            <i class="icon-work prefix"></i>
                            <input type="text" name="name" id="name" class="validate"  pattern="[0-9A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ .,!?_-&%+-$]+" title="Solo puede usar letras (con acentos), números y los caracteres especiales: . , $ ! ? % + -" value="{{ $company->name }}" required readonly>
                            <label for="name">Razón Social</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="left" data-tooltip="Solo puede usar números y letras en mayúsculas. Ej: A1B2C3">
                            <i class="icon-chrome_reader_mode prefix"></i>
                            <input type="text" name="license" id="license" class="validate" pattern="[0-9A-Z]+" title="Solo puede usar números y letras en mayúsculas." value="{{ $company->license }}" required readonly>
                            <label for="license">Licencia</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>
                            <input type="text" name="opening_date" id="opening_date" class="datepicker" value="{{ $company->opening_date }}" required disabled>
                            <label for="opening_date">Fecha de Apertura</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-supervisor_account prefix"></i>
                            <input type="number" name="number_employees" id="number_employees" class="validate" pattern="[0-9]+" title="Solo puede usar números" value="{{ $company->number_employees }}" disabled>
                            <label for="number_employees">Numero de Empleados</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <i class="icon-public prefix"></i>
                            <select  name="sector" id="sector" required disabled>
                                <option value="null" disabled selected>Seleccionar Ubicación</option>
                                <option value="ESTE" @if($company->sector=="ESTE"){{"selected"}}@endif >ESTE</option>
                                <option value="OESTE" @if($company->sector=="OESTE"){{"selected"}}@endif>OESTE</option>
                                <option value="NORTE" @if($company->sector=="NORTE"){{"selected"}}@endif>NORTE</option>
                                <option value="SUR" @if($company->sector=="SUR"){{"selected"}}@endif>SUR</option>
                                <option value="CENTRO"  @if($company->sector=="CENTRO"){{"selected"}}@endif>CENTRO</option>
                                <option value="NORTE"   @if($company->sector=="NORTE"){{"selected"}}@endif>NORTE</option>
                                <option value="SUR"     @if($company->sector=="SUR"){{"selected"}}@endif>SUR</option>
                                <option value="INDUSI"  @if($company->sector=="INDUSI"){{"selected"}}@endif>ZONA INDUSTRIAL I</option>
                                <option value="INDUSII" @if($company->sector=="INDUSII"){{"selected"}}@endif>ZONA INDUSTRIAL II</option>
                                <option value="INDUSIII"@if($company->sector=="INDUSIII"){{"selected"}}@endif>ZONA INDUSTRIAL III</option>
                            </select>
                            <label>Ubicación Geográfica </label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="left" data-tooltip="Código que revela la ubicación exacta del inmueble.">
                            <i class="icon-offline_pin prefix"></i>
                            <input type="text" name="code_catastral" id="code_catastral" class="validate" pattern="[0-9A-Z]+" minlength="20" maxlength="20" title="Solo puede usar números y letras en mayúsculas." value="{{ $company->code_catastral }}" disabled required>
                            <label for="code_catastral">Código Catastral</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <i class="icon-phone prefix tooltipped" data-position="S" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet<br>251: Local"></i>
                            <select name="country_code" id="country_code_company" required disabled>
                                <option value="null" selected disabled>...</option>
                                <option value="+58412" @if ($company->operator=='+58412'){{"selected"}}@endif >(412)</option>
                                <option value="+58414" @if ($company->operator=='+58414'){{"selected"}}@endif>(414)</option>
                                <option value="+58416" @if ($company->operator=='+58416'){{"selected"}}@endif>(416)</option>
                                <option value="+58424" @if ($company->operator=='+58424'){{"selected"}}@endif>(424)</option>
                                <option value="+58426" @if ($company->operator=='+58426'){{"selected"}}@endif>(426)</option>
                                <option value="+58251" @if ($company->operator=='+58251'){{"selected"}}@endif>(251)</option>
                            </select>
                            <label for="country_code">Operadora</label>
                        </div>
                        <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                            <label for="phone">Teléfono</label>
                            <input id="phone" type="tel" name="phone" value="{{ $company->numberPhone }}" class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required readonly>
                        </div>
                        <div class="input-field col m6 s12">
                            <i class="icon-satellite prefix"></i>
                            <select  name="parish" id="parish" required disabled>
                                <option value="null" disabled selected>Seleccionar una parroquia</option>
                                @foreach($parish as $parish):
                                @if($parish->id===$company->parish_id)
                                    <option value="{{ $parish->id }}" selected>{{ $parish->name }}</option>
                                @else
                                    <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                                @endif
                                @endforeach
                            </select>
                            <label>Parroquia</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-directions prefix"></i>
                            <textarea name="address" id="address" cols="30" rows="10" class="materialize-textarea" required readonly>{{ $company->address }}</textarea>
                            <label for="address">Dirección</label>
                        </div>

                        <input id="lat" type="hidden" name="lat" value="{{ $company->lat }}">
                        <input id="lng" type="hidden" name="lng" value="{{ $company->lng }}">


                        <div class="input-field col s12 m6">
                                <i class="icon-cloud_done prefix tooltipped" data-position="bottom" data-tooltip="Se refiere al código del Clasificador Industrial Internacional Uniforme, el mismo facilita a los contribuyentes la ubicación de las actividades por sectores y algunos subgrupos con referencias específicas de su actividad económica (Ord.  AE I Parte Normativa, 6. Régimen Tarifario). "></i>
                                <input type="text" name="code" id="code" class="validate number-only" pattern="[0-9]+" disabled>
                                <label for="code">CIIU</label>
                        </div>
                        <div class="input-field col s12 m6">
                                <a href="#" class="btn btn-large waves-effect waves-light peach col s12 " id="search-ciu" disabled>
                                    Buscar
                                    <i class="icon-search right"></i>
                                </a>
                        </div>
                        @foreach($company->ciu as $ciu)
                            <input type="hidden" name="ciu[]" id="ciu" class="ciu" value="{{$ciu->id}}">
                            <div class="input-field col s12 m6">
                                <i class="icon-assignment prefix"></i>
                                <input type="text" name="search-ciu" id="ciu" disabled value="{{$ciu->code}}">
                                <label>CIIU</label>
                            </div>
                            <div class="input-field col s10 m6">
                                <i class="icon-text_fields prefix"></i>
                                <label for="phone">Nombre</label>
                                <textarea name="name-ciu" id="nombre" cols="30" rows="10" class="materialize-textarea"
                                          disabled required>{{$ciu->name}}</textarea>
                            </div>
                        @endforeach
                        <div id="group-ciu">

                        </div>
                    </div>

                </form>
            </div>


            <div class="col m4">
                <form action="#" id="form-user" method="post" class="card testimonial-card">
                    <div class="card-header center-align">
                        <h5>CONSTRIBUYENTE</h5>
                    </div>
                    <div class="card-up"></div>
                    <div class="avatar avatar-centered">
                        @if (Storage::disk('users')->has($company->users[0]->image))
                        <img src="{{ route('users.getImage', ['filename' => $company->users[0]->image]) }}" alt="" class="circle responsive-img">
                        @else
                        <img src="{{ asset('images/user.png') }}" alt="" class="circle responsive-img">
                        @endif
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="V: Venezolano; E: Extrangero">
                            <i class="icon-public prefix"></i>
                            <select name="nationality" id="nationality" required disabled>
                                <option value="null" >...</option>
                                <option value="V" @if ($company->users[0]->typeDocument=='V'){{"selected"}}@endif>V</option>
                                <option value="E" @if ($company->users[0]->typeDocument=='E'){{"selected"}}@endif>E</option>
                            </select>
                            <label for="nationality">Nacionalidad</label>
                        </div>
                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede escribir números. Ej: 12345678">
                            <input id="ci" type="text" name="ci" class="validate" pattern="[0-9]+"
                                   title="Solo puede escribir números." required value="{{$company->users[0]->document }}"
                                   readonly>
                            <label for="ci">Cedula</label>
                        </div>
                        <div class="input-field col s12 m12 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="name" type="text" name="name" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$company->users[0]->name }}" required readonly>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m12 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="surname" type="text" name="surname" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$company->users[0]->surname}}" required readonly>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s6 >
                            <i class="icon-phone prefix tooltipped" data-position="S" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet<br>251: Local"></i>
                            <select name="country_code" id="country_code_company" required disabled>
                                <option value="null" selected disabled>...</option>
                                <option value="+58412" @if ($company->users[0]->operator=='+58412'){{"selected"}}@endif >(412)</option>
                                <option value="+58414" @if ($company->users[0]->operator=='+58414'){{"selected"}}@endif>(414)</option>
                                <option value="+58416" @if ($company->users[0]->operator=='+58416'){{"selected"}}@endif>(416)</option>
                                <option value="+58424" @if ($company->users[0]->operator=='+58424'){{"selected"}}@endif>(424)</option>
                                <option value="+58426" @if ($company->users[0]->operator=='+58426'){{"selected"}}@endif>(426)</option>
                                <option value="+58251" @if ($company->users[0]->operator=='+58251'){{"selected"}}@endif>(251)</option>
                            </select>
                            <label for="country_code">Operadora</label>
                        </div>
                        <div class="input-field col s6 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                            <label for="phone">Teléfono</label>
                            <input id="phone" type="tel" name="phone" value="{{ $company->users[0]->numberPhone }}" class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required readonly>
                        </div>


                        <div class="input-field col s12 tooltipped" data-position="bottom"
                             data-tooltip="Ej: correo@mail.com">
                            <i class="icon-mail_outline prefix"></i>
                            <input id="email" type="email" name="email" class="validate"
                                   value="{{ $company->users[0]->email }}" required readonly>
                            <label for="email">E-mail</label>
                        </div>
                    </div>
                </form>
            </div>

           <!-- <div class="col s12 m4">
                <a href="#" class="btn btn-large waves-effect waves-light green col s12 " id="update-company">
                    Actualizar
                    <i class="icon-refresh right"></i>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="#" class="btn btn-large waves-effect waves-light blue col s12 " id="add-ciiu">
                    Añadir CIIU
                    <i class="icon-add right"></i>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="#" class="btn btn-large waves-effect waves-light red col s12 " id="delete-ciiu">
                    Eliminar CIIU
                    <i class="icon-delete right"></i>
                </a>
            </div>-->
            <div class="col s12 location-container tooltipped" data-position="left"
                 data-tooltip="Acerca el mapa y selecciona tu ubicación, puede tomar algunos segundos.">
                <div id="map" style="height: 500px;width: 100%; margin-top:1rem"></div>
            </div>

            <div class="col s12 m12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Historial de Pagos</h5>
                    </div>
                    <div class="card-content">
                        <table class="centered highlight" id="history" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Periodo Fiscal</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($company->taxesCompanies as $taxe)
                                <tr>
                                    <td>{{ $taxe->code }}</td>
                                    <td>{{ \App\Helpers\TaxesMonth::convertFiscalPeriod($taxe->fiscal_period)}}</td>
                                    @if($taxe->status==='process')
                                        <td>SIN CONCILIAR AÚN</td>
                                        <td><a href="{{url('pdf/'.$taxe->id)}}"
                                               class="btn orange waves-effect waves-light"><i
                                                        class="icon-description left"></i>Descargar planilla.</a></td>
                                    @else
                                        <td>
                                            <button class="btn disabled">
                                                <i class="icon-more_horiz left"></i>
                                                {{ $taxe->status }}
                                            </button>
                                        </td>
                                        @if($taxe->status==='verified')
                                            <td>
                                                <a href="{{url('payments/taxes/'.$taxe->id)  }}"
                                                   class="btn indigo waves-effect waves-light"><i
                                                            class="icon-pageview left"></i>Detalles</a>
                                            </td>
                                        @else
                                            <td>
                                                <a href="{{url('pdf/'.$taxe->id)}}"
                                                   class="btn orange waves-effect waves-light"><i
                                                            class="icon-description left"></i>Descargar planilla.</a>
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


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
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Todavia este contribuyente ningun pago.",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "<i class='icon-navigate_next'></i>",
                    "sPrevious": "<i class='icon-navigate_before'></i>"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            }
        });
    </script>
    <script src="{{ asset('js/dev/company-edit.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU"
            type="text/javascript"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection