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
use App\Payments;
use Carbon\Carbon;
use App\Employees;
use App\CiuTaxes;
use App\CompanyTaxe;


class VerifyPaymentsBankImportController extends Controller
{

    public function importFile(Request $request)
    {

        //$amountInterest=0;//total de intereses
        //$amountRecargo=0;//total de recargos
        //$amountCiiu=0;//total de ciiu
        //$amountDesc=0;//Descuento
        //$amountTaxes=0;//total a de impuesto
        //$amountTotal=0;


        $file = $request->file;

        $Archivo = \File::get($file);
        $mime = $file->getMimeType();

        if ($mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            Excel::import(new PaymentsImport, request()->file('file'));
        }

        if ($mime == "text/plain") {
            //Archivo);
            //var_dump($file);


            $arch = fopen($file, 'r');

            //$hola=stream_get_contents($arch);
            //var_dump($arch);

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
                }
                if ($codeBank == '00116' && $band == false) {
                    $typeRegisterBank = substr($otra, 0, 1);
                    $document = substr($otra, 1, 10);
                    $reference = substr($otra, 11, 16);
                    $amount = substr($otra, 27, 14);
                    $amountTwo = str_replace(',', '', $amount);
                    $amountThere = str_replace(',', '.', $amount);
                    $viaPayments = substr($otra, 41, 3);


                    //echo $typeRegisterBank . '<br>';
                    //echo $codeBank . '<br>';
                    //echo $codeAccount . '<br>';
                    //echo $date . '<br>';
                    //echo $amountTotalTwo . '<br>';
                    //echo $amountTotalThere . '<br>';

                    //echo 'este es el que es' . ltrim($amountTotal, '0');

                    //echo $typeRegisterBank . '<br>';
                    //echo $document . '<br>';
                    //echo $reference . '<br>';
                    //echo $amount . '<br>';
                    //echo 'este es el que es' . ltrim($amount, '0') . '<br>';
                    //echo $amountTwo.'<br>';
                    //echo $amountThere.'<br>';
                    //echo $viaPayments . '<br>';

                } else {

                    $typeRegisterBank = substr($otra, 0, 1);
                    $document = substr($otra, 1, 10);
                    $reference = substr($otra, 11, 16);
                    $amount = substr($otra, 27, 14);
                    $amountTwo = str_replace(',', '', $amount);
                    $amountThere = str_replace(',', '.', $amount);
                    $viaPayments = substr($otra, 41, 30);
                    $numberCashierInternet = substr($otra, 71, 10);

                    //echo $typeRegisterBank . '<br>';
                    //echo $document . '<br>';
                    //echo $reference . '<br>';
                    //echo $amount . '<br>';
                    //echo 'este es el que es' . ltrim($amount, '0') . '<br>';
                    //echo $amountTwo.'<br>';
                    //echo $amountThere.'<br>';
                    //echo $viaPayments . '<br>';

                    $carbon = Carbon::now();

                    $taxes = Taxe::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
                    foreach ($taxes as $taxe) {
                        $code = substr($taxe->code, 3, 10);

                        //&& $amountThere == $taxe->amount
                        if ($document == $code && $taxe->status == 'process') {


                            $pCode = substr($taxe->code, 0, 3);
                            if ($pCode == 'PPC') {
                            } else {


                                if ($pCode == 'PPT' || $pCode == 'PPE') {
                                    echo "soy jhon";
                                    if ($taxe->branch == 'Act.Eco') {

                                        $companyTaxes = CompanyTaxe::where('taxe_id', $taxe->id)->get();

                                        $ciuTaxes = CiuTaxes::where('taxe_id', $taxe->id)->get();
                                        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxe->fiscal_period);
                                        $company = Company::find($companyTaxes[0]->company_id);
                                        $userCompany = $company->users()->get();

                                        foreach ($ciuTaxes as $ciu) {

                                            $pdf = \PDF::loadView('modules.taxes.receipt', [
                                                'taxes' => $taxe,
                                                'fiscal_period' => $fiscal_period,
                                                'ciuTaxes' => $ciuTaxes,
                                                'amount' => $amount,
                                                'companyTaxes' => $companyTaxes,
                                                'firm' => true
                                            ]);


                                            $userCompany = $company->users()->get();
                                            $taxe->status = 'verified';
                                            $taxe->update();;

                                            $subject = "Planilla Verificada";
                                            $for = $userCompany[0]->email;


                                            Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {

                                                $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                                                $msj->subject($subject);
                                                $msj->to($for);
                                                $msj->attachData($pdf->output(), time() . 'Planilla_Verificada.pdf');
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }
            fclose($arch);

        }
    }

    public function verifyPayments()
    {

        $taxes = Taxe::where('status', 'verified')
            ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
        return view('modules.bank.read', ['taxes' => $taxes]);
    }
}
