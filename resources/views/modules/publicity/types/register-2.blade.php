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
                    @if(session()->has('company'))
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.details', ['id' => session('company')->id]) }}">{{ session('company')->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Mis Publicidades</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.register.types') }}">Registrar Publicidad</a></li>
                    @if(session()->has('company'))
                        <li class="breadcrumb-item"><a href="{{ route('publicity.register.create',['id' => 2, 'company_id' => session('company')->id]) }}">Publicidad por cantidad de ejemplares</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('publicity.register.create',['id' => 2]) }}">Publicidad por cantidad de ejemplares</a></li>
                    @endif
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <form method="post" action="{{ route('publicity.save') }}" class="card" enctype="multipart/form-data" id="register">
                    <ul class="tabs">
                        <li class="tab col s6" id="one"><a href="#user-tab"><i class="icon-filter_1"></i> Datos Generales</a></li>
                        <li class="tab col s6 disabled" id="two"><a href="#property-tab"><i class="icon-filter_2"></i> Datos del Inmueble</a></li>
                    </ul>
                    <div id="user-tab">
                        <div class="card-header center-align">
                            <h5>Datos Generales</h5>
                        </div>
                        <div class="card-content row">
                            <div class="input-field col s12">
                                <i class="icon-person prefix"></i>
                                <select name="status" id="status" required>
                                    @if($company != '')
                                        <option value="null" disabled>Selecciona Condicion</option>
                                        <option value="propietario" selected>Propietario</option>
                                        <option value="responsable" disabled="">Responsable</option>
                                    @else
                                        <option value="null" disabled selected>Selecciona Condicion</option>
                                        <option value="propietario">Propietario</option>
                                        <option value="responsable">Responsable</option>
                                    @endif
                                </select>
                                <label for="model">Condición Legal</label>
                            </div>
                            <div id="content">

                            </div>
                        </div>
                        <div class="card-footer right-align">
                            <a href="#" id='data-next' class="btn peach waves-effect waves-light">
                                Siguiente
                                <i class="icon-navigate_next right"></i>
                            </a>
                        </div>
                    </div>
                    <div id="property-tab">
                        <div class="card-header center-align">
                            <h5>Datos de la publicidad</h5>
                        </div>
                        @if($company != '')
                            <input type="hidden" name="id" value="{{ $company->id }}" id="id">
                            <input type="hidden" name="type" value="company" id="type">
                        @else
                            <input type="hidden" name="id" value="" id="id">
                            <input type="hidden" name="type" value="" id="type">
                        @endif
                        <div class="card-content row">
                            <div class="input-field col s12">
                                <i class="icon-linked_camera prefix"></i>
                                <select name="advertising_type_id" id="advertising_type_id" required>
                                    <option value="null" disabled selected>Elija un tipo</option>
                                    @foreach($advertisingTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-smoking_rooms prefix"></i>
                                <select name="licor" id="licor">
                                    <option value="" disabled selected>Elija una opción</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <label>¿Su publicidad hace refencia a cigarrillos o bebidas alcoholicas?</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-my_location prefix"></i>
                                <select name="state_location" id="state_location">
                                    <option value="" disabled selected>Elija una opción</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <label>¿Su publicidad está ubicada en un espacio reservado de la alcaldía?</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-format_size prefix"></i>
                                <input type="text" name="name" id="name" min="5" max="256" required>
                                <label for="name">Nombre</label>
                            </div>
                            <div class="col s12">
                                {{-- <img src="{{ asset('images/bqto-4.jpg') }}" class="responsive-img" alt=""> --}}
                                <div class="preview img-wrapper center-align valing-wrapper">
                                    <i class="icon-add_a_photo medium"></i>
                                </div>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="image" id="image" class="file-upload-native" accept="image/*" />
                                    <input type="text" disabled placeholder="Subir imagen" class="file-upload-text" />
                                </div>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_start" id="date_start" class="datepicker date_start" required>
                                <label for="date_start">Fecha de Inicio</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_end" id="date_end" class="datepicker" required>
                                <label for="date_end">Fecha de Fin</label>
                            </div>
                            <div class="col s12 input-field">
                                <i class="icon-straighten prefix"></i>
                                <select name="unit" id="unit">
                                    <option value="null" disabled>Elige la unidad</option>
                                    <option value="mts" disabled>Metro</option>
                                    <option value="qnt" selected>Cantidad</option>
                                </select>
                                <label>Unidad</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-chrome_reader_mode prefix"></i>
                                <input type="number" name="quantity" id="quantity" min="1" required>
                                <label for="quantity">Ejemplares</label>
                            </div>
                            {{--<div class="input-field col s12">
                                <input type="text" name="point" id="point">
                                <label for="point">Cantidad de Lugares</label>
                            </div>--}}
                        </div>
                        <div class="card-action center-align">
                            <button type="submit" class="btn btn-rounded btn-large waves-effect waves-light peach">
                                Registrar
                                <i class="icon-send right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/ion.rangeSlider.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
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
                minDate: date,
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
                postfix: ' m'
            });
        })
    </script>
    <script src="{{ asset('js/imagePreview.js') }}"></script>
    <script src="{{ asset('js/data/publicity.js') }}"></script>
@endsection