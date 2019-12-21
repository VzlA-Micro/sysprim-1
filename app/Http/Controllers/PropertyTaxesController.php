<?php

namespace App\Http\Controllers;

use App\Ciu;
use App\Company;
use App\Extras;
use App\Inmueble;
use App\Notification;
use App\Tributo;
use App\Val_cat_const_inmu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Taxe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Alert;
use App\Helpers\TaxesMonth;
use App\Helpers\TaxesNumber;
use Illuminate\Support\Facades\Session;
use App\CiuTaxes;
use App\Employees;
use Illuminate\Support\Facades\Mail;
use App\Helpers\Declaration;
use App\CatastralTerreno;
use App\CatastralConstruccion;
use App\PropertyTaxes;
use App\Alicuota;

class PropertyTaxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $taxes = Taxe::all();
    }


    public function history($company)
    {


        $company = Company::where('name', $company)->get();
        $taxes = Taxe::where('company_id', $company[0]->id)
            ->where('status', 'verified')->orWhere('status', 'process')
            ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();

        return view('modules.payments.history', ['taxes' => $taxes]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create($id)
    {
        $declaration = Declaration::VerifyDeclaration($id);

        $property = Inmueble::where('id', $id)->get();
        $constProperty = Val_cat_const_inmu::where('property_id', $property[0]->id)->get();
        $catasGround = CatastralTerreno::where('id', $property[0]->value_cadastral_ground_id)->get();
        $catasBuild = CatastralConstruccion::where('id', $constProperty[0]->value_catas_const_id)->get();
        $alicuota = Alicuota::where('id', $property[0]->type_inmueble_id)->get();

        $taxes = new Taxe();
        $taxes->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxes->fiscal_period = Carbon::now()->format('Y-m-d');
        $taxes->save();

        $taxesId = DB::getPdo()->lastInsertId();

        $taxes = Taxe::where('id', $taxesId)->get();
        $propertyTaxes = new PropertyTaxes();
        $propertyTaxes->property_id = $property[0]->id;
        $propertyTaxes->taxes_id = $taxesId;
        $period_fiscal = Carbon::now()->year;


        return view('dev.paymentProperty.details', array(
            'property' => $property,
            'declaration' => $declaration,
            'ground' => $catasGround,
            'build' => $catasBuild,
            'taxes' => $taxes,
            'period' => $period_fiscal,
            'alicuota' => $alicuota
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPDF($id)
    {
        $amountInterest = 0;//total de intereses
        $amountRecargo = 0;//total de recargos
        $amountCiiu = 0;//total de ciiu
        $amountDesc = 0;//Descuento
        $amountTaxes = 0;//total a de impuesto
        $amountTotal = 0;


        $taxes = Taxe::findOrFail($id);
        $ciuTaxes = CiuTaxes::where('taxe_id', $id)->get();
        $company_find = Company::find($taxes->company_id);
        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $mora = Extras::orderBy('id', 'desc')->take(1)->get();
        $extra = ['tasa' => $mora[0]->tax_rate];


        $amountTaxes = $amountInterest + $amountRecargo + $amountCiiu;//Total

        $amount = ['amountInterest' => $amountInterest,
            'amountRecargo' => $amountRecargo,
            'amountCiiu' => $amountCiiu,
            'amountTotal' => $amountTaxes,
        ];


        $pdf = \PDF::loadView('modules.taxes.receipt', [
            'taxes' => $taxes,
            'fiscal_period' => $fiscal_period,
            'extra' => $extra,
            'ciuTaxes' => $ciuTaxes,
            'amount' => $amount,
            'firm' => false
        ]);
        return $pdf->stream();
    }

    public function paymentsHelp(Request $request)
    {
        echo 'hola';
        $amountInterest = 0;//total de intereses
        $amountRecargo = 0;//total de recargos
        $amountCiiu = 0;//total de ciiu
        $amountDesc = 0;//Descuento
        $amountTaxes = 0;//total a de impuesto
        $amountTotal = 0;

        $user = \Auth::user();


        $id = $request->input('taxes_id');

        $idProperty = $request->input('idProperty');
        $amount = $request->input('total');

        $bank = $request->input('bank');
        $payments_type = $request->input('payments');
        $totalBuild = $request->input('totalBuild');
        $totalGround = $request->input('totalGround');

        $payments_type = strtoupper($payments_type);
        if ($payments_type === 'PPV') {
            $bank = 57;
        }

        $property = Inmueble::find($idProperty);
        $constProperty = Val_cat_const_inmu::where('property_id', $property->id)->get();
        $catasBuild = CatastralConstruccion::where('id', $constProperty[0]->value_catas_const_id)->get();
        $amount_format = str_replace('.', '', $amount);
        $amount_format = str_replace(',', '.', $amount_format);
        $taxes = Taxe::findOrFail($id);
        $taxes->amount = $amount_format;
        $code = TaxesNumber::generateNumberTaxes($payments_type . "84");
        $catasGround = CatastralTerreno::where('id', $property->value_cadastral_ground_id)->get();
        $taxes->code = $code;
        $taxes->bank = $bank;
        $taxes->status = 'process';
        $taxes->branch = 'Imn.Urbano';
        $code = substr($code, 3, 12);

        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));
        $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank, $code);

        $taxes->update();

        $taxes = Taxe::findOrFail($id);

        $subject = "PLANILLA DE PAGO";
        $for = \Auth::user()->email;
        $pdf = \PDF::loadView('dev.paymentProperty.receipt', [
            'taxes' => $taxes,
            'fiscal_period' => $taxes->created_at->format('Y'),
            'amount' => $amount,
            'firm' => false,
            'nameUser' => $user->name . " " . $user->surname,
            'ci' => $user->ci,
            'tel' => $user->phone,
            'cadastral' => $property->code_cadastral,
            'property' => $property,
            'build' => $catasBuild[0]->name,
            'costBuild' =>$totalBuild,
            'ground'=>$catasGround->name,
            'costGround'=>$totalGround
        ]);


        Mail::send('mails.payment-payroll', [], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("grabieldiaz63@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
            $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });
        return redirect('payments/history/' . session('company'))->with('message', 'La planilla fue registra con éxito,fue enviado al correo ' . \Auth::user()->email . ',recuerda que esta planilla es valida solo por el dia ' . $date_format);

    }


    public function calculate($id)
    {
        $taxes = Taxe::findOrFail($id);
        $taxes->delete();
        return redirect('payments/create/' . session('company'));

    }


    public function getCarnet()
    {
        $pdf = \PDF::loadView('modules.companies.carnet');
        return $pdf->stream();
    }

    public function calcu(Request $request)
    {
        $value = strval($request->input('value'));
        $valor = str_replace('.', '', $value);
        $valor1 = str_replace(',', '.', $valor);
        $descuento = $valor1 * 0.20;
        $total = $valor1 - $descuento;
        $total1 = number_format($total, 2, ',', '.');

        return response()->json(['value' => $total1]);

    }

    public function calcuFraccionado(Request $request)
    {
        $value = strval($request->input('value'));
        $valor = str_replace('.', '', $value);
        $valor1 = str_replace(',', '.', $valor);
        $total = $valor1 / 4;
        $fraccionado = number_format($total, 2, ',', '.');

        return response()->json(['value' => $fraccionado]);
    }

}
