<?php

namespace App\Http\Controllers;

use App\Imports\PaymentsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use App\Bank;
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
            echo "listo";   
        }

        $this->verifyPayments();
       
    }

    public function verifyPayments(){
        $banks=Bank::all();
        $payments=PaymentTaxes::all();

        foreach ($banks as  $bank){
            $payments=PaymentTaxes::where('code_ref',$bank->ref)->first();
            if(!is_null($payments)){
                $payments_find=PaymentTaxes::find($payments->id);
                $payments->status='verified';
                $payments->save();
            }
        }
    }
}
