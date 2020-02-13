@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Mis Publicidades</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.register.types') }}">Registrar por Tipo Publicidad</a></li>

                </ul>
            </div>
            <div class="col s12 m6 animated bounceIn">
                <a href="{{ route('publicity.register.create',['id' => 1]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Art. 57 (Publicidad eventual u ocacional)</span>
                </a>
            </div>
            <div class="col s12 m6 animated bounceIn">
                <a href="{{ route('publicity.register.create',['id' => 2]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Art. 61, 62, 63, 64, 65, 66</span>
                </a>
            </div>
            <div class="col s12 m6 animated bounceIn">
                <a href="{{ route('publicity.register.create',['id' => 3]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Art. 67, 68, 73</span>
                </a>
            </div>
            <div class="col s12 m6 animated bounceIn">
                <a href="{{ route('publicity.register.create',['id' => 4]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Art. 70, 71, 77, 84, 85</span>
                </a>
            </div>
            <div class="col s12 m6 animated bounceIn">
                <a href="{{ route('publicity.register.create',['id' => 5]) }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Art. 83, 86 (Vallas publicitarias)</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection