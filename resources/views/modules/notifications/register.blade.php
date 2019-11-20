@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('notifications.manage') }}" class="breadcrumb">Gestionar Notificaciones</a>
                <a href="{{ route('notifications.register') }}" class="breadcrumb">Registrar Notificación</a>
            </div>
            <div class="col s12 m8 offset-m2">
                <form id="register" action="" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Notificación</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>
                            <select name="type_notification">
						        <option value="" disabled selected>Elige una opción</option>
						        <option value="1">Option 1</option>
						        <option value="2">Option 2</option>
						        <option value="3">Option 3</option>
						    </select>
						    <label>Tipo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-send prefix"></i>   
                            <input type="text" name="title" id="title" required>
                            <label for="title">Título</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-date_range prefix"></i>
							<textarea name="content" id="content" cols="30" rows="10" class="materialize-textarea"></textarea>
							<label for="content">Contenido</label>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded btn-large waves-effect waves-light peach">
                            <i class="icon-send right"></i>
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection