@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mis Empresas</a>
                <a href="{{ route('companies.details', ['id' => $company->id]) }}" class="breadcrumb">{{ $company->name }}</a>
                <a href="#!" class="breadcrumb">Modificar</a>
            </div>
            <div class="col s12 m8 l8 offset-m3 offset-l2">
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
                        <div class="input-field col s12 m6 tooltipped" data-position="left" data-tooltip="Razón social o nombre de la empresa.">
                            <i class="icon-work prefix"></i>                                                        
                            <input type="text" name="name" id="name" class="validate"  pattern="[0-9A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ .,!?_-&%+-$]+" title="Solo puede usar letras (con acentos), números y los caracteres especiales: . , $ ! ? % + -" value="{{ $company->name }}" required disabled>
                            <label for="name">Razón Social</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="left" data-tooltip="Puede escribir: J, G ó V y números. Ej: J1234567890">
                            <i class="icon-perm_contact_calendar prefix"></i>                            
                            <input type="text" name="RIF" id="RIF" class="validate" pattern="[0-9JGV]+" title="Puede escribir: J = Juridico, G = Gubernamental, V = Venezolano y números." value="{{ $company->RIF }}" required disabled>
                            <label for="RIF">RIF</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="left" data-tooltip="Solo puede usar números y letras en mayúsculas. Ej: A1B2C3">
                            <i class="icon-chrome_reader_mode prefix"></i>                                                                                    
                            <input type="text" name="license" id="license" class="validate" pattern="[0-9A-Z]+" title="Solo puede usar números y letras en mayúsculas." value="{{ $company->license }}" required disabled>
                            <label for="license">Licencia</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>                                                        
                            <input type="text" name="opening_date" id="opening_date" class="datepicker" value="{{ $company->opening_date }}" required disabled>
                            <label for="opening_date">Fecha de Apertura</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-supervisor_account prefix"></i>                                                                                    
                            <input type="number" name="number_employees" id="number_employees" class="validate" pattern="[0-9]+" title="Solo puede usar números" value="{{ $company->number_employees }}" required >
                            <label for="number_employees">Numero de Empleados</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <i class="icon-public prefix"></i>                                                        
                            <select  name="sector" id="sector" required>
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
                            <input type="text" name="code_catastral" id="code_catastral" class="validate" pattern="[0-9A-Z]+" minlength="20" maxlength="20" title="Solo puede usar números y letras en mayúsculas." value="{{ $company->code_catastral }}" required>
                            <label for="code_catastral">Código Catastral</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="left" data-tooltip="Ej: 02511234567">
                            <i class="icon-phone prefix"></i>                            
                            <label for="phone">Teléfono de la Empresa</label>
                            <input id="phone" type="tel" name="phone" class="validate" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 025161234567" value="{{ $company->phone }}" required>
                        </div>
                        <div class="input-field col m6 s12">
                            <i class="icon-satellite prefix"></i>
                            <select  name="parish" required>
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
                            <textarea name="address" id="address" cols="30" rows="10" class="materialize-textarea" required>{{ $company->address }}</textarea>
                            <label for="address">Dirección</label>
                        </div>

                        <input id="lat" type="hidden" name="lat" value="{{ $company->lat }}">
                        <input id="lng" type="hidden" name="lng" value="{{ $company->lng }}">

                        @foreach($company->ciu as $ciu)
                        <input type="hidden" name="ciu[]" id="ciu" class="ciu" value="{{$ciu->id}}">
                        <div class="input-field col s12 m6">
                            <i class="icon-assignment prefix"></i>
                            <input type="text" name="search-ciu" id="ciu"  disabled value="{{$ciu->code}}">
                            <label>CIIU</label>
                        </div>
                        <div class="input-field col s10 m6"  >
                            <i class="icon-text_fields prefix"></i>
                            <label for="phone">Nombre</label>
                            <textarea name="name-ciu" id="nombre" cols="30" rows="10" class="materialize-textarea" disabled required>{{$ciu->name}}</textarea>
                        </div>
                        @endforeach

                        <div class="input-field col s12 location-container tooltipped" data-position="left" data-tooltip="Acerca el mapa y selecciona tu ubicación, puede tomar algunos segundos.">
                            <span>Elige la  ubicación de tu empresa:</span>
                            <div id="map" style="height: 500px;width: 100%; margin-top:1rem"></div>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded btn-large waves-effect waves-light peach">
                            <i class="icon-send right"></i>
                            Actualizar
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

@endsection