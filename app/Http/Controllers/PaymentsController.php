<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
class PaymentsController extends Controller{
    public function menuPayments($company)
    {

        $company_find = Company::find(session('company')->id);

        if ($company_find->status !== 'disabled'&&substr($company_find->license,0,2)!='SL') {
            return view('modules.payments.menu');
        } else {
            if(substr($company_find->license,0,2)=='SL'){
                return redirect('companies/details/' . $company_find->id)->with(['message'=>'Para reliazar una declaración, La empresa '.$company_find->name .' debe poseer una licencia  valida.']);
            }else{
                return redirect('companies/details/' . $company_find->id);
            }

        }

    }

}
