@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row card">
        
        <div class="col s12">
            <table class="striped centered responsive-table" id="ciu">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Alicuota</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($showCiu as $ciu)
                    <tr>
                        <td>{{$ciu->name}}</td>
                        <td>{{$ciu->code}}</td>
                        <td>{{$ciu->alicuotas}}</td>
                        <td>
                            <a href="{{url('/details-ciu/'.$ciu->id)}} " class="btn btn-small btn-floating pink waves-effect effect-light"><i class="icon-pageview"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
