<?php

namespace App\Http\Controllers;

use App\Helpers\Calculate;
use App\Payments;
use App\Taxe;
use Faker\Provider\Payment;
use Illuminate\Http\Request;
use App\CiuTaxes;
use App\Parish;
use App\Company;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Helpers\TaxesNumber;
use App\Tributo;
use App\Helpers\TaxesMonth;
use App\Ciu;
use App\Extras;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;
class TicketOfficeController extends Controller{



    public function QrTaxes($id){
        try {
            $id=Crypt::decrypt($id);

            $taxe=Taxe::with('companies')->where('id',$id)->get();
            if($taxe[0]->status==='verified'){
                return response()->json(['status'=>'verified','taxe'=>null,'calculate'=>null,'ciu'=>null]);
            }else{
                $calculateTaxes=Calculate::calculateTaxes($id);
                $ciuTaxes=CiuTaxes::with('ciu')->where('taxe_id',$id)->get();
                return response()->json(['status'=>'process','taxe'=>$taxe,'calculate'=>$calculateTaxes,'ciu'=>$ciuTaxes]);
            }
        } catch (DecryptException $e) {
            return response()->json(['status' => 'error', 'taxe' => null, 'calculate' => null, 'ciu' => null]);
        }
    }

    public function cashier(){;
        return view('modules.ticket-office.create');
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
        $amount=$request->input('amount');
        $ref=$request->input('ref');
        $bank=$request->input('bank');
        $bank_destinations=$request->input('bank_destinations');
        $person=$request->input('person');
        $country_code = $request->input('country_code');
        $phone=$request->input('phone');
        $payments_type=$request->input('payments_type');



        $taxe=Taxe::findOrFail($id_taxes);
        $amountPayment=0;
        $acum=0;

        $amount_format=str_replace('.','',$amount);
        $amount=str_replace(',','.',$amount_format);
        $payments=new Payments();


        $payments->taxe_id=$id_taxes;
        $payments->lot=$lot;
        $payments->amount=$amount;
        $payments->ref=$ref;
        $payments->bank=$bank;
        $payments->name=$person;
        $payments->phone=$country_code.$phone;
        $payments->type_payment=$payments_type;
        $payments->save();

        $paymentsTaxe= $taxe->payments()->get();

        if ($paymentsTaxe->isEmpty()) {
            $amountPayment=$taxe->amount-$amount;

            if($amountPayment==0){
                $data=['status'=>'success'];

                if($bank_destinations!==null){
                    $taxe->bank=$bank_destinations;
                }else{
                    $taxe->status='verified';
                    $taxe->bank=$bank;
                }

                $taxe->update();
            }else{
                $data=['status'=>'process','payment'=>$amountPayment];
            }
        }else{
            foreach ($paymentsTaxe as $payment){
                $acum=$acum+$payment->amount;
            }

            if($acum>=$taxe->amount){
                $data=['status'=>'success','payment'=>0];

                if($bank_destinations!==null){
                    $taxe->bank=$bank_destinations;
                    $taxe->status='process';
                }else{
                    $taxe->bank=$bank;
                    $taxe->status='verified';
                }
                $taxe->update();
            }else{
                $amountPayment=$taxe->amount-$acum;
                $data=['status'=>'process','payment'=>number_format($amountPayment,2)];
            }
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
        $company = Company::where('license',$code)->with('ciu')->with('users')->get();

        if($company->isEmpty()){
            $response=array('status'=>'error','message'=>'La Licencia '.$code.' no esta registrar, debe registrar una empresa.');
        }else{
            $response=array('status'=>'success','company'=>$company);
        }



        return response()->json($response);
    }



    //taxes



    public function registerTaxes(Request $request){

        $datos=$request->all();;
        $fiscal_period = $datos['fiscal_period'];
        $company = $datos['company_id'];
        $company_find = Company::find($company);

        $ciu_id = $datos['ciu_id'];
        $min_tribu_men = $datos['min_tribu_men'];
        $deductions = $datos['deductions'];

        $withholding = $datos['withholding'];
        $base = $datos['base'];
        $fiscal_credits = $datos['fiscal_credits'];


        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('PPV81');
        $taxe->fiscal_period = $fiscal_period;
        $taxe->branch='Act.Eco';
        $taxe->bank='66';

        $taxe->save();


        $id = $taxe->id;


        $unid_tribu = Tributo::orderBy('id', 'desc')->take(1)->get();
        $date = TaxesMonth::verify($company, false);



        for ($i = 0; $i < count($base); $i++) {
            //format a base
            $base_format = str_replace('.', '', $base[$i]);
            $base_format = str_replace(',', '.', $base_format);
            //format a deductions
            $deductions_format = str_replace('.', '', $deductions[$i]);
            $deductions_format = str_replace(',', '.', $deductions_format);
            //format withdolding
            $withholding_format = str_replace('.', '', $withholding[$i]);

            $withholding_format = str_replace(',', '.', $withholding_format);
            //format fiscal credits
            $fiscal_credits_format = str_replace('.', '', $fiscal_credits[$i]);
            $fiscal_credits_format = str_replace(',', '.', $fiscal_credits_format);
            $ciu = Ciu::find($ciu_id[$i]);

            if ($base[$i] == 0) {
                $taxes = $ciu->min_tribu_men * $unid_tribu[0]->value;
                $unid_total = $unid_tribu[0]->value;
            } else {
                $taxes = $ciu->alicuota * $base_format / 100;
                $unid_total = 0;
            }

            if ($date['mora']) {//si tiene mora
                $extra = Extras::orderBy('id', 'desc')->take(1)->get();
                if ($company_find->typeCompany === 'R') {
                    $tax_rate = $taxes + (float)$withholding_format - (float)$deductions_format - (float)$fiscal_credits_format;
                } else {
                    $tax_rate = $taxes - $withholding_format - (float)-(float)$deductions_format - (float)$fiscal_credits_format;
                }

                $tax_rate = $tax_rate * $extra[0]->tax_rate / 100;
                $interest = (0.42648 / 360) * $date['diffDayMora'] * ($tax_rate + $taxes);
                $mora = 0;
            } else {
                $mora = 0;
                $tax_rate = 0;
                $interest = 0;
            }


            $taxe->companies()->attach(['taxe_id'=>$id],['company_id'=>$company_find->id]);




            $taxe->taxesCiu()->attach(['taxe_id'=>$id],
                [   'ciu_id'=>$ciu_id[$i],
                    'base'=>$base_format,
                    'deductions'=>$deductions_format,
                    'withholding'=>$withholding_format,
                    'fiscal_credits'=>$fiscal_credits_format,
                    'unid_tribu'=>$unid_total,
                    'mora'=>$mora,
                    'tax_rate'=>$tax_rate,
                    'interest'=>$interest
                ]);




        }
        $taxesCalculate=Calculate::calculateTaxes($id);
        $taxesCalculate['id_taxes']=$id;
        $taxe_update=Taxe::find($id);
        $taxe_update->amount=$taxesCalculate['amountTotal'];
        $taxe_update->update();


        return response()->json(['taxe'=>$taxesCalculate]);
    }




    public function verifyTaxes($fiscal_period,$company_id){
        $band=true;
        $company=Company::where('id','=',$company_id)->with('taxesCompanies')->get();
        foreach ($company[0]->taxesCompanies as $taxes){
            if($taxes->fiscal_period==$fiscal_period&&$taxes->status!==null){
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

        return $pdf->stream();
    }

    public function taxesAll(){

        $amount_taxes=0;
        $taxes=Audit::where('user_id',\Auth::user()->id)
            ->where('event','created')
                ->where('auditable_type','App\Payments')
                    ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();

        if(!$taxes->isEmpty()){
            foreach ($taxes as $taxe){
                $id_taxes[]=$taxe->auditable_id;
            }

            if(count($id_taxes)!==0){
                $taxes=Payments::with('taxes')->whereIn('id',$id_taxes)->get();

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


        return view('modules.payments.read',['taxes'=>$taxes,'amount_taxes'=>$amount_taxes]);
    }



    public function payments($type){
        $payment=Payments::with('taxes')->where('type_payment','=',$type)->get();
        return view('modules.payments.read',['taxes'=>$payment,'amount_taxes'=>0]);
    }


    public function changeStatustaxes($id){

    }







}
