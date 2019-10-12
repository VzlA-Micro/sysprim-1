<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\FineCompany;
use App\Fine;
use App\PaymentFines;

class PaymentsFinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function __construct(){
        $this->middleware('auth');
    }*/

    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id=Company::where('name',$request->company)->select('id')->get();

        $finesCompany=FineCompany::findOrFail($id);

        $fines=Fine::findOrFail($finesCompany[0]->fine_id);

        $company=Company::findOrFail($finesCompany[0]->company_id);

        $monto=$finesCompany[0]->unid_tribu_value*$fines->cant_unid_tribu;

        return view('dev.finesPayments.register',array(
            'finesCompany'=>$finesCompany,
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
        $pFines= new PaymentFines();
        $pFines->payments_type= $request->input('type');
        $pFines->code_ref= $request->input('code_ref');
        $pFines->bank= $request->input('bank');
        $pFines->amount= $request->input('amount');
        $pFines->status="process";
        $pFines->fine_company_id= $request->input('idFinesCompany');
        $pFines->save();

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
