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
            <div class="col s12">
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
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection