@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu.manage') }}">Gestionar CIIU</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu-group.register') }}">Registrar Grupo CIIU</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offest-m2 l6 offset-l3">
                <form id="groupCiiu" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Grupo de CIIU</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input id="code" type="text" name="code" required minlength="5" maxlength="10">
                            <label for="code">Código</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>
                            <input id="name" type="text" name="name" required minlength="5" maxlength="200">
                            <label for="name">Nombre</label>
                        </div>
                    </div>
                    <div class="card-action center">
                        <button type="submit" class="btn btn-rounded btn-large peach waves-effect waves-light">Registrar
                            <i class="icon-send right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/groupCiiu.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection