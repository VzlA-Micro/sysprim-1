@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mis Empresas</a>
                <a href="#!" class="breadcrumb">Registrar Empresa</a>
            </div>
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form action="#" method="post" class="card" enctype="multipart/form-data" id="company-register">
                    <div class="card-header center-align">
                        <h5>Registrar Empresa</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s3 m3">
                            <i class="icon-perm_contact_calendar prefix tooltipped" data-position="bottom" data-tooltip="Seleccione: J = Juridico, G = Gubernamental ó V = Venezolano."></i>
                            <select name="document_type" id="document_type">
                                <option value="null" selected disabled>...</option>
                                <option value="J">J</option>
                                <option value="V">V</option>
                                <option value="G">G</option>
                            </select>
                            <label for="document_type">Documento</label>
                        </div>
                        <div class="input-field col s9 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 1234567890">
                            <input type="text" name="RIF" id="RIF" class="validate" pattern="[0-9]+" maxlength="10" minlength="8" title="Solo puede escribir números." required>
                            <label for="RIF">RIF</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-work prefix tooltipped" data-position="bottom" data-tooltip="Razón social o nombre de la empresa."></i>                            
                            <input type="text" name="name" id="name" class="validate"  title="Solo puede usar letras (con acentos), números y los caracteres especiales: . , $ ! ? % + -" required>
                            <label for="name">Razón Social</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-chrome_reader_mode prefix tooltipped" data-position="bottom" data-tooltip="Solo puede usar números y letras en mayúsculas. Ej: A1B2C3"></i>                                                        
                            <input type="text" name="license" id="license" class="validate" pattern="[0-9A-Z]+" title="Solo puede usar números y letras en mayúsculas." required>
                            <label for="license">Licencia</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>                            
                            <input type="text" name="opening_date" id="opening_date" class="datepicker" required>
                            <label for="opening_date">Fecha de Apertura</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-supervisor_account prefix tooltipped" data-position="bottom" data-tooltip="Todo contribuyente que emplee y mantenga en nómina la cantidad de trabajadores o trabajadoras especificados o especificadas en el cuadro anexo, de nacionalidad venezolana, residenciados o residenciadas en el Municipio Iribarren y que garantice estabilidad laboral, gozará de rebajas en el monto del impuesto mensual, con un ajuste impositivo anual al presentar la declaración definitiva que deba pagar según la actual ordenanza (Ord. AE Art. 87)."></i>                                                        
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
                        <div class="input-field col s12 m6">
                            <i class="icon-offline_pin prefix tooltipped" data-position="bottom" data-tooltip="Código que revela la ubicación exacta del inmueble."></i>
                            <input type="text" name="code_catastral" id="code_catastral" class="validate" pattern="[0-9A-Z]+" minlength="20" maxlength="20" title="Solo puede usar números y letras en mayúsculas." required>
                            <label for="code_catastral">Código Catastral</label>
                        </div>
                        <div class="input-field col s3 m3">
                            <i class="icon-phone prefix tooltipped" data-position="S" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet<br>251: Local"></i>
                            <select name="country_code" id="country_code" required>
                                <option value="null">...</option>
                                <option value="+58412">(412)</option>
                                <option value="+58414">(414)</option>
                                <option value="+58416">(416)</option>
                                <option value="+58424">(424)</option>
                                <option value="+58426">(426)</option>
                                <option value="+58426">(251)</option>
                            </select>
                            <label for="country_code">Operadora</label>
                        </div>
                        <div class="input-field col s9 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                            <label for="phone">Teléfono</label>
                            <input id="phone" type="tel" name="phone" class="validate" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-directions prefix"></i>
                            <textarea name="address" id="address" cols="30" rows="10" class="materialize-textarea" required></textarea>
                            <label for="address">Dirección</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-cloud_done prefix tooltipped" data-position="bottom" data-tooltip="Se refiere al código del Clasificador Industrial Internacional Uniforme, el mismo facilita a los contribuyentes la ubicación de las actividades por sectores y algunos subgrupos con referencias específicas de su actividad económica (Ord.  AE I Parte Normativa, 6. Régimen Tarifario). "></i>
                            <input type="text" name="search-ciu" >
                            <label>CIU</label>

                        </div>
                        <div class="input-field col s12 m6">
                            <button class="btn btn-large waves-effect waves-light peach col s12 btn-rounded">
                               Buscar
                                <i class="icon-search right"></i>
                            </button>
                        </div>
                        <div class="file-field input-field col s12 12">
                            <div class="btn purple btn-rounded waves-light">
                                 <span><i class="icon-photo_size_select_actual right"></i>Imagen</span>
                                <input type="file" name="image" id="image">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Elige una imagen de referencia de la empresa (LOGO, FACHADA)">
                            </div>
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
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded btn-large waves-effect waves-light peach">
                            Registrar
                            <i class="icon-send right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/company.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap" type="text/javascript"></script>
@endsection