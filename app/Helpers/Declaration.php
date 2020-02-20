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
use Carbon\Carbon;
use App\Payments;
use App\Inmueble;
use App\CatastralConstruccion;
use App\CatastralTerreno;
use App\Val_cat_const_inmu;
use App\Tributo;
use App\Alicuota;
use App\Property;
use App\Recharge;
use App\Helpers\CheckCollectionDay;
use App\BankRate;


class Declaration
{
    /**
     * @param $id
     * @param $status
     * @param null $fiscal_period
     */
    public static function VerifyDeclaration($id, $status, $fiscal_period = null)
    {
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $currentDate = Carbon::now();

        $dayCurrent = Carbon::now()->format('d');
        $monthCurrent = Carbon::now()->format('m');
        $january = 01;
        $currentFiscalPeriodStart = '2019-01-01';
        $currentFiscalPeriodEnd = '2020-01-01';
//        if (is_null($fiscal_period)){
//            $fiscalPeriod = Carbon::parse($fiscal_period);
//        }
        $fiscalPeriod = Carbon::parse($fiscal_period);


        $taxUnitPrice = Tributo::whereDate('to','>=',$fiscalPeriod)->whereDate('since','<=',$fiscalPeriod)->get();
        if (is_null($taxUnitPrice)){
            $taxUnitPrice = Tributo::orderBy('id', 'desc')->take(1)->get();
        }
//        dd($taxUnitPrice);

//        dd($fiscal_period);
//        var_dump($currentDate->month);

        if($currentDate->year == $fiscalPeriod->year) {
            if (intVal($currentDate->month) == 01) {
                $recharge = 0;
                $interest = 0;
                $descuento = 0.20;
                $property = Property::where('id', $id)->get();
                $alicuota = Alicuota::where('id', $property[0]->type_inmueble_id)->get();
                $buildProperty = Val_cat_const_inmu::where('property_id', $property[0]->id)->get();
                $cadastralBuild = CatastralConstruccion::where('id', $buildProperty[0]->value_catas_const_id)->get();
                $cadastralGround = CatastralTerreno::where('id', $property[0]->value_cadastral_ground_id)->get();
//                $taxUnitPrice = Tributo::orderBy('id', 'desc')->take(1)->get();

                if ($property[0]->area_ground !== 0) {
                    $totalground = $property[0]->area_ground * $cadastralGround[0]->value_terreno_vacio * $taxUnitPrice[0]->value;
                }
                else {
                    $totalground = 0;
                }
                if ($property[0]->area_build !== 0) {
                    $baseImponibleForBuild = $property[0]->area_build * $cadastralGround[0]->value_terreno_construccion * $taxUnitPrice[0]->value;
                    $valueBuild = $cadastralBuild[0]->value_edificacion * $taxUnitPrice[0]->value;
                    $totalbuild = $baseImponibleForBuild + $valueBuild;
                }
                else {
                    $totalbuild = 0;
                }
                $baseImponible = $totalground + $totalbuild; // Base imponible bruta

                if ($status == 'full') {
                    $discount = $baseImponible * $descuento; // Descuento
                } else {
                    $discount = $baseImponible * 0;
                }
//
                $porcentaje = $baseImponible * $alicuota[0]->value; // Valor de alicuota
                $total = ($baseImponible + $porcentaje) - $discount; // Total del impuesto
            }
            elseif(intVal($currentDate->month) == 02 || intVal($currentDate->month) == 03) {
                $recharge = 0;
                $interest = 0;
                $property = Property::where('id', $id)->get();
                $alicuota = Alicuota::where('id', $property[0]->type_inmueble_id)->get();
                $buildProperty = Val_cat_const_inmu::where('property_id', $property[0]->id)->get();
                $cadastralBuild = CatastralConstruccion::where('id', $buildProperty[0]->value_catas_const_id)->get();
                $cadastralGround = CatastralTerreno::where('id', $property[0]->value_cadastral_ground_id)->get();
//                $taxUnitPrice = Tributo::orderBy('id', 'desc')->take(1)->get();

                if ($property[0]->area_ground !== 0) {
                    $totalground = $property[0]->area_ground * $cadastralGround[0]->value_terreno_vacio * $taxUnitPrice[0]->value;
                }
                else {
                    $totalground = 0;
                }
                if ($property[0]->area_build !== 0) {
                    $baseImponibleForBuild = $property[0]->area_build * $cadastralGround[0]->value_terreno_construccion * $taxUnitPrice[0]->value;
                    $valueBuild = $cadastralBuild[0]->value_edificacion * $taxUnitPrice[0]->value;
                    $totalbuild = $baseImponibleForBuild + $valueBuild;
                }
                else {
                    $totalbuild = 0;
                }
                $baseImponible = $totalground + $totalbuild; // Base imponible bruta
                $discount = 0;
                $porcentaje = $baseImponible * $alicuota[0]->value; // Valor de alicuota
                $total = ($baseImponible + $porcentaje) - $discount; // Total del impuesto
            }
            else {
//                $taxUnitPrice = Tributo::orderBy('id', 'desc')->take(1)->get();
                $discount = 0;

                $property = Property::where('id', $id)->get();
                $alicuota = Alicuota::where('id', $property[0]->type_inmueble_id)->get();
                $buildProperty = Val_cat_const_inmu::where('property_id', $property[0]->id)->get();
                $cadastralBuild = CatastralConstruccion::where('id', $buildProperty[0]->value_catas_const_id)->get();
                $cadastralGround = CatastralTerreno::where('id', $property[0]->value_cadastral_ground_id)->get();

                $verifyPrologue = CheckCollectionDay::verify('Inm.Urbanos');
                if ($property[0]->area_ground !== 0) {
                    $totalground = $property[0]->area_ground * $cadastralGround[0]->value_terreno_vacio * $taxUnitPrice[0]->value;
//                $totalGround = number_format($totalground, 2,',','.');
                } else {
                    $totalground = 0;
                }
                if ($property[0]->area_build !== 0) {
                    $baseImponibleForBuild = $property[0]->area_build * $cadastralGround[0]->value_terreno_construccion * $taxUnitPrice[0]->value;
                    $valueBuild = $cadastralBuild[0]->value_edificacion * $taxUnitPrice[0]->value;
                    $totalbuild = $baseImponibleForBuild + $valueBuild;
//                $totalBuild=number_format($totalbuild,2,',','.');

                } else {
                    $totalbuild = 0;
                }
                $baseImponible = $totalground + $totalbuild; // Base imponible bruta
//            $base = $totalground + $totalbuild;
                if ($verifyPrologue['mora']) { // Verifica si hay dias de mora
                    $recargo = Recharge::where('branch', 'Inm.Urbanos')->whereDate('to', '>=', $currentFiscalPeriodStart)->whereDate('since', '<=', $currentFiscalPeriodEnd)->first();
//                dd($recargo);
                    $bankInterest = BankRate::orderBy('id', 'desc')->take(1)->first();
                    $recharge = ($recargo->value * $baseImponible) / 100;
                    $interestCalc = (($bankInterest->value_rate / 100) / 360) * $verifyPrologue['diffDayMora'] * ($recharge + $baseImponible);
                    $interest = round($interestCalc, 2);
                } else {
                    $recharge = 0;
                    $interest = 0;
                }
                $porcentaje = $baseImponible * $alicuota[0]->value;
                $total = $baseImponible + $porcentaje + $interest + $recharge;
            }
        }
        else { // SI el periodo fiscal es diferente del año actual
            $taxUnitPrice = Tributo::orderBy('id', 'desc')->take(1)->get();
//            $recargo = Recharge::where('branch', 'Inmuebles Urb.')->get();
            $discount = 0;

            $property = Property::where('id', $id)->get();
            $alicuota = Alicuota::where('id', $property[0]->type_inmueble_id)->get();
            $buildProperty = Val_cat_const_inmu::where('property_id', $property[0]->id)->get();
            $cadastralBuild = CatastralConstruccion::where('id', $buildProperty[0]->value_catas_const_id)->get();
            $cadastralGround = CatastralTerreno::where('id', $property[0]->value_cadastral_ground_id)->get();
//            $propertyTaxe = $property->propertyTaxes(); dd($propertyTaxe);

            $verifyPrologue = CheckCollectionDay::verify('Inm.Urbanos', $fiscal_period);
//
//            dd($verifyPrologue);
            if ($property[0]->area_ground !== 0) {
                $totalground = $property[0]->area_ground * $cadastralGround[0]->value_terreno_vacio * $taxUnitPrice[0]->value;
//                $totalGround = number_format($totalground, 2,',','.');
            } else {
                $totalground = 0;
            }
            if ($property[0]->area_build !== 0) {
                $baseImponibleForBuild = $property[0]->area_build * $cadastralGround[0]->value_terreno_construccion * $taxUnitPrice[0]->value;
                $valueBuild = $cadastralBuild[0]->value_edificacion * $taxUnitPrice[0]->value;
                $totalbuild = $baseImponibleForBuild + $valueBuild;
//                $totalBuild=number_format($totalbuild,2,',','.');

            } else {
                $totalbuild = 0;
            }
            $baseImponible = $totalground + $totalbuild; // Base imponible bruta
//            $base = $totalground + $totalbuild;
            if ($verifyPrologue['mora']) { // Verifica si hay dias de mora
                $recargo = Recharge::where('branch', 'Inm.Urbanos')->whereDate('to', '>=', $currentFiscalPeriodStart)->whereDate('since', '<=', $currentFiscalPeriodEnd)->first();
//                dd($recargo);
                $bankInterest = BankRate::orderBy('id', 'desc')->take(1)->first();
                $recharge = ($recargo->value * $baseImponible) / 100;
                $interestCalc = (($bankInterest->value_rate / 100) / 360) * $verifyPrologue['diffDayMora'] * ($recharge + $baseImponible);
                $interest = round($interestCalc, 2);
//                dd($num);
            } else {
                $recharge = 0;
                $interest = 0;
            }
//            $recharge = $base * $recargo->value;
            $porcentaje = $baseImponible * $alicuota[0]->value;
            $total = $baseImponible + $porcentaje + $interest + $recharge;
        }

        $amounts = array(
            'baseImponible' => $baseImponible,
            'porcentaje' => $porcentaje,
            'alicuota' => $alicuota[0],
            'totalGround' => $totalground,
            'totalBuild' => $totalbuild,
            'recharge' => $recharge,
            'interest' => $interest,
            'discount' => $discount,
            'total' => $total,
//              'mora' => $verifyPrologue
        );
        return $amounts;
    }
}
