@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.manage') }}">Gestionar Usuarios</a></li>
                    <li class="breadcrumb-item"><a href="">Ver Usuarios</a></li>
                    <li class="breadcrumb-item"><a href="">Detalles</a></li>
                    <!-- <li class="breadcrumb-item"><a href="">Editar</a></li> -->
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">



                {{-- Agregar los valores de la base de datos con la consulta --}}
                <form action="#" id="userUpdate" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles Usuario</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <input type="hidden" value="1" name="confirmed">
                        <input type="hidden" value="{{$user->id}}" name="user_id" id="user_id">
                        <div class="input-field col s6 m3">

                            <i class="icon-public prefix tooltipped" data-position="bottom" data-tooltip="V: Venezolano<br>E: Extrangero"></i>
                            <select name="nationality" id="nationality" required>
                                <option value="null">...</option>
                                <option value="V" @if ($user->TypeDocument=='V'){{"selected"}}@endif>V</option>
                                <option value="E" @if ($user->TypeDocument=='E'){{"selected"}}@endif>E</option>
                            </select>
                            <label for="nationality">Nacionalidad</label>
                        </div>
                        <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                            <input id="ci" type="text" name="ci" class="validate number-only" pattern="[0-9]+" maxlength="8" title="Solo puede escribir números." required value="{{$user->document}}" readonly>
                            <label for="ci">Cedula</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-person prefix tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos)."></i>
                            <input id="name" type="text" name="name" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." value="{{$user->name}}" readonly>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-person prefix tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos)."></i>
                            <input id="surname" type="text" name="surname" class="validate" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." value="{{$user->surname}}" readonly>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <i class="icon-phone_android prefix tooltipped" data-position="bottom" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet"></i>
                            <select name="country_code" id="country_code_company" required disabled>
                                <option value="null" selected disabled>...</option>
                                <option value="+58412" @if ($user->operator=='+58412'){{"selected"}}@endif >(412)</option>
                                <option value="+58414" @if ($user->operator=='+58414'){{"selected"}}@endif>(414)</option>
                                <option value="+58416" @if ($user->operator=='+58416'){{"selected"}}@endif>(416)</option>
                                <option value="+58424" @if ($user->operator=='+58424'){{"selected"}}@endif>(424)</option>
                                <option value="+58426" @if ($user->operator=='+58426'){{"selected"}}@endif>(426)</option>
                                <option value="+58251" @if ($user->operator=='+58251'){{"selected"}}@endif>(251)</option>
                            </select>
                            <label for="country_code_user" >Operadora</label>
                        </div>
                        <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                            <label for="phone_user">Teléfono</label>
                            <input id="phone_user" type="tel" name="phone" class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required value="{{$user->NumberPhone}}" readonly >
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-mail_outline prefix tooltipped" data-position="bottom" data-tooltip="Ej: correo@mail.com"></i>
                            <input id="email" type="email" name="email" class="validate" value="{{ $user->email }}" required readonly0>
                            <label for="email">E-mail</label>
                        </div>

                        <div class="input-field col s12">
                            <i class="icon-recent_actors prefix"></i>
                            <select  name="role" id="role" required>
                                <option value="null" disabled selected>Selecciona rol</option>
                                @foreach($Role as $rol):
                                    @if($rol->id===$user->role_id)
                                        <option value="{{ $rol->id }}" selected>{{ $rol->name }}</option>
                                    @else
                                        <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label>Rol Usuario</label>
                        </div>
                    </div>

                    <div class="card-footer center">
                        <button type="submit" id="actualizar" class="btn btn-rounded green waves-effect waves-light">Actualizar</button>
                        <!--<button type="submit" class="btn btn-rounded green waves-effect waves-light">Registar</button>
                    </div>
                        -->
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/user.js')}}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection