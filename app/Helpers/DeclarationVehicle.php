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
use App\BankRate;
use App\Prologue;
use App\TimelineTypeVehicle;

class DeclarationVehicle
{
    public static function Declaration($id, $optionPayment, $year = null)
    {
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        if (is_null($year)) {
            $year = Carbon::now();
        }
        $dateCurrent = Carbon::now();
        $yearCurrent = Carbon::now()->format('Y');
        $monthCurrent = Carbon::now()->format('m');
        $monthJanuary = Carbon::create(2020, 01, 01, 12, 00, 00);
        $total = 0;
        $fractionalPayments = 0;
        $mes = 1;
        $taxes = 0;
        $rateYear = 0;
        $discount = 0;
        $previousDebt = 0;
        $valueDiscount = 0;
        $valueDayMora = 0;
        $recharge = 0;
        $prologue = Prologue::where('branch', 'Pat.Veh')->first();

        $fiscal_period_format = Carbon::parse($year);
        $rate = Tributo::whereDate('to', '>=', $fiscal_period_format)->whereDate('since', '<=', $fiscal_period_format)->first();

        $date = Carbon::parse($prologue->date_limit);
        if (is_null($rate)) {
            $rate = Tributo::orderBy('id', 'desc')->first();
        }

        //dd($rate);


        $moreThereYear = null;
        $bank = BankRate::select('value_rate')->latest()->first();
        $rateBank = $bank->value_rate;


        $recharges = Recharge::where('branch', 'Pat.Vehiculo')->latest()->first();
        $helperTrimester = Trimester::verifyTrimester();

        /*if ($monthCurrent >= 1 and $monthCurrent <= 3) {
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
        }*/

        $vehicle = Vehicle::where('id', $id)->get();

        $yearVehicle = $vehicle[0]->year;

        $diffYear = $yearCurrent - intval($yearVehicle);
//NO CAMBIAR LA LINEA DE ABAJO CON EL WHEREYEAR AUNQUE TE DE UN TIC EN EL OJO PARECE ESTAR MALO PERO FUNCIONA
        $since = TimelineTypeVehicle::where('type_vehicle_id', $vehicle[0]->type_vehicle_id)
            ->whereYear('since', '<=', (string)$year->format('Y'))
            ->whereYear('to', '>=', (string)$year->format('Y'))->first();

        if (is_null($since)) {
            $since = TimelineTypeVehicle::where('type_vehicle_id', $vehicle[0]->type_vehicle_id)
                ->orderBy('id', 'desc')->take(1)->first();
        }

        if ($diffYear < 3) {
            $rateYear = $since->rate;
            $taxes = $rateYear * $rate->value;
            $moreThereYear = false;
        } else {
            $rateYear = $since->rate_UT;
            $taxes = $rateYear * $rate->value;
            $moreThereYear = true;
        }

        if ($fiscal_period_format->year == $yearCurrent) {

            $day = CheckCollectionDay::verify('Pat.Veh');


            if ($dateCurrent->month <= $date->month) {


                if (($dateCurrent->day >= $date->day)&&$day['diffDayMora']>=1) {

                    $recharge = ($taxes * $recharges->value) / 100;

                    $dayMora = 0;
                    $valueDayMora = ($rateBank / 100 / 360) * ($day['diffDayMora'] + $dayMora) * ($taxes + $recharge);

                } else {
                    $dayMora = 0;
                    $valueDayMora = 0;
                    //$valueDayMora = ($rateBank / 100 / 360)*($day['diffDayMora']+$dayMora)*($taxes+$recharge);
                }
            } else {
                $recharge = ($taxes * $recharges->value) / 100;

                $valueDayMora = ($rateBank / 100 / 360) * ($day['diffDayMora']) * ($taxes + $recharge);
            }
        } else {
            $recharge = ($taxes * $recharges->value) / 100;
            $dayMora = 0;
            $day = DeclarationVehicle::dayMora($year);
            $valueDayMora = ($rateBank / 100 / 360) * ($day['diffDayMora'] + $dayMora) * ($taxes + $recharge);
        }

        //--------------option of payments-------------------------|||||||||||||||||||||||||||||||||
        if ($optionPayment) {
            //indica que el pago es anual

            if ($fiscal_period_format->year == $yearCurrent) {
                $day_prologue = CheckCollectionDay::verify('Pat.Veh');
            }else{
                $day_prologue =DeclarationVehicle::dayMora($year);
            }



            if (!$day_prologue['mora']) {
                $valueDiscount = ($taxes * 20) / 100;

                $total = ($taxes - $valueDiscount) + $valueDayMora;

            } else {
                //$valueDiscount = ($taxes * 20) / 100;

                $total = ($taxes - $valueDiscount) + $valueDayMora + $recharge;

            }
            $amounts = array(
                'grossTaxes' => $taxes,
                'fractionalPayments' => $fractionalPayments,
                'valueDiscount' => $valueDiscount,
                'total' => $total,
                'rateYear' => $rateYear,
                'recharge' => $recharge,
                'moreThereYear' => $moreThereYear,
                'optionPayment' => $optionPayment,
                'previousDebt' => $previousDebt,
                'valueMora' => $valueDayMora
            );
            return $amounts;
        }


        /*  }else {
            //INDICA QUE EL PAGO ES TRIMESTRAL, PERO SE DAN 2 CASOS
            // 1- ES PAGO TRIMESTRAL PERO ESTA DENTRO DEL PRIMER MES DE CADA TRIMESTRE POR LO TANTO NO TENDRA, NI RECARGOS, NI MULTAS
            $fractionalPayments = $taxes / 4;
            if (($monthCurrent == $january) || ($monthCurrent == $april) || ($monthCurrent == $july) || ($monthCurrent == $october)) {
                $total = $fractionalPayments*$valueDayMora;
                $amounts = array(
                    'taxes' => $taxes,
                    'fractionalPayments' => $fractionalPayments,
                    'total' => $total,
                    'rateYear' => $rateYear,
                    'moreThereYear' => $moreThereYear,
                    'optionPayment' => $optionPayment,
                    'valueMora' => $valueDayMora
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

                    $recharge = (($fractionalPayments * $diffMonths) * $recharges->value) / 100;

                    $previousDebt = ($fractionalPayments * ($diffMonths - 1));

                    $total = $fractionalPayments + $recharge + $previousDebt + $valueDayMora;

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

                    $recharge = (($fractionalPayments * $diffTrimester) * $recharges->value) / 100;
                    $previousDebt = ($fractionalPayments * $diffTrimester);

                    $total = ($fractionalPayments + $recharge + $previousDebt + $valueDayMora)*$valueDayMora;
                }
                $amounts = array(
                    'taxes' => $taxes,
                    'fractionalPayments' => $fractionalPayments,
                    'recharge' => $recharge,
                    'previousDebt' => $previousDebt,
                    'total' => $total,
                    'rateYear' => $rateYear,
                    'moreThereYear' => $moreThereYear,
                    'optionPayment' => $optionPayment,
                    'valueMora' => $valueDayMora
                );

                return $amounts;
            }
        }*/
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
            $vehicleTaxes = VehiclesTaxe::where('vehicle_id', $vehicle->id)
                ->where('status', '=', 'temporal')
                ->get();

            if (!$vehicleTaxes->isEmpty()) {
                foreach ($vehicleTaxes as $tax) {
                    if ($tax->status !== 'cancel') {
                        $taxe = Taxe::find($tax->taxe_id);
                        $taxe->delete();
                    }
                }
            }
        }
        return 0;
    }

    public static function dayMora($year)
    {
        $varDayForMora = CheckCollectionDay::verify('Pat.Veh', $year);
        return $varDayForMora;
    }
}