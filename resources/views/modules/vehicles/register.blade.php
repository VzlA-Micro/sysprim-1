@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    @if(isset($idCompany))
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a
                                    href="{{ route('companies.details', ['id' => $idCompany]) }}">{{$company}}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Registrar Vehículos</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.my-vehicles')}}">Mis Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="#">Registrar Vehículos</a></li>
                    @endif

                </ul>
            </div>
            <form id="vehicle" action="#" method="post" class="col s12 m8 offset-m2" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Vehículo</h5>
                    </div>
                    <div class="card-content row">
                        <input type="hidden" value="propietario" id="status" name="status">
                        <input type="hidden" value="{{$idCompany}}" id="idCompany" name="idCompany">
                        <input type="hidden" name="Vcompany" value="true">
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: L1S2M3">
                            <i class="icon-crop_16_9 prefix"></i>
                            <input type="text" name="license_plate" id="license_plate" minlength="7" maxlength="7"
                                   pattern="[0-9A-Za-z]+" autocomplete="off"
                                   title="Solo puede escribir números y letra en mayúsculas." class="validate" required>
                            <label for="license_plate">Placa</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-airport_shuttle prefix"></i>
                            <select name="typeV" id="typev" required>
                                {{--<option value="null" disabled selected>Selecciona el tipo de vehiculo</option>--}}
                                @foreach($type as $types)
                                    <option value="{{$types->id}}">{{$types->name}}</option>
                                @endforeach
                            </select>
                            <label for="type">Tipo De Vehículo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input type="text" name="bodySerial" id="bodySerial" class="validate" pattern="[A-Za-z0-9]+"
                                   title="Solo puede escribir letras y numeros." autocomplete="off" minlength="15" maxlength="17" required>
                            <label for="bodySerial">Serial de carroceria</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-opacity prefix"></i>
                            <input type="text" name="color" id="color" class="validate" pattern="[A-Za-z]+"
                                   title="Solo puede escribir letras." minlength="3" maxlength="20" required>
                            <label for="color">Color</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-select_all prefix"></i>
                            <input type="text" name="serialEngine" id="serialEngine" class="validate"
                                   pattern="[A-Za-z0-9]+" minlength="15" maxlength="20"
                                   title="Solo puede escribir letras y numeros." autocomplete="off" required>
                            <label for="serialEngine">Serial del motor</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-event_note prefix"></i>
                            <input type="text" name="year" id="year" class="validate number-date" pattern="[0-9]+"
                                   minlength="4"
                                   maxlength="4"
                                   title="Solo puede escribir numeros." required>
                            <label for="year">Año</label>
                        </div>
                        <div class="file-field input-field col s12 m12 l12">

                            <div class="btn purple btn-rounded waves-light">
                                <span><i class="icon-photo_size_select_actual right"></i>Imagen</span>
                                <input type="file" name="image" id="image">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text"
                                       placeholder="Elige una imagen del vehículo.">
                            </div>
                        </div>
                        <div id="group-MB">
                            <div class="input-field col s12 m6">
                                <i class="icon-directions_car prefix"></i>
                                <select name="brand" id="brand" required>
                                    <option value="null" disabled selected>Selecciona la marca</option>
                                    @foreach($brand as $brands)
                                        <option value="{{$brands->id}}">{{$brands->name}}</option>
                                    @endforeach

                                </select>
                                <label for="brand">Marca</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-local_shipping prefix"></i>
                                <select name="model" id="model" required>
                                    <option value="null" disabled selected>Selecciona el módelo</option>
                                </select>
                                <label for="model">Módelo</label>
                            </div>
                        </div>
                        <div id="group-new-MB">

                        </div>
                        <div class="container col s12">
                            <p><span class=""><b>NOTA: </b></span>En caso que la marca o modelo de su vehículo no se
                                encuentre registrado en nuestro sistema, presiona el botón de <b>REGISTRAR MARCA</b> e
                                introduce los siguientes datos:<br> 1- Marca<br> 2- Modelo<br></p>
                        </div>


                        {{--<div class="container">
                            <p><span class=""><b>NOTA: </b></span>En caso que la marca o modelo de su vehiculo, no se encuentre registrado en nuestro sistema. Por favor envíanos un correo a esta Dirección: correo, con los siguientes datos:<br> 1- Marca<br> 2- Modelo<br> 3- Año </p>
                        </div>--}}

                        <div class="input-field col s12 center-align">
                            <a href="#" id="button-brand" class="btn btn-rounded btn-large blue waves-effect">Registrar Marca<i
                                        class="icon-file_upload right"></i></a>
                            <button id="button-vehicle" type="submit"
                                    class="btn btn-rounded btn-large peach waves-effect">
                                Registrar<i class="icon-send right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/vehicle.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection