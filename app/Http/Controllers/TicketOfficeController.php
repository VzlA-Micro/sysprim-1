<?php

namespace App\Http\Controllers;

use App\FindCompany;
use App\Helpers\Calculate;
use App\Payment;
use App\Taxe;
use Illuminate\Http\Request;
use App\CiuTaxes;
use App\Parish;
use App\Company;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Helpers\TaxesNumber;
use App\Tributo;
use App\Helpers\TaxesMonth;
use App\Ciu;
use App\Extras;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\FineCompany;
use App\Recharge;
use App\BankRate;


class TicketOfficeController extends Controller{



    public function QrTaxes($id){
        try {
            $id=Crypt::decrypt($id);

            $taxe=Taxe::with('companies')->where('id',$id)->get();

            if($taxe[0]->status==='verified'){
                return response()->json(['status'=>'verified','taxe'=>null,'calculate'=>null,'ciu'=>null]);
            }elseif($taxe[0]->status==='cancel') {
                return response()->json(['status'=>'cancel','taxe'=>null,'calculate'=>null,'ciu'=>null]);
            }elseif($taxe[0]->created_at->format('d-m-Y')!==Carbon::now()->format('d-m-Y')){
                $taxe_find=Taxe::find($taxe[0]->id);
                $taxe_find->status='cancel';
                $taxe_find->update();
                return response()->json(['status'=>'old','taxe'=>null,'calculate'=>null,'ciu'=>null]);

            }else{
                $calculateTaxes=Calculate::calculateTaxes($id);
                $ciuTaxes=CiuTaxes::with('ciu')->where('taxe_id',$id)->get();
                return response()->json(['status'=>'process','taxe'=>$taxe,'calculate'=>$calculateTaxes,'ciu'=>$ciuTaxes]);
            }

        } catch (DecryptException $e) {
            $taxe=Taxe::with('companies')->where('code',$id)->get();


            if(!$taxe->isEmpty()){
                if($taxe[0]->status==='verified'){
                    return response()->json(['status'=>'verified','taxe'=>null,'calculate'=>null,'ciu'=>null]);
                }elseif($taxe[0]->status==='cancel') {
                    return response()->json(['status'=>'cancel','taxe'=>null,'calculate'=>null,'ciu'=>null]);
                }elseif($taxe[0]->created_at->format('d-m-Y')!==Carbon::now()->format('d-m-Y')){
                    $taxe_find=Taxe::find($taxe[0]->id);
                    $taxe_find->status='cancel';
                    $taxe_find->update();
                    return response()->json(['status'=>'old','taxe'=>null,'calculate'=>null,'ciu'=>null]);

                }else{
                    return response()->json(['status'=>'process','taxe'=>$taxe,'calculate'=>'null']);
                }
            }else{
                return response()->json(['status' => 'error', 'taxe' => null, 'calculate' => null, 'ciu' => null]);
            }
        }
    }

    public function cashier(){
        $unid_tribu = Tributo::orderBy('id', 'desc')->take(1)->get();
        return view('modules.ticket-office.create',['unid_tribu'=>$unid_tribu]);
    }

    public function findUser($ci){
            $user=User::where('ci', $ci)->get();
            if(!$user->isEmpty()){
                $response=array('status'=>'success',['user'=>$user[0]]);
            }else{
                $response=array('status'=>'error','message'=>'No Encontrada.');
            }
            return response()->json($response);
    }






