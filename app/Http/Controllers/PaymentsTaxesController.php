<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentsTaxes;

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
        return view('modules.payments.register',array(
            'id'=>$id
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
        $pTaxes= new PaymentsTaxes();
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
        $paymentTaxe= PaymentsTaxes::findOrFail($id);
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
