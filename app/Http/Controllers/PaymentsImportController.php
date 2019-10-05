<?php

namespace App\Http\Controllers;

use App\Imports\PaymentsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use Mail;
use App\Bank;
use App\Taxe;
use App\Company;
use App\Http\Controllers\Controller;
use App\PaymentTaxes;

class PaymentsImportController extends Controller
{


    public function importFile(Request $request){
        
        $file=$request->file;
        $Archivo=\File::get($file);
        $mime = $file->getMimeType();

        $dat=explode(";",$Archivo);
        $count=count($dat);
  
       if ($mime =="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
        Excel::import(new PaymentsImport, request()->file('file'));
       }

        if ($mime == "text/plain") {
            for($i=0; $i<$count;$i++){
                if ($i > 1) {
                    $referenceBank = new Bank();
                    $referenceBank->ref = $dat[$i];
                    $i++;
                    $referenceBank->bank=$dat[$i];
                    $referenceBank->save();
                }
            } 
               
        }

        $this->verifyPayments();
       
    }

    public function verifyPayments(){
        $banks=Bank::all();
        $payments=PaymentTaxes::all();
        //$banco=Bank::where('ref',$payments[0]->code_ref)->get();
        /*foreach($payments as $payment){
        $taxes=Taxe::where('id',$payment->taxe_id)->get();
        $company=Company::find($taxes[0]->company_id);
        $uCompa=$company->users()->get();
        var_dump($uCompa[0]->email);
        }
        */
        foreach ($banks as  $bank){
            $payments=PaymentTaxes::where('code_ref',$bank->ref)->first();
           
            if(!is_null($payments)){
                $payments_find=PaymentTaxes::find($payments->id);
                $bank_find=Bank::find($bank->id);
                $payments->status='verified';
                $payments->save();
               
                $taxes=Taxe::where('id',$payments->taxe_id)->get();
                $company=Company::find($taxes[0]->company_id);
                $uCompa=$company->users()->get();
                
                $subject = "RECIBO DE SOLVENCIA";
                $for =$uCompa[0]->email;
                Mail::send('dev.pago',[], function($msj) use($subject,$for){
                $msj->from("grabieldiaz63@gmail.com","Equipo de Sysprim");
                $msj->subject($subject);
                $msj->to($for);
                });

                $bank_find->delete();
               
            }

           /* $subject = "Asunto del correo";
        $for = "correo_que_recibira_el_mensaje@gmail.com";
        Mail::send('email',$request->all(), function($msj) use($subject,$for){
            $msj->from("tucorreo@gmail.com","NombreQueApareceráComoEmisor");
            $msj->subject($subject);
            $msj->to($for);
        });
        return redirect()->back();*/
        }
    }
}
