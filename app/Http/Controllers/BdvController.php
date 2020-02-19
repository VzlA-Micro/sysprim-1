<?php

namespace App\Http\Controllers;

use App\Taxe;
use Illuminate\Http\Request;
use App\Helpers\IpgBdv;
use App\Helpers\TaxesNumber;
use App\Helpers\IpgBdvPaymentRequest;


class BdvController extends Controller
{



    public function register($id){
        $taxes=Taxe::findOrFail($id);
        return view('modules.bdv.register',['id'=>$id,'amount'=>$taxes->amount]);
    }




    public function  store(Request $request ){

        $taxes=Taxe::findOrFail($request->input('id'));
        $Payment = new IpgBdvPaymentRequest();

        $Payment->idLetter= $request->input('type_document') ; //Letra de la cédula - V, E o P
        $Payment->idNumber= $request->input('email'); //Número de cédula

        $amount_format = str_replace('.', '',$request->input('amount') );
        $amount_format = str_replace(',', '.', $amount_format);


        $Payment->amount=1 ; //Monto a combrar, DECIMAL
        $Payment->currency= 1; //Moneda del pago, 0 - Bolivar Fuerte, 1 - Dolar
        $Payment->reference= TaxesNumber::generateNumberPayment('PBV'); //Código de referecia o factura
        $Payment->title= "IMPUESTOS SEMAT IRIBARREN."; //Titulo para el pago, Ej: Servicio de Cable
        $Payment->description= "PAGO DE ".strtoupper($taxes->branch)." ".$taxes->created_at->format('d-m-Y') ; //Descripción del pago, Ej: Abono mes de marzo 2017
        $Payment->email=$request->input('email');
        $Payment->cellphone= $request->input('country_code').$request->input('phone');


        $Payment->urlToReturn= $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/ipgbdv/success.php?token={ID}'; //URL de retrono al finalizar el pago


        $PaymentProcess = new IpgBdv ("73247489","aj6lEoN6");//Instanciación de la API de pago con usuario y clave
        $response = $PaymentProcess->createPayment($Payment);


        var_dump($response);
        die();
    if ($response->success) // Se procesó correctamente y es necesario redirigir a la página de pago
	{
		if (strtolower(filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest') { //si es ajax
			// echo $response->urlPayment;
			return response()->json($response);
		}
		else{ //si no es ajax
			header("Location: ".$response->urlPayment); //W
			die();
		}
	}else{
        return response()->json($response);
	}



    }





}
