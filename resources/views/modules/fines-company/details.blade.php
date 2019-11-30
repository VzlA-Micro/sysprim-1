@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fines.manage') }}">Gestionar Multas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fines-company.manage') }}">Multas y Empresas</a></li>
                    <li class="breadcrumb-item"><a href="#!">Ver Multas</a></li>
                    <li class="breadcrumb-item"><a href="#!">Detalles</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles de Multa a Empresa</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <input id="name" type="text" name="name"readOnly required value="{{$company[0]->name}}">
                            <label for="name">Nombre de Empresa </label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="rif" type="text" name="rif" readOnly required value="{{$company[0]->RIF}}">
                            <label for="rif">Rif de Empresa </label>
                         </div>
                         <div class="input-field col s12 m6">
                            <input id="address" type="text" name="address" readOnly required value="{{$company[0]->address}}">
                            <label for="address">Direccion de Empresa </label>
                         </div>
                         <div class="input-field col s12 m6">
                            <input id="sector" type="text" name="sector" readOnly required value="{{$company[0]->sector}}">
                            <label for="sector">Sector de Empresa </label>
                         </div>
                         <div class="input-field col s12 m6">
                            <input id="fines" type="text" name="fines" readOnly required value="{{$fines[0]->name}}">
                            <label for="fines">Multa a Empresa </label>
                         </div>
                         <div class="input-field col s12 m6">
                            <input id="undTributo" type="text" name="undTributo" readOnly required value="{{$fines[0]->cant_unid_tribu}}">
                            <label for="undTributo">Cantidad de unidad tributaria </label>
                         </div>
                         <div class="input-field col s12 m6">
                            <input id="valueUndTributo" type="text" readOnly name="valueUndTributo" required value="{{$finesCompany->unid_tribu_value}} BS">
                            <label for="valueUndTributo">Valor de unidad tributaria </label>
                         </div>
                         <div class="input-field col s12 m6">
                            <input id="totalTributo" type="text" readOnly name="totalUndTributo" required value="{{$finesCompany->unid_tribu_value * $finesCompany->unid_tribu_value}} BS">
                            <label for="totalUndTributo">Total </label>
                         </div>
                    </div>
                 </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection