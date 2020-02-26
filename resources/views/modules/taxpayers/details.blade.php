@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    {{-- <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li> --}}
                    <li class="breadcrumb-item"><a href="{{ route('taxpayers.manage') }}">Gestionar Usuarios Web</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('taxpayers.read') }}">Ver Usuarios Web</a></li>
                    <li class="breadcrumb-item"><a href="#!">Detalles</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <form action="#" method="post" class="card" id="update">

                    <div class="card-header center-align">
                        <h5>Detalles del Usuario Web</h5>
                    </div>


                    <div class="card-content row">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                        <div class="input-field col m6 s12 tooltipped" data-position="bottom"
                             data-tooltip="Solo puede escribir números. Ej: 12345678">
                            <i class="icon-public prefix"></i>
                            <input id="ci" type="text" name="ci" class="validate number-only" pattern="[0-9VE]+"
                                   title="Solo puede escribir números." value="{{ $user->ci }}" required disabled>
                            <label for="ci">Cedula</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-person prefix tooltipped" data-position="bottom"
                               data-tooltip="Solo puede agregar letras (con acentos)."></i>
                            <input id="name" type="text" name="name" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)." value="{{ $user->name }}" required
                                   disabled>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-person prefix tooltipped" data-position="bottom"
                               data-tooltip="Solo puede agregar letras (con acentos)."></i>
                            <input id="surname" type="text" name="surname" class="validate"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)." value="{{ $user->surname }}"
                                   disabled required>
                            <label for="surname">Apellido</label>
                        </div>

                        <div class="input-field col s6 m3">
                            <i class="icon-phone_android prefix tooltipped" data-position="bottom" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet"></i>
                            <select name="country_code" id="country_code" required disabled>
                                <option value="null" selected disabled>...</option>
                                <option value="+58412" @if ($user->operator=='+58412'){{"selected"}}@endif >(412)</option>
                                <option value="+58414" @if ($user->operator=='+58414'){{"selected"}}@endif>(414)</option>
                                <option value="+58416" @if ($user->operator=='+58416'){{"selected"}}@endif>(416)</option>
                                <option value="+58424" @if ($user->operator=='+58424'){{"selected"}}@endif>(424)</option>
                                <option value="+58426" @if ($user->operator=='+58426'){{"selected"}}@endif>(426)</option>
                                <option value="+58251" @if ($user->operator=='+58251'){{"selected"}}@endif>(251)</option>
                            </select>
                            <label for="country_code_user" >Operadora</label>
                        </div>
                        <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                            <label for="phone_user">Teléfono</label>
                            <input id="phone_user" type="tel" name="phone" class="validate" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required readonly value="{{$user->NumberPhone}}" >
                        </div>                        <div class="input-field col s12">
                            <i class="icon-mail_outline prefix tooltipped" data-position="bottom"
                               data-tooltip="Ej: correo@mail.com"></i>
                            <input id="email_edit" type="email" name="email" class="validate" value="{{ $user->email }}"
                                   disabled required>
                            <label for="email_edit">E-mail</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="icon-verified_user prefix tooltipped" data-position="bottom"></i>
                            <input id="statusName" type="text" name="status" class="validate"
                                   value="{{ $user->statusName }}" required readonly>
                            <label for="statusName">Estado de Cuenta:</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="icon-verified_user prefix tooltipped" data-position="bottom"></i>
                            <input id="statusEmail" type="text" name="status" class="validate"
                                   value="{{ $user->statusEmail }}" required readonly>
                            <label for="statusEmail">Estado de Email:</label>
                        </div>


                        <div class="input-field col s12 m12">
                            <i class="icon-directions prefix"></i>
                            <textarea name="address" id="address" cols="30" rows="12" class="materialize-textarea" maxlength="150" required disabled>{{$user->address}}</textarea>
                            <label for="address">Dirección</label>
                        </div>


                        <input type="hidden" name="role" id="role" value="3">
                    </div>

                    <div class="row">
                        <div class="row">

                            <h4 class="center-align">Registros:</h4>

                        </div>
                        <div class="col  l12">

                            <a href="{{route('taxpayers.details.company',['id'=>$user->id])}}">
                                <div class="col s12 m3">
                                    <div class="widget bootstrap-widget stats white-text">
                                        <div class="widget-stats-icon blue-gradient">
                                            <i class="fas fa-home"></i>
                                        </div>
                                        <div class="widget-stats-content">
                                            <span class="widget-stats-title black-text">Empresas</span>
                                            <span class="widget-stats-number black-text">{{$number_company}}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>


                            <a href="{{route('taxpayers.details.rates',['id'=>$user->id])}}">
                                <div class="col s12 m3">
                                    <div class="widget bootstrap-widget stats white-text">
                                        <div class="widget-stats-icon red-gradient white-text">
                                            <i class="fas fa-clipboard"></i>
                                        </div>
                                        <div class="widget-stats-content">
                                            <span class="widget-stats-title black-text">Tasas</span>
                                            <span class="widget-stats-number black-text">{{$number_rate}}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>





                            <a href="{{route('taxpayers.details.vehicle',['id'=>$user->id])}}">
                                <div class="col s12 m3">
                                    <div class="widget bootstrap-widget stats white-text">
                                        <div class="widget-stats-icon green-gradient white-text">
                                            <i class="fas fa-car"></i>
                                        </div>
                                        <div class="widget-stats-content">
                                            <span class="widget-stats-title black-text">Vehiculos</span>
                                            <span class="widget-stats-number black-text">{{$number_vehicle}}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>


                            <a href="{{route('taxpayers.details.property',['id'=>$user->id])}}">
                                <div class="col s12 m3">
                                    <div class="widget bootstrap-widget stats white-text">
                                        <div class="widget-stats-icon green-gradient white-text">
                                            <i class="fas icon-location_city"></i>
                                        </div>
                                        <div class="widget-stats-content">
                                            <span class="widget-stats-title black-text">Inmuebles</span>
                                            <span class="widget-stats-number black-text">{{$number_property}}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>



                        </div>


                    </div>
                    @can('Actualizar Contribuyentes')
                        <div class="card-footer">
                            <div class="row">
                                @can('Resetear Contribuyentes')
                                    <div class="col s12 m6 center-align">
                                        <a href="#!" class="btn btn-rounded btn-large peach waves-effect waves-light col s12"
                                           id="btn-reset-password" style="margin-top:10px">
                                            <i class="icon-send right"></i>
                                            Restablecer Contraseña
                                        </a>
                                    </div>
                                @endcan
                                <div class="col s12 m6 center-align">
                                    <a href="#!" class="btn btn-rounded btn-large blue waves-effect waves-light col s12"
                                       id="btn-edit" style="margin-top:10px">
                                        <i class="icon-send right"></i>
                                        Editar
                                    </a>
                                    <button type="submit"
                                            class="btn btn-rounded btn-large peach waves-effect waves-light col s12"
                                            style="display: none" id="btn-update" style="margin-top:10px">
                                        <i class="icon-save right"></i>
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/taxpayers.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection