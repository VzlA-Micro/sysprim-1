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
use Illuminate\Support\Facades\DB;
use Alert;
use App\Helpers\TaxesMonth;
use Illuminate\Support\Facades\Session;
use App\CiuTaxes;
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
        $taxes=Taxe::where('company_id',$company[0]->id)->get();
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
            if(!is_null($date)&&isset($taxes[0]->fiscal_period)&&$taxes[0]->fiscal_period===$date['fiscal_period']){
                Session::flash('message','ACTIVIDAD ECONOMICA DECLARADAS POR FAVOR CONCILIE SUS PAGOS.');
                return view('modules.taxes.register',['company'=>$company_find,"date"=>$date]);
            }else{
                return view('modules.taxes.register',['company'=>$company_find,"date"=>$date]);
            }
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
        $taxe->code=TaxesNumber::generateNumber();
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

            if($date['mora']){//si tiene mora
                $extra=Extras::orderBy('id', 'desc')->take(1)->get();
                $mora=$extra[0]->mora*$unid_tribu[0]->value;
                $ciu=Ciu::find($ciu_id[$i]);
                $taxes=$ciu->alicuota*$base_format/100;

                $tax_rate=$taxes-(float)$deductions[$i]-(float)$withholding[$i]-(float)$fiscal_credits[$i];

                $tax_rate=$tax_rate*$extra[0]->tax_rate/100;
                $interest=(0.42648/360)*($tax_rate+$taxes);
            }else{
                $mora=0;
                $tax_rate=0;
                $interest=0;

            }

            if($base[$i]==0){
                    $unid_total=$unid_tribu[0]->value;
            }else{
                    $unid_total=0;
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
        $taxes=Taxe::findOrFail($id);
        $company=Company::where('name',session('company'))->get();
        $company_find=Company::find($company[0]->id);
        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $unid_tribu=Tributo::orderBy('id', 'desc')->take(1)->get();
        $mora=Extras::orderBy('id', 'desc')->take(1)->get();
        $extra=['mora'=>$mora[0]->mora,'tasa'=>$mora[0]->tax_rate,'unid_tribu'=>$unid_tribu[0]->value];


        return view('modules.taxes.details',['taxes'=>$taxes,'fiscal_period'=>$fiscal_period,'extra'=>$extra]);
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
        $taxes=Taxe::findOrFail($id);
        $company=Company::where('name',session('company'))->get();
        $company_find=Company::find($company[0]->id);
        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $unid_tribu=Tributo::orderBy('id', 'desc')->take(1)->get();
        $mora=Extras::orderBy('id', 'desc')->take(1)->get();
        $extra=['mora'=>$mora[0]->mora,'tasa'=>$mora[0]->tax_rate,'unid_tribu'=>$unid_tribu[0]->value];
        $pdf = \PDF::loadView('modules.taxes.receipt',['taxes'=>$taxes,'fiscal_period'=>$fiscal_period,'extra'=>$extra]);
        return $pdf->stream();
    }

    public function paymentsHelp(Request $request){
        $id=$request->id;
        $company=Company::where('name',session('company'))->get();
        $company_find=Company::find($company[0]->id);
        $taxes=Taxe::findOrFail($id);
        $monto=0;

        foreach($taxes->taxesCiu as $ciu){
            if($ciu->pivot->base == 0){
                $monto+=($ciu->min_tribu_men * $ciu->pivot->unid_tribu)+$ciu->pivot->mora;
            }
            else{
                $monto+=($ciu->alicuota * $ciu->pivot->base/100)+$ciu->pivot->mora;

            }
        }


        return view('modules.payments.help',array(
            'taxes'=>$taxes,
            'id'=>$id,
            'monto'=>$monto
        ));
    }
    // public function getQR($id) {
    //     $taxes=Taxe::findOrFail($id);
    //     return view();
    // }
}
