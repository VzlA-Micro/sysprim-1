@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/receipt.css') }}">
@endsection

@section('content')
    @php setlocale(LC_MONETARY, 'en_US');@endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Pagar Impuestos</h5>
                    </div>
                    <div class="card-content row" style="margin-bottom: 0px">
                        <div class="input-field col s10">
                            <i class="icon-search prefix"></i>
                            <input id="search" type="search" value="{{$taxe->companies->license}}">
                            <label for="search">CODIGO QR</label>
                        </div>
                        <div class="input-field col s2 center-align">
                            <button class="btn btn-floating peach">
                                <i class="icon-search"></i>
                            </button>
                        </div>
                        <div class="input-field col s6">
                            <i class="icon-event_available prefix"></i>
                            <input type="text" name="fiscal_period" id="fiscal_period" value="" disabled>
                            <label for="fiscal_period">Periodo Fiscal</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="icon-event_available prefix"></i>
                            <input type="text" name="fiscal_period" id="fiscal_period" value="" disabled>
                            <label for="fiscal_period">Fecha</label>
                        </div>


                        <div class="input-field col s6">
                            <i class="icon-event_available prefix"></i>
                            <input type="text" name="fiscal_period" id="fiscal_period" value="" disabled>
                            <label for="fiscal_period">Licencia o codigo</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="icon-event_available prefix"></i>
                            <input type="text" name="fiscal_period" id="fiscal_period" value="" disabled>
                            <label for="fiscal_period">NOMBRE</label>
                        </div>


                        <div class="input-field col s6">
                            <i class="icon-event_available prefix"></i>
                            <input type="text" name="fiscal_period" id="fiscal_period" value="" disabled>
                            <label for="fiscal_period">Direccion</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="icon-event_available prefix"></i>
                            <input type="text" name="fiscal_period" id="fiscal_period" value="" disabled>
                            <label for="fiscal_period">Pers.Responsable</label>
                        </div>

                        <div class="divider"></div>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <input type="hidden" id="company_id" name="company_id" value="">
                        <input type="hidden" name="fiscal_period" id="fiscal_period" value="">
                        <input type="hidden" name="ciu_id[]" value="">

                        <table class="centered striped">
                            <tbody>
                            @foreach($ciuTaxes as $ciu)
                                <tr>
                                    <td>Código CIIU</td>
                                    <td>{{$ciu->ciu->code}}</td>
                                </tr>
                                <tr>
                                    <td>Nombre CIIU</td>
                                    <td>{{$ciu->ciu->name}}</td>
                                </tr>

                                <tr>
                                    <td>Base Imponible</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <i class="prefix">
                                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                            </i>
                                            <input type="text" value="{{number_format($ciu->withholding,2)}}" name="base[]" id="" class="validate money_keyup base" maxlength="18" required readonly>
                                            <!-- <label for="">Base Imponible</label> -->
                                        </div>
                                    </td>
                                </tr>



                                <tr>
                                    <td>Base Imponible</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <i class="prefix">
                                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                            </i>
                                            <input type="text" value="{{number_format($ciu->withholding,2)}}" name="base[]" id="" class="validate money_keyup base" maxlength="18" required readonly>
                                            <!-- <label for="">Base Imponible</label> -->
                                        </div>
                                    </td>
                                </tr>



                                <tr>
                                    <td>Base Imponible</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <i class="prefix">
                                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                            </i>
                                            <input type="text" value="{{number_format($ciu->withholding,2)}}" name="base[]" id="" class="validate money_keyup base" maxlength="18" required readonly>
                                            <!-- <label for="">Base Imponible</label> -->
                                        </div>
                                    </td>
                                </tr>


                                <tr>
                                    <td>Base Imponible</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <i class="prefix">
                                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                            </i>
                                            <input type="text" value="{{number_format($ciu->withholding,2)}}" name="base[]" id="" class="validate money_keyup base" maxlength="18" required readonly>
                                            <!-- <label for="">Base Imponible</label> -->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><div class="divider"></div> </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col s12 right-align">
                                <h4><span class="green-text">Total: </span>000000.00 BSS</h4>
                            </div>
                            <div class="col s12 right-align">
                                @if($taxe->status!='verified')
                                    <a href="{{-- {{ route('payments.help',['id'=>$taxes->id]) }} --}}#modal1"  class="btn btn-rounded blue waves-effect waves-light modal-trigger">PAGAR</a>
                                @else
                                    <a href=""  class="btn btn-rounded col s12 blue waves-effect waves-light">GENERAR PLANILLA</a>
                                @endif
                            </div>
                            {{-- Modal structure --}}
                            <div id="modal1" class="modal modal-fixed-footer">
                                <div class="modal-content">
                                    <h4 class="center-align">Pagar</h4>
                                    <form method="POST" action="{{route('taxes.save')}}">
                                        <input type="hidden" name="taxes_id" value="{{$taxe->id}}">
                                        <div class="input-field col s12 m6 ">
                                            <i class="icon-confirmation_number prefix "></i>
                                            <input type="text" name="lot" id="lot" value="" class="validate" required >
                                            <label for="lot">Lote</label>
                                        </div>

                                        <div class="input-field col s12 m6 ">
                                            <i class="icon-confirmation_number prefix "></i>
                                            <input type="text" name="ref" id="ref" value="" class="validate" required >
                                            <label for="ref">Referencia</label>
                                        </div>

                                        <div class="input-field col s12 m6 ">
                                            <i class="icon-touch_app prefix "></i>
                                            <input type="text" name="amount" id="amount" value="" class="validate" required>
                                            <label for="amount">Monto</label>
                                        </div>


                                        <div class="input-field col s12 m6 ">
                                            <i class="icon-monetization_on prefix "></i>
                                            <select>
                                                <option>100%banco</option>
                                                <option>BOD</option>
                                            </select>
                                            <label for="code">Banco</label>
                                        </div>
                                        <div class="input-field col s12 m6 ">
                                            <button type="submit" class="btn blue-45deg-gradient-1">Registrar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection