@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('notifications.read') }}">Notificaciones</a></li>
                    <li class="breadcrumb-item"><a href="">Detalles</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Notificacion</h5>
                    </div>
                    <div class="card-content">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Iure nostrum beatae blanditiis vitae tempora corporis veniam natus similique officia ut!
                    </div>
                    <div class="card-footer">
                        Date: 11-11-1111
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection