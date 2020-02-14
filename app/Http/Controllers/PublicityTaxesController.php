<?php

namespace App\Http\Controllers;

use App\Helpers\DeclarationPublicity;
use App\UserPublicity;
use Illuminate\Http\Request;
use App\Publicity;
use App\PublicityTaxe; 
use App\AdvertisingType;
use Carbon\Carbon;
use App\Tributo;
use App\Taxe;
use App\Helpers\TaxesNumber;
use App\User;
use App\Company;
use OwenIt\Auditing\Models\Audit;




class PublicityTaxesController extends Controller
{
    public function index($id)
    {
        $publicity = Publicity::find($id);
        return view('modules.publicity-payments.manage', ['publicity' => $publicity]);
    }

    public function create($id) {
        $period_fiscal = Carbon::now()->year; // Año del periodo fiscal
        $actualDate = Carbon::now(); // Fecha actual
        $statusTax = '';


        $advertisingTypes = AdvertisingType::all();
        $publicity = Publicity::find($id);
        $declaration = DeclarationPublicity::Declarate($id);
        $userPublicity = UserPublicity::where('publicity_id',$id)->first();
        $base = $declaration['baseImponible'];
        $taxes = $publicity->publicityTaxes()->where('branch','Prop. y Publicidad')->whereYear('fiscal_period','=',$actualDate->format('Y'))->get();
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
        if($userPublicity->company_id != null) {
            $owner_id = $userPublicity->company_id;
            $owner_type = 'company';
            $owner = Company::find($owner_id);
        }
        elseif($userPublicity->person_id != null) {
            $owner_id = $userPublicity->person_id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        }
        else{
            $owner_id = \Auth::user()->id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        }
        $baseImponible = number_format($declaration['baseImponible'],2,',','.');
//        $interest = number_format($declaration['interest'],2,',','.');
        $amount = number_format($declaration['total'],2,',','.');
//        dd($statusTax);


//        dd($baseImponible);
    	return view('modules.publicity-payments.register', [
    		'advertisingTypes' => $advertisingTypes,
    		'publicity' => $publicity,
            'base' => $base,
            'baseImponible' => $baseImponible,
//            'interest' => $interest,
            'amount' => $amount,
            'owner_type' => $owner_type,
            'owner' => $owner,
            'statusTax' => $statusTax,
            'daysDiff' => $declaration['daysDiff']
    	]);
    }

    public function store(Request $request) {
        # Transformacion para los montos
        $value = strval($request->input('amount'));
        $valor = str_replace('.', '', $value);
        $amount = str_replace(',', '.', $valor);

        $valueBase = strval($request->input('base_imponible'));
        $valorBase = str_replace('.', '', $valueBase);
        $baseImponible = str_replace(',', '.', $valorBase);

        /*$valueInterest = strval($request->input('interest'));
        $valorInterest = str_replace('.', '', $valueInterest);
        $interest = str_replace(',', '.', $valorInterest);*/

        $valueFiscalCredit = strval($request->input('fiscal_credit'));
        $valorFiscalCredit = str_replace('.', '', $valueFiscalCredit);
        $fiscalCredit = str_replace(',', '.', $valorFiscalCredit);

        # --------------------------------------------------------------
        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxe->status = 'temporal';
//        dd($baseImponible); die();
        $taxe->type='daily';

        $date = Carbon::now();
        $year = $date->year;

//        dd($amount);

        $taxe->fiscal_period = Carbon::parse('01-01-'.$year)->format('Y-m-d');
        $taxe->fiscal_period_end = Carbon::parse('31-12-'.$year)->format('Y-m-d');
        $taxe->branch = 'Prop. y Publicidad';
        $taxe->amount = $amount;
        $taxe->save();
        $taxeId = $taxe->id;

        $publicityTaxes = new PublicityTaxe();
        $publicityTaxes->publicity_id = $request->input('publicity_id');
        $publicityTaxes->taxe_id = $taxeId;
        $publicityTaxes->base_imponible = $baseImponible;
//        $publicityTaxes->interest = $interest;
        $publicityTaxes->fiscal_credit = $fiscalCredit;
        if($fiscalCredit == '') {
            $publicityTaxes->fiscal_credit = 0;
        }
        else {
            $publicityTaxes->fiscal_credit = $fiscalCredit;
        }
        $publicityTaxes->save();
        return response()->json(['status' => 'success','taxe_id' => $taxeId]);
    }

    public function typePayment($id) {
        $taxe = Taxe::findOrFail($id);
//        $propertyTaxes = PropertyTaxes::where('taxes_id', $id)->get();
//        dd($propertyTaxes[0]->property_id); die();
//        dd($taxe->publicities[0]);
        return view('modules.publicity-payments.payments',['taxes_id'=>$id, 'taxe' => $taxe]);
    }

    public function paymentStore(Request $request) {
        $id_taxes = $request->input('id_taxes');
        $type_payment = $request->input('type_payment');
        $bank_payment = $request->input('bank_payment');

        $taxes = Taxe::findOrFail($id_taxes);
        $code = TaxesNumber::generateNumberTaxes($type_payment . "86");
        $taxes->code = $code;
        $code = substr($code, 3, 12);
        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));


        $type = '';
        $owner = $taxes->publicities()->get();
        $userPublicity = UserPublicity::where('publicity_id',$owner[0]->pivot->publicity_id)->first();

        $publicity = Publicity::find($userPublicity->publicity_id);

        if (!is_null($userPublicity->company_id)) {
            $data = Company::find($userPublicity->company_id);
            $type = 'company';
        } else {
            $data = User::find($userPublicity->person_id);
            $type = 'user';
        }
        $publicityTaxes = PublicityTaxe::where('taxe_id',$id_taxes)->first();
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

        $pdf = \PDF::loadView('modules.publicity-payments.receipt', [
            'taxes' => $taxes,
            'data' => $data,
            'firm' => false,
            'type' => $type,
            'publicityTaxes' => $publicityTaxes,
            'publicity' => $publicity
        ]);

        /*return $pdf->stream();
        die();*/
        Mail::send('mails.payment-payroll', ['type' => 'Declaración de Propaganda y Publicidad Comercial'], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("semat.alcaldia.iribarren@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
            $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });

        return redirect('properties/payments/history/'.$property->id)->with('message', 'La planilla fue registra con éxito,fue enviado al correo ' . \Auth::user()->email . ',recuerda que esta planilla es valida solo por el dia ' . $date);
    }

    public function paymentHistoryTaxPayers($id){
        $publicity = Publicity::find($id);
        $taxes = $publicity->publicityTaxes()->distinct()->orderBy('id','desc')->get();
        return view('modules.publicity-payments.history', ['publicity' => $publicity,'taxes' =>$taxes]);
    }

    public function pdfTaxpayer($id, $download = null) {
        $taxe = Taxe::find($id);
        $type='';
//        dd($taxe);
        $owner = $taxe->publicities()->get();
        $userPublicity = UserPublicity::where('publicity_id',$owner[0]->pivot->publicity_id)->first();
        $publicity = Publicity::find($userPublicity->publicity_id);
        $publicityTaxes = PublicityTaxe::where('taxe_id',$taxe->id)->first();

        if (!is_null($userPublicity->company_id)) {
            $data = Company::find($userPublicity->company_id);
            $type = 'company';
        } else {
            $data = User::find($userPublicity->person_id);
            $type = 'user';
        }
        $pdf = \PDF::loadView('modules.publicity-payments.receipt', [
            'taxes' => $taxe,
            'data' => $data,
            'publicity' => $publicity,
            'publicityTaxes' => $publicityTaxes,
            'type' => $type
        ]);

        if(isset($download)){
            return $pdf->stream('PLANILLA_INMUEBLE.pdf');
        }else{
            return $pdf->download('PLANILLA_INMUEBLE.pdf');
        }
    }

    public function manageTicketOffice() {
        return view('modules.publicity-payments.ticket-office.manage');
    }

    public function generateTicketOffice() {
        $advertisingTypes = AdvertisingType::all();
        return view('modules.publicity-payments.ticket-office.generate', ['advertisingTypes' => $advertisingTypes]);
    }

    public function findCode($code) {
        $publicity = Publicity::where('code', $code)->with('users')->first();
        if($publicity == null) {
            $response = [
                'status' => 'error',
                'message' => 'La publicidad con el código '. $code .' no se encuentra registrado. Por favor, ingrese un código valido.'
            ];
        }
        else {
            $response = [
                'status' => 'success',
                'publicity' => $publicity,
            ];
        }
        return response()->json($response);
    }

    public function verifyFiscalPeriod($id, $year) {
        $date = Carbon::now();
        $publicity = Publicity::find($id);
        $taxe = $publicity->publicityTaxes()->whereDate('fiscal_period',$year)->first();
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

            return response()->json($statusTax);
        }
    }


}
