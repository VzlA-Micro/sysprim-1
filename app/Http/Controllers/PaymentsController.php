<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
class PaymentsController extends Controller{
    public function menuPayments($company)
    {
        session(['company' => $company]);
        $company = Company::where('name', $company)->get();
        $company_find = Company::find($company[0]->id);

        if ($company_find->status !== 'disabled') {
            return view('modules.payments.menu');
        } else {
            return redirect('companies/details/' . $company_find->id);
        }

    }

}
