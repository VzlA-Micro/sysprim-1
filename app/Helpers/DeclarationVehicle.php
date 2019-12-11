<?php
/**
 * Created by PhpStorm.
 * User: Sistemas
 * Date: 11/7/2019
 * Time: 8:25 a.m.
 */

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Notification;
use Illuminate\Support\Carbon;
use App\Payments;
use App\Vehicle;
use App\VehicleType;
use App\ModelsVehicle;
use App\UserVehicle;
use App\Tributo;

class DeclarationVehicle
{
    public static function Declaration($id)
    {
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $dateCurrent = Carbon::now()->format('Y-m-d');
        $yearCurrent = Carbon::now()->format('Y');
        $monthCurrent = Carbon::now()->format('m');
        $january = 01;
        $mes = 12;
        $taxes=0;
        $rateYear=0;
        $discount=0;
        $valueDiscount=0;
        $rate=Tributo::orderBy('id', 'desc')->take(1)->get();

        //$day = Carbon::now()->format('d');

        if ($monthCurrent ==$mes){
            $vehicle = Vehicle::where('id', $id)->get();
            $yearVehicle=$vehicle[0]->model->year;

            $diffYear=$yearCurrent-$yearVehicle;

            if ($diffYear <3){
                $rateYear=$vehicle[0]->type->rate;
                $taxes=$rateYear*$rate[0]->value;
                $valueDiscount=($taxes*20)/100;
                $discount=$taxes-$valueDiscount;
            }else{
                $rateYear=$vehicle[0]->type->rate_UT;
                $taxes=$rateYear*$rate[0]->value;
                $valueDiscount=($taxes*20)/100;
                $discount=$taxes-$valueDiscount;
            }
        }
        $amounts = array(
            'taxes' => $taxes,
            'valueDiscount' => $valueDiscount,
            'discount' => $discount,
            'rateYear'=>$rateYear
        );

        return $amounts;
    }
}