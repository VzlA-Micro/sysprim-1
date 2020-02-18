@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accessories.manage') }}">Gestionar Accesorios</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accessories.register') }}">Registrar</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" id="register">
                    <div class="card-header center-align">
                        <h4>Registrar Accesorio</h4>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <i class="icon-brush prefix"></i>
                            <input type="text" name="name" id="name" min="5" maxlength="50" required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-exposure_plus_1 prefix"></i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only only-number-positive"  maxlength="3" required>
                            <label for="value">Valor UTC</label>
                        </div>
                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/accessories.js') }}"></script>
@endsection