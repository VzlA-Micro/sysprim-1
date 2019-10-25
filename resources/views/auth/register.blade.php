@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m8 offest-m2 l6 offset-l3 animated bounceInDown">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" style="margin-top: 1rem;">{{ $error }}</div>
                @endforeach
                <form action="" method="post" class="card bg-light-opacity-8">
                    <div class="card-header center-align">
                        <h5>Registrarse</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s2 tooltipped" data-position="bottom" data-tooltip="V: Venezolano; E: Extrangero">
                            <select name="nationality" id="nationality" required>
                                <option value="null">...</option>
                                <option value="V">V</option>
                                <option value="E">E</option>
                            </select>
                            <label for="nationality">Nacionalidad</label>
                        </div>
                        <div class="input-field col s10 m4 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="ci" type="text" name="ci" class="validate" pattern="[0-9]+" title="Solo puede escribir números." required>
                                <label for="ci">Cedula</label>
                            </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                            <input id="name" type="text" name="name" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                            <input id="surname" type="text" name="surname" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s2 tooltipped" data-position="bottom" data-tooltip="412: Digitel; 414/424: Movistar; 416/426: Movilnet">
                            <select name="country_code" id="country_code" required>
                                <option value="null">...</option>
                                <option value="+58412">(412)</option>
                                <option value="+58414">(414)</option>
                                <option value="+58416">(416)</option>
                                <option value="+58424">(424)</option>
                                <option value="+58426">(426)</option>
                            </select>
                            <label for="country_code">Operadora</label>
                        </div>
                        <div class="input-field col s10 m4 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                            <label for="phone">Teléfono</label>
                            <input id="phone" type="tel" name="phone" class="validate" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required>
                        </div>
                        <div class="input-field col s12">
                            <select name="type" id="type" required>
                                <option value="null" disabled selected>Elige un tipo...</option>
                                <option value="natural">Natural</option>
                                <option value="business">Juridica</option>
                              </select>
                              <label for="type">Tipo de Persona</label>
                        </div>
                        <div class="input-field col s12 tooltipped" data-position="bottom" data-tooltip="Ej: correo@mail.com">
                            <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}" required>
                            <label for="email">E-mail</label>
                        </div>
                        <div class="input-field col s12 tooltipped" data-position="bottom" data-tooltip="Ej: Venezuela1234">
                            <input id="password" type="password" name="password" class="validate" pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' minlength="8" title="La contraseña debe tener una logitud mínima de 8 caracteres y contener al menos un letra en mayuscula y un número." required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="password-confirm" type="password" class="validate" name="password_confirmation" pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' minlength="8" title="La contraseña debe tener una logitud mínima de 8 caracteres y contener al menos un letra en mayuscula y un número." required>
                            <label for="password-confirm">Confirmar contraseña</label>
                        </div>
                    </div>
                    <div class="card-footer center">
                        <button type="submit" class="btn btn-rounded green waves-effect waves-light">Registarse</button>
                    </div>
                    <div class="card-footer center-align">
                        <a href="{{ route('login') }}">¿Ya tienes una cuenta? Inicia sesión aquí.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/user.js') }}"></script>
@endsection