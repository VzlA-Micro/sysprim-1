@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="#" class="preview-view">Formas de Pago</a></li>
                    <li class="breadcrumb-item"><a href="{{route('rate.taxpayers.register')}}">Datos de pago de BDV</a></li>
                    {{--<li class="breadcrumb-item"><a href="{{route('rate.taxpayers.details',['id'=>$taxes_id])}}">Detalles de Autoliquidación</a></li>--}}
                </ul>
            </div>
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <div class="message message-danger hide">
                    <div class="message-body">
                        <strong id="message"></strong>
                    </div>
                </div>

                <form action="#" method="post"  class="card " id="register">

                        <div class="card-title center-align padding-1">
                            <h4> Datos de Pago(BDV)</h4>
                        </div>
                        <div class="card-content row">
                            <input type="hidden" id="id" name="id" value="{{$id}}">

                            <div class="input-field col s12 m4 tooltipped" data-position="bottom"
                                 data-tooltip="V: Venezolano; E: Extranjero">
                                <i class="icon-public prefix"></i>
                                <select name="type_document" id="type_document" required>
                                    <option value="null" selected disabled>...</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                </select>
                                <label for="type_document">Nacionalidad</label>
                            </div>


                            <div class="input-field col s12 m8 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <i class="icon-payment prefix"></i>
                                <input id="document" type="text" name="document" data-validate="documento" maxlength="8"
                                       class="validate number-only rate" pattern="[0-9]+"
                                       title="Solo puede escribir números." required>
                                <label for="document">Cedula Afiliada a BDV</label>
                            </div>



                            <div class="input-field col s12 m12 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <i class="icon-mail_outline prefix"></i>
                                <input id="email" type="email" name="email" data-validate="email" maxlength="100"
                                       class="validate"
                                       title="Solo puede escribir números." required>
                                <label for="email">Email</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="icon-phone prefix tooltipped" data-position="S" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet<br>251: Local"></i>
                                <select name="country_code" id="country_code" required>
                                    <option value="null" selected disabled>...</option>
                                    <option value="0412" >(412)</option>
                                    <option value="0414" >(414)</option>
                                    <option value="0416" >(416)</option>
                                    <option value="0424" >(424)</option>
                                    <option value="0426" >(426)</option>
                                </select>
                                <label for="country_code">Operadora</label>
                            </div>
                            <div class="input-field col s6 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                                <label for="phone">Teléfono Afiliado a BDV</label>
                                <input id="phone" type="tel" name="phone" value="" class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required>
                            </div>



                            <div class="input-field col s12 m12">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                                </i>
                                <input type="text" name="amount" id="amount" class="validate total_ciu money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{$amount}}" readonly>
                                <label for="amount">Monto a Pagar<b> (Bs)</b></label>
                            </div>




                            <div class="input-field col s6 left-align">
                                <a href="#"  class="btn peach waves-effect waves light preview-view ">
                                    Anterior
                                    <i class="icon-navigate_before left"></i>
                                </a>
                            </div>
                            <div class="input-field col s6 right-align">
                                <button type="submit" class="btn peach waves-effect waves light" id="data-next">
                                    Siguiente
                                    <i class="icon-navigate_next right"></i>
                                </button>
                            </div>



                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/data/bdv.js') }}"></script>
@endsection