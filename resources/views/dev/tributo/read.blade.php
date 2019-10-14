@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row card">
        
        <div class="col s12">
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
                        <td>{{$tributo->since}}</td>
                        <td>{{$tributo->to}}</td>
                        <td>{{$tributo->value}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
