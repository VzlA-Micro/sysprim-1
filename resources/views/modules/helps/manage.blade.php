@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
        	<div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('helps.manage') }}">Ayuda</a></li>
                </ul>
            </div>
            {{--<div class="col s12 m4">
                <div class="row">
                    <div class="col s12">
                        <div class="alert alert-green" style="margin-top: 7px; margin-bottom: 0">
                            <b>Contacto: </b><br>
                            <b>WhtasApp: </b>+580000000000<br>
                            <b>E-mail: </b> sysprim@gmail.com
                        </div>
                    </div>
                </div>
            </div>--}}
            <div class="col s12 m12 l8">
                <div class="collection with-header">
                    <div class="collection-header center-align"><h4>Ayuda</h4></div>
                    <a href="{{ route('download', ['file' => 'Manual_Registro_Empresa.pdf']) }}" class="collection-item red-text text-darken-4">
                        <div>
                            Registrar mi Empresa
                            <span class="secondary-content"><i class="icon-get_app red-text text-darken-2" style="font-size: 22px;"></i></span>
                        </div>
                    </a>
                    <!-- <a href="{{ route('download', ['file' => 'Manual_Conciliacion_Pago.pdf']) }}" class="collection-item red-text text-darken-4">
                        <div>
                            Conciliar Pagos - Actividad Económica
                            <span class="secondary-content"><i class="icon-get_app red-text text-darken-2" style="font-size: 22px;"></i></span>
                        </div>
                    </a> -->
                    <!-- <a href="" class="collection-item red-text text-darken-2">
                        <div>
                            Alvin
                            <span class="secondary-content"><i class="icon-send red-text text-darken-2" style="font-size: 22px;"></i></span>
                        </div>
                    </a>
                    <a href="" class="collection-item red-text text-darken-2">
                        <div>
                            Alvin
                            <span class="secondary-content"><i class="icon-send red-text text-darken-2" style="font-size: 22px;"></i></span>
                        </div>
                    </a> -->
                </div>
            </div>
            <div class="col s12 m12 l4" style="margin-top: 7px; margin-bottom: 0">
                <article class="message message-red-semat">
                    <div class="message-header">
                        <span style="font-size: 20px">Contactanos:</span>
                        <i class="fas fa-phone-alt right small"></i>
                    </div>
                    <div class="message-body">
                        <span style="font-size: 20px" class="truncate">
                            <i class="fab fa-whatsapp"></i>
                            <b>WhatsApp: </b> <a href="https://wa.me/584120574860">+584120574860</a>
                        </span><br>
                        <span style="font-size: 20px" class="truncate">
                            <i class="fas fa-mail-bulk"></i>
                            <b>E-mail: </b> sysprim@gmail.com
                        </span>
                    </div>
                </article>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection