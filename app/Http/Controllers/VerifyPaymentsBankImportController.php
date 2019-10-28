<?php

namespace App\Http\Controllers;

use App\Imports\PaymentsImport;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use Mail;
use App\Taxe;
use App\Company;
use App\Extras;
use App\Tributo;
use App\Helpers\TaxesMonth;
use App\Http\Controllers\Controller;
use App\PaymentTaxes;
use Carbon\Carbon;

class VerifyPaymentsBankImportController extends Controller
{

    public function importFile(Request $request)
    {
        $file = $request->file;
        $Archivo = \File::get($file);
        $mime = $file->getMimeType();


        if ($mime == "text/plain") {
            $arch = fopen($file, 'r');
            $band = true;
            while (!feof($arch)) {
                $linea = fgets($arch);
                $otra = nl2br($linea);

                if ($band == true) {
                    $typeRegisBank = substr($otra, 0, 1);
                    $codeBank = substr($otra, 1, 5);
                    $codeAccount = substr($otra, 6, 5);
                    $date = substr($otra, 11, 10);
                    $amountTotal = substr($otra, 21, 14) . "<br>";
                    $amountTotalTwo = str_replace(',', '', $amountTotal);
                    $amountTotalThere = str_replace(',', '.', $amountTotal);

                    $band = false;
                } else {
                    $typeRegisterBank = substr($otra, 0, 1);
                    $document = substr($otra, 1, 10);
                    $reference = substr($otra, 11, 16);
                    $amount = substr($otra, 27, 14);
                    $amountTwo = str_replace(',', '', $amount);
                    $amountThere = str_replace(',', '.', $amount);
                    $viaPayments = substr($otra, 41, 30);
                    $numberCashierInternet = substr($otra, 71, 10);

                    $carbon = Carbon::now();
                    $taxes = Taxe::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
                    foreach ($taxes as $taxe) {
                        $code = substr($taxe->code, 3, 10);
                        if ($document == $code && $amountThere == $taxe->amount) {
                            $company = Company::find($taxe->company_id);
                            $fiscal_period = TaxesMonth::convertFiscalPeriod($taxe->fiscal_period);
                            $unid_tribu = Tributo::orderBy('id', 'desc')->take(1)->get();
                            $mora = Extras::orderBy('id', 'desc')->take(1)->get();
                            $extra = ['mora' => $mora[0]->mora, 'tasa' => $mora[0]->tax_rate, 'unid_tribu' => $unid_tribu[0]->value];

                            $userCompany = $company->users()->get();
                            $taxe->status = 'verified';
                            $taxe->update();


                            $subject = "Planilla Verificada";
                            $for = $userCompany[0]->email;
                            $pdf = \PDF::loadView('modules.taxes.receipt', ['taxes' => $taxe, 'fiscal_period' => $fiscal_period, 'extra' => $extra]);

                            Mail::send('dev.pago', [], function ($msj) use ($subject, $for, $pdf) {

                                $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                                $msj->subject($subject);
                                $msj->to($for);
                                $msj->attachData($pdf->output(), time().'Planilla_Verificada.pdf');
                            });
                        }
                    }
                }
            }
            fclose($arch);
        }
    }

    public function verifyPayments()
    {
        $taxes = Taxe::where('status','verified')
        ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
        return view('dev.verifyPaymentsBank.read',['taxes'=>$taxes]);
    }
}
