@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('payments.manage') }}" class="breadcrumb">Gestionar Pagos</a>
                <a href="#!" class="breadcrumb">Ver Pagos</a>
            </div>
            <div class="col s12 m10 offset-m1">
                <div class="card">
                    <div class="card-content">
                        <table class="centered highlight responsive-table">
                            <thead>
                                <tr>
                                    <th>Contribuyente</th>
                                    <th>Forma de Pago</th>
                                    <th>Banco</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>N°. Referencia</th>
                                    {{-- <th>Detalles</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Jhon Doe</td>
                                    <td>Transferencia</td>
                                    <td>Venezuela</td>
                                    <td>22/06/2019</td>
                                    <td>5000BS</td>
                                    <td>12353646246</td>
                                    {{-- <td>
                                        <a href="" class="btn btn-floating orange waves-effect waves-light"><i class="icon-pageview"></i></a>
                                    </td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection