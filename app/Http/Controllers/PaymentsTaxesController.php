<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentTaxes;
use App\Ciu;
use App\Company;
use App\Taxe;
use App\CiuTaxes;

class PaymentsTaxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id=$request->id;
        $company=Company::where('name',session('company'))->get();
        $company_find=Company::find($company[0]->id);
        $taxes=Taxe::findOrFail($id);
        $ciuTaxes=CiuTaxes::findOrFail($taxes->id);

        $ciu=Ciu::findOrFail($ciuTaxes->ciu_id);

        if($ciuTaxes->base == 0){
            $monto=$ciu->min_tribu_men * $ciuTaxes->unid_tribu;
        }
        else{
            $monto=$ciu->alicuota * $ciuTaxes->base/100;
        }

        return view('modules.payments.register',array(
            'taxes'=>$taxes,
            'id'=>$id,
            'monto'=>$monto
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $pTaxes= new PaymentTaxes();
        $pTaxes->payments_type= $request->input('type');
        $pTaxes->code_ref= $request->input('code_ref');
        $pTaxes->bank= $request->input('bank');
        $pTaxes->amount= $request->input('amount');
        $pTaxes->status="process";
        $pTaxes->taxe_id= $request->input('taxes');
        $pTaxes->save();

        return redirect('payments/history/'.session('company'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paymentTaxe= PaymentTaxes::findOrFail($id);
        return view('dev.updatePayments',array(
            '$payment'=>$paymentTaxe
        ));
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
}
