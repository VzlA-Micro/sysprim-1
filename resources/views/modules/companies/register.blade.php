@extends('layouts.app')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form action="#" method="post" class="card" enctype="multipart/form-data" id="company-register">
                    <div class="card-header center-align">
                        <h5>Registrar mi empresa</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <input type="text" name="name" id="name" class="validate"  title="Solo puede usar letras (con acentos), números y los caracteres especiales: . , $ ! ? % + -" required>
                            <label for="name">Nombre</label>
                        </div>
                        
                        <div class="input-field col s12 m6">
                            <input type="text" name="RIF" id="RIF" class="validate" pattern="[0-9J-]+" title="Solo puede escribir números." value="J-" required>
                            <label for="RIF">RIF</label>
                        </div>
                        <div class="input-field col s12 m6">
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
                                <option value="NORTE">NORTE</option>
                                <option value="SUR">SUR</option>
                            </select>
                            <label>Ubicación geográfica </label>
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
                            <input type="text" name="code_catastral" id="code_catastral" class="validate" pattern="[0-9A-Z]+" minlength="20" maxlength="20" title="Solo puede usar números y letras en mayúsculas." required>
                            <label for="code_catastral">CÓDIGO CATASTRAL</label>
                        </div>



                        <div class="input-field col s12">
                            <textarea name="address" id="address" cols="30" rows="10" class="materialize-textarea" required></textarea>
                            <label for="address">Dirección</label>
                        </div>


                        <div class="input-field col s12">
                            <select multiple name="ciu[]" required id="ciu">
                                <option value="null" disabled >Seleccionar CIU</option>
                                @foreach($ciu as $ciu):
                                    <option value="{{ $ciu->id }}">{{ $ciu->name }}</option>
                                @endforeach
                            </select>
                            <label>CIU</label>
                        </div>



                        <div class="file-field input-field col s12 12">
                            <div class="btn purple btn-rounded waves-light">
                                <span><i class="icon-photo_size_select_actual right"></i>Imagen</span>
                                <input type="file" name="image" id="image">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Elige una imagen">
                            </div>
                        </div>
                        <div class="input-field col s12 location-container">
                            <span>Elige tu ubicación:</span>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded waves-effect waves-light green">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/company.js') }}"></script>
@endsection