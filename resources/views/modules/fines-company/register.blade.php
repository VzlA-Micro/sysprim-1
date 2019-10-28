@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Gestionar Mutlas</a>
                <a href="" class="breadcrumb">Multas y Empresas</a>
                <a href="" class="breadcrumb">Registrar</a>
            </div>
            <div class="col s12 m8 offset-m2">
                <form id="register" action="{{ route('fines-company.save') }}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Asignar Multa a Compañia</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6">
                            <input type="hidden" value="{{$Company->id}}" name="idCompany" id="idCompany">    
                            <input type="text" value="{{$Company->name}}" name="nameCompany" id="nameCompany" disabled required>
                            <label for="name">Nombre</label>
                       </div>
                       <div class="input-field col s12 m6">
                            <input type="text" name="rif" id="rif" value="{{$Company->RIF}}" disabled required>
                            <label for="name">RIF</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="valueUndTributo" id="valueUndTributo" value="{{$tributo->value}}" readonly required>
                            <label for="valueUndTributo">Valor de unidad tributaria</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <select name="fines" id="fines" required>
                                <option value="" disabled selected>Elije una opción...</option>
                                @foreach($fines as $fine)
                                    <option value="{{$fine->id}}">{{$fine->name}}----{{$fine->cant_unid_tribu}}</option>
                                @endforeach
                            </select>
                            <label for="type">Multa</label>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded btn-large waves-effect waves-light peach">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection