@extends('layouts.app2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mi Empresa</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
                <a href="" class="breadcrumb">Pagar Impuestos</a>
            </div>
            <div class="col s12 m8 offset-m2">
                @if(session('message'))
                    {{session('message')}}
                @endIf
                <form action="{{ route('taxes.save') }}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Pagar Impuesto</h5>
                    </div>
                    <div class="card-content row">
                        <input type="hidden" id="company_id" name="company_id" value="1">
                        <div class="input-field col s12">
                            <input type="text" name="fiscal_period" id="fiscal_period" class="datepicker" >
                            <label for="fiscal_period">Año Fiscal</label>
                        </div>
                        @foreach($company->ciu as $ciu)
                        <input type="hidden" name="ciu_id[]" value="{{$ciu->id}}" ><br>
                        <div class="input-field col s12 m6">
                            <input type="text" name="code" id="code" value="{{ $ciu->code }}" required disabled>
                            <label for="code">Código</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="ciu" id="ciu" value="{{ $ciu->name }}" required disabled>
                            <label for="ciu">CIU</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="base[]" id="base" required>
                            <label for="base">Base Imponible</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="deductions[]" id="deductions" required>
                            <label for="deductions">Deducciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="withholding[]" id="withholdings" required>
                            <label for="withholdings">Retenciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="fiscal_credits[]" id="fiscal_credits" required>
                            <label for="fiscal_credits">Creditos Fiscales</label>
                        </div>
                        <div class="input-field col s12">
                            <div class="divider"></div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn waves-effect waves-light blue">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection