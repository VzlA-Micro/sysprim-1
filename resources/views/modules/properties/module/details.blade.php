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
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.home') }}">Taquilla - Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.manager-property') }}">Modulo - Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.read-property') }}">Modulo - Consultar Inmubles Urbanos</a></li>
                </ul>
            </div>
            <div class="col s12 m8 l8">
                <form action="#" method="POST" class="card" enctype="multipart/form-data">
                    <div class="card-header center-align">
                        <h5>{{$property->code_cadastral}}</h5>
                    </div>
                    <div class="card-content row">
                        @csrf

                        <input type="hidden" name="id" id="id" value="{{ $property->id }}">


                        <div class="input-field col m12 s12">
                            <h5 class="center-align">Datos del Propietario</h5>
                        </div>


                        <div class="input-field col s4 m4">
                            <i class="icon-perm_contact_calendar prefix tooltipped" data-position="bottom" data-tooltip="J = Juridico<br>G = Gubernamental<br>V = Venezolano<br>E = Extranjero"></i>
                            <select name="document_type" id="document_type" disabled>
                                <option value="null" selected disabled>...</option>
                                <option value="J" @if ($data->typeDocument=='J'){{"selected"}}@endif>J</option>
                                <option value="V" @if ($data->typeDocument=='V'){{"selected"}}@endif>V</option>
                                <option value="G" @if ($data->typeDocument=='G'){{"selected"}}@endif>G</option>
                                <option value="E" @if ($data->typeDocument=='E'){{"selected"}}@endif>E</option>
                            </select>
                            <label for="document_type">Documento</label>
                        </div>






                        <div class="input-field col s12 m4">
                            <i class="icon-account_box prefix"></i>
                            <input id="document" type="text" name="document" value="{{$data->document}}" readonly>
                            <label for="document">Cedula o RIF</label>
                        </div>



                        <div class="input-field col s12 m4">
                            <i class="icon-account_box prefix"></i>
                            <input id="lat" type="text" name="name "
                                   @if($type=='users')
                                      value="{{$data->name. ' '. $data->surname}}"
                                   @else
                                         value="{{$data->name}}"
                                   @endif
                                   readonly>
                            <label for="name">Nombre</label>
                        </div>

                        <div class="input-field col s12">
                            <i class="icon-directions prefix"></i>
                            <textarea name="address" id="address" cols="30" rows="12" class="materialize-textarea"  readonly required maxlength="200">{{$data->address}}</textarea>
                            <label for="address">Dirección</label>
                        </div>




                        <div class="input-field col m12 s12">
                            <h5 class="center-align">Datos del Inmuebles</h5>
                        </div>

                        <div class="input-field col m6 s12">
                            <i class="icon-map prefix"></i>
                            <select name="location_cadastral" id="location_cadastral" required disabled>
                                <option value="null" disabled selected>Seleccionar ubicacion Catastral</option>
                                @foreach($catasTerreno as $cT):
                                  @if($property->value_cadastral_ground_id==$cT->id)
                                   <option value="{{$cT->id }}" selected>{{ $cT->name}}</option>
                                    @else
                                    <option value="{{$cT->id }}">{{ $cT->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label>Ubicación Catastral</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <i class="icon-domain prefix"></i>
                            <select name="type_const" id="type_const" required>
                                <option value="null" disabled selected>Seleccionar Tipo de Construccion</option>
                                @foreach($catasConstruccion as $cC):
                                @if($property->valueBuild->id==$cC->id)
                                     <option value="{{$cC->id }}" selected>{{ $cC->name}}</option>
                                @else
                                    <option value="{{$cC->id }}">{{ $cC->name}}</option>
                                @endif
                                @endforeach
                            </select>
                            <label>Tipo de Construccion</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-panorama_horizontal prefix"></i>
                            <input type="text" name="area_ground" id="area_ground" class="validate number-only" pattern="[0-9.]+"
                                   data-tooltip="Solo puede usar números y caracter especial(.) . Ej: 15.47"
                                   required maxlength="8" value="{{$property->area_ground}}" readonly>
                            <label for="area_ground">Area de Terreno</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-location_city prefix"></i>
                            <input type="text" name="area_build" id="area_build" maxlength="8" class="validate number-only" pattern="[0-9.]+"
                                   data-tooltip="Solo puede usar números y caracter especial(.) . Ej: 15.47"
                                   required  value="{{$property->area_build}}" readonly >
                            <label for="area_build">Area de Construcción</label>
                        </div>

                        <div class="input-field col m6 s12">
                            <i class="icon-domain prefix"></i>
                            <select name="type_inmueble_id" id="type_inmueble_id" required disabled>
                                <option value="null" disabled selected>Seleccionar Tipo de Inmueble</option>
                                @foreach($alicuota as $value):
                                @if($property->type_inmueble_id==$value->id)
                                    <option value="{{ $value->id }}" selected >{{ $value->name }}</option>
                                @else
                                    <option value="{{ $value->id }}" >{{ $value->name }}</option>
                                @endif


                                @endforeach
                            </select>
                            <label>Tipo de Inmueble</label>
                        </div>

                        <div class="input-field col m6 s12">
                            <i class="icon-satellite prefix"></i>
                            <select name="parish" id="parish" required disabled>
                                <option value="null" disabled selected>Seleccionar una Parroquia</option>
                                @foreach($parish as $parish):
                                @if($property->parish_id==$parish->id)

                                <option value="{{ $parish->id }}" selected>{{ $parish->name }}</option>
                                @else
                                    <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                                @endif
                                @endforeach
                            </select>
                            <label>Parroquia</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-directions prefix"></i>
                            <textarea name="address" id="address" cols="30" rows="12" class="materialize-textarea"  readonly required maxlength="200">{{$property->address}}</textarea>
                            <label for="address">Dirección</label>
                        </div>




                        <div class="input-field col s12 m6">
                            <i class="icon-my_location prefix"></i>
                            <input id="lat" type="text" name="lat" value="{{$property->lat}}" readonly>
                            <label for="lat">Latitud</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-my_location prefix"></i>
                            <input id="lng" type="text" name="lng" value="{{$property->lng}}" readonly>
                            <label for="lng">Logintud</label>
                        </div>


                        <div class="col l12">
                            <div class="row">

                                    <div class="col s12 m3">
                                        <a href="#" class="btn btn-large waves-effect waves-light green col s12 "
                                           id="update-company">
                                            Actualizar
                                            <i class="icon-refresh right"></i>
                                        </a>
                                    </div>

                            </div>
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
                        @if (Storage::disk('users')->has($property->users[0]->image))
                            <img src="{{ route('users.getImage', ['filename' => $property->users[0]->image]) }}" alt=""
                                 class="circle responsive-img">
                        @else
                            <img src="{{ asset('images/user.png') }}" alt="" class="circle responsive-img">
                        @endif
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="V: Venezolano; E: Extrangero">
                            <i class="icon-public prefix"></i>
                            <select name="nationality" id="nationality" required disabled>
                                <option value="null">...</option>
                                <option value="V" @if ($property->users[0]->typeDocument=='V'){{"selected"}}@endif>V
                                </option>
                                <option value="E" @if ($property->users[0]->typeDocument=='E'){{"selected"}}@endif>E
                                </option>
                            </select>
                            <label for="nationality">Nacionalidad</label>
                        </div>
                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede escribir números. Ej: 12345678">
                            <input id="ci" type="text" name="ci" class="validate" pattern="[0-9]+"
                                   title="Solo puede escribir números." required
                                   value="{{$property->users[0]->document }}"
                                   readonly>
                            <label for="ci">Cedula</label>
                        </div>
                        <div class="input-field col s12 m12 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="name_user" type="text" name="name" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$property->users[0]->name }}" required readonly>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m12 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede agregar letras (con acentos).">
                            <i class="icon-person prefix"></i>
                            <input id="surname" type="text" name="surname" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)."
                                   value="{{$property->users[0]->surname}}" required readonly>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s6 ">
                            <i class="icon-phone prefix tooltipped" data-position="S" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet<br>251:
                        Local"></i>
                            <select name="country_code" id="country_code_user" required disabled>
                                <option value="null" selected disabled>...</option>
                                <option value="+58412" @if ($property->users[0]->operator=='+58412'){{"selected"}}@endif >
                                    (412)
                                </option>
                                <option value="+58414" @if ($property->users[0]->operator=='+58414'){{"selected"}}@endif>
                                    (414)
                                </option>
                                <option value="+58416" @if ($property->users[0]->operator=='+58416'){{"selected"}}@endif>
                                    (416)
                                </option>
                                <option value="+58424" @if ($property->users[0]->operator=='+58424'){{"selected"}}@endif>
                                    (424)
                                </option>
                                <option value="+58426" @if ($property->users[0]->operator=='+58426'){{"selected"}}@endif>
                                    (426)
                                </option>
                                <option value="+58251" @if ($property->users[0]->operator=='+58251'){{"selected"}}@endif>
                                    (251)
                                </option>
                            </select>
                            <label for="country_code">Operadora</label>
                        </div>
                        <div class="input-field col s6 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede escribir números">
                            <label for="phone">Teléfono</label>
                            <input id="phone_user" type="tel" name="phone" value="{{ $property->users[0]->numberPhone }}"
                                   class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números."
                                   placeholder="Ej. 1234567" maxlength="7" minlength="7" required readonly>
                        </div>


                        <div class="input-field col s12 tooltipped" data-position="bottom"
                             data-tooltip="Ej: correo@mail.com">
                            <i class="icon-mail_outline prefix"></i>
                            <input id="email" type="email" name="email" class="validate"
                                   value="{{ $property->users[0]->email }}" required readonly>
                            <label for="email">E-mail</label>
                        </div>
                        @can('Cambiar Usuario - Empresa')
                        <div class="input-field col s12 m6">
                            <a href="#" class="btn btn-large waves-effect waves-light green col s12 btn-rounded " id="change-users">Cambiar Usuario
                                <i class="icon-refresh right"></i>
                            </a>
                        </div>
                        @endcan
                    </div>


                </form>
            </div>
        </div>

        @can('Historial de Pago - Empresas')


        <div class="row">
            <div class="row">

                <h4 class="center-align">Registro de Pagos:</h4>

            </div>
        </div>

        @endcan

        <div class="col s12 location-container tooltipped mb-2" id="div-map" data-position="left"
             data-tooltip="Acerca el mapa y selecciona tu ubicación, puede tomar algunos segundos.">
            <div id="map" style="height: 500px;width: 100%; margin-top:1rem"></div>
        </div>





    </div>

    </div>
@endsection
@section('scripts')

    {{--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU"
            type="text/javascript"></script>--}}



    <script src="{{ asset('js/validations.js') }}"></script>
@endsection