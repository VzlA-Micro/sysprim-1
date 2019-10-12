@extends('layouts.app')

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
            <div class="col s12 m8 offset-m2">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Detalles de Pago</h5>
                    </div>
                    <div class="row padding-2 left-align">
                        <div class="col m6">
                            <ul>
                                <li><b>Código: </b>{{ $taxes->code }}</li>
                                <li><b>Periodo Fiscal: </b>{{ $taxes->fiscal_period }}</li>
                                <li><b>Fecha: </b>{{ $taxes->created_at }}</li>

                            </ul>
                        </div>
                        <div class="col m6">
                            <ul>
                                <li><b>Nombre: </b>{{ $taxes->companies->name }}</li>
                                <li><b>RIF: </b>{{ $taxes->companies->RIF }}</li>
                                <li><b>Licencia: </b>{{ $taxes->companies->license }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="divider"></div>
                    @if (Storage::disk('companies')->has($taxes->companies->image))
                    <div class="card-image">
                        <img src="{{ route('companies.image', ['filename' => $taxes->companies->image]) }}" alt="" srcset="">
                    </div>
                    @endif

                    <div class="card-header center-align">
                        <h5>Detalles de Actividad Económica</h5>
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

                            <div class="input-field col s12 m4">
                                <input type="number" name="total_ciu[]" id="total_ciu" class="validate total_ciu" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ ($ciu->alicuota*$ciu->pivot->base/100)}}" disabled>

                                <label for="fiscal_credits">Total a Pagar por CIU<b> (Bs)</b></label>
                            </div>


                            <div class="input-field col s12 m4">
                                <input type="number" name="tasa[]" id="tasa" class="validate tasa" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="0" disabled>
                                <label for="fiscal_credits">Tasa<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m4">
                                <input type="number" name="mora[]" id="mora" class="validate mora" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="0" disabled>
                                <label for="fiscal_credits">Mora<b> (Bs)</b></label>
                            </div>

                        <div class="input-field col s12">
                            <div class="divider"></div>
                        </div>

                        @endforeach

                        <div class="col s12 m6 offset-m6">
                            <input type="text" name="total_tasa" id="total_tasa" class="validate total_tasa" value="0"  readonly>
                            <label for="total_tasa">Total Tasa:(Bs)</label>
                        </div>

                        <div class="col s12 m6 offset-m6">
                            <input type="text" name="total_mora" id="total_mora" class="validate total_mora"  value="0" readonly>
                            <label for="total_mora">Total Mora:(Bs)</label>
                        </div>


                        <div class="col s12 m6 offset-m6">
                            <input type="text" name="total" id="total_pagar" class="validate total"  readonly>
                            <label for="total_pagar">Total a Pagar:(Bs)</label>
                        </div>



                        <div class="input-field col s12">
                            <button type="submit" class="btn btn-rounded col s12 blue waves-effect waves-light">Guardar</button>
                        </div>
                    </form>
                    <div class="card-action">
                        <div class="row">
                            <button class="btn btn-rounded blue col s12 m6 waves-light">Editar</button>
                            <button class="btn btn-rounded red col s12 m6 waves-light">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
        <script src="{{ asset('js/dev/taxes.js') }}"></script>
@endsection