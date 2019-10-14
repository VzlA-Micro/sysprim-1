@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row card">
        
        <div class="col s12">
            <table class="striped centered responsive-table" id="finesCompany">
                <thead>
                    <tr>
                        <th>Minimo</th>
                        <th>Maximo</th>
                        <th>Rebaja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($showEmployees as $employees)
                    <tr>
                        <td>{{$employees->min}}</td>
                        <td>{{$employees->max}}</td>
                        <td>{{$employees->value}} %</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
