@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.manage') }}">Gestionar Empresas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tickOffice.companies.register') }}">Registrar Empresa</a></li>
                </ul>
            </div>
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form action="#" method="post" class="card" id="company-register-ticket">
                    <ul class="tabs">
                        <li class="tab col s4" id="user-tab-one"><a href="#user-tab"><i class="icon-filter_1"></i> Representante Legal</a></li>
                        <li class="tab col s4 disabled" id="company-tab-two"><a href="#company-tab"><i class="icon-filter_2"></i> Datos de la Empresa</a></li>
                        <li class="tab col s4 disabled" id="map-tab-three"><a href="#map-tab"><i class="icon-filter_3"></i> Mapa</a></li>
                    </ul>
                    <div id="user-tab">
                        <div class="card-header center-align">
                            <h4>Representante Legal</h4>
                        </div>
                        <div class="card-content row">
                            <input type="hidden" name="user_id" value="" id="user_id">
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="V: Venezolano; E: Extrangero">
                                <i class="icon-public prefix"></i>
                                <select name="nationality" id="nationality" required>
                                    <option value="null" selected disabled>...</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                </select>

                                <label for="nationality">Nacionalidad</label>
                            </div>
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="ci" type="text" name="ci" maxlength="8" class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números." required>
                                <label for="ci">Cedula</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="name_user" type="text" name="name_user" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required readonly>
                                <label for="name_user">Nombre</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="surname" type="text" name="surname" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required readonly>
                                <label for="surname">Apellido</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: correo@mail.com" readonly>
                                <i class="icon-mail_outline prefix"></i>
                                <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}" required readonly>
                                <label for="email">E-mail</label>
                            </div>
                            <div class="input-field col s12 right-align">
                                <a href="#" id='user-next' class="btn peach waves-effect waves-light">
                                    Siguiente
                                    <i class="icon-navigate_next right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="company-tab">
                        <div class="card-header center-align">
                            <h4>Datos de la Empresa</h4>
                        </div>
                        <div class="card-content row">
                            <div class="input-field col s3 m3 tooltipped" data-position="bottom" data-tooltip="J = Juridico<br>G = Gubernamental<br>V = Venezolano<br>E = Extranjero">
                                <i class="icon-perm_contact_calendar prefix"></i>
                                <select name="document_type" id="document_type">
                                    <option value="null" selected disabled>...</option>
                                    <option value="J">J</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                    <option value="G">G</option>
                                </select>
                                <label for="document_type">Documento</label>
                            </div>
                            <div class="input-field col s9 m3 tooltipped" data-position="bottom" data-tooltip="EL RIF solo debe contener número sin - ni caracteres extraños. Ej: 1234567890">
                                <input type="text" name="RIF" id="RIF" class="validate company-validate" pattern="[0-9]+" maxlength="10" minlength="8" title="Solo puede escribir números." required data-validate="RIF">
                                <label for="RIF">RIF</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Razón social o nombre de la empresa.">
                                <i class="icon-work prefix"></i>
                                <input type="text" name="name_company" id="name_company" class="validate company-validate"  title="Solo puede usar letras (con acentos), números y los caracteres especiales: . , $ ! ? % + -" required data-validate="Razon social">
                                <label for="name_company" >Razón Social</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede usar números y letras en mayúsculas. Ej: A1B2C3">
                                <i class="icon-chrome_reader_mode prefix"></i>
                                <input type="text" name="license" id="license" class="validate company-validate" pattern="[0-9A-Z]+" title="Solo puede usar números y letras en mayúsculas." required data-validate="licencia">
                                <label for="license">Licencia</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="opening_date" id="opening_date" class="datepicker company-validate" required data-validate="Fecha de apertura">
                                <label for="opening_date">Fecha de Apertura</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Todo contribuyente que emplee y mantenga en nómina la cantidad de trabajadores o trabajadoras especificados o especificadas en el cuadro anexo, de nacionalidad venezolana, residenciados o residenciadas en el Municipio Iribarren y que garantice estabilidad laboral, gozará de rebajas en el monto del impuesto mensual, con un ajuste impositivo anual al presentar la declaración definitiva que deba pagar según la actual ordenanza (Ord. AE Art. 87).">
                                <i class="icon-supervisor_account prefix"></i>
                                <input type="number" name="number_employees" id="number_employees" class="validate company-validate" maxlength="2000" pattern="[0-9]+" title="Solo puede usar números" data-validate="Número de empleados " required>
                                <label for="number_employees">Número de Empleados</label>
                            </div>

                            <div class="input-field col m6 s12">
                                <i class="icon-satellite prefix"></i>
                                <select  name="parish" id="parish" class="company-validate" data-validate="Parroquia"  required>
                                    <option value="null" disabled selected>Seleccionar una parroquia</option>
                                    @foreach($parish as $parish):
                                    <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                                    @endforeach
                                </select>
                                <label>Parroquia</label>
                            </div>

                            <div class="input-field col m6 s12">
                                <i class="icon-public prefix"></i>

                                  <select  name="sector" id="sector" class="company-validate" data-validate="Ubicación Geográfica" required>
                                      <!--
                                 <option value="null" disabled selected>Seleccionar Ubicación</option>
                                 <option value="ESTE">ESTE</option>
                                 <option value="OESTE">OESTE</option>
                                 <option value="CENTRO">CENTRO</option>
                                 <option value="NORTE">NORTE</option>
                                 <option value="SUR">SUR</option>
                                 <option value="INDUSI">ZONA INDUSTRIAL I</option>
                                 <option value="INDUSII">ZONA INDUSTRIAL II</option>
                                 <option value="INDUSIII">ZONA INDUSTRIAL III</option>
                                    -->
                             </select>

                                <label>Ubicación Geográfica </label>
                            </div>


                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Código que revela la ubicación exacta del inmueble.">
                                <i class="icon-offline_pin prefix"></i>
                                <input type="text" name="code_catastral" id="code_catastral" class="validate company-validate" data-validate="Código Catastral" pattern="[0-9A-Z]+" minlength="20" maxlength="20" title="Solo puede usar números y letras en mayúsculas."  required>
                                <label for="code_catastral">Código Catastral</label>
                            </div>
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="412: Digitel; 414/424: Movistar; 416/426: Movilnet">
                                <i class="icon-phone_android prefix"></i>
                                <select name="country_code_company" id="country_code_company" required>
                                    <option value="null" disabled selected>...</option>
                                    <option value="+58412">(412)</option>
                                    <option value="+58414">(414)</option>
                                    <option value="+58416">(416)</option>
                                    <option value="+58424">(424)</option>
                                    <option value="+58426">(426)</option>
                                    <option value="+58251">(251)</option>
                                </select>
                                <label for="country_code_company">Operadora</label>
                            </div>
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                                <label for="phone_company">Teléfono</label>
                                <input id="phone_company" type="tel" name="phone_company"  data-validate="Teléfono" class="validate company-validate" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-directions prefix"></i>
                                <textarea name="address" id="address" cols="30" rows="10" class="materialize-textarea company-validate" required data-validate="Dirección" ></textarea>
                                <label for="address">Dirección</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Se refiere al código del Clasificador Industrial Internacional Uniforme, el mismo facilita a los contribuyentes la ubicación de las actividades por sectores y algunos subgrupos con referencias específicas de su actividad económica (Ord.  AE I Parte Normativa, 6. Régimen Tarifario). ">
                                <i class="icon-cloud_done prefix"></i>
                                <input type="text" name="search-ciu" id="code" >
                                <label for="code">CIIU</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <a href="#" class="btn btn-large waves-effect waves-light peach col s12 " id="search-ciu">
                                    Buscar
                                    <i class="icon-search right"></i>
                                </a>
                            </div>
                            <div id="group-ciu">
                            
                            </div>
                            <div class="input-field col s6 left-align">
                                <a href="#" id="company-previous" class="btn peach waves-effect waves light">
                                    Anterior
                                    <i class="icon-navigate_before left"></i>
                                </a>
                            </div>
                            <div class="input-field col s6 right-align">
                                <a href="#" class="btn peach waves-effect waves light" id="company-next">
                                    Siguiente
                                    <i class="icon-navigate_next right"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div id="map-tab">
                        <div class="card-header center-align">
                            <h4>Ubicación</h4>
                        </div>
                        <div class="card-content row">
                            <div class="input-field col s12 location-container tooltipped" data-position="bottom" data-tooltip="Acerca el mapa y selecciona tu ubicación, puede tomar algunos segundos.">
                                <span>Elige la  ubicación de tu empresa:</span>
                                <div id="map" style="height: 500px;width: 100%; margin-top:1rem"></div>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-my_location prefix"></i>
                                <input id="lat" type="text" name="lat" value="" readonly>
                                <label for="lat">Latitud</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-my_location prefix"></i>
                                <input id="lng" type="text" name="lng" value="" readonly>
                                <label for="lat">Logintud</label>
                            </div>
                        </div>
                        <div class="card-footer center">
                            <button type="submit" class="btn btn-rounded btn-large peach waves-effect waves-light" id="button-company">
                                <i class="icon-send right"></i>
                                Registar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/company.js') }}"></script>
    <script src="{{ asset('js/dev/ticketOffice.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap" type="text/javascript"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection