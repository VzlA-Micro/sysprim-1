@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mis Empresas</a>
                <a href="#!" class="breadcrumb">Registrar Empresa</a>
            </div>
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form action="#" method="post" class="card" id="company-register-ticket">
                    <div class="card-header center-align">
                        <h5>Registrar Empresa</h5>
                    </div>
                    <div class="card-content row">

                        <h5 class="center-align">Datos de la Empresa</h5>
                        <div class="divider"></div>
                        <div class="divider"></div>
                                <div class="input-field col s3 m3 tooltipped" data-position="bottom" data-tooltip="Seleccione: J = Juridico, G = Gubernamental ó V = Venezolano.">
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
                                <div class="input-field col s9 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                    <input type="text" name="RIF" id="RIF" class="validate" pattern="[0-9]+" maxlength="10" minlength="8" title="Solo puede escribir números." required>
                                    <label for="RIF">RIF</label>
                                </div>
                                <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Razón social o nombre de la empresa.">
                                    <i class="icon-work prefix"></i>
                                    <input type="text" name="name_company" id="name_company" class="validate"  title="Solo puede usar letras (con acentos), números y los caracteres especiales: . , $ ! ? % + -" required>
                                    <label for="name_company">Razón Social</label>
                                </div>
                                <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede usar números y letras en mayúsculas. Ej: A1B2C3">
                                    <i class="icon-chrome_reader_mode prefix"></i>
                                    <input type="text" name="license" id="license" class="validate" pattern="[0-9A-Z]+" title="Solo puede usar números y letras en mayúsculas." required>
                                    <label for="license">Licencia</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <i class="icon-date_range prefix"></i>
                                    <input type="text" name="opening_date" id="opening_date" class="datepicker" required>
                                    <label for="opening_date">Fecha de Apertura</label>
                                </div>
                                <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Todo contribuyente que emplee y mantenga en nómina la cantidad de trabajadores o trabajadoras especificados o especificadas en el cuadro anexo, de nacionalidad venezolana, residenciados o residenciadas en el Municipio Iribarren y que garantice estabilidad laboral, gozará de rebajas en el monto del impuesto mensual, con un ajuste impositivo anual al presentar la declaración definitiva que deba pagar según la actual ordenanza (Ord. AE Art. 87).">
                                    <i class="icon-supervisor_account prefix"></i>
                                    <input type="number" name="number_employees" id="number_employees" class="validate" pattern="[0-9]+" title="Solo puede usar números" required>
                                    <label for="number_employees">Numero de Empleados</label>
                                </div>
                                <div class="input-field col m6 s12">
                                    <i class="icon-public prefix"></i>
                                    <select  name="sector" id="sector" required>
                                        <option value="null" disabled selected>Seleccionar Ubicación</option>
                                        <option value="ESTE">ESTE</option>
                                        <option value="OESTE">OESTE</option>
                                        <option value="CENTRO">CENTRO</option>
                                        <option value="NORTE">NORTE</option>
                                        <option value="SUR">SUR</option>
                                        <option value="INDUSI">ZONA INDUSTRIAL I</option>
                                        <option value="INDUSII">ZONA INDUSTRIAL II</option>
                                        <option value="INDUSIII">ZONA INDUSTRIAL III</option>
                                    </select>
                                    <label>Ubicación Geográfica </label>
                                </div>
                                <div class="input-field col m6 s12">
                                    <i class="icon-satellite prefix"></i>
                                    <select  name="parish" id="parish" required>
                                        <option value="null" disabled selected>Seleccionar una parroquia</option>
                                        @foreach($parish as $parish):
                                        <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                                        @endforeach
                                    </select>
                                    <label>Parroquia</label>
                                </div>
                                <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Código que revela la ubicación exacta del inmueble.">
                                    <i class="icon-offline_pin prefix"></i>
                                    <input type="text" name="code_catastral" id="code_catastral" class="validate" pattern="[0-9A-Z]+" minlength="20" maxlength="20" title="Solo puede usar números y letras en mayúsculas." required>
                                    <label for="code_catastral">Código Catastral</label>
                                </div>
                                <div class="input-field col s3 m3 tooltipped" data-position="bottom"
                                     data-tooltip="412: Digitel; 414/424: Movistar; 416/426: Movilnet">
                                    <i class="icon-phone_android prefix"></i>
                                    <select name="country_code_company" id="country_code_company" required>
                                        <option value="null">...</option>
                                        <option value="+58412">(412)</option>
                                        <option value="+58414">(414)</option>
                                        <option value="+58416">(416)</option>
                                        <option value="+58424">(424)</option>
                                        <option value="+58426">(426)</option>
                                    </select>
                                    <label for="country_code_company">Operadora</label>
                                </div>
                                <div class="input-field col s9 m3 tooltipped" data-position="bottom"
                                     data-tooltip="Solo puede escribir números">
                                    <label for="phone">Teléfono</label>
                                    <input id="phone" type="tel" name="phone_user" class="validate" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required>
                                </div>
                                <div class="input-field col s12 m6">
                                    <i class="icon-directions prefix"></i>
                                    <textarea name="address" id="address" cols="30" rows="10" class="materialize-textarea" required></textarea>
                                    <label for="address">Dirección</label>
                                </div>
                                <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Se refiere al código del Clasificador Industrial Internacional Uniforme, el mismo facilita a los contribuyentes la ubicación de las actividades por sectores y algunos subgrupos con referencias específicas de su actividad económica (Ord.  AE I Parte Normativa, 6. Régimen Tarifario). ">
                                    <i class="icon-cloud_done prefix"></i>
                                    <input type="text" name="search-ciu" id="code" >
                                    <label>CIU</label>

                                </div>
                                <div class="input-field col s12 m6">
                                    <i class="icon-assignment prefix"></i>
                                    <a href="#" class="btn btn-large waves-effect waves-light peach col s12 " id="search-ciu">
                                        Buscar
                                        <i class="icon-search right"></i>
                                    </a>
                                </div>

                                <div id="group-ciu">



                                </div>
                        <h4 class="center-align">Representante Legal</h4>
                        <div class="divider"></div>
                        <h5 class="center-align">Datos Antiguos</h5>
                        <div class="divider"></div>
                        <div class="input-field col s6 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                            <i class="icon-public prefix"></i>
                            <input id="ci-license" type="text" name="ci-license" class="validate" pattern="[0-9]+" title="Solo puede escribir números." required disabled>
                            <label for="ci">Cedula</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos)." disabled>
                            <i class="icon-person prefix"></i>
                            <input id="name-license" type="text" name="name-license" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." disabled required>
                            <label for="name">Nombre del Reprensente</label>
                        </div>


                        <div class="divider"></div>
                        <h5 class="center-align">Datos nuevos</h5>
                        <div class="divider"></div>


                        <div class="input-field col s4 m2 tooltipped" data-position="bottom" data-tooltip="V: Venezolano; E: Extrangero">
                            <i class="icon-public prefix"></i>
                            <select name="nationality" id="nationality" required>
                                <option value="null">...</option>
                                <option value="V">V</option>
                                <option value="E">E</option>
                            </select>
                            <label for="nationality">Nacionalidad</label>
                        </div>
                        <div class="input-field col s6 m4 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                            <input id="ci" type="text" name="ci" class="validate" pattern="[0-9]+" title="Solo puede escribir números." required>
                            <label for="ci">Cedula</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="name_user" type="text" name="name_user" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required>
                            <label for="name_user">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="surname" type="text" name="surname" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s3 m3 tooltipped" data-position="bottom" data-tooltip="412: Digitel; 414/424: Movistar; 416/426: Movilnet">
                            <i class="icon-phone_android prefix"></i>
                            <select name="country_code_user" id="country_code_user" required>
                                <option value="null">...</option>
                                <option value="+58412">(412)</option>
                                <option value="+58414">(414)</option>
                                <option value="+58416">(416)</option>
                                <option value="+58424">(424)</option>
                                <option value="+58426">(426)</option>
                            </select>
                            <label for="country_code_user">Operadora</label>
                        </div>
                        <div class="input-field col s9 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                            <label for="phone">Teléfono</label>
                            <input id="phone" type="tel" name="phone_user" class="validate" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required>
                        </div>
                        <div class="input-field col s12 tooltipped" data-position="bottom" data-tooltip="Ej: correo@mail.com">
                            <i class="icon-mail_outline prefix"></i>
                            <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}" required>
                            <label for="email">E-mail</label>
                        </div>


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
                        <button type="submit" class="btn btn-rounded btn-large peach waves-effect waves-light">
                            <i class="icon-send right"></i>
                            Registar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/company.js') }}"></script>
    <script src="{{ asset('js/dev/user.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap" type="text/javascript"></script>
@endsection