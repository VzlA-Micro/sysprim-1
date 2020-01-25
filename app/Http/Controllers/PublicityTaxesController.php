<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publicity;
use App\PublicityTaxe; 
use App\AdvertisingType;
use Carbon\Carbon;
use App\Tributo;

class PublicityTaxesController extends Controller
{
    public function index($id)
    {
        $publicity = Publicity::find($id);
        return view('modules.publicity-payments.manage', ['publicity' => $publicity]);
    }

    public function create($id) {
    	$advertisingTypes = AdvertisingType::all();
    	$publicity = Publicity::find($id);
        $type = $publicity->advertising_type_id;
//        $taxUnitPrice = Tributo::orderBy('id', 'desc')->take(1)->get();
    	if($type == 1) { // Si es publicidad Eventual
    		$dateStart = Carbon::parse($publicity->date_start);
    		$dateEnd = Carbon::parse($publicity->date_end);
    		$daysDiff = $dateEnd->diffInDays($dateStart); // Calcula la cantidad de dias que tendra la publicidad
    		$linealMeters = $publicity->width + $publicity->height; // Calcula los metros lineales (Se suman)
    		$baseCalculated = (($linealMeters * $publicity->advertisingType->value) * $daysDiff); // Calcula la Base Imponible a pagar
            $base = number_format($baseCalculated, 2, ',', '.');
    	}
    	elseif($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7 || $type == 12 || $type == 14) {
    	    if($type == 2 || $type == 3 || $type == 4 || $type == 5) {
    	        if($publicity->quantity <= 1000) {
                    $baseCalculated = $taxUnitPrice * $publicity->advertisingType->value;
                }
                else {
                    // Dividir la cantidad actual entre la cantidad de la ordenanza para tomar el valor y multiplicarlo por el valor de UT
    	            $valueByQuantity = $publicity->quantity / 1000;
    	            $value = round($valueByQuantity, PHP_ROUND_HALF_UP); // Redondea el valor al entero mayor mas cercano
                    $baseCalculated = ($publicity->advertisingType->value * $value); //
                }
            }
            elseif($type == 6) {
                if($publicity->quantity <= 500) {
                    $baseCalculated = $publicity->advertisingType->value;
                }
                else {
                    // Dividir la cantidad actual entre la cantidad de la ordenanza para tomar el valor y multiplicarlo por el valor de UT
                    $valueByQuantity = $publicity->quantity / 500;
                    $value = round($valueByQuantity, PHP_ROUND_HALF_UP); // Redondea el valor al entero mayor mas cercano
                    $baseCalculated = $publicity->advertisingType->value * $value; //
                }
            }
            elseif($type == 7 || $type == 12 || $type == 14) {
                $baseCalculated = $publicity->advertisingType->value * $publicity->quantity;
            }
            $base = number_format($baseCalculated, 2, ',', '.');
        }
    	elseif ($type == 8 || $type == 9 || $type == 13) {
            $dateStart = Carbon::parse($publicity->date_start);
            $dateEnd = Carbon::parse($publicity->date_end);
            $daysDiff = $dateEnd->diffInDays($dateStart); // Calcula la cantidad de dias que tendra la publicidad
            $baseCalculated = ($daysDiff * $publicity->advertisingType->value);
            $base = number_format($baseCalculated, 2, ',', '.');
        }
        elseif ($type == 10 || $type == 11 || $type == 16 || $type == 18 || $type == 19) {
    	    $squareMeters = $publicity->width * $publicity->height;
    	    $baseCalculated  = ($squareMeters * $publicity->advertisingType->value);
            $base = number_format($baseCalculated, 2, ',', '.');
        }
        elseif ($type == 17 || $type == 20) {
            $squareMeters = $publicity->width * $publicity->height;
            $squareMeters_UT = ($squareMeters * $publicity->advertisingType->value);
            $baseCalculated = ($squareMeters_UT * $publicity->side) + ($squareMeters_UT * $publicity->floor);
            $base = number_format($baseCalculated, 2, ',', '.');
        }
//        $total = number_format($base, 2, ',', '.');

    	return view('modules.publicity-payments.register', [
    		'advertisingTypes' => $advertisingTypes,
    		'publicity' => $publicity,
            'base' => $base,
//            'total' => $total
    	]);
    }
}
