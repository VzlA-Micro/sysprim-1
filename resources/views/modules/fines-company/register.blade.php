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
                    <li class="breadcrumb-item"><a href="{{ route('fines-company.create') }}">Registrar</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form id="register" action="{{ route('fines-company.save') }}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Asignar Multa a Compañia</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6">
                            <input type="hidden" value="{{$Company->id}}" name="idCompany" id="idCompany">   
                            <i class="icon-work prefix"></i>                            
                            <input type="text" value="{{$Company->name}}" name="nameCompany" id="nameCompany" disabled required>
                            <label for="name">Razón Social</label>
                       </div>
                       <div class="input-field col s12 m6">
                            <i class="icon-perm_contact_calendar prefix"></i>
                            <input type="text" name="rif" id="rif" value="{{$Company->RIF}}" disabled required>
                            <label for="name">RIF</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-attach_money prefix"></i>
                            <input type="number" name="valueUndTributo" id="valueUndTributo" value="{{$tributo->value}}" readonly required>
                            <label for="valueUndTributo">Valor de unidad tributaria</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>                                                                                   
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
                        <button type="submit" class="btn btn-rounded btn-large waves-effect waves-light peach">
                            Register
                            <i class="icon-send right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection