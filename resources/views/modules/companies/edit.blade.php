@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.details', ['id' => $company->id]) }}">{{ $company->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.edit', ['id' => $company->id]) }}">Editar</a></li>
                </ul>
            </div>
            <div class="col s12 m12 l10 offset-l1">
                <form action="{{ route('companies.update') }}" method="post" class="card" enctype="multipart/form-data">
                    <div class="card-header center-align">
                        <h5>Editar datos de mi empresa</h5>
                    </div>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    <div class="card-content row">
                        @csrf
                        <input type="hidden" name="id" name="id" value="{{ $company->id }}">
                        <div class="input-field col s4 m3">
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
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Razón social o nombre de la empresa.">
                            <i class="icon-work prefix"></i>                                                        
                            <input type="text" name="name" id="name" class="validate"  pattern="[0-9A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ .,!?_-&%+-$]+" title="Solo puede usar letras (con acentos), números y los caracteres especiales: . , $ ! ? % + -" value="{{ $company->name }}" required readonly>
                            <label for="name">Razón Social</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede usar números y letras en mayúsculas. Ej: A1B2C3">
                            <i class="icon-chrome_reader_mode prefix"></i>                                                                                    
                            <input type="text" name="license" id="license" class="validate" pattern="[0-9A-Z]+" title="Solo puede usar números y letras en mayúsculas." value="{{ $company->license }}" required readonly>
                            <label for="license">Licencia</label>
                        </div>
                         @if($company->opening_date)
                        <div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>                                                        
                            <input type="text" name="opening_date" id="opening_date" class="datepicker" value="{{ $company->opening_date }}" required readonly>
                            <label for="opening_date">Fecha de Apertura</label>
                        </div>
                        @endif
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
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Código que revela la ubicación exacta del inmueble.">
                            <i class="icon-offline_pin prefix"></i>                            
                            <input type="text" name="code_catastral" id="code_catastral" class="validate" pattern="[0-9A-Z]+" minlength="20" maxlength="20" title="Solo puede usar números y letras en mayúsculas." value="{{ $company->code_catastral }}" readonly required>
                            <label for="code_catastral">Código Catastral</label>
                        </div>
                        <div class="input-field col s4 m3">
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
                        <div class="input-field col s8 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                            <label for="phone">Teléfono</label>
                            <input id="phone" type="tel" name="phone" value="{{ $company->numberPhone }}" class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required readonly>
                        </div>
                        <div class="input-field col m6 s12">
                            <i class="icon-satellite prefix"></i>
                            <select  name="parish" required disabled>
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
                        @if($company->opening_date)
                        <div class="input-field col s12 m6">
                            <i class="icon-directions prefix"></i>
                            <textarea name="address" id="address" cols="30" rows="10" class="materialize-textarea" required readonly>{{ $company->address }}</textarea>
                            <label for="address">Dirección</label>
                        </div>
                        @else
                            <div class="input-field col s12 m12">
                                <i class="icon-directions prefix"></i>
                                <textarea name="address" id="address" cols="30" rows="10" class="materialize-textarea" required readonly>{{ $company->address }}</textarea>
                                <label for="address">Dirección</label>
                            </div>
                        @endif

                        <input id="lat" type="hidden" name="lat" value="{{ $company->lat }}">
                        <input id="lng" type="hidden" name="lng" value="{{ $company->lng }}">

                        @foreach($company->ciu as $ciu)
                        <div class="input-field col s12 m4">
                            <i class="icon-cloud_done prefix tooltipped" data-position="bottom" data-tooltip="Se refiere al código del Clasificador Industrial Internacional Uniforme, el mismo facilita a los contribuyentes la ubicación de las actividades por sectores y algunos subgrupos con referencias específicas de su actividad económica (Ord.  AE I Parte Normativa, 6. Régimen Tarifario). "></i>
                            <input type="text" name="code" id="code" maxlength="6" class="validate number-only" pattern="[0-9]+" value="{{ $ciu->code }}" disabled="">
                            <label for="code">CIIU</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>
                            <textarea name="name" id="name" cols="30" rows="10" class="materialize-textarea" disabled>{{ $ciu->name }}</textarea>
                            <label for="name">Nombre</label>
                        </div>

                            @if($ciu->pivot->status=='disabled')
                                <div class="input-field col s12 m2" id="bDelete">
                                    <span class="center-align">Estado:</span>
                                    <button type="button"
                                            class="btn waves-effect waves-light red col s12  disabled-ciu-selected"
                                            value="{{$ciu->id}}" data-ciiu="enabled">

                                        <i class="icon-do_not_disturb_alt "></i></button>

                                </div>
                            @else
                                <div class="input-field col s12 m2" id="bDelete">
                                    <span class="center-align">Estado:</span>
                                    <button type="button"
                                            class="btn waves-effect waves-light green col s12  disabled-ciu-selected"
                                            value="{{$ciu->id}}" data-ciiu="disabled">
                                        <i class="icon-check"></i></button>
                                </div>
                            @endif

                        @endforeach

                        <div class="input-field col s12 location-container tooltipped" data-position="bottom" data-tooltip="Acerca el mapa y selecciona tu ubicación, puede tomar algunos segundos.">
                            <span>Elige la  ubicación de tu empresa:</span>
                            <div id="map" style="height: 500px;width: 100%; margin-top:1rem"></div>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button onclick="window.history.back();" type="button" class="btn btn-rounded btn-large waves-effect waves-light peach">
                            <i class="icon-navigate_before right"></i>
                            Atras
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/company-edit.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU" type="text/javascript"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection