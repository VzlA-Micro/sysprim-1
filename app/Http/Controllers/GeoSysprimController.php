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



        $taxes=Taxe::where('status','verified')->whereDate('created','=',  $date_now)->get();


        if(!$taxes->isEmpty()){
            foreach ($taxes as $taxe){
                    $company_find[]=$taxe->companies[0];
            }
        }else{
            $company_find=null;
        }


        return response()->json(['taxes'=>$taxes,'company'=>$company_find]);
    }


    public function findCompanyProcess(){

        $taxes=Taxe::where('status','process')->whereDate('created_at','=',Carbon::now()->format('Y-m-d'))->get();

        if(!$taxes->isEmpty()){
            foreach ($taxes as $taxe){
                $company_find[]=$taxe->companies[0];
            }
        }else{
            $company_find=null;
        }


        return response()->json(['taxes'=>$taxes,'company'=>$company_find]);
    }



}