    public function paymentTaxes(Request $request){
        $id_taxes=$request->input('taxes_id');
        $lot=$request->input('lot');
        $amount=$request->input('amount_total');
        $ref=$request->input('ref');
        $bank=$request->input('bank');
        $bank_destinations=$request->input('bank_destinations');
        $person=$request->input('person');
        $country_code = $request->input('country_code');
        $phone=$request->input('phone');
        $payments_type=$request->input('payments_type');
        $taxes_data = substr($id_taxes, 0, -1);
        $taxes_explode=explode('-',$taxes_data);

        $amount_total=0;
        $acum=0;

        $amountPayment=0;
        $amount_depo=$amount;

        $amount_format=str_replace('.','',$amount);
        $amount=str_replace(',','.',$amount_format);

        $payments=new Payment();

        if($payments_type==='PPT'){
            $payments->type_payment='TRANSFERENCIA BANCARIA';
        }else if($payments_type=='PPC'){
            $payments->type_payment='DEPOSITO BANCARIO/CHEQUE';
            //$amount=round($amount_depo,0);
        }else if($payments_type=='PPE'){
            $payments->type_payment='DEPOSITO BANCARIO/EFECTIVO';
        }else{
            $payments->type_payment='PUNTO DE VENTA';
            $payments->status='verified';
        }

        $payments->lot=$lot;
        $payments_number=TaxesNumber::generateNumberPayment($payments_type . "81");
        $payments->code=$payments_number;

        if($bank!=null){
            $code = substr($payments_number, 3, 12);
            $payments->digit=TaxesNumber::generateNumberSecret($amount,Carbon::now()->format('Y-m-d'),$bank,$code);
        }

        $payments->amount=$amount;
        $payments->ref=$ref;
        $payments->bank=$bank;


        $payments->name=$person;
        $payments->phone=$country_code.$phone;
        $payments->save();
        $payment_id=$payments->id;



        for($i=0;$i<count($taxes_explode);$i++){
            $taxe=Taxe::findOrFail($taxes_explode[$i]);
            $amount_total+=$taxe->amount;
            $taxe_id=$taxes_explode[$i];
            $taxe->payments()->attach(['taxe_id'=>$taxe_id],['payment_id'=>$payment_id]);
        }


        $paymentsTaxe= $taxe->payments()->get();
        $unid_tribu = Tributo::orderBy('id', 'desc')->take(1)->get();

        foreach ($paymentsTaxe as $payment){

                if($payments->amount!=='cancel'){
                    $acum=$acum+$payment->amount;
                }
        }


        $band= bccomp($acum, $amount_total, 2);




        if($band===0){

                $data=['status'=>'success','payment'=>0];
                for($i=0;$i<count($taxes_explode);$i++){
                    $taxes_find=Taxe::findOrFail($taxes_explode[$i]);
                    if($bank_destinations!==null){
                        $taxes_find->bank=$bank_destinations;
                        $taxes_find->status='process';
                    }else if($payments_type=='PPB'||$payments_type=='PPE'||$payments_type=='PPC'){
                        $code = substr($taxes_find->code, 3, 12);
                        $taxes_find->code="PPB".$code;
                        $taxes_find->status='process';
                        $taxes_find->bank=$bank;

                    }else{
                        $code = substr($taxes_find->code, 3, 12);
                        $taxes_find->digit=TaxesNumber::generateNumberSecret($taxes_find->amount,$taxes_find->created_at->format('Y-m-d'),$bank,$code);
                        $taxes_find->status='verified';
                        $taxes_find->bank=$bank;
                    }
                    $taxes_find->update();
                }


        }else{
                $amountPayment=$amount_total-$acum;
                $data=['status'=>'process','payment'=>number_format($amountPayment,2)];
        }

        return response()->json($data);
    }


    //comapanies
    public function registerCompany(){
        $parish=Parish::all();
        return view('modules.ticket-office.companies.register',['parish'=>$parish]);
    }


    public function storeCompany(Request $request){
        $ciu = $request->input('ciu');
        $nameCompany = $request->input('name_company');
        $license = $request->input('license');
        $parish = $request->input('parish');
        $openingDate = $request->input('opening_date');
        $rif = $request->input('document_type').$request->input('RIF');
        $address = $request->input('address');
        $code_catastral = $request->input('code_catastral');
        $numberEmployees=$request->input('number_employees');
        $sector=$request->input('sector');
        $phone=$request->input('phone_company');
        $country_code= $request->input('country_code_company');
        $lat=$request->input('lat');
        $lng=$request->input('lng');


        $validate = $this->validate($request, [
            'name_company' => 'required',
            'license' => 'required',
            'RIF' => 'required|min:8',
            'address' => 'required',
            'opening_date' => 'required',
            'parish' => 'required|integer',
            'code_catastral' => 'required',
            'sector' => 'required',
            'number_employees' => 'required',
        ]);

        $company = new Company();
        $company->name = strtoupper($nameCompany);
        $company->address = strtoupper($address);
        $company->rif = $rif;
        $company->license = strtoupper($license);
        $company->lat = $lat;
        $company->lng = $lng;
        $company->code_catastral = strtoupper($code_catastral);
        $company->parish_id = $parish;
        $company->opening_date = $openingDate;
        $company->sector = $sector;
        $company->number_employees = $numberEmployees;
        $company->phone =  $country_code.$phone;
        $company->created_at='2019-09-14';
        $company->save();

        $id_company = DB::getPdo()->lastInsertId();

        $id_user =$request->input('user_id');

        $company->users()->attach(['company_id' => $id_company], ['user_id' => $id_user]);
        foreach ($ciu as $ciu) {
            $company->ciu()->attach(['company_id' => $id_company], ['ciu_id' => $ciu]);
        }

    }


    public function allCompanies(){
       $companies=Company::all();
        return view('modules.ticket-office.companies.read',['companies'=>$companies]);
    }



    public function detailsCompany($id){
        $company=Company::find($id);
        $parish=Parish::all();
        return view('modules.ticket-office.companies.details',['company'=>$company,'parish'=>$parish]);
    }

    //find-license

    public function findCode($code){
        $company = Company::where('license',$code)->orWhere('RIF',$code)->with('ciu')->with('users')->get();


        if($company->isEmpty()){
            $response=array('status'=>'error','message'=>'La Licencia '.$code. 'no esta registrar, debe registrar una empresa.');
        }else{


            if($company[0]->status!='disabled'){
                $response=array('status'=>'success','company'=>$company);

            }else{
                $response=array('status'=>'error','message'=>'La empresa '.$company[0]->name. ' esta bloqueada temporalmente,para poder generar una planilla ,debes desbloquearla.');
            }

        }


        return response()->json($response);
    }




    public function getTaxes(){
        $taxes=Audit::where('user_id',\Auth::user()->id)
            ->where('event','created')
            ->where('auditable_type','App\Taxe')
            ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();

        if(!$taxes->isEmpty()){
            foreach ($taxes as $taxe){
                $id_taxes[]=$taxe->auditable_id;
            }
            if(count($id_taxes)!==0){
                $taxes=Taxe::where('status','=','ticket-office')->whereIn('id',$id_taxes)->get();
            }else{
                $amount_taxes=null;
                $taxes=null;
            }
        }else{
            $amount_taxes=null;
            $taxes=null;
        }


        return view('modules.ticket-office.taxes.taxes-tickoffice',['taxes'=>$taxes]);
    }

    public function registerTaxes(Request $request)
    {

        $datos = $request->all();

        $fiscal_period = $datos['fiscal_period'];
        $company = $datos['company_id'];
        $company_find = Company::find($company);

        $ciu_id = $datos['ciu_id'];
        $deductions = $datos['deductions'];

        $withholding = $datos['withholding'];
        $base = $datos['base'];
        $fiscal_credits = $datos['fiscal_credits'];

        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('PTS81');


        $taxe->fiscal_period = $fiscal_period;
        $taxe->branch = 'Act.Eco';
        $taxe->bank = '';
        $taxe->type = 'actuated';

        $taxe->status = 'ticket-office';
        $taxe->save();
        $id = $taxe->id;


        $fiscal_period_format = Carbon::parse($fiscal_period);
        $tributo = Tributo::whereDate('to', '>=', $fiscal_period_format)->whereDate('since', '<=', $fiscal_period_format)->first();

        if($tributo->isEmpty()){

        }


        $taxes_amount = 0;
        $date = TaxesMonth::calculateDayMora($fiscal_period, $company_find->typeCompany);

        //format a deductions
        $deductions_format = str_replace('.', '', $deductions);
        $deductions_format = str_replace(',', '.', $deductions_format);

        //format withdolding
        $withholding_format = str_replace('.', '', $withholding);
        $withholding_format = str_replace(',', '.', $withholding_format);

        //format fiscal credits
        $fiscal_credits_format = str_replace('.', '', $fiscal_credits);
        $fiscal_credits_format = str_replace(',', '.', $fiscal_credits_format);


        $base_format_verify = 0;
        $total_base = 0;


        for ($i = 0; $i < count($base); $i++) {

            //damos formato a la base
            $base_format_verify = str_replace('.', '', $base[$i]);
            $base_format_verify = str_replace(',', '.', $base_format_verify);

            $ciu = Ciu::find($ciu_id[$i]);

            //Calculo de minimo  a tributar
            $min_amount = $ciu->min_tribu_men * $tributo->value;

            //Calculo de base imponible
            $base_amount_sub = $ciu->alicuota * $base_format_verify;


            if ($min_amount > $base_amount_sub) {
                $total_base = $total_base + $min_amount;
            } else {
                $total_base = $total_base + $base_amount_sub;
            }


        }
        if ($company_find->typeCompany == 'R') {
            $total_base = $total_base + $withholding_format - $fiscal_credits_format - $deductions_format;
        } else {
            $total_base = $total_base - $withholding_format - $fiscal_credits_format - $deductions_format;
        }


        if ($total_base < 0) {
            return response()->json(['status'=>'error','message' => 'La deducciones o creditos fiscal no pueder ser mayor que el impuesto causado.']);
        }







        for ($i = 0; $i < count($base); $i++) {

            //damos formato a la base
            $base_format = str_replace('.', '', $base[$i]);
            $base_format = str_replace(',', '.', $base_format);
            $ciu = Ciu::find($ciu_id[$i]);


            //Calculo de minimo  a tributar
            $min_amount = $ciu->min_tribu_men * $tributo->value;

            //Calculo de base imponible
            $base_amount_sub = $ciu->alicuota * $base_format;

            //si lo que va a pagar es mayor que el min a tributar
            if ($base_amount_sub > $min_amount) {

                $min_amount = 0;
            } else {//si no paga minimo

                $base_amount_sub = $min_amount;
            }

            if ($date['mora']) {//si tiene mora
                //Obtengo recargo
                $recharge = Recharge::where('branch', 'Act.Eco')->whereDate('to', '>=', $fiscal_period_format)->whereDate('since', '<=', $fiscal_period_format)->first();

                //Obtengo Intereset del banco
                $interest_bank = BankRate::orderBy('id', 'desc')->take(1)->first();

                $amount_recharge = $base_amount_sub * $recharge->value / 100;
                $interest = (($interest_bank->value_rate / 100) / 360) * $date['diffDayMora'] * ($amount_recharge + $base_amount_sub);


            } else {
                $amount_recharge = 0;
                $interest = 0;
            }

            $taxe->taxesCiu()->attach(['taxe_id' => $id],
                ['ciu_id' => $ciu_id[$i],
                    'base' => $base_format,
                    'recharge' => $amount_recharge,
                    'tax_unit' => $tributo->value,
                    'interest' => $interest,
                    'taxable_minimum' => $min_amount
                ]);
        }


            $day_mora=$date['diffDayMora'];
            $taxe->companies()->attach(['taxe_id'=>$id],['company_id'=>$company_find->id,
                'fiscal_credits'=>$fiscal_credits_format,
                'withholding'=>$withholding_format,
                'deductions'=>$deductions_format,
                'day_mora'=>$day_mora]);


        $taxesCalculate=Calculate::calculateTaxes($id);

        $taxe_update=Taxe::find($id);

            //Si tiene  multa
            $verify=TaxesMonth::calculateDayMora($taxe_update->fiscal_period,$taxe_update->companies[0]->typeCompany);
            if($verify['mora']){
                $company=Company::find($taxe_update->companies[0]->id);
                $fineCompany=FineCompany::where('fiscal_period',$taxe_update->fiscal_period)->get();
                if(!$fineCompany->isEmpty()){
                    $fine=FineCompany::find($fineCompany[0]->id);
                    $fine->delete();
                }
                $company->fineCompany()->attach(['company_id' => $company->id], ['fine_id'=>1, 'unid_tribu_value'=>$tributo->value, 'fiscal_period'=>$taxe_update->fiscal_period]);
                $fines=$company->fineCompany()->orderBy('id','desc')->take(1)->get();

                $subject = "MULTA-SEMAT";
                $for = $company->users[0]->email;


                try{
                    Mail::send('mails.resolucion', ['name'=>$company->name], function ($msj) use ($subject, $for) {
                        $msj->from("semat.alcaldia.iribarren@gmail.com", "SEMAT");
                        $msj->subject($subject);
                        $msj->to($for);
                    });
                }catch (\Exception $e){
                    return response()->json(['status'=>'error-email','message'=>'La planilla se registro con éxito, sin embargo no se pudo enviar el correo de la multa generada.(Fallo de internet.)']);
                }
                $response=['status'=>'success','message'=>'Registro de planilla con éxito,  se le genero una multa por pago fuera de lapso.'];
                $taxe_update->amount=$taxesCalculate['amountTotal'];
        }else{
                $response=['status'=>'success','message'=>'Registro de planilla con éxito.'];
            $taxe_update->amount=$taxesCalculate['amountTotal'];
        }

       $taxe_update->update();


        return response()->json($response);
    }




    public function verifyTaxes($fiscal_period,$company_id){
        $band=true;
        $company=Company::where('id','=',$company_id)->with('taxesCompanies')->get();
        foreach ($company[0]->taxesCompanies as $taxes){
            if($taxes->fiscal_period==$fiscal_period&&$taxes->status!=='cancel'){
                $band=false;
            }
        }

        $fiscal_period=TaxesMonth::convertFiscalPeriod($fiscal_period);

        if($band){
            $response=array('status'=>'success');
        }else{
            $response=array('status'=>'error','fiscal_period'=>$fiscal_period);
        }
        return response()->json($response);
    }


    public function pdfTaxes($id){
        $taxes = Taxe::findOrFail($id);


        if($taxes->type!='definitive') {
            $ciuTaxes=CiuTaxes::where('taxe_id',$taxes->id)->get();
            $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
                'taxes' => $taxes,
                'ciuTaxes' => $ciuTaxes,
                'firm'=>true
            ]);
        }else{

            $companyTaxe=$taxes->companies()->get();
            $ciuTaxes = CiuTaxes::where('taxe_id', $id)->get();
            $company_find = Company::find($companyTaxe[0]->id);
            $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
            $mora = Extras::orderBy('id', 'desc')->take(1)->get();
            $extra = ['tasa' => $mora[0]->tax_rate];
            $amount=Calculate::calculateTaxes($id);


            $pdf = \PDF::loadView('modules.taxes.receipt',[
                'taxes'=>$taxes,
                'fiscal_period'=>$fiscal_period,
                'extra'=>$extra,
                'ciuTaxes'=>$ciuTaxes,
                'amount'=>$amount,
                'firm'=>true
            ]);
        }







        return $pdf->stream();
    }


    public function myPaymentsTickOffice($type){

        $amount_taxes=0;
        $taxes=Audit::where('user_id',\Auth::user()->id)
            ->where('event','created')
                ->where('auditable_type','App\Payment')
                    ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();

        if(!$taxes->isEmpty()){
            foreach ($taxes as $taxe){
                $id_taxes[]=$taxe->auditable_id;
            }
            if(count($id_taxes)!==0){
                $taxes=Payment::with('taxes')->whereIn('id',$id_taxes)->where('type_payment','=',$type)->get();
                foreach($taxes as $taxe){
                    $amount_taxes+=$taxe->amount;
                }
            }else{
                $amount_taxes=null;
                $taxes=null;
            }
        }else{
            $amount_taxes=null;
            $taxes=null;
        }


        return view('modules.payments.ticket-office',['taxes'=>$taxes,'amount_taxes'=>$amount_taxes]);
    }



    public function payments($type){
        $payment=Payment::with('taxes')->where('type_payment','=',$type)->get();
        if($payment->isEmpty()){
           $payment=null;
        }
        if($type=='TRANSFERENCIA BANCARIA'){
            return view('modules.payments.transfer',['taxes'=>$payment,'amount_taxes'=>0]);
        }else if($type==='PUNTO DE VENTA'){
            return view('modules.payments.pointofsale',['taxes'=>$payment,'amount_taxes'=>0]);
        } else if($type==='DEPOSITO BANCARIO'){
            return view('modules.payments.deposit',['taxes'=>$payment,'amount_taxes'=>0]);
        }

    }



    public function generateReceipt($taxes_data){
        $taxes_data = substr($taxes_data, 0, -1);
        $taxes_explode=explode('-',$taxes_data);
        $ciuTaxes=CiuTaxes::whereIn('taxe_id',$taxes_explode)->with('ciu')->with('taxes')->get();

        if($ciuTaxes[0]->taxes->type!='definitive'){
            $pdf = \PDF::loadView('modules.ticket-office.receipt-ticketoffice',['taxes'=>$ciuTaxes]);
        }else{
            $taxes=Taxe::find($ciuTaxes[0]->taxes->id);
            $ciuTaxes=CiuTaxes::where('taxe_id',$ciuTaxes[0]->taxes->id)->get();
            $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
                'taxes' => $taxes,
                'ciuTaxes' => $ciuTaxes,
                'firm'=>true
            ]);
        }
        return $pdf->stream();
    }


    public function calculatePayments($taxes_data){
        $taxes_data = substr($taxes_data, 0, -1);
        $taxes_explode=explode('-',$taxes_data);

        $taxes=Taxe::whereIn('id',$taxes_explode)->with('payments')->get();
        $amount=0;
        $amount_payment=0;
        $id_payment='';



        foreach ($taxes as $tax){

            if(!$tax->payments->isEmpty()){

                foreach ($tax->payments as $payment){
                    if($payment->id!==$id_payment){
                       if($payment->status!=='cancel'){
                           $amount_payment+=$payment->amount;
                       }
                   }
                    $id_payment=$payment->id;
                }
            }


            $amount+=$tax->amount;
        }
        $amount=$amount-$amount_payment;



        return response()->json(['status'=>'success','amount'=>$amount]);
    }





    public function changeStatustaxes($id,$status){
        $taxes=Taxe::find($id);
        $taxes->status=$status;
        $taxes->update();

        if($status==='verified'){
            $taxes_find=CiuTaxes::whereIn('taxe_id',[$id])->with('ciu')->with('taxes')->get();
            $companyTaxe=$taxes->companies()->get();
            $company_find = Company::find($companyTaxe[0]->id);



            $pdf = \PDF::loadView('modules.taxes.receipt-verified',['taxes'=>$taxes_find]);
            $user= $company_find->users()->get();
            $subject = "PLANILLA VERIFICADA";
            $for = $user[0]->email;

            Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {
                $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                $msj->subject($subject);
                $msj->to($for);
                $msj->attachData($pdf->output(), time().'PLANILLA_VERIFICADA.pdf');
            });
        }


        return response()->json(['status'=>$taxes->statusName]);
    }



    public function paymentsDetails($id){
        $payment=Payment::with('taxes')->where('id','=',$id)->get();
        return view('modules.payments.details',['payments'=>$payment[0]]);
    }


    public function paymentsWeb(){
        $taxes=Taxe::with('companies')->where('status','!=','cancel')->orderBy('id','desc')->get();
        return view('modules.payments.read_web',['taxes'=>$taxes]);
    }


    public function changeStatusPayment($id,$status){
        $message='';

        //Cambiando status del payment
        $payments=Payment::find($id);
        $payments->status=$status;
        $payments->update();

        //Cambiando el estado de la planilla a en procesos
        $taxes=$payments->taxes()->first();


        if($status=='cancel'){
            $taxes->status='ticket-office';
            $taxes->update();
            $message='ANULADO';
        }else{
            $taxes->update();
            $message='VERIFICADO';
        }

        return response()->json(['status'=>$message]);
    }

    //*________DEFINITIVE_________*

    public function verifyDefinitive($company_id){
        $status = TaxesMonth::verifyDefinitive($company_id);
        return response()->json(['status'=>$status]);
    }




}

