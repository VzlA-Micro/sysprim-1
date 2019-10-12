@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row card">
        
        <div class="col s12">
            <table class="striped centered responsive-table" id="fines">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad de unidad tributaria</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach($showFines as $fines)
                    <tr>
                        <td>{{$fines->name}}</td>
                        <td>{{$fines->cant_unid_tribu}}</td>
                        <td>
                            <a href="{{url('/details-fines/'.$fines->id)}} " class="btn btn-small btn-floating pink waves-effect effect-light"><i class="icon-pageview"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
