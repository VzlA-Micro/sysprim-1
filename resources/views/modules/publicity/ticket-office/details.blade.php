@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas
                        </a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.publicity.home') }}">Taquilla
                            Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticketOffice.publicity.managePublicity')}}">Gestionar
                            Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticketOffice.publicity.read')}}">Ver
                            Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="#">Detalles De
                            Publicidad</a></li>
                </ul>
            </div>
            <div class="col s12 m8 l8">
                <form action="#" id="update-register" class="card" enctype="multipart/form-data">
                    <div class="card-header center-align">
                        <h5>{{$publicity->code}}</h5>
                    </div>
                    <div class="card-content row">
                        @csrf

                        <input type="hidden" name="id" id="id" value="{{ $publicity->id }}">

                        <h5 class="center">Datos del propietario</h5>

                        @if(isset($publicity->company[0]))
                            <div class="input-field col s6 tooltipped" data-position="bottom"
                                 data-tooltip="V: Venezolano; E: Extranjero">
                                <i class="icon-public prefix"></i>
                                <select name="nationality" id="nationality" required disabled>
                                    <option value="null">...</option>
                                    <option value="V" selected>{{$publicity->company[0]->typeDocument}}</option>
                                    <option value="E">E</option>
                                    <option value="E">G</option>
                                    <option value="E">V</option>
                                </select>
                                <label for="nationality">Nacionalidad</label>
                            </div>

                            <div class="input-field col s6 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="ci" type="text" name="ci" class="validate number-data" maxlength="10"
                                       pattern="[0-9]+"
                                       title="Solo puede escribir números." required
                                       value="{{$publicity->company[0]->document }}"
                                       readonly disabled>
                                <label for="ci">Cedula</label>
                            </div>

                            <div class="input-field col s12 m12 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="name_user" type="text" name="name" class="validate"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)."
                                       value="{{$publicity->company[0]->name }}" required disabled>
                                <label for="name">Nombre</label>
                            </div>
                        @elseif(isset($person))
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="name_user" type="text" name="name" class="validate"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)."
                                       value="{{$person->name }}" required readonly>
                                <label for="name">Nombre</label>
                            </div>

                            <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="surname" type="text" name="surname" class="validate"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)."
                                       value="{{$person->surname}}" required readonly>
                                <label for="surname">Apellido</label>
                            </div>

                            <div class="input-field col s6 tooltipped" data-position="bottom"
                                 data-tooltip="V: Venezolano; E: Extranjero">
                                <i class="icon-public prefix"></i>
                                <select name="nationality" id="nationality" required disabled>
                                    <option value="null">...</option>
                                    <option value="V" @if ($person->typeDocument=='V'){{"selected"}}@endif>V
                                    </option>
                                    <option value="E" @if ($person->typeDocument=='E'){{"selected"}}@endif>E
                                    </option>
                                </select>
                                <label for="nationality">Nacionalidad</label>
                            </div>

                            <div class="input-field col s6 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="ci" type="text" name="ci" class="validate" pattern="[0-9]+"
                                       title="Solo puede escribir números." required
                                       value="{{$person->document }}"
                                       readonly>
                                <label for="ci">Cedula</label>
                            </div>

                        @endif
                        {{--@else

                        <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="name_user" type="text" name="name" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$vehicle->users[0]->name }}" required readonly>
                            <label for="name">Nombre</label>
                        </div>

                        <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="surname" type="text" name="surname" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$vehicle->users[0]->surname}}" required readonly>
                            <label for="surname">Apellido</label>
                        </div>

                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="V: Venezolano; E: Extranjero">
                            <i class="icon-public prefix"></i>
                            <select name="nationality" id="nationality" required disabled>
                                <option value="null">...</option>
                                <option value="V" @if ($vehicle->users[0]->typeDocument=='V'){{"selected"}}@endif>V
                                </option>
                                <option value="E" @if ($vehicle->users[0]->typeDocument=='E'){{"selected"}}@endif>E
                                </option>
                            </select>
                            <label for="nationality">Nacionalidad</label>
                        </div>

                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede escribir números. Ej: 12345678">
                            <input id="ci" type="text" name="ci" class="validate" pattern="[0-9]+"
                                   title="Solo puede escribir números." required
                                   value="{{$vehicle->users[0]->document }}"
                                   readonly>
                            <label for="ci">Cedula</label>
                        </div>

                        @endif--}}

                        <div id="change">

                        </div>

                        <h5 class="center">Datos de la Publicidad</h5>
                        <div>
                            <input type="hidden" name="id" id="id" value="{{$publicity->id}}">

                            @if($publicity->advertisingType->group->id==1)
                                <div class="card-content row">
                                    <div class="input-field col s12">
                                        <i class="icon-linked_camera prefix"></i>
                                        <input type="hidden" name="advertising_type_id" id="advertising_type_id2"
                                               value="{{$publicity->advertisingType->group->id}}">
                                        <input type="text" name="advertising_type_id" id="advertising_type_id"
                                               value="{{$publicity->advertisingType->name}}" disabled required>
                                        <label for="advertising_type_id">Tipo de Publicidad</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <i class="icon-format_size prefix"></i>
                                        <input type="text" name="name" id="name" minlength="5" maxlength="190" value="{{$publicity->name}}" disabled
                                               required>
                                        <label for="name">Nombre</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-smoking_rooms prefix"></i>
                                        <select name="licor" id="licor" disabled>
                                            <option value="null" selected disabled>...</option>
                                            <option value="SI" @if ($publicity->licor=='SI'){{"selected"}}@endif>SI</option>
                                            <option value="NO" @if ($publicity->licor=='NO'){{"selected"}}@endif>NO</option>
                                        </select>
                                        <label>¿Su publicidad hace refencia a cigarrillos o bebidas alcoholicas?</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-my_location prefix"></i>
                                        <select name="state_location" id="state_location" disabled="">
                                            <option value="null" selected disabled>...</option>
                                            <option value="SI" @if ($publicity->state_location=='SI'){{"selected"}}@endif>SI</option>
                                            <option value="NO" @if ($publicity->state_location=='NO'){{"selected"}}@endif>NO</option>
                                        </select>
                                        <label>¿Su publicidad está ubicada en un espacio reservado de la alcaldía?</label>
                                    </div>

                                    <div class="input-field col s12 m6" id="date-begin">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_start" value="{{$publicity->date_start}}"
                                               id="date_start1"
                                               disabled required>
                                        <label for="date_start">Fecha de Inicio</label>
                                    </div>
                                    <div class="input-field col s12 m6" id="date-end">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_end" id="date_end1"
                                               value="{{$publicity->date_end}}" disabled required>
                                        <label for="date_end">Fecha de Fin</label>
                                    </div>
                                    <div class="input-field col s12 m6 hide" id="U-date-begin">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_start" id="date_start" value="{{$publicity->date_start}}" class="datepicker date_start"
                                               required>
                                        <label for="date_start">Fecha de Inicio</label>
                                    </div>
                                    <div class="input-field col s12 m6 hide" id="U-date-end">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_end" value="{{$publicity->date_end}}" id="date_end" class="datepicker date_end" required>
                                        <label for="date_end">Fecha de Fin</label>
                                    </div>
                                    {{-- <div class="input-field col s12">
                                         <input type="text" name="quantity" id="quantity">
                                         <label for="quantity">Cantidad</label>
                                     </div>--}}

                                </div>
                            @elseif($publicity->advertisingType->group->id==2)
                                <div class="card-content row">
                                    <div class="input-field col s12">
                                        <i class="icon-linked_camera prefix"></i>
                                        <input type="hidden" name="advertising_type_id" id="advertising_type_id2"
                                               value="{{$publicity->advertisingType->group->id}}" required>
                                        <input type="text" name="advertising_type_id" id="advertising_type_id"
                                               value="{{$publicity->advertisingType->name}}" disabled required>
                                        <label>Tipo de Publicidad</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <i class="icon-format_size prefix"></i>
                                        <input type="text" name="name" id="name" minlength="5" maxlength="190" value="{{$publicity->name}}" disabled
                                               required>
                                        <label for="name">Nombre</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-smoking_rooms prefix"></i>
                                        <select name="licor" id="licor" disabled>
                                            <option value="null" selected disabled>...</option>
                                            <option value="SI" @if ($publicity->licor=='SI'){{"selected"}}@endif>SI</option>
                                            <option value="NO" @if ($publicity->licor=='NO'){{"selected"}}@endif>NO</option>
                                        </select>
                                        <label>¿Su publicidad hace refencia a cigarrillos o bebidas alcoholicas?</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-my_location prefix"></i>
                                        <select name="state_location" id="state_location" disabled="">
                                            <option value="null" selected disabled>...</option>
                                            <option value="SI" @if ($publicity->state_location=='SI'){{"selected"}}@endif>SI</option>
                                            <option value="NO" @if ($publicity->state_location=='NO'){{"selected"}}@endif>NO</option>
                                        </select>
                                        <label>¿Su publicidad está ubicada en un espacio reservado de la alcaldía?</label>
                                    </div>


                                    <div class="input-field col s12 m6" id="date-begin">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_start" value="{{$publicity->date_start}}"
                                               id="date_start1"
                                               disabled required>
                                        <label for="date_start">Fecha de Inicio</label>
                                    </div>

                                    <div class="input-field col s12 m6" id="date-end">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_end" id="date_end1"
                                               value="{{$publicity->date_end}}" disabled required>
                                        <label for="date_end">Fecha de Fin</label>
                                    </div>

                                    <div class="input-field col s12 m6 hide" id="U-date-begin">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_start" value="{{$publicity->date_start}}" id="date_start" class="datepicker date_start"
                                               required>
                                        <label for="date_start">Fecha de Inicio</label>
                                    </div>

                                    <div class="input-field col s12 m6 hide" id="U-date-end">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_end" value="{{$publicity->date_end}}" id="date_end" class="datepicker date_end" required>
                                        <label for="date_end">Fecha de Fin</label>
                                    </div>

                                    <div class="input-field col s12 m12" id="U-date-end">
                                        <i class="icon-straighten prefix"></i>
                                        <input type="text" name="unit" id="unit" value="{{$publicity->unit}}" disabled>
                                        <label for="u-med">Unidad de medida</label>
                                    </div>

                                    <div class="input-field col s12 m6" >
                                        <i class="icon-panorama_horizontal prefix"></i>
                                        <label for="width">Ancho</label>
                                        <input type="text" class="js-range-slider width" name="width" maxlength="5" id="width"
                                               value="{{$publicity->width}}" disabled required>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-panorama_vertical prefix"></i>
                                        <label for="height">Alto</label>
                                        <input type="text" class="js-range-slider height" name="height" maxlength="5" id="height"
                                               value="{{$publicity->height}}" disabled required>
                                    </div>

                                    {{--<div class="input-field col s12">
                                        <input type="text" name="point" id="point">
                                        <label for="point">Cantidad de Lugares</label>
                                    </div>--}}
                                </div>
                            @elseif($publicity->advertisingType->group->id==3)
                                <div class="card-content row">
                                    <div class="input-field col s12">
                                        <i class="icon-linked_camera prefix"></i>
                                        <input type="hidden" name="advertising_type_id" id="advertising_type_id2"
                                               value="{{$publicity->advertisingType->group->id}}" required>
                                        <input type="text" name="advertising_type_id" id="advertising_type_id"
                                               value="{{$publicity->advertisingType->name}}" disabled required>
                                        <label>Tipo de Publicidad</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <i class="icon-format_size prefix"></i>
                                        <input type="text" name="name" id="name" minlength="5" maxlength="190" value="{{$publicity->name}}" disabled
                                               required>
                                        <label for="name">Nombre</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-smoking_rooms prefix"></i>
                                        <select name="licor" id="licor" disabled>
                                            <option value="null" selected disabled>...</option>
                                            <option value="SI" @if ($publicity->licor=='SI'){{"selected"}}@endif>SI</option>
                                            <option value="NO" @if ($publicity->licor=='NO'){{"selected"}}@endif>NO</option>
                                        </select>
                                        <label>¿Su publicidad hace refencia a cigarrillos o bebidas alcoholicas?</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-my_location prefix"></i>
                                        <select name="state_location" id="state_location" disabled="">
                                            <option value="null" selected disabled>...</option>
                                            <option value="SI" @if ($publicity->state_location=='SI'){{"selected"}}@endif>SI</option>
                                            <option value="NO" @if ($publicity->state_location=='NO'){{"selected"}}@endif>NO</option>
                                        </select>
                                        <label>¿Su publicidad está ubicada en un espacio reservado de la alcaldía?</label>
                                    </div>

                                    <div class="input-field col s12 m6" id="date-begin">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_start" value="{{$publicity->date_start}}"
                                               id="date_start1"
                                               disabled required>
                                        <label for="date_start">Fecha de Inicio</label>
                                    </div>

                                    <div class="input-field col s12 m6" id="date-end">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_end" id="date_end1"
                                               value="{{$publicity->date_end}}" disabled required>
                                        <label for="date_end">Fecha de Fin</label>
                                    </div>

                                    <div class="input-field col s12 m6 hide" id="U-date-begin">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_start" value="{{$publicity->date_start}}" id="date_start" class="datepicker date_start"
                                               required>
                                        <label for="date_start">Fecha de Inicio</label>
                                    </div>

                                    <div class="input-field col s12 m6 hide" id="U-date-end">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_end" value="{{$publicity->date_end}}" id="date_end" class="datepicker date_end" required>
                                        <label for="date_end">Fecha de Fin</label>
                                    </div>

                                    <div class="input-field col s12 m12" id="U-date-end">
                                        <i class="icon-straighten prefix"></i>
                                        <input type="text" name="unit" id="unit" value="{{$publicity->unit}}" disabled>
                                        <label for="u-med">Unidad de medida</label>
                                    </div>

                                    <div class="input-field col s12">
                                        <i class="icon-chrome_reader_mode prefix"></i>
                                        <input type="number" name="quantity" id="quantity" maxlength="5" value="{{$publicity->quantity}}" min="1" disabled required>
                                        <label for="quantity">Ejemplares</label>
                                    </div>
                                    {{--<div class="input-field col s12">
                                        <input type="text" name="point" id="point">
                                        <label for="point">Cantidad de Lugares</label>
                                    </div>--}}
                                </div>
                            @elseif($publicity->advertisingType->group->id==4)
                                <div class="card-content row">
                                    <div class="input-field col s12">
                                        <i class="icon-linked_camera prefix"></i>
                                        <input type="hidden" name="advertising_type_id" id="advertising_type_id2"
                                               value="{{$publicity->advertisingType->group->id}}" required>
                                        <input type="text" name="advertising_type_id" id="advertising_type_id"
                                               value="{{$publicity->advertisingType->name}}" disabled required>
                                        <label>Tipo de Publicidad</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <i class="icon-format_size prefix"></i>
                                        <input type="text" name="name" id="name" minlength="5" maxlength="190" value="{{$publicity->name}}" disabled
                                               required>
                                        <label for="name">Nombre</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-smoking_rooms prefix"></i>
                                        <select name="licor" id="licor" disabled>
                                            <option value="null" selected disabled>...</option>
                                            <option value="SI" @if ($publicity->licor=='SI'){{"selected"}}@endif>SI</option>
                                            <option value="NO" @if ($publicity->licor=='NO'){{"selected"}}@endif>NO</option>
                                        </select>
                                        <label>¿Su publicidad hace refencia a cigarrillos o bebidas alcoholicas?</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-my_location prefix"></i>
                                        <select name="state_location" id="state_location" disabled="">
                                            <option value="null" selected disabled>...</option>
                                            <option value="SI" @if ($publicity->state_location=='SI'){{"selected"}}@endif>SI</option>
                                            <option value="NO" @if ($publicity->state_location=='NO'){{"selected"}}@endif>NO</option>
                                        </select>
                                        <label>¿Su publicidad está ubicada en un espacio reservado de la alcaldía?</label>
                                    </div>

                                    <div class="input-field col s12 m6" id="date-begin">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_start" value="{{$publicity->date_start}}"
                                               id="date_start1"
                                               disabled required>
                                        <label for="date_start">Fecha de Inicio</label>
                                    </div>

                                    <div class="input-field col s12 m6" id="date-end">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_end" id="date_end1"
                                               value="{{$publicity->date_end}}" disabled required>
                                        <label for="date_end">Fecha de Fin</label>
                                    </div>

                                    <div class="input-field col s12 m6 hide" id="U-date-begin">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" value="{{$publicity->date_start}}" name="date_start" id="date_start" class="datepicker date_start"
                                               required>
                                        <label for="date_start">Fecha de Inicio</label>
                                    </div>

                                    <div class="input-field col s12 m6 hide" id="U-date-end">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_end" id="date_end" value="{{$publicity->date_end}}" class="datepicker date_end" required>
                                        <label for="date_end">Fecha de Fin</label>
                                    </div>

                                    <div class="input-field col s12 m12" id="U-date-end">
                                        <i class="icon-straighten prefix"></i>
                                        <input type="text" name="unit" id="unit" value="{{$publicity->unit}}" disabled>
                                        <label for="u-med">Unidad de medida</label>
                                    </div>

                                    <div class="input-field col s12 m6" >
                                        <i class="icon-panorama_horizontal prefix"></i>
                                        <label for="width">Ancho</label>
                                        <input type="text" class="js-range-slider width" maxlength="5" name="width" id="width"
                                               value="{{$publicity->width}}" disabled required>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-panorama_vertical prefix"></i>
                                        <label for="height">Alto</label>
                                        <input type="text" class="js-range-slider height" maxlength="5" name="height" id="height"
                                               value="{{$publicity->height}}" disabled required>
                                    </div>

                                    <div class="input-field col s12">
                                        <i class="icon-exposure_plus_1 prefix"></i>
                                        <input type="text" name="quantity" id="quantity" class="validate number-only" maxlength="5" value="{{$publicity->quantity}}" min="1" disabled required>
                                        <label for="quantity">Cantidad de Lugares</label>
                                    </div>
                                </div>
                            @elseif($publicity->advertisingType->group->id==5)
                                <div class="card-content row">
                                    <div class="input-field col s12">
                                        <i class="icon-linked_camera prefix"></i>
                                        <input type="hidden" name="advertising_type_id" id="advertising_type_id2"
                                               value="{{$publicity->advertisingType->group->id}}" required>
                                        <input type="text" name="advertising_type_id" id="advertising_type_id"
                                               value="{{$publicity->advertisingType->name}}" disabled required>
                                        <label>Tipo de Publicidad</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <i class="icon-format_size prefix"></i>
                                        <input type="text" name="name" id="name" minlength="5" maxlength="190" value="{{$publicity->name}}" disabled
                                               required>
                                        <label for="name">Nombre</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-smoking_rooms prefix"></i>
                                        <select name="licor" id="licor" disabled>
                                                <option value="null" selected disabled>...</option>
                                                <option value="SI" @if ($publicity->licor=='SI'){{"selected"}}@endif>SI</option>
                                                <option value="NO" @if ($publicity->licor=='NO'){{"selected"}}@endif>NO</option>
                                            </select>
                                        <label>¿Su publicidad hace refencia a cigarrillos o bebidas alcoholicas?</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-my_location prefix"></i>
                                        <select name="state_location" id="state_location" disabled="">
                                            <option value="null" selected disabled>...</option>
                                            <option value="SI" @if ($publicity->state_location=='SI'){{"selected"}}@endif>SI</option>
                                            <option value="NO" @if ($publicity->state_location=='NO'){{"selected"}}@endif>NO</option>
                                        </select>
                                        <label>¿Su publicidad está ubicada en un espacio reservado de la alcaldía?</label>
                                    </div>

                                    <div class="input-field col s12 m6" id="date-begin">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_start" value="{{$publicity->date_start}}"
                                               id="date_start1"
                                               disabled required>
                                        <label for="date_start">Fecha de Inicio</label>
                                    </div>

                                    <div class="input-field col s12 m6" id="date-end">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_end" id="date_end1"
                                               value="{{$publicity->date_end}}" disabled required>
                                        <label for="date_end">Fecha de Fin</label>
                                    </div>

                                    <div class="input-field col s12 m6 hide" id="U-date-begin">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_start" value="{{$publicity->date_start}}" id="date_start" class="datepicker date_start"
                                               required>
                                        <label for="date_start">Fecha de Inicio</label>
                                    </div>

                                    <div class="input-field col s12 m6 hide" id="U-date-end">
                                        <i class="icon-date_range prefix"></i>
                                        <input type="text" name="date_end" id="date_end" value="{{$publicity->date_end}}" class="datepicker date_end" required>
                                        <label for="date_end">Fecha de Fin</label>
                                    </div>



                                    <div class="input-field col s12 m12" id="U-date-end">
                                        <i class="icon-straighten prefix"></i>
                                        <input type="text" name="unit" id="unit" value="{{$publicity->unit}}" disabled>
                                        <label for="u-med">Unidad de medida</label>
                                    </div>

                                    <div class="input-field col s12 m6" >
                                        <i class="icon-panorama_horizontal prefix"></i>
                                        <input type="text"  name="width" maxlength="5" id="width"
                                               value="{{$publicity->width}}" disabled required>
                                        <label for="width">Ancho</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="icon-panorama_vertical prefix"></i>                                        
                                        <input type="text"  name="height" maxlength="5" id="height"
                                               value="{{$publicity->height}}" disabled required>
                                        <label for="height">Alto / Piso</label>
                                    </div>

                                    {{--<div class="input-field col s12">--}}
                                    {{--<input type="number" name="quantity" id="quantity">--}}
                                    {{--<label for="quantity">Cantidad de Lugares</label>--}}
                                    {{--</div>--}}
                                    <div class="input-field col s12">
                                        <i class="icon-exposure_plus_1 prefix"></i>
                                        <input type="text" name="side" value="{{$publicity->side}}" maxlength="5" disabled id="side">
                                        <label for="side">Cantidad de Caras</label>
                                    </div>
                                    {{-- <div class="input-field col s12">
                                        <input type="number" name="floor" id="floor">
                                        <label for="floor">Pisos</label>
                                    </div> --}}
                                    <div id="content"></div>
                                </div>
                            @endif
                            {{--<div class="input-field col s6">
                                <i class="icon-person prefix"></i>
                                <select name="status" id="status" required disabled>
                                    <option value="propietario"@if ($vehicle->users[0]->status_user_vehicle=='propietario'){{"selected"}}@endif>Propietario
                                    </option>
                                    <option value="responsable"@if ($vehicle->users[0]->status_user_vehicle=='responsable'){{"selected"}}@endif>Responsable
                                    </option>
                                </select>
                                <label for="status">Condición Legal</label>
                            </div>--}}

                            {{--<div class="input-field col s6">
                                <i class="icon-local_shipping prefix"></i>
                                <select name="model" id="model" disabled required>
                                    <option value="null" disabled selected>Selecciona el módelo</option>
                                    @foreach($model as $models)
                                        <option value="{{$models->id}}"@if ($models->id==$vehicle->model->id){{"selected"}}@endif>{{$models->name}}</option>
                                    @endforeach
                                </select>
                                <label for="model">Módelo</label>
                            </div>--}}

                        </div>
                        <div class="col s12 m4 center-align">
                            <h4>Estado:</h4>
                        </div>
                        @if($publicity->status===null||$publicity->status==='enabled')
                            <div class="input-field col s12 m8" id="estado" style="margin-top:.5rem">
                                <a href="#"
                                   class="btn btn-large waves-effect waves-light green col s12 btn-rounded "
                                >Habilitada
                                    <i class="icon-check right"></i>
                                </a>
                            </div>

                        @else
                            <div class="input-field col s12 m8" id="estado" style="margin-top:.5rem">
                                <a href="#" class="btn btn-large waves-effect waves-light red col s12 btn-rounded "
                                >Deshabilitada
                                    <i class="icon-refresh right"></i>
                                </a>
                            </div>

                        @endif
                        {{--@can('Cambiar Propietario - Vehiculo')
                            <div class="col s12 m4 center-align" style="margin-top:.5rem">
                                <a href="#" class="btn btn-large btn-rounded waves-effect waves-light peach col s12 "
                                   id="change-users">
                                    Cambiar Propietario
                                    <i class="icon-refresh right"></i>
                                </a>
                                <a href="#"
                                   class=" hide btn btn-large btn-rounded waves-effect waves-light blue col s12"
                                   id="save-change">
                                    Guardar Cambios
                                    <i class="icon-save right"></i>
                                </a>
                            </div>
                        @endcan--}}
                        @can('Actualizar Publicidad')
                            <div class="col s12 m6 center-align" style="margin-top:.5rem" id="block-update">
                                <a href="#!" class="btn btn-large btn-rounded waves-effect waves-light blue col s12 "
                                   id="update-publicity">
                                    Actualizar
                                    <i class="icon-mode_edit right"></i>
                                </a>
                                <button type="submit"
                                        class="btn btn-large hide btn-rounded waves-effect waves-light blue col s12 "
                                        id="update-publicity-save">
                                    Guardar Cambios
                                    <i class="icon-save right"></i>
                                </button>
                            </div>
                        @endcan

                        @can('Habilitar/Deshabilitar Publicidad')
                            <div class="col s12 m6 center-align" style="margin-top:.5rem" id="block-status">
                                @if($publicity->status===null||$publicity->status==='enabled')
                                    <button type="button"
                                            class="btn btn-rounded btn-large waves-effect waves-light red col s12 "
                                            id="publicity-status" value="disabled">
                                        Deshabilitar Publicidad
                                        <i class="icon-not_interested right"></i>
                                    </button>
                                @else
                                    <button type="button"
                                            class="btn btn-rounded btn-large waves-effect waves-light green col s12 "
                                            id="publicity-status" value="enabled">
                                        Activar Publicidad
                                        <i class="icon-check right"></i>
                                    </button>
                                @endif
                            </div>
                        @endcan

                        <div class="col s12 m12 center-align" style="margin-top:.5rem;display:none" id="block-back">
                            <a href="{{route('ticketOffice.publicity.detailsPublicity',['id'=>$publicity->id])}}" class="btn btn-large btn-rounded waves-effect waves-light peach col s12 " 
                               id="back">
                                Atrás
                                <i class="icon-keyboard_arrow_left left" style="margin:0"></i>
                            </a>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col m4">
                <form action="#" id="form-user" method="post" class="card testimonial-card">
                    <div class="card-header center-align">
                        <h5>Usuario Web</h5>
                    </div>
                    <div class="card-up"></div>
                    <div class="avatar avatar-centered">
                        @if (Storage::disk('users')->has($publicity->users[0]->image))
                            <img src="{{ route('users.getImage', ['filename' => $publicity->users[0]->image]) }}"
                                 alt="Image" width="100%" height="100%"
                                 class="circle responsive-img">
                        @else
                            <img src="{{ asset('images/user.png') }}" alt="" class="circle responsive-img" alt="Image"
                                 width="100%" height="100%">
                        @endif
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="V: Venezolano; E: Extrangero">
                            <i class="icon-public prefix"></i>
                            <select name="nationalitys" id="nationalitys" required disabled>
                                <option value="null">...</option>
                                <option value="V" @if ($publicity->users[0]->typeDocument=='V'){{"selected"}}@endif>V
                                </option>
                                <option value="E" @if ($publicity->users[0]->typeDocument=='E'){{"selected"}}@endif>E
                                </option>
                            </select>
                            <label for="nationalitys">Nacionalidad</label>
                        </div>
                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede escribir números. Ej: 12345678">
                            <input id="ci-uw" type="text" name="ci" class="validate" pattern="[0-9]+"
                                   minlength="7" maxlength="8" title="Solo puede escribir números." required
                                   value="{{$publicity->users[0]->document }}"
                                   readonly>
                            <label for="ci">Cedula</label>
                        </div>
                        <div class="input-field col s12 m12 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="name_user" type="text" name="name" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$publicity->users[0]->name }}" required readonly>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m12 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="surname" type="text" name="surname" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$publicity->users[0]->surname}}" required readonly>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s6 ">
                            <i class="icon-phone prefix tooltipped" data-position="S" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet<br>251:
                        Local"></i>
                            <select name="country_code" id="country_code_user" required disabled>
                                <option value="null" selected disabled>...</option>
                                <option value="+58412" @if ($publicity->users[0]->operator=='+58412'){{"selected"}}@endif >(412)
                                </option>
                                <option value="+58414" @if ($publicity->users[0]->operator=='+58414'){{"selected"}}@endif>(414)
                                </option>
                                <option value="+58416" @if ($publicity->users[0]->operator=='+58416'){{"selected"}}@endif>(416)
                                </option>
                                <option value="+58424" @if ($publicity->users[0]->operator=='+58424'){{"selected"}}@endif>(424)
                                </option>
                                <option value="+58426" @if ($publicity->users[0]->operator=='+58426'){{"selected"}}@endif>(426)
                                </option>
                                <option value="+58251" @if ($publicity->users[0]->operator=='+58251'){{"selected"}}@endif>(251)
                                </option>
                            </select>
                            <label for="country_code">Operadora</label>
                        </div>
                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede escribir números">
                            <label for="phone">Teléfono</label>
                            <input id="phone_user" type="tel" name="phone"
                                   value="{{ $publicity->users[0]->numberPhone }}"
                                   class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números."
                                   placeholder="Ej. 1234567" maxlength="7" minlength="7" required readonly>
                        </div>


                        <div class="input-field col s12 tooltipped" data-position="bottom"
                             data-tooltip="Ej: correo@mail.com">
                            <i class="icon-mail_outline prefix"></i>
                            <input id="email" type="email" name="email" class="validate"
                                   value="{{ $publicity->users[0]->email }}" required readonly>
                            <label for="email">E-mail</label>
                        </div>
                        <div id="changeUserWeb">

                        </div>
                        @can('Cambiar Usuario - Publicidad')
                            <div class="input-field col s12 m12 ">
                                <a id="changeUW" href="#"
                                   class="center btn btn-large waves-effect waves-light peach col s12 btn-rounded ">Cambiar
                                    Usuario Web
                                    <i class="icon-mode_edit right"></i>
                                </a>
                                <a id="saveUW" href="#"
                                   class="hide btn btn-large waves-effect waves-light blue col s12 btn-rounded ">Guardar
                                    Cambios
                                    <i class="icon-save right"></i>
                                </a>
                            </div>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
        @can('Historial de Pago - Publicidad')

            <div class="row">
                <div class="row">

                    <h4 class="center-align">Registro de Pagos:</h4>

                </div>
                <a href="{{route('ticketOffice.publicity.historyPayment',['id'=>$publicity->id])}}">
                    <div class="col s12 m12">
                        <div class="widget bootstrap-widget stats white-text">
                            <div class="widget-stats-icon green-gradient white-text">
                                <i class="fas fa-camera-retro"></i>
                            </div>
                            <div class="widget-stats-content">
                                <span class="widget-stats-title black-text">Publicidad</span>
                                <span class="widget-stats-number black-text">{{$publicity->publicityTaxes()->count()}}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

    </div>

    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script>
        $('#history').DataTable({
            responsive: true,
            scroller: true,
            "scrollX": true,
            "pageLength": 10,
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Todavia este contribuyente ningun pago.",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "<i class='icon-navigate_next'></i>",
                    "sPrevious": "<i class='icon-navigate_before'></i>"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            }
        });
    </script>
    <script src="{{ asset('js/data/publicityTicketOffice.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection