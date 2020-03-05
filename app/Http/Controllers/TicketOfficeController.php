<?php

namespace App\Http\Controllers;

use App\CompanyTaxe;
use App\FindCompany;
use App\Helpers\Calculate;
use App\Payment;
use App\Prologue;
use App\Taxe;
use App\Vehicle;
use Dompdf\Exception;
use Illuminate\Http\Request;
use App\CiuTaxes;
use App\Parish;
use App\Company;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Helpers\TaxesNumber;
use App\Tributo;
use App\Helpers\TaxesMonth;
use App\Ciu;
use App\Extras;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\FineCompany;
use App\Recharge;
use App\BankRate;
use App\Helpers\CheckCollectionDay;
use App\Property;
use App\UserProperty;
use App\PropertyTaxes;
use App\Publicity;
use App\PublicityTaxe;
use App\UserPublicity;
use App\TimelineCiiu;
use App\Val_cat_const_inmu;


class TicketOfficeController extends Controller
{


    public function QrTaxes($id)
    {
        try {
            $id = Crypt::decrypt($id);

            $taxe = Taxe::with('companies')->where('id', $id)->get();

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
                $ciuTaxes = CiuTaxes::with('ciu')->where('taxe_id', $id)->get();
                return response()->json(['status' => 'process', 'taxe' => $taxe, 'calculate' => $calculateTaxes, 'ciu' => $ciuTaxes]);
            }

        } catch (DecryptException $e) {
            $code = strtoupper($id);
            $taxe = Taxe::with('companies')->where('code', $code)->get();
            if (!$taxe->isEmpty()) {
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
                    return response()->json(['status' => 'process', 'taxe' => $taxe, 'calculate' => 'null']);
                }
            } else {
                return response()->json(['status' => 'error', 'taxe' => null, 'calculate' => null, 'ciu' => null]);
            }
        }
    }

    public function cashier()
    {
        $unid_tribu = Tributo::orderBy('id', 'desc')->take(1)->get();
        return view('modules.ticket-office.create', ['unid_tribu' => $unid_tribu]);
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


        $payments_number = TaxesNumber::generateNumberPayment($payments_type . '55');


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

            if ($payment->status != 'cancel') {
                $acum = $acum + $payment->amount;
            }
        }





        $band = bccomp($acum, $amount_total, 2);


        if ($band === 0) {

            $data = ['status' => 'success', 'payment' => 0];
            for ($i = 0; $i < count($taxes_explode); $i++) {
                $taxes_find = Taxe::findOrFail($taxes_explode[$i]);
                if ($bank_destinations !== null) {
                    $code = substr($taxes_find->code, 3, 12);
                    $code_payment = substr($taxes_find->code, 0, 3);
                    $taxes_find->bank = $bank_destinations;
                    $taxes_find->code = TaxesNumber::generateNumberTaxes($payments_type.$code_payment);
                    $taxes_find->status = 'process';

                } else if ($payments_type == 'PPB' || $payments_type == 'PPE' || $payments_type == 'PPC') {

                    $code = substr($taxes_find->code, 3, 12);
                    $code_payment = substr($taxes_find->code, 0, 3);
                    $taxes_find->code = TaxesNumber::generateNumberTaxes($payments_type.$code_payment);
                    $taxes_find->status = 'process';
                    $taxes_find->bank = $bank;
                    $taxes_find->digit = TaxesNumber::generateNumberSecret($taxes_find->amount, $taxes_find->created_at->format('Y-m-d'), $bank, $code);

                } else {
                    $code = substr($taxes_find->code, 3, 12);
                    $code_payment = substr($taxes_find->code, 3, 3);
                    $taxes_find->code = TaxesNumber::generateNumberTaxes($payments_type.$code_payment);
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


    //comapanies
    public function registerCompany()
    {
        $parish = Parish::all();
        return view('modules.ticket-office.companies.register', ['parish' => $parish]);
    }


    public function storeCompany(Request $request)
    {
        $ciu = $request->input('ciu');
        $nameCompany = $request->input('name_company');
        $license = $request->input('license');
        $parish = $request->input('parish');
        $openingDate = $request->input('opening_date');
        $rif = $request->input('document_type') . $request->input('RIF');
        $address = $request->input('address');
        $code_catastral = $request->input('code_catastral');
        $numberEmployees = $request->input('number_employees');
        $sector = $request->input('sector');
        $phone = $request->input('phone_company');
        $country_code = $request->input('country_code_company');
        $lat = $request->input('lat');
        $lng = $request->input('lng');


        $validate = $this->validate($request, [
            'name_company' => 'required',
            'RIF' => 'required|min:8',
            'address' => 'required',
            'parish' => 'required|integer',
            'sector' => 'required',
        ]);

        if (!$license) {
            $license = TaxesNumber::generateNumberLicense();
        }

        $company = new Company();
        $company->name = strtoupper($nameCompany);
        $company->address = strtoupper($address);
        $company->rif = $rif;
        $company->license = strtoupper($license);
        $company->lat = $lat;
        $company->lng = $lng;
        $company->code_catastral = strtoupper($code_catastral);
        $company->parish_id = $parish;
        $company->opening_date = $openingDate;
        $company->sector = $sector;
        $company->number_employees = $numberEmployees;
        $company->phone = $country_code . $phone;
        $company->save();
        $id_company = $company->id;

        $id_user = $request->input('user_id');

        $company->users()->attach(['company_id' => $id_company], ['user_id' => $id_user]);

        if ($ciu) {
            foreach ($ciu as $ciu) {
                $company->ciu()->attach(['company_id' => $id_company], ['ciu_id' => $ciu]);
            }
        }

        return response()->json(['status' => 'success', 'Registro de Empresa realiazado con éxito']);
    }


    public function allCompanies()
    {
        $companies = Company::all();

        return view('modules.ticket-office.companies.read', ['companies' => $companies]);
    }


    public function detailsCompany($id)
    {
        $company = Company::findOrFail($id);
        $parish = Parish::all();

        $number_acteco = $company->taxesCompanies()->orderBy('id', 'desc')->count();
        $number_rate = $company->taxesCompaniesRate()->orderBy('id', 'desc')->count();

        $number_vehicle = $company->companyVehicle()->orderBy('id', 'desc')->count();
        $number_property = $company->companyProperty()->orderBy('id', 'desc')->count();


        return view('modules.ticket-office.companies.details', ['company' => $company, 'parish' => $parish, 'number_rate' => $number_rate, 'number_ateco' => $number_acteco, 'number_property' => $number_property, 'number_vehicle' => $number_vehicle]);
    }


    //Pago de empresas

    public function detailsCompanyTaxes($id, $type)
    {
        $company = Company::findOrFail($id);
        if ($type == 'Act.Eco') {
            $companyTaxes = $company->taxesCompanies()->orderBy('id', 'desc')->get();
        } elseif ($type == 'Tasas y Cert') {
            $companyTaxes = $company->taxesCompaniesRate()->orderBy('id', 'desc')->get();
        }
        return view('modules.ticket-office.companies.all-taxes', ['taxesCompanies' => $companyTaxes, 'id' => $id]);
    }


    //find-license

    public function findCode($code)
    {
        $company = Company::where('license', $code)->orWhere('RIF', $code)->with('ciu')->with('users')->get();


        if ($company->isEmpty()) {
            $response = array('status' => 'error', 'message' => 'La Licencia  o RIF "' . $code . '" no esta registrada, para generar una planilla debe ingresar un codigo valido.');
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
                $taxes = Taxe::where('status', '=', 'ticket-office')->where('branch', '=', 'Act.Eco')->whereIn('id', $id_taxes)->get();
            } else {
                $amount_taxes = null;
                $taxes = null;
            }
        } else {
            $amount_taxes = null;
            $taxes = null;
        }


        return view('modules.ticket-office.taxes.taxes-tickoffice', ['taxes' => $taxes]);
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

        $amount_recharge = 0;
        $interest = 0;


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

            $timeline_ciu = TimelineCiiu::where('ciu_id', $ciu->id)->whereYear('since', '<=', $fiscal_period_format->format('Y'))->whereYear('to', '>=', $fiscal_period_format->format('Y'))->first();

            if (is_null($timeline_ciu)) {
                $timeline_ciu = TimelineCiiu::where('ciu_id', $ciu->id)->orderBy('id', 'desc')->take(1)->first();
            }


            //Calculo de minimo  a tributar
            $min_amount = $timeline_ciu->min_tribu_men * $tributo->value;

            //Calculo de base imponible
            $base_amount_sub = $timeline_ciu->alicuota * $base_format_verify;


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


            $timeline_ciu = TimelineCiiu::where('ciu_id', $ciu->id)->whereYear('since', '<=', $fiscal_period_format->format('Y'))->whereYear('to', '>=', $fiscal_period_format->format('Y'))->first();

            if (is_null($timeline_ciu)) {
                $timeline_ciu = TimelineCiiu::where('ciu_id', $ciu->id)->orderBy('id', 'desc')->take(1)->first();
            }


            //Calculo de minimo  a tributar
            $min_amount = $timeline_ciu->min_tribu_men * $tributo->value;

            //Calculo de base imponible
            $base_amount_sub = $timeline_ciu->alicuota * $base_format;

            //si lo que va a pagar es mayor que el min a tributar
            if ($base_amount_sub > $min_amount) {

                $min_amount = 0;
            } else {//si no paga minimo

                $base_amount_sub = $min_amount;
            }


            if ($date['mora']&&$date['diffDayMora']>=1) {//si tiene mora


                $recharge = Recharge::where('branch', 'Act.Eco')->whereDate('to', '>=', $fiscal_period_format)->whereDate('since', '<=', $fiscal_period_format)->first();

                if (is_null($recharge)) {
                    $recharge = Recharge::where('branch', 'Act.Eco')->orderBy('id', 'desc')->take(1)->first();
                }


                //Obtengo Intereset del banco
                $interest_bank = BankRate::orderBy('id', 'desc')->take(1)->first();

                $amount_recharge = $base_amount_sub * $recharge->value / 100;
                $interest = (($interest_bank->value_rate / 100) / 360) * $date['diffDayMora'] * ($amount_recharge + $base_amount_sub);

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

                if ($type === "DEPOSITO BANCARIO") {
                    $taxes = Payment::with('taxes')->whereIn('id', $id_taxes)->where('type_payment', '=', $type . '/EFECTIVO')->orWhere('type_payment', '=', $type . '/CHEQUE')->get();


                } else {
                    $taxes = Payment::with('taxes')->whereIn('id', $id_taxes)->where('type_payment', '=', $type)->get();
                }


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


    public function payments($type)
    {

        if ($type == 'DEPOSITO BANCARIO') {
            $payment = Payment::with('taxes')->where('type_payment', '=', $type . '/CHEQUE')->orWhere('type_payment', '=', $type . '/EFECTIVO')->orderBy('id','desc')->get();
        } else {
            $payment = Payment::with('taxes')->where('type_payment', '=', $type)->orderBy('id','desc')->get();
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


    public function detailsTaxesAteco($id)
    {
        $taxes = Taxe::findOrFail($id);

        $companyTaxe = $taxes->companies()->get();

        $ciuTaxes = CiuTaxes::where('taxe_id', $id)->get();
        $company_find = Company::find($companyTaxe[0]->id);
        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $amount = Calculate::calculateTaxes($id);
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


        return view('modules.ticket-office.ateco.details', ['taxes' => $taxes,
            'fiscal_period' => $fiscal_period,
            'ciuTaxes' => $ciuTaxes,
            'amount' => $amount,
            'verified' => $verified
        ]);


    }


    public function generateReceipt($taxes_data)
    {
        $taxes_data = substr($taxes_data, 0, -1);
        $taxes_explode = explode('-', $taxes_data);

        $amount_total = 0;

        $ciuTaxes = CiuTaxes::whereIn('taxe_id', $taxes_explode)->with('ciu')->with('taxes')->get();
        $companyTaxes = CompanyTaxe::whereIn('taxe_id', $taxes_explode)->get();

        for ($i = 0; $i < count($taxes_explode); $i++) {
            $amount = Calculate::calculateTaxes($taxes_explode[$i]);
            $amount_total += $amount['amountTotal'];
        }


        if ($ciuTaxes[0]->taxes->type != 'definitive') {
            $pdf = \PDF::loadView('modules.ticket-office.receipt-ticketoffice',
                [
                    'taxes' => $ciuTaxes,
                    'companyTaxes' => $companyTaxes,
                    'amount_total' => $amount_total
                ]);


        } else {
            $taxes = Taxe::find($ciuTaxes[0]->taxes->id);
            $ciuTaxes = CiuTaxes::where('taxe_id', $ciuTaxes[0]->taxes->id)->get();
            $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
                'taxes' => $taxes,
                'ciuTaxes' => $ciuTaxes,
                'firm' => true
            ]);
        }
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

        $data = ['status' => 'success', 'amount' => $amount];

        if ($amount == 0) {
            foreach ($taxes as $tax) {
                $taxes_find = Taxe::find($tax->id);
                $taxes_find->status = 'verified';

                if ($taxes_find->type === 'definitive') {
                    $code = TaxesNumber::generateNumberTaxes('PSP' . "89");
                    $taxes_find->code = $code;
                } elseif ($taxes_find->type === 'actuated') {

                    $code = TaxesNumber::generateNumberTaxes('PSP' . "81");
                    $taxes_find->code = $code;

                } elseif ($taxes_find->branch === 'Tasas y Cert') {
                    $code = TaxesNumber::generateNumberTaxes('PSP' . "88");
                    $taxes_find->code = $code;
                } elseif ($taxes_find->branch === 'Pat.Veh') {
                    $code = TaxesNumber::generateNumberTaxes('PSP' . "85");
                    $taxes_find->code = $code;
                } elseif ($taxes_find->branch === 'Inm.Urbanos') {
                    $code = TaxesNumber::generateNumberTaxes('PSP' . "84");
                    $taxes_find->code = $code;
                }

                $taxes_find->update();
            }


            $data = ['status' => 'verified'];
        }


        return response()->json($data);
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


        return response()->json(['status' => $taxes->statusName]);
    }


    public function paymentsDetails($id)
    {
        $payment = Payment::with('taxes')->where('id', '=', $id)->get();
        return view('modules.payments.details', ['payments' => $payment[0]]);
    }


    public function paymentsWeb()
    {
        $taxes = Taxe::with('companies')->where('status', '!=', 'temporal')->orderBy('id', 'desc')->get();
        return view('modules.payments.read_web', ['taxes' => $taxes]);
    }


    public function sendEmailVerified($id)
    {
        $taxes = Taxe::findOrFail($id);
        $band = false;
        $pdf = '';
        $email = '';


        if ($taxes->branch === 'Act.Eco') {


            if ($taxes->type == 'actuated' && $taxes->status == 'verified' || $taxes->status == 'verified-sysprim') {
                $taxes_find = CiuTaxes::whereIn('taxe_id', [$id])->with('ciu')->with('taxes')->get();
                $companyTaxe = $taxes->companies()->get();
                $company_find = Company::find($companyTaxe[0]->id);

                $user = $company_find->users()->get();

                $ciuTaxes = CiuTaxes::where('taxe_id', $id)->get();
                $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
                $amount = Calculate::calculateTaxes($id);


                $pdf = \PDF::loadView('modules.taxes.receipt',
                    ['taxes' => $taxes,
                        'fiscal_period' => $fiscal_period,
                        'ciuTaxes' => $ciuTaxes,
                        'amount' => $amount,
                        'firm' => true
                    ]);

                $band = true;
                $email = $user[0]->email;

            } elseif ($taxes->type == 'definitive' && ($taxes->status == 'verified' || $taxes->status == 'verified-sysprim')) {

                $ciuTaxes = CiuTaxes::where('taxe_id', $taxes->id)->get();
                $companyTaxe = $taxes->companies()->get();
                $company_find = Company::find($companyTaxe[0]->id);
                $user = $company_find->users()->get();

                $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
                    'taxes' => $taxes,
                    'ciuTaxes' => $ciuTaxes,
                    'firm' => true
                ]);

                $band = true;
            } else {

                $band = false;
                return response()->json(['status' => 'error', 'message' => 'El que correo no se envio, debido a que la planilla debe estar verificada.']);
            }


            $email = $user[0]->email;
        } elseif ($taxes->branch == 'Tasas y Cert' && ($taxes->status == 'verified' || $taxes->status == 'verified-sysprim')) {

            $rate = $taxes->rateTaxes()->get();
            $type = '';
            if (!is_null($rate[0]->pivot->company_id)) {
                $data = Company::find($rate[0]->pivot->company_id);
                $type = 'company';
            } else {
                $data = User::find($rate[0]->pivot->person_id);
                $type = 'user';
            }

            $pdf = \PDF::loadView('modules.rates.taxpayers.receipt', [
                'taxes' => $taxes,
                'data' => $data,
            ]);


            $user = User::find($rate[0]->pivot->user_id);;
            $email = $user->email;
            $band = true;
        } elseif ($taxes->branch == 'Inm.Urbanos' && ($taxes->status == 'verified' || $taxes->status == 'verified-sysprim')) {


            $owner = $taxes->properties()->get();
            $userProperty = UserProperty::where('property_id', $owner[0]->pivot->property_id)->first();
            $property = Property::find($userProperty->property_id);
            $propertyBuildings = Val_cat_const_inmu::where('property_id', $property->id)->get();
            $propertyTaxes = PropertyTaxes::where('taxe_id',$taxes->id)->first();

            if (!is_null($userProperty->company_id)) {
                $data = Company::find($userProperty->company_id);
                $type = 'company';
            } else {
                $data = User::find($userProperty->person_id);
                $type = 'user';
            }
            $pdf = \PDF::loadView('modules.properties-payments.receipt', [
                'taxes' => $taxes,
                'data' => $data,
                'property' => $property,
                'propertyTaxes' => $propertyTaxes,
                'type' => $type,
                'propertyBuildings' => $propertyBuildings,
                'firm' => true
            ]);

            $user = User::find($userProperty->user_id);
            $email = $user->email;
            $band = true;
        } elseif ($taxes->branch == 'Pat.Veh' && ($taxes->status == 'verified' || $taxes->status == 'verified-sysprim')) {

            $vehicleTaxes = $taxes->vehicleTaxes()->get();
            $diffYear = Carbon::now()->format('Y') - intval($vehicleTaxes[0]->year);
            $vehicleFind = Vehicle::find($vehicleTaxes[0]->id);
            $user = $vehicleFind->users()->get();


            $pdf = \PDF::loadView('modules.ticket-office.vehicle.modules.receipt.receipt', [
                'taxes' => $taxes,
                'vehicleTaxes' => $vehicleTaxes,
                'vehicle' => $vehicleFind,
                'user' => $user,
                'diffYear' => $diffYear,
                'firm' => true
            ]);


            $email = $user[0]->email;
            $band = true;
        } elseif ($taxes->branch == 'Prop. y Publicidad' && ($taxes->status == 'verified' || $taxes->status == 'verified-sysprim')) {
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
            $publicityTaxes = PublicityTaxe::where('taxe_id', $taxes->id)->first();

            $pdf = \PDF::loadView('modules.publicity-payments.receipt', [
                'taxes' => $taxes,
                'data' => $data,
                'publicity' => $publicity,
                'publicityTaxes' => $publicityTaxes,
                'type' => $type,
                'firm' => true
            ]);

            $user = User::find($userPublicity->user_id);
            $email = $user->email;
            $band = true;
        }


        if ($band) {
            $subject = "PLANILLA VERIFICADA";
            $for = $email;
            try {
                Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {
                    $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                    $msj->subject($subject);
                    $msj->to($for);
                    $msj->attachData($pdf->output(), time() . 'PLANILLA_VERIFICADA.pdf');
                });
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Ocurrio un error de conexión durante el envio de correo,recargue el navegador e intentelo mas tarde.']);
            }
        }
        return response()->json(['status' => 'success', 'message' => 'Correo enviado con éxito.']);
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

    public function verifyDefinitive($company_id,$fiscal_period)
    {

        $fiscal_period=Carbon::parse($fiscal_period)->format('Y');

        $date = Carbon::now();
        $company = Company::find($company_id);

        $tax = $company->taxesCompanies()->where('type', 'definitive')->whereYear('fiscal_period', $fiscal_period)->first();
        $statusTax = false;
        if (is_null($tax)) {
            $statusTax = false;
        } else {
            if ($tax->status === 'verified' || $tax->status === 'verified-sysprim') {
                $statusTax =true;
            } else if ($tax->status === 'temporal') {
//                      $tax->delete();
                $statusTax =false;
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
        return response()->json($statusTax);
    }


    public function registerTaxeDefinitive(Request $request){
        $datos = $request->all();
        $fiscal_period = $datos['fiscal_period'];

        $verify_prologue = CheckCollectionDay::verify('Act.Eco.Defi',$datos['fiscal_period']);

        $company = $datos['company_id'];

        $company_find = Company::find($company);

        $ciu_id = $datos['ciu_id'];
        $base = $datos['base'];
        $fiscal_credits = $datos['fiscal_credits'];
        $base_anticipated = $datos['anticipated'];

        $fiscal_period_end=Carbon::parse($fiscal_period)->format('Y');

        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('PTS89');
        $taxe->fiscal_period = $fiscal_period;
        $taxe->fiscal_period_end =$fiscal_period_end.'-12-31';
        $taxe->status = 'ticket-office';
        $taxe->type = 'definitive';
        $taxe->branch = 'Act.Eco';
        $taxe->save();

        $id = $taxe->id;
        $unid_tribu = Tributo::orderBy('id', 'desc')->take(1)->get();


        $amount_recharge = 0;
        $interest = 0;

        $amount_total = 0;
        $interest_total = 0;
        $recharge_total = 0;


        $fiscal_period_format = Carbon::parse($fiscal_period);
        $tributo = Tributo::whereDate('to', '>=', $fiscal_period_format)->whereDate('since', '<=', $fiscal_period_format)->first();

        if (is_null($tributo)) {
            $tributo = Tributo::orderBy('id', 'desc')->take(1)->first();
        }


        $taxes_amount = 0;
        $date = TaxesMonth::calculateDayMora($fiscal_period, $company_find->typeCompany);


        //format fiscal credits
        $fiscal_credits_format = str_replace('.', '', $fiscal_credits);
        $fiscal_credits_format = str_replace(',', '.', $fiscal_credits_format);


        $base_format_verify = 0;
        $total_base = 0;


        for ($i = 0; $i < count($base); $i++) {

            //damos formato a la base
            $base_format_verify = str_replace('.', '', $base[$i]);
            $base_format_verify = str_replace(',', '.', $base_format_verify);


            $anticipated_format_verify = str_replace('.', '', $base_anticipated[$i]);
            $anticipated_format_verify = str_replace(',', '.', $anticipated_format_verify);


            $ciu = Ciu::find($ciu_id[$i]);

            $timeline_ciu=TimelineCiiu::where('ciu_id',$ciu->id)->whereYear('since', '<=', $fiscal_period_format->format('Y'))->whereYear('to', '>=', $fiscal_period_format->format('Y'))->first();

            if (is_null($timeline_ciu)) {
                $timeline_ciu = TimelineCiiu::where('ciu_id',$ciu->id)->orderBy('id', 'desc')->take(1)->first();
            }


            //Calculo de minimo  a tributar
            $min_amount = $timeline_ciu->min_tribu_men * $tributo->value * 12;

            //Calculo de base imponible
            $base_amount_sub = $timeline_ciu->alicuota * $base_format_verify;


            if ($min_amount > $base_amount_sub) {
                $total_base = $total_base + $min_amount - $anticipated_format_verify;
            } else {
                $total_base = $total_base + $base_amount_sub - $anticipated_format_verify;
            }
        }

        if ($company_find->typeCompany == 'R') {
            $total_base = $total_base - $fiscal_credits_format;
        } else {
            $total_base = $total_base - $fiscal_credits_format;
        }


        if ($total_base < 0) {
            return response()->json(['status' => 'error', 'message' => 'La deducciones o creditos fiscal no pueder ser mayor que el impuesto causado.']);
        }


        for ($i = 0; $i < count($base); $i++) {
            //format a base


            $base_format = str_replace('.', '', $base[$i]);
            $base_format = str_replace(',', '.', $base_format);


            $anticipated_format = str_replace('.', '', $base_anticipated[$i]);
            $anticipated_format = str_replace(',', '.', $anticipated_format);

            $ciu = Ciu::find($ciu_id[$i]);

            $timeline_ciu=TimelineCiiu::where('ciu_id',$ciu->id)->whereYear('since', '<=', $fiscal_period_format->format('Y'))->whereYear('to', '>=', $fiscal_period_format->format('Y'))->first();

            if (is_null($timeline_ciu)) {
                $timeline_ciu = TimelineCiiu::where('ciu_id',$ciu->id)->orderBy('id', 'desc')->take(1)->first();
            }


            //Calculo de minimo  a tributar
            $min_amount = $timeline_ciu->min_tribu_men * $tributo->value * 12;

            //Calculo de base imponible
            $base_amount_sub = $timeline_ciu->alicuota * $base_format;



            //si lo que va a pagar es mayor que el min a tributar
            if ($base_amount_sub > $min_amount) {
                $min_amount = 0;
            } else {//si no paga minimo
                $base_amount_sub = $min_amount;
            }


            $taxes_amount += $base_amount_sub - $anticipated_format;


            if ($verify_prologue['mora']) {//si tiene mora


                $recharge = Recharge::where('branch', 'Act.Eco')->whereDate('to', '>=', $fiscal_period_format)->whereDate('since', '<=', $fiscal_period_format)->first();
                if (is_null($recharge)) {
                    $recharge = Recharge::orderBy('id', 'desc')->take(1)->first();
                }


                //Obtengo Intereset del banco
                $interest_bank = BankRate::orderBy('id', 'desc')->take(1)->first();

                $amount_recharge = ($base_amount_sub - $anticipated_format) * $recharge->value / 100;

                $interest = (($interest_bank->value_rate / 100) / 360) * $verify_prologue['diffDayMora'] * ($amount_recharge + ($base_amount_sub - $anticipated_format));

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
                    'base_anticipated' => $anticipated_format,
                    'taxable_minimum' => $min_amount
                ]);

            $interest_total += $interest;
            $recharge_total += $amount_recharge;

        }
        $day_mora = $verify_prologue['diffDayMora'];

        $taxe->companies()->attach(['taxe_id' => $id], [
            'company_id' => $company_find->id,
            'fiscal_credits' => $fiscal_credits_format,
            'withholding' => 0,
            'deductions' => 0,
            'day_mora' => $day_mora
        ]);

        $taxe = Taxe::find($taxe->id);
        $taxe->amount = ($taxes_amount - $fiscal_credits_format) + $recharge_total + $interest_total;
        $taxe->update();


        return response()->json(['status' => 'success', 'message' => '']);
    }


    public function detailsTaxesDefinitive($id)
    {
        $taxes = Taxe::find($id);
        $ciuTaxes = CiuTaxes::where('taxe_id', $taxes->id)->get();
        $companyTaxe = $taxes->companies()->get();
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

        return view('modules.ticket-office.ateco-definitive.details', [
            'taxes' => $taxes,
            'ciuTaxes' => $ciuTaxes,
            'verified' => $verified
        ]);
    }


    public function viewPDF($id)
    {
        $taxes = Taxe::findOrFail($id);

        $firm = false;

        $pdf = '';


        if ($taxes->status == 'verified' || $taxes->status == 'verified-sysprim') {
            $firm = true;
        }

        if ($taxes->branch === 'Act.Eco') {
            if ($taxes->type == 'actuated') {
                $taxes_find = CiuTaxes::whereIn('taxe_id', [$id])->with('ciu')->with('taxes')->get();
                $companyTaxe = $taxes->companies()->get();
                $company_find = Company::find($companyTaxe[0]->id);

                $user = $company_find->users()->get();

                $ciuTaxes = CiuTaxes::where('taxe_id', $id)->get();
                $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
                $amount = Calculate::calculateTaxes($id);


                $pdf = \PDF::loadView('modules.taxes.receipt',
                    ['taxes' => $taxes,
                        'fiscal_period' => $fiscal_period,
                        'ciuTaxes' => $ciuTaxes,
                        'amount' => $amount,
                        'firm' => $firm
                    ]);

            } elseif ($taxes->type == 'definitive') {
                $ciuTaxes = CiuTaxes::where('taxe_id', $taxes->id)->get();
                $companyTaxe = $taxes->companies()->get();
                $company_find = Company::find($companyTaxe[0]->id);
                $user = $company_find->users()->get();

                $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
                    'taxes' => $taxes,
                    'ciuTaxes' => $ciuTaxes,
                    'firm' => $firm
                ]);

            }


        } elseif ($taxes->branch === 'Tasas y Cert') {
            $rate = $taxes->rateTaxes()->get();
            $type = '';
            if (!is_null($rate[0]->pivot->company_id)) {
                $data = Company::find($rate[0]->pivot->company_id);
                $type = 'company';
            } else {
                $data = User::find($rate[0]->pivot->person_id);
                $type = 'user';
            }

            $pdf = \PDF::loadView('modules.rates.taxpayers.receipt', [
                'taxes' => $taxes,
                'data' => $data,
            ]);

        } elseif ($taxes->branch == 'Pat.Veh') {

            $vehicleTaxes = $taxes->vehicleTaxes()->get();
            $diffYear = Carbon::now()->format('Y') - intval($vehicleTaxes[0]->year);
            $vehicleFind = Vehicle::find($vehicleTaxes[0]->id);
            $user = $vehicleFind->users()->get();

            $pdf = \PDF::loadView('modules.ticket-office.vehicle.modules.receipt.receipt', [
                'taxes' => $taxes,
                'vehicleTaxes' => $vehicleTaxes,
                'vehicle' => $vehicleFind,
                'user' => $user,
                'diffYear' => $diffYear,
                'firm' => $firm
            ]);

        } elseif ($taxes->branch == 'Inm.Urbanos') {
            $owner = $taxes->properties()->get();
            $userProperty = UserProperty::where('property_id', $owner[0]->pivot->property_id)->first();

            $property = Property::find($userProperty->property_id);
            $propertyTaxes = PropertyTaxes::where('taxe_id', $taxes->id)->first();
            $propertyBuildings = Val_cat_const_inmu::where('property_id', $property->id)->get();

            if (!is_null($userProperty->company_id)) {
                $data = Company::find($userProperty->company_id);
                $type = 'company';
            } else {
                $data = User::find($userProperty->person_id);
                $type = 'user';
            }
            $pdf = \PDF::loadView('modules.properties-payments.receipt', [
                'taxes' => $taxes,
                'data' => $data,
                'property' => $property,
                'propertyTaxes' => $propertyTaxes,
                'type' => $type,
                'propertyBuildings' => $propertyBuildings
            ]);
        } elseif ($taxes->branch == 'Prop. y Publicidad') {
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
            $publicityTaxes = PublicityTaxe::where('taxe_id', $taxes->id)->first();
            $pdf = \PDF::loadView('modules.publicity-payments.receipt', [
                'taxes' => $taxes,
                'data' => $data,
                'publicity' => $publicity,
                'publicityTaxes' => $publicityTaxes,
                'type' => $type
            ]);
        }


        return $pdf->stream();
    }

    public function config()
    {
        return view('modules.ticket-office.config.manage');
    }

    public function dataFilterManage() {
        return view('modules.ticket-office.filter');
    }


}

