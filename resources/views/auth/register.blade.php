@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m8 offset-m2 l6 offset-l3 animated bounceInDown">
                @foreach ($errors->all() as $error)
                    <div class="message message-danger" style="margin-top: 1rem;">
                        <div class="message-body">
                            <strong>{{ $error }}</strong>
                        </div>
                    </div>
                @endforeach
                <form action="" method="post" class="card bg-light-opacity-8">
                    <div class="card-header center-align">
                        <h5>Registrarse</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s6 m3  tooltipped" data-position="bottom" data-tooltip="V: Venezolano; E: Extranjero">
                            <i class="icon-public prefix"></i>
                            <select name="nationality" id="nationality" required>
                                <option value="null" disabled selected>...</option>
                                <option value="V">V</option>
                                <option value="E">E</option>
                            </select>
                            <label for="nationality">Nacionalidad</label>
                        </div>
                        <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="ci" type="text" name="ci" class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números." maxlength="12" required>
                                <label for="ci">Cedula</label>
                            </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>                            
                            <input id="name" type="text" name="name" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>                            
                            <input id="surname" type="text" name="surname" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet">
                            <i class="icon-phone_android prefix"></i>                            
                            <select name="country_code" id="country_code_user" required>
                                <option value="null" disabled selected>...</option>
                                <option value="+58412">(412)</option>
                                <option value="+58414">(414)</option>
                                <option value="+58416">(416)</option>
                                <option value="+58424">(424)</option>
                                <option value="+58426">(426)</option>
                                <option value="+58251">(251)</option>
                            </select>
                            <label for="country_code">Operadora</label>
                        </div>
                        <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                            <label for="phone_user" >Teléfono</label>
                            <input id="phone_user" type="tel" name="phone" class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required>
                        </div>
                        <div class="input-field col s12 m12">
                            <i class="icon-directions prefix"></i>
                            <textarea name="address" id="address" cols="30" rows="12" data-validate="direccion"
                                      class="materialize-textarea rate" required maxlength="200"></textarea>
                            <label for="address">Dirección</label>
                        </div>
                        <div class="input-field col s12 tooltipped" data-position="bottom" data-tooltip="Ej: correo@mail.com">
                            <i class="icon-mail_outline prefix"></i>
                            <input id="email" type="email" name="email" class="validate" required>
                            <label for="email">E-mail</label>
                        </div>

                        <div class="input-field col s12 tooltipped" data-position="bottom" data-tooltip="Ej: correo@mail.com">
                            <i class="icon-mail_outline prefix"></i>
                            <input id="email-confirm" type="email" name="email-confirm" class="validate" value="" required>
                            <label for="email-confirm">Confirmar E-mail</label>
                        </div>

                        <div class="input-field col s12 tooltipped" data-position="bottom" data-tooltip="Ej: Venezuela1234">
                            <i class="icon-lock prefix"></i>
                            <input id="password" type="password" name="password" class="validate" pattern='[A-Za-z0-9]+{5,20}' minlength="8" title="La contraseña debe tener una logitud mínima de 8 caracteres y contener al menos un letra en mayuscula y un número." required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-lock prefix"></i>
                            <input id="password-confirm" type="password" class="validate" name="password_confirmation" pattern='[A-Za-z0-9]+{5,20}' minlength="8" title="La contraseña debe tener una logitud mínima de 8 caracteres y contener al menos un letra en mayuscula y un número." required>
                            <label for="password-confirm">Confirmar contraseña</label>
                        </div>
                    </div>
                    <div class="card-footer center">
                        <button type="submit" class="btn btn-rounded btn-large peach waves-effect waves-light">
                            Registrarse
                            <i class="icon-send right"></i>
                        </button>
                    </div>
                    <div class="card-footer center-align">
                        <a class="iribarren-wine-text" href="{{ route('login') }}">¿Ya tienes una cuenta? Inicia sesión aquí.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/user.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection