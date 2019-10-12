@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mi Empresa</a>
                <a href="{{ route('companies.details', ['id' => $company->id]) }}" class="breadcrumb">{{ $company->name }}</a>
                <a href="" class="breadcrumb">Modificar</a>
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
                        <div class="input-field col s12 m6">
                            <input type="text" name="name" id="name" class="validate" pattern="[0-9A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ .,!?_-&%+-$]+" title="Solo puede usar letras (con acentos), números y los caracteres especiales: . , $ ! ? % + -" value="{{ $company->name }}" required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="RIF" id="RIF" class="validate" pattern="[0-9J-]+" title="Solo puede escribir números." value="{{ $company->RIF }}" required>
                            <label for="RIF">RIF</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="license" id="license" class="validate" pattern="[0-9A-Z]+" title="Solo puede usar números y letras en mayúsculas." value="{{ $company->license }}" required>
                            <label for="license">Licencia</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="opening_date" id="opening_date" class="datepicker" value="{{ $company->opening_date }}" required>
                            <label for="opening_date">Fecha de Apertura</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <input type="number" name="number_employees" id="number_employees" class="validate" pattern="[0-9]+" title="Solo puede usar números" value="{{ $company->number_employees }}" required>
                            <label for="number_employees">Numero de Empleados</label>
                        </div>


                        <div class="input-field col s10 m6">
                            <label for="phone">Teléfono de la Empresa</label>
                            <input id="phone" type="tel" name="phone" class="validate" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 025161234567" value="{{$company->phone}}" required>
                        </div>

                        <div class="input-field col m6 s12">
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
                            <label>Ubicación geográfica </label>
                        </div>

                        <input id="lat" type="hidden" name="lat" value="{{$company->lat}}">
                        <input id="lng" type="hidden" name="lng" value="{{$company->lng}}">

                        <div class="input-field col m6 s12">
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
                            <input type="text" name="code_catastral" id="code_catastral" class="validate" pattern="[0-9A-Z]+"  value="{{ $company->code_catastral }}" minlength="20" maxlength="20" title="Solo puede usar números y letras en mayúsculas." required>
                            <label for="code_catastral">CÓDIGO CATASTRAL</label>
                        </div>

                       <div class="input-field col s6 m6">
                        <textarea name="address" id="" cols="30" rows="10" class="materialize-textarea" required>{{ $company->address }}</textarea>
                        <label for="address">Dirección</label>
                    </div>

                        <div class="input-field col s12">
                            <select multiple name="ciu[]">
                                @php $band=false @endphp;

                                @foreach($ciu as $ciu):
                                    @foreach($company->ciu as $ciu_selected)
                                        @if($ciu_selected->id==$ciu->id)
                                            <option value="{{ $ciu->id }}"@if($ciu_selected->id==$ciu->id){{"selected"}}@endif>{{ $ciu->name }} </option>
                                            @php $band=true @endphp;
                                         @endif
                                     @endforeach

                                    @if(!$band)
                                         <option value="{{ $ciu->id }}">{{ $ciu->name }} </option>
                                    @endif
                                     @php $band=false @endphp;
                                @endforeach
                            </select>
                            <label>Agregar CIU</label>
                        </div>
                        <div class="input-field col s12 location-container">
                            <span>Elige tu ubicación:</span>
                            <div id="map" style="height: 500px;width: 800px;" class="s12"></div>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn waves-effect waves-light green">Actualizar</button>
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