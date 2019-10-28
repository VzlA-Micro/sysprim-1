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
                <form action="#" method="post" id="property" class="card" enctype="multipart/form-data" id="company-register">
                    <div class="card-header center-align">
                        <h5>Registrar Inmueble</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s10 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 1234567890">
                            <input type="text" name="codigo_cadastral" id="codigo_cadastral" class="validate" pattern="[0-9]+" maxlength="20" minlength="20" title="Solo puede escribir números." required>
                            <label for="codigo_catastral">Codigo Catastral</label>
                        </div>

                        <div class="input-field col m6 s12">
                            <select  name="location_cadastral" id="location_cadastral" required>
                                <option value="null" disabled selected>Seleccionar ubicacion Catastral</option>
                                @foreach($catasTerreno as $cT):
                                <option value="{{$cT->id }}">{{ $cT->name}}</option>
                                @endforeach
                            </select>
                            <label>Ubicacion Catastral</label>
                        </div>

                        <div class="input-field col m6 s12">
                            <select  name="type_const" id="type_const" required>
                                <option value="null" disabled selected>Seleccionar tipo de Construccion</option>
                                @foreach($catasConstruccion as $cC):
                                <option value="{{$cC->id }}">{{ $cC->name}}</option>
                                @endforeach
                            </select>
                            <label>Tipo De Construccion</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <input type="text" name="area" id="area" class="validate" pattern="[0-9.]+" data-tooltip="Solo puede usar números y caracter especial(.) . Ej: 15.47" required>
                            <label for="area">Area</label>
                        </div>

                        <div class="input-field col m6 s12">
                            <select  name="parish" id="parish" required>
                                <option value="null" disabled selected>Seleccionar una parroquia</option>
                                @foreach($parish as $parish):
                                <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                                @endforeach
                            </select>
                            <label>Parroquia</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <textarea name="address" id="address" cols="30" rows="10" class="materialize-textarea" required></textarea>
                            <label for="address">Dirección</label>
                        </div>

                        <div class="input-field col s12 location-container tooltipped" data-position="bottom" data-tooltip="Acerca el mapa y selecciona tu ubicación, puede tomar algunos segundos.">
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
                        <button type="submit" class="btn btn-rounded waves-effect waves-light green">Registrar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/property.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap" type="text/javascript"></script>

@endsection