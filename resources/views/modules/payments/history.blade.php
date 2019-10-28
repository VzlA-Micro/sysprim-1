@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mis Empresas</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
                <a href="" class="breadcrumb">Historial de Pagos</a>
            </div>
            <div class="col s12 m10 offset-m1">
                @if(Session::has('message'))
                    <div class="alert alert-warning center-align">
                        <strong>{{ session('message') }}</strong>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Historial de Pagos</h5>
                    </div>
                    <div class="card-content">
                        {{-- Realizar verificacion --}}
                        @if ($taxes === null)
                            <h5 class="center-align">No hay registros para mostrar.</h5>
                        @else
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

                                    <td>{{ \App\Helpers\TaxesMonth::convertFiscalPeriod($taxe->fiscal_period)}}</td>
                                    @if($taxe->status==='process')
                                        <td>SIN CONCILIAR AÚN</td>
                                        <td><a href="{{url('pdf/'.$taxe->id)}}" class="btn orange waves-effect waves-light"><i class="icon-description left"></i>Descargar planilla.</a></td>
                                    @else
                                            <td>
                                                <button class="btn disabled">
                                                    <i class="icon-more_horiz left"></i>
                                                    {{ $taxe->status }}
                                                </button>
                                            </td>
                                            @if($taxe->status==='verified')
                                                <td>
                                                    <a href="{{url('pdf/'.$taxe->id)}}" class="btn orange waves-effect waves-light"><i class="icon-description left"></i>Descargar planilla.</a>
                                                </td>
                                            @else
                                                <td>
                                                    <a href="{{url('payments/taxes/'.$taxe->id)  }}" class="btn indigo waves-effect waves-light"><i class="icon-pageview left"></i>Detalles</a>
                                                </td>
                                            @endif
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection