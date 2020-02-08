<?php

namespace App\Http\Controllers;

use App\Imports\PaymentsImport;
use App\Payment;
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
use App\CiuTaxes;
use App\CompanyTaxe;
use App\Vehicle;
use App\Property;
use App\UserProperty;
use App\PropertyTaxes;

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
        $date_limit = $request->input('date_limit');

        $verify_taxes=0;
        $verify_total=0;
        $verify_payment=0;




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
                } elseif ($codeBank == '00116' && $band == false) {
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

                } elseif(!$band) {

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


                    $taxes = Taxe::whereDate('created_at', '=', $date_limit)->get();

                    foreach ($taxes as $taxe) {
                        $code = substr($taxe->code, 3, 10);



                        //&& $amountThere == $taxe->amount
                        if ($document == $code && $taxe->status == 'process') {


                            $pCode = substr($taxe->code, 0, 3);

                           // $taxes_find=Taxe::find($taxe->id);




                            if ($pCode == 'PPC') {


                            } else {

                                if ($pCode == 'PPT' || $pCode == 'PPE') {




                                    if ($taxe->branch == 'Act.Eco') {



                                        if($taxe->type=='actuated'){

                                            $companyTaxes = CompanyTaxe::where('taxe_id',  $taxe->id)->get();

                                            $ciuTaxes = CiuTaxes::where('taxe_id', $taxe->id)->get();
                                            $fiscal_period = TaxesMonth::convertFiscalPeriod($taxe->fiscal_period);
                                            $company = Company::find($companyTaxes[0]->company_id);
                                            $userCompany = $company->users()->get();
                                            $taxe->status = 'verified-sysprim';
                                            $taxe->update();


                                            foreach ($ciuTaxes as $ciu) {

                                                $pdf = \PDF::loadView('modules.taxes.receipt', [
                                                    'taxes' => $taxe,
                                                    'fiscal_period' => $fiscal_period,
                                                    'ciuTaxes' => $ciuTaxes,
                                                    'companyTaxes' => $companyTaxes,
                                                    'firm' => true
                                                ]);

                                                $userCompany = $company->users()->get();
                                                $for = $userCompany[0]->email;
                                            }

                                        }elseif($taxe->type=='definitive'){

                                            $taxe->status = 'verified-sysprim';
                                            $taxe->update();

                                            $ciuTaxes = CiuTaxes::where('taxe_id', $taxe->id)->get();
                                            $companyTaxe = $taxe->companies()->get();
                                            $company_find = Company::find($companyTaxe[0]->id);
                                            $user = $company_find->users()->get();
                                            $for = $user[0]->email;


                                            $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
                                                'taxes' => $taxe,
                                                'ciuTaxes' => $ciuTaxes,
                                                'firm' => true
                                            ]);

                                        }


                                    }elseif($taxe->branch == 'Pat.Veh'){


                                        $vehicleTaxes=$taxe->vehicleTaxes()->get();
                                        $diffYear = Carbon::now()->format('Y') - intval($vehicleTaxes[0]->year);
                                        $vehicleFind=Vehicle::find($vehicleTaxes[0]->id);
                                        $user = $vehicleFind->users()->get();

                                        $taxe->status = 'verified-sysprim';
                                        $taxe->update();

                                        $pdf = \PDF::loadView('modules.ticket-office.vehicle.modules.receipt.receipt', [
                                            'taxes' => $taxe,
                                            'vehicleTaxes'=>$vehicleTaxes,
                                            'vehicle'=>$vehicleFind,
                                            'user'=>$user,
                                            'diffYear'=>$diffYear,
                                            'firm' => true
                                        ]);

                                        $for=$user[0]->email;
                                    }elseif($taxe->branch=='Inm.Urbanos'){

                                        $owner = $taxe->properties()->get();
                                        $userProperty = UserProperty::where('property_id',$owner[0]->pivot->property_id)->first();
                                        $property = Property::find($userProperty->property_id);
                                        $propertyTaxes =   $propertyTaxes = PropertyTaxes::where('taxe_id',$taxes->id)->first();


                                        if (!is_null($userProperty->company_id)) {
                                            $data = Company::find($userProperty->company_id);
                                            $type = 'company';
                                        } else {
                                            $data = User::find($userProperty->person_id);
                                            $type = 'user';
                                        }

                                        $taxe->status = 'verified-sysprim';
                                        $taxe->update();


                                        $pdf = \PDF::loadView('modules.properties-payments.receipt', [
                                            'taxes' => $taxe,
                                            'data' => $data,
                                            'property' => $property,
                                            'propertyTaxes' => $propertyTaxes,
                                            'firm'=>true
                                        ]);


                                        $user=User::find($userProperty->user_id);
                                        $for=$user->email;



                                    }elseif($taxe->branch=='Tasas y Cert'){
                                        $rate=$taxe->rateTaxes()->get();
                                        $type='';
                                        if(!is_null($rate[0]->pivot->company_id)){
                                            $data=Company::find($rate[0]->pivot->company_id);
                                            $type='company';
                                        }else{
                                            $data=User::find($rate[0]->pivot->person_id);
                                            $type='user';
                                        }

                                        $taxe->status = 'verified-sysprim';
                                        $taxe->update();
                                        $pdf = \PDF::loadView('modules.rates.taxpayers.receipt', [
                                            'taxes' => $taxe,
                                            'data' => $data,
                                        ]);

                                        $user=User::find($rate[0]->pivot->user_id);;
                                        $for=$user->email;
                                        $band=true;
                                    }

                                        //Enviando Planilla verificada.
                                        $subject = "PLANILLA VERIFICADA";
                                        Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {

                                            $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                                            $msj->subject($subject);
                                            $msj->to($for);
                                            $msj->attachData($pdf->output(), time() . 'PLANILLA_VERIFICADA.pdf');
                                        });


                                        $verify_taxes++;
                                }
                            }
                        }else{
                             $verify_payment=$this->verifyPaymentsTaxes($document,$date_limit);
                        }
                    }
                }
            }
            fclose($arch);
            $verify_total=$verify_taxes+$verify_payment;
            return redirect('bank/verified-today')->with(['message'=>'Verificación realizada con éxito, fueron verificado un total de:'.$verify_total.' planillas.']);
        }
    }

    public function verifyPayments()
    {
        $taxes = Taxe::where('status', 'verified-sysprim')
            ->whereDate('updated_at', '=', Carbon::now()->format('Y-m-d'))->get();
        return view('modules.bank.read', ['taxes' => $taxes]);
    }



    public function verifyPaymentsTaxes($code,$date_limit,$amount_total=null){

        $payments=Payment::whereDate('created_at','=',$date_limit)->get();

        $verify=0;

        if(!$payments->isEmpty()) {
            foreach ($payments as $payment) {

                $code_payment = substr($payment->code, 3, 10);


                if($code_payment===$code){
                    $payment->status='verified';
                    $payment->update();

                    foreach ($payment->taxes as $tax) {
                        $band=false;


                        $type_payment = substr($tax->code, 0, 3);

                        if ($type_payment == 'PPT' || $type_payment == 'PPE') {


                            if ($tax->branch === 'Act.Eco' && $tax->status == 'process') {

                                if ($tax->type == 'actuated') {

                                    $companyTaxes = CompanyTaxe::where('taxe_id', $tax->id)->get();

                                    $ciuTaxes = CiuTaxes::where('taxe_id', $tax->id)->get();
                                    $fiscal_period = TaxesMonth::convertFiscalPeriod($tax->fiscal_period);
                                    $company = Company::find($companyTaxes[0]->company_id);
                                    $userCompany = $company->users()->get();
                                    $tax->status = 'verified-sysprim';
                                    $tax->update();

                                    $pdf = \PDF::loadView('modules.taxes.receipt', [
                                        'taxes' => $tax,
                                        'fiscal_period' => $fiscal_period,
                                        'ciuTaxes' => $ciuTaxes,
                                        'companyTaxes' => $companyTaxes,
                                        'firm' => true
                                    ]);

                                    $userCompany = $company->users()->get();
                                    $for = $userCompany[0]->email;

                                    $band = true;
                                } elseif ($tax->type == 'definitive') {

                                    $tax->status = 'verified-sysprim';
                                    $tax->update();

                                    $ciuTaxes = CiuTaxes::where('taxe_id', $tax->id)->get();
                                    $companyTaxe = $tax->companies()->get();
                                    $company_find = Company::find($companyTaxe[0]->id);
                                    $user = $company_find->users()->get();
                                    $for = $user[0]->email;


                                    $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
                                        'taxes' => $tax,
                                        'ciuTaxes' => $ciuTaxes,
                                        'firm' => true
                                    ]);

                                }
                                $band = true;

                            } elseif ($tax->branch === 'Pat.Veh' && $tax->status == 'process') {


                                $vehicleTaxes = $tax->vehicleTaxes()->get();
                                $diffYear = Carbon::now()->format('Y') - intval($vehicleTaxes[0]->year);
                                $vehicleFind = Vehicle::find($vehicleTaxes[0]->id);
                                $user = $vehicleFind->users()->get();

                                $tax->status = 'verified-sysprim';
                                $tax->update();

                                $pdf = \PDF::loadView('modules.ticket-office.vehicle.modules.receipt.receipt', [
                                    'taxes' => $tax,
                                    'vehicleTaxes' => $vehicleTaxes,
                                    'vehicle' => $vehicleFind,
                                    'user' => $user,
                                    'diffYear' => $diffYear,
                                    'firm' => true
                                ]);

                                $for = $user[0]->email;

                                $band = true;
                            } elseif ($tax->branch === 'Inm.Urbanos' && $tax->status == 'process') {

                                $owner = $tax->properties()->get();
                                $userProperty = UserProperty::where('property_id',$owner[0]->pivot->property_id)->first();
                                $property = Property::find($userProperty->property_id);
                                $propertyTaxes = PropertyTaxes::where('taxe_id',$tax->id)->first();


                                if (!is_null($userProperty->company_id)) {
                                    $data = Company::find($userProperty->company_id);
                                    $type = 'company';
                                } else {
                                    $data = User::find($userProperty->person_id);
                                    $type = 'user';
                                }

                                $tax->status = 'verified-sysprim';
                                $tax->update();


                                $pdf = \PDF::loadView('modules.properties-payments.receipt', [
                                    'taxes' => $tax,
                                    'data' => $data,
                                    'property' => $property,
                                    'propertyTaxes' => $propertyTaxes,
                                    'firm' => true
                                ]);

                                $band = true;
                                $user = User::find($userProperty->user_id);
                                $for = $user->email;


                            } elseif ($tax->branch == 'Tasas y Cert' && $tax->status == 'process') {
                                $rate = $tax->rateTaxes()->get();
                                $type = '';
                                if (!is_null($rate[0]->pivot->company_id)) {
                                    $data = Company::find($rate[0]->pivot->company_id);
                                    $type = 'company';
                                } else {
                                    $data = User::find($rate[0]->pivot->person_id);
                                    $type = 'user';
                                }

                                $tax->status = 'verified-sysprim';
                                $tax->update();
                                $pdf = \PDF::loadView('modules.rates.taxpayers.receipt', [
                                    'taxes' => $tax,
                                    'data' => $data,
                                ]);

                                $user = User::find($rate[0]->pivot->user_id);;
                                $for = $user->email;
                                $band = true;
                            }


                            if ($band) {
                                //Enviando Planilla verificada.
                                $subject = "PLANILLA VERIFICADA";
                                Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {

                                    $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                                    $msj->subject($subject);
                                    $msj->to($for);
                                    $msj->attachData($pdf->output(), time() . 'PLANILLA_VERIFICADA.pdf');
                                });

                                $verify++;
                            }


                        }
                    }


                }



            }



        }
        return $verify;
    }
    public function readPaymentsVerify(){
        $taxes=Taxe::where('status','verified-sysprim')->get();
        return view('modules.bank.read-verify', ['taxes' => $taxes]);
    }









}
