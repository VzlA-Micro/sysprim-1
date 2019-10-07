@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Detalles de Pago</h5>
                    </div>
                    <div class="card-content">
                        <ul>
                            <li><b>Código: </b>{{ $taxes->code }}</li>
                            <li><b>Periodo Fiscal: </b>{{ $taxes->fiscal_period }}</li>
                            <li><b>Fecha: </b>{{ $taxes->created_at }}</li>
                            {{-- <li class="divider"></li> --}}
                        </ul>
                    </div>
                    <div class="card-header center-align">
                        <h5>Datos de la Empresa</h5>
                    </div>
                    <div class="card-content">
                        <ul>
                            <li><b>Nombre: </b>{{ $taxes->companies->name }}</li>
                            <li><b>RIF: </b>{{ $taxes->companies->rif }}</li>
                            <li><b>Licencia: </b>{{ $taxes->companies->license }}</li>
                            <li><b>Fecha de Apertura: </b>{{ $taxes->companies->opening_date }}</li>
                            <li><b>Dirección: </b>{{ $taxes->companies->address }}</li>
                        </ul>
                    </div>
                    @if (Storage::disk('companies')->has($taxes->companies->image))
                    <div class="card-image">
                        <img src="{{ route('companies.image', ['filename' => $taxes->companies->image]) }}" alt="" srcset="">
                    </div>
                    @endif
                    <div class="card-header center-align">
                        <h5>Datos de Impuestos - CIU</h5>
                    </div>
                    <form method="post" action="" class="card-content row">
                        @csrf
                        @foreach($taxes->taxesCiu as $ciu)
                        <div class="input-field col s12 m6">
                            <input type="text" name="code" id="code" value="{{ $ciu->code }}" required disabled>
                            <label for="code">Código</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="ciu" id="ciu" value="{{ $ciu->name }}" required disabled>
                            <label for="ciu">CIU</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="base[]" id="base" class="validate" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->pivot->base }}" disabled>
                            <label for="base">Base Imponible</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="deductions[]" id="deductions" class="validate" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->pivot->deductions }}" disabled>
                            <label for="deductions">Deducciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="withholding[]" id="withholdings" class="validate" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->pivot->withholding }}" disabled>
                            <label for="withholdings">Retenciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="fiscal_credits[]" id="fiscal_credits" class="validate" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->pivot->fiscal_credits }}" disabled>
                            <label for="fiscal_credits">Creditos Fiscales</label>
                        </div>
                        <div class="input-field col s12">
                            <div class="divider"></div>
                        </div>
                        @endforeach
                        <div class="input-field col s12">
                            <button type="submit" class="btn col s12 blue">Actualizar</button>
                        </div>
                    </form>
                    <div class="card-action">
                        <div class="row">
                            <button class="btn blue col s12 m6">Editar</button>
                            <button class="btn red col s12 m6">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection