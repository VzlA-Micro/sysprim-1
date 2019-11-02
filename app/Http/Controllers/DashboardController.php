<?php

namespace App\Http\Controllers;

use App\Imports\PaymentsImport;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use Mail;
use App\Taxe;
use App\Company;
use App\Extras;
use App\Tributo;
use App\Helpers\TaxesMonth;
use App\Http\Controllers\Controller;
use App\Payments;
use Carbon\Carbon;
use App\Employees;
use App\CiuTaxes;

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

        $banescoEnero = 0;
        $banescoFebrero = 0;
        $banescoMarzo = 0;
        $banescoAbril = 0;
        $banescoMayo = 0;
        $banescoJunio = 0;
        $banescoJulio = 0;
        $banescoAgosto = 0;
        $banescoSeptiembre = 0;
        $banescoOctubre = 0;
        $banescoNoviembre = 0;
        $banescoDiciembre = 0;

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
            ->sum('amount');
        $banesco = Taxe::where('status', 'verified')
            ->where('bank', 55)
            ->sum('amount');
        $banco100 = Taxe::where('status', 'verified')
            ->where('bank', 33)
            ->sum('amount');
        $bnc = Taxe::where('status', 'verified')
            ->where('bank', 99)
            ->sum('amount');
        $bod = Taxe::where('status', 'verified')
            ->where('bank', 44)
            ->sum('amount');
        $bicentenario = Taxe::where('status', 'verified')
            ->where('bank', 77)
            ->sum('amount');


        //Recaudacion por meses

        $enero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');
        $febrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');
        $marzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');
        $abril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');
        $mayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');
        $junio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');
        $julio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');
        $agosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');
        $septiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');
        $octubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');
        $noviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');
        $diciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->sum('amount');

        //Recaudacion por meses de banesco


        $banescoEnero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');
        $banescoFebrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');
        $banescoMarzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');
        $banescoAbril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');
        $banescoMayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');
        $banescoJunio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');
        $banescoJulio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');
        $banescoAgosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');
        $banescoSeptiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');
        $banescoOctubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');
        $banescoNoviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');
        $banescoDiciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 55)
            ->sum('amount');

        //Recaudacion por meses de bnc


        $bncEnero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncFebrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncMarzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncAbril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncMayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncJunio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncJulio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncAgosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncSeptiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncOctubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncNoviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');
        $bncDiciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 99)
            ->sum('amount');

        //Recaudacion por meses de bicentenario

        $bicentenarioEnero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioFebrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioMarzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioAbril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioMayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioJunio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioJulio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioAgosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioSeptiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioOctubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioNoviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');
        $bicentenarioDiciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 77)
            ->sum('amount');

        //Recaudacion por meses de bod


        $bodEnero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodFebrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodMarzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodAbril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodMayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodJunio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodJulio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodAgosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodSeptiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodOctubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodNoviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');
        $bodDiciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 44)
            ->sum('amount');

        //Recaudacion por meses de banco100


        $banco100Enero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Febrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Marzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Abril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Mayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Junio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Julio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Agosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Septiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Octubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Noviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');
        $banco100Diciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('bank', 33)
            ->sum('amount');

        $collection = array(
            'total' => $taxe,
            'banesco' => $banesco,
            'banco100' => $banco100,
            'bnc' => $bnc,
            'bod' => $bod,
            'bicentenario' => $bicentenario
        );
        $collectionMonth = array(
            'enero' => $enero,
            'febrero' => $febrero,
            'marzo' => $marzo,
            'abril' => $abril,
            'mayo' => $mayo,
            'junio' => $junio,
            'julio' => $julio,
            'agosto' => $agosto,
            'septiembre' => $septiembre,
            'octubre' => $octubre,
            'noviembre' => $noviembre,
            'diciembre' => $diciembre
        );
        $banescoMonth = array(
            'enero' => $banescoEnero,
            'febrero' => $banescoFebrero,
            'marzo' => $banescoMarzo,
            'abril' => $banescoAbril,
            'mayo' => $banescoMayo,
            'junio' => $banescoJunio,
            'julio' => $banescoJulio,
            'agosto' => $banescoAgosto,
            'septiembre' => $banescoSeptiembre,
            'octubre' => $banescoOctubre,
            'noviembre' => $banescoNoviembre,
            'diciembre' => $banescoDiciembre
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
        return response()->json([
            $collection,
            $collectionMonth,
            $banescoMonth,
            $bncMonth,
            $bicentenarioMonth,
            $bodMonth,
            $banco100Month
        ]);
    }

    public function dashboard()
    {
        $company=Taxe::orderByDesc('id')->take(8)->get();
        //$companyTaxes = $company->taxesCompanies()->orderByDesc('id')->take(1)->get();
        $ptb=Taxe::where('code','like','%ptb%')
            ->where('status','verified')->get();
        $countPtb=count($ptb);


        $ppb=Taxe::where('code','like','%ppb%')
                    ->where('status','verified')->get();
        $countPpb=count($ppb);


        return view('modules.admin.dashboard',array(
            'company'=>$company,
            'ptb'=>$countPtb,
            'ppb'=>$countPpb)
        );
    }
}
