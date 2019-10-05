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
                                    <th>CÓDIGO</th>
                                    <th>PERIODO FISCAL</th>
                                    <th>ESTADO</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taxes as $taxe)
                                <tr>
                                    <td>{{ $taxe->code }}</td>
                                    <td>{{ $taxe->fiscal_period }}</td>
                                    @if($taxe->payments->isEmpty())
                                        <td>SIN CONCILIAR AÚN</td>
                                        <td><a href="{{ route('payments.reconcile') }}" class="btn green waves-effect waves-light"><i class="icon-payment left"></i>Pagar</a></td>
                                    @else

                                    @foreach($taxe->payments as $payment)
                                            <td>{{$payment->status}}</td>
                                        @if($payment->status==='verified')
                                            <td><button><a href="{{ url('payments/taxes/'.$taxe->id) }}">DESCARGAR SOLVENCIA</a></button><button><a href="{{url('pdf/'.$taxe->id) }}">DETALLES</a></button></td>
                                            @else
                                                <td><button><a href="#">PROCESANDO</a></button></td>
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