@extends('layouts.app')

@section('styles')

@endsection

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
                    <li class="breadcrumb-item"><a href="{{ route('catastral-construction.timeline.register') }}" >Registrar</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" enctype="multipart/form-data" id="register">
                    @csrf
                    <div class="card-header center-align">
                        <h4>Registrar Linea de Tiempo</h4>
                    </div>

                    <div class="card-content row">
                        <div class="input-field col s12">
                            <select name="value_catastral_construccion_id" id="value_catastral_construccion_id" required>
                                <option value="null" disabled selected>Elige un valor catastral de construcción</option>
                                @foreach($catastralConstrucciones as $catastralConstruccion)
                                    <option value="{{ $catastralConstruccion->id }}">{{ $catastralConstruccion->name }}</option>
                                @endforeach
                            </select>
                            <label for="value_catastral_construccion_id">Valor Catastral de Construcción</label>
                        </div>
                        {{--<div class="input-field col s12 m4">
                            <input type="text" name="since" id="since" class="datepicker" required>
                            <label for="since">Desde</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="text" name="to" id="to" class="datepicker" required>
                            <label for="to">Hasta</label>
                        </div>--}}
                        @php
                            $cont=(int)date('Y');
                        @endphp

                        <div class="input-field col s12 m8">
                            <i class="icon-date_range prefix"></i>
                            <select name="since" id="since">
                                <option value="null" disabled selected>Seleccione</option>
                                @while($cont <= 2030)
                                    <option value="{{$cont.'-01-01'}}">{{$cont}}</option>
                                    @php $cont++; @endphp
                                @endwhile
                            </select>
                            <label for="since">Año</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only"  maxlength="6"  required>
                            <label for="value">Valor (UT)</label>
                        </div>
                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/catastral_construccion_timeline.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection