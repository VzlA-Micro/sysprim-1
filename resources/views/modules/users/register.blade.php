@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.manage') }}">Gestionar Usuarios (Admin)</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.register') }}">Registrar Usuario</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1 l8 offset-l2">
                <form action="#" id="gestionUser" method="post" class="card" enctype="multipart/form-data">
                    <div class="card-header center-align">
                        <h5>Registrar Usuario</h5>
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
                        <div class="input-field col s12">
                            <i class="icon-lock prefix tooltipped" data-position="bottom" data-tooltip="Ej: Venezuela1234"></i>
                            <input id="password" type="password" name="password" class="validate" pattern='[A-Za-z0-9]+{5,20}' minlength="8" title="La contraseña debe tener una logitud mínima de 8 caracteres y contener al menos un letra en mayuscula y un número." required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-lock prefix"></i>
                            <input id="password-confirm" type="password" class="validate" name="password_confirmation" pattern='[A-Za-z0-9]+{5,20}' minlength="8" title="La contraseña debe tener una logitud mínima de 8 caracteres y contener al menos un letra en mayuscula y un número." required>
                            <label for="password-confirm">Confirmar contraseña</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-recent_actors prefix"></i>
                            <select  name="role" id="role" required>
                                <option value="null" disabled selected>Selecciona rol</option>
                                @foreach($Role as $rol):
                                    <option value="{{$rol->id }}">{{ $rol->name}}</option>
                                @endforeach
                            </select>
                            <label>Rol Usuario</label>
                        </div>
                    </div>
                    <div class="card-footer center">
                        <button type="submit" class="btn btn-rounded btn-large peach waves-effect waves-light">
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
    <script src="{{ asset('js/dev/user.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection