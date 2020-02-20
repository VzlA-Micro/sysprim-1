@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.property') }}">Configuración de Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.terreno.manage') }}">Gestionar Valor  Catastral de Terreno</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal-terreno.timeline.manage') }}" >Linea de Tiempo</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catastral-terreno.timeline.read') }}" >Consultar</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catastral-terreno.timeline.details',['id' => $timeline->id]) }}">Detalles</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" enctype="multipart/form-data" id="update">
                    @csrf
                    <div class="card-header center-align">
                        <h4>Detalles de Valor Catastral del Terreno</h4>
                    </div>
                    <div class="card-content row">
                        <input type="hidden" name="id" id="id" value="{{ $timeline->id }}">
                        <input type="hidden" name="value_catastral_terreno_id" value="{{ $timeline->catastralTerrain->id }}">

                        <div class="input-field col s12">
                            <select name="value_catastral_terreno_id" id="value_catastral_terreno_id" disabled>
                                <option value="null" disabled selected>Elige un valor catastral de terreno</option>
                                @foreach($catastralTerrenos as $catastralTerreno)
                                    <option value="{{ $catastralTerreno->id }}" @if($timeline->catastralTerrain->id == $catastralTerreno->id) {{ "selected" }} @endif>{{ $catastralTerreno->name }}</option>
                                @endforeach
                            </select>
                            <label for="value_catastral_terreno_id">Valor Catastral de Construcción</label>
                        </div>
                        {{--<div class="input-field col s12 m6">
                            <input type="text" name="since" id="since" class="datepicker" value="{{ $timeline->since }}" disabled required>
                            <label for="since">Desde</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="to" id="to" class="datepicker" value="{{ $timeline->to }}" disabled required>
                            <label for="to">Hasta</label>
                        </div>--}}
                        @php
                            $cont=(int)date('Y');
                        @endphp

                        <div class="input-field col s12">
                            <i class="icon-date_range prefix"></i>
                            <select name="since" id="since" disabled>
                                <option value="null" selected disabled>Seleccione</option>
                                @while($cont <= 2030)
                                    @if($timeline->since==$cont.'-01-01')
                                        <option value="{{$cont.'-01-01'}}" selected>{{$cont}}</option>
                                    @else
                                        <option value="{{$cont.'-01-01'}}">{{$cont}}</option>
                                    @endif
                                    @php $cont++; @endphp
                                @endwhile
                            </select>
                            <label for="since">Año</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input type="text" name="value_built_terrain" id="value_built_terrain" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only" value="{{ $timeline->value_built_terrain }}" maxlength="6" disabled required>
                            <label for="value_built_terrain">Valor de Terreno Construido (UT)</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input type="text" name="value_empty_terrain" id="value_empty_terrain" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only" value="{{ $timeline->value_empty_terrain }}"  maxlength="6" disabled required>
                            <label for="value_empty_terrain">Valor de Terreno Vacío (UT)</label>
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
    <script src="{{ asset('js/data/catastral_terreno_timeline.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection