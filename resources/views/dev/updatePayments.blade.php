@extends('layouts.app2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m8 offest-m2 l4 offset-l4">
                <form action="{{route('savePaymentsTaxes')}}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar pago</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                        <input id="type" type="text" name="type" required value="{{$paymentsTaxe->type}}">
                            <label for="type">Tipo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="code_ref" type="text" name="code_ref" required value="{{$paymentsTaxe->code_ref}}">
                            <label for="code_ref">Codigo De Referencia</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="bank" type="text" name="bank" required value="{{$paymentsTaxe->bank}}">
                            <label for="bank">Banco</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="amount" type="text" name="amount" required value="{{$paymentsTaxe->amount}}">
                            <label for="amount">Monto</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="taxes" type="text" name="taxes" required>
                            <label for="taxes">Impuesto</label>
                        </div>
                        
                    </div>
                    <div class="card-action center">
                        <button type="submit" class="btn green">Registrar</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection
