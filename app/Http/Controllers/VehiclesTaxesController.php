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
        $discount = number_format($declaration['discount'], 2, ',', '.');
        $valueDiscount = number_format($declaration['valueDiscount'], 2, ',', '.');
        $rateYear=$declaration['rateYear'];
        //var_dump($taxesVehicle);

        $taxes = new Taxe();
        $taxes->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxes->fiscal_period = Carbon::now()->format('Y-m-d');
        $taxes->save();

        $taxesId = $taxes->id;

        $vehicleTaxes = new VehiclesTaxe();
        $vehicleTaxes->vehicle_id = $vehicle[0]->id;
        $vehicleTaxes->taxe_id = $taxesId;
        $vehicleTaxes->amount_accumulated=$declaration['taxes'];
        $vehicleTaxes->save();

        $period_fiscal = Carbon::now()->format('Y');

        return view('modules.taxes.detailsVehicle',array(
            'vehicle'=>$vehicle,
            'taxes'=>$taxes,
            'taxesVehicle'=>$taxesVehicle,
            'discount'=>$discount,
            'period' => $period_fiscal,
            'valueDiscount'=>$valueDiscount,
            'rateYear'=>$rateYear
        ));


    }

    public function taxesSave(Request $request){
        $amountInterest=0;//total de intereses
        $amountRecargo=0;//total de recargos
        $amountCiiu=0;//total de ciiu
        $amountDesc=0;//Descuento
        $amountTaxes=0;//total a de impuesto
        $amountTotal=0;

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

        return view('modules.taxes.payments',['taxes_id'=>$id]);


        /*
        $taxes=Taxe::findOrFail($id);

        $ciuTaxes=CiuTaxes::where('taxe_id',$taxes->id)->get();
        $companyTaxe=$taxes->companies()->get();

        $company_find=Company::find($companyTaxe[0]->id);

        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $mora = Extras::orderBy('id', 'desc')->take(1)->get();
        $extra = ['tasa' => $mora[0]->tax_rate];

        foreach ($ciuTaxes as $ciu) {
            $amountInterest += $ciu->interest;
            $amountRecargo += $ciu->tax_rate;

            if ($company_find->TypeCompany === 'R') {
                $amountCiiu += $ciu->totalCiiu + $ciu->withholding - $ciu->deductions - $ciu->fiscal_credits;
            } else {
                $amountCiiu += $ciu->totalCiiu - $ciu->withholding - $ciu->fiscal_credits - $ciu->dedutions;
            }
        }

        $amountTaxes = $amountInterest + $amountRecargo + $amountCiiu;//Total

        //si tiene descuento

        if($company_find->desc){
            $employees = Employees::all();
            foreach ($employees as $employee) {
                if ($company_find->number_employees >= $employee->min) {
                    if ($company_find->number_employees <= $employee->max) {
                        $amountDesc = $amountTaxes * $employee->value / 100;

                    }
                }
            }

            $amountTaxes=$amountTaxes-$amountDesc;//descuento
        }*/

        /*
        $amount = ['amountInterest' => $amountInterest,
            'amountRecargo' => $amountRecargo,
            'amountCiiu' => $amountCiiu,
            'amountTotal' => $amountTaxes,
            'amountDesc' => $amountDesc
        ];


        $subject = "PLANILLA DE PAGO";
        $for = \Auth::user()->email;
        $pdf = \PDF::loadView('modules.taxes.receipt', ['taxes' => $taxes,
            'fiscal_period' => $fiscal_period,
            'extra' => $extra,
            'ciuTaxes' => $ciuTaxes,
            'amount' => $amount,
            'firm' => false
        ]);

        Mail::send('mails.payment-payroll', [], function ($msj) use ($subject, $for, $pdf) {
            $msj->from("grabieldiaz63@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
            $msj->attachData($pdf->output(), time() . "planilla.pdf");
        });

        return redirect('payments/history/' . session('company'))->with('message', 'La planilla fue registra con éxito,fue enviado al correo ' . \Auth::user()->email . ',recuerda que esta planilla es valida solo por el dia ' . $date_format);
        */



    }

}
