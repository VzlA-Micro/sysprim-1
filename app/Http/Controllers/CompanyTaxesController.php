<?php

namespace App\Http\Controllers;

use App\BankRate;
use App\Ciu;
use App\Company;
use App\Extras;
use App\FindCompany;
use App\Fine;
use App\FineCompany;
use App\Helpers\Calculate;
use App\Notification;
use App\Recharge;
use App\Tributo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\TaxesNumber;
use App\Taxe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Alert;
use App\Helpers\TaxesMonth;
use Illuminate\Support\Facades\Session;
use App\CiuTaxes;
use App\Employees;
use Illuminate\Support\Facades\Mail;



class CompanyTaxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $taxes = Taxe::all();
    }


    public function history($company)
    {
        $company=Company::where('name',$company)->get();

        $company=Company::find($company[0]->id);

        if(!$company->taxesCompanies->isEmpty()){

           /* foreach ($company->taxesCompanies as $taxe ){
                $taxes[]=Taxe::where('id',$taxe->id)->where('status','verified')->orWhere('status','process')->where('id',$taxe->id)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->get();
            }*/
        }else{
            $taxes=null;
        }

        return view('modules.payments.history', ['taxes' => $company->taxesCompanies()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create($company,$type)
    {
        $company = Company::where('name', $company)->get();
        $company_find = Company::find($company[0]->id);
        $mounths = array("ENERO" => '01', "FEBRERO" => '02', "MARZO" => '03', "ABRIL" => '04', "MAYO" => '05', "JUNIO" => '06', "JULIO" => '07', "AGOSTO" => '08', "SEPTIEMBRE" => '09', "OCTUBRE" => '10', "NOVIEMBRE" => '11', "DICIEMBRE" => '12');
        $mounthNow = Carbon::now()->format('m');


        if ($company_find->status !== 'disabled') {

            if ($type !== 'definitive') {
                $mounth_pay = TaxesMonth::verify($company[0]->id, false);

                $users = $company_find->users()->get();
                $taxes = $company_find->taxesCompanies()->orderBy('id', 'desc')->take(1)->get();
                $unid_tribu = Tributo::orderBy('id', 'desc')->take(1)->get();

                if (isset($users[0]->id) && $users[0]->id != \Auth::user()->id) {//si la empresa le pertenece a quien coloco la ruta
                    return redirect('companies/my-business');
                } else {
                    return view('modules.taxes.register', ['company' => $company_find, "mount_pay" => $mounth_pay, 'mounths' => $mounths, 'mountNow' => $mounthNow, 'unid_tribu' => $unid_tribu[0]->value]);

                }
            } else {

                $users = $company_find->users()->get();

                $status = TaxesMonth::verifyDefinitive($company[0]->id);
                $unid_tribu = Tributo::orderBy('id', 'desc')->take(1)->get();


                return view('modules.acteco-definitive.register', ['company' => $company_find,
                    "status" => $status,
                    'unid_tribu' => $unid_tribu[0]->value
                ]);
            }

        } else {
            return redirect('companies/details/' . $company_find->id);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /*
        $ciu=$request->input('ciu');
        $base=$request->input('base');
        $dedutions=$request->input('deductions');
        $withholding=$request->input('withholding');
        $fiscal_credits=$request->input('fiscal_credits');

       */


        $fiscal_period = $request->input('fiscal_period');
        $company = $request->input('company_id');
        $company_find = Company::find($company);
        $ciu_id = $request->input('ciu_id');
        $min_tribu_men = $request->input('min_tribu_men');

        $deductions = $request->input('deductions');
        $withholding = $request->input('withholding');
        $fiscal_credits = $request->input('fiscal_credits');

        $base = $request->input('base');



        $date =TaxesMonth::calculateDayMora($fiscal_period,$company_find->typeCompany);
        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxe->fiscal_period = $fiscal_period;
        $taxe->status='temporal';
        $taxe->type='actuated';
        $taxe->branch='Act.Eco';
        $taxe->save();

        $id = $taxe->id;


        //Colocar siempre unidad tributarias vigentes.
        $fiscal_period_format=Carbon::parse($fiscal_period);
        $tributo = Tributo::whereDate('to','>=',$fiscal_period_format)->whereDate('since','<=',$fiscal_period_format)->first();



        //format a deductions
        $deductions_format = str_replace('.', '', $deductions);
        $deductions_format = str_replace(',', '.', $deductions_format);

        //format withdolding
        $withholding_format = str_replace('.', '', $withholding);
        $withholding_format = str_replace(',', '.', $withholding_format);

        //format fiscal credits
        $fiscal_credits_format = str_replace('.', '', $fiscal_credits);
        $fiscal_credits_format = str_replace(',', '.', $fiscal_credits_format);

        //base imponible
         $base_format_verify=0;
         $total_base=0;



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


        if($company_find->typeCompany=='R'){
            $total_base=$total_base+$withholding_format-$fiscal_credits_format-$deductions_format;
        }else{
            $total_base=$total_base-$withholding_format-$fiscal_credits_format-$deductions_format;
        }



        if($total_base < 0){
            return redirect('payments/create/'.$company_find->name.'/actuated')->with(['message'=>'La deducciones o creditos fiscal no pueder ser mayor que el impuesto causado.']);
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
            if($base_amount_sub>$min_amount){

                $min_amount=0;
            }else{//si no paga minimo

                $base_amount_sub=$min_amount;
            }

            if ($date['mora']) {//si tiene mora
                //Obtengo recargo

                $recharge = Recharge::where('branch', 'Act.Eco')->whereDate('to','>=',$fiscal_period_format)->whereDate('since','<=',$fiscal_period_format)->first();

                //Obtengo Intereset del banco
                $interest_bank=BankRate::orderBy('id', 'desc')->take(1)->first();

                $amount_recharge = $base_amount_sub * $recharge->value / 100;
                $interest=(($interest_bank->value_rate/100) / 360) * $date['diffDayMora'] *($amount_recharge+$base_amount_sub);

            } else {
                $amount_recharge= 0;
                $interest = 0;
            }

            $taxe->taxesCiu()->attach(['taxe_id'=>$id],
                    ['ciu_id'=>$ciu_id[$i],
                    'base'=>$base_format,
                    'recharge'=>$amount_recharge,
                    'tax_unit'=>$tributo->value,
                    'interest'=>$interest,
                    'taxable_minimum'=>$min_amount
            ]);
        }


        $day_mora=$date['diffDayMora'];
        $taxe->companies()->attach(['taxe_id'=>$id],['company_id'=>$company_find->id,
                                                    'fiscal_credits'=>$fiscal_credits_format,
                                                    'withholding'=>$withholding_format,
                                                    'deductions'=>$deductions_format,
                                                    'day_mora'=>$day_mora]);
        $calculate=Calculate::calculateTaxes($id);


        //Busco la impuesto y le coloco el total a pagar
        $taxes_find=Taxe::find($id);
        $taxes_find->amount=$calculate['amountTotal'];
        $taxes_find->update();




        return redirect('payments/taxes/' . $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $taxes = Taxe::findOrFail($id);
        $companyTaxe=$taxes->companies()->get();
        $ciuTaxes = CiuTaxes::where('taxe_id', $id)->get();
        $company_find = Company::find($companyTaxe[0]->id);
        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $amount=Calculate::calculateTaxes($id);



        return view('modules.taxes.details', [  'taxes' => $taxes,
                'fiscal_period' => $fiscal_period,
                'ciuTaxes' => $ciuTaxes,
                'amount'=>$amount
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //descargar pdf de taxes
    public function downloadPDF($id)
    {

        $taxes = Taxe::findOrFail($id);
        $ciuTaxes = CiuTaxes::where('taxe_id', $id)->get();
        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $amount=Calculate::calculateTaxes($id);
        $firm=false;

        if($taxes->status==='verified'){
            $firm=true;
        }
        $pdf = \PDF::loadView('modules.taxes.receipt',
            ['taxes' => $taxes,
                'fiscal_period' => $fiscal_period,
                'ciuTaxes' => $ciuTaxes,
                'amount' => $amount,
                'firm' => $firm
            ]);

        return $pdf->download('PLANILLA_ANTICIPADA.pdf');
    }


    //registrar el taxes con su forma de pago
    public function payments( Request $request){


        $id_taxes=$request->input('id_taxes');
        $type_payment=$request->input('type_payment');
        $bank_payment=$request->input('bank_payment');
        $taxes = Taxe::findOrFail($id_taxes);


        $code = TaxesNumber::generateNumberTaxes($type_payment . "81");
        $taxes->code=$code;
        $code = substr($code, 3, 12);

        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));


        if($type_payment!='PPV'){
            if($type_payment=='PPE'){
                $taxes->bank=$bank_payment;
                $amount=round($taxes->amount,0);
                $taxes->amount=$amount;
                $taxes->digit = TaxesNumber::generateNumberSecret($amount, $date_format, $bank_payment, $code);

            }else{
                $taxes->bank=$bank_payment;
                $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank_payment, $code);
            }

        }

        $taxes->status="process";
        $taxes->update();


        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $fiscal_period_format=Carbon::parse($taxes->fiscal_period);
        $tributo = Tributo::whereDate('to','>=',$fiscal_period_format)->whereDate('since','<=',$fiscal_period_format)->first();


        $amount=Calculate::calculateTaxes($id_taxes);
        $ciuTaxes =CiuTaxes::where('taxe_id', $id_taxes)->get();
        $verify=TaxesMonth::calculateDayMora($taxes->fiscal_period,$taxes->companies[0]->typeCompany);



        if($verify['mora']){
            $company=Company::find($taxes->companies[0]->id);
            $fineCompany=FineCompany::where('fiscal_period',$taxes->fiscal_period)->get();
            if(!$fineCompany->isEmpty()){
                $fine=FineCompany::find($fineCompany[0]->id);
                $fine->delete();
            }
            $company->fineCompany()->attach(['company_id' => $company->id], ['fine_id'=>1, 'unid_tribu_value'=>$tributo->value, 'fiscal_period'=>$taxes->fiscal_period]);

            $fines=$company->fineCompany()->orderBy('id','desc')->take(1)->get();

            $subject = "MULTA-SEMAT";
            $for = \Auth::user()->email;

            Mail::send('mails.resolucion', ['name'=>$company->name], function ($msj) use ($subject, $for) {
                $msj->from("semat.alcaldia.iribarren@gmail.com", "SEMAT");
                $msj->subject($subject);
                $msj->to($for);
            });


        }


        $subject = "PLANILLA DE PAGO";
        $for = \Auth::user()->email;

        $pdf = \PDF::loadView('modules.taxes.receipt',
            ['taxes' => $taxes,
            'fiscal_period' => $fiscal_period,
            'ciuTaxes' => $ciuTaxes,
            'amount' => $amount,
            'firm' => false
        ]);


        Mail::send('mails.payment-payroll', ['type'=>'Declaración de Actividad Económica (ANTICIPADA)'], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("semat.alcaldia.iribarren@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
           $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });


        return redirect('payments/history/' . session('company'))->with('message', 'La planilla fue registra con éxito,fue enviado al correo ' . \Auth::user()->email . ',recuerda que esta planilla es valida solo por el dia ' . $date_format);
    }







    //Guardar el taxes
    public function taxesSave(Request $request){
        $id = $request->input('taxes_id');
        $taxes=Taxe::find($id);
        if($taxes->amount==0) {
            $code = TaxesNumber::generateNumberTaxes('PSP' . "81");
            $taxes->code = $code;
            $taxes->status = 'verified';
            $taxes->update();

            $ciuTaxes = CiuTaxes::where('taxe_id', $taxes->id)->get();
            $subject = "PLANILLA DE PAGO";
            $for = \Auth::user()->email;
            $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
            $amount = Calculate::calculateTaxes($id);

            $pdf = \PDF::loadView('modules.taxes.receipt',
                ['taxes' => $taxes,
                    'fiscal_period' => $fiscal_period,
                    'ciuTaxes' => $ciuTaxes,
                    'amount' => $amount,
                    'firm' => true
                ]);

            Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {
                $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                $msj->subject($subject);
                $msj->to($for);
                $msj->attachData($pdf->output(), time() . 'PLANILLA_VERIFICADA.pdf');
            });

            return redirect('payments/history/' . session('company'))->with('message', 'La declaración fue registra con éxito,se le envio al correo ' . \Auth::user()->email . ' su pago verificado.');

        }

        return view('modules.taxes.payments',['taxes_id'=>$id]);

    }

    public function calculate($id){
        $taxes = Taxe::findOrFail($id);
        $taxes->delete();
        return redirect('payments/create/' . session('company').'/'.'actuated');
    }




    public function downloadCalculate(Request $request){
        $amountInterest=0;//total de intereses
        $amountRecargo=0;//total de recargos
        $amountCiiu=0;//total de ciiu
        $amountDesc=0;//Descuento
        $amountTaxes=0;//total a de impuesto
        $amountTotal=0;

        $id = $request->input('taxes_id');
        $amount = $request->input('total');

        $amount_format = str_replace('.', '', $amount);
        $amount_format = str_replace(',', '.', $amount_format);
        $taxes = Taxe::find($id);




        $taxes->amount = $amount_format;
        $code = 'PCC00000000';
        $taxes->code = $code;
        $taxes->status = 'calculate';
        $taxes->branch = 'Act.Eco';
        $code = substr($code, 3, 12);
        $taxes->update();



        $taxes=Taxe::findOrFail($id);
        $ciuTaxes=CiuTaxes::where('taxe_id',$taxes->id)->get();
        $companyTaxe=$taxes->companies()->get();
        $company_find=Company::find($companyTaxe[0]->id);

        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $mora = Extras::orderBy('id', 'desc')->take(1)->get();
        $extra = ['tasa' => $mora[0]->tax_rate];

        foreach ($ciuTaxes as $ciu) {
            $amountInterest += $ciu->interest;
            $amountRecargo += $ciu->tax_rate;

            if ($company_find->TypeCompany === 'R') {
                $amountCiiu += $ciu->totalCiiu + $ciu->withholding - $ciu->deductions - $ciu->fiscal_credits;
            } else {
                $amountCiiu += $ciu->totalCiiu - $ciu->withholding - $ciu->fiscal_credits - $ciu->dedutions;
            }
        }

        $amountTaxes = $amountInterest + $amountRecargo + $amountCiiu;//Total

        //si tiene descuento

        /*if($company_find->desc){
            $employees = Employees::all();
            foreach ($employees as $employee) {
                if ($company_find->number_employees >= $employee->min) {
                    if ($company_find->number_employees <= $employee->max) {
                        $amountDesc = $amountTaxes * $employee->value / 100;

                    }
                }
            }

            $amountTaxes=$amountTaxes-$amountDesc;//descuento
        }*/


        $amount = ['amountInterest' => $amountInterest,
            'amountRecargo' => $amountRecargo,
            'amountCiiu' => $amountCiiu,
            'amountTotal' => $amountTaxes,
            'amountDesc' => $amountDesc
        ];


        $pdf = \PDF::loadView('modules.taxes.receipt-calculate',[
            'taxes'=>$taxes,
            'fiscal_period'=>$fiscal_period,
            'extra'=>$extra,
            'ciuTaxes'=>$ciuTaxes,
            'amount'=>$amount,
            'firm'=>false
        ]);

        $taxes->delete();
        return $pdf->stream('recibo.pdf');

    }





    public function storeDefinitive(Request $request){

        $taxes_amount=0;//Para calcular monto total

        $fiscal_period = $request->input('fiscal_period');
        $company = $request->input('company_id');
        $company_find = Company::find($company);
        $amount_recharge=0;
        $interest=0;

        $amount_total=0;

        $ciu_id = $request->input('ciu_id');



        $min_tribu_men = $request->input('min_tribu_men');
        /* $deductions = $request->input('deductions');
          $withholding = $request->input('withholding');


        */


        $base=$request->input('base');
        $anticipated = $request->input('anticipated');
        $fiscal_credits = $request->input('fiscal_credits');



        //$date =TaxesMonth::calculateDayMora($fiscal_period,$company_find->typeCompany);
        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxe->fiscal_period = $fiscal_period;
        $taxe->fiscal_period_end = '2019-12-01';
        $taxe->status = 'temporal';
        $taxe->type = 'definitive';
        $taxe->branch = 'Act.Eco';
        $taxe->save();


        $id = $taxe->id;
        $unid_tribu = Tributo::orderBy('id', 'desc')->take(1)->get();

        $total_base=0;
        $fiscal_period_format=Carbon::parse($fiscal_period);

        $tributo = Tributo::whereDate('to','>=',$fiscal_period_format)->whereDate('since','<=',$fiscal_period_format)->first();

        $fiscal_credits_format = str_replace('.', '', $fiscal_credits);
        $fiscal_credits_format = str_replace(',', '.', $fiscal_credits_format);


        for ($i = 0; $i < count($base); $i++) {

            //damos formato a la base
            $base_format_verify = str_replace('.', '', $base[$i]);
            $base_format_verify = str_replace(',', '.', $base_format_verify);



            $anticipated_format_verify = str_replace('.', '', $anticipated[$i]);
            $anticipated_format_verify = str_replace(',', '.', $anticipated_format_verify);


            $ciu = Ciu::find($ciu_id[$i]);

            //Calculo de minimo  a tributar
            $min_amount = $ciu->min_tribu_men * $tributo->value*12;

            //Calculo de base imponible
            $base_amount_sub =$ciu->alicuota * $base_format_verify;



            if ($min_amount > $base_amount_sub) {
                $total_base = ($total_base + $min_amount)-$anticipated_format_verify;
            } else {
                $total_base = $total_base + $base_amount_sub-$anticipated_format_verify;
            }

        }

        $total_base=$total_base-$fiscal_credits_format;



        if($total_base < 0){
            return redirect('payments/create/'.$company_find->name.'/definitive')->with(['message'=>'La Deducciones o Creditos Fiscal no pueder ser mayor que el impuesto causado.']);
        }



        for ($i = 0; $i < count($base); $i++) {
            //format a base

            $base_format = str_replace('.', '', $base[$i]);

            $base_format = str_replace(',', '.', $base_format);

            $anticipated_format = str_replace('.', '', $anticipated[$i]);
            $anticipated_format = str_replace(',', '.', $anticipated_format);

            $ciu = Ciu::find($ciu_id[$i]);



            //Calculo de minimo  a tributar
            $min_amount = $ciu->min_tribu_men * $tributo->value *12;

            //Calculo de base imponible
            $base_amount_sub = $ciu->alicuota * $base_format;

            //si lo que va a pagar es mayor que el min a tributar
            if($base_amount_sub>$min_amount){
                $min_amount=0;
            }else{//si no paga minimo
                $base_amount_sub=$min_amount;
            }



            $amount_total+=$base_amount_sub-$anticipated_format;




            $taxe->taxesCiu()->attach(['taxe_id'=>$id],
                ['ciu_id'=>$ciu_id[$i],
                    'base'=>$base_format,
                    'recharge'=>$amount_recharge,
                    'tax_unit'=>$tributo->value,
                    'interest'=>$interest,
                    'base_anticipated'=>$anticipated_format,
                    'taxable_minimum'=>$min_amount
                ]);




            /*if ($date['mora']) {//si tiene mora
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
            }*/
        }

        $day_mora=0;
        $taxe->companies()->attach(['taxe_id'=>$id],['company_id'=>$company_find->id,
            'fiscal_credits'=>$fiscal_credits_format,
            'withholding'=>0,
            'deductions'=>0,
            'day_mora'=>$day_mora
        ]);

        $taxe=Taxe::find($taxe->id);
        $taxe->amount=$amount_total-$fiscal_credits_format;
        $taxe->update();


        return redirect('taxes/definitive/' . $id);
    }



    //detalles Taxes
    public function detailsDefinitive($id){
        $taxes=Taxe::find($id);
        $ciuTaxes = CiuTaxes::where('taxe_id', $taxes->id)->get();
        return view('modules.acteco-definitive.details',['taxes'=>$taxes,'ciuTaxes'=>$ciuTaxes]);
    }





    //Calcular de muevo definitive
    public function againDefinitive($id){
        $taxes=Taxe::find($id);
        $taxes->delete();
        return redirect('payments/create/' . session('company').'/'.'definitive');
    }




    public function typePaymentDefinitive($id){
        $taxes=Taxe::find($id);

        if($taxes->amount==0){
            $code = TaxesNumber::generateNumberTaxes('PSP' . "89");
            $taxes->code=$code;
            $taxes->status='verified';
            $taxes->update();
            $ciuTaxes=CiuTaxes::where('taxe_id',$taxes->id)->get();
            $subject = "PLANILLA DE PAGO";
            $for = \Auth::user()->email;



            $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
                'taxes' => $taxes,
                'ciuTaxes' => $ciuTaxes,
                'firm'=>true
            ]);

            Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {
                $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                $msj->subject($subject);
                $msj->to($for);
                $msj->attachData($pdf->output(), time() . 'PLANILLA_VERIFICADA.pdf');
            });

            return redirect('payments/history/' . session('company'))->with('message', 'La declaración fue registra con éxito,se le envio al correo ' . \Auth::user()->email . ' su pago verificado.');

        }



        return view('modules.acteco-definitive.payments',['taxes_id'=>$taxes->id]);
    }





    //PDF DE DEFINITIVA
    public function definitivePDF($id){
        $taxes=Taxe::find($id);
        $ciuTaxes=CiuTaxes::where('taxe_id',$taxes->id)->get();

        $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
            'taxes' => $taxes,
            'ciuTaxes' => $ciuTaxes,
            'firm'=>false
        ]);
        return $pdf->download('PLANILLA_DEFINITIVA.pdf');
    }



    //Calcular
    public function paymentDefinitiveStore(Request $request){
        $id_taxes=$request->input('id_taxes');
        $type_payment=$request->input('type_payment');
        $bank_payment=$request->input('bank_payment');
        $taxes = Taxe::findOrFail($id_taxes);
        $code = TaxesNumber::generateNumberTaxes($type_payment . "89");
        $taxes->code=$code;
        $code = substr($code, 3, 12);
        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));






        if($type_payment!='PPV'){

            if($type_payment=='PPE'){
                $taxes->bank=$bank_payment;
                $amount=round($taxes->amount,0);
                $taxes->amount=$amount;
                $taxes->digit = TaxesNumber::generateNumberSecret($amount, $date_format, $bank_payment, $code);

            }else{
                $taxes->bank=$bank_payment;
                $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank_payment, $code);
            }
        }

        $taxes->status="process";
        $taxes->update();


        $ciuTaxes=CiuTaxes::where('taxe_id',$taxes->id)->get();

        $subject = "PLANILLA DE PAGO";
        $for = \Auth::user()->email;

        $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
                'taxes' => $taxes,
                'ciuTaxes' => $ciuTaxes,
                'firm'=>false
            ]);


        Mail::send('mails.payment-payroll', ['type'=>'Declaración de Actividad Económica (DEFINITIVA)'], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("semat.alcaldia.iribarren@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
            $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });

        return redirect('payments/history/' . session('company'))->with('message', 'La planilla fue registra con éxito,fue enviado al correo ' . \Auth::user()->email . ',recuerda que esta planilla es valida solo por el dia ' . $date_format);
    }









    /*foreach($taxes->taxesCiu as $ciu){
        if($ciu->pivot->base == 0){
            $monto+=($ciu->min_tribu_men * $ciu->pivot->unid_tribu)+$ciu->pivot->mora;
        }
        else{
            $monto+=($ciu->alicuota * $ciu->pivot->base/100)+$ciu->pivot->mora;

        }
      return view('modules.payments.help',array(
        'taxes'=>$taxes,
        'id'=>$id,
        'monto'=>$monto
    ));
    }*/


    // public function getQR($id) {
    //     $taxes=Taxe::findOrFail($id);
    //     return view();
    // }


}
