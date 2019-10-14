@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('ciu.manage') }}" class="breadcrumb">Gestionar Grupo CIIU</a>
                <a href="{{ route('ciu-branch.manage') }}" class="breadcrumb">Gestionar Ramo CIIU</a>
                <a href="#!" class="breadcrumb">Ver Ramos CIIU's</a>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <table class="striped centered responsive-table" id="ciu">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Codigo</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($showCiu as $ciu)
                                <tr>
                                    <td>{{ $ciu->name }}</td>
                                    <td>{{ $ciu->code }}</td>
                                    <td>{{ $ciu->value }}</td>
                                    <td>
                                    <a href="{{ route('ciu-branch.details',['id' => $ciu->id]) }}" class="btn btn-small btn-floating orange waves-effect effect-light"><i class="icon-pageview"></i></a>
                                    </td>
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