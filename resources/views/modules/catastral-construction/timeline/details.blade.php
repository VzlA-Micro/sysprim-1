@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.property') }}">Configuración de Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.construction.manage') }}">Gestionar Valor  Catastral de Contrucción</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal-construction.timeline.manage') }}" >Linea de Tiempo</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catastral-construction.timeline.read') }}" >Consultar</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catastral-construction.timeline.details',['id' => $timeline->id]) }}">Detalles</a></li>
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
                            <select name="value_catastral_construccion_id" id="value_catastral_construccion_id" disabled>
                                <option value="null" disabled selected>Elige un valor catastral de construcción</option>
                                @foreach($catastralConstrucciones as $catastralConstruccion)
                                    <option value="{{ $catastralConstruccion->id }}" @if($timeline->catastralBuild->id == $catastralConstruccion->id) {{ "selected" }} @endif>{{ $catastralConstruccion->name }}</option>
                                @endforeach
                            </select>
                            <label for="value_catastral_construccion_id">Valor Catastral de Construcción</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="text" name="since" id="since" class="datepicker" value="{{ $timeline->since }}" disabled required>
                            <label for="since">Desde</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="text" name="to" id="to" class="datepicker" value="{{ $timeline->to }}" disabled required>
                            <label for="to">Hasta</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only only-number-positive" value="{{ $timeline->value }}" maxlength="6" disabled required>
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
    <script src="{{ asset('js/data/catastral_construccion_timeline.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection