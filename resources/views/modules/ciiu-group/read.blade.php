@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('ciu.manage') }}" class="breadcrumb">Gestionar CIIU</a>
                <a href="#!" class="breadcrumb">Ver Grupos CIIU</a>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
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
                                    <td>{{ $groupCiiu->name }}</td>
                                    <td>{{ $groupCiiu->code }}</td>
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