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


    }
}