<?php

namespace App\Http\Controllers;

use App\Helpers\DeclarationVehicle;
use App\Helpers\Trimester;
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
    { $trimester = Trimester::verifyTrimester();

        $vehicleTaxe = VehiclesTaxe::where('vehicle_id', $id)
            ->where('status', 'process')->get();

        $vehicleTaxesTem = VehiclesTaxe::where('vehicle_id', $id)
            ->where('status', 'process')->get();


        if (!Empty($vehicleTaxe[0])) {
            return view('modules.taxes.detailsVehicle', array('vehicleTaxes' => true));
        } else {

            if (!Empty($vehicleTaxesTem[0])) {
                DeclarationVehicle::verify($id, $temporal = true);
            }
            $declaration = DeclarationVehicle::Declaration($id);

            $vehicle = Vehicle::where('id', $id)->get();

            $grossTaxes = 0;
            $total = number_format($declaration['total'], 2, ',', '.');
            $totalAux = $declaration['total'];
            $paymentFractional = 0;
            $valueDiscount = 0;
            if ($declaration['valueMora'] == 0) {
                $valueMora = 0;
            } else {
                $valueMora = number_format($declaration['dayMora'], 2, ',', '.');
            }

            if ($declaration['optionPayment']) {
                $period_fiscal = $trimester['monthBegin']->format('m-Y'). ' / ' .'12/'.$trimester['monthEnd']->format('Y');
                $total = number_format($declaration['total'], 2, ',', '.');
                $valueDiscount = number_format($declaration['valueDiscount'], 2, ',', '.');
                $rateYear = $declaration['rateYear'];
                $grossTaxes = number_format($declaration['grossTaxes'], 2, ',', '.');
                $previousDebt = $declaration['previousDebt'];
                $recharge = 0;
                $period_fiscal_begin=$trimester['monthBegin']->format('m-Y');
                $period_fiscal_end='12/'.$trimester['monthEnd']->format('Y');
            } else {
                $period_fiscal = $trimester['monthBegin']->format('m-Y'). ' / ' . $trimester['monthEnd']->format('m-Y');
                $paymentFractional = number_format($declaration['fractionalPayments'], 2, ',', '.');
                $grossTaxes = $paymentFractional;
                $rateYear = $declaration['rateYear'];
                $period_fiscal_begin=$trimester['monthBegin']->format('m-Y');
                $period_fiscal_end=$trimester['monthEnd']->format('m-Y');
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
            $taxes->fiscal_period =$period_fiscal_begin ;
            $taxes->fiscal_period_end=$period_fiscal_end;
            $taxes->save();

            $taxesId = $taxes->id;

            $vehicleTaxes = new VehiclesTaxe();
            $vehicleTaxes->vehicle_id = $vehicle[0]->id;
            $vehicleTaxes->taxe_id = $taxesId;
            $vehicleTaxes->status = 'Temporal';
            $vehicleTaxes->type_payments = $declaration['optionPayment'];
            $vehicleTaxes->fiscal_credits = 0;
            $vehicleTaxes->save();


            //$period_fiscal = $trimester['monthBegin']->format('m-Y'). ' / ' . $trimester['monthEnd']->format('m-Y');

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
                'vehicleTaxes' => false,
                'valueMora' => $valueMora,
                'totalAux' => $totalAux
            ));
        }

    }


    public function taxesSave(Request $request)
    {
        $id = $request->input('taxes_id');
        $amount = $request->input('total');
        $fiscalCredits = $request->input('fiscal_credits');
        $recharge = $request->input('recharge');
        $recharge_mora = $request->input('rechargeMora');
        $previouDebt = $request->input('previou_debt');
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

        if ($previouDebt !== 0) {
            $previouDebt_format = str_replace('.', '', $previouDebt);
            $previouDebt_format = str_replace(',', '.', $previouDebt_format);
        } else {
            $previouDebt_format = 0;
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
        $taxes->status = 'temporal';
        $taxes->branch = 'Pat.Veh';

        $idVehicleTaxes = VehiclesTaxe::where('taxe_id', $id)->get();



        $vehicleTaxes = VehiclesTaxe::find($idVehicleTaxes[0]->id);
        $vehicleTaxes->fiscal_credits = $fiscalCredits_format;
        $vehicleTaxes->recharge = $recharge_format;
        $vehicleTaxes->recharge_mora = $rechargeMora_format;
        $vehicleTaxes->base_imponible = $base_format;
        $vehicleTaxes->previous_debt = (float)$previouDebt_format;
        $vehicleTaxes->discount=$discount_format;
        $vehicleTaxes->update();

        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));
        // $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank, $code);

        $taxes->update();

        return view('modules.taxes.paymentsvehicle', ['taxes_id' => $id]);
    }


    public function payments(Request $request)
    {
        $type_payment = $request->input('type_payment');
        $bank_payment = $request->input('bank_payment');

        $id_taxes = $request->input('id_taxes');

        $taxes = Taxe::findOrFail($id_taxes);
        $user = \Auth::user();
        $vehiclesTaxes = VehiclesTaxe::where('taxe_id', $id_taxes)->get();
        $vehicle = Vehicle::where('id', $vehiclesTaxes[0]->vehicle_id)->get();
        $vehiclesTaxe = VehiclesTaxe::find($vehiclesTaxes[0]->id);

        $declaration = DeclarationVehicle::Declaration($vehicle[0]->id);

        $grossTaxes = 0;
        $total = $declaration['total'];
        $paymentFractional = 0;
        $valueDiscount = 0;
        $valueMora = $declaration['valueMora'];

        if ($declaration['optionPayment']) {
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

        $vehiclesTaxe->status = 'process';
        $vehiclesTaxe->update();

        $trimester = Trimester::verifyTrimester();
        $period_fiscal = Carbon::now()->format('m-Y') . ' / ' . $trimester['trimesterEnd'];

        $subject = "PLANILLA DE PAGO";
        $for = \Auth::user()->email;

        $pdf = \PDF::loadView('modules.vehicles-payments.receipt',
            [
                'taxes' => $taxes,
                'user' => $user,
                'fiscal_period' => $period_fiscal,
                'firm' => false,
                'grossTaxes' => $grossTaxes,
                'recharge' => $recharge,
                'previousDebt' => $previousDebt,
                'valueDiscount' => $valueDiscount,
                'vehicle' => $vehicle,
                'total' => $total,
                'moreThereYear' => $declaration['moreThereYear'],
                'fiscalCredits' => $vehiclesTaxe->fiscal_credits,
                'rechargeMora' => $vehiclesTaxe->recharge_mora
            ]);


        Mail::send('mails.payment-payroll', ['type' => 'Declaración de Patente De Vehículo (ANTICIPADA)'], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("grabieldiaz63@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
            $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });

        $vehicleID = $vehicle[0]->id;

        return redirect()->route('vehicle.payments.history', ['id' => $vehicleID]);
    }

    public function history($vehicleId)
    {
        $vehicle = Vehicle::find($vehicleId);

        return view('modules.vehicles-payments.history', ['taxes' => $vehicle->taxesVehicle()->get()]);
    }

    public function downloadPDF($id)
    {
        $declaration = DeclarationVehicle::Declaration($id);

        $id_vehicle = explode('-', $id);

        $taxes = Taxe::findOrFail($id_vehicle[1]);
        $user = \Auth::user();
        $vehicle = Vehicle::where('id', $id_vehicle[0])->get();
        $idTaxesVehicle = VehiclesTaxe::where('taxe_id', $id_vehicle[1])->get();
        $vehiclesTaxe = VehiclesTaxe::find($idTaxesVehicle[0]->id);


        $grossTaxes = 0;
        $total = $declaration['total'];
        $paymentFractional = 0;
        $valueDiscount = 0;

        if ($declaration['optionPayment']) {
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

        $trimester = Trimester::verifyTrimester();
        $period_fiscal = Carbon::now()->format('m-Y') . ' / ' . $trimester['trimesterEnd'];

        $pdf = \PDF::loadView('modules.vehicles-payments.receipt',
            [
                'taxes' => $taxes,
                'user' => $user,
                'fiscal_period' => $period_fiscal,
                'firm' => false,
                'grossTaxes' => $grossTaxes,
                'recharge' => $recharge,
                'previousDebt' => $previousDebt,
                'valueDiscount' => $valueDiscount,
                'vehicle' => $vehicle,
                'total' => $total,
                'moreThereYear' => $declaration['moreThereYear'],
                'fiscalCredits' => $vehiclesTaxe->fiscal_credits,
                'rechargeMora' => $vehiclesTaxe->recharge_mora
            ]);


        return $pdf->download('PLANILLA_SOLVENCIA.pdf');
    }

    public function creditsFiscal(Request $request)
    {
        $total = $request->input('total');
        $fiscalCredits = $request->input('creditsFiscal');
        $aux = 0;

        if ($fiscalCredits >= 0) {
            $aux = $total - $fiscalCredits;
            if ($aux < 0) {
                //DEVUELVO TRUE SI EL VALOR QUE INTRODUJO
                // EN EL CREDITO FISCAL ES MAYOR AL QUE LE CORRESPONDE
                //CANCELAR
                return response()->json([true]);
            } else {
                //DEVUELVO FALSE SI EL CREDITO FISCAL ES IGUAL O MENOR AL MONTO A PAGAR
                $totalAux = (string)number_format($aux, 2, ',', '.');
                $fiscalCreditsAux = (string)number_format($fiscalCredits, 2, ',', '.');
                return response()->json([false, $totalAux, $fiscalCreditsAux]);
            }

        }
    }


}
