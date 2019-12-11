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


    public function CompanyRegistered(){
        $company=Company::all();
        return response()->json(['company'=>$company]);

    }
    public function findCompanySolvent(){
        $date_now=Carbon::now();

        $mounth=$date_now->format('m');
        $taxes=Taxe::where('status','verified')->whereMonth('created_at','=',$mounth)->get();

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

    public function CompanyProcessVerified(){
        $date_now=Carbon::now();


        $mounth=$date_now->format('m');
        $taxes_process=Taxe::where('status','process')->whereDate('created_at','=',Carbon::now()->format('Y-m-d'))->get();


        if(!$taxes_process->isEmpty()){
            foreach ($taxes_process as $taxe){
                $company_process[]=$taxe->companies[0];
            }
        }else{
            $company_process=null;
        }


        $taxes=Taxe::where('status','verified')->whereMonth('created_at','=',$mounth)->get();


        if(!$taxes->isEmpty()){
            foreach ($taxes as $taxe){
                $company_verified[]=$taxe->companies[0];
            }
        }else{
            $company_verified=null;
        }

        return response()->json(['company_process'=>$company_process,'company_verified'=>$company_verified]);
    }



}
