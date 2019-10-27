@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('tax-unit.manage') }}" class="breadcrumb">Gestionar Unidad Tributaria</a>
                <a href="{{ route('tax-unit.register') }}" class="breadcrumb">Ver</a>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <table class="striped centered responsive-table" id="finesCompany">
                            <thead>
                                <tr>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($showTributo as $tributo)
                                <tr>
                                    <td>{{ $tributo->since }}</td>
                                    <td>{{ $tributo->to }}</td>
                                    <td>{{ $tributo->value }}</td>
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
@section('scripts')
    
@endsection