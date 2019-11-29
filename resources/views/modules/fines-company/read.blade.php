@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fines.manage') }}">Gestionar Multas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fines-company.manage') }}">Multas y Empresas</a></li>
                    <li class="breadcrumb-item"><a href="#!">Ver Multas</a></li>
                </ul>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Multas y Empresas</h5>
                    </div>
                    <div class="card-content">
                        <table class="centered highlight responsive-table">
                            <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>RIF</th>
                                    <th>Dirección</th>
                                    {{-- <th>Multar</th> --}}
                                    <th>Ver Multas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($company as $Company)
                                <tr>
                                    <td>{{$Company[0]->name}}</td>
                                    <td>{{$Company[0]->RIF}}</td>
                                    <td>{{$Company[0]->address}}</td>
                                    <td>
                                        <a href="{{ route('fines-company.details', ['id' => $Company[0]->fineCompany[0]->id]) }}" class="btn btn-small waves-effect waves-light orange"><i class="icon-report"></i></a>
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