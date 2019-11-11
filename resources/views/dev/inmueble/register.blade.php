@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mis Empresas</a>
                <a href="#!" class="breadcrumb">Registrar Inmueble</a>
            </div>
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                @csrf
                <form class="card" action="#" method="post" id="property" class="" enctype="multipart/form-data">

                    <div class="card-header center-align">
                        <h5>Registrar Inmueble</h5>
                    </div>
                    <div class="card-content row">


                        <div class="center">
                            <span style="font-size:20px">Codigo Catastral</span>
                        </div>
                        <div class="">
                            <div class="input-field col s10 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C1" id="C1" class="validate" pattern="[0-9]+"
                                       maxlength="4" minlength="2" title="Solo puede escribir números."
                                       required value="13" readonly>
                                <label for="C1">Estado</label>
                            </div>
                            <div class="input-field col s10 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C2" id="C2" class="validate" pattern="[0-9]+"
                                       maxlength="4" minlength="2" title="Solo puede escribir números."
                                       required value="3" readonly>
                                <label for="C2">Municipio</label>
                            </div>
                            <div class="input-field col s10 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C3" id="C3" class="validate" pattern="[0-9]+"
                                       maxlength="3" minlength="2" title="Solo puede escribir números."
                                       required>
                                <label for="C3">Parroquia</label>
                            </div>
                            <div class="input-field col s10 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C4" id="C4" class="validate" pattern="[0-9a-zA-Z]+"
                                       maxlength="3" minlength="3" title="Solo puede escribir números."
                                       required>
                                <label for="C4">Sector</label>
                            </div>
                            <div class="input-field col s10 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C5" id="C5" class="validate" pattern="[0-9]+"
                                       maxlength="4" minlength="2" title="Solo puede escribir números."
                                       required>
                                <label for="C5">Comuna</label>
                            </div>
                            <div class="input-field col s10 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C6" id="C6" class="validate" pattern="[0-9]+"
                                       maxlength="4" minlength="3" title="Solo puede escribir números."
                                       required>
                                <label for="C6">Barrio</label>
                            </div>
                            <div class="input-field col s10 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C7" id="C7" class="validate" pattern="[0-9]+"
                                       maxlength="3" minlength="3" title="Solo puede escribir números."
                                       required>
                                <label for="C7">Manzana</label>
                            </div>
                            <div class="input-field col s10 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 1234567890">
                                <input type="text" name="C8" id="C8" class="validate" pattern="[0-9a-zA-Z]+"
                                       maxlength="8" minlength="3" title="."
                                       required>
                                <label for="C8">Terreno</label>
                            </div>
                        </div>
                        <div class="input-field col m6 s12">
                            <select name="location_cadastral" id="location_cadastral" required>
                                <option value="null" disabled selected>Seleccionar ubicacion Catastral</option>
                                @foreach($catasTerreno as $cT):
                                <option value="{{$cT->id }}">{{ $cT->name}}</option>
                                @endforeach
                            </select>
                            <label>Ubicacion Catastral</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <select name="type_const" id="type_const" required>
                                <option value="null" disabled selected>Seleccionar tipo de Construccion</option>
                                @foreach($catasConstruccion as $cC):
                                <option value="{{$cC->id }}">{{ $cC->name}}</option>
                                @endforeach
                            </select>
                            <label>Tipo De Construccion</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="area_ground" id="area" class="validate" pattern="[0-9.]+"
                                   data-tooltip="Solo puede usar números y caracter especial(.) . Ej: 15.47"
                                   required>
                            <label for="area">Area De Terreno</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="area_build" id="area" class="validate" pattern="[0-9.]+"
                                   data-tooltip="Solo puede usar números y caracter especial(.) . Ej: 15.47"
                                   required>
                            <label for="area">Area De Construcción</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <select name="parish" id="parish" required>
                                <option value="null" disabled selected>Seleccionar una parroquia</option>
                                @foreach($parish as $parish):
                                <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                                @endforeach
                            </select>
                            <label>Parroquia</label>
                        </div>
                        <div class="input-field col s12 m6">
                        <textarea name="address" id="address" cols="30" rows="10" class="materialize-textarea"
                                  required></textarea>
                            <label for="address">Dirección</label>
                        </div>
                        <div class="input-field col s12 location-container tooltipped" data-position="bottom"
                             data-tooltip="Acerca el mapa y selecciona tu ubicación, puede tomar algunos segundos.">
                            <span>Elige con mas exactitud la ubicación de tu Inmueble:</span>
                            <div id="map" style="height: 500px;width: 100%; margin-top:1rem"></div>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="lat" type="text" name="lat" value="" readonly>
                            <label for="lat">Latitud</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="lng" type="text" name="lng" value="" readonly>
                            <label for="lat">Logintud</label>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded waves-effect waves-light green">Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/property.js') }}"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap"
            type="text/javascript"></script>

@endsection