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
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="{{ route('taxes.save') }}" method="post" class="card" id="taxes-register">
                    @if(is_null($date))
                        <div class="alert alert-success center-align">
                            <strong>Empresa solvente hasta la fecha.</strong>
                        </div>
                    @elseif(Session::has('message'))
                        <div class="alert alert-success center-align">
                            <strong>{{ session('message') }}</strong>
                        </div>
                    @elseif($date['mount_diff']>=2)
                        <div class="alert alert-warning center-align">
                            <strong>Estimado contribuyente, el plazo para el pago del periodo de {{ $date['mount_pay'] }} expiró, por favor, diríjase a la oficina del SEMAT. </strong>
                        </div>
                    @else

                        <div class="card-header center-align">
                            <h5>Declarar actividad Economica</h5>
                        </div>

                        <div class="card-content row">
                            @csrf
                            <input type="hidden" id="company_id" name="company_id" value="{{ $company->id }}">
                            <div class="input-field col s12">
                                <input type="hidden" name="fiscal_period" id="fiscal_period"
                                       value="{{$date['fiscal_period']}}">
                            </div>

                            <div class="input-field col s12">
                                <input type="text" name="fiscal_period" id="fiscal_period"
                                       value="{{$date['mount_pay']}}" disabled>
                                <label for="fiscal_period">Periodo Fiscal</label>
                            </div>

                            @foreach($company->ciu as $ciu)
                                <input type="hidden" name="ciu_id[]" value="{{ $ciu->id }}">
                                <input type="hidden" name="ciu_alicuota" class="ciu_alicuota"
                                       value="{{ $ciu->alicuota }}">
                                <input type="hidden" name="min_tribu_men[]" class="min_tribu_men"
                                       value="{{ $ciu->min_tribu_men}}">

                                <div class="input-field col s12 m6">
                                    <input type="text" name="code" id="code" value="{{ $ciu->code }}" class="code" required readonly>
                                    <label for="code">Código</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input type="text" name="ciu" id="ciu" value="{{ $ciu->name }}" required readonly>
                                    <label for="ciu">CIU</label>
                                </div>

                                <div class="input-field col s12 m6">
                                    <input type="text"  name="base[]" id="base_{{$ciu->code}}" class="validate money_keyup base" maxlength="18" required>
                                    <label for="base_{{$ciu->code}}">Base Imponible</label>
                                </div>

                                <input type="hidden" id="alicuota_{{$ciu->code}}"   class="alicuota" value="{{ $ciu->alicuota }}">

                                <div class="input-field col s12 m6">
                                    <input type="text"  name="deductions[]" id="deductions_{{$ciu->code}}" class="validate money_keyup"
                                            required>
                                    <label for="deductions_{{$ciu->code}}">Deducciones</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input type="text"  name="withholding[]" id="withholdings_{{$ciu->code}}"
                                           class="validate money_keyup"  required>
                                    <label for="withholdings_{{$ciu->code}}">Retenciones</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input type="text" name="fiscal_credits[]" id="fiscal_credits_{{$ciu->code}}"
                                           class="validate money_keyup"  required>
                                    <label for="fiscal_credits_{{$ciu->code}}">Creditos Fiscales</label>
                                </div>
                                <div class="input-field col s12">
                                    <div class="divider"></div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-action center-align">
                            <button type="submit" class="btn btn-rounded waves-effect waves-light blue">Register
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
        <script src="{{asset('js/dev/taxes.js')}}"></script>
@endsection