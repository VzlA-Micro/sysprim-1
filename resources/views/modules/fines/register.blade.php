@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fines.manage') }}">Gestionar Multas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fines.register') }}">Registrar Multa</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form id="register" action="" method="#" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Multa</h5>
                    </div>
                    <div class="card-content row">
                       <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>                                                                                   
                            <input type="text" name="name" id="name" required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-swap_vertical_circle prefix"></i>                                                        
                            <input type="number" name="undTributo" id="undTributo" required>
                            <label for="undTributo">Cantidad de unidades tributarias</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-perm_contact_calendar prefix tooltipped" data-position="bottom" data-tooltip=""></i>
                            <select name="branch" id="branch">
                                <option value="null" selected disabled>Selecciona Impuesto</option>
                                <option value="Act.Economica">Act.Economica</option>
                                <option value="Pat.Vehiculo">Pat.Vehiculo</option>
                                <option value="Publicidad">Publicidad</option>
                                <option value="Espectaculos">Espectaculos</option>
                                <option value="Inm.Urbano">Inm.Urbano</option>
                            </select>
                            <label for="branch">Impuesto</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-directions prefix"></i>
                            <textarea name="description" id="description" cols="30" rows="10" class="materialize-textarea" required></textarea>
                            <label for="description">Descripción</label>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded btn-large waves-effect waves-light peach">
                            Registrar
                            <i class="icon-send right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/dev/fines.js') }}"></script>
@endsection