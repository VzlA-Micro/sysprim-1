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
                <form action="" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Empresa</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 tooltipped" data-position="bottom" data-tooltip="Ej: V12345678">
                            <input type="text" name="cedula" id="cedula" value="V" pattern="[0-9V]+" title="Solo puede usar números y V en mayúscula." class="validate" required>
                            <label for="cedula">Cedula</label>
                        </div>
                        <input type="hidden" name="id">
                        <div class="input-field col s2 tooltipped" data-position="bottom" data-tooltip="Seleccione: J = Juridico, G = Gubernamental ó V = Venezolano.">
                            <select name="document_type" id="document_type">
                                <option value="null" selected disabled>...</option>
                                <option value="J">J</option>
                                <option value="V">V</option>
                                <option value="G">G</option>
                            </select>
                            <label for="document_type">Documento</label>
                        </div>
                        <div class="input-field col s10 m4 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 1234567890">
                            <input type="text" name="RIF" id="RIF" class="validate" pattern="[0-9]+" maxlength="10" minlength="8" title="Solo puede escribir y números." required>
                            <label for="RIF">RIF</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Razón social o nombre de la empresa.">
                            <input type="text" name="name" id="name" class="validate"  title="Solo puede usar letras (con acentos), números y los caracteres especiales: . , $ ! ? % + -" required>
                            <label for="name">Razón Social</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede usar números y letras en mayúsculas. Ej: A1B2C3">
                            <input type="text" name="license" id="license" class="validate" pattern="[0-9A-Z]+" title="Solo puede usar números y letras en mayúsculas." required>
                            <label for="license">Licencia</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="opening_date" id="opening_date" class="datepicker" required>
                            <label for="opening_date">Fecha de Apertura</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="number_employees" id="number_employees" class="validate" pattern="[0-9]+" title="Solo puede usar números" required>
                            <label for="number_employees">Numero de Empleados</label>
                        </div>
                        <div class="input-field col m6 s12">
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
                        {{-- ENviar parroquias al formulario --}}
                        {{-- <div class="input-field col m6 s12">
                            <select  name="parish" id="parish" required>
                                <option value="null" disabled selected>Seleccionar una parroquia</option>
                                @foreach($parish as $parish):
                                <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                                @endforeach
                            </select>
                            <label>Parroquia</label>
                        </div> --}}
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Código que revela la ubicación exacta del inmueble.">
                            <input type="text" name="code_catastral" id="code_catastral" class="validate" pattern="[0-9A-Z]+" minlength="20" maxlength="20" title="Solo puede usar números y letras en mayúsculas." required>
                            <label for="code_catastral">Código Catastral</label>
                        </div>
                        <div class="input-field col s10 m6 tooltipped" data-position="bottom" data-tooltip="Ej: 02511234567">
                            <label for="phone">Teléfono de la Empresa</label>
                            <input id="phone" type="tel" name="phone" class="validate"  maxlength="11" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 025161234567" required>
                        </div>
                        <div class="input-field col s12">
                            <textarea name="address" id="address" cols="30" rows="10" class="materialize-textarea" required></textarea>
                            <label for="address">Dirección</label>
                        </div>
                        <div id="box">
                            {{-- Agregar condicional si es taquillero --}}
                            <div class="input-field col s10 tooltipped" data-position="bottom" data-tooltip="Ej: 000000">
                                <label for="ciu_code[]">Codígo del CIU</label>
                                <input id="ciu_code[]" type="text" name="ciu_code[]" class="validate"  maxlength="6" pattern="[0-9]+" title="Solo puede escribir números." required>
                            </div>
                            {{-- Agregar boton para nuevo ciu --}}
                            <div class="input-field col s2 center-align">
                                <button class="btn green add_ciu"><i class="icon-add"></i></button>
                            </div>
                        </div>
                        {{-- Si es usuario, coloca el codigo del ciu --}}
                        <div class="input-field col s12 location-container tooltipped" data-position="bottom" data-tooltip="Acerca el mapa y selecciona tu ubicación, puede tomar algunos segundos.">
                            <span>Elige la  ubicación de tu empresa:</span>
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
    <script>
        $(document).ready(function() {
            $('.add_ciu').click(function() {
                var elem = `
                    <div class="input-field col s10 tooltipped" data-position="bottom" data-tooltip="Ej: 000000">
                        <label for="ciu_code[]">Codígo del CIU</label>
                        <input id="ciu_code[]" type="text" name="ciu_code[]" class="validate"  maxlength="6" pattern="[0-9]+" title="Solo puede escribir números." required>
                    </div>
                    <div class="input-field col s2 center-align">
                        <button class="btn green" id="add_ciu"><i class="icon-add"></i></button>
                    </div>
                `;
                // $(this).hide();
                $('#box').append(elem);
            });
        });
    </script>
@endsection