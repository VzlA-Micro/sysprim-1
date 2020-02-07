<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\Mail;
use App\Helpers\Declaration;
use App\CatastralTerreno;
use App\CatastralConstruccion;
use App\PropertyTaxes;
use App\Alicuota;
use App\Property;
use App\UserProperty;
use App\User;
use App\Helpers\CheckCollectionDay;
use App\BankRate;
use App\Company;
use App\Parish;
use OwenIt\Auditing\Models\Audit;


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

    public function manage($id) {
//        $userProperty = UserProperty::where('user_id', \Auth::user()->id)->select('property_id')->get();
//        $property = Property::find('id', $userProperty[0])->get();
        $property = Property::find($id);
        return view('modules.properties-payments.manage', ['property' => $property]);
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

    public function create($id, $status = 'full')
    {
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $actualDate = Carbon::now();
        $declaration = Declaration::VerifyDeclaration($id, $status);
        $statusTax = '';
        $property = Property::where('id', $id)->with('valueGround')->with('type')->get();
        $constProperty = Val_cat_const_inmu::where('property_id', $property[0]->id)->get();
        //$catasGround = CatastralTerreno::where('id', $property[0]->value_cadastral_ground_id)->get();
        $catasBuild = CatastralConstruccion::where('id', $constProperty[0]->value_catas_const_id)->get();
        //$alicuota = Alicuota::where('id', $property[0]->type_inmueble_id)->get();
        $period_fiscal = Carbon::now()->year;
        $userProperty = UserProperty::where('property_id', $property[0]->id)->get();
//        $propertyTaxes = PropertyTaxes::find('company_id', $id);
        $propertyTaxes = Property::find($id);
        $taxes = $propertyTaxes->propertyTaxes()->where('branch','Inm.Urbanos')->whereYear('fiscal_period','=',$actualDate->format('Y'))->get();
        if(!empty($taxes)) {
            foreach ($taxes as $tax) {
                if($tax->status === 'verified'||$tax->status==='verified-sysprim'){
                    $statusTax = 'verified';
                }else if($tax->status === 'temporal'){
//                $tax->delete();
                    $statusTax = 'new';
                }else if($tax->status === 'ticket-office' && $tax->created_at->format('d-m-Y') === $actualDate->format('d-m-Y') ){
                    $statusTax = 'process';
                } else if($tax->status === 'process' && $tax->created_at->format('d-m-Y') === $actualDate->format('d-m-Y')){
                    $statusTax = 'process';
                }else{
                    $statusTax = 'new';
                }
            }
        }
        else {
            $statusTax = 'new';
        }
        // Realizar verificacion si el propietario es una compañia o es una persona
        if($userProperty[0]->company_id != null) {
            $owner_id = $userProperty[0]->company_id;
            $owner_type = 'company';
            $owner = Company::find($owner_id);
        }
        elseif($userProperty[0]->person_id != null) {
            $owner_id = $userProperty[0]->person_id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        }
        else{
            $owner_id = \Auth::user()->id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        }
        if($status == 'full'){
            $baseImponible = number_format($declaration['baseImponible'],2,',','.');
            $totalGround = number_format($declaration['totalGround'],2,',','.');
            $totalBuild = number_format($declaration['totalBuild'],2,',','.');
            $discount = number_format($declaration['porcentaje'],2,',','.');
            $total = number_format($declaration['total'],2,',','.');
        }
        /*elseif($status == 'trimestral') {
            $calculateBaseImponible = $declaration['baseImponible'] / 4;
            $calculateGround = $declaration['totalGround'] / 4;
            $calculateBuild = $declaration['totalBuild'] / 4;
            $calculateDiscount = $declaration['porcentaje'] / 4;
            $calculateTotal = $declaration['total'] / 4;
            $baseImponible = number_format($calculateBaseImponible, 2, ',', '.');
            $totalGround = number_format($calculateGround, 2, ',', '.');
            $totalBuild = number_format($calculateBuild, 2, ',', '.');
            $discount = number_format($calculateDiscount, 2, ',', '.');
            $total = number_format($calculateTotal, 2, ',', '.');
        }*/
        $response = array(
            'property' => $property,
            'declaration' => $declaration,
            'build' => $catasBuild,
            'userProperty' => $userProperty[0],
            'period' => $period_fiscal
        );
        return view('modules.properties-payments.details',array(
            'property' => $property,
            'response'=>$response,
            'owner_type' => $owner_type,
            'owner' => $owner,
            'baseImponible' => $baseImponible,
            'totalGround' => $totalGround,
            'totalBuild' => $totalBuild,
            'discount' => $discount,
            'total' => $total,
            'status' => $status,
            'statusTax' => $statusTax
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
        # Transformacion para los montos
        $value = strval($request->input('amount'));
        $valor = str_replace('.', '', $value);
        $amount = str_replace(',', '.', $valor);

        $valueBase = strval($request->input('base_imponible'));
        $valorBase = str_replace('.', '', $valueBase);
        $baseImponible = str_replace(',', '.', $valorBase);

        $valueRecharge = strval($request->input('recharge'));
        $valorRecharge = str_replace('.', '', $valueRecharge);
        $recharge = str_replace(',', '.', $valorRecharge);

        $valueAlicuota = strval($request->input('alicuota'));
        $valorAlicuota = str_replace('.', '', $valueAlicuota);
        $alicuota = str_replace(',', '.', $valorAlicuota);


        $valueInterest = strval($request->input('interest'));
        $valorInterest = str_replace('.', '', $valueInterest);
        $interest = str_replace(',', '.', $valorInterest);

        $valueDiscount = strval($request->input('discount'));
        $valorDiscount = str_replace('.', '', $valueDiscount);
        $discount = str_replace(',', '.', $valorDiscount);

        $valueFiscalCredit = strval($request->input('fiscal_credit'));
        $valorFiscalCredit = str_replace('.', '', $valueFiscalCredit);
        $fiscalCredit = str_replace(',', '.', $valorFiscalCredit);

//        dd($fiscalCredit);

        $status = $request->input('status');

        # --------------------------------------------------------------
        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxe->status = 'temporal';
//        dd($baseImponible); die();
        $taxe->type='daily';


        $date = Carbon::now();
        $year = $date->year;

        $taxe->fiscal_period = Carbon::parse('01-01-'.$year)->format('Y-m-d');
        $taxe->fiscal_period_end = Carbon::parse('31-12-'.$year)->format('Y-m-d');
        $taxe->branch='Inm.Urbanos';
        $taxe->amount = $amount;
        $taxe->save();
        $taxeId = $taxe->id;

        //$taxes = Taxe::where('id', $taxesId)->get();
        $propertyTaxes = new PropertyTaxes();
        $propertyTaxes->property_id = $request->input('property_id');
        $propertyTaxes->taxe_id = $taxeId;

        $propertyTaxes->base_imponible = $baseImponible;
        $propertyTaxes->recharge = $recharge;
        $propertyTaxes->discount = $discount;
        $propertyTaxes->alicuota = $alicuota;
        $propertyTaxes->interest = $interest;
        if($fiscalCredit == '') {
            $propertyTaxes->fiscal_credit = 0;
        }
        else {
            $propertyTaxes->fiscal_credit = $fiscalCredit;
        }
        $propertyTaxes->status = $status;

        $propertyTaxes->save();
//        dd($propertyTaxes);
        return response()->json(['status' => 'success','taxe_id' => $taxeId]);
    }

    public function calculateAmount(Request $request) {
        $value = strval($request->input('amount'));
        $valor = str_replace('.', '', $value);
        $amount = str_replace(',', '.', $valor);

        $valueFiscalCredit = strval($request->input('fiscal_credit'));
        $valorFiscalCredit = str_replace('.', '', $valueFiscalCredit);
        $fiscalCredit = str_replace(',', '.', $valorFiscalCredit);

        if($fiscalCredit == '' || $fiscalCredit == null) {
            return response()->json([
                'status' => 'void',
                'message' => ''
            ]);
        }
        elseif($fiscalCredit > $amount) {
            $total = 0;
            return response()->json([
                'status' => 'error',
                'message' => 'El crédito fiscal no puede ser mayor al monto total del impuesto.',
                'total' => $total,
            ]);
        }
        else {
            $totalAmount = $amount - $fiscalCredit;
//            var_dump($totalAmount);
            $total = number_format($totalAmount,2,',','.');
            return response()->json([
                'status' => 'success',
                'message' => 'Su total a pagar se ha reducido por un crédito fiscal.',
                'total' => $total,
                'fiscal_credit' => $fiscalCredit
            ]);
        }
    }


    public function typePayment($id) {
        $taxe=Taxe::findOrFail($id);
//        $propertyTaxes = PropertyTaxes::where('taxes_id', $id)->get();
//        dd($propertyTaxes[0]->property_id); die();
        return view('modules.properties-payments.payments',['taxes_id'=>$id, 'taxe' => $taxe]);
    }

    public function pdfTaxpayer($id, $download = null) {
        $taxe = Taxe::find($id);
        $type='';
//        dd($download);
        $owner = $taxe->properties()->get();
        $userProperty = UserProperty::find($owner[0]->pivot->property_id);
        $property = Property::find($userProperty->property_id);
        $propertyTaxes = PropertyTaxes::find($taxe->id);

        if (!is_null($userProperty->company_id)) {
            $data = Company::find($userProperty->company_id);
            $type = 'company';
        } else {
            $data = User::find($userProperty->person_id);
            $type = 'user';
        }
        $pdf = \PDF::loadView('modules.properties-payments.receipt', [
            'taxes' => $taxe,
            'data' => $data,
            'property' => $property,
            'propertyTaxes' => $propertyTaxes
        ]);

        if(isset($download)){
            return $pdf->stream('PLANILLA_TASAS.pdf');
        }else{
            return $pdf->stream('PLANILLA_TASAS.pdf');
        }
//        return $pdf->stream('PLANILLA_INMUEBLE.pdf');
//        return $pdf->download('PLANILLA_INMUEBLE.pdf');
    }

    public function paymentStore(Request $request) {
        $id_taxes = $request->input('id_taxes');
        $type_payment = $request->input('type_payment');
        $bank_payment = $request->input('bank_payment');

        $taxes = Taxe::findOrFail($id_taxes);
        $code = TaxesNumber::generateNumberTaxes($type_payment . "84");
        $taxes->code = $code;
        $code = substr($code, 3, 12);
        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));


        $type = '';
        $owner = $taxes->properties()->get();
        $userProperty = UserProperty::find($owner[0]->pivot->property_id);
        $property = Property::find($userProperty->property_id);

        if (!is_null($userProperty->company_id)) {
            $data = Company::find($userProperty->company_id);
            $type = 'company';
        } else {
            $data = User::find($userProperty->person_id);
            $type = 'user';
        }
        $propertyTaxes = PropertyTaxes::where('taxe_id',$id_taxes)->first();
        if ($type_payment != 'PPV') {

            if ($type_payment == 'PPE') {
                $taxes->bank = $bank_payment;
                $amount = round($taxes->amount, 0);
                $taxes->amount = $amount;
                $taxes->digit = TaxesNumber::generateNumberSecret($amount, $date_format, $bank_payment, $code);
            } else {
                $taxes->bank = $bank_payment;
                $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank_payment, $code);
            }
        }

        $taxes->status = "process";
        $taxes->update();

//        dd($propertyTaxes);
        $subject = "PLANILLA DE PAGO";
        $for = \Auth::user()->email;

        $pdf = \PDF::loadView('modules.properties-payments.receipt', [
            'taxes' => $taxes,
            'data' => $data,
            'firm' => false,
            'type' => $type,
            'propertyTaxes' => $propertyTaxes,
            'property' => $property
        ]);

        return $pdf->stream();
//        die();
        Mail::send('mails.payment-payroll', ['type' => 'Declaración de Inmuebles Urbanos'], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("semat.alcaldia.iribarren@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
            $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });

        return redirect('properties/payments/history/'.$property->id)->with('message', 'La planilla fue registra con éxito,fue enviado al correo ' . \Auth::user()->email . ',recuerda que esta planilla es valida solo por el dia ' . $date);
    }


    public function paymentHistoryTaxPayers($id){
        $property = Property::find($id);
        $taxes = $property->propertyTaxes()->distinct()->orderBy('id','desc')->get();
        return view('modules.properties-payments.history', ['property' => $property,'taxes' =>$taxes]);
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

    public function discount(Request $request)
    {
        $value = strval($request->input('value'));
        $valor = str_replace('.', '', $value);
        $valor1 = str_replace(',', '.', $valor);
        $descuento = $valor1 * 0.20;
        $total = $valor1 - $descuento;
        $total1 = number_format($total, 2, ',', '.');

        return response()->json(['value' => $total1]);

    }

    public function fractionalCalculation(Request $request)
    {
        $value = strval($request->input('value'));
        $valor = str_replace('.', '', $value);
        $valor1 = str_replace(',', '.', $valor);
        $total = $valor1 / 4;
        $fraccionado = number_format($total, 2, ',', '.');

        return response()->json(['value' => $fraccionado]);
    }

    public function manageTicketOffice() {
        return view('modules.properties.ticket-office.manage');
    }

    public function generateTicketOfficePayroll() {
        $catastralTerreno = CatastralTerreno::all();
//        dd($catastralTerreno[0]);
        $catastralConstruccion = CatastralConstruccion::all();
        $parish = Parish::all();
        $alicuota= Alicuota::all();
        return view('modules.properties.ticket-office.generate',[
            'catastralConstruccion' => $catastralConstruccion,
            'catastralTerreno' => $catastralTerreno,
            'parish' => $parish,
            'alicuota' => $alicuota
        ]);
    }

    public function findCode($code) {
        $property = Property::where('code_cadastral', $code)->with('users')->first();
        if($property == null) {
            $response = [
                'status' => 'error',
                'message' => 'El inmueble con el código catastral no se encuentra registrado. Por favor, ingrese un código valido.'
            ];
        }
        else {
            $response = [
                'status' => 'success',
                'property' => $property,
            ];
        }
        return response()->json($response);
    }

    public function taxesTicketOfficePayroll($id, $status, $fiscal_period) {
        $actualDate = Carbon::now();
        $statusTax = '';
        $property = Property::where('id', $id)->with('valueGround')->with('type')->get();
        $userProperty = UserProperty::where('property_id', $property[0]->id)->get();
        $declaration = Declaration::VerifyDeclaration($id, $status, $fiscal_period);
        // Realizar verificacion si el propietario es una compañia o es una persona
        if($userProperty[0]->company_id != null) {
            $owner_id = $userProperty[0]->company_id;
            $owner_type = 'company';
            $owner = Company::find($owner_id);
        }
        elseif($userProperty[0]->person_id != null) {
            $owner_id = $userProperty[0]->person_id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        }
        else{
            $owner_id = \Auth::user()->id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        }
        if($status == 'full'){
            $baseImponible = number_format($declaration['baseImponible'],2,',','.');
            $totalGround = number_format($declaration['totalGround'],2,',','.');
            $totalBuild = number_format($declaration['totalBuild'],2,',','.');
            $discount = number_format($declaration['discount'],2,',','.');
            $alicuota = number_format($declaration['porcentaje'],2,',','.');
            $recharge = number_format($declaration['recharge'],2,',','.');
            $interest = number_format($declaration['interest'],2,',','.');
            $total = number_format($declaration['total'],2,',','.');
        }
        /*elseif($status == 'trimestral') {
            $calculateBaseImponible = $declaration['baseImponible'] / 4;
            $calculateGround = $declaration['totalGround'] / 4;
            $calculateBuild = $declaration['totalBuild'] / 4;
            $calculateDiscount = $declaration['porcentaje'] / 4;
            $calculateTotal = $declaration['total'] / 4;
            $baseImponible = number_format($calculateBaseImponible, 2, ',', '.');
            $totalGround = number_format($calculateGround, 2, ',', '.');
            $totalBuild = number_format($calculateBuild, 2, ',', '.');
            $discount = number_format($calculateDiscount, 2, ',', '.');
            $total = number_format($calculateTotal, 2, ',', '.');
        }*/
        $resp = [
            'state' => 'success',
            'message' => 'Por favor, verifique los montos antes de generar la planilla',
            'property' => $property,
            'declaration' => $declaration,
            'userProperty' => $userProperty[0],
            'owner_type' => $owner_type,
            'owner' => $owner,
            'baseImponible' => $baseImponible,
            'totalGround' => $totalGround,
            'totalBuild' => $totalBuild,
            'discount' => $discount,
            'total' => $total,
            'recharge' => $recharge,
            'interest' => $interest,
            'alicuota' => $alicuota,
            'status' => $status,
            'statusTax' => $statusTax,
//            'taxe_id' => $taxe_id
        ];
//        dd($declaration);
        return response()->json($resp);
    }

    public function storeTicketOffice(Request $request) {
        # Transformacion para los montos
        $value = strval($request->input('amount'));
        $valor = str_replace('.', '', $value);
        $amount = str_replace(',', '.', $valor);

        $valueBase = strval($request->input('base_imponible'));
        $valorBase = str_replace('.', '', $valueBase);
        $baseImponible = str_replace(',', '.', $valorBase);

        $valueRecharge = strval($request->input('recharge'));
        $valorRecharge = str_replace('.', '', $valueRecharge);
        $recharge = str_replace(',', '.', $valorRecharge);

        $valueAlicuota = strval($request->input('alicuota'));
        $valorAlicuota = str_replace('.', '', $valueAlicuota);
        $alicuota = str_replace(',', '.', $valorAlicuota);


        $valueInterest = strval($request->input('interest'));
        $valorInterest = str_replace('.', '', $valueInterest);
        $interest = str_replace(',', '.', $valorInterest);

        $valueDiscount = strval($request->input('discount'));
        $valorDiscount = str_replace('.', '', $valueDiscount);
        $discount = str_replace(',', '.', $valorDiscount);

        $valueFiscalCredit = strval($request->input('fiscal_credit'));
        $valorFiscalCredit = str_replace('.', '', $valueFiscalCredit);
        $fiscalCredit = str_replace(',', '.', $valorFiscalCredit);

        $status = $request->input('status');
        $fiscalPeriod = $request->input('fiscal_period');
        # --------------------------------------------------------------
        $date = Carbon::parse($fiscalPeriod);
        $year = $date->year;
        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('PTS84');
        $taxe->status = 'ticket-office';
//        dd($baseImponible); die();
        $taxe->type='daily';

        $taxe->fiscal_period = $fiscalPeriod;
        $taxe->fiscal_period_end = Carbon::parse('31-12-'.$year)->format('Y-m-d');
        $taxe->branch='Inm.Urbanos';
        $taxe->amount = $amount;
        $taxe->save();
        $taxeId = $taxe->id;

        //$taxes = Taxe::where('id', $taxesId)->get();
        $propertyTaxes = new PropertyTaxes();
        $propertyTaxes->property_id = $request->input('property_id');
        $propertyTaxes->taxe_id = $taxeId;

        $propertyTaxes->base_imponible = $baseImponible;
        $propertyTaxes->recharge = $recharge;
        $propertyTaxes->discount = $discount;
        $propertyTaxes->alicuota = $alicuota;
        $propertyTaxes->interest = $interest;
        if($fiscalCredit == '') {
            $propertyTaxes->fiscal_credit = 0;
        }
        else {
            $propertyTaxes->fiscal_credit = $fiscalCredit;
        }
        $propertyTaxes->status = $status;

        $propertyTaxes->save();
        return response()->json(['status' => 'success', 'message' => 'Se ha generado una planilla.','taxe_id' => $taxeId]);
    }

    public function getTaxesTicketOffice() {
        $taxes = Audit::where('user_id', \Auth::user()->id)
            ->where('event', 'created')
            ->where('auditable_type', 'App\Taxe')
            ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();

        if (!$taxes->isEmpty()) {
            foreach ($taxes as $taxe) {
                $id_taxes[] = $taxe->auditable_id;
            }
            if (count($id_taxes) !== 0) {
                $taxes = Taxe::where('status', '=', 'ticket-office')->where('branch', '=','Inm.Urbanos')->whereIn('id', $id_taxes)->get();
            } else {
                $amount_taxes = null;
                $taxes = null;
            }
        } else {
            $amount_taxes = null;
            $taxes = null;
        }

        /*foreach ($taxes as $index => $taxe) {
            dd($taxe->properties[$index]->code_cadastral);

        }*/
        return view('modules.properties.ticket-office.payment', ['taxes' => $taxes]);
    }

    public function detailsTicketOffice($id, $status = 'full') {
        $taxes = Taxe::findOrFail($id);
        $propertyTaxe = $taxes->properties()
            ->with('valueGround')
            ->with('type')
            ->with('valueBuild')
            ->with('users')
            ->first();
        $userProperty = UserProperty::find($propertyTaxe->pivot->property_id);
        $amounts = Declaration::VerifyDeclaration($propertyTaxe->id, $status,$propertyTaxe->fiscal_period);
//        dd($taxes);
        if (!is_null($userProperty->company_id)) {
            $owner = Company::find($userProperty->company_id);
            $type = 'company';
        } else {
            $owner = User::find($userProperty->person_id);
            $type = 'user';
        }



        $verified = true;

        if (!$taxes->payments->isEmpty()) {
            foreach ($taxes->payments as $payment) {
                if ($payment->status != 'verified') {
                    $verified = false;
                }
            }
        } else {
            $verified = false;
        }




//        dd($taxes);
        return view('modules.properties.ticket-office.details', [
            'taxes' => $taxes,
            'amounts' => $amounts,
            'verified' => $verified,
            'propertyTaxe' => $propertyTaxe,
            'status' => $status,
            'owner' => $owner,
            'type' => $type
        ]);
    }

    public function verifyFiscalPeriod($id, $year)
    {
        $date = Carbon::now();
        $property = Property::find($id);
        $taxe = $property->propertyTaxes()->whereDate('fiscal_period',$year)->first();
//        dd($taxe);
//        $propertyTaxe = $pr->taxesVehicle()->whereDate('fiscal_period', $year)->first();
        if (is_null($taxe)) {
            $statusTax = false;
        } else {
            if ($taxe->status === 'verified' || $taxe->status === 'verified-sysprim') {
                $statusTax = true;
            } else if ($taxe->status === 'temporal') {
//                      $tax->delete();
                $statusTax = false;
            } else if ($taxe->status === 'ticket-office' && $taxe->created_at->format('d-m-Y') === $date->format('d-m-Y')) {
                $statusTax = true;
            } else if ($taxe->status === 'process' && $taxe->created_at->format('d-m-Y') === $date->format('d-m-Y')) {
                $statusTax = true;
            } else if ($taxe->status === 'cancel') {
                $statusTax = false;
            }

            return Response()->json($statusTax);
        }
    }

    public function generateReceipt($taxes_data) {
        //$taxes_data = substr($taxes_data, 0, -1);
        $taxes_explode = explode('-', $taxes_data);

        $taxes = Taxe::whereIn('id', $taxes_explode)->with('properties')->get();
        $property = Property::find($taxes[0]->properties[0]->id);
        $userProperty = UserProperty::find($taxes[0]->properties[0]->id);
//        dd($userProperty);
        if (!is_null($userProperty->company_id)) {
            $data = Company::find($userProperty->company_id);
            $type = 'company';
        } else {
            $data = User::find($userProperty->person_id);
            $type = 'user';
        }
        $pdf = \PDF::loadView('modules.properties.ticket-office.receipt', [
            'taxes' => $taxes,
            'property' => $property,
            'data' => $data,
            'type' => $type
        ]);

        return $pdf->stream();
    }
}
