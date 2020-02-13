@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    @if(session()->has('company'))
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.details', ['id' => session('company')->id]) }}">{{ session('company')->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Mis Publicidades</a></li>
                </ul>
            </div>
            @foreach($publicities as $index => $publicity)
                @if($userPublicity[$index]->user_id == \Auth::user()->id && $userPublicity[$index]->person_id != null)
                    <div class="col s12 m4 animated bounceIn">
                        <a href="{{ route('publicity.details', ['id' => $publicity->id]) }}" class="btn-app white purple-text">
                            <i class="icon-work"></i>
                            <span class="truncate">{{ $publicity->name }}</span>
                            <span><b>Persona Natural</b></span>
                        </a>
                    </div>
                @elseif($userPublicity[$index]->person_id == null)
                    <div class="col s12 m4 animated bounceIn">
                        <a href="{{ route('publicity.details', ['id' => $publicity->id]) }}" class="btn-app white purple-text">
                            <i class="icon-work"></i>
                            <span class="truncate">{{ $publicity->name }}</span>
                            <span><b>Juridico</b></span>
                        </a>
                    </div>
                @endif
            @endforeach
            <div class="col s12 m4 animated bounceIn">
                @if(session()->has('company'))
                <a href="{{ route('publicity.register.types', ['company_id' => session('company')->id]) }}" class="btn-app white orange-text">
                @else
                <a href="{{ route('publicity.register.types') }}" class="btn-app white orange-text">
                @endif
                    <i class="icon-add_circle"></i><br>
                    <span class="truncate">Agregar nueva publicidad...</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection