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

        $year = Carbon::now()->format('Y');





        $taxe = Taxe::where('status', 'verified')
            ->orWhere('status', 'verified-sysprim')
            ->sum('amount');
        $taxes = number_format($taxe, 2, ',', '.');

        /*--------------------------TOTAL RECAUDADO POR BANCOS(ANUAL)-------------------------------------*/
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
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', 'BANESCO')
                ->sum('amount');
        }



        /*--------------------------RECAUDACION POR MESES (BNC) -------------------------------------*/



        $monthBnc=[];
        for ($month=1;$month<=12;$month++){
            $monthBnc[] = Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', 'BNC')
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', 'BNC')
                ->sum('amount');
        }



        /*--------------------------RECAUDACION POR MESES (BICENTENARIO) -------------------------------------*/



        $monthBicentenario=[];
        for ($month=1;$month<=12;$month++){
            $monthBicentenario[] = Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', 'BICENTENARIO')
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', 'BICENTENARIO')
                ->sum('amount');
        }


        /*--------------------------RECAUDACION POR MESES (BOD) -------------------------------------*/



        $monthBod=[];
        for ($month=1;$month<=12;$month++){
            $monthBod[] = Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', 'BOD')
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', 'BOD')
                ->sum('amount');
        }





        /*--------------------------RECAUDACION POR MESES (100BANCO) -------------------------------------*/


        $monthBanco100=[];
        for ($month=1;$month<=12;$month++){
            $monthBanco100[] = Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', '100%BANCO')
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('bank_name', '100%BANCO')
                ->sum('amount');
        }



        /*--------------------------RECAUDACION POR MESES (VENEZUELA) -------------------------------------*/

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





        /*--------------------------ENVIO DE DATOS -------------------------------------*/

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
            'enero' => $monthBnc[0],
            'febrero' => $monthBnc[1],
            'marzo' => $monthBnc[2],
            'abril' => $monthBnc[3],
            'mayo' => $monthBnc[4],
            'junio' => $monthBnc[5],
            'julio' => $monthBnc[6],
            'agosto' => $monthBnc[7],
            'septiembre' => $monthBnc[8],
            'octubre' => $monthBnc[9],
            'noviembre' => $monthBnc[10],
            'diciembre' => $monthBnc[11]
        );

        $bicentenarioMonth = array(
            'enero' => $monthBicentenario[0],
            'febrero' =>  $monthBicentenario[1],
            'marzo' => $monthBicentenario[2],
            'abril' =>  $monthBicentenario[3],
            'mayo' =>  $monthBicentenario[4],
            'junio' =>  $monthBicentenario[5],
            'julio' =>  $monthBicentenario[6],
            'agosto' =>  $monthBicentenario[7],
            'septiembre' => $monthBicentenario[8],
            'octubre' =>  $monthBicentenario[9],
            'noviembre' =>  $monthBicentenario[10],
            'diciembre' => $monthBicentenario[11],
        );

        $bodMonth = array(
            'enero' => $monthBod[0],
            'febrero' => $monthBod[1],
            'marzo' => $monthBod[2],
            'abril' => $monthBod[3],
            'mayo' => $monthBod[4],
            'junio' => $monthBod[5],
            'julio' => $monthBod[6],
            'agosto' => $monthBod[7],
            'septiembre' => $monthBod[8],
            'octubre' => $monthBod[9],
            'noviembre' => $monthBod[10],
            'diciembre' => $monthBod[11]
        );
        //number_format($total, 2, ',', '.');
        $banco100Month = array(
            'enero' => $monthBanco100[0],
            'febrero' => $monthBanco100[1],
            'marzo' => $monthBanco100[2],
            'abril' => $monthBanco100[3],
            'mayo' => $monthBanco100[4],
            'junio' => $monthBanco100[5],
            'julio' => $monthBanco100[6],
            'agosto' => $monthBanco100[7],
            'septiembre' => $monthBanco100[8],
            'octubre' => $monthBanco100[9],
            'noviembre' => $monthBanco100[10],
            'diciembre' => $monthBanco100[11]
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


        /*--------------------------ESTIMADOS -------------------------------------*/

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



        /*--------------------------NUMERO DE USUARIOS -------------------------------------*/


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


        $vehicleMonth=[];


        for ($month=1;$month<=12;$month++){
            $vehicleMonth[]= Taxe::where('status', 'verified')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('branch', 'Pat.Veh')
                ->orWhere('status', 'verified-sysprim')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('branch', 'Pat.Veh')
                ->sum('amount');
        }




        $vehicle = array(
            'enero' => $vehicleMonth[0],
            'febrero' => $vehicleMonth[1],
            'marzo' => $vehicleMonth[2],
            'abril' =>  $vehicleMonth[3],
            'mayo' =>  $vehicleMonth[4],
            'junio' =>  $vehicleMonth[5],
            'julio' =>  $vehicleMonth[6],
            'agosto' =>  $vehicleMonth[7],
            'septiembre' =>  $vehicleMonth[8],
            'octubre' =>  $vehicleMonth[9],
            'noviembre' => $vehicleMonth[10],
            'diciembre' =>  $vehicleMonth[11]
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
