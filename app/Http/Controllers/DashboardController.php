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
        $taxes = number_format($taxe, 2, ',', '.');

        $banesco1 = Taxe::where('status', 'verified')
            ->where('bank', 55)
            ->sum('amount');
        $banesco = number_format($banesco1, 2, ',', '.');

        $banco1001 = Taxe::where('status', 'verified')
            ->where('bank', 33)
            ->sum('amount');
        $banco100 = number_format($banco1001, 2, ',', '.');
        $bnc1 = Taxe::where('status', 'verified')
            ->where('bank', 99)
            ->sum('amount');
        $bnc = number_format($bnc1, 2, ',', '.');
        $bod1 = Taxe::where('status', 'verified')
            ->where('bank', 44)
            ->sum('amount');
        $bod = number_format($bod1, 2, ',', '.');
        $bicentenario1 = Taxe::where('status', 'verified')
            ->where('bank', 77)
            ->sum('amount');
        $bicentenario = number_format($bicentenario, 2, ',', '.');


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

        //$noviembre=number_format($noviembre1, 2, ',', '.');
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
            'total' => $taxes,
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
        $actividad = $this->actividadTaxes();
        $property = $this->propertyTaxes();
        $vehicle = $this->vehicleTaxes();
        $event = $this->eventTaxes();
        $top = $this->topPayments();
        $dear= $this->dearTaxes();

        $dearTaxes=array(
          'estimado'=>$dear['estimado'],
          'incremento'=>$dear['incremento'],
          'total'=>$dear['total']
        );

        return response()->json([
            $collection,
            $collectionMonth,
            $banescoMonth,
            $bncMonth,
            $bicentenarioMonth,
            $bodMonth,
            $banco100Month,
            $actividad,
            $property,
            $vehicle,
            $event,
            $top,
            $dear
        ]);
    }

    public function dashboard()
    {

        $company = Taxe::where('status', 'verified')
            ->where('branch', 'Act.Eco')->orderByDesc('id')->take(5)->get();

        //$companyTaxes = $company->taxesCompanies()->orderByDesc('id')->take(1)->get();
        $ptb = Taxe::where('code', 'like', '%ptb%')
            ->where('status', 'verified')->get();
        $countPtb = count($ptb);


        $ppv = Taxe::where('code', 'like', '%ppv%')
            ->where('status', 'verified')->get();
        $countPpv = count($ppv);

        $ppe = Taxe::where('code', 'like', '%ppe%')
            ->where('status', 'verified')->get();
        $countPpe = count($ppe);


        $ppc = Taxe::where('code', 'like', '%ppc%')
            ->where('status', 'verified')->get();
        $countPpc = count($ppc);
        $dear = $this->dearTaxes();

        return view('modules.admin.dashboard', array(
                'company' => $company,
                'ptb' => $countPtb,
                'ppv' => $countPpv,
                'ppc' => $countPpc,
                'ppe' => $countPpe,
                'dear' => $dear
            )
        );
    }

    public function bs()
    {
        $taxe = Taxe::where('status', 'verified')
            ->sum('amount');
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

        $Act_Enero = 0;
        $Act_Febrero = 0;
        $Act_Marzo = 0;
        $Act_Abril = 0;
        $Act_Mayo = 0;
        $Act_Junio = 0;
        $Act_Julio = 0;
        $Act_Agosto = 0;
        $Act_Septiembre = 0;
        $Act_Octubre = 0;
        $Act_Noviembre = 0;
        $Act_Diciembre = 0;

        $Act_Enero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $Act_Febrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $Act_Marzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $Act_Abril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $Act_Mayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $Act_Junio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $Act_Julio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $Act_Agosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $Act_Septiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $Act_Octubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $Act_Noviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');
        $Act_Diciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Act.Eco')
            ->sum('amount');

        $actividad = array(
            'enero' => $Act_Enero,
            'febrero' => $Act_Febrero,
            'marzo' => $Act_Marzo,
            'abril' => $Act_Abril,
            'mayo' => $Act_Mayo,
            'junio' => $Act_Junio,
            'julio' => $Act_Julio,
            'agosto' => $Act_Agosto,
            'septiembre' => $Act_Septiembre,
            'octubre' => $Act_Octubre,
            'noviembre' => $Act_Noviembre,
            'diciembre' => $Act_Diciembre
        );
        return $actividad;
    }

    public function propertyTaxes()
    {
        $year = Carbon::now()->format('Y');

        $pro_Enero = 0;
        $pro_Febrero = 0;
        $pro_Marzo = 0;
        $pro_Abril = 0;
        $pro_Mayo = 0;
        $pro_Junio = 0;
        $pro_Julio = 0;
        $pro_Agosto = 0;
        $pro_Septiembre = 0;
        $pro_Octubre = 0;
        $pro_Noviembre = 0;
        $pro_Diciembre = 0;

        $pro_Enero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');
        $pro_Febrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');
        $pro_Marzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');
        $pro_Abril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');
        $pro_Mayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');
        $pro_Junio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');
        $pro_Julio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');
        $pro_Agosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');
        $pro_Septiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');
        $pro_Octubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');
        $pro_Noviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');
        $pro_Diciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Inm.Urbano')
            ->sum('amount');

        $property = array(
            'enero' => $pro_Enero,
            'febrero' => $pro_Febrero,
            'marzo' => $pro_Marzo,
            'abril' => $pro_Abril,
            'mayo' => $pro_Mayo,
            'junio' => $pro_Junio,
            'julio' => $pro_Julio,
            'agosto' => $pro_Agosto,
            'septiembre' => $pro_Septiembre,
            'octubre' => $pro_Octubre,
            'noviembre' => $pro_Noviembre,
            'diciembre' => $pro_Diciembre
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
            ->where('branch', 'Pat. Veh')
            ->sum('amount');
        $veh_Febrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat. Veh')
            ->sum('amount');
        $veh_Marzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat. Veh')
            ->sum('amount');
        $veh_Abril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat. Veh')
            ->sum('amount');
        $veh_Mayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat. Veh')
            ->sum('amount');
        $veh_Junio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat. Veh')
            ->sum('amount');
        $veh_Julio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat. Veh')
            ->sum('amount');
        $veh_Agosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat. Veh')
            ->sum('amount');
        $veh_Septiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat. Veh')
            ->sum('amount');
        $veh_Octubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat. Veh')
            ->sum('amount');
        $veh_Noviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat. Veh')
            ->sum('amount');
        $veh_Diciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Pat. Veh')
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


    public function eventTaxes()
    {


        $year = Carbon::now()->format('Y');

        $event_Enero = 0;
        $event_Febrero = 0;
        $event_Marzo = 0;
        $event_Abril = 0;
        $event_Mayo = 0;
        $event_Junio = 0;
        $event_Julio = 0;
        $event_Agosto = 0;
        $event_Septiembre = 0;
        $event_Octubre = 0;
        $event_Noviembre = 0;
        $event_Diciembre = 0;

        $event_Enero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '01')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');
        $event_Febrero = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '02')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');
        $event_Marzo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '03')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');
        $event_Abril = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '04')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');
        $event_Mayo = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '05')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');
        $event_Junio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '06')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');
        $event_Julio = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '07')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');
        $event_Agosto = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '08')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');
        $event_Septiembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '09')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');
        $event_Octubre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');
        $event_Noviembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');
        $event_Diciembre = Taxe::where('status', 'verified')
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', $year)
            ->where('branch', 'Event')
            ->sum('amount');

        $event = array(
            'enero' => $event_Enero,
            'febrero' => $event_Febrero,
            'marzo' => $event_Marzo,
            'abril' => $event_Abril,
            'mayo' => $event_Mayo,
            'junio' => $event_Junio,
            'julio' => $event_Julio,
            'agosto' => $event_Agosto,
            'septiembre' => $event_Septiembre,
            'octubre' => $event_Octubre,
            'noviembre' => $event_Noviembre,
            'diciembre' => $event_Diciembre
        );

        return $event;
    }

    public function topPayments()
    {

        $ppv = Taxe::where('code', 'like', '%ppv%')
            ->where('status', 'verified')->get();
        $countPpv = count($ppv);


        $ppe = Taxe::where('code', 'like', '%ppe%')
            ->where('status', 'verified')->get();
        $countPpe = count($ppe);

        $ptb = Taxe::where('code', 'like', '%ptb%')
            ->where('status', 'verified')->get();
        $countPtb = count($ptb);


        $ppc = Taxe::where('code', 'like', '%ppc%')
            ->where('status', 'verified')->get();
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
        foreach ($company as $compa) {
            $co = $compa->ciu()->get();
            $countCiu = count($co);
            for ($i = 0; $i < $countCiu; $i++) {
                $min = $compa->ciu()->value('min_tribu_men');
                $acum += $min * $tributo;
            }
        }

        $increment = $totalCollection - $acum;
        if($increment<0){
            $increment=0;
        }

        $dearTaxesCompany = array(
            'taxes' => 'Actividad Economica',
            'Recaudado' => number_format($raised, 2, ',', '.'),
            'Espera' => number_format($wait, 2, ',', '.'),
            'Total' => number_format($totalCollection, 2, ',', '.'),
            'Porcentaje' => $percentage,
            'Estimado' => number_format($acum, 2, ',', '.'),
            'Incremento'=> number_format($increment, 2, ',', '.'),
            'total'=>$totalCollection,
            'estimado'=>$acum,
            'incremento'=>$increment
        );

        return $dearTaxesCompany;
    }
}
