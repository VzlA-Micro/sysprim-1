<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentTaxes;
use App\Ciu;
use App\Company;
use App\Taxe;
use App\CiuTaxes;
use App\Employees;
use Illuminate\Support\Facades\App;

class PaymentsTaxesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $id = $request->id;
        $company = Company::where('name', session('company'))->get();

        $company_find = Company::find($company[0]->id);

        $taxes = Taxe::findOrFail($id);

        $ciuTaxes = CiuTaxes::findOrFail($taxes->id);

        $employees = Employees::all();

        $count = count($employees);

        $ciu = Ciu::findOrFail($ciuTaxes->ciu_id);

        $rebaja = 0;

        for ($i = 0; $i < $count; $i++) {
            if ($company_find->number_employees >= $employees[$i]->min) {
                if ($company_find->number_employees <= $employees[$i]->max) {
                    $rebaja = $employees[$i]->value;
                }
            }
        }

        if ($ciuTaxes->base == 0) {
            $base = $ciu->min_tribu_men * $ciuTaxes->unid_tribu / 100;
            $rebaja_employees = $base * $rebaja / 100;
            $monto = $base - $rebaja_employees;
        } else {
            $base = $ciu->alicuota * $ciuTaxes->base / 100;
            $rebaja_employees = $base * $rebaja / 100;
            $monto = $base - $rebaja_employees;
        }

        return view('modules.payments.register', array(
            'taxes' => $taxes,
            'id' => $id,
            'monto' => $monto
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //

        $pTaxes = new PaymentTaxes();
        $pTaxes->payments_type = $request->input('type');
        $pTaxes->code_ref = $request->input('code_ref');
        $pTaxes->bank = $request->input('bank');
        $pTaxes->amount = $request->input('amount');
        $pTaxes->status = "process";
        $pTaxes->taxe_id = $request->input('taxes');
        $pTaxes->name_deposito = $request->input('name');
        $pTaxes->surname_deposito = $request->input('surname');
        $pTaxes->cedula = $request->input('cedula');
        $pTaxes->date_transference = $request->input('date_transference');
        $file = $request->file('files');
        
        if ($file) {
            
            $filePath = time() . $file->getClientOriginalName();
            \Storage::disk('payments')->put($filePath, \File::get($file));
            $pTaxes->file = $filePath;
        }


        $pTaxes= new PaymentTaxes();
        $pTaxes->payments_type= $request->input('type');
        $pTaxes->code_ref= $request->input('code_ref');
        $pTaxes->bank= $request->input('bank');

        $amount_format=str_replace('.','',$request->input('amount'));
        $amount_format=str_replace(',','.',$amount_format);
        $pTaxes->amount=$amount_format;
        $pTaxes->status="process";
        $pTaxes->taxe_id= $request->input('taxes');
        $pTaxes->save();

        return redirect('payments/history/' . session('company'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $paymentTaxe = PaymentTaxes::findOrFail($id);
        return view('dev.updatePayments', array(
            '$payment' => $paymentTaxe
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
