@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/imagePreview.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Mis Publicidades</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.details', ['id' => $publicity->id]) }}">{{ $publicity->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Editar</a></li>
                </ul>            
            </div>
            <div class="col s12 m10 offset-m1">
            	<form method="post" action="{{ route('publicity.save') }}" class="card" enctype="multipart/form-data" id="update">
            		<div class="card-header center-align">
            			<h4>Editar Publicidad</h4>
            		</div>
            		<div class="card-content row">
            			@csrf
                        <input type="hidden" name="id" id="id" value="{{ $publicity->id }}">
            			<div class="input-field col s12">
                            <select name="advertising_type_id" id="advertising_type_id" disabled>
                                <option value="null" disabled selected>Elija un tipo</option>
                                @foreach($advertisingTypes as $type)
                                <option value="{{ $type->id }}" @if($publicity->advertising_type_id == $type->id){{ "selected" }} @endif>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <label>Tipo de Publicidad</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="text" name="name" id="name" value="{{ $publicity->name }}" disabled>
                            <label for="name">Nombre</label>
                        </div>
            			@if (Storage::disk('publicities')->has($publicity->image))
                        <div class="col s12">
                            {{-- <img src="{{ asset('images/bqto-4.jpg') }}" class="responsive-img" alt=""> --}}

                            <div class="preview image img-wrapper center-align valing-wrapper" style="background-image: url({{ route('publicity.image', ['filename' => $publicity->image]) }}); background-size: contain;background-repeat: no-repeat;background-position: 50% 50%;">
                                <i class="icon-add_a_photo medium"></i>
                            </div>
                            <div class="file-upload-wrapper">
                                <input type="file" name="image" id="image" class="file-upload-native" accept="image/*" value="{{ $publicity->image }}">
                                <input type="text" disabled placeholder="Subir imagen" class="file-upload-text" value="{{ $publicity->image }}">
                            </div>
                        </div>
                        @else
                        <div class="col s12">
                            <div class="preview img-wrapper center-align valing-wrapper">
                                <i class="icon-add_a_photo medium"></i>
                            </div>
                            <div class="file-upload-wrapper">
                                <input type="file" name="image" id="image" class="file-upload-native" accept="image/*">
                                <input type="text" disabled placeholder="Subir imagen" class="file-upload-text">
                            </div>
                        </div>
                        @endif
                        <div class="input-field col s12 m6">
                            <input type="text" name="date_start" id="date_start" class="datepicker" value="{{ $publicity->date_start }}" disabled>
                            <label for="date_start">Fecha de Inicio</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="date_end" id="date_end" class="datepicker" value="{{ $publicity->date_end }}" disabled>
                            <label for="date_end">Fecha de Fin</label>
                        </div>
                        <div class="col s12 input-field">
                            <select name="unit" id="unit" disabled>
                                <option value="null" disabled>Elige la unidad</option>
                                <option value="mts" @if($publicity->unit != 'mts') {{ "disabled" }} @endif>Metro</option>
                                <option value="qnt" @if($publicity->unit != 'qnt') {{ "disabled" }} @endif>Cantidad</option>
                            </select>
                            <label>Unidad</label>
                        </div>
                        <div class="col s12">
                            <label for="width">Ancho</label>
                            <input type="text" class="js-range-slider width" name="width" id="width" value="{{ $publicity->width }}">
                        </div>
                        <div class="col s12">
                            <label for="height">Alto</label>
                            <input type="text" class="js-range-slider height" name="height" id="height" value="{{ $publicity->height }}">
                        </div>
                        <div class="input-field col s12">
                            <input type="number" name="quantity" id="quantity" value="{{ $publicity->quantity }}" class="validate number-only" disabled>
                            <label for="quantity">Cantidad de Lugares</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="number" name="side" id="side" value="{{ $publicity->side }}" class="validate number-only" disabled>
                            <label for="side">Cantidad de Caras</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="number" name="floor" id="floor" value="{{ $publicity->floor }}" class="validate number-only" disabled>
                            <label for="floor">Pisos</label>
                        </div>
            		</div>
            		<div class="card-footer center-align">
            			<a href="#!" class="btn btn-large btn-rounded blue waves-effect waves-light" id="btn-modify">
                            <i class="icon-update right"></i>
                            Modificar
                        </a>
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light hide" id="btn-update">
                            <i class="icon-update right"></i>
                            Actualizar
                        </button>
            		</div>
            	</form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/ion.rangeSlider.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('select').formSelect();
            var date = new Date();
            $('#date_start').datepicker({
                maxDate:  date,
                format: 'yyyy-mm-dd', // Configure the date format
                // yearRange: [1900,date.getFullYear()],
                showClearBtn: false,
                i18n: {
                    cancel: 'Cerrar',
                    clear: 'Reiniciar',
                    done: 'Hecho',
                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                    weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
                }
            }); 
            $('#date_end').datepicker({
                maxDate:  null,
                format: 'yyyy-mm-dd', // Configure the date format
                // yearRange: [1900,date.getFullYear()],
                showClearBtn: false,
                i18n: {
                    cancel: 'Cerrar',
                    clear: 'Reiniciar',
                    done: 'Hecho',
                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                    weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
                }
            }); 
            $(".js-range-slider").ionRangeSlider({
                skin: "modern",
                max: 50,
                min: 0,
                grid: true,
                step: 0.1,
                postfix: ' m',
                block: true
            });
        })
    </script>
    <script src="{{ asset('js/imagePreview.js') }}"></script>
    <script src="{{ asset('js/data/publicity.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
    
@endsection