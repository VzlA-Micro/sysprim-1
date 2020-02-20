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
use App\TimelineAlicuota;
use App\TimelineCatastralBuild;
use App\TimelineCatastralTerrain;
//////////////////////////////////////////////////////////
///
///       Hacer o acomodar valores de la unidad tributaria, filtrar por fechas, tomar la uniodad tributaria actual


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
        $fiscalPeriod = Carbon::parse($fiscal_period);

        $taxUnitPrice = Tributo::whereDate('to', '>=', $fiscalPeriod)->whereDate('since', '<=', $fiscalPeriod)->first();

        if (is_null($taxUnitPrice)) {
            $taxUnitPrice = Tributo::orderBy('id', 'desc')->take(1)->first();
        }

        $property = Property::where('id', $id)->first();
        $alicuota = Alicuota::where('id', $property->type_inmueble_id)->first();
//                $buildProperty = Val_cat_const_inmu::where('property_id', $property->id)->first();
        $cadastralBuild = CatastralConstruccion::where('id', $property->value_cadastral_build_id)->first();
        $cadastralGround = CatastralTerreno::where('id', $property->value_cadastral_ground_id)->first();
        //// Obteniendo valores de los timelines
        $timelineAlicuota = TimelineAlicuota::where('alicuota_inmueble_id',$alicuota->id)->whereYear('since', '<=', $fiscalPeriod->format('Y'))->whereYear('to', '>=', $fiscalPeriod->format('Y'))->first();
        if (is_null($timelineAlicuota)) {
            $timelineAlicuota = TimelineAlicuota::where('alicuota_inmueble_id',$alicuota->id)->orderBy('id', 'desc')->take(1)->first();
        }

        $timelineCatastralBuild = TimelineCatastralBuild::where('value_catastral_construccion_id',$cadastralBuild->id)->whereYear('since', '<=', $fiscalPeriod->format('Y'))->whereYear('to', '>=', $fiscalPeriod->format('Y'))->first();
        if (is_null($timelineCatastralBuild)) {
            $timelineCatastralBuild = TimelineCatastralBuild::where('value_catastral_construccion_id',$cadastralBuild->id)->orderBy('id', 'desc')->take(1)->first();
        }

        $timelineCatastralTerrain = TimelineCatastralTerrain::where('value_catastral_terreno_id',$cadastralGround->id)->whereYear('since', '<=', $fiscalPeriod->format('Y'))->whereYear('to', '>=', $fiscalPeriod->format('Y'))->first();
        if (is_null($timelineCatastralTerrain)) {
            $timelineCatastralTerrain = TimelineCatastralTerrain::where('value_catastral_terreno_id',$cadastralGround->id)->orderBy('id', 'desc')->take(1)->first();
        }
        ////////////////////////////////////////////////////

//        $timelineAlicuota = TimelineAlicuota::where('ciu_id',$ciu->id)->whereYear('since', '<=', $fiscal_period_format->format('Y'))->whereYear('to', '>=', $fiscal_period_format->format('Y'))->first();

        /*if (is_null($timeline_ciu)) {
            $timeline_ciu = TimelineCiiu::where('ciu_id',$ciu->id)->orderBy('id', 'desc')->take(1)->first();
        }*/

        if($currentDate->year == $fiscalPeriod->year) {
            if (intVal($currentDate->month) == 01) {
                $recharge = 0;
                $interest = 0;
                $descuento = 0.20;
                /*$property = Property::where('id', $id)->first();
                $alicuota = Alicuota::where('id', $property->type_inmueble_id)->first();
//                $buildProperty = Val_cat_const_inmu::where('property_id', $property->id)->first();
                $cadastralBuild = CatastralConstruccion::where('id', $property->value_cadastral_build_id)->first();
                $cadastralGround = CatastralTerreno::where('id', $property->value_cadastral_ground_id)->first();
//                $taxUnitPrice = Tributo::orderBy('id', 'desc')->take(1)->first();*/

                if ($property->area_ground !== 0) {
                    $totalground = ($property->area_ground * $cadastralBuild->timelineValue[0]->value) * $taxUnitPrice->value;
//                    $totalground = $property[0]->area_ground * $cadastralGround[0]->value_terreno_vacio * $taxUnitPrice[0]->value;
                }
                else {
                    $totalground = 0;
                }
                if ($property->area_build !== 0) {
                    $baseImponibleForBuild = ($property->area_build * $cadastralGround->timelineValue[0]->value_built_terrain) * $taxUnitPrice->value;
                    $valueBuild = $cadastralBuild->timelineValue[0]->value * $taxUnitPrice->value;
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
                $porcentaje = $baseImponible * $alicuota[0]->value; // Valor de alicuota
                $total = ($baseImponible + $porcentaje) - $discount; // Total del impuesto
            }
            elseif(intVal($currentDate->month) == 02 || intVal($currentDate->month) == 03) {
                $recharge = 0;
                $interest = 0;



                if ($property->area_ground !== 0) {
                    $totalground = ($property->area_ground * $timelineCatastralBuild->value) * $taxUnitPrice->value;
//                    $totalground = $property[0]->area_ground * $cadastralGround[0]->value_terreno_vacio * $taxUnitPrice[0]->value;
                }
                else {
                    $totalground = 0;
                }
                if ($property->area_build !== 0) {
                    $baseImponibleForBuild = ($property->area_build * $timelineCatastralTerrain->value_built_terrain) * $taxUnitPrice->value;
                    $valueBuild = $cadastralBuild->timelineValue[0]->value * $taxUnitPrice->value;
                    $totalbuild = $baseImponibleForBuild + $valueBuild;
                }
                else {
                    $totalbuild = 0;
                }
                $baseImponible = $totalground + $totalbuild; // Base imponible bruta
                $discount = 0;
                $porcentaje = $baseImponible * $timelineAlicuota->value; // Valor de alicuota
                $total = ($baseImponible + $porcentaje) - $discount; // Total del impuesto
            }
            else {
                $discount = 0;

                /*$property = Property::where('id', $id)->first();
                $alicuota = Alicuota::where('id', $property->type_inmueble_id)->first();
//                $buildProperty = Val_cat_const_inmu::where('property_id', $property->id)->first();
                $cadastralBuild = CatastralConstruccion::where('id', $property->value_cadastral_build_id)->first();
                $cadastralGround = CatastralTerreno::where('id', $property->value_cadastral_ground_id)->first();
//                $taxUnitPrice = Tributo::orderBy('id', 'desc')->take(1)->first();*/
                $verifyPrologue = CheckCollectionDay::verify('Inm.Urbanos');

                if ($property->area_ground !== 0) {
                    $totalground = ($property->area_ground * $cadastralBuild->timelineValue[0]->value) * $taxUnitPrice->value;
//                    $totalground = $property[0]->area_ground * $cadastralGround[0]->value_terreno_vacio * $taxUnitPrice[0]->value;
                }
                else {
                    $totalground = 0;
                }
                if ($property->area_build !== 0) {
                    $baseImponibleForBuild = ($property->area_build * $cadastralGround->timelineValue[0]->value_built_terrain) * $taxUnitPrice->value;
                    $valueBuild = $cadastralBuild->timelineValue[0]->value * $taxUnitPrice->value;
                    $totalbuild = $baseImponibleForBuild + $valueBuild;
                }
                else {
                    $totalbuild = 0;
                }
                $baseImponible = $totalground + $totalbuild; // Base imponible bruta

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
//            $recargo = Recharge::where('branch', 'Inmuebles Urb.')->get();
            $discount = 0;
            /*$property = Property::where('id', $id)->first();
            $alicuota = Alicuota::where('id', $property->type_inmueble_id)->first();
//            $buildProperty = Val_cat_const_inmu::where('property_id', $property->id)->first();
            $cadastralBuild = CatastralConstruccion::where('id', $property->value_cadastral_build_id)->first();
            $cadastralGround = CatastralTerreno::where('id', $property->value_cadastral_ground_id)->first();
//            $propertyTaxe = $property->propertyTaxes(); dd($propertyTaxe);*/
            $verifyPrologue = CheckCollectionDay::verify('Inm.Urbanos', $fiscal_period);

            if ($property->area_ground !== 0) {
                $totalground = ($property->area_ground * $cadastralBuild->timelineValue[0]->value) * $taxUnitPrice->value;
//                    $totalground = $property[0]->area_ground * $cadastralGround[0]->value_terreno_vacio * $taxUnitPrice[0]->value;
            }
            else {
                $totalground = 0;
            }
            if ($property->area_build !== 0) {
                $baseImponibleForBuild = ($property->area_build * $cadastralGround->timelineValue[0]->value_built_terrain) * $taxUnitPrice->value;
                $valueBuild = $cadastralBuild->timelineValue[0]->value * $taxUnitPrice->value;
                $totalbuild = $baseImponibleForBuild + $valueBuild;
            }
            else {
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
//            $recharge = $base * $recargo->value;
            $porcentaje = $baseImponible * $alicuota->value;
            $total = $baseImponible + $porcentaje + $interest + $recharge;
        }

        $amounts = array(
            'baseImponible' => $baseImponible,
            'porcentaje' => $porcentaje,
            'alicuota' => $alicuota,
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
