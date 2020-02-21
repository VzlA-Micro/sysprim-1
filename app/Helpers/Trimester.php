<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Notification;
use Illuminate\Support\Carbon;

class Trimester
{
    public static function verifyTrimester()
    {
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local

        $dateCurrent = Carbon::now();
        $monthCurrent = Carbon::now()->format('m');
        $yearCurrent = Carbon::now()->format('Y');
        $monthBegin = Carbon::now();
        $monthIntermediate = Carbon::now();
        $monthEnd = Carbon::now();

        $trimesterCurrent = 0;
        $trimesterBegin = 0;
        $trimesterEnd = 0;


        if ($monthCurrent >= 1 and $monthCurrent <= 3) {
            $trimesterCurrent = 1;
            $trimesterBegin = '01' . '-' . $yearCurrent;
            $trimesterEnd = '03' . '-' . $yearCurrent;
            $monthBegin->day(1);
            $monthBegin->month(1);
            $monthBegin->year($yearCurrent);
            $monthIntermediate->day(1);
            $monthIntermediate->month(2);
            $monthIntermediate->year($yearCurrent);
            $monthEnd->day(1);
            $monthEnd->month(3);
            $monthEnd->year($yearCurrent);
        }
        if ($monthCurrent >= 4 and $monthCurrent <= 6) {
            $trimesterCurrent = 2;
            $trimesterBegin = '04' . '-' . $yearCurrent;
            $trimesterEnd = '06' . '-' . $yearCurrent;
            $monthBegin->day(1);
            $monthBegin->month(4);
            $monthBegin->year($yearCurrent);
            $monthIntermediate->day(1);
            $monthIntermediate->month(5);
            $monthIntermediate->year($yearCurrent);
            $monthEnd->day(1);
            $monthEnd->month(6);
            $monthEnd->year($yearCurrent);
        }
        if ($monthCurrent >= 7 and $monthCurrent <= 9) {
            $trimesterCurrent = 3;
            $trimesterBegin = '07' . '-' . $yearCurrent;
            $trimesterEnd = '09' . '-' . $yearCurrent;
            $monthBegin->day(1);
            $monthBegin->month(7);
            $monthBegin->year($yearCurrent);
            $monthIntermediate->day(1);
            $monthIntermediate->month(8);
            $monthIntermediate->year($yearCurrent);
            $monthEnd->day(1);
            $monthEnd->month(9);
            $monthEnd->year($yearCurrent);
        }
        if ($monthCurrent >= 10 and $monthCurrent <= 12) {
            $trimesterCurrent = 4;
            $trimesterBegin = '10' . '-' . $yearCurrent;
            $trimesterEnd = '12' . '-' . $yearCurrent;
            $monthBegin->day(1);
            $monthBegin->month(10);
            $monthBegin->year($yearCurrent);
            $monthIntermediate->day(1);
            $monthIntermediate->month(11);
            $monthIntermediate->year($yearCurrent);
            $monthEnd->day(1);
            $monthEnd->month(12);
            $monthEnd->year($yearCurrent);
        }
        return array(
            'trimesterCurrent' => $trimesterCurrent,
            'trimesterBegin' => $trimesterBegin,
            'trimesterEnd' => $trimesterEnd,
            'monthBegin' => $monthBegin,
            'monthIntermediate' => $monthIntermediate,
            'monthEnd' => $monthEnd,
            'current' => $dateCurrent
        );
    }

    public static function yearPayment($year)
    {
        $periodInit = Carbon::parse("01-01-" . $year);
        $periodFinal = Carbon::parse("31-12-" . $year);

        return array(
            'periodInit' => $periodInit,
            'periodFinal' => $periodFinal
        );
    }



}