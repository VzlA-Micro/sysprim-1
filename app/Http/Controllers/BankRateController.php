<?php

namespace App\Http\Controllers;

use App\BankRate;
use Illuminate\Http\Request;


class BankRateController extends Controller{




    public function manage() {
        return view('modules.bank-rate.manage');
    }

    public function create() {
        return view('modules.bank-rate.register');
    }

    public function store(Request $request) {
        $BankRate = new BankRate();
        $BankRate->value_rate = $request->input('value');
        $BankRate->save();
        return response()->json(['status'=>'success',$request->input('value')]);
    }

    public function show() {
        $BankRate = BankRate::orderBy('id','desc')->get();
        return view('modules.bank-rate.read', ['BankRates' => $BankRate]);
    }

    public function details($id) {

    }

    public function update(Request $request) {
    }

    public function destroy() {

    }



}
