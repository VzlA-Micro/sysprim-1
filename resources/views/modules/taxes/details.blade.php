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
            <div class="col s12 m10 offset-m1">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Detalles de Pago</h5>
                    </div>
                    <div class="row padding-2 left-align">
                        <div class="col m6">
                            <ul>
                                <li><b>Código: </b>{{ $taxes->code }}</li>
                                <li><b>Periodo Fiscal: </b>{{ $fiscal_period }}</li>
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
                            <input type="text" name="base[]" id="base" class="validate money" value="{{ $ciu->pivot->base }}" disabled>
                            <label for="base">Base Imponible</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="deductions[]" id="deductions" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->pivot->deductions }}" disabled>
                            <label for="deductions">Deducciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="withholding[]" id="withholdings" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->pivot->withholding }}" disabled>
                            <label for="withholdings">Retenciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="fiscal_credits[]" id="fiscal_credits" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->pivot->fiscal_credits }}" disabled>
                            <label for="fiscal_credits">Creditos Fiscales</label>
                        </div>
                            <div class="input-field col s12 m4">
                                @if($ciu->pivot->base!=0)
                                    <input type="text" name="total_ciu[]" id="total_ciu" class="validate total_ciu money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ ($ciu->alicuota*$ciu->pivot->base/100)}}" disabled>
                                @else
                                    <input type="text" name="total_ciu[]" id="total_ciu" class="validate total_ciu money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->pivot->unid_tribu*$ciu->min_tribu_men}}" disabled>
                                @endif
                                    <label for="fiscal_credits">Total a Pagar por CIU<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m4">
                                <input type="text" name="tasa[]" id="tasa" class="validate tasa money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="0" disabled>
                                <label for="tasa">Tasa<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m4">
                                <input type="text" name="mora[]" id="mora" class="validate mora money" pattern="" value="{{ $ciu->pivot->mora }}" disabled>
                                <label for="mora">Mora<b> (Bs)</b></label>
                            </div>

                        <div class="input-field col s12">
                            <div class="divider"></div>
                        </div>

                        @endforeach
                        <div class="col l12">
                            <div class="col l6">

                                    <table class="centered responsive-table" style="font-size: 10px;!important;">
                                        <tr>
                                            <td>CODIGO</td>
                                            <td>NOMBRE</td>
                                            <td>ALICUOTA</td>
                                            <td>MININIMO TRIBUTABLE</td>
                                        </tr>
                                        @php $unid=$ciu->pivot->unid_tribu;@endphp
                                        @foreach($taxes->taxesCiu as $ciu)
                                        <tr>
                                            <td>{{$ciu->code}}</td>
                                            <td>{{$ciu->name}}</td>
                                            <td>{{$ciu->alicuota."%"}}</td>
                                            <td>{{$ciu->min_tribu_men}}</td>
                                        </tr>

                                @endforeach
                                    </table>
                                    <p><b>UNIDAD TRIBUTARIA: {{$extra['unid_tribu']}}</b>Bs</p>
                                    <p><b>TASA: </b>{{$extra['tasa']}}Bs</p>
                                    <p><b>MORA:</b>{{($extra["mora"])}}Bs</p>

                            </div>
                            <div class="col l6">
                                <div class="col s12 m12 ">
                                    <input type="text" name="total_tasa" id="total_tasa" class="validate total_tasa money" value="0"  readonly>
                                    <label for="total_tasa">Total Tasa:(Bs)</label>
                                </div>

                                <div class="col s12 m12 ">
                                    <input type="text" name="total_mora" id="total_mora" class="validate total_mora money"  value="0" readonly>
                                    <label for="total_mora">Total Mora:(Bs)</label>
                                </div>


                                <div class="col s12 m12">
                                    <input type="text" name="total" id="total_pagar" class="validate total money"  readonly>
                                    <label for="total_pagar">Total a Pagar:(Bs)</label>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="card-action">
                        <div class="row">
                            <div class="input-field col s12">
                                <a href="{{ route('payments.help',['id'=>$taxes->id]) }}" class="btn btn-rounded col s12 blue waves-effect waves-light">PAGAR</a>
                            </div>
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