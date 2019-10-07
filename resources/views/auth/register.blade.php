@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m8 offest-m2 l6 offset-l3">
                <form action="" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrarse</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s2">
                            <select name="nationality" id="nationality" required>
                                <option value="null">...</option>
                                <option value="V-">V</option>
                                <option value="E-">E</option>
                            </select>
                            <label for="nationality">Nacionalidad</label>
                        </div>
                        <div class="input-field col s10 m4">
                                <input id="ci" type="text" name="ci" class="validate" pattern="[0-9]+" title="Solo puede escribir números." required>
                                <label for="ci">Cedula</label>
                            </div>
                        <div class="input-field col s12 m6">
                            <input id="name" type="text" name="name" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ]+" title="Solo puede agregar letras (con acentos)." required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="surname" type="text" name="surname" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ]+" title="Solo puede agregar letras (con acentos)." required>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s2">
                            <select name="country_code" id="country_code" required>
                                <option value="null">...</option>
                                <option value="+58">+58</option>
                            </select>
                            <label for="country_code">Código</label>
                        </div>
                        <div class="input-field col s10 m4">
                            <label for="phone">Teléfono</label>
                            <input id="phone" type="tel" name="phone" class="validate" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 4161234567" required>
                        </div>
                        <div class="input-field col s12">
                            <select name="type" id="type" required>
                                <option value="null" disabled selected>Elige un tipo...</option>
                                <option value="natural">Natural</option>
                                <option value="business">Juridica</option>
                              </select>
                              <label for="type">Tipo de Persona</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}" required>
                            <label for="email">E-mail</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="password" type="password" name="password" class="validate" pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' minlength="8" title="La contraseña debe tener una logitud mínima de 8 caracteres y contener al menos un letra en mayuscula y un número." required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="password-confirm" type="password" class="validate" name="password_confirmation" pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' minlength="8" title="La contraseña debe tener una logitud mínima de 8 caracteres y contener al menos un letra en mayuscula y un número." required>
                            <label for="password-confirm">Confirmar contraseña</label>
                        </div>
                    </div>
                    <div class="card-action center">
                        <button type="submit" class="btn green">Registarse</button>
                    </div>
                    <div class="card-footer center-align">
                        <a href="{{ route('login') }}">¿Ya tienes una cuenta? Inicia sesión aquí.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection