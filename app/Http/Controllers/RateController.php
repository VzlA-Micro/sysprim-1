<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Rate;
use App\User;
use App\Helpers\CedulaVE;
use App\Taxe;
use App\Helpers\TaxesNumber;
use App\Tributo;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;



class RateController extends Controller{






    public function index() {
        $rate = Rate::all();
        return view('modules.rates.module.read', ['rate' => $rate]);
    }








    public function verifyCode($code,$id=null){
        $rate=Rate::where('code', $code)->get();

        if(is_null($id)) {
            $rate=Rate::where('code', $code)->get();
        }else{
            $rate=Rate::where('code', $code)->where('id','!=',$id)->get();
        }
        if(!$rate->isEmpty()){
            $response=array('status'=>'error','message'=>'El código "'.$code.'" se encuentra registrado en el sistema. Por favor, ingrese un código valido.');
        }else{
            $response=array('status'=>'success','message'=>'No registrado.');
        }
        return response()->json($response);
    }


    //manager de module
    public function manager(){
        return view('modules.rates.module.manage');
    }


    //view register
    public function create() {
        return view('modules.rates.module.register');
    }



    //register
    public function createRegisterCompany($id){
        $rate = Rate::all();
        $company=Company::findOrFail($id);
        return view('modules.rates.taxpayers.company',['rates' => $rate,'company'=>$company]);
    }




    //save
    public function store(Request $request) {
        $rate = new Rate();
        $rate->code = strtoupper($request->input('code'));
        $rate->name = strtoupper($request->input('name'));
        $rate->type = $request->input('type');
        $rate->cant_tax_unit = $request->input('cant_tax_unit');
        $rate->status = $request->input('status');
        $rate->save();
        return response()->json(['status'=>'success','message'=>'La tasa se ha registrado con éxito.']);
    }



    public function details($id) {
        $rate = Rate::find($id);
        return view('modules.rates.module.details', ['rate' => $rate]);

    }

    public function update(Request $request) {
        $id = $request->input('id');
        $rate = Rate::find($id);
        $rate->code = $request->input('code');
        $rate->name = $request->input('name');
        $rate->type = $request->input('type');
        $rate->cant_tax_unit = $request->input('cant_tax_unit');
        $rate->status = $request->input('status');
        $rate->update();
        return response()->json(['status'=>'success','message'=>'La tasa se ha actualiza con éxito.']);
    }

    public function destroy($id) {
        $rate = Rate::find($id);
        $rate->delete();
        return response()->json(['status'=>'success','message'=>'La tasa se ha eliminado con éxito.']);
    }

    /* taxpayers*/
    public function menuTaxPayers(){
        return view('modules.rates.taxpayers.menu');
    }

    public function  registerTaxPayers(){
        $rate = Rate::all();
        return view('modules.rates.taxpayers.register',['rates'=>$rate]);
    }


    //Buscar empresa o usuario;
    public function findTaxPayers($type_document,$document){
        if($type_document=='V'||$type_document=='E'){
            $user=User::where('ci', $type_document.$document)->get();
            if($user->isEmpty()){
                $user=CedulaVE::get($type_document,$document,false);
                $data=['status'=>'success','type'=>'not-user','user'=>$user];

            }else{

                $data=['status'=>'success','type'=>'user','user'=>$user[0]];
            }
        }else{
            $company=Company::where('RIF', $type_document.$document)->orWhere('license',$type_document.$document)->get();

            if($company->isEmpty()){
                    $data=['status'=>'error','type'=>'not-company','company'=>null];
            }else{

                if($company->count()>1){
                    $data=['status'=>'error','message'=>'Este RIF, posse 2 licencia, por lo cual debe ingresar una licencia para indentificarla, selecione de tipo de documento la L e introduza el N de licencia..'];

                }else{
                    $data=['status'=>'success','type'=>'company','company'=>$company[0]];
                }

            }

        }
        return response()->json($data);
    }




    public function registerCompanyUsers(Request $request){
        $type=$request->input('type');
        $name=$request->input('name');
        $surname=$request->input('surname');
        $type_document=$request->input('type_document');
        $document=$request->input('document');
        $address=$request->input('address');
        $email=$request->input('email');

        if($type=='user'){

            $user=new User();
            $user->name=$name;
            $user->surname=$surname;
            $user->ci=$type_document.$document;
            $user->status_account='waiting';
            $user->address=$address;
            $user->email=$email;
            $user->role_id=3;
            $user->save();
            $id=$user->id;
        }else{
            $company=new Company();
            $company->name=$name;
            $company->RIF=$type_document.$document;
            $company->status='waiting';
            $company->address=$address;
            $company->save();
            $id=$company->id;

        }


        return response(['status'=>'success','id'=>$id,'type'=>$type]);
    }


    public function saveTaxPayers(Request $request){
        $type=$request->input('type');
        $id=$request->input('id');
        $rate_id=$request->input('rate_id');

        $person_id=null;
        $company_id=null;
        if($type=='user'){
            $person_id=$id;
            $user_id=\Auth::user()->id;

        }else{

            $user_id=\Auth::user()->id;
            $company_id=$id;
        }

        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxe->status='temporal';
        $taxe->type='daily';
        $taxe->fiscal_period=date('Y-m-d');
        $taxe->branch='Tasas y Cert';
        $taxe->save();
        $id = $taxe->id;


        $amount=0;

        $tributo=Tributo::orderBy('id','desc')->first();




        for ($i=0;$i<count($rate_id);$i++){
            $rate=Rate::find($rate_id[$i]);
            $taxe->rateTaxes()->attach(['taxe_id'=>$id],
                [    'rate_id'=>$rate_id[$i],
                    'company_id'=>$company_id,
                    'person_id'=>$person_id,
                    'user_id'=>$user_id,
                    'cant_tax_unit'=>$rate->cant_tax_unit,
                    'tax_unit'=>$tributo->value,
                ]);


            $amount+=$rate->cant_tax_unit*$tributo->value;
        }


        $taxe_find=Taxe::find($id);
        $taxe_find->amount=$amount;
        $taxe_find->update();
        return response()->json(['status'=>'success','taxe_id'=>$id]);
    }


    public function detailsTaxPayers($id){
        $taxe=Taxe::find($id);
        $rate=$taxe->rateTaxes()->get();

        $type='';

        if(!is_null($rate[0]->pivot->company_id)){
            $data=Company::find($rate[0]->pivot->company_id);
            $type='company';
        }else{
            $data=User::find($rate[0]->pivot->person_id);
            $type='user';
        }


        return view('modules.rates.taxpayers.details',['taxes'=>$taxe,'data'=>$data,'type'=>$type]);
    }


    public function calculateTaxPayers($id){
        $taxe=Taxe::find($id);
        if($taxe->stauts==='temporal'){
            $taxe->delete();
        }
        return redirect('home');
    }



    public function typePaymentTaxPayers($id){
        $taxe=Taxe::findOrFail($id);
        return view('modules.rates.taxpayers.payments',['taxes_id'=>$id]);
    }




    public function pdfTaxPayers($id,$download){
        $taxe=Taxe::find($id);
        $rate=$taxe->rateTaxes()->get();
        $type='';

        if(!is_null($rate[0]->pivot->company_id)){
            $data=Company::find($rate[0]->pivot->company_id);
            $type='company';
        }else{
            $data=User::find($rate[0]->pivot->person_id);
            $type='user';
        }

        $pdf = \PDF::loadView('modules.rates.taxpayers.receipt', [
            'taxes' => $taxe,
            'data' => $data,
        ]);

        if($download==='true'){
            return $pdf->stream('PLANILLA_TASAS.pdf');
        }else{
            return $pdf->stream('PLANILLA_TASAS.pdf');
        }

    }





