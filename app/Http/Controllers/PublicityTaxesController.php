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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class PublicityTaxesController extends Controller
{
    public function index($id)
    {
        $publicity = Publicity::find($id);
        return view('modules.publicity-payments.manage', ['publicity' => $publicity]);
    }

    public function create($id)
    {
        $period_fiscal = Carbon::now()->year; // Año del periodo fiscal
        $actualDate = Carbon::now(); // Fecha actual
        $statusTax = '';


        $advertisingTypes = AdvertisingType::all();
        $publicity = Publicity::find($id);
        $declaration = DeclarationPublicity::Declarate($id);
        $userPublicity = UserPublicity::where('publicity_id', $id)->first();
        $base = $declaration['baseImponible'];
        $taxes = $publicity->publicityTaxes()->where('branch', 'Prop. y Publicidad')->whereYear('fiscal_period', '=', $actualDate->format('Y'))->get();
        if (!empty($taxes)) {
            foreach ($taxes as $tax) {
                if ($tax->status === 'verified' || $tax->status === 'verified-sysprim') {
                    $statusTax = 'verified';
                } else if ($tax->status === 'temporal') {
                    DeclarationPublicity::verify($tax->id);
                    $statusTax = 'new';
                } else if ($tax->status === 'ticket-office' && $tax->created_at->format('d-m-Y') === $actualDate->format('d-m-Y')) {
                    $statusTax = 'process';
                } else if ($tax->status === 'process' && $tax->created_at->format('d-m-Y') === $actualDate->format('d-m-Y')) {
                    $statusTax = 'process';
                } else {
                    $statusTax = 'new';
                }
            }
        } else {
            $statusTax = 'new';
        }
        if ($userPublicity->company_id != null) {
            $owner_id = $userPublicity->company_id;
            $owner_type = 'company';
            $owner = Company::find($owner_id);
        } elseif ($userPublicity->person_id != null) {
            $owner_id = $userPublicity->person_id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        } else {
            $owner_id = \Auth::user()->id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        }
        # Declarating variables to generate taxe
        $amount = $declaration['total'];
        $baseImponible = $declaration['baseImponible'];
        $increment = $declaration['increment'];
        $taxeType = $declaration['taxeType'];
        $fiscalCredit = 0;
        $date = Carbon::now();
        $year = $date->year;    

        # Creating Temporal Taxe --------------------------------
        # --------------------------------------------------------------
        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxe->status = 'temporal';
        $taxe->type = $taxeType;
        $taxe->fiscal_period = Carbon::parse('01-01-' . $year)->format('Y-m-d');
        $taxe->fiscal_period_end = Carbon::parse('31-12-' . $year)->format('Y-m-d');
        $taxe->branch = 'Prop. y Publicidad';
        $taxe->amount = $amount;
        $taxe->save();
        $taxeId = $taxe->id;

        $publicityTaxes = new PublicityTaxe();
        $publicityTaxes->publicity_id = $publicity->id;
        $publicityTaxes->taxe_id = $taxeId;
        $publicityTaxes->base_imponible = $baseImponible;
        $publicityTaxes->increment = $increment;
//        $publicityTaxes->interest = $interest;
        $publicityTaxes->fiscal_credit = $fiscalCredit;
        $publicityTaxes->save();
        # ---------------------------------------------------

        $baseImponible = number_format($declaration['baseImponible'], 2, ',', '.');
        $increment = number_format($declaration['increment'], 2, ',', '.');
//        $interest = number_format($declaration['interest'],2,',','.');
        $amount = number_format($declaration['total'], 2, ',', '.');

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
            'daysDiff' => $declaration['daysDiff'],
            'increment' => $increment,
            'taxeType' => $taxeType,
            'taxe_id' => $taxeId
    	]);
    }

    public function store(Request $request)
    {
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

        $valueIncrement = strval($request->input('increment'));
        $valorIncrement = str_replace('.', '', $valueIncrement);
        $increment = str_replace(',', '.', $valorIncrement);

        $valueFiscalCredit = strval($request->input('fiscal_credit'));
        $valorFiscalCredit = str_replace('.', '', $valueFiscalCredit);
        $fiscalCredit = str_replace(',', '.', $valorFiscalCredit);


        $taxeType = $request->input('type');

        # --------------------------------------------------------------
//         $taxe = new Taxe();
//         $taxe->code = TaxesNumber::generateNumberTaxes('TEM');
//         $taxe->status = 'temporal';
// //        dd($baseImponible); die();
//         $taxe->type = $taxeType;

//         $date = Carbon::now();
//         $year = $date->year;

// //        dd($amount);

//         $taxe->fiscal_period = Carbon::parse('01-01-' . $year)->format('Y-m-d');
//         $taxe->fiscal_period_end = Carbon::parse('31-12-' . $year)->format('Y-m-d');
//         $taxe->branch = 'Prop. y Publicidad';
//         $taxe->amount = $amount;
//         $taxe->save();
//         $taxeId = $taxe->id;

//         $publicityTaxes = new PublicityTaxe();
//         $publicityTaxes->publicity_id = $request->input('publicity_id');
//         $publicityTaxes->taxe_id = $taxeId;
//         $publicityTaxes->base_imponible = $baseImponible;
//         $publicityTaxes->increment = $increment;

// //        $publicityTaxes->interest = $interest;
//         $publicityTaxes->fiscal_credit = $fiscalCredit;
//         if ($fiscalCredit == '') {
//             $publicityTaxes->fiscal_credit = 0;
//         } else {
//             $publicityTaxes->fiscal_credit = $fiscalCredit;
//         }
//         $publicityTaxes->save();
        return response()->json(['status' => 'success', 'taxe_id' => $taxeId]);
    }

    public function calculateAmount(Request $request) {
        $publicityId = $request->input('publicity_id');
        $taxeId = $request->input('taxe_id');
        $publicityTaxe = PublicityTaxe::where('taxe_id', $taxeId)->first();
        $taxe = Taxe::find($taxeId);

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
            $totalAmount = $taxe->amount - $fiscalCredit;
            $publicityTaxe->fiscal_credit = $fiscalCredit;
            $publicityTaxe->update();
            $taxe->amount = $totalAmount;
            $taxe->update();
            $total = number_format($totalAmount,2,',','.');
            return response()->json([
                'status' => 'success',
                'message' => 'Su total a pagar se ha reducido por un crédito fiscal.',
                'total' => $total,
                'fiscal_credit' => $fiscalCredit
            ]);
        }
    }

    public function typePayment($id)
    {
        $taxe = Taxe::findOrFail($id);
        return view('modules.publicity-payments.payments', ['taxes_id' => $id, 'taxe' => $taxe]);
    }

    public function paymentStore(Request $request)
    {
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
        $userPublicity = UserPublicity::where('publicity_id', $owner[0]->pivot->publicity_id)->first();

        $publicity = Publicity::find($userPublicity->publicity_id);

        if (!is_null($userPublicity->company_id)) {
            $data = Company::find($userPublicity->company_id);
            $type = 'company';
        } else {
            $data = User::find($userPublicity->person_id);
            $type = 'user';
        }
        $publicityTaxes = PublicityTaxe::where('taxe_id', $id_taxes)->first();
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

        return redirect('publicity/payments/history/' . $publicity->id)->with('message', 'La planilla fue registra con éxito,fue enviado al correo ' . \Auth::user()->email . ',recuerda que esta planilla es valida solo por el dia ' . $date);
    }

    public function paymentHistoryTaxPayers($id)
    {
        $publicity = Publicity::find($id);
        $taxes = $publicity->publicityTaxes()->distinct()->orderBy('id', 'desc')->get();
        return view('modules.publicity-payments.history', ['publicity' => $publicity, 'taxes' => $taxes]);
    }

    public function pdfTaxpayer($id, $download = null)
    {
        $taxe = Taxe::find($id);
        $type = '';
//        dd($taxe);
        $owner = $taxe->publicities()->get();
        $userPublicity = UserPublicity::where('publicity_id', $owner[0]->pivot->publicity_id)->first();
        $publicity = Publicity::find($userPublicity->publicity_id);
        $publicityTaxes = PublicityTaxe::where('taxe_id', $taxe->id)->first();

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

        if (isset($download)) {
            return $pdf->stream('PLANILLA_PUBLICIDAD.pdf');
        } else {
            return $pdf->download('PLANILLA_PUBLICIDAD.pdf');
        }
    }

    public function manageTicketOffice()
    {
        return view('modules.publicity-payments.ticket-office.manage');
    }

    public function generateTicketOffice()
    {
        $advertisingTypes = AdvertisingType::all();
        return view('modules.publicity-payments.ticket-office.generate', ['advertisingTypes' => $advertisingTypes]);
    }

    public function findCode($code)
    {
        $publicity = Publicity::where('code', $code)->with('users')->first();
        $declaration = DeclarationPublicity::Declarate($publicity->id);
        if($publicity == null) {
            $response = [
                'status' => 'error',
                'message' => 'La publicidad con el código ' . $code . ' no se encuentra registrado. Por favor, ingrese un código valido.'
            ];
        } else {
            $response = [
                'status' => 'success',
                'publicity' => $publicity,
                'type' => $declaration['taxeType']
            ];
        }
        return response()->json($response);
    }

    public function verifyFiscalPeriod($id, $year)
    {
        $date = Carbon::now();
        $publicity = Publicity::find($id);
        $taxe = $publicity->publicityTaxes()->whereDate('fiscal_period',$year)->first();
        if (is_null($taxe)) {
            $statusTax = false;
        } else {
            if ($taxe->status === 'verified' || $taxe->status === 'verified-sysprim') {
                $statusTax = true;
            } elseif ($taxe->status === 'temporal') {
//                      $tax->delete();
                $statusTax = false;
            } elseif ($taxe->status === 'ticket-office' && $taxe->created_at->format('d-m-Y') === $date->format('d-m-Y')) {
                $statusTax = true;
            } elseif ($taxe->status === 'process' && $taxe->created_at->format('d-m-Y') === $date->format('d-m-Y')) {
                $statusTax = true;
            } elseif ($taxe->status === 'cancel') {
                $statusTax = false;
            }
        }
        return response()->json($statusTax);
    }

    public function taxesTicketOfficePayroll($id, $status, $fiscal_period) {
        $period_fiscal = Carbon::now()->year; // Año del periodo fiscal
        $actualDate = Carbon::now(); // Fecha actual
        $statusTax = '';

//        $advertisingTypes = AdvertisingType::all();
        $publicity = Publicity::where('id', $id)->with('advertisingType')->first();
        $declaration = DeclarationPublicity::Declarate($publicity->id);
        $userPublicity = UserPublicity::where('publicity_id', $id)->first();
        $base = $declaration['baseImponible'];
//         $taxes = $publicity->publicityTaxes()->where('branch', 'Prop. y Publicidad')->whereYear('fiscal_period', '=', $actualDate->format('Y'))->get();
//         if (!empty($taxes)) {
//             foreach ($taxes as $tax) {
//                 if ($tax->status === 'verified' || $tax->status === 'verified-sysprim') {
//                     $statusTax = 'verified';
//                 } else if ($tax->status === 'temporal') {
// //                $tax->delete();
//                     $statusTax = 'new';
//                 } else if ($tax->status === 'ticket-office' && $tax->created_at->format('d-m-Y') === $actualDate->format('d-m-Y')) {
//                     $statusTax = 'process';
//                 } else if ($tax->status === 'process' && $tax->created_at->format('d-m-Y') === $actualDate->format('d-m-Y')) {
//                     $statusTax = 'process';
//                 } else {
//                     $statusTax = 'new';
//                 }
//             }
//         } else {
//             $statusTax = 'new';
//         }
        # Declarating variables to generate taxe
        $amount = $declaration['total'];
        $baseImponible = $declaration['baseImponible'];
        $increment = $declaration['increment'];
        $taxeType = $declaration['taxeType'];
        $fiscalPeriod = $fiscal_period;
        $fiscalCredit = 0;
        $date = Carbon::parse($fiscal_period);
        $year = $date->year;

        # Creating Temporal Taxe --------------------------------
        # --------------------------------------------------------------
        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('PTS86');
        $taxe->status = 'ticket-office';
        $taxe->type = $taxeType;
        $taxe->fiscal_period = $fiscalPeriod;
        $taxe->fiscal_period_end = Carbon::parse('31-12-'.$year)->format('Y-m-d');
        $taxe->branch = 'Prop. y Publicidad';
        $taxe->amount = $amount;
        $taxe->save();

        $taxeId = $taxe->id;
        $publicityTaxes = new PublicityTaxe();
        $publicityTaxes->publicity_id = $publicity->id;
        $publicityTaxes->taxe_id = $taxeId;
        $publicityTaxes->base_imponible = $baseImponible;
        $publicityTaxes->increment = $increment;
//        $publicityTaxes->interest = $interest;
        $publicityTaxes->fiscal_credit = $fiscalCredit;
        $publicityTaxes->save();
        # -------------------------------------------------------------------
        if ($userPublicity->company_id != null) {
            $owner_id = $userPublicity->company_id;
            $owner_type = 'company';
            $owner = Company::find($owner_id);
        } elseif ($userPublicity->person_id != null) {
            $owner_id = $userPublicity->person_id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        } else {
            $owner_id = \Auth::user()->id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        }
        $baseImponible = number_format($declaration['baseImponible'], 2, ',', '.');
//        $interest = number_format($declaration['interest'],2,',','.');
        $increment = number_format($declaration['increment'],2,',','.');
        $amount = number_format($declaration['total'],2,',','.');
        $taxeType = $declaration['taxeType'];
        $resp = [
            'state' => 'success',
            'message' => 'Por favor, verifique los montos antes de generar la planilla',
            'publicity' => $publicity,
            'declaration' => $declaration,
            'userPublicity' => $userPublicity,
            'owner_type' => $owner_type,
            'owner' => $owner,
            'base' => $base,
            'baseImponible' => $baseImponible,
            'increment' => $increment,
            'amount' => $amount,
            'status' => $status,
            'statusTax' => $statusTax,
            'taxeType' => $taxeType,
//            'advertisingTypes' => $advertisingTypes
           'taxe_id' => $taxeId
        ];

        return response()->json($resp);
    }

    public function storeTicketOffice(Request $request)
    {
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

        $valueIncrement = strval($request->input('increment'));
        $valorIncrement = str_replace('.', '', $valueIncrement);
        $increment = str_replace(',', '.', $valorIncrement);

        $valueFiscalCredit = strval($request->input('fiscal_credit'));
        $valorFiscalCredit = str_replace('.', '', $valueFiscalCredit);
        $fiscalCredit = str_replace(',', '.', $valorFiscalCredit);


        $type = $request->input('status');
        $fiscalPeriod = $request->input('fiscal_period');

        # --------------------------------------------------------------
        $date = Carbon::parse($fiscalPeriod);
        $year = $date->year;

        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('PTS86');
        $taxe->status = 'ticket-office';
        $taxe->type = $type;
        $taxe->fiscal_period = $fiscalPeriod;
        $taxe->fiscal_period_end = Carbon::parse('31-12-'.$year)->format('Y-m-d');
        $taxe->branch = 'Prop. y Publicidad';
        $taxe->amount = $amount;
        $taxe->save();
        $taxeId = $taxe->id;

        $publicityTaxes = new PublicityTaxe();
        $publicityTaxes->publicity_id = $request->input('publicity_id');
        $publicityTaxes->taxe_id = $taxeId;
        $publicityTaxes->base_imponible = $baseImponible;
        $publicityTaxes->increment = $increment;
//        $publicityTaxes->interest = $interest;
        $publicityTaxes->fiscal_credit = $fiscalCredit;
        if ($fiscalCredit == '') {
            $publicityTaxes->fiscal_credit = 0;
        } else {
            $publicityTaxes->fiscal_credit = $fiscalCredit;
        }
        $publicityTaxes->save();
        return response()->json(['status' => 'success', 'message' => 'Se ha generado una planilla.', 'taxe_id' => $taxeId]);
    }

    public function detailsTicketOffice($id, $status = 'full')
    {
        $taxes = Taxe::findOrFail($id);
        $publicityTaxe = $taxes->publicities()
            ->with('advertisingType')
            ->with('users')
            ->first();
//        dd($publicityTaxe);

        $advertisingTypes = AdvertisingType::all();
        $publicity = Publicity::find($publicityTaxe->pivot->publicity_id);
        $userPublicity = UserPublicity::where('publicity_id', $publicityTaxe->pivot->publicity_id)->first();
        $declaration = DeclarationPublicity::Declarate($publicityTaxe->id);
//        dd($taxes);
        if (!is_null($userPublicity->company_id)) {
            $owner = Company::find($userPublicity->company_id);
            $type = 'company';
        } else {
            $owner = User::find($userPublicity->person_id);
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
        $daysDiff = $declaration['daysDiff'];

        return view('modules.publicity-payments.ticket-office.details', [
            'taxes' => $taxes,
            'declaration' => $declaration,
            'verified' => $verified,
            'publicityTaxe' => $publicityTaxe,
            'status' => $status,
            'owner' => $owner,
            'type' => $type,
            'publicity' => $publicity,
            'advertisingTypes' => $advertisingTypes,
            'daysDiff' => $daysDiff,
        ]);
    }


    public function getTaxesTicketOffice()
    {
        session()->forget('publicity');
        $taxes = Audit::where('user_id', \Auth::user()->id)
            ->where('event', 'created')
            ->where('auditable_type', 'App\Taxe')
            ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
//        dd($taxes);
        if (!$taxes->isEmpty()) {
            foreach ($taxes as $taxe) {
                $id_taxes[] = $taxe->auditable_id;
            }
            if (count($id_taxes) !== 0) {
                $taxes = Taxe::where('status', '=', 'ticket-office')->where('branch', '=', 'Prop. y Publicidad')->whereIn('id', $id_taxes)->with('publicities')->get();
            } else {
                $amount_taxes = null;
                $taxes = null;
            }
        } else {
            $amount_taxes = null;
            $taxes = null;
        }
        return view('modules.publicity-payments.ticket-office.payment', ['taxes' => $taxes]);
    }

    public function generateReceipt($taxes_data)
    {
        //$taxes_data = substr($taxes_data, 0, -1);
        $taxes_explode = explode('-', $taxes_data);

        $taxes = Taxe::whereIn('id', $taxes_explode)->with('publicities')->get();
        $publicity = Publicity::find($taxes[0]->publicities[0]->id);
        $userPublicity = UserPublicity::where('publicity_id', $taxes[0]->publicities[0]->id)->first();
//        dd($userProperty);
        if (!is_null($userPublicity->company_id)) {
            $data = Company::find($userPublicity->company_id);
            $type = 'company';
        } else {
            $data = User::find($userPublicity->person_id);
            $type = 'user';
        }
        $pdf = \PDF::loadView('modules.publicity-payments.ticket-office.receipt', [
            'taxes' => $taxes,
            'publicity' => $publicity,
            'data' => $data,
            'type' => $type
        ]);

        return $pdf->stream();
    }

    public function QrTaxes($id)
    {
        try {
            $id = Crypt::decrypt($id);

            $taxe = Taxe::with('publicities')->where('id', $id)->get();

            if ($taxe[0]->status === 'verified' || $taxe[0]->status === 'verified-sysprim') {
                return response()->json(['status' => 'verified', 'taxe' => null, 'calculate' => null, 'ciu' => null]);
            } elseif ($taxe[0]->status === 'cancel') {
                return response()->json(['status' => 'cancel', 'taxe' => null, 'calculate' => null, 'ciu' => null]);
            } elseif ($taxe[0]->created_at->format('d-m-Y') !== Carbon::now()->format('d-m-Y')) {
                $taxe_find = Taxe::find($taxe[0]->id);
                $taxe_find->status = 'cancel';
                $taxe_find->update();
                return response()->json(['status' => 'old', 'taxe' => null, 'calculate' => null, 'ciu' => null]);

            } else {
                $calculateTaxes = Calculate::calculateTaxes($id);
                return response()->json(['status' => 'process', 'taxe' => $taxe, 'calculate' => $calculateTaxes]);
            }

        } catch (DecryptException $e) {
            $code = strtoupper($id);
            $taxe = Taxe::with('publicities')->where('code', $code)->get();
            if (!$taxe->isEmpty()) {
                if ($taxe[0]->status === 'verified' || $taxe[0]->status === 'verified-sysprim') {
                    return response()->json(['status' => 'verified', 'taxe' => null, 'calculate' => null]);
                } elseif ($taxe[0]->status === 'cancel') {
                    return response()->json(['status' => 'cancel', 'taxe' => null, 'calculate' => null]);
                } elseif ($taxe[0]->created_at->format('d-m-Y') !== Carbon::now()->format('d-m-Y')) {
                    $taxe_find = Taxe::find($taxe[0]->id);
                    $taxe_find->status = 'cancel';
                    $taxe_find->update();
                    return response()->json(['status' => 'old', 'taxe' => null, 'calculate' => null]);

                } else {
                    return response()->json(['status' => 'process', 'taxe' => $taxe, 'calculate' => 'null']);
                }
            } else {
                return response()->json(['status' => 'error', 'taxe' => null, 'calculate' => null]);
            }
        }
    }
}
