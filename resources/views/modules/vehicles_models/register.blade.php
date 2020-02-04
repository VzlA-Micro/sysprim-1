@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.models.vehicles') }}" class="breadcrumb">Gestionar Modelos De Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.models.register') }}" class="breadcrumb">Registrar Modelos De Vehículos</a></li>
                </ul>
            </div>

            <form method="post" action="{{url('/vehicles-models/save')}}" class="col s12 m8 offset-m2"
                  enctype="multipart/form-data" id="type">
                {{csrf_field()}}
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Modelos De Vehículos</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: Carga">
                            <input type="text" name="models" id="models" pattern="[a-zA-Z0-9]+"
                                   title="Solo puede escribir números y letra en mayúsculas." class="validate" required>
                            <label for="models">Modelo Vehiculo</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <input type="text" name="year" id="year" class="validate" pattern="[A-Za-z0-9,.]+"
                                   title="Solo puede escribir letras y numeros." required>
                            <label for="year">Año</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="brand" id="brand" required>
                                <option value="null" disabled selected>Selecciona la marca</option>
                                @foreach($brand as $brands)
                                    <option value="{{$brands->id}}">{{$brands->name}}</option>
                                @endforeach

                            </select>
                            <label for="brand">Marca</label>
                        </div>
                        <div class="input-field col s12 center-align">
                            <button type="submit" class="btn btn-rounded btn-large peach waves-effect">Registrar
                                    <i class="icon-send right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection