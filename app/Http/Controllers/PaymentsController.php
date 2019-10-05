<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentsController extends Controller{
    public function menuPayments($company){
        session(['company' => $company]);
        return view('modules.payments.menu');
    }


}
