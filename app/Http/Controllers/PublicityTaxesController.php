<?php

namespace App\Http\Controllers;

use App\Helpers\DeclarationPublicity;
use App\UserPublicity;
use Illuminate\Http\Request;
use App\Publicity;
use App\PublicityTaxe; 
use App\AdvertisingType;
use Carbon\Carbon;
use App\Tributo;


class PublicityTaxesController extends Controller
{
    public function index($id)
    {
        $publicity = Publicity::find($id);
        return view('modules.publicity-payments.manage', ['publicity' => $publicity]);
    }

    public function create($id) {
        $period_fiscal = Carbon::now()->year; // Año del periodo fiscal
        $actualDate = Carbon::now(); // Fecha actual

        $advertisingTypes = AdvertisingType::all();
        $publicity = Publicity::find($id);
        $declaration = DeclarationPublicity::Declarate($id);
        $userPublicity = UserPublicity::where('publicity_id',$id)->get();
        $base = $declaration['baseImponible'];
        $taxes = $publicity->publicityTaxes()->where('branch','Prop. y Publicidad')->whereYear('fiscal_period','=',$actualDate->format('Y'))->get();
        if(!empty($taxes)) {
            foreach ($taxes as $tax) {
                if($tax->status === 'verified'||$tax->status==='verified-sysprim'){
                    $statusTax = 'verified';
                }else if($tax->status === 'temporal'){
//                $tax->delete();
                    $statusTax = 'new';
                }else if($tax->status === 'ticket-office' && $tax->created_at->format('d-m-Y') === $actualDate->format('d-m-Y') ){
                    $statusTax = 'process';
                } else if($tax->status === 'process' && $tax->created_at->format('d-m-Y') === $actualDate->format('d-m-Y')){
                    $statusTax = 'process';
                }else{
                    $statusTax = 'new';
                }
            }
        }
        else {
            $statusTax = 'new';
        }
        /*if($userProperty[0]->company_id != null) {
            $owner_id = $userProperty[0]->company_id;
            $owner_type = 'company';
            $owner = Company::find($owner_id);
        }
        elseif($userProperty[0]->person_id != null) {
            $owner_id = $userProperty[0]->person_id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        }
        else{
            $owner_id = \Auth::user()->id;
            $owner_type = 'user';
            $owner = User::find($owner_id);
        }*/
        $baseImponible = number_format($declaration['baseImponible'],2,',','.');
        $interest = number_format($declaration['interest'],2,',','.');
        $total = number_format($declaration['total'],2,',','.');



//        dd($baseImponible);
    	return view('modules.publicity-payments.register', [
    		'advertisingTypes' => $advertisingTypes,
    		'publicity' => $publicity,
            'base' => $base,
            'baseImponible' => $baseImponible,
            'interest' => $interest,
            'total' => $total
//            'interest' => $interest
//            'total' => $total
    	]);
    }
}
