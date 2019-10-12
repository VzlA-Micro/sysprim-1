@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row card">
        
        <div class="col s12">
            <table class="striped centered responsive-table" id="finesCompany">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>RIF</th>
                        <th>Direccion</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($company as $Company)
                    <tr>
                        <td>{{$Company->name}}</td>
                        <td>{{$Company->RIF}}</td>
                        <td>{{$Company->address}}</td>
                        <td>
                            <a href="{{url('/details-finesCompany/'.$Company->id)}} " class="btn btn-small btn-floating pink waves-effect effect-light">MULTAR</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
