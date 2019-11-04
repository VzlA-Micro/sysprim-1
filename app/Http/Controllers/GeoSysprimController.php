<?php

namespace App\Http\Controllers;

use App\Helpers\TaxesMonth;
use App\Company;
use App\Payments;
use App\Taxe;
use Carbon\Carbon;
use Illuminate\Http\Request;
class GeoSysprimController extends Controller{

    public function home(){

        return view('modules.geosysprim.home');
    }

    public function findCompanySolvent(){
        $date_now=Carbon::now();

        $date_now->subMonth(1);

        $mounth=$date_now->format('m');

        $taxes=Taxe::where('status','verified')->whereMonth('fiscal_period','=',$mounth)->get();

        foreach ($taxes as $taxe){
                $company_find[]=$taxe->companies;
        }
        return response()->json(['taxes'=>$taxes,'company'=>$company_find]);
    }


    public function findCompanyProcess(){
        $date_now=Carbon::now();

        $taxes=Taxe::where('status','process')->where('created_at','=',$date_now)->get();

        foreach ($taxes as $taxe){
            $company_find[]=$taxe->companies;
        }

        return response()->json(['taxes'=>$taxes,'company'=>$company_find]);
    }



}
