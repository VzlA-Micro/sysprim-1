<?php

namespace App\Http\Controllers;

use App\Helpers\Calculate;
use App\Payments;
use App\Taxe;
use Illuminate\Http\Request;
use App\CiuTaxes;
class TicketOfficeController extends Controller{



    public function QrTaxes($id){
        $taxe=Taxe::findOrFail($id);
        $calculateTaxes=Calculate::calculateTaxes($id);
        $ciuTaxes=CiuTaxes::where('taxe_id',$id)->get();
        return view('modules.ticket-office.create',['taxe'=>$taxe,'calculate'=>$calculateTaxes,'ciuTaxes'=>$ciuTaxes]);
    }


    public function registerTaxes(Request $request){
        $id_taxes=$request->input('taxes_id');

        $lot=$request->input('lot');
        $amount=$request->input('amount');
        $ref=$request->input('ref');
        $taxe=Taxe::findOrFail($id_taxes);
        $taxe->status='verified';
        $taxe->update();
        $payments=new Payments();
        $payments->taxe_id=$id_taxes;
        $payments->lot=$lot;
        $payments->amount=$amount;
        $payments->ref=$ref;
        $payments->save();
    }

}
