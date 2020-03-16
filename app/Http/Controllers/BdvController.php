<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Taxe;
use Illuminate\Http\Request;
use App\Helpers\IpgBdv;
use App\Helpers\TaxesNumber;
use App\Helpers\IpgBdvPaymentRequest;
use Carbon\Carbon;
use App\CiuTaxes;
use App\CompanyTaxe;
use App\Vehicle;
use App\Property;
use App\UserProperty;
use App\PropertyTaxes;
use App\Publicity;
use App\UserPublicity;
use App\User;
use Mail;
use App\Company;
use App\PublicityTaxe;
use App\Helpers\TaxesMonth;
use App\Val_cat_const_inmu;
use App\Helpers\Calculate;
class BdvController extends Controller
{


    public function register($id)
    {
        $taxes = Taxe::findOrFail($id);
        return view('modules.bdv.register', ['id' => $id, 'amount' => $taxes->amount]);
    }


    public function store(Request $request)
    {


        $taxes = Taxe::findOrFail($request->input('id'));
        $taxes->bank_name="BANCO VENEZUELA";
        $taxes->update();
        $taxes_id = $request->input('id');
        $Payment = new IpgBdvPaymentRequest();;

        $Payment->idLetter = $request->input('type_document'); //Letra de la cédula - V, E o P
        $Payment->idNumber = $request->input('document'); //Número de cédula

        $number_payments = TaxesNumber::generateNumberPayment('PBP55');
        $Payment->amount = $taxes->amount; //Monto a combrar, DECIMAL
        $Payment->currency = 1; //Moneda del pago, 0 - Bolivar Fuerte, 1 - Dolar
        $Payment->reference = $number_payments; //Código de referecia o factura
        $Payment->title = "IMPUESTOS SEMAT IRIBARREN."; //Titulo para el pago, Ej: Servicio de Cable
        $Payment->description = "PAGO DE " . strtoupper($taxes->branch) . " " . $taxes->created_at->format('d-m-Y'); //Descripción del pago, Ej: Abono mes de marzo 2017
        $Payment->email = $request->input('email');
        $Payment->cellphone = $request->input('country_code') . $request->input('phone');
        $Payment->urlToReturn = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . '/payments/bdv/verified/' . $taxes_id; //URL de retrono al finalizar el pago
        $PaymentProcess = new IpgBdv ("00000000018", "M96wlqhC");//Instanciación de la API de pago con usuario y clave
        $response = $PaymentProcess->createPayment($Payment);


        if ($response->success) // Se procesó correctamente y es necesario redirigir a la página de pago
        {
            if (strtolower(filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest') { //si es ajax
                // echo $response->urlPayment;
                $payments_sysprim = new  Payment();
                $payments_sysprim->code = $number_payments;
                $payments_sysprim->amount = $taxes->amount;
                $payments_sysprim->type_payment = 'BOTON DE PAGO';
                $payments_sysprim->status = 'process';
                $payments_sysprim->bank_name = 'BANCO VENEZUELA';
                $payments_sysprim->description="PAGO DE " . strtoupper($taxes->branch) . " " . $taxes->created_at->format('d-m-Y'); ;
                $payments_sysprim->phone = $request->input('country_code') . $request->input('phone');
                $payments_sysprim->save();
                $paymentsTaxes = $payments_sysprim->taxes()->attach(['taxe_id' => $taxes_id]);

                return response()->json($response);
            } else { //si no es ajax
                header("Location: " . $response->urlPayment); //W
                die();
            }
        } else {
            return response()->json($response);
        }

    }


    public function verifyTaxes($taxes_id){
        $taxe = Taxe::findOrFail($taxes_id);
        $token=$_GET['id'];
        $firm=false;

        $PaymentProcess = new IpgBdv ("00000000018","M96wlqhC");//Instanciación de la API de pago con usuario y clave
        $payments = $PaymentProcess->checkPayment($token);


        if($payments->status&&$payments->success) {
            $firm=true;
            $payments_find=Payment::where('code',$payments->reference)->first();
            $payments_find->status='verified';
            $payments_find->ref=$token;
            $payments_find->update();
            $taxe->status='verified-sysprim';
            $taxe->update();
        }




            $pdf='';

            if ($taxe->branch == 'Act.Eco') {


                if ($taxe->type == 'actuated') {

                    $companyTaxes = CompanyTaxe::where('taxe_id', $taxe->id)->get();
                    $ciuTaxes = CiuTaxes::where('taxe_id', $taxe->id)->get();
                    $fiscal_period = TaxesMonth::convertFiscalPeriod($taxe->fiscal_period);
                    $company = Company::find($companyTaxes[0]->company_id);
                    $taxe->code = TaxesNumber::generateNumberTaxes('PBP81');
                    $taxe->update();
                    $amount = Calculate::calculateTaxes($taxe->id);

                    $pdf = \PDF::loadView('modules.taxes.receipt', [
                            'taxes' => $taxe,
                            'fiscal_period' => $fiscal_period,
                            'ciuTaxes' => $ciuTaxes,
                            'companyTaxes' => $companyTaxes,
                            'amount' => $amount,
                            'firm' => $firm
                    ]);

                    $userCompany = $company->users()->get();
                    $for = $userCompany[0]->email;


                } elseif ($taxe->type == 'definitive') {

                    $taxe->status = 'verified-sysprim';
                    $taxe->code = TaxesNumber::generateNumberTaxes('PBP89');
                    $taxe->update();

                    $ciuTaxes = CiuTaxes::where('taxe_id', $taxe->id)->get();
                    $companyTaxe = $taxe->companies()->get();
                    $company_find = Company::find($companyTaxe[0]->id);
                    $user = $company_find->users()->get();
                    $for = $user[0]->email;


                    $pdf = \PDF::loadView('modules.acteco-definitive.receipt', [
                        'taxes' => $taxe,
                        'ciuTaxes' => $ciuTaxes,
                        'firm' => $firm
                    ]);

                }


                $subject = "PLANILLA VERIFICADA";
                Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {

                    $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                    $msj->subject($subject);
                    $msj->to($for);
                    $msj->attachData($pdf->output(), time() . 'PLANILLA_VERIFICADA.pdf');
                });


                return redirect('payments/history/' . session('company'))->with('message', 'La planilla fue registra y su pago fue procesado  con éxito, fue enviado al correo:' . \Auth::user()->email . '.');

            } elseif ($taxe->branch == 'Pat.Veh') {


                $vehicleTaxes = $taxe->vehicleTaxes()->get();
                $diffYear = Carbon::now()->format('Y') - intval($vehicleTaxes[0]->year);
                $vehicleFind = Vehicle::find($vehicleTaxes[0]->id);
                $user = $vehicleFind->users()->get();
                $taxe->code = TaxesNumber::generateNumberTaxes('PBP85');
                $taxe->update();

                $pdf = \PDF::loadView('modules.ticket-office.vehicle.modules.receipt.receipt', [
                    'taxes' => $taxe,
                    'vehicleTaxes' => $vehicleTaxes,
                    'vehicle' => $vehicleFind,
                    'user' => $user,
                    'diffYear' => $diffYear,
                    'firm' => $firm
                ]);

                $for = $user[0]->email;


                $subject = "PLANILLA VERIFICADA";
                Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {

                    $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                    $msj->subject($subject);
                    $msj->to($for);
                    $msj->attachData($pdf->output(), time() . 'PLANILLA_VERIFICADA.pdf');
                });


                return redirect()->route('vehicle.payments.history', ['id' => $vehicleTaxes[0]->id]);
            } elseif ($taxe->branch == 'Inm.Urbanos') {

                $owner = $taxe->properties()->get();
                $userProperty = UserProperty::where('property_id', $owner[0]->pivot->property_id)->first();
                $property = Property::find($userProperty->property_id);
                $propertyTaxes = $propertyTaxes = PropertyTaxes::where('taxe_id', $taxe->id)->first();
                $propertyBuildings = Val_cat_const_inmu::where('property_id', $property->id)->get();

                if (!is_null($userProperty->company_id)) {
                    $data = Company::find($userProperty->company_id);
                    $type = 'company';
                } else {
                    $data = User::find($userProperty->person_id);
                    $type = 'user';
                }

                $taxe->code = TaxesNumber::generateNumberTaxes('PBP84');
                $taxe->update();


                $pdf = \PDF::loadView('modules.properties-payments.receipt', [
                    'taxes' => $taxe,
                    'data' => $data,
                    'property' => $property,
                    'propertyTaxes' => $propertyTaxes,
                    'type' => $type,
                    'firm' => $firm,
                    'propertyBuildings' => $propertyBuildings
                ]);


                $user = User::find($userProperty->user_id);
                $for = $user->email;

                $subject = "PLANILLA VERIFICADA";
                Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {

                    $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                    $msj->subject($subject);
                    $msj->to($for);
                    $msj->attachData($pdf->output(), time() . 'PLANILLA_VERIFICADA.pdf');
                });
                return redirect('properties/payments/history/'.$property->id)->with('message', 'La planilla fue registrada y su pago fue procesado  con éxito, fue enviado al correo: ' . \Auth::user()->email . '.');

            } elseif ($taxe->branch == 'Tasas y Cert') {
                $rate = $taxe->rateTaxes()->get();
                $type = '';
                if (!is_null($rate[0]->pivot->company_id)) {
                    $data = Company::find($rate[0]->pivot->company_id);
                    $type = 'company';
                } else {
                    $data = User::find($rate[0]->pivot->person_id);
                    $type = 'user';
                }

                $taxe->code = TaxesNumber::generateNumberTaxes('PBP88');
                $taxe->update();
                $pdf = \PDF::loadView('modules.rates.taxpayers.receipt', [
                    'taxes' => $taxe,
                    'data' => $data,
                ]);

                $user = User::find($rate[0]->pivot->user_id);;
                $for = $user->email;

                $subject = "PLANILLA VERIFICADA";
                Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {

                    $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                    $msj->subject($subject);
                    $msj->to($for);
                    $msj->attachData($pdf->output(), time() . 'PLANILLA_VERIFICADA.pdf');
                });

                return redirect('rate/taxpayers/payments-history')->with('message', 'La planilla fue registrada y su pago fue procesado  con éxito, fue enviado al correo: ' . \Auth::user()->email . '.');

            } elseif ($taxe->branch == 'Prop. y Publicidad') {
                $owner = $taxe->publicities()->get();
                $userPublicity = UserPublicity::where('publicity_id', $owner[0]->pivot->publicity_id)->first();

                $publicity = Publicity::find($userPublicity->publicity_id);

                if (!is_null($userPublicity->company_id)) {
                    $data = Company::find($userPublicity->company_id);
                    $type = 'company';
                } else {
                    $data = User::find($userPublicity->person_id);
                    $type = 'user';
                }
                $publicityTaxes = PublicityTaxe::where('taxe_id', $taxe->id)->first();

                $taxe->code = TaxesNumber::generateNumberTaxes('PBP86');
                $taxe->update();

                $pdf = \PDF::loadView('modules.publicity-payments.receipt', [
                    'taxes' => $taxe,
                    'data' => $data,
                    'publicity' => $publicity,
                    'publicityTaxes' => $publicityTaxes,
                    'type' => $type,
                    'firm' => $firm
                ]);


                $user = User::find($userPublicity->user_id);
                $for = $user->email;


                $subject = "PLANILLA VERIFICADA";
                Mail::send('mails.payment-verification', [], function ($msj) use ($subject, $for, $pdf) {

                    $msj->from("grabieldiaz63@gmail.com", "SEMAT");
                    $msj->subject($subject);
                    $msj->to($for);
                    $msj->attachData($pdf->output(), time() . 'PLANILLA_VERIFICADA.pdf');
                });

                return redirect('publicity/payments/history/'.$publicity->id)->with('message', 'La planilla fue registrada y su pago fue procesado  con éxito, fue enviado al correo: ' . \Auth::user()->email . '.');

            }

    }









}
