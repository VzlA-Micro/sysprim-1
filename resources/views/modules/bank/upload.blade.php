@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquilla</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.verify.manage') }}">Verificación de Pagos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bank.upload') }}">Cargar Pagos</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="{{ route('bank.verify') }}" id="verifyPaymentsBank" method="post" class="card" enctype="multipart/form-data">
                    <div class="card-header center-align">
                        <h5>Cargar Archivo de Banco</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="file-field input-field">
                            <div class="btn blue waves-light">
                              <span>Seleccionar Archivo</span>
                              <input type="file" name="file" id="file">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text" placeholder="Buscar archivo..." required>
                            </div>
                        </div>
                        <div class="input-field col s12 m12">
                            <i class="icon-date_range  prefix"></i>
                            <input type="text" name="date_limit" class="datepicker" id="date_limit" required>
                            <label for="date_limit">Fecha de los pagos</label>
                        </div>


                    </div>
                    <div class="card-action center">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-light">Cargar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        $('#verifyPaymentsBank').submit(function () {
            $("#preloader").fadeIn('fast');
            $("#preloader-overlay").fadeIn('fast');
        });
    </script>
@endsection