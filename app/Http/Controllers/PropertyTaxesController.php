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

    public function create($id, $status)
    {

        $declaration = Declaration::VerifyDeclaration($id, $status);
        $property = Property::where('id', $id)->with('valueGround')->with('type')->get();
        $constProperty = Val_cat_const_inmu::where('property_id', $property[0]->id)->get();
        //$catasGround = CatastralTerreno::where('id', $property[0]->value_cadastral_ground_id)->get();
        $catasBuild = CatastralConstruccion::where('id', $constProperty[0]->value_catas_const_id)->get();
        //$alicuota = Alicuota::where('id', $property[0]->type_inmueble_id)->get();
        $period_fiscal = Carbon::now()->year;
        $userProperty = UserProperty::where('property_id', $property[0]->id)->get();
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
//        dd($person_id); die();
        /*$baseImponible = number_format($declaration['baseImponible'],2,',','.');
        $totalGround = number_format($declaration['totalGround'],2,',','.');
        $totalBuild = number_format($declaration['totalBuild'],2,',','.');
        $discount = number_format($declaration['porcentaje'],2,',','.');
        $total = number_format($declaration['total'],2,',','.');*/
        if($status == 'full'){
            $baseImponible = number_format($declaration['baseImponible'],2,',','.');
            $totalGround = number_format($declaration['totalGround'],2,',','.');
            $totalBuild = number_format($declaration['totalBuild'],2,',','.');
            $discount = number_format($declaration['porcentaje'],2,',','.');
            $total = number_format($declaration['total'],2,',','.');
        }
        elseif($status == 'trimestral') {
            $calculateBaseImponible = $declaration['baseImponible'] / 4;
            $calculateGround = $declaration['totalGround'] / 4;
            $calculateBuild = $declaration['totalBuild'] / 4;
            $calculateDiscount = $declaration['porcentaje'] / 4;
            $calculateTotal = $declaration['total'] / 4;
            $baseImponible = number_format($calculateBaseImponible,2,',','.');
            $totalGround = number_format($calculateGround,2,',','.');
            $totalBuild = number_format($calculateBuild,2,',','.');
            $discount = number_format($calculateDiscount,2,',','.');
            $total = number_format($calculateTotal,2,',','.');
//            dd($discount);
        }
//        dd($discount); die();

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
            'status' => $status
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

        $status = $request->input('status');
//        dd($valueAlicuota); die();

        # --------------------------------------------------------------
        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxe->status = 'temporal';
//        dd($baseImponible); die();
        $taxe->type='daily';
        $taxe->fiscal_period = Carbon::now()->format('Y-m-d');
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
//        $propertyTaxes->discount = $discount;
        $propertyTaxes->alicuota = $alicuota;
        $propertyTaxes->interest = $interest;
        $propertyTaxes->status = $status;

        $propertyTaxes->save();
        return response()->json(['status' => 'success','taxe_id' => $taxeId]);
    }


    public function typePayment($id) {
        $taxe=Taxe::findOrFail($id);
//        $propertyTaxes = PropertyTaxes::where('taxes_id', $id)->get();
//        dd($propertyTaxes[0]->property_id); die();
        return view('modules.properties-payments.payments',['taxes_id'=>$id, 'taxe' => $taxe]);
    }

    public function pdfTaxpayer($id) {
        $taxe = Taxe::find($id);
        $type='';

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
//        return $pdf->stream('PLANILLA_INMUEBLE.pdf');
        return $pdf->download('PLANILLA_INMUEBLE.pdf');
    }

    public function paymentStore(Request $request) {
        $id_taxes = $request->input('id_taxes');
        $type_payment = $request->input('type_payment');
        $bank_payment = $request->input('bank_payment');

        $taxes = Taxe::findOrFail($id_taxes);
        $code = TaxesNumber::generateNumberTaxes($type_payment . "81");
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
        $propertyTaxes = PropertyTaxes::find($id_taxes);
//        dd($propertyTaxes);


//        dd($propertyTaxes); die();

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
        die();
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

}
