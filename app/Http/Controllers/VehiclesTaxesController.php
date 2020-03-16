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
use App\Helpers\CheckCollectionDay;
class VehiclesTaxesController extends Controller
{
    public function create($id)
    {

        $array = explode('-', $id);
        $idVehicle = $array[0];
        $optionPayment = null;
        $vehicle = Vehicle::where('id', $idVehicle)->with('company')->get();
        if (isset($array[1])) {
            if ($array[1] == 'false' || $array[1] == 'true') {
                if ($array[1] === 'false') {
                    $optionPayment = false;
                } else {

                    $optionPayment = true;
                }
            }
        }


        $trimester = Trimester::verifyTrimester();

        $date = Carbon::now();

        $vehicleTaxe = Vehicle::find($idVehicle);
        if ($vehicleTaxe->taxesVehicle->isEmpty()) {
            $taxes = '';
        } else {
            $taxes = Taxe::whereIn('id', $vehicleTaxe->taxesVehicle)->get();

        }




        if (!empty($taxes)) {
            foreach ($taxes as $tax) {
                if ($tax->status === 'verified' || $tax->status === 'verified-sysprim') {
                    $statusTax = 'verified';
                } else if ($tax->status === 'Temporal') {
                    DeclarationVehicle::verify($idVehicle);
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


        $declaration = DeclarationVehicle::Declaration($idVehicle, $optionPayment);

        $type = null;

        //$vehicle = Vehicle::where('id', $idVehicle)->get();

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
            $period_fiscal_begin = $trimester['monthBegin']->format('Y-m-d');
            $period_fiscal_end = $trimester['monthEnd']->format('Y') . '-12-01';
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

        if ($statusTax === 'process'){
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
                'totalAux' => $totalAux,
                'statusTax' => $statusTax
            ));
        }

        $taxes = new Taxe();
        $taxes->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxes->fiscal_period = $period_fiscal_begin;
        $taxes->fiscal_period_end = $period_fiscal_end;
        $taxes->status = 'Temporal';
        $taxes->type = $type;
        $taxes->amount = $totalAux;
        $taxes->status = 'temporal';
        $taxes->branch = 'Pat.Veh';

        $taxes->save();

        $taxesId = $taxes->id;

        $vehicleTaxes = new VehiclesTaxe();
        $vehicleTaxes->vehicle_id = $vehicle[0]->id;
        $vehicleTaxes->taxe_id = $taxesId;
        $vehicleTaxes->status = 'Temporal';
        $vehicleTaxes->type_payments = $declaration['optionPayment'];
        $vehicleTaxes->fiscal_credits = 0;


        $vehicleTaxes->recharge = $declaration['recharge'];
        $vehicleTaxes->recharge_mora = $declaration['valueMora'];
        $vehicleTaxes->base_imponible = $declaration['grossTaxes'];
        $vehicleTaxes->previous_debt = $declaration['previousDebt'];
        $vehicleTaxes->discount = $declaration['valueDiscount'];
        $vehicleTaxes->save();


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
            'totalAux' => $totalAux,
            'statusTax' => $statusTax
        ));
    }


    public
    function taxesSave(Request $request)
    {
        $id = $request->input('taxes_id');
        $amount = $request->input('total');
        $fiscalCredits = $request->input('fiscal_credits');
        $recharge = $request->input('recharge');
        $recharge_mora = $request->input('rechargeMora');
        $previouDebt = $request->input('previou_debt');
        $discount = $request->input('discount');
        $base = $request->input('base');
        $companyId = $request->input('companyId');
        $idVehicle = $request->input('vehicleId');

        $declaration = DeclarationVehicle::Declaration($idVehicle, true);
        if (isset($companyId)) {
            $vehicle = Vehicle::where('id', $idVehicle)->with('company')->get();

        }
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

        //$vehicleTaxes = VehiclesTaxe::find($idVehicleTaxes[0]->id);
        //$vehicleTaxes->fiscal_credits = $fiscalCredits_format;
        //$vehicleTaxes->recharge = $recharge_format;
        //$vehicleTaxes->recharge_mora = $rechargeMora_format;
        //$vehicleTaxes->base_imponible = $base_format;
        //$vehicleTaxes->previous_debt = (float)$previouDebt_format;
        //$vehicleTaxes->discount = $discount_format;
        //$vehicleTaxes->update();

        $date_format = date("Y-m-d", strtotime($taxes->created_at));
        $date = date("d-m-Y", strtotime($taxes->created_at));
        // $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank, $code);

        $taxes->update();
        if (isset($vehicle)) {
            return view('modules.taxes.paymentsVehicle', ['taxes_id' => $id, 'vehicle' => $vehicle]);
        } else {
            return view('modules.taxes.paymentsVehicle', ['taxes_id' => $id]);
        }


    }

    public
    function payments(Request $request)
    {
        $type_payment = $request->input('type_payment');
        $bank_payment = $request->input('bank_payment');

        $id_taxes = $request->input('id_taxes');

        $taxes = Taxe::findOrFail($id_taxes);

        $vehiclesTaxes = VehiclesTaxe::where('taxe_id', $id_taxes)->get();
        $vehiclesTaxe = VehiclesTaxe::find($vehiclesTaxes[0]->id);

        //$vehicle=Vehicle::where('id',$vehiclesTaxe->id)->with('company')->get();

        $code = TaxesNumber::generateNumberTaxes($type_payment . "85");
        $taxes->code = $code;
        $code = substr($code, 3, 12);

        $date_format = date("Y-m-d", strtotime($taxes->created_at));

        if ($type_payment != 'PPV') {
            $taxes->bank = $bank_payment;
            $taxes->digit = TaxesNumber::generateNumberSecret($taxes->amount, $date_format, $bank_payment, $code);
        }
        $taxes->bank_name= CheckCollectionDay::getNameBank($bank_payment);
        $taxes->status = "process";
        $taxes->update();


        $vehiclesTaxe->status = 'process';
        $vehiclesTaxe->update();

        $vehicleTaxes = $taxes->vehicleTaxes()->get();
        $diffYear = Carbon::now()->format('Y') - intval($vehicleTaxes[0]->year);
        $vehicleFind = Vehicle::find($vehicleTaxes[0]->id);
        $user = $vehicleFind->users()->get();


        $subject = "PLANILLA DE PAGO";
        $for = $user[0]->email;
        /*$var=[
            'taxes' => $taxes,
            'vehicleTaxes' => $vehicleTaxes,
            'vehicle' => $vehicleFind,
            'user' => $user,
            'diffYear' => $diffYear,
            'firm' => true
        ];
        dd($var);
    */
        $pdf = \PDF::loadView('modules.ticket-office.vehicle.modules.receipt.receipt',
            [
                'taxes' => $taxes,
                'vehicleTaxes' => $vehicleTaxes,
                'vehicle' => $vehicleFind,
                'user' => $user,
                'diffYear' => $diffYear,
                'firm' => true
            ]);

        //return $pdf->stream('PLANILLA_SOLVENCIA.pdf');

        Mail::send('mails.payment-payroll', ['type' => 'Declaración de Patente De Vehículo (ANTICIPADA)'], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("grabieldiaz63@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
            $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });

        return redirect()->route('vehicle.payments.history', ['id' => $vehicleTaxes[0]->id])->with('message', 'La planilla fue registra con éxito, fue enviado al correo ' . \Auth::user()->email . ', recuerda que esta planilla es valida solo por el dia ' . $date_format);
    }

    public function history($vehicleId)
    {
        $vehicle = Vehicle::where('id', $vehicleId)->with('company')->get();
        $vehicles = Vehicle::find($vehicleId);
        if (isset($vehicle[0]->company[0])) {
            return view('modules.vehicles-payments.history', ['taxes' => $vehicles->taxesVehicle()->get(), 'vehicle' => $vehicle[0]]);
        } else {
            return view('modules.vehicles-payments.history', ['taxes' => $vehicles->taxesVehicle()->get(), 'vehicle' => $vehicle[0]]);

        }
    }

    public
    function downloadPDF($id, $download)
    {
        $taxes = Taxe::find($id);

        $vehicleTaxes = $taxes->vehicleTaxes()->get();
        $diffYear = Carbon::now()->format('Y') - intval($vehicleTaxes[0]->year);
        $vehicleFind = Vehicle::find($vehicleTaxes[0]->id);
        $user = $vehicleFind->users()->get();

        if (isset($vehicleFind->person[0]->pivot->person_id)){
            $person=User::find($vehicleFind->person[0]->pivot->person_id);
        }else{
            $person='';
        }


        $pdf = \PDF::loadView('modules.ticket-office.vehicle.modules.receipt.receipt',
            [
                'taxes' => $taxes,
                'vehicleTaxes' => $vehicleTaxes,
                'vehicle' => $vehicleFind,
                'user' => $user,
                'person'=>$person,
                'diffYear' => $diffYear,
                'firm' => true
            ]);
        if ($download === "true") {
            return $pdf->download('PLANILLA.pdf');
        } else {
            return $pdf->stream('PLANILLA.pdf');
        }


    }

    public
    function creditsFiscal($fiscalCredit,$vehicleId)
    {
        //$total = (float)$request->input('total');
        $fiscalCredits_format = str_replace('.', '', $fiscalCredit);
        $fiscalCredits_format = str_replace(',', '.', $fiscalCredits_format);
        $fiscalCredits = $fiscalCredits_format;
        $idVehicle = $vehicleId;
        $vehicleTaxes=VehiclesTaxe::where('vehicle_id',$idVehicle)->latest()
            ->first();
        $vehicleTaxe=VehiclesTaxe::find($vehicleTaxes->id);
        $taxes=Taxe::where('id',$vehicleTaxes->taxe_id)->latest()
            ->first();
        $aux = 0;
//dd($taxes);
        if ($fiscalCredits >= 0) {
            $aux = $taxes->amount - $fiscalCredits;
            if ($aux < 0) {
                //DEVUELVO TRUE SI EL VALOR QUE INTRODUJO
                // EN EL CREDITO FISCAL ES MAYOR AL QUE LE CORRESPONDE
                //CANCELAR
                return response()->json([true]);
            } else {
                //DEVUELVO FALSE SI EL CREDITO FISCAL ES IGUAL O MENOR AL MONTO A PAGAR
                $vehicleTaxe->fiscal_credits=$fiscalCredits;
                $vehicleTaxe->update();

                $taxes->amount=$aux;
                $taxes->update();

                $totalAux = (string)number_format($aux, 2, ',', '.');
                $fiscalCreditsAux = (string)number_format($fiscalCredits, 2, ',', '.');
                return response()->json([false, $totalAux, $fiscalCreditsAux]);
            }
        }
    }


    /* public function paymentsDeclaration($id, $optionPayment)
     {

         $trimester = Trimester::verifyTrimester();

         $declaration = DeclarationVehicle::Declaration($id, $optionPayment);

         $type = null;

         $vehicle = Vehicle::where('id', $id)->with('company')->get();

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

 }*/

}

