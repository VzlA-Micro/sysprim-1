@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="#!">Gestionar Grupo de Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="#!">Registrar</a></li>
                </ul>
            </div>

            <form method="#" action="#" class="col s12 m8 offset-m2"
                  enctype="multipart/form-data" id="register">
                {{csrf_field()}}
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Grupo de Publicidad</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 tooltipped" data-position="bottom" data-tooltip="Ej: Tiempo">
                            <i class="icon-format_size prefix"></i>
                            <input type="text" name="groupName" id="groupName" pattern="[a-zA-Z0-9 ]+"
                                   title="Solo puede escribir números y letra en mayúsculas." class="validate" maxlength="40" minlength="10" required>
                            <label for="groupName">Nombre del Grupo</label>
                        </div>
                        <div class="input-field col s12 center-align">
                            <button type="submit" id="groupRegister" class="btn btn-rounded btn-large peach waves-effect">
                                <i class="icon-send right"></i>Registrar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/groupPublicity.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection