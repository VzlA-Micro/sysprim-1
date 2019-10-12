@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mi Empresa</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
                <a href="" class="breadcrumb">Historial de Pagos</a>
            </div>
            <div class="col s12 m10 offset-m1">
                @include('sweet::alert')
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Historial de Pagos</h5>
                    </div>
                    <div class="card-content">
                        <table class="centered highlight table-responsive">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Periodo Fiscal</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taxes as $taxe)
                                <tr>
                                    <td>{{ $taxe->code }}</td>
                                    <td>{{ $taxe->fiscal_period }}</td>
                                    @if($taxe->payments->isEmpty())
                                        <td>SIN CONCILIAR AÚN</td>
                                        <td><a href="{{ route('registerPayments',['id'=>$taxe->id]) }}" class="btn green waves-effect waves-light"><i class="icon-payment left"></i>Pagar</a></td>
                                    @else
                                        @foreach($taxe->payments as $payment)
                                                <td><button class="btn disabled"><i class="icon-more_horiz"></i>{{ $payment->status }}</button></td>
                                            @if($payment->status==='verified')
                                                <td>
                                                    <a href="{{ url('payments/taxes/'.$taxe->id) }}" class="btn orange waves-effect waves-light"><i class="icon-description"></i>Descargar Solvencia</a>
                                                </td>
                                                @else
                                                <td>
                                                    <a href="{{ url('pdf/'.$taxe->id) }}" class="btn indigo waves-effect waves-light"><i class="icon-pageview"></i>Detalles</a>
                                                </td>
                                            @endif
                                        @endforeach
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection