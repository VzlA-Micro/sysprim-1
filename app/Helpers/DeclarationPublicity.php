<?php
/**
 * Created by PhpStorm.
 * User: User invitado
 * Date: 18/1/2020
 * Time: 10:55
 */

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Publicity;
use App\AdvertisingType;
use App\Tributo;
use App\BankRate;
use App\Taxe;
use Carbon\Carbon;


class DeclarationPublicity
{
    public static function Declarate($id) {
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $currentDate = Carbon::now();
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $taxUnit = Tributo::orderBy('id', 'desc')->take(1)->get();
        $bankRate = BankRate::select('value_rate')->latest()->first();

//        $advertisingTypes = AdvertisingType::all();
//        $interest = 0;
//        $baseImponible = 0;
        $daysDiff = 0;
        $publicity = Publicity::find($id);
        $type = $publicity->advertising_type_id;
        $taxUnitPrice = Tributo::orderBy('id', 'desc')->take(1)->get();
//        dd($taxUnitPrice);
        if($type == 1) { // Si es publicidad Eventual
            $dateStart = Carbon::parse($publicity->date_start);
            $dateEnd = Carbon::parse($publicity->date_end);
            $daysDiff = $dateEnd->diffInDays($dateStart); // Calcula la cantidad de dias que tendra la publicidad
            if($daysDiff == 0) {
                $daysDiff = 1;
            }
            $linealMeters = $publicity->width + $publicity->height; // Calcula los metros lineales (Se suman)
            $baseImponible = $taxUnitPrice[0]->value * ((($linealMeters * $publicity->advertisingType->value) * $daysDiff) * $publicity->quantity); // Calcula la Base Imponible a paga
//            dd($baseImponible);
        }
        elseif($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7 || $type == 12 || $type == 14) {
            if($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6) {
                if($publicity->quantity <= 500) {
                    $baseImponible = $taxUnitPrice[0]->value * $publicity->advertisingType->value;
                }
                else {
                    // Dividir la cantidad actual entre la cantidad de la ordenanza para tomar el valor y multiplicarlo por el valor de UT
                    $valueByQuantity = $publicity->quantity / 500;
                    $value = round($valueByQuantity, PHP_ROUND_HALF_UP); // Redondea el valor al entero mayor mas cercano
                    $baseImponible = $taxUnitPrice[0]->value * ($publicity->advertisingType->value * $value); //
                }
            }
            /*elseif($type == 6) {
                if($publicity->quantity <= 500) {
                    $baseImponible = $taxUnitPrice[0]->value * $publicity->advertisingType->value;
                }
                else {
                    // Dividir la cantidad actual entre la cantidad de la ordenanza para tomar el valor y multiplicarlo por el valor de UT
                    $valueByQuantity = $publicity->quantity / 500;
                    $value = round($valueByQuantity, PHP_ROUND_HALF_UP); // Redondea el valor al entero mayor mas cercano
                    $baseImponible = $taxUnitPrice[0]->value * $publicity->advertisingType->value * $value; //
                }
            }*/
            elseif($type == 7 || $type == 12 || $type == 14) {
                $baseImponible = $taxUnitPrice[0]->value * ($publicity->advertisingType->value * $publicity->quantity);
            }
//            dd($baseImponible);
        }
        elseif ($type == 8 || $type == 9 || $type == 13) {
            $dateStart = Carbon::parse($publicity->date_start);
            $dateEnd = Carbon::parse($publicity->date_end);
            $daysDiff = $dateEnd->diffInDays($dateStart); // Calcula la cantidad de dias que tendra la publicidad
            if($daysDiff == 0) {
                $daysDiff = 1;
            }
            $baseImponible = $taxUnitPrice[0]->value * ($daysDiff * $publicity->advertisingType->value);
//            dd($baseImponible);

        }
        elseif ($type == 10 || $type == 11 || $type == 16 || $type == 18 || $type == 19) {
            $squareMeters = $publicity->width * $publicity->height;
            if($squareMeters == 0) {
                $squareMeters = 1;
            }
            $baseImponible = $taxUnitPrice[0]->value * ($squareMeters * $publicity->advertisingType->value);
//            dd($baseImponible);

        }
        elseif ($type == 17 || $type == 20) {
            $squareMeters = $publicity->width * $publicity->height;
            if($squareMeters == 0) {
                $squareMeters = 1;
            }
            $squareMeters_UT = ($squareMeters * $publicity->advertisingType->value);
            if($type == 17) {
                $baseImponible = $taxUnitPrice[0]->value * ($squareMeters_UT * $publicity->side) + ($squareMeters_UT * $publicity->floor);
            }
            else {
                $baseImponible = $taxUnitPrice[0]->value * (($squareMeters_UT * $publicity->side) + ($squareMeters_UT * $publicity->floor) * $publicity->quantity);

            }
//            dd($baseImponible);

        }
        if($publicity->state_location == 'SI') {
            $increment = $taxUnitPrice[0]->value * 5000;
        }
        elseif($publicity->licor == 'SI') {
            $increment = $taxUnitPrice[0]->value * 5000;
        }
        elseif($publicity->licor == 'SI' && $publicity->state_location == 'SI') {
            $increment = $taxUnitPrice[0]->value * (5000 * 2);
        }
        else {
            $increment = 0;
        }
        $total = $baseImponible + $increment;
//        $increment = 0;

        // Retornar datos
        $amounts = array(
            'baseImponible' => $baseImponible,
            'daysDiff' => $daysDiff,
            'total' => $total,
            'increment' => $increment
        );
        return $amounts;
    }
}