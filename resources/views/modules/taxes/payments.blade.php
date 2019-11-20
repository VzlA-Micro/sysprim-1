@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mi Empresa</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
                <a href="" class="breadcrumb">Pagar Impuestos</a>
                <a href="" class="breadcrumb">Detalles de Pago</a>
            </div>
            <div class="col s12 m10 offset-m1">
            	<ul class="tabs">
			        <li class="tab col s4"><a href="#test1">Test 1</a></li>
			        <li class="tab col s4"><a href="#test3">Disabled Tab</a></li>
			        <li class="tab col s4"><a href="#test4">Test 4</a></li>
			     </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection