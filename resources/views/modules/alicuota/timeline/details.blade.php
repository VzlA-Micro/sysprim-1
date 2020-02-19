@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.manage') }}" >Gestionar Alicuota Inmuebles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.timeline.manage') }}" >Linea de Tiempo</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.timeline.read') }}" >Consultar Linea de Tiempo</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.timeline.details',['id' => $timeline->id]) }}">Detalles</a></li>

                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" enctype="multipart/form-data" id="update">
                    @csrf
                    <div class="card-header center-align">
                        <h4>Detalles de Alicuota</h4>
                    </div>
                    <div class="card-content row">
                        <input type="hidden" name="id" id="id" value="{{ $timeline->id }}">
                        <div class="input-field col s12">
                            <select name="alicuota_inmueble_id" id="alicuota_inmueble_id" disabled>
                                <option value="null" disabled selected>Elige una Alicuota</option>
                                @foreach($alicuotas as $alicuota)
                                    <option value="{{ $alicuota->id }}" @if($timeline->alicuota->id == $alicuota->id) {{ "selected" }} @endif>{{ $alicuota->name }}</option>
                                @endforeach
                            </select>
                            <label for="alicuota_inmueble_id">Alicuotas</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="text" name="since" id="since" class="datepicker" value="{{ $timeline->since }}" readonly required>
                            <label for="since">Desde</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="text" name="to" id="to" class="datepicker" value="{{ $timeline->to }}" required>
                            <label for="to">Hasta</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only only-number-positive" value="{{ $timeline->value }}" maxlength="3" readonly required>
                            <label for="value">Valor</label>
                        </div>
                    </div>
                    {{--@can('Actualizar Alicuota')--}}
                        <div class="card-footer center-align">
                            <a href="#!" class="btn btn-large blue btn-rounded waves-effect waves-light" id="btn-modify">
                                <i class="icon-update right"></i>
                                Modificar
                            </a>
                            <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light hide" id="btn-update">
                                <i class="icon-send right"></i>
                                Actualizar
                            </button>
                        </div>
                    {{--@endcan--}}
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/data/alicuota_timeline.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection