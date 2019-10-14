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
                        <td>{{$Company[0]->name}}</td>
                        <td>{{$Company[0]->RIF}}</td>
                        <td>{{$Company[0]->address}}</td>
                        <td>
                            <a href="{{url('/details-finesCompany/'.$Company[0]->fineCompany[0]->id)}} " class="btn btn-small btn-floating pink waves-effect effect-light"></a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