    public function  paymentStoreTaxPayers(Request $request)
    {
        $id_taxes = $request->input('id_taxes');
        $type_payment = $request->input('type_payment');
        $bank_payment = $request->input('bank_payment');

        $taxes = Taxe::findOrFail($id_taxes);
        $code = TaxesNumber::generateNumberTaxes($type_payment . "81");
        $taxes->code = $code;
        $code = substr($code, 3, 12);
        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));


        $type = '';
        $rate = $taxes->rateTaxes()->get();


        if (!is_null($rate[0]->pivot->company_id)) {
            $data = Company::find($rate[0]->pivot->company_id);
            $type = 'company';
        } else {
            $data = User::find($rate[0]->pivot->person_id);
            $type = 'user';
        }


        if ($type_payment != 'PPV') {

            if ($type_payment == 'PPE') {
                $taxes->bank = $bank_payment;
                $amount = round($taxes->amount, 0);
                $taxes->amount = $amount;
                var_dump($amount);
                var_dump($date_format);
                var_dump($bank_payment);
                var_dump($code);

                $taxes->digit = TaxesNumber::generateNumberSecret($amount, $date_format, $bank_payment, $code);
                dd($taxes->digit);
            } else {
                $taxes->bank = $bank_payment;
                $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank_payment, $code);
            }
        }

        $taxes->status = "process";
        $taxes->update();


        $subject = "PLANILLA DE PAGO";
        $for = \Auth::user()->email;


        $pdf = \PDF::loadView('modules.rates.taxpayers.receipt', [
            'taxes' => $taxes,
            'data' => $data,
            'firm' => false
        ]);


        Mail::send('mails.payment-payroll', ['type' => 'Declaración de Tasas Y Certificaciones'], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("semat.alcaldia.iribarren@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
            $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });

        return redirect('rate/taxpayers/payments-history')->with('message', 'La planilla fue registra con éxito,fue enviado al correo ' . \Auth::user()->email . ',recuerda que esta planilla es valida solo por el dia ' . $date);
    }


    public function paymentHistoryTaxPayers(){
        $users=User::find(\Auth::user()->id);
        $taxes=$users->taxesRate()->distinct()->orderBy('id','desc')->get();




        return view('modules.rates.taxpayers.history', ['taxes' =>$taxes]);
    }


    public function menuTicketOffice(){
        return view('modules.rates.ticket-office.menu');
    }




    public function generateRateTicketOffice(){
        $rate = Rate::all();

        return view('modules.rates.ticket-office.generate-rate',
            ['rates'=>$rate]);
    }



    public function saveRateTicketOffice(Request $request){
        $type=$request->input('type');
        $id=$request->input('id');
        $rate_id=$request->input('rate_id');

        $person_id=null;
        $company_id=null;
        if($type=='user'){
            $person_id=$id;
            $user_id=$id;
        }else{
            $user_id=\Auth::user()->id;
            $company_id=$id;
        }


        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('PTS'."88");
        $taxe->status='ticket-office';
        $taxe->type='daily';
        $taxe->fiscal_period=date('Y-m-d');
        $taxe->branch='Tasas y Cert';
        $taxe->save();
        $id = $taxe->id;
        $amount=0;


        $tributo=Tributo::orderBy('id','desc')->first();



        for ($i=0;$i<count($rate_id);$i++){
            $rate=Rate::find($rate_id[$i]);
            $taxe->rateTaxes()->attach(['taxe_id'=>$id],
                [   'rate_id'=>$rate_id[$i],
                    'company_id'=>$company_id,
                    'person_id'=>$person_id,
                    'user_id'=>$user_id,
                    'cant_tax_unit'=>$rate->cant_tax_unit,
                    'tax_unit'=>$tributo->value,
                ]);


            $amount+=$rate->cant_tax_unit*$tributo->value;
        }


        $taxe_find=Taxe::find($id);
        $taxe_find->amount=$amount;
        $taxe_find->update();



        return response()->json(['status'=>'success','taxe_id'=>$id]);
    }




    public function getTaxesRateTicketOffice(){
        $taxes = Audit::where('user_id', \Auth::user()->id)
            ->where('event', 'created')
            ->where('auditable_type', 'App\Taxe')
            ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();

        if (!$taxes->isEmpty()) {
            foreach ($taxes as $taxe) {
                $id_taxes[] = $taxe->auditable_id;
            }
            if (count($id_taxes) !== 0) {

                $taxes = Taxe::where('status', '=', 'ticket-office')->where('branch','=','Tasas y Cert')->whereIn('id', $id_taxes)->with('rateTaxes')->distinct()->get();

            } else {

                $amount_taxes = null;
                $taxes = null;
            }
        } else {
            $amount_taxes = null;
            $taxes = null;
        }


        return view('modules.rates.ticket-office.payment', ['taxes' => $taxes]);
    }

    public function detailsTicketOffice($id){
        $taxe=Taxe::find($id);
        $rate=$taxe->rateTaxes()->get();
        $type='';

        if(!is_null($rate[0]->pivot->company_id)){
            $data=Company::find($rate[0]->pivot->company_id);
            $type='company';
        }else{
            $data=User::find($rate[0]->pivot->person_id);
            $type='user';
        }


        $verified = true;

        if (!$taxe->payments->isEmpty()) {
            foreach ($taxe->payments as $payment) {
                if ($payment->status != 'verified') {
                    $verified = false;
                }
            }
        } else {
            $verified = false;
        }


        return view('modules.rates.ticket-office.details',['taxes'=>$taxe,'data'=>$data,'type'=>$type,'verified'=>$verified]);
    }



    public function verifyEmail($email){
        $user = User::where('email', $email)->get();

        if(!$user->isEmpty()){
            $response=array('status'=>'error','message'=>'El correo "'.$email.'" encuentra registrado en el sistema. Por favor, ingrese un correo valido.');
        }else{
            $response=array('status'=>'success','message'=>'No registrado.');
        }
        return response()->json($response);
    }

}
