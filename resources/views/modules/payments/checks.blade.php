@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.manage') }}">Gestionar Pagos</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticket-office.type.payments') }}">Ver Pagos</a></li>
                    <li class="breadcrumb-item"><a href="#!">Tranferiacias</a></li>
                    <li class="breadcrumb-item"><a href="#!">Detalles</a></li>
                </ul>
            </div>
                <div class="col s12 m10 offset-m1">
                    <form action="" method="post" class="card" id="register">
                        <div class="card-header center-align">
                            <h5>Detalles de empresa.</h5>
                        </div>
                        <div class="card-content row">
                        <div class="input-field col s4 m3">

                            <input type="hidden" value="{{$payments->taxes[0]->id}}" id="taxes_id">
                            <i class="icon-perm_contact_calendar prefix tooltipped" data-position="bottom" data-tooltip="J = Juridico<br>G = Gubernamental<br>V = Venezolano<br>E = Extrangero"></i>
                            <select name="document_type" id="document_type" disabled>

                                <option value="null" selected disabled>...</option>
                                <option value="J" @if ($payments->taxes[0]->companies[0]->typeDocument=='J'){{"selected"}}@endif>J</option>
                                <option value="V" @if ($payments->taxes[0]->companies[0]->typeDocument=='V'){{"selected"}}@endif>V</option>
                                <option value="G" @if ($payments->taxes[0]->companies[0]->typeDocument=='G'){{"selected"}}@endif>G</option>
                                <option value="E" @if ($payments->taxes[0]->companies[0]->typeDocument=='E'){{"selected"}}@endif>E</option>
                            </select>
                            <label for="document_type">Documento</label>
                        </div>
                        <div class="input-field col s8 m3 tooltipped" data-position="bottom" data-tooltip="EL RIF solo debe contener número sin - ni caracteres extraños. Ej: 1234567890">
                            <input type="text" name="RIF" id="RIF" value="{{$payments->taxes[0]->companies[0]->document}}" class="validate number-only" pattern="[0-9]+" maxlength="10" minlength="6" title="Solo puede escribir números." required readonly>
                            <label for="RIF">RIF</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Razón social o nombre de la empresa.">
                            <i class="icon-work prefix"></i>
                            <input type="text" name="name" id="name" class="validate"  pattern="[0-9A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ .,!?_-&%+-$]+" title="Solo puede usar letras (con acentos), números y los caracteres especiales: . , $ ! ? % + -" value="{{$payments->taxes[0]->companies[0]->name }}" required readonly>
                            <label for="name">Razón Social</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede usar números y letras en mayúsculas. Ej: A1B2C3">
                            <i class="icon-chrome_reader_mode prefix"></i>
                            <input type="text" name="license" id="license" class="validate" pattern="[0-9A-Z]+" title="Solo puede usar números y letras en mayúsculas." value="{{  $payments->taxes[0]->companies[0]->license}}" required readonly>
                            <label for="license">Licencia</label>
                        </div>

                            <div class="input-field col s6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="fiscal_period_view" id="fiscal_period_view"
                                       value="{{\App\Helpers\TaxesMonth::convertFiscalPeriod($payments->taxes[0]->fiscal_period)}}" readonly>
                                <label for="fiscal_period">Periodo Fiscal</label>
                            </div>

                            <div class="card-header center-align">
                                <h5>Detalles de pago</h5>
                            </div>

                            <div class="input-field col s6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="fiscal_period_view" id="fiscal_period_view"
                                       value="{{\App\Helpers\TaxesMonth::convertFiscalPeriod($payments->taxes[0]->fiscal_period)}}" readonly>
                                <label for="fiscal_period">Periodo Fiscal</label>
                            </div>


                            <div class="input-field col s6">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="code" id="code"
                                       value="{{$payments->taxes[0]->code}}" readonly>
                                <label for="fiscal_period">Codigo</label>
                            </div>



                            <input type="hidden" name="taxes_id" id="taxes_id_tr" value="">
                            <div class="input-field col m6 s12">
                                <i class="icon-satellite prefix"></i>
                                <input type="text" name="bank" id="bank" value="{{$payments->bankName}}" class="validate" required>
                                <label>Banco</label>
                            </div>

                            <input type="text" name="payments_type" id="payments_type"
                                   value="TRANSFERENCIA" class="validate hide" required>
                            <div class="input-field col s12 m6 ">
                                <i class="icon-confirmation_number prefix "></i>
                                <input type="text" name="nro" id="nro" value="{{$payments->ref}}" class="validate"
                                       required minlength="10" maxlength="10">
                                <label for="nro">Número de Cheque</label>
                            </div>


                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}"
                                         style="width: 2rem"
                                         alt="">
                                </i>
                                <input type="text" name="amount_total" id="amount_total" value="{{number_format($payments->amount,2,',','.')}}"
                                       class="validate money"
                                       required>
                                <label for="amount_total" >Monto</label>
                            </div>



                            @if($payments->taxes[0]->status==='process')
                                <div class="input-field col s12 center-align">
                                    <button class="btn green col s12">
                                        <i class="icon-more_horiz left "></i>
                                        ESTADO: SIN CONCILIAR AÚN
                                    </button>
                                </div>
                            @elseif($payments->taxes[0]->status==='verified')
                                <div class="input-field col s12 center-align">
                                    <button class="btn blue  col s12">
                                        <i class="icon-more_horiz left"></i>
                                        ESTADO: VERIFICADA.
                                    </button>

                                </div>
                            @elseif($payments->taxes[0]->status==='cancel')
                                <div class="input-field col s12 center-align">
                                    <button class="btn red s6 ">
                                        <i class="icon-more_horiz left"></i>
                                        ESTADO: CANCELADA.
                                    </button>
                                </div>
                            @endif

                                <div class="input-field col s12">
                                    @if($payments->taxes[0]->status=='process')
                                        @can('Anular Pagos')
                                        <a href="#"  class="btn btn-rounded col s4 red waves-effect waves-ligt reconcile" data-status="cancel">
                                            ANULAR PAGO.
                                            <i class="icon-close right"></i></a>
                                        @endcan
                                        @can('Verificar Pagos - Manual')
                                        <a href="#"  class="btn btn-rounded col s4 blue waves-effect waves-light reconcile" data-status="verified">
                                            VERIFICAR PAGO.
                                            <i class="icon-verified_user right"></i></a>
                                        @endcan
                                    @endif
                                    @can('Detalles Planilla')
                                    <a href="{{url('payments/taxes/'.$payments->taxes[0]->id)}}"  class="btn btn-rounded col s4 blue waves-effect waves-light">

                                        Detalles de planilla.
                                        <i class="icon-details right"></i>
                                    </a>
                                    @endcan

                                </div>
                        </div>
                        <div class="card-footer center">


                        </div>
                    </form>
                </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/payments.js')}}"></script>
@endsection