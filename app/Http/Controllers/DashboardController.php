<?php

namespace App\Http\Controllers;

use App\Imports\PaymentsImport;
use App\Inmueble;
use App\TimelineCiiu;
use App\TimelineTypeVehicle;
use App\Vehicle;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use Mail;
use App\Taxe;
use App\Company;
use App\Property;
use App\Extras;
use App\Tributo;
use App\Helpers\TaxesMonth;
use App\Http\Controllers\Controller;
use App\Payments;
use Carbon\Carbon;
use App\Employees;
use App\CiuTaxes;
use App\Rate;
use App\Helpers\Declaration;


class DashboardController extends Controller
{
    //

    public function collection()
    {
        $banesco = 0;
        $banco100 = 0;
        $bnc = 0;
        $bod = 0;
        $bicentenario = 0;
        $enero = 0;
        $febrero = 0;
        $marzo = 0;
        $abril = 0;
        $mayo = 0;
        $junio = 0;
        $julio = 0;
        $agosto = 0;
        $septiembre = 0;
        $octubre = 0;
        $noviembre = 0;
        $diciembre = 0;

        $year = Carbon::now()->format('Y');


        $bncEnero = 0;
        $bncFebrero = 0;
        $bncMarzo = 0;
        $bncAbril = 0;
        $bncMayo = 0;
        $bncJunio = 0;
        $bncJulio = 0;
        $bncAgosto = 0;
        $bncSeptiembre = 0;
        $bncOctubre = 0;
        $bncNoviembre = 0;
        $bncDiciembre = 0;

        $bicentenarioEnero = 0;
        $bicentenarioFebrero = 0;
        $bicentenarioMarzo = 0;
        $bicentenarioAbril = 0;
        $bicentenarioMayo = 0;
        $bicentenarioJunio = 0;
        $bicentenarioJulio = 0;
        $bicentenarioAgosto = 0;
        $bicentenarioSeptiembre = 0;
        $bicentenarioOctubre = 0;
        $bicentenarioNoviembre = 0;
        $bicentenarioDiciembre = 0;

        $bodEnero = 0;
        $bodFebrero = 0;
        $bodMarzo = 0;
        $bodAbril = 0;
        $bodMayo = 0;
        $bodJunio = 0;
        $bodJulio = 0;
        $bodAgosto = 0;
        $bodSeptiembre = 0;
        $bodOctubre = 0;
        $bodNoviembre = 0;
        $bodDiciembre = 0;

        $banco100Enero = 0;
        $banco100Febrero = 0;
        $banco100Marzo = 0;
        $banco100Abril = 0;
        $banco100Mayo = 0;
        $banco100Junio = 0;
        $banco100Julio = 0;
        $banco100Agosto = 0;
        $banco100Septiembre = 0;
        $banco100Octubre = 0;
        $banco100Noviembre = 0;
        $banco100Diciembre = 0;


        $taxe = Taxe::where('status', 'verified')
            ->orWhere('status', 'verified-sysprim')
            ->sum('amount');
        $taxes = number_format($taxe, 2, ',', '.');

        $banesco1 = Taxe::where('status', 'verified')
            ->where('bank_name', 'BANESCO')
            ->orWhere('status', 'verified-sysprim')
            ->where('bank_name', 'BANESCO')
            ->sum('amount');
        $banesco = number_format($banesco1, 2, ',', '.');

        $banco1001 = Taxe::where('status', '=', 'verified')
            ->where('bank_name', '100%BANCO')
            ->orWhere('status', 'verified-sysprim')
            ->where('bank_name', '100%BANCO')
            ->sum('amount');
        $banco100 = number_format($banco1001, 2, ',', '.');
        $bnc1 = Taxe::where('status', 'verified')
            ->where('bank_name', 'BNC')
            ->orWhere('status', 'verified-sysprim')
            ->where('bank_name', 'BNC')
            ->sum('amount');
        $bnc = number_format($bnc1, 2, ',', '.');
        $bod1 = Taxe::where('status', 'verified')
            ->where('bank_name', 'BOD')
            ->orWhere('status', 'verified-sysprim')
            ->where('bank_name', 'BOD')
            ->sum('amount');
        $bod = number_format($bod1, 2, ',', '.');
        $bicentenario1 = Taxe::where('status', 'verified')
            ->where('bank_name', 'BICENTENARIO')
            ->orWhere('status', 'verified-sysprim')
            ->where('bank_name', 'BICENTENARIO')
            ->sum('amount');
        $bicentenario = number_format($bicentenario, 2, ',', '.');

        $bdv1 = Taxe::where('status', 'verified')
        ->where('bank_name', 'BANCO VENEZUELA')
        ->orWhere('status', 'verified-sysprim')
        ->where('bank_name', 'BANCO VENEZUELA')
        ->sum('amount');
        $bdv = number_format($bdv1, 2, ',', '.');

        /*--------------------------RECAUDACION POR MESES -------------------------------------*/


        $monthTaxes=[];
        for ($month=1;$month<=12;$month++){
            $monthTaxes[] = Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->sum('amount');
        }




        /*--------------------------RECAUDACION POR MESES (BANESCO) -------------------------------------*/


        $monthBanesco=[];
        for ($month=1;$month<=12;$month++){
            $monthBanesco[] = Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', 'BANESCO')
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', '01')
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', 'BANESCO')
                ->sum('amount');
        }



        /*--------------------------RECAUDACION POR MESES (BNC) -------------------------------------*/


        $bncEnero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncFebrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncMarzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncAbril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncMayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncJunio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncJulio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncAgosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncSeptiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncOctubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncNoviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncDiciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');

        //Recaudacion por meses de bicentenario

        $bicentenarioEnero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioFebrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioMarzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioAbril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioMayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioJunio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioJulio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioAgosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioSeptiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioOctubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioNoviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioDiciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');

        //Recaudacion por meses de bod


        $bodEnero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodFebrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodMarzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodAbril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodMayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodJunio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodJulio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodAgosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodSeptiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodOctubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodNoviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodDiciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');

        //Recaudacion por meses de banco100


        $banco100Enero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Febrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Marzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Abril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Mayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Junio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Julio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Agosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Septiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Octubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Noviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Diciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');


        //RECAUDACION POR BANCO DE VENEZUELA
        $monthBdv=[];
        for($month=1;$month<=12;$month++){
            $monthBdv[] = Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', 'BANCO VENEZUELA')
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', 'BANCO VENEZUELA')
                ->sum('amount');
        }



        $collection = array(
            'total' => $taxes,
            'banesco' => $banesco,
            'banco100' => $banco100,
            'bnc' => $bnc,
            'bod' => $bod,
            'bicentenario' => $bicentenario,
            'venezuela'=> $bdv
        );
        $collectionMonth = array(
            'enero' => $monthTaxes[0],
            'febrero' => $monthTaxes[1],
            'marzo' => $monthTaxes[2],
            'abril' => $monthTaxes[3],
            'mayo' => $monthTaxes[4],
            'junio' => $monthTaxes[5],
            'julio' => $monthTaxes[6],
            'agosto' => $monthTaxes[7],
            'septiembre' => $monthTaxes[8],
            'octubre' => $monthTaxes[9],
            'noviembre' => $monthTaxes[10],
            'diciembre' => $monthTaxes[11]
        );


        $banescoMonth = array(
            'enero' => $monthBanesco[0],
            'febrero' => $monthBanesco[1],
            'marzo' => $monthBanesco[2],
            'abril' => $monthBanesco[3],
            'mayo' => $monthBanesco[4],
            'junio' => $monthBanesco[5],
            'julio' => $monthBanesco[6],
            'agosto' => $monthBanesco[7],
            'septiembre' =>$monthBanesco[8],
            'octubre' => $monthBanesco[9],
            'noviembre' => $monthBanesco[10],
            'diciembre' => $monthBanesco[11]
        );
        $bncMonth = array(
            'enero' => $bncEnero,
            'febrero' => $bncFebrero,
            'marzo' => $bncMarzo,
            'abril' => $bncAbril,
            'mayo' => $bncMayo,
            'junio' => $bncJunio,
            'julio' => $bncJulio,
            'agosto' => $bncAgosto,
            'septiembre' => $bncSeptiembre,
            'octubre' => $bncOctubre,
            'noviembre' => $bncNoviembre,
            'diciembre' => $bncDiciembre
        );

        $bicentenarioMonth = array(
            'enero' => $bicentenarioEnero,
            'febrero' => $bicentenarioFebrero,
            'marzo' => $bicentenarioMarzo,
            'abril' => $bicentenarioAbril,
            'mayo' => $bicentenarioMayo,
            'junio' => $bicentenarioJunio,
            'julio' => $bicentenarioJulio,
            'agosto' => $bicentenarioAgosto,
            'septiembre' => $bicentenarioSeptiembre,
            'octubre' => $bicentenarioOctubre,
            'noviembre' => $bicentenarioNoviembre,
            'diciembre' => $bicentenarioDiciembre
        );

        $bodMonth = array(
            'enero' => $bodEnero,
            'febrero' => $bodFebrero,
            'marzo' => $bodMarzo,
            'abril' => $bodAbril,
            'mayo' => $bodMayo,
            'junio' => $bodJunio,
            'julio' => $bodJulio,
            'agosto' => $bodAgosto,
            'septiembre' => $bodSeptiembre,
            'octubre' => $bodOctubre,
            'noviembre' => $bodNoviembre,
            'diciembre' => $bodDiciembre
        );
        //number_format($total, 2, ',', '.');
        $banco100Month = array(
            'enero' => $banco100Enero,
            'febrero' => $banco100Febrero,
            'marzo' => $banco100Marzo,
            'abril' => $banco100Abril,
            'mayo' => $banco100Mayo,
            'junio' => $banco100Junio,
            'julio' => $banco100Julio,
            'agosto' => $banco100Agosto,
            'septiembre' => $banco100Septiembre,
            'octubre' => $banco100Octubre,
            'noviembre' => $banco100Noviembre,
            'diciembre' => $banco100Diciembre
        );

        $bdvMonth = array(
            'enero' => $monthBdv[0],
            'febrero' => $monthBdv[1],
            'marzo' => $monthBdv[2],
            'abril' => $monthBdv[3],
            'mayo' => $monthBdv[4],
            'junio' => $monthBdv[5],
            'julio' => $monthBdv[6],
            'agosto' => $monthBdv[7],
            'septiembre' => $monthBdv[8],
            'octubre' => $monthBdv[9],
            'noviembre' => $monthBdv[10],
            'diciembre' =>$monthBdv[11]
        );


        $actividad = $this->actividadTaxes();
        $property = $this->propertyTaxes();
        $vehicle = $this->vehicleTaxes();
        $rate = $this->rateTaxes();
        $publicity = $this->publicityTaxes();
        $top = $this->topPayments();
        $dear = $this->dearTaxes();
        $dearVehicle = $this->dearTaxesVehicle();
        //$dearRate = $this->dearRateTaxes();

        $dearTaxes = array(
            'estimado' => $dear['estimado'] + $dearVehicle['estimado'],
            'incremento' => $dear['incremento'] + $dearVehicle['incremento'],
            'total' => $dear['total'] + $dearVehicle['total']
        );

        // Count Taxpayers

        $taxpayers = User::get()->count();
        $companies = Company::get()->count();


        /* Position sirve para saber en que posicion del array estan lo datos para el javascript*/

        return response()->json([
            $collection,  //position:0
            $collectionMonth,//position:1
            $banescoMonth,//position:2
            $bncMonth,//position:3
            $bicentenarioMonth,//position:4
            $bodMonth,//position:5
            $banco100Month,//position:6
            $actividad,//position:7
            $property,//position:8
            $vehicle,//position:9
            $publicity,//position:10
            $top,//position:11
            $dearTaxes,//position:12
            $taxpayers,//position:13
            $companies,//position:14
            $rate,//position:15
            $bdvMonth//position:16
        ]);
    }

    public function dashboard()
    {

        $company = Taxe::where('status', 'verified')
            ->where('branch', 'Act.Eco')->orderByDesc('id')
            ->orWhere('status', 'verified-sysprim')
            ->where('branch', 'Act.Eco')->orderByDesc('id')->take(5)->get();


        //$companyTaxes = $company->taxesCompanies()->orderByDesc('id')->take(1)->get();
        $ptb = Taxe::where('status', 'verified')
            ->where('code', 'like', '%ppt%')
            ->orWhere('status', 'verified-sysprim')
            ->where('code', 'like', '%ppt%')->get();
        $countPtb = count($ptb);


        $ppv = Taxe::where('status', 'verified')
            ->where('code', 'like', '%ppv%')
            ->orWhere('status', 'verified-sysprim')
            ->where('code', 'like', '%ppv%')->get();
        $countPpv = count($ppv);

        $ppe = Taxe::where('status', 'verified')
            ->where('code', 'like', '%ppe%')
            ->orWhere('status', 'verified-sysprim')
            ->where('code', 'like', '%ppe%')->get();
        $countPpe = count($ppe);


        $ppc = Taxe::where('status', 'verified')
            ->where('code', 'like', '%ppc%')
            ->orWhere('status', 'verified-sysprim')
            ->where('code', 'like', '%ppc%')->get();
        $countPpc = count($ppc);
        $dear = array(
            'company' => $this->dearTaxes(),
            'vehicle' => $this->dearTaxesVehicle(),
            'property'=> $this->dearTaxesProperty()
        );

        $users = User::all()->count();
        $companies = Company::get()->count();
        $vehicles = Vehicle::get()->count();
        $property = Inmueble::get()->count();



        //Conseguir nombre de mes en enpaniol
        $month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $date_now = Carbon::now();
        $mounthNow = $month[($date_now->format('n')) - 1];





        return view('modules.admin.dashboard', array(
                'company' => $company,
                'ptb' => $countPtb,
                'ppv' => $countPpv,
                'ppc' => $countPpc,
                'ppe' => $countPpe,
                'dear' => $dear,
                'users' => $users,
                'companies' => $companies,
                'vehicles' => $vehicles,
                'property' => $property,
                'monthNow'=>$mounthNow
            )
        );
    }

    public function bs()
    {
        $taxe = Taxe::where('status', 'verified')
            ->orWhere('status', 'verified-sysprim')->sum('amount');
        return response()->json([
            $taxe]);
    }

    public function amountApproximate()
    {
        $date = Carbon::now();
        $taxe = Taxe::where('status', 'process')
            ->whereDay('created_at', $date->day)
            ->sum('amount');
        return response()->json([
            $taxe]);
    }

    public function actividadTaxes()
    {
        $year = Carbon::now()->format('Y');

        $month=[];

        for ($i=1;$i<=12;$i++){
            $month[]= Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $i)
                ->whereYear('created_at', '=', $year)
                ->where('branch', 'Act.Eco')
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', $i)
                ->whereYear('created_at', '=', $year)
                ->where('branch', 'Act.Eco')
                ->sum('amount');
         }

        $actividad = array(
            'enero' => $month[0],
            'febrero' => $month[1],
            'marzo' => $month[2],
            'abril' => $month[3],
            'mayo' => $month[4],
            'junio' => $month[5],
            'julio' => $month[6],
            'agosto' => $month[7],
            'septiembre' => $month[8],
            'octubre' => $month[9],
            'noviembre' => $month[10],
            'diciembre' => $month[11],
        );
        return $actividad;
    }

    public function propertyTaxes()
    {
        $year = Carbon::now()->format('Y');


        $propertyMonth=[];

        for ($month=1;$month<=12;$month++){
            $propertyMonth[]= Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('branch', 'Inm.Urbanos')
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('branch', 'Inm.Urbanos')
                ->sum('amount');
        }


        $property = array(
            'enero' => $propertyMonth[0],
            'febrero' => $propertyMonth[1],
            'marzo' =>$propertyMonth[2],
            'abril' => $propertyMonth[3],
            'mayo' => $propertyMonth[4],
            'junio' => $propertyMonth[5],
            'julio' =>$propertyMonth[6],
            'agosto' =>$propertyMonth[7],
            'septiembre' => $propertyMonth[8],
            'octubre' => $propertyMonth[9],
            'noviembre' => $propertyMonth[10],
            'diciembre' => $propertyMonth[11]
        );
        return $property;
    }

    public function vehicleTaxes()
    {
        $year = Carbon::now()->format('Y');

        $veh_Enero = 0;
        $veh_Febrero = 0;
        $veh_Marzo = 0;
        $veh_Abril = 0;
        $veh_Mayo = 0;
        $veh_Junio = 0;
        $veh_Julio = 0;
        $veh_Agosto = 0;
        $veh_Septiembre = 0;
        $veh_Octubre = 0;
        $veh_Noviembre = 0;
        $veh_Diciembre = 0;

        $veh_Enero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');
        $veh_Febrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');
        $veh_Marzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');
        $veh_Abril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');
        $veh_Mayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');
        $veh_Junio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');
        $veh_Julio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');
        $veh_Agosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');
        $veh_Septiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');
        $veh_Octubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');
        $veh_Noviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');
        $veh_Diciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');

        $vehicle = array(
            'enero' => $veh_Enero,
            'febrero' => $veh_Febrero,
            'marzo' => $veh_Marzo,
            'abril' => $veh_Abril,
            'mayo' => $veh_Mayo,
            'junio' => $veh_Junio,
            'julio' => $veh_Julio,
            'agosto' => $veh_Agosto,
            'septiembre' => $veh_Septiembre,
            'octubre' => $veh_Octubre,
            'noviembre' => $veh_Noviembre,
            'diciembre' => $veh_Diciembre
        );
        return $vehicle;
    }

    public function rateTaxes()
    {
        $year = Carbon::now()->format('Y');


        $rateMonth=[];

        for ($month=1;$month<=12;$month++){
            $rateMonth[]= Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('branch', 'Tasas y Cert')
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('branch', 'Tasas y Cert')
                ->sum('amount');
        }


        $rate = array(
            'enero' => $rateMonth[0],
            'febrero' => $rateMonth[1],
            'marzo' => $rateMonth[2],
            'abril' => $rateMonth[3],
            'mayo' => $rateMonth[4],
            'junio' => $rateMonth[5],
            'julio' => $rateMonth[6],
            'agosto' => $rateMonth[7],
            'septiembre' => $rateMonth[8],
            'octubre' => $rateMonth[9],
            'noviembre' => $rateMonth[10],
            'diciembre' => $rateMonth[11]
        );
        return $rate;
    }

    public function publicityTaxes()
    {
        $year = Carbon::now()->format('Y');

        $publicityMonth=[];

        for ($month=1;$month<=12;$month++){
            $publicityMonth[]= Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('branch', 'Prop. y Publicidad')
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('branch', 'Prop. y Publicidad')
                ->sum('amount');
        }

        $publicity = array(
            'enero' => $publicityMonth[0],
            'febrero' => $publicityMonth[1],
            'marzo' => $publicityMonth[2],
            'abril' => $publicityMonth[3],
            'mayo' => $publicityMonth[4],
            'junio' => $publicityMonth[5],
            'julio' => $publicityMonth[6],
            'agosto' => $publicityMonth[7],
            'septiembre' => $publicityMonth[8],
            'octubre' => $publicityMonth[9],
            'noviembre' => $publicityMonth[10],
            'diciembre' => $publicityMonth[11]
        );

        return $publicity;
    }

    public function topPayments()
    {

        $ppv = Taxe::where('status', 'verified')
            ->where('code', 'like', '%ppv%')
            ->orWhere('status', 'verified-sysprim')
            ->where('code', 'like', '%ppv%')->get();
        $countPpv = count($ppv);


        $ppe = Taxe::where('status', 'verified')
            ->where('code', 'like', '%ppe%')
            ->orWhere('status', 'verified-sysprim')
            ->where('code', 'like', '%ppe%')->get();
        $countPpe = count($ppe);

        $ptb = Taxe::where('status', 'verified')
            ->where('code', 'like', '%ppt%')
            ->orWhere('status', 'verified-sysprim')
            ->where('code', 'like', '%ppt%')->get();
        $countPtb = count($ptb);

        $ppc = Taxe::where('status', 'verified')
            ->where('code', 'like', '%ppc%')
            ->orWhere('status', 'verified-sysprim')
            ->where('code', 'like', '%ppc%')->get();
        $countPpc = count($ppc);
        $top = array(
            'ppv' => $countPpv,
            'ppe' => $countPpe,
            'ptb' => $countPtb,
            'ppc' => $countPpc
        );
        return $top;

    }

    public function dearTaxes()
    {
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $company = Company::all();
        $tributo = Tributo::latest()->value('value');
        $acum = 0;
        $percentage = 0;

        $raised = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');

        $wait = Taxe::where('status', 'process')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $totalCollection = $raised + $wait;

        if ($raised > 0) {
            $percentage = $raised / $totalCollection * 100;
        }




        $ciiu=[];

        foreach ($company as $compa) {


            foreach ($compa->ciu as $ciu){
                $ciiu[] =$ciu->id;
            }

        }

        $now=Carbon::now()->format('Y');

        $timelines=TimelineCiiu::whereIn('ciu_id',$ciiu)->whereYear('to','=',$now)->orderBy('id','desc')->get();




        foreach ($timelines as $timeline){
                $acum+=$timeline->min_tribu_men*$tributo;
        }





        $increment = $totalCollection - $acum;
        if ($increment < 0) {
            $increment = 0;
        }

        $dearTaxesCompany = array(
            'taxes' => 'Actividad Economica',
            'Recaudado' => number_format($raised, 2, ',', '.'),
            'Espera' => number_format($wait, 2, ',', '.'),
            'Total' => number_format($totalCollection, 2, ',', '.'),
            'Porcentaje' => $percentage,
            'Estimado' => number_format($acum, 2, ',', '.'),
            'Incremento' => number_format($increment, 2, ',', '.'),
            'total' => $totalCollection,
            'estimado' => $acum,
            'incremento' => $increment
        );

        return $dearTaxesCompany;
    }

    public function dearTaxesVehicle()
    {
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $vehicle = Vehicle::where('status', 'enabled')->get();
        //$rate = Tributo::orderBy('id', 'desc')->take(1)->get();
        $rate = Tributo::latest()->value('value');
        $acum = 0;
        $percentage = 0;
        $raised = 0;
        $wait = 0;
        $timeline='';

        $raised = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');

        $wait = Taxe::where('status', 'process')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat.Veh')
            ->sum('amount');

        foreach ($vehicle as $vehicles) {
            $yearVehicle = $vehicles->year;

            $diffYear = $year - intval($yearVehicle);

            $now=Carbon::now();
            $timeline=TimelineTypeVehicle::where('type_vehicle_id',$vehicles->type->id)
                ->whereYear('to','=',(string)$now->format('Y'))->orderBy('id','desc')->get();


            if ($diffYear < 3) {
                $rateYear = $timeline[0]->rate;
                $taxes = $rateYear * $rate;
            } else {
                $rateYear = $timeline[0]->rate_UT;
                $taxes = $rateYear * $rate;
            }
            $acum += $taxes;
        }


        $totalCollection = $raised + $wait;



        if ($raised > 0) {
            $percentage = $raised / $totalCollection * 100;
        }

        $increment = $totalCollection - $acum;
        if ($increment < 0) {
            $increment = 0;
        }

        $dearTaxesVehicle = array(
            'taxes' => 'Patente Vehículo',
            'Recaudado' => number_format($raised, 2, ',', '.'),
            'Espera' => number_format($wait, 2, ',', '.'),
            'Total' => number_format($totalCollection, 2, ',', '.'),
            'Porcentaje' => $percentage,
            'Estimado' => number_format($acum, 2, ',', '.'),
            'Incremento' => number_format($increment, 2, ',', '.'),
            'total' => $totalCollection,
            'estimado' => $acum,
            'incremento' => $increment
        );

        return $dearTaxesVehicle;
    }

public function dearTaxesProperty()
    {
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $rate = Rate::where('status', 'enabled')->get();
        $rate = Tributo::orderBy('id', 'desc')->take(1)->get();
        $acum = 0;
        $percentage = 0;
        $raised = 0;
        $wait = 0;

        $raised = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbanos')
            ->orWhere('status', 'verified-sysprim')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbanos')
            ->sum('amount');

        $wait = Taxe::where('status', 'process')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbanos')
            ->sum('amount');

        $property=Property::all();

        $acum=0;

        foreach($property as $proper){
            $save=Declaration::VerifyDeclaration($proper->id,'full');
            $acum+=$save['total'];
        }

        $totalCollection = $raised + $wait;

        if ($raised > 0) {
            $percentage = $raised / $totalCollection * 100;
        }

        $increment = $totalCollection - $acum;
        if ($increment < 0) {
            $increment = 0;
        }

        $dearTaxesProperty = array(
            'taxes' => 'Inmuebles Urbanos',
            'Recaudado' => number_format($raised, 2, ',', '.'),
            'Espera' => number_format($wait, 2, ',', '.'),
            'Total' => number_format($totalCollection, 2, ',', '.'),
            'Porcentaje' => $percentage,
            'Estimado' => number_format($acum, 2, ',', '.'),
            'Incremento' => number_format($increment, 2, ',', '.'),
            'total' => $totalCollection,
            'estimado' => $acum,
            'incremento' => $increment
        );

        return $dearTaxesProperty;
    }


}
