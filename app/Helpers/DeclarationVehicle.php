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
use App\Taxe;
use App\Recharge;
use App\Helpers\Trimester;

class DeclarationVehicle
{
    public static function Declaration($id)
    {
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $dateCurrent = Carbon::now();
        $yearCurrent = Carbon::now()->format('Y');
        $monthCurrent = Carbon::now()->format('m');
        $monthJanuary = Carbon::create(2018, 1, 30, 12, 00, 00)->format('m');
        $january = 01;
        $april = 04;
        $total = 0;
        $fractionalPayments = 0;
        $july = 07;
        $october = 10;
        $mes = 1;
        $taxes = 0;
        $rateYear = 0;
        $discount = 0;
        $previousDebt = 0;
        $valueDiscount = 0;
        $rate = Tributo::orderBy('id', 'desc')->take(1)->get();
        $moreThereYear = null;
        $recharges=Recharge::where('branch','Pat.Vehiculo')->latest()->first();
        $helperTrimester=Trimester::verifyTrimester();
        $diffDayMora=$dateCurrent->diffInDays($helperTrimester['Daytrimester']);
        //$day = Carbon::now()->format('d');
        $array = explode('-', $id);
        $idVehicle = $array[0];

        if ($monthCurrent >= 1 and $monthCurrent <= 3) {
            $trimesterCurrent = 1;
        }
        if ($monthCurrent >= 4 and $monthCurrent <= 6) {
            $trimesterCurrent = 2;
        }
        if ($monthCurrent >= 7 and $monthCurrent <= 9) {
            $trimesterCurrent = 3;
        }
        if ($monthCurrent >= 10 and $monthCurrent <= 12) {
            $trimesterCurrent = 4;
        }
        session_start();
        if (isset($array[1])) {
            $optionPayment = $array[1];
            $_SESSION['optionPayment'] = $optionPayment;
        } else {
            $optionPayment = $_SESSION['optionPayment'];
        }

        $vehicle = Vehicle::where('id', $id)->get();
        $yearVehicle = $vehicle[0]->year;

        $diffYear = $yearCurrent - intval($yearVehicle);

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
        if ($optionPayment) {
            //indica que el pago es anual

            if (($monthCurrent == $mes)) {
                $valueDiscount = ($taxes * 20) / 100;
                $total = $taxes - $valueDiscount;

                $amounts = array(
                    'grossTaxes' => $taxes,
                    'fractionalPayments' => $fractionalPayments,
                    'valueDiscount' => $valueDiscount,
                    'total' => $total,
                    'rateYear' => $rateYear,
                    'moreThereYear' => $moreThereYear,
                    'optionPayment' => $optionPayment,
                    'previousDebt' => $previousDebt
                );
                return $amounts;
            }

        } else {
            //INDICA QUE EL PAGO ES TRIMESTRAL, PERO SE DAN 2 CASOS
            // 1- ES PAGO TRIMESTRAL PERO ESTA DENTRO DEL PRIMER MES DE CADA TRIMESTRE POR LO TANTO NO TENDRA, NI RECARGOS, NI MULTAS
            $fractionalPayments = $taxes / 4;
            if (($monthCurrent == $january) || ($monthCurrent == $april) || ($monthCurrent == $july) || ($monthCurrent == $october)) {
                $total=$fractionalPayments;
                $amounts = array(
                    'taxes' => $taxes,
                    'fractionalPayments' => $fractionalPayments,
                    'total' => $total,
                    'rateYear' => $rateYear,
                    'moreThereYear' => $moreThereYear,
                    'optionPayment' => $optionPayment
                );

                return $amounts;

            // 2 - EN ESTE CASO ES SI, REALIZA EL PAGO DE FORMA TRIMESTRAL PERO,NO ESTA DENTRO DEL PRIMER MES DEL TRIMESTRE POR LO TANTO TENDRA UNA DEUDA Y UN RECARGO
            } else {
                $vehicleTaxes = VehiclesTaxe::where('vehicle_id', $vehicle[0]->id)->orderBy('id', 'desc')->take(1)->get();
                //AQUI SE VUELVEN A DAR 2 CASOS
                // 1 - ESTE CASO ES SI NO EXISTE NINGUN PAGO ANTERIOR DE ESTE VEHICULO
                if (!isset($vehicleTaxes[0]) || $vehicleTaxes[0]->status == 'Temporal') {
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
                    $recharge = (($fractionalPayments * $diffMonths) * $recharges) / 100;

                    $previousDebt = ($fractionalPayments * ($diffMonths - 1));

                    $total = $fractionalPayments + $recharge + $previousDebt;

                // 2 - ESTE CASO ES SI, HAY ALGUN REGISTRO CORESPONBDIENTE A ESTE VEHICULO
                } else {
                    //
                    $monthTaxes = intval($vehicleTaxes[0]->created_at->format('m'));


                    if ($monthTaxes >= 1 and $monthTaxes <= 3) {
                        $trimester = 1;
                    }
                    if ($monthTaxes >= 4 and $monthTaxes <= 6) {
                        $trimester = 2;
                    }
                    if ($monthTaxes >= 7 and $monthTaxes <= 9) {
                        $trimester = 3;
                    }
                    if ($monthTaxes >= 10 and $monthTaxes <= 12) {
                        $trimester = 4;
                    }

                    $diffTrimester = $trimesterCurrent - $trimester;


                    $recharge = (($fractionalPayments * $diffTrimester) * $recharges) / 100;
                    $previousDebt = ($fractionalPayments * $diffTrimester);

                    $total = $fractionalPayments + $recharge + $previousDebt;

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


    public static function verify($id, $temporal = true)
    {
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $date = null;
        $vehicle = Vehicle::find($id);
        $now_pay = Carbon::now();//fecha de pago
        $mount_pay = null;

        if ($temporal) {
            $vehicleTaxes = $vehicle->taxesVehicle()->where('status', '=', 'temporal')->get();//busco el ultimo pago realizado por la empresa

            if (!$vehicleTaxes->isEmpty()) {
                foreach ($vehicleTaxes as $tax) {
                    if ($tax->status !== 'cancel') {
                        $tax = Taxe::find($tax->id);
                        $tax->delete();
                    }
                }
            }
        }
    }
}