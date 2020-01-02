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
        $vehicleTaxe=VehiclesTaxe::where('vehicle_id',$id)
            ->where('status','process')->get();


        if (!Empty($vehicleTaxe[0])) {
            return view('modules.taxes.detailsVehicle', array('vehicleTaxes'=>true));
        } else {
            $declaration = DeclarationVehicle::Declaration($id);

            $vehicle = Vehicle::where('id', $id)->get();

            $grossTaxes = 0;
            $total = number_format($declaration['total'], 2, ',', '.');
            $paymentFractional = 0;
            $valueDiscount = 0;
            if ($declaration['optionPayment'] == 'true') {
                $total = number_format($declaration['total'], 2, ',', '.');
                $valueDiscount = number_format($declaration['valueDiscount'], 2, ',', '.');
                $rateYear = $declaration['rateYear'];
                $grossTaxes = number_format($declaration['grossTaxes'], 2, ',', '.');
                $previousDebt = $declaration['previousDebt'];
                $recharge = 0;
            } else {
                $paymentFractional = number_format($declaration['fractionalPayments'], 2, ',', '.');
                $grossTaxes = $paymentFractional;
                $rateYear = $declaration['rateYear'];
                if (isset($declaration['recharge'])) {
                    $recharge = number_format($declaration['recharge'], 2, ',', '.');
                    if ($declaration['previousDebt'] !== 0) {
                        $previousDebt = number_format($declaration['previousDebt'], 2, ',', '.');
                    }

                }
            }

            $taxes = new Taxe();
            $taxes->code = TaxesNumber::generateNumberTaxes('TEM');
            $taxes->fiscal_period = Carbon::now()->format('Y-m-d');
            $taxes->save();

            $taxesId = $taxes->id;

            $vehicleTaxes = new VehiclesTaxe();
            $vehicleTaxes->vehicle_id = $vehicle[0]->id;
            $vehicleTaxes->taxe_id = $taxesId;
            $vehicleTaxes->status = 'Temporal';
            $vehicleTaxes->save();

            $period_fiscal = Carbon::now()->format('Y');

            return view('modules.taxes.detailsVehicle', array(
                'vehicle' => $vehicle,
                'taxes' => $taxes,
                'grossTaxes' => $grossTaxes,
                'paymentFractional' => $paymentFractional,
                'period' => $period_fiscal,
                'valueDiscount' => $valueDiscount,
                'rateYear' => $rateYear,
                'recharge' => $recharge,
                'previousDebt' => $previousDebt,
                'total' => $total,
                'vehicleTaxes'=>false
            ));
        }
    }


    public function taxesSave(Request $request)
    {
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


    public function payments(Request $request)
    {

        $id_taxes = $request->input('id_taxes');
        $type_payment = $request->input('type_payment');
        $bank_payment = $request->input('bank_payment');
        $taxes = Taxe::findOrFail($id_taxes);
        $user = \Auth::user();
        $vehiclesTaxes = VehiclesTaxe::where('taxe_id', $id_taxes)->get();
        $vehicle = Vehicle::where('id', $vehiclesTaxes[0]->vehicle_id)->get();
        $vehiclesTaxe=VehiclesTaxe::find($vehiclesTaxes[0]->id);

        $declaration = DeclarationVehicle::Declaration($vehicle[0]->id);

        $grossTaxes = 0;
        $total = $declaration['total'];
        $paymentFractional = 0;
        $valueDiscount = 0;

        if ($declaration['optionPayment'] == 'true') {
            $total = $declaration['total'];
            $valueDiscount = $declaration['valueDiscount'];
            $rateYear = $declaration['rateYear'];
            $grossTaxes = $declaration['grossTaxes'];
            $previousDebt = $declaration['previousDebt'];
            $recharge = 0;
        } else {
            $paymentFractional = $declaration['fractionalPayments'];
            $grossTaxes = $paymentFractional;
            $rateYear = $declaration['rateYear'];
            if (isset($declaration['recharge'])) {
                $recharge = $declaration['recharge'];
                if ($declaration['previousDebt'] !== 0) {
                    $previousDebt = $declaration['previousDebt'];
                }

            }
        }

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

        $vehiclesTaxe->status='process';
        $vehiclesTaxe->update();


        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);

        $subject = "PLANILLA DE PAGO";
        $for = \Auth::user()->email;

        $pdf = \PDF::loadView('modules.vehicles-payments.receipt',
            [
                'taxes' => $taxes,
                'user' => $user,
                'fiscal_period' => $fiscal_period,
                'firm' => false,
                'grossTaxes' => $grossTaxes,
                'recharge' => $recharge,
                'previousDebt' => $previousDebt,
                'valueDiscount' => $valueDiscount,
                'vehicle' => $vehicle,
                'total' => $total,
                'moreThereYear' => $declaration['moreThereYear']
            ]);


        Mail::send('mails.payment-payroll', [], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("grabieldiaz63@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
            $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });

        return redirect('payments/history/' . session('company'))->with('message', 'La planilla fue registra con éxito,fue enviado al correo ' . \Auth::user()->email . ',recuerda que esta planilla es valida solo por el dia ' . $date_format);
    }


}
