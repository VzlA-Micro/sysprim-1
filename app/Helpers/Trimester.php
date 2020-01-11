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

        $dateCurrent = Carbon::now()->format('Y-m-d');
        $monthCurrent = Carbon::now()->format('m');
        $yearCurrent= Carbon::now()->format('Y');
        $DayTrimester=Carbon::now();

        $trimesterCurrent = 0;
        $trimesterBegin = 0;
        $trimesterEnd = 0;

        if ($monthCurrent >= 1 and $monthCurrent <= 3) {
            $trimesterCurrent = 1;
            $trimesterBegin = '01'.'-'.$yearCurrent;
            $trimesterEnd = '03'.'-'.$yearCurrent;
            $DayTrimester->day(1);
            $DayTrimester->month(1);
            $DayTrimester->year($yearCurrent);
        }
        if ($monthCurrent >= 4 and $monthCurrent <= 6) {
            $trimesterCurrent = 2;
            $trimesterBegin = '04'.'-'.$yearCurrent;
            $trimesterEnd = '06'.'-'.$yearCurrent;
            $DayTrimester->day(1);
            $DayTrimester->month(4);
            $DayTrimester->year($yearCurrent);
        }
        if ($monthCurrent >= 7 and $monthCurrent <= 9) {
            $trimesterCurrent = 3;
            $trimesterBegin = '07'.'-'.$yearCurrent;
            $trimesterEnd = '09'.'-'.$yearCurrent;
            $DayTrimester->day(1);
            $DayTrimester->month(7);
            $DayTrimester->year($yearCurrent);
        }
        if ($monthCurrent >= 10 and $monthCurrent <= 12) {
            $trimesterCurrent = 4;
            $trimesterBegin = '10'.'-'.$yearCurrent;
            $trimesterEnd = '12'.'-'.$yearCurrent;
            $DayTrimester->day(1);
            $DayTrimester->month(10);
            $DayTrimester->year($yearCurrent);
        }
        return array(
            'trimesterCurrent' => $trimesterCurrent,
            'trimesterBegin' => $trimesterBegin,
            'trimesterEnd' => $trimesterEnd,
            'Daytrimester' => $DayTrimester
        );
    }
}