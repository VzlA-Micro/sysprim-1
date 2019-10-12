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

                    </tr>
                </thead>
                <tbody>
                    @foreach($showGroupCiiu as $groupCiiu)
                    <tr>
                        <td>{{$groupCiiu->name}}</td>
                        <td>{{$groupCiiu->code}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
