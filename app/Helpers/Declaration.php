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
use App\Inmueble;
use App\CatastralConstruccion;
use App\CatastralTerreno;
use App\Val_cat_const_inmu;
use App\Tributo;
use TijsVerkoyen\CssToInlineStyles\Css\Property\Property;


class Declaration
{
    public static function VerifyDeclaration($id)
    {
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $dateCurrent = Carbon::now()->format('Y-m-d');
        $dayCurrent = Carbon::now()->format('d');
        $monthCurrent = Carbon::now()->format('m');
        $january = 01;
        $march = 03;

        $day=Carbon::now()->format('d');

        $mes=11;
        var_dump($id);

        if (($mes<=12 && $mes>=11) && ($day>=01 && $day<=31) ){
        //if (($monthCurrent <= $march && $monthCurrent >= $january) && ($dayCurrent >= 01 and $dayCurrent <= 31)) {
            $property =Inmueble::where('id', $id)->get();

            $buildProperty = Val_cat_const_inmu::where('property_id', $property[0]->id)->get();

            $cadastralBuild = CatastralConstruccion::where('id', $buildProperty[0]->value_catas_const_id)->get();

            $cadastralGround = CatastralTerreno::where('id', $property[0]->value_cadastral_ground_id)->get();

            $tributo = Tributo::all();

            if ($property[0]->area_ground !== 0) {

                $totalGround = $property[0]->area_ground * $cadastralGround[0]->value_terreno_vacio * $tributo[0]->value;


            } else {
                $totalGround=0;
            }
            if ($property[0]->area_build !== 0) {
                $baseImponibleForBuild = $property[0]->area_build * $cadastralGround[0]->value_terreno_construccion * $tributo[0]->value;
                $valueBuild = $cadastralBuild[0]->value_edificacion * $tributo[0]->value;
                $totalBuild = $baseImponibleForBuild + $valueBuild;
                var_dump($totalBuild);
            } else {
                $totalBuild = 0;
            }

            $declaration=$totalGround+$totalBuild;
        } else {
            $declaration=false;
        }

        return $declaration;
    }
}