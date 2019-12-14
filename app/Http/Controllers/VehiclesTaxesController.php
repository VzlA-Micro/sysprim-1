<?php

namespace App\Http\Controllers;

use App\Helpers\DeclarationVehicle;
use App\VehiclesTaxe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use Mail;
use App\Helpers\TaxesMonth;
use App\Http\Controllers\Controller;
use App\Payments;
use Carbon\Carbon;
use App\Vehicle;
use App\Helpers\TaxesNumber;
use App\UserVehicle;
use App\Brand;
use App\ModelsVehicle;
use App\VehicleType;
use App\Taxe;

class VehiclesTaxesController extends Controller
{
    public function create($id)
    {
        $declaration = DeclarationVehicle::Declaration($id);

        $vehicle = Vehicle::where('id', $id)->get();
        $taxesVehicle = number_format($declaration['taxes'], 2, ',', '.');
        $taxesPayment = $declaration['taxes'];

        if ($declaration['optionPayment'] === true) {
            $discount = number_format($declaration['discount'], 2, ',', '.');
            $valueDiscount = number_format($declaration['valueDiscount'], 2, ',', '.');
            $rateYear = $declaration['rateYear'];
        } else {
            $discount = 0;
            $paymentFractional = number_format($declaration['fractionalPayments'], 2, ',', '.');
            $rateYear = $declaration['rateYear'];
            if (isset($declaration['recharge'])){
                $recharge=number_format($declaration['recharge'],2,',','.');
                //$previousDebt=number_format($declaration['previousDebt'],2,',','.');
                $PreviousDebt=$declaration['previousDebt'];
            }else{
                $recharge=0;
                $PreviousDebt=0;
            }
        }

        $total=$discount+$PreviousDebt+$declaration['total'];

        $taxes = new Taxe();
        $taxes->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxes->fiscal_period = Carbon::now()->format('Y-m-d');
        $taxes->save();

        $taxesId = $taxes->id;

        $vehicleTaxes = new VehiclesTaxe();
        $vehicleTaxes->vehicle_id = $vehicle[0]->id;
        $vehicleTaxes->taxe_id = $taxesId;
        $vehicleTaxes->amount_accumulated = $taxesPayment;
        $vehicleTaxes->save();

        $period_fiscal = Carbon::now()->format('Y');


        if ($declaration['optionPayment'] === true) {
            return view('modules.taxes.detailsVehicle', array(
                'vehicle' => $vehicle,
                'taxes' => $taxes,
                'taxesVehicle' => $taxesVehicle,
                'discount' => $discount,
                'period' => $period_fiscal,
                'valueDiscount' => $valueDiscount,
                'rateYear' => $rateYear,
                'recharge'=>$recharge,
                'previousDebt'=>$PreviousDebt,
                'total'=>$total
            ));
        } else {
            return view('modules.taxes.detailsVehicle', array(
                'vehicle' => $vehicle,
                'taxes' => $taxes,
                'taxesVehicle' => $paymentFractional,
                'period' => $period_fiscal,
                'discount' => $discount,
                'rateYear' => $rateYear,
                'recharge'=>$recharge,
                'previousDebt'=>$PreviousDebt,
                'total'=>$total
            ));
        }

    }

    public function taxesSave(Request $request)
    {
        $amountInterest = 0;//total de intereses
        $amountRecargo = 0;//total de recargos
        $amountCiiu = 0;//total de ciiu
        $amountDesc = 0;//Descuento
        $amountTaxes = 0;//total a de impuesto
        $amountTotal = 0;

        $id = $request->input('taxes_id');
        $amount = $request->input('total');

        $amount_format = str_replace('.', '', $amount);
        $amount_format = str_replace(',', '.', $amount_format);
        $taxes = Taxe::findOrFail($id);
        $taxes->amount = $amount_format;
        $taxes->status = 'temporal';
        $taxes->branch = 'Vehiculo';
        //$code = substr($code, 3, 12);


        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));
        // $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank, $code);

        $taxes->update();

        return view('modules.taxes.paymentsvehicle', ['taxes_id' => $id]);

    }

    public function store(Request $request)
    {
        /*
        $ciu=$request->input('ciu');
        $base=$request->input('base');
        $dedutions=$request->input('deductions');
        $withholding=$request->input('withholding');
        $fiscal_credits=$request->input('fiscal_credits');
       */

        $fiscal_period = $request->input('fiscal_period');
        $company = $request->input('company_id');
        $company_find = Company::find($company);
        $ciu_id = $request->input('ciu_id');
        $min_tribu_men = $request->input('min_tribu_men');
        $deductions = $request->input('deductions');
        $withholding = $request->input('withholding');
        $base = $request->input('base');
        $fiscal_credits = $request->input('fiscal_credits');

        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxe->fiscal_period = $fiscal_period;
        $taxe->status = 'temporal';
        $taxe->save();

        $id = $taxe->id;
        $unid_tribu = Tributo::orderBy('id', 'desc')->take(1)->get();
        $date = TaxesMonth::verify($company, false);

        for ($i = 0; $i < count($base); $i++) {
            //format a base
            $base_format = str_replace('.', '', $base[$i]);
            $base_format = str_replace(',', '.', $base_format);
            //format a deductions
            $deductions_format = str_replace('.', '', $deductions[$i]);
            $deductions_format = str_replace(',', '.', $deductions_format);
            //format withdolding
            $withholding_format = str_replace('.', '', $withholding[$i]);

            $withholding_format = str_replace(',', '.', $withholding_format);
            //format fiscal credits
            $fiscal_credits_format = str_replace('.', '', $fiscal_credits[$i]);
            $fiscal_credits_format = str_replace(',', '.', $fiscal_credits_format);


            $taxe->companies()->attach(['taxe_id' => $id], ['company_id' => $company_find->id]);

            $data = array([
                'status' => 'success',
                'message' => 'Impuesto registrada correctamente.'
            ]);
            return redirect('payments/taxes/' . $id);
        }
    }

    public function payments(Request $request)
    {

        $id_taxes = $request->input('id_taxes');
        $type_payment = $request->input('type_payment');
        $bank_payment = $request->input('bank_payment');
        $taxes = Taxe::findOrFail($id_taxes);
        $user = \Auth::user();
        $vehiclesTaxes = VehiclesTaxe::where('taxe_id', $id_taxes)->get();
        $vehicle = Vehicle::where('id', $vehiclesTaxes[0]->vehicle_id)->get();

        $declaration = DeclarationVehicle::Declaration($vehicle[0]->id);

        $taxesVehicle = number_format($declaration['taxes'], 2, ',', '.');
        if (isset($declaration['discount'])) {
            $discount = number_format($declaration['discount'], 2, ',', '.');
        }
        if (isset($valueDiscount)) {
            $valueDiscount = number_format($declaration['valueDiscount'], 2, ',', '.');
        }

        $rateYear = $declaration['rateYear'];

        $code = TaxesNumber::generateNumberTaxes($type_payment . "85");
        $taxes->code = $code;
        $code = substr($code, 3, 12);

        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));


        if ($type_payment != 'PPV') {
            $taxes->bank = $bank_payment;
            $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank_payment, $code);
        }

        $taxes->status = "process";
        $taxes->update();

        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);

        $subject = "PLANILLA DE PAGO";
        $for = \Auth::user()->email;

        if ($declaration['optionPayment']===true){
            $pdf = \PDF::loadView('modules.vehicles-payments.receipt',
                [
                    'taxes' => $taxes,
                    'user' => $user,
                    'fiscal_period' => $fiscal_period,
                    'firm' => false,
                    'taxesVehicle' => $taxesVehicle,
                    'discount' => $discount,
                    'valueDiscount' => $valueDiscount,
                    'vehicle' => $vehicle,
                    'moreThereYear' => $declaration['moreThereYear']
                ]);
        }else{
            $pdf = \PDF::loadView('modules.vehicles-payments.receipt',
                [
                    'taxes' => $taxes,
                    'user' => $user,
                    'fiscal_period' => $fiscal_period,
                    'firm' => false,
                    'taxesVehicle' => $taxesVehicle,
                    'vehicle' => $vehicle,
                    'moreThereYear' => $declaration['moreThereYear']
                ]);
        }

        Mail::send('mails.payment-payroll', [], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("grabieldiaz63@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
            $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });

        return redirect('payments/history/' . session('company'))->with('message', 'La planilla fue registra con éxito,fue enviado al correo ' . \Auth::user()->email . ',recuerda que esta planilla es valida solo por el dia ' . $date_format);
    }


}
