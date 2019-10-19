<?php

namespace App\Http\Controllers;

use App\Helpers\TaxesMonth;
use App\Company;
use App\PaymentTaxes;
use Illuminate\Http\Request;
class GeoSysprimController extends Controller{

    public function home(){

        return view('modules.geosysprim.home');
    }

    public function findCompanySolvent(){
        $companies=Company::all();
        foreach ($companies as $company){
            $verified=TaxesMonth::verify($company->id,false);
            if(is_null($verified)) {
                $company_find[]=$company;
                $taxes[]=$company->taxesCompanies->last();
            }
        }
        return response()->json(['taxes'=>$taxes,'company'=>$company_find]);
    }
}
