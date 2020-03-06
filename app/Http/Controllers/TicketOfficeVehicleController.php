<?php

namespace App\Http\Controllers;

use App\Company;
use App\Helpers\Calculate;
use App\Payment;
use App\Taxe;
use Dompdf\Exception;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Helpers\TaxesNumber;
use App\Helpers\TaxesMonth;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Recharge;
use App\BankRate;
use App\Vehicle;
use App\UserVehicle;
use App\Brand;
use App\ModelsVehicle;
use App\VehicleType;
use App\VehiclesTaxe;
use App\Helpers\DeclarationVehicle;
use App\Helpers\Trimester;
use App\Exceptions\Handler;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;


class TicketOfficeVehicleController extends Controller
{


    public function QrTaxes($id)
    {
        try {
            $id = Crypt::decrypt($id);

            $taxe = Taxe::with('VehicleTaxes')->where('id', $id)->get();

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
                return response()->json(['status' => 'process', 'taxe' => $taxe, 'calculate' => null]);
            }

        } catch (DecryptException $e) {
            $code = strtoupper($id);
            $taxe = Taxe::with('VehicleTaxes')->where('code', $code)->get();
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


    public function findUser($ci)
    {
        $user = User::where('ci', $ci)->get();
        if (!$user->isEmpty()) {
            $response = array('status' => 'success', ['user' => $user[0]]);
        } else {
            $response = array('status' => 'error', 'message' => 'No Encontrada.');
        }
        return response()->json($response);
    }


    public function paymentTaxes(Request $request)
    {
        $id_taxes = $request->input('taxes_id');
        $lot = $request->input('lot');
        $amount = $request->input('amount_total');
        $ref = $request->input('ref');
        $bank = $request->input('bank');
        $bank_destinations = $request->input('bank_destinations');
        $person = $request->input('person');
        $country_code = $request->input('country_code');
        $phone = $request->input('phone');
        $payments_type = $request->input('payments_type');
        $taxes_data = substr($id_taxes, 0, -1);
        $taxes_explode = explode('-', $taxes_data);

        $amount_total = 0;
        $acum = 0;

        $amountPayment = 0;
        $amount_depo = $amount;

        $amount_format = str_replace('.', '', $amount);
        $amount = str_replace(',', '.', $amount_format);

        $payments = new Payment();

        if ($payments_type === 'PPT') {
            $payments->type_payment = 'TRANSFERENCIA BANCARIA';
            $payments->status = 'process';

        } else if ($payments_type == 'PPC') {
            $payments->type_payment = 'DEPOSITO BANCARIO/CHEQUE';
            $payments->status = 'process';

        } else if ($payments_type == 'PPE') {
            $payments->type_payment = 'DEPOSITO BANCARIO/EFECTIVO';
            $payments->status = 'process';
        } else {
            $payments->type_payment = 'PUNTO DE VENTA';
            $payments->status = 'verified';
        }

        $payments->lot = $lot;
        $payments_number = TaxesNumber::generateNumberPayment($payments_type . "81");
        $payments->code = $payments_number;

        if ($bank != null) {
            $code = substr($payments_number, 3, 12);
            $payments->digit = TaxesNumber::generateNumberSecret($amount, Carbon::now()->format('Y-m-d'), $bank, $code);
        }

        $payments->amount = $amount;
        $payments->ref = $ref;
        $payments->bank = $bank;


        $payments->name = $person;
        $payments->phone = $country_code . $phone;
        $payments->save();
        $payment_id = $payments->id;


        for ($i = 0; $i < count($taxes_explode); $i++) {
            $taxe = Taxe::findOrFail($taxes_explode[$i]);
            $amount_total += $taxe->amount;
            $taxe_id = $taxes_explode[$i];
            $taxe->payments()->attach(['taxe_id' => $taxe_id], ['payment_id' => $payment_id]);
        }


        $paymentsTaxe = $taxe->payments()->get();
        $unid_tribu = Tributo::orderBy('id', 'desc')->take(1)->get();

        foreach ($paymentsTaxe as $payment) {

            if ($payments->amount !== 'cancel') {
                $acum = $acum + $payment->amount;
            }
        }


        $band = bccomp($acum, $amount_total, 2);


        if ($band === 0) {

            $data = ['status' => 'success', 'payment' => 0];
            for ($i = 0; $i < count($taxes_explode); $i++) {
                $taxes_find = Taxe::findOrFail($taxes_explode[$i]);
                if ($bank_destinations !== null) {
                    $taxes_find->bank = $bank_destinations;
                    $taxes_find->status = 'process';
                } else if ($payments_type == 'PPB' || $payments_type == 'PPE' || $payments_type == 'PPC') {
                    $code = substr($taxes_find->code, 3, 12);
                    $taxes_find->code = "PPB" . $code;
                    $taxes_find->status = 'process';
                    $taxes_find->bank = $bank;

                } else {
                    $code = substr($taxes_find->code, 3, 12);
                    $taxes_find->digit = TaxesNumber::generateNumberSecret($taxes_find->amount, $taxes_find->created_at->format('Y-m-d'), $bank, $code);
                    $taxes_find->status = 'verified';
                    $taxes_find->bank = $bank;
                }
                $taxes_find->update();
            }


        } else {
            $amountPayment = $amount_total - $acum;
            $data = ['status' => 'process', 'payment' => number_format($amountPayment, 2)];
        }

        return response()->json($data);
    }

    public function storeVehicle(Request $request, Exception $e)
    {
        $vehicle = new Vehicle();
        $type = $request->input('type');

        $person_id = null;
        $company_id = null;

        $licensePlate = strtoupper($request->input('license_plates'));
        $color = strtoupper($request->input('color'));
        $body_serial = strtoupper($request->input('bodySerials'));
        $serial_engine = strtoupper($request->input('serialEngines'));
        $type_vehicle_id = $request->input('typeV');
        $year = $request->input('year');
        $status_view = $request->input('status_view');
        $status = $request->input('status');
        $owner_id = $request->input('id');
        $person_id = $request->input('person_id');

        if ($type == 'company') {
            $company = Company::find($owner_id);
            $user = $company->users()->get();
            $user_id = $user[0]->id;
            $company_id = $owner_id;
        } else {
            $user_id = $owner_id;
        }


        if (!empty($request->input('brand-n') && $request->input('model-n'))) {
            $brandVehicles = new Brand();
            $modelsVehicle = new ModelsVehicle();

            $models = strtoupper($request->input('model-n'));
            $brand = strtoupper($request->input('brand-n'));
            $otherBrand = Brand::where('name', $brand)->first();

            if (is_object($otherBrand)) {
                $modelsVehicle->name = $models;
                $modelsVehicle->brand_id = $otherBrand->id;
                $modelsVehicle->save();

                $vehicle->model_id = $modelsVehicle->id;

            } else {
                $brandVehicles->name = $brand;
                $brandVehicles->save();

                $modelsVehicle->name = $models;
                $modelsVehicle->brand_id = $brandVehicles->id;
                $modelsVehicle->save();

                $vehicle->model_id = $modelsVehicle->id;
            }

        } else {
            $vehicle->model_id = $request->input('model');
        }

        $vehicle->license_plate = $licensePlate;
        $vehicle->color = $color;
        $vehicle->body_serial = $body_serial;
        $vehicle->serial_engine = $serial_engine;
        $vehicle->type_vehicle_id = $type_vehicle_id;
        $vehicle->year = $year;
        $vehicle->status = 'enabled';

        $vehicle->save();

        $userVehicle = new UserVehicle();

        $userVehicle->user_id = $user_id;
        $userVehicle->vehicle_id = $vehicle->id;
        $userVehicle->person_id = $person_id;
        $userVehicle->company_id = $company_id;
        $userVehicle->status_user_vehicle = $status;

        $userVehicle->save();

        if ($vehicle->save() && $userVehicle->save()) {
            $response = ['status' => 'success'];
        } else {
            $response = ['status' => 'fail'];
        }

        return response()->json($response);
    }


    public function statusVehicle(Request $request)
    {

        if ($request->input('status') == 'true') {
            $vehicle = Vehicle::findOrFail($request->input('id'));
            $vehicle->status = 'disabled';
            $vehicle->update();
            $response = array('status' => 'disabled', 'message' => 'Ha sido desactivado con exito.');

        } else {
            $vehicle = Vehicle::findOrFail($request->input('id'));
            $vehicle->status = 'enabled';
            $vehicle->update();
            $response = array('status' => 'enabled', 'message' => 'Ha sido activado con exito.');
        }

        return response()->json($response);
    }


    public function detailsVehicle($id)
    {
        
        $type = VehicleType::all();
        $vehicle = Vehicle::find($id);
        $brands = Brand::all();
        $models = ModelsVehicle::where('brand_id',$vehicle->model->brand->id)->get();
        // dd($models);

        if (isset($vehicle->person[0]->pivot->person_id)) {
            $person = User::find($vehicle->person[0]->pivot->person_id);
        } else {
            $person = '';
        }


        return view('modules.ticket-office.vehicle.modules.vehicle.details', [
            'vehicle' => $vehicle,
            'brand' => $brands,
            'model' => $models,
            'type' => $type,
            'person' => $person
        ]);
    }

//find-license

    public function findCode($code)
    {
        $company = Company::where('license', $code)->orWhere('RIF', $code)->with('ciu')->with('users')->get();


        if ($company->isEmpty()) {
            $response = array('status' => 'error', 'message' => 'La Licencia ' . $code . 'no esta registrar, debe registrar una empresa.');
        } else {


            if ($company[0]->status != 'disabled') {
                $response = array('status' => 'success', 'company' => $company);

            } else {
                $response = array('status' => 'error', 'message' => 'La empresa ' . $company[0]->name . ' esta bloqueada temporalmente,para poder generar una planilla ,debes desbloquearla.');
            }

        }


        return response()->json($response);
    }


    public function getTaxes()
    {
        $taxes = Audit::where('user_id', \Auth::user()->id)
            ->where('event', 'created')
            ->where('auditable_type', 'App\Taxe')
            ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();

        if (!$taxes->isEmpty()) {
            foreach ($taxes as $taxe) {
                $id_taxes[] = $taxe->auditable_id;
            }
            if (count($id_taxes) !== 0) {
                $taxes = Taxe::where('status', '=', 'ticket-office')->where('branch', '=', 'Pat.Veh')->whereIn('id', $id_taxes)->with('vehicleTaxes')->get();
            } else {
                $amount_taxes = null;
                $taxes = null;
            }
        } else {
            $amount_taxes = null;
            $taxes = null;
        }


        return view('modules.ticket-office.vehicle.modules.taxes.taxes-tickoffice', ['taxes' => $taxes]);
    }

    public function registerTaxes(Request $request)
    {

        $datos = $request->all();

        $fiscal_period = $datos['fiscal_period'];
        $company = $datos['company_id'];
        $company_find = Company::find($company);

        $ciu_id = $datos['ciu_id'];
        $deductions = $datos['deductions'];

        $withholding = $datos['withholding'];
        $base = $datos['base'];
        $fiscal_credits = $datos['fiscal_credits'];


        $fiscal_period_format = Carbon::parse($fiscal_period);
        $tributo = Tributo::whereDate('to', '>=', $fiscal_period_format)->whereDate('since', '<=', $fiscal_period_format)->first();


        if (is_null($tributo)) {
            $tributo = Tributo::orderBy('id', 'desc')->take(1)->first();
        }


        $taxes_amount = 0;
        $date = TaxesMonth::calculateDayMora($fiscal_period, $company_find->typeCompany);

        //format a deductions
        $deductions_format = str_replace('.', '', $deductions);
        $deductions_format = str_replace(',', '.', $deductions_format);

        //format withdolding
        $withholding_format = str_replace('.', '', $withholding);
        $withholding_format = str_replace(',', '.', $withholding_format);

        //format fiscal credits
        $fiscal_credits_format = str_replace('.', '', $fiscal_credits);
        $fiscal_credits_format = str_replace(',', '.', $fiscal_credits_format);


        $base_format_verify = 0;
        $total_base = 0;


        for ($i = 0; $i < count($base); $i++) {

            //damos formato a la base
            $base_format_verify = str_replace('.', '', $base[$i]);
            $base_format_verify = str_replace(',', '.', $base_format_verify);

            $ciu = Ciu::find($ciu_id[$i]);

            //Calculo de minimo  a tributar
            $min_amount = $ciu->min_tribu_men * $tributo->value;

            //Calculo de base imponible
            $base_amount_sub = $ciu->alicuota * $base_format_verify;


            if ($min_amount > $base_amount_sub) {
                $total_base = $total_base + $min_amount;
            } else {
                $total_base = $total_base + $base_amount_sub;
            }


        }
        if ($company_find->typeCompany == 'R') {
            $total_base = $total_base + $withholding_format - $fiscal_credits_format - $deductions_format;
        } else {
            $total_base = $total_base - $withholding_format - $fiscal_credits_format - $deductions_format;
        }


        if ($total_base < 0) {
            return response()->json(['status' => 'error', 'message' => 'La deducciones o creditos fiscal no pueder ser mayor que el impuesto causado.']);
        }


        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('PTS81');


        $taxe->fiscal_period = $fiscal_period;
        $taxe->branch = 'Act.Eco';
        $taxe->bank = '';
        $taxe->type = 'actuated';

        $taxe->status = 'ticket-office';
        $taxe->save();
        $id = $taxe->id;


        for ($i = 0; $i < count($base); $i++) {

            //damos formato a la base
            $base_format = str_replace('.', '', $base[$i]);
            $base_format = str_replace(',', '.', $base_format);
            $ciu = Ciu::find($ciu_id[$i]);


            //Calculo de minimo  a tributar
            $min_amount = $ciu->min_tribu_men * $tributo->value;

            //Calculo de base imponible
            $base_amount_sub = $ciu->alicuota * $base_format;

            //si lo que va a pagar es mayor que el min a tributar
            if ($base_amount_sub > $min_amount) {

                $min_amount = 0;
            } else {//si no paga minimo

                $base_amount_sub = $min_amount;
            }

            if ($date['mora']) {//si tiene mora
                //Obtengo recargo
                $recharge = Recharge::where('branch', 'Act.Eco')->whereDate('to', '>=', $fiscal_period_format)->whereDate('since', '<=', $fiscal_period_format)->first();
                if (is_null($recharge)) {
                    $recharge = Recharge::orderBy('id', 'desc')->take(1)->first();
                }


                //Obtengo Intereset del banco
                $interest_bank = BankRate::orderBy('id', 'desc')->take(1)->first();

                $amount_recharge = $base_amount_sub * $recharge->value / 100;
                $interest = (($interest_bank->value_rate / 100) / 360) * $date['diffDayMora'] * ($amount_recharge + $base_amount_sub);


            } else {
                $amount_recharge = 0;
                $interest = 0;
            }

            $taxe->taxesCiu()->attach(['taxe_id' => $id],
                ['ciu_id' => $ciu_id[$i],
                    'base' => $base_format,
                    'recharge' => $amount_recharge,
                    'tax_unit' => $tributo->value,
                    'interest' => $interest,
                    'taxable_minimum' => $min_amount
                ]);
        }


        $day_mora = $date['diffDayMora'];
        $taxe->companies()->attach(['taxe_id' => $id], ['company_id' => $company_find->id,
            'fiscal_credits' => $fiscal_credits_format,
            'withholding' => $withholding_format,
            'deductions' => $deductions_format,
            'day_mora' => $day_mora]);


        $taxesCalculate = Calculate::calculateTaxes($id);

        $taxe_update = Taxe::find($id);

        //Si tiene  multa
        $verify = TaxesMonth::calculateDayMora($taxe_update->fiscal_period, $taxe_update->companies[0]->typeCompany);
        if ($verify['mora']) {
            $company = Company::find($taxe_update->companies[0]->id);
            $fineCompany = FineCompany::where('fiscal_period', $taxe_update->fiscal_period)->get();
            if (!$fineCompany->isEmpty()) {
                $fine = FineCompany::find($fineCompany[0]->id);
                $fine->delete();
            }
            $company->fineCompany()->attach(['company_id' => $company->id], ['fine_id' => 1, 'unid_tribu_value' => $tributo->value, 'fiscal_period' => $taxe_update->fiscal_period]);
            $fines = $company->fineCompany()->orderBy('id', 'desc')->take(1)->get();

            $subject = "MULTA-SEMAT";
            $for = $company->users[0]->email;


            try {
                Mail::send('mails.resolucion', ['name' => $company->name], function ($msj) use ($subject, $for) {
                    $msj->from("semat.alcaldia.iribarren@gmail.com", "SEMAT");
                    $msj->subject($subject);
                    $msj->to($for);
                });
            } catch (\Exception $e) {


                $response = ['status' => 'error-email', 'message' => 'La planilla se registro con éxito, sin embargo no se pudo enviar el correo de la multa generada.(Fallo de internet.)'];
            }
            $response = ['status' => 'success', 'message' => 'Registro de planilla con éxito,  se le genero una multa por pago fuera de lapso.'];
            $taxe_update->amount = $taxesCalculate['amountTotal'];
        } else {
            $response = ['status' => 'success', 'message' => 'Registro de planilla con éxito.'];
            $taxe_update->amount = $taxesCalculate['amountTotal'];
        }

        $taxe_update->update();


        return response()->json($response);
    }


    public function verifyTaxes($fiscal_period, $company_id)
    {
        $band = true;
        $company = Company::where('id', '=', $company_id)->with('taxesCompanies')->get();
        foreach ($company[0]->taxesCompanies as $taxes) {
            if ($taxes->fiscal_period == $fiscal_period && $taxes->status !== 'cancel') {
                $band = false;
            }
        }

        $fiscal_period = TaxesMonth::convertFiscalPeriod($fiscal_period);

        if ($band) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error', 'fiscal_period' => $fiscal_period);
        }
        return response()->json($response);
    }


    public function pdfTaxes($id)
    {
        $taxes = Taxe::findOrFail($id);


        if ($taxes->type != 'definitive') {
            $ciuTaxes = CiuTaxes::where('taxe_id', $taxes->id)->get();
            $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
                'taxes' => $taxes,
                'ciuTaxes' => $ciuTaxes,
                'firm' => true
            ]);
        } else {
            $companyTaxe = $taxes->companies()->get();
            $ciuTaxes = CiuTaxes::where('taxe_id', $id)->get();
            $company_find = Company::find($companyTaxe[0]->id);

            $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
            $mora = Extras::orderBy('id', 'desc')->take(1)->get();
            $extra = ['tasa' => $mora[0]->tax_rate];
            $amount = Calculate::calculateTaxes($id);


            $pdf = \PDF::loadView('modules.taxes.receipt', [
                'taxes' => $taxes,
                'fiscal_period' => $fiscal_period,
                'extra' => $extra,
                'ciuTaxes' => $ciuTaxes,
                'amount' => $amount,
                'firm' => true
            ]);
        }


        return $pdf->stream();
    }


    public function myPaymentsTickOffice($type)
    {

        $amount_taxes = 0;
        $taxes = Audit::where('user_id', \Auth::user()->id)
            ->where('event', 'created')
            ->where('auditable_type', 'App\Payment')
            ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();

        if (!$taxes->isEmpty()) {
            foreach ($taxes as $taxe) {
                $id_taxes[] = $taxe->auditable_id;
            }
            if (count($id_taxes) !== 0) {
                $taxes = Payment::with('taxes')->whereIn('id', $id_taxes)->where('type_payment', '=', $type)->get();
                foreach ($taxes as $taxe) {
                    $amount_taxes += $taxe->amount;
                }
            } else {
                $amount_taxes = null;
                $taxes = null;
            }
        } else {
            $amount_taxes = null;
            $taxes = null;
        }


        return view('modules.payments.ticket-office', ['taxes' => $taxes, 'amount_taxes' => $amount_taxes]);
    }


    /*public function payments($type)
        {

            if ($type == 'DEPOSITO BANCARIO') {
                $payment = Payment::with('taxes')->where('type_payment', '=', $type . '/CHEQUE')->orWhere('type_payment', '=', $type . '/EFECTIVO')->get();
            } else {
                $payment = Payment::with('taxes')->where('type_payment', '=', $type)->get();
            }
            if ($payment->isEmpty()) {
                $payment = null;
            }


            if ($type == 'TRANSFERENCIA BANCARIA') {
                return view('modules.payments.transfer', ['taxes' => $payment, 'amount_taxes' => 0]);
            } else if ($type === 'PUNTO DE VENTA') {
                return view('modules.payments.pointofsale', ['taxes' => $payment, 'amount_taxes' => 0]);
            } else if ($type === 'DEPOSITO BANCARIO') {
                return view('modules.payments.deposit', ['taxes' => $payment, 'amount_taxes' => 0]);
            } else {
                return redirect('ticket-office/type-payment');
            }

        }
    */


    public function generateReceipt($taxes_data)
    {
        //$taxes_data = substr($taxes_data, 0, -1);
        $taxes_explode = explode('-', $taxes_data);


        $taxes = Taxe::whereIn('id', $taxes_explode)->with('vehicleTaxes')->get();
        $vehicleFind = Vehicle::find($taxes[0]->vehicleTaxes[0]->id);
        $user = $vehicleFind->users()->get();
        if (isset($vehicleFind->person[0]->pivot->person_id)) {
            $person = User::find($vehicleFind->person[0]->pivot->person_id);
        } else {
            $person = '';
        }

        $pdf = \PDF::loadView('modules.ticket-office.vehicle.modules.receipt.receiptMulti', [
            'taxes' => $taxes,
            'vehicle' => $vehicleFind,
            'person' => $person,
            'user' => $user
        ]);

        return $pdf->stream();
    }


    public function calculatePayments($taxes_data)
    {
        $taxes_data = substr($taxes_data, 0, -1);
        $taxes_explode = explode('-', $taxes_data);

        $taxes = Taxe::whereIn('id', $taxes_explode)->with('payments')->get();
        $amount = 0;
        $amount_payment = 0;
        $id_payment = '';


        foreach ($taxes as $tax) {

            if (!$tax->payments->isEmpty()) {

                foreach ($tax->payments as $payment) {
                    if ($payment->id !== $id_payment) {
                        if ($payment->status !== 'cancel') {
                            $amount_payment += $payment->amount;
                        }
                    }
                    $id_payment = $payment->id;
                }
            }


            $amount += $tax->amount;
        }
        $amount = $amount - $amount_payment;


        return response()->json(['status' => 'success', 'amount' => $amount]);
    }


    public function changeStatustaxes($id, $status)
    {
        $taxes = Taxe::find($id);
        $taxes->status = $status;
        $taxes->update();


        if ($status === 'cancel') {
            if (!$taxes->payments->isEmpty()) {
                foreach ($taxes->payments as $payment) {
                    $payment = Payment::find($payment->id);
                    $payment->status = 'cancel';
                    $payment->update();
                }
            }
        }


        if ($status === 'verified' && $taxes->type == 'actuated') {
            $taxes_find = CiuTaxes::whereIn('taxe_id', [$id])->with('ciu')->with('taxes')->get();
            $companyTaxe = $taxes->companies()->get();
            $company_find = Company::find($companyTaxe[0]->id);

            $pdf = \PDF::loadView('modules.taxes.receipt-verified', ['taxes' => $taxes_find]);
            $user = $company_find->users()->get();
            $subject = "PLANILLA VERIFICADA";
            $for = $user[0]->email;

            try {
                Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {
                    $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                    $msj->subject($subject);
                    $msj->to($for);
                    $msj->attachData($pdf->output(), time() . 'PLANILLA_VERIFICADA.pdf');
                });
            } catch (\Exception $e) {
                return response()->json(['status' => 'error']);
            }

        }


        return response()->json(['status' => $taxes->statusName]);
    }


    public function paymentsDetails($id)
    {
        $payment = Payment::with('taxes')->where('id', '=', $id)->get();
        return view('modules.payments.details', ['payments' => $payment[0]]);
    }


    public function paymentsWeb()
    {
        $taxes = Taxe::with('companies')->where('status', '!=', 'cancel')->orderBy('id', 'desc')->get();
        return view('modules.payments.read_web', ['taxes' => $taxes]);
    }


    public function changeStatusPayment($id, $status)
    {
        $payments = Payment::find($id);
        $payments->status = $status;
        $payments->update();
        $now = Carbon::now()->format('Y-m-d');

        $message = '';

        //Cambiando status del payment

        //Cambiando el estado de la planilla a en procesos
        $taxes = $payments->taxes()->first();
        if ($status == 'cancel' && $taxes->created_at->format('Y-m-d') == $now) {
            $taxes->status = 'ticket-office';
            $taxes->update();
            $message = 'ANULADO';
        } elseif ($status == 'cancel' && $taxes->created_at->format('Y-m-d') != $now) {
            $taxes->status = 'cancel';
            $taxes->update();
            $message = 'ANULADO';
        } elseif ($status == 'verified') {
            $message = 'VERIFICADO';
        }

        return response()->json(['status' => $message]);
    }

//*________DEFINITIVE_________*

    public function verifyDefinitive($company_id)
    {
        $status = TaxesMonth::verifyDefinitive($company_id);
        return response()->json(['status' => $status]);
    }

//declarar y generar la planilla
    public function create($id, $year)
    {
        $array = explode('-', $id);
        $idVehicle = $array[0];
        $optionPayment = null;
        if (isset($array[1])) {
            if ($array[1] == 'false' || $array[1] == 'true') {
                if ($array[1] == 'false') {
                    $optionPayment = false;
                } else {
                    $optionPayment = true;
                }
            }
        }


        $years = Trimester::yearPayment($year);

        $trimester = Trimester::verifyTrimester();

        $date = Carbon::now();

        $vehicleTaxe = Vehicle::find($idVehicle);
        if ($vehicleTaxe->pivot === null) {
            $taxes = '';
        } else {
            $taxes = Taxe::where('id', $vehicleTaxe->pivot->taxe_id)->get();
        }

        if (!empty($taxes)) {
            foreach ($taxes as $tax) {
                if ($tax->status === 'verified' || $tax->status === 'verified-sysprim') {
                    $statusTax = 'verified';
                } else if ($tax->status === 'temporal') {
                    DeclarationVehicle::verify($tax->id);
//                  $tax->delete();
                    $statusTax = 'new';
                } else if ($tax->status === 'ticket-office' && $tax->created_at->format('d-m-Y') === $date->format('d-m-Y')) {
                    $statusTax = 'process';
                } else if ($tax->status === 'process' && $tax->created_at->format('d-m-Y') === $date->format('d-m-Y')) {
                    $statusTax = 'process';
                } else {
                    $statusTax = 'new';
                }
            }
        } else {
            $statusTax = 'new';
        }


        $declaration = DeclarationVehicle::Declaration($idVehicle, $optionPayment, $years['periodInit']);

        $type = null;

        $vehicle = Vehicle::where('id', $idVehicle)->get();

        $grossTaxes = 0;
        $total = number_format($declaration['total'], 2, ',', '.');
        $totalAux = $declaration['total'];
        $paymentFractional = 0;
        $valueDiscount = 0;
        if ($declaration['valueMora'] == 0) {
            $valueMora = 0;
        } else {
            $valueMora = number_format($declaration['valueMora'], 2, ',', '.');
        }

        if ($declaration['optionPayment']) {
            $period_fiscal = $trimester['monthBegin']->format('m-Y') . ' / ' . '12/' . $trimester['monthEnd']->format('Y');
            $total = number_format($declaration['total'], 2, ',', '.');
            $valueDiscount = number_format($declaration['valueDiscount'], 2, ',', '.');
            $rateYear = $declaration['rateYear'];
            $grossTaxes = number_format($declaration['grossTaxes'], 2, ',', '.');
            $previousDebt = $declaration['previousDebt'];
            $recharge = number_format($declaration['recharge'], 2, ',', '.');
            $period_fiscal_begin = $years['periodInit']->format('Y-m-d');
            $period_fiscal_end = $years['periodFinal']->format('Y-m-d');
            $type = "Anual";
        }
        /*else {
            $period_fiscal = $trimester['monthBegin']->format('m-Y') . ' / ' . $trimester['monthEnd']->format('m-Y');
            $paymentFractional = number_format($declaration['fractionalPayments'], 2, ',', '.');
            $grossTaxes = $paymentFractional;
            $rateYear = $declaration['rateYear'];
            $period_fiscal_begin = $trimester['monthBegin']->format('Y-m-d');
            $period_fiscal_end = $trimester['monthEnd']->format('Y-m-d');
            $type = "Trimestral";
            if (isset($declaration['recharge'])) {
                $recharge = number_format($declaration['recharge'], 2, ',', '.');
            } else {
                $recharge = 0;
            }
            if (isset($declaration['previousDebt'])) {
                if ($declaration['previousDebt'] !== 0) {

                    $previousDebt = number_format($declaration['previousDebt'], 2, ',', '.');
                }
            } else {
                $previousDebt = 0;
            }
        }*/

        $taxes = new Taxe();
        $taxes->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxes->fiscal_period = $period_fiscal_begin;
        $taxes->fiscal_period_end = $period_fiscal_end;
        $taxes->type = $type;
        $taxes->save();

        $taxesId = $taxes->id;

        $vehicleTaxes = new VehiclesTaxe();
        $vehicleTaxes->vehicle_id = $vehicle[0]->id;
        $vehicleTaxes->taxe_id = $taxesId;
        $vehicleTaxes->status = 'Temporal';
        $vehicleTaxes->type_payments = $declaration['optionPayment'];
        $vehicleTaxes->fiscal_credits = 0;
        $vehicleTaxes->save();


        return response()->json(array(
                'process' => false,
                'vehicle' => $vehicle,
                'taxes' => $taxes,
                'grossTaxes' => $grossTaxes,
                'paymentFractional' => $paymentFractional,
                'valueDiscount' => $valueDiscount,
                'rateYear' => $rateYear,
                'recharge' => $recharge,
                'previousDebt' => $previousDebt,
                'total' => $total,
                'totalAux' => $declaration['total'],
                'vehicleTaxes' => false,
                'valueMora' => $valueMora,
                'totalAux' => $totalAux,
                'taxeId' => $taxesId,
                'statusTax' => $statusTax
            )
        );

    }


//::::::::::::::::::::::::::::temporal:::::::::::::::::::::::::::::::::::::::::
    public function saveRateTicketOffice(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');
        $rate_id = $request->input('rate_id');

        $person_id = null;
        $company_id = null;
        if ($type == 'user') {
            $person_id = $id;
            $user_id = $id;
        } else {
            $user_id = \Auth::user()->id;
            $company_id = $id;
        }


        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxe->status = 'ticket-office';
        $taxe->type = 'daily';
        $taxe->fiscal_period = date('Y-m-d');
        $taxe->branch = 'Tasas y Cert';
        $taxe->save();
        $id = $taxe->id;
        $amount = 0;


        $tributo = Tributo::orderBy('id', 'desc')->first();


        for ($i = 0; $i < count($rate_id); $i++) {
            $rate = Rate::find($rate_id[$i]);
            $taxe->rateTaxes()->attach(['taxe_id' => $id],
                ['rate_id' => $rate_id[$i],
                    'company_id' => $company_id,
                    'person_id' => $person_id,
                    'user_id' => $user_id,
                    'cant_tax_unit' => $rate->cant_tax_unit,
                    'tax_unit' => $tributo->value,
                ]);


            $amount += $rate->cant_tax_unit * $tributo->value;
        }


        $taxe_find = Taxe::find($id);
        $taxe_find->amount = $amount;
        $taxe_find->update();


        return response()->json(['status' => 'success', 'taxe_id' => $id]);
    }

//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    public function taxesSave(Request $request)
    {
        $id = $request->input('taxeId');
        $amount = $request->input('total');
        $fiscalCredits = $request->input('fiscalCredits');
        $recharge = $request->input('recharge');
        $recharge_mora = $request->input('rechargeMora');
        $previousDebt = $request->input('previous');
        $discount = $request->input('discount');
        $base = $request->input('base');

        $amount_format = str_replace('.', '', $amount);
        $amount_format = str_replace(',', '.', $amount_format);

        $base_format = str_replace('.', '', $base);
        $base_format = str_replace(',', '.', $base_format);

        if ($fiscalCredits !== 0) {
            $fiscalCredits_format = str_replace('.', '', $fiscalCredits);
            $fiscalCredits_format = str_replace(',', '.', $fiscalCredits_format);
        } else {
            $fiscalCredits_format = 0;
        }

        if ($previousDebt !== 0) {
            $previousDebt_format = str_replace('.', '', $previousDebt);
            $previousDebt_format = str_replace(',', '.', $previousDebt_format);
        } else {
            $previousDebt_format = (float)0;
        }

        if ($discount !== 0) {
            $discount_format = str_replace('.', '', $discount);
            $discount_format = str_replace(',', '.', $discount_format);
        } else {
            $discount_format = 0;
        }

        if ($recharge !== 0 && $recharge_mora !== 0) {
            $recharge_format = str_replace('.', '', $recharge);
            $recharge_format = str_replace(',', '.', $recharge_format);

            $rechargeMora_format = str_replace('.', '', $recharge_mora);
            $rechargeMora_format = str_replace(',', '.', $rechargeMora_format);
        } else {
            $recharge_format = 0;
            $rechargeMora_format = 0;
        }

        $taxes = Taxe::findOrFail($id);
        $taxes->amount = $amount_format;
        $taxes->status = 'ticket-office';
        $taxes->branch = 'Pat.Veh';
        $taxes->code = TaxesNumber::generateNumberTaxes('PTS' . '85');

        $taxes->update();

        $idVehicleTaxes = VehiclesTaxe::where('taxe_id', $id)->get();

        $vehicleTaxes = VehiclesTaxe::findOrFail($idVehicleTaxes[0]->id);

        $vehicleTaxes->fiscal_credits = $fiscalCredits_format;
        $vehicleTaxes->recharge = $recharge_format;
        $vehicleTaxes->recharge_mora = $rechargeMora_format;
        $vehicleTaxes->base_imponible = $base_format;

        $vehicleTaxes->previous_debt = $previousDebt_format;

        $vehicleTaxes->discount = $discount_format;

        $vehicleTaxes->update();

        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));
        // $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank, $code);


        return response()->json(['status' => 'success']);

    }

    /* public function payments(Request $request)
     {
         $id_taxes = $request->input('id_taxes');

         $taxes = Taxe::findOrFail($id_taxes);
         $vehiclesTaxes = VehiclesTaxe::where('taxe_id', $id_taxes)->get();
         $vehiclesTaxe = VehiclesTaxe::find($vehiclesTaxes[0]->id);


         $code = TaxesNumber::generateNumberTaxes("TEM" . "85");
         $taxes->code = $code;
         $code = substr($code, 3, 12);

         $date_format = date("Y-m-d", strtotime($taxes->created_at));
         $date = date("d-m-Y", strtotime($taxes->created_at));

         $taxes->status = "tickek-office";
         $taxes->update();

         $vehiclesTaxe->status = 'process';
         $vehiclesTaxe->update();

         $trimester = Trimester::verifyTrimester();
         $period_fiscal = Carbon::now()->format('m-Y') . ' / ' . $trimester['trimesterEnd'];


         return redirect()->route('vehicle.payments.history', ['id' => $vehicleID]);
     }*/

    public function viewDetails($id)
    {
        $taxes = Taxe::findOrFail($id);

        $vehicleTaxes = VehiclesTaxe::where('taxe_id', $id)->get();
        $vehicle = Vehicle::where('id', $vehicleTaxes[0]->vehicle_id)->get();

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
        $response = array(
            'taxes' => $taxes,
            'vehicleTaxes' => $vehicleTaxes,
            'vehicle' => $vehicle,
            'model' => $vehicle[0]->model,
            'verified' => $verified
        );
        return view('modules.ticket-office.vehicle.modules.payroll.details', array('response' => $response));
    }

    public function paymentsDeclaration($id, $optionPayment)
    {
        $trimester = Trimester::verifyTrimester();

        $declaration = DeclarationVehicle::Declaration($id, $optionPayment);

        $type = null;

        $vehicle = Vehicle::where('id', $id)->get();

        $grossTaxes = 0;
        $total = number_format($declaration['total'], 2, ',', '.');
        $totalAux = $declaration['total'];
        $paymentFractional = 0;
        $valueDiscount = 0;
        if ($declaration['valueMora'] == 0) {
            $valueMora = 0;
        } else {
            $valueMora = number_format($declaration['valueMora'], 2, ',', '.');
        }

        if ($declaration['optionPayment']) {
            $period_fiscal = $trimester['monthBegin']->format('m-Y') . ' / ' . '12/' . $trimester['monthEnd']->format('Y');
            $total = number_format($declaration['total'], 2, ',', '.');
            $valueDiscount = number_format($declaration['valueDiscount'], 2, ',', '.');
            $rateYear = $declaration['rateYear'];
            $grossTaxes = number_format($declaration['grossTaxes'], 2, ',', '.');
            $previousDebt = $declaration['previousDebt'];
            $recharge = 0;
            $period_fiscal_begin = $trimester['monthBegin']->format('Y-m-d');
            $period_fiscal_end = $trimester['monthEnd']->format('Y') . '-12-01';
            $type = "Anual";

        } else {
            $period_fiscal = $trimester['monthBegin']->format('m-Y') . ' / ' . $trimester['monthEnd']->format('m-Y');
            $paymentFractional = number_format($declaration['fractionalPayments'], 2, ',', '.');
            $grossTaxes = $paymentFractional;
            $rateYear = $declaration['rateYear'];
            $period_fiscal_begin = $trimester['monthBegin']->format('Y-m-d');
            $period_fiscal_end = $trimester['monthEnd']->format('Y-m-d');
            $type = "Trimestral";
            if (isset($declaration['recharge'])) {
                $recharge = number_format($declaration['recharge'], 2, ',', '.');
            } else {
                $recharge = 0;
            }
            if (isset($declaration['previousDebt'])) {
                if ($declaration['previousDebt'] !== 0) {

                    $previousDebt = number_format($declaration['previousDebt'], 2, ',', '.');
                }
            } else {
                $previousDebt = 0;
            }
        }

        $taxes = new Taxe();
        $taxes->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxes->fiscal_period = $period_fiscal_begin;
        $taxes->fiscal_period_end = $period_fiscal_end;
        $taxes->type = $type;
        $taxes->save();

        $taxesId = $taxes->id;
        $vehicleTaxes = new VehiclesTaxe();
        $vehicleTaxes->vehicle_id = $vehicle[0]->id;
        $vehicleTaxes->taxe_id = $taxesId;
        $vehicleTaxes->status = 'Temporal';
        $vehicleTaxes->type_payments = $declaration['optionPayment'];
        $vehicleTaxes->fiscal_credits = 0;
        $vehicleTaxes->save();

        return response()->json(array(
                'process' => false,
                'vehicle' => $vehicle,
                'taxes' => $taxes,
                'grossTaxes' => $grossTaxes,
                'paymentFractional' => $paymentFractional,
                'valueDiscount' => $valueDiscount,
                'rateYear' => $rateYear,
                'recharge' => $recharge,
                'previousDebt' => $previousDebt,
                'total' => $total,
                'totalAux' => $declaration['total'],
                'vehicleTaxes' => false,
                'valueMora' => $valueMora,
                'totalAux' => $totalAux,
                'taxeId' => $taxesId
            )
        );
    }

    public function changeUser($type, $document, $id)
    {
        $vehicle = UserVehicle::where('vehicle_id', $id)->get();
        $vehicleUser = UserVehicle::find($vehicle[0]->id);

        if ($type == "J" || $type == "G") {
            $company = Company::where('RIF', $type . $document)->get();

            if (!$company->isEmpty()) {

                $vehicleUser->user_id = $company[0]->users[0]->id;
                $vehicleUser->company_id = $company[0]->id;
                $vehicleUser->person_id = null;
                $response = ['status' => 'success'];
            } else {
                $response = ['status' => 'fail'];
            }
        } elseif ($type == "E" || $type == "V") {
           // var_dump($type);
            $user = User::where('ci', $type . $document)->get();
            if (!$user->isEmpty()) {
                $vehicleUser->company_id = null;
                $vehicleUser->person_id = $user[0]->id;

                $response = ['status' => 'success'];
            } else {
                $response = ['status' => 'fail'];
            }

        }

        $vehicleUser->update();

        return Response()->json($response);
    }

    public function changeUserWeb($type, $document, $id)
    {
        $vehicle = UserVehicle::where('vehicle_id', $id)->get();
        $vehicleUser = UserVehicle::find($vehicle[0]->id);

        if ($type == "E" || $type == "V") {
            $user = User::where('ci', $type . $document)->get();
            if (!$user->isEmpty()) {
                $vehicleUser->user_id = $user[0]->id;
                $vehicleUser->company_id = null;
                $response = ['status' => 'success'];
            } else {
                $response = ['status' => 'fail'];
            }

        }

        $vehicleUser->update();

        return Response()->json($response);
    }

    public function fiscalPeriod($id, $year)
    {
        $date = Carbon::now();
        $vehicleTaxe = Vehicle::find($id);
        $tax = $vehicleTaxe->taxesVehicle()->whereDate('fiscal_period', $year)->first();
        $statusTax = false;
        if (is_null($tax)) {
            $statusTax = false;
        } else {
            if ($tax->status === 'verified' || $tax->status === 'verified-sysprim') {
                $statusTax = true;
            } else if ($tax->status === 'temporal') {
//                      $tax->delete();
                $statusTax = false;
            } else if ($tax->status === 'ticket-office' && $tax->created_at->format('d-m-Y') === $date->format('d-m-Y')) {
                $statusTax = true;
            } else if ($tax->status === 'process' && $tax->created_at->format('d-m-Y') === $date->format('d-m-Y')) {
                $statusTax = true;
            } else if ($tax->status === 'cancel') {
                $statusTax = false;
            } else if ($tax->status === null) {
                $statusTax = false;
            }
        }

        return Response()->json($statusTax);
    }

    public function historyPayments($id)
    {
        $vehicle = Vehicle::find($id);

        return view('modules.ticket-office.vehicle.modules.vehicle.historyPayments', [
            'vehicle' => $vehicle
        ]);
    }

}


