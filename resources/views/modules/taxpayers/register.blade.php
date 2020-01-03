@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    {{-- <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li> --}}
                    <li class="breadcrumb-item"><a href="{{ route('taxpayers.manage') }}">Gestionar Usuarios Web</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('taxpayers.register') }}">Registrar Usuario Web</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
            	<form action="" method="post" class="card" id="register">
            		<div class="card-header center-align">
                        <h5>Registrar Usuario Web</h5>
            		</div>
            		<div class="card-content row">
            			@csrf
                        <input type="hidden" value="1" name="confirmed">
                        <div class="input-field col s6 m3">
                            <i class="icon-public prefix tooltipped" data-position="bottom" data-tooltip="V: Venezolano<br>E: Extranjero"></i>
                            <select name="nationality" id="nationality" required>
                                <option value="null">...</option>
                                <option value="V">V</option>
                                <option value="E">E</option>
                            </select>
                            <label for="nationality">Nacionalidad</label>
                        </div>
                        <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="ci" type="text" name="ci" class="validate number-only" pattern="[0-9]+" maxlength="8" title="Solo puede escribir números." required>
                                <label for="ci">Cedula</label>
                            </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-person prefix tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos)."></i>
                            <input id="name" type="text" name="name" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-person prefix tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos)."></i>
                            <input id="surname" type="text" name="surname" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <i class="icon-phone_android prefix tooltipped" data-position="bottom" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet"></i>
                            <select name="country_code" id="country_code_user" required>
                                <option value="null" selected disabled>...</option>
                                <option value="+58412">(412)</option>
                                <option value="+58414">(414)</option>
                                <option value="+58416">(416)</option>
                                <option value="+58424">(424)</option>
                                <option value="+58426">(426)</option>
                            </select>
                            <label for="country_code_user">Operadora</label>
                        </div>
                        <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                            <label for="phone_user">Teléfono</label>
                            <input id="phone_user" type="tel" name="phone" class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required>
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-mail_outline prefix tooltipped" data-position="bottom" data-tooltip="Ej: correo@mail.com"></i>
                            <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}" required>
                            <label for="email">E-mail</label>
                        </div>
                        <input type="hidden" name="role" id="role" value="3">
            		</div>
            		<div class="card-footer center">
                        <button type="submit" class="btn btn-rounded btn-large peach waves-effect waves-light" id="button-user">
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
    <script src="{{ asset('js/data/taxpayers.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection