@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('group-publicity.manage') }}">Gestionar Grupo de Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('group-publicity.read') }}" >Ver
                            Grupos</a></li>

                    <li class="breadcrumb-item"><a href="#">Detalles
                            </a></li>
                </ul>
            </div>
            <div class="col s12 m10 l8 offset-m1 offset-l2">
                <form id="updateGroup" method="" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles De Grupo de Publicidad</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <input id="id" type="hidden" name="id" value="{{ $GroupPublicity->id }}">

                        <div class="input-field col s12">
                            <i class="icon-folder_special prefix"></i>
                            <input id="name" type="text" name="name" readonly value="{{ $GroupPublicity->name }}" maxlength="40" minlength="10" required>
                            <label for="name">Grupo</label>
                        </div>
                    </div>
                    @can('Actualizar Grupo de Publicidad')
                    <div class="card-action center">
                            <a id="btn-modify" class="btn btn-large btn-rounded blue waves-effect waves-light">
                                <i class="icon-update right"></i>
                                Modificar
                            </a>

                            <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light hide" id="btn-update">
                                <i class="icon-save right"></i>
                                Guardar
                            </button>
                        {{--<a href="#" class="btn btn-rounded red waves-effect waves-light">Eliminar  <i class="icon-delete right"></i></a>--}}
                    </div>
                    @endcan

                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('js/dev/groupPublicity.js') }}"></script>
<script src="{{ asset('js/validations.js') }}"></script>
@endsection