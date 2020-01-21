@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{route('rate.taxpayers.menu')}}">Mis Tasas</a></li>
            </ul>
        </div>
        <div class="col s12 m8 l8 offset-m2 offset-l2">
            <form action="#" method="post" class="card" id="#">
                <ul class="tabs">
                    <li class="tab col s12" id="one"><a href="#rate-tab"><i class="icon-filter_1"></i>Datos Generales</a></li>
                </ul>
                <div id="rate-tab">
                    <div class="card-header center-align">
                        <h4>Tasas a Generar</h4>
                    </div>

                    <div class="col l12">
                        <input type="hidden" name="id" value="{{$company->id}}" id="id">
                        <input type="hidden" name="type" value="company" id="type">


                        @foreach($rates as $rate)
                            <div class="input-field col s3 m3">
                                <p>
                                    <label>
                                        <input type="checkbox" class="rate"  value="{{$rate->id}}"/>
                                        <span>{{$rate->name}}</span>
                                    </label>
                                </p>
                            </div>

                        @endforeach

                    </div>


                    <div class="card-content row">
                        <div class="input-field col s12 right-align">
                            <a href="#" class="btn peach waves-effect waves light" id="register-rates">
                                Siguiente
                                <i class="icon-navigate_next right"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/data/rate.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection