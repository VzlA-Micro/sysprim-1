<?php

namespace App\Http\Controllers;

use App\Company;
use App\Notification;
use Illuminate\Http\Request;
use App\Helpers\TaxesNumber;
use App\Taxe;
use Illuminate\Support\Facades\DB;
use Alert;
use App\Helpers\TaxesMonth;
class CompanyTaxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        if(isset($users[0]->id)&&$users[0]->id!=\Auth::user()->id){//si la empresa le pertenece a quien coloco la ruta
            return redirect('companies/my-business');
        }else{
            //mientras tanto
            $notifications=Notification::where('user_id',\Auth::user()->id)->get();

            return view('modules.taxes.register',['company'=>$company_find,'notifications'=>$notifications,"date"=>$date]);
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
        for ($i=0;$i<count($ciu_id);$i++){
            $taxe->taxesCiu()->attach(['taxe_id'=>$id],['ciu_id'=>$ciu_id[$i],'base'=>$base[$i],'deductions'=>$deductions[$i],'withholding'=>$withholding[$i],'fiscal_credits'=>$fiscal_credits[$i]]);
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

        $date=TaxesMonth::verify($company[0]->id,false);




        return view('modules.taxes.details',['taxes'=>$taxes]);
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
        $pdf = \PDF::loadView('modules.taxes.receipt',['id'=>$id]);
        return $pdf->stream();
    }

    // public function getQR($id) {
    //     $taxes=Taxe::findOrFail($id);
    //     return view();
    // }
}
