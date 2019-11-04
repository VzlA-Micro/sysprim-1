@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.manage') }}" class="breadcrumb">Gestionar Usuarios</a>
                <a href="{{ route('companies.read') }}" class="breadcrumb">Ver Usuarios</a>
                <a href="#!" class="breadcrumb">Detalles</a>
                <a href="#!" class="breadcrumb">Editar</a>
            </div>
            <div class="col s12 m8 offset-m2">
                {{-- Agregar los valores de la base de datos con la consulta --}}
                <form action="#" id="userUpdate" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Editar Usuario</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <input id="id" type="hidden" value="{{$user->id}}" name="id">
                        <div class="input-field col s10 m6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede escribir números. Ej: 12345678">
                            <input id="cedula" type="text" name="cedula" class="validate number-only" readonly pattern="[0-9VE]+"
                                   title="Solo puede escribir números." value="{{$user->ci}}" required>
                            <label for="cedula">Cedula</label>
                        </div>
                        <div class="input-field col s12 m6">
                             <i class="icon-person prefix tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos)."></i>
                            <input id="name" type="text" name="name" class="validate" readonly
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ]+"
                                   title="Solo puede agregar letras (con acentos)." value="{{$user->name}}" required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                             <i class="icon-person prefix tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos)."></i>
                            <input id="surname" type="text" name="surname" readonly class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ]+"
                                   title="Solo puede agregar letras (con acentos)." value="{{$user->surname}}" required>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s10 m6" readonly>
                             <i class="icon-phone_android prefix tooltipped" data-position="bottom" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet"></i>
                            <label for="phone">Teléfono</label>
                            <input id="phone" type="tel" name="phone" readonly class="validate" pattern="[0-9+]+"
                                   value="{{$user->phone}}" title="Solo puede escribir números."
                                   placeholder="Ej. 1234567" maxlength="13" minlength="7" required>
                        </div>
                        <!-- <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <input id="rol" type="text" name="rol" readonly class="validate"
                                   title="Solo puede agregar letras (con acentos)." value="{{$role[0]->name}}" required>
                            <label for="rol">Rol De Usuario</label>
                        </div> -->
                        <div class="input-field col m6 s12">
                            <i class="icon-recent_actors prefix"></i>
                            <select  name="roles" id="roles"  required>
                                <option value="null" disabled selected>Selecciona rol</option>
                                @foreach($roles as $rol):
                                <option value="{{$rol->id }}">{{ $rol->name}}</option>
                                @endforeach
                            </select>
                            <label for="roles">Rol Usuario</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                                   data-tooltip="Ej: correo@mail.com">
                            <input id="emailEdit" type="text" name="emailEdit" readonly class="validate"
                                   value="{{ $user->email }}" required>
                            <label for="emailEdit">E-mail</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                             data-tooltip="Ej: correo@mail.com">
                            <input id="passwordEdit" type="password" name="passwordEdit" readonly class="validate"
                                   value="{{ $user->email }}" required>
                            <label for="passwordEdit">Password</label>
                        </div>

                    </div>
                    <div class="card-footer center">
                        <button type="submit" id="actualizar" class="btn btn-rounded green waves-effect waves-light">Actualizar</button>
                        <!--<button type="submit" class="btn btn-rounded green waves-effect waves-light">Registar</button>-->
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