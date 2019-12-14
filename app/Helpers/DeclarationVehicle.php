<?php
/**
 * Created by PhpStorm.
 * User: Sistemas
 * Date: 11/7/2019
 * Time: 8:25 a.m.
 */

namespace App\Helpers;

use App\VehiclesTaxe;
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
        $monthJanuary = Carbon::create(2018, 1, 30, 12, 00, 00)->format('m');
        $january = 01;
        $april = 04;
        $july = 07;
        $october = 10;
        $mes = 12;
        $taxes = 0;
        $rateYear = 0;
        $discount = 0;
        $valueDiscount = 0;
        $rate = Tributo::orderBy('id', 'desc')->take(1)->get();
        $moreThereYear = null;

        //$day = Carbon::now()->format('d');
        $array = explode('-', $id);
        $idVehicle = $array[0];
        session_start();
        if (isset($array[1])) {
            $optionPayment = $array[1];
            $_SESSION['optionPayment'] = $optionPayment;
        } else {
            $optionPayment = $_SESSION['optionPayment'];
        }

        $vehicle = Vehicle::where('id', $id)->get();
        $yearVehicle = $vehicle[0]->model->year;

        $diffYear = $yearCurrent - $yearVehicle;

        if ($diffYear < 3) {
            $rateYear = $vehicle[0]->type->rate;
            $taxes = $rateYear * $rate[0]->value;
            //$valueDiscount = ($taxes * 20) / 100;
            //$discount = $taxes - $valueDiscount;
            $moreThereYear = false;
        } else {
            $rateYear = $vehicle[0]->type->rate_UT;
            $taxes = $rateYear * $rate[0]->value;
            //$valueDiscount = ($taxes * 20) / 100;
            //$discount = $taxes - $valueDiscount;
            $moreThereYear = true;
        }

        //--------------option of payments-------------------------
        if ($optionPayment == 'true') {

            if (($monthCurrent == $mes)) {
                $valueDiscount = ($taxes * 20) / 100;
                $discount = $taxes - $valueDiscount;

                $amounts = array(
                    'taxes' => $taxes,
                    'valueDiscount' => $valueDiscount,
                    'discount' => $discount,
                    'rateYear' => $rateYear,
                    'moreThereYear' => $moreThereYear,
                    'optionPayment' => $optionPayment
                );
                return $amounts;
            }

        } else {
            $fractionalPayments = $taxes / 4;
            if (($monthCurrent == $january) || ($monthCurrent == $april) || ($monthCurrent == $july) || ($monthCurrent == $october)) {
                $amounts = array(
                    'taxes' => $taxes,
                    'fractionalPayments' => $fractionalPayments,
                    'rateYear' => $rateYear,
                    'moreThereYear' => $moreThereYear,
                    'optionPayment' => $optionPayment
                );

                return $amounts;
            } else {
                $vehicleTaxes = VehiclesTaxe::where('id', $vehicle[0]->id)->orderBy('id', 'desc')->take(1)->get();
                if (!isset($vehicleTaxes[0])) {
                    $diffMonths = round($monthCurrent / 3);
                    if ($diffMonths > 1 and $diffMonths < 1.5) {
                        $diffMonths = 2;
                    }
                    if ($diffMonths > 2 and $diffMonths < 2.5) {
                        $diffMonths = 3;
                    }
                    if ($diffMonths > 3 and $diffMonths < 3.5) {
                        $diffMonths = 4;
                    }
                    $recharge = (($fractionalPayments * $diffMonths) * 20) / 100;
                    $previousDebt = ($fractionalPayments * ($diffMonths - 1));
                    $total =$fractionalPayments  + $recharge;

                } else {
                    $diffMonths = round(($monthCurrent - $vehicleTaxes->created_at->format('m') / 3));
                    if ($diffMonths > 1 and $diffMonths < 1.5) {
                        $diffMonths = 2;
                    }
                    if ($diffMonths > 2 and $diffMonths < 2.5) {
                        $diffMonths = 3;
                    }
                    if ($diffMonths > 3 and $diffMonths < 3.5) {
                        $diffMonths = 4;
                    }
                    $recharge = (($fractionalPayments * $diffMonths) * 20) / 100;
                    $previousDebt = ($fractionalPayments * ($diffMonths - 1));
                    $total = $fractionalPayments + $recharge;
                }
                $amounts = array(
                    'taxes' => $taxes,
                    'fractionalPayments' => $fractionalPayments,
                    'recharge' => $recharge,
                    'previousDebt' => $previousDebt,
                    'total' => $total,
                    'rateYear' => $rateYear,
                    'moreThereYear' => $moreThereYear,
                    'optionPayment' => $optionPayment
                );

                return $amounts;
            }
        }
    }
}