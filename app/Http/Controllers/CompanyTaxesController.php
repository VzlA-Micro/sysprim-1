<?php

namespace App\Http\Controllers;

use App\Ciu;
use App\Company;
use App\Extras;
use App\Notification;
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


    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $taxes=Taxe::all();
    }


    public function history($company){


        $company=Company::where('name',$company)->get();
        $taxes=Taxe::where('company_id',$company[0]->id)
            ->where('status','verified')->orWhere('status','process')->where('company_id',$company[0]->id)
            ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->get();

        return view('modules.payments.history',['taxes'=>$taxes]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create($company){
        $company=Company::where('name',$company)->get();
        $company_find=Company::find($company[0]->id);

        $date=TaxesMonth::verify($company[0]->id,false);
        $users=$company_find->users()->get();
        $taxes=Taxe::where('company_id',$company[0]->id)->orderBy('id', 'desc')->take(1)->get();


        if(isset($users[0]->id)&&$users[0]->id!=\Auth::user()->id){//si la empresa le pertenece a quien coloco la ruta
            return redirect('companies/my-business');
        }else{
            return view('modules.taxes.register',['company'=>$company_find,"date"=>$date]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        /*
        $ciu=$request->input('ciu');
        $base=$request->input('base');
        $dedutions=$request->input('deductions');
        $withholding=$request->input('withholding');
        $fiscal_credits=$request->input('fiscal_credits');
       */

        $fiscal_period=$request->input('fiscal_period');




        $company=$request->input('company_id');
    
        $company_find=Company::find($company);

        $ciu_id=$request->input('ciu_id');
        $min_tribu_men=$request->input('min_tribu_men');
        $deductions=$request->input('deductions');
        $withholding=$request->input('withholding');
        $base=$request->input('base');
        $fiscal_credits=$request->input('fiscal_credits');
        $taxe=new Taxe();
        $taxe->code=TaxesNumber::generateNumberTaxes('TEM');
        $taxe->fiscal_period=$fiscal_period;

        $taxe->company_id=$company;
        $taxe->save();
        $id=DB::getPdo()->lastInsertId();
        $unid_tribu=Tributo::orderBy('id', 'desc')->take(1)->get();
        $date=TaxesMonth::verify($company,false);

        for ($i=0;$i<count($base);$i++){
            //format a base
            $base_format=str_replace('.','',$base[$i]);
            $base_format=str_replace(',','.',$base_format);
            //format a deductions
            $deductions_format=str_replace('.','',$deductions[$i]);
            $deductions_format=str_replace(',','.',$deductions_format);
            //format withdolding
            $withholding_format=str_replace('.','',$withholding[$i]);

            $withholding_format=str_replace(',','.',$withholding_format);
            //format fiscal credits
            $fiscal_credits_format=str_replace('.','',$fiscal_credits[$i]);
            $fiscal_credits_format=str_replace(',','.',$fiscal_credits_format);
            $ciu=Ciu::find($ciu_id[$i]);

            if($base[$i]==0){
                $taxes=$ciu->min_tribu_men*$unid_tribu[0]->value;
                $unid_total=$unid_tribu[0]->value;
            }else{
                $taxes=$ciu->alicuota*$base_format/100;
                $unid_total=0;
            }

            if($date['mora']){//si tiene mora
                $extra=Extras::orderBy('id', 'desc')->take(1)->get();
                if($company_find->typeCompany==='R'){
                    $tax_rate=$taxes+(float)$withholding_format-(float)$deductions_format-(float)$fiscal_credits_format;
                }else{
                    $tax_rate=$taxes-$withholding_format-(float)-(float)$deductions_format-(float)$fiscal_credits_format;
                }

                $tax_rate=$tax_rate*$extra[0]->tax_rate/100;
                $interest=(0.42648/360)*$date['diffDayMora']*($tax_rate+$taxes);
                $mora=0;
            }else{
                $mora=0;
                $tax_rate=0;
                $interest=0;
            }



            $taxe->taxesCiu()->attach(['taxe_id'=>$id],
                ['ciu_id'=>$ciu_id[$i],
                'base'=>$base_format,'deductions'=>$deductions_format,'withholding'=>$withholding_format,
                'fiscal_credits'=>$fiscal_credits_format,'unid_tribu'=>$unid_total, 'mora'=>$mora,
                'tax_rate'=>$tax_rate,
                'interest'=>$interest
            ]);



        }
        $data = array([
            'status' => 'success',
            'message' => 'Impuesto registrada correctamente.'
        ]);
        return redirect('payments/taxes/'.$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $amountInterest=0;//total de intereses
        $amountRecargo=0;//total de recargos
        $amountCiiu=0;//total de ciiu
        $amountDesc=0;//Descuento
        $amountTaxes=0;//total a de impuesto
        $amountTotal=0;


        $taxes=Taxe::findOrFail($id);
        $ciuTaxes=CiuTaxes::where('taxe_id',$id)->get();
        $company_find=Company::find($taxes->company_id);
        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $mora=Extras::orderBy('id', 'desc')->take(1)->get();
        $extra=['tasa'=>$mora[0]->tax_rate];


        foreach ($ciuTaxes as $ciu){
                $amountInterest+=$ciu->interest;
                $amountRecargo+=$ciu->tax_rate;


                if($company_find->TypeCompany==='R'){
                    $amountCiiu+=$ciu->totalCiiu+$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits;
                }else{

                    $amountCiiu+=$ciu->totalCiiu-$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits;

                }
        }





        $amountTaxes=$amountInterest+$amountRecargo+$amountCiiu;//Total



        $amount=['amountInterest'=>$amountInterest,
            'amountRecargo'=>$amountRecargo,
            'amountCiiu'=>$amountCiiu,
            'amountTotal'=>$amountTaxes,
            'amountDesc'=>$amountDesc
            ];


        return view('modules.taxes.details',
            [   'taxes'=>$taxes,
                'fiscal_period'=> $fiscal_period,
                'extra'=>$extra,
                'ciuTaxes'=>$ciuTaxes,
                'amount'=>$amount
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPDF($id){
        $amountInterest=0;//total de intereses
        $amountRecargo=0;//total de recargos
        $amountCiiu=0;//total de ciiu
        $amountDesc=0;//Descuento
        $amountTaxes=0;//total a de impuesto
        $amountTotal=0;


        $taxes=Taxe::findOrFail($id);
        $ciuTaxes=CiuTaxes::where('taxe_id',$id)->get();
        $company_find=Company::find($taxes->company_id);
        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $mora=Extras::orderBy('id', 'desc')->take(1)->get();
        $extra=['tasa'=>$mora[0]->tax_rate];


        foreach ($ciuTaxes as $ciu){
            $amountInterest+=$ciu->interest;
            $amountRecargo+=$ciu->tax_rate;

            if($company_find->TypeCompany==='R'){
                $amountCiiu+=$ciu->totalCiiu+$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits;
            }else{
                $amountCiiu+=$ciu->totalCiiu-$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits;
            }
        }

        $amountTaxes=$amountInterest+$amountRecargo+$amountCiiu;//Total


        //si tiene descuento
        /*if($company_find->desc){
            $employees = Employees::all();
            foreach ($employees as $employee){
                if ($company_find->number_employees >= $employee->min) {
                    if ($company_find->number_employees <= $employee->max) {
                        $amountDesc=$amountTaxes*$employee->value/100;

                    }
                }
            }

            $amountTaxes=$amountTaxes-$amountDesc;//descuento
        }
        */





        $amount=['amountInterest'=>$amountInterest,
            'amountRecargo'=>$amountRecargo,
            'amountCiiu'=>$amountCiiu,
            'amountTotal'=>$amountTaxes,
        ];


        $pdf = \PDF::loadView('modules.taxes.receipt',[
            'taxes'=>$taxes,
            'fiscal_period'=>$fiscal_period,
            'extra'=>$extra,
            'ciuTaxes'=>$ciuTaxes,
            'amount'=>$amount,
            'firm'=>false
            ]);


        return $pdf->download('recibo.pdf');
    }

    public function paymentsHelp(Request $request){
        $amountInterest=0;//total de intereses
        $amountRecargo=0;//total de recargos
        $amountCiiu=0;//total de ciiu
        $amountDesc=0;//Descuento
        $amountTaxes=0;//total a de impuesto
        $amountTotal=0;



        $id = $request->input('taxes_id');
        $amount = $request->input('total');

        $bank = $request->input('bank');
        $payments_type = $request->input('payments');

        $payments_type=strtoupper($payments_type);
        if($payments_type==='PPV'){
            $bank="66";
        }
        $amount_format = str_replace('.', '', $amount);
        $amount_format = str_replace(',', '.', $amount_format);
        $taxes = Taxe::findOrFail($id);
        $taxes->amount = $amount_format;
        $code = TaxesNumber::generateNumberTaxes($payments_type."81");


        $taxes->code = $code;
        $taxes->bank = $bank;
        $taxes->status = 'process';
        $taxes->branch='Act.Eco';
        $code = substr($code, 3, 12);


        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));
        $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank, $code);

        $taxes->update();

        $taxes=Taxe::findOrFail($id);
        $ciuTaxes=CiuTaxes::where('taxe_id',$taxes->id)->get();


        $company_find=Company::find($taxes->company_id);
        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $mora=Extras::orderBy('id', 'desc')->take(1)->get();
        $extra=['tasa'=>$mora[0]->tax_rate];

        foreach ($ciuTaxes as $ciu){
            $amountInterest+=$ciu->interest;
            $amountRecargo+=$ciu->tax_rate;

            if($company_find->TypeCompany==='R'){
                $amountCiiu+=$ciu->totalCiiu+$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits;
            }else{
                $amountCiiu+=$ciu->totalCiiu-$ciu->withholding-$ciu->fiscal_credits-$ciu->dedutions;
            }
        }

        $amountTaxes=$amountInterest+$amountRecargo+$amountCiiu;//Total

        //si tiene descuento
        /*if($company_find->desc){
            $employees = Employees::all();
            foreach ($employees as $employee){
                if ($company_find->number_employees >= $employee->min) {
                    if ($company_find->number_employees <= $employee->max) {
                        $amountDesc=$amountTaxes*$employee->value/100;

                    }
                }
            }

            $amountTaxes=$amountTaxes-$amountDesc;//descuento
        }*/

        $amount=['amountInterest'=>$amountInterest,
            'amountRecargo'=>$amountRecargo,
            'amountCiiu'=>$amountCiiu,
            'amountTotal'=>$amountTaxes,
            'amountDesc'=>$amountDesc
        ];



        $subject = "PLANILLA DE PAGO";
        $for = \Auth::user()->email;
        $pdf = \PDF::loadView('modules.taxes.receipt',['taxes'=>$taxes,'fiscal_period'=>$fiscal_period,'extra'=>$extra, 'ciuTaxes'=>$ciuTaxes,
            'amount'=>$amount,'firm'=>false
        ]);



        Mail::send('mails.payment-payroll', [], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("grabieldiaz63@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
            $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });
        return redirect('payments/history/' . session('company'))->with('message', 'La planilla fue registra con éxito,fue enviado al correo ' . \Auth::user()->email . ',recuerda que esta planilla es valida solo por el dia ' . $date_format);

    }





    public function calculate($id){
        $taxes=Taxe::findOrFail($id);
        $taxes->delete();
        return redirect('payments/create/'.session('company'));

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

    public function getCarnet() {
        $pdf = \PDF::loadView('modules.companies.carnet');
        return $pdf->stream();
    }
}
