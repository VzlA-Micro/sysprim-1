@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    @if(session()->has('company'))
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.details', ['id' => session('company')->id]) }}">{{ session('company')->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="{{ route('properties.my-properties') }}">Mis Inmuebles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.register') }}">Registrar Inmueble</a></li>
                </ul>
            </div>
            <div class="col s12 m10 l8 offset-m1 offset-l2">
                <form action="" method="post" id="property" class="card">
                    @csrf
                    <ul class="tabs">
                        <li class="tab col s6" id="one"><a href="#user-tab"><i class="icon-filter_1"></i> Datos Generales</a></li>
                        <li class="tab col s6 disabled" id="two"><a href="#property-tab"><i class="icon-filter_2"></i> Datos del Inmueble</a></li>
                    </ul>
                    <div id="user-tab">
                        <div class="card-header center-align">
                            <h5>Datos Generales</h5>
                        </div>
                        <div class="card-content row">
                            <div class="input-field col s12">
                                <i class="icon-person prefix"></i>
                                <select name="status" id="status" required>
                                    @if($company != '')
                                    <option value="null" disabled>Selecciona Condicion</option>
                                    <option value="propietario" selected>Propietario</option>
                                    <option value="responsable" disabled="">Responsable</option>
                                    @else
                                    <option value="null" disabled selected>Selecciona Condicion</option>
                                    <option value="propietario">Propietario</option>
                                    <option value="responsable">Responsable</option>
                                    @endif
                                </select>
                                <label for="model">Condición Legal</label>
                            </div>
                            <div id="content">

                            </div>
                        </div>
                        <div class="card-footer right-align">
                            <a href="#" id='data-next' class="btn peach waves-effect waves-light">
                                Siguiente
                                <i class="icon-navigate_next right"></i>
                            </a>
                        </div>
                    </div>
                    <div id="property-tab">
                        <div class="card-header center-align">
                            <h5>Datos del Inmueble</h5>
                        </div>
                        @if($company != '')
                        <input type="hidden" name="id" value="{{ $company->id }}" id="id">
                        <input type="hidden" name="type" value="company" id="type">
                        @else
                        <input type="hidden" name="id" value="" id="id">
                        <input type="hidden" name="type" value="" id="type">
                        @endif
                        <div class="card-content row">
                            <div class="center-align">
                                <span style="font-size: 20px">Codigo Catastral</span>
                            </div>
                            <div class="input-field col s12 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C1" id="C1" class="validate number-only" pattern="[0-9]+"
                                       maxlength="4" minlength="2" title="Solo puede escribir números."
                                       required value="13" readonly>
                                <label for="C1">Estado</label>
                            </div>
                            <div class="input-field col s12 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C2" id="C2" class="validate number-only" pattern="[0-9]+"
                                       maxlength="4" minlength="2" title="Solo puede escribir números."
                                       required value="3" readonly>
                                <label for="C2">Municipio</label>
                            </div>
                            <div class="input-field col s12 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C3" id="C3" class="validate number-only" pattern="[0-9]+"
                                       maxlength="3" minlength="2" title="Solo puede escribir números."
                                       required>
                                <label for="C3">Parroquia</label>
                            </div>
                            <div class="input-field col s12 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C4" id="C4" class="validate number-only" pattern="[0-9a-zA-Z]+"
                                       maxlength="3" minlength="3" title="Solo puede escribir números."
                                       required>
                                <label for="C4">Sector</label>
                            </div>
                            <div class="input-field col s12 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C5" id="C5" class="validate number-only" pattern="[0-9]+"
                                       maxlength="4" minlength="2" title="Solo puede escribir números."
                                       required>
                                <label for="C5">Comuna</label>
                            </div>
                            <div class="input-field col s12 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C6" id="C6" class="validate number-only" pattern="[0-9]+"
                                       maxlength="4" minlength="3" title="Solo puede escribir números."
                                       required>
                                <label for="C6">Barrio</label>
                            </div>
                            <div class="input-field col s12 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C7" id="C7" class="validate number-only" pattern="[0-9]+"
                                       maxlength="3" minlength="3" title="Solo puede escribir números."
                                       required>
                                <label for="C7">Manzana</label>
                            </div>
                            <div class="input-field col s12 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C8" id="C8" class="validate number-only" pattern="[0-9a-zA-Z]+"
                                       maxlength="8" minlength="3" title="."
                                       required>
                                <label for="C8">Terreno</label>
                            </div>
                            <div class="input-field col m6 s12">
                                <i class="icon-map prefix"></i>
                                <select name="location_cadastral" id="location_cadastral" required>
                                    <option value="null" disabled selected>Seleccionar ubicacion Catastral</option>
                                    @foreach($catasTerreno as $cT):
                                    <option value="{{$cT->id }}">{{ $cT->name}}</option>
                                    @endforeach
                                </select>
                                <label>Ubicación Catastral</label>
                            </div>
                            <div class="input-field col m6 s12">
                                <i class="icon-domain prefix"></i>
                                <select name="type_const" id="type_const" required>
                                    <option value="null" disabled selected>Seleccionar Tipo de Construccion</option>
                                    @foreach($catasConstruccion as $cC):
                                    <option value="{{$cC->id }}">{{ $cC->name}}</option>
                                    @endforeach
                                </select>
                                <label>Tipo de Construccion</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="icon-panorama_horizontal prefix"></i>
                                <input type="text" name="area_ground" id="area_ground" class="validate number-only only-number-positive" maxlength="5" pattern="[0-9.]+"
                                       data-tooltip="Solo puede usar números y caracter especial(.) . Ej: 15.47"
                                       required>
                                <label for="area_ground">Area de Terreno</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-location_city prefix"></i>
                                <input type="text" name="area_build" id="area_build" class="validate number-only only-number-positiv "   maxlength="3"  pattern="[0-9.]+"
                                       data-tooltip="Solo puede usar números y caracter especial(.) . Ej: 15.47"
                                       required>
                                <label for="area_build">Area de Construcción</label>
                            </div>

                            <div class="input-field col m6 s12">
                                <i class="icon-domain prefix"></i>
                                <select name="type_inmueble_id" id="type_inmueble_id" required>
                                    <option value="null" disabled selected>Seleccionar Tipo de Inmueble</option>
                                    @foreach($alicuota as $value):
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                <label>Tipo de Inmueble</label>
                            </div>

                            <div class="input-field col m6 s12">
                                <i class="icon-satellite prefix"></i>
                                <select name="parish" id="parish" required>
                                    <option value="null" disabled selected>Seleccionar una Parroquia</option>
                                    @foreach($parish as $parish):
                                    <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                                    @endforeach
                                </select>
                                <label>Parroquia</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-directions prefix"></i>
                                <textarea name="address" id="address" cols="30" rows="12" class="materialize-textarea" required maxlength="200"></textarea>
                                <label for="address">Dirección</label>
                            </div>
                            <div class="input-field col s12 location-container tooltipped" data-position="bottom"
                                 data-tooltip="Acerca el mapa y selecciona tu ubicación, puede tomar algunos segundos.">
                                <span>Elige con mas exactitud la ubicación de tu Inmueble:</span>
                                <div id="map" style="height: 500px;width: 100%; margin-top:1rem"></div>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-location_searching prefix"></i>
                                <input id="lat" type="text" name="lat" value="" readonly>
                                <label for="lat">Latitud</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-location_searching prefix"></i>
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
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/property.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap"
            type="text/javascript"></script>
@endsection