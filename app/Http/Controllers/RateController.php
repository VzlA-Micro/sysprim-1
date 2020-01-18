<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Rate;
use App\User;
use App\Helpers\CedulaVE;
use App\Taxe;
use App\Helpers\TaxesNumber;
use App\Tributo;
class RateController extends Controller{



    /*Module*/

    public function index() {
        $rate = Rate::all();
        return view('modules.rates.module.read', ['rate' => $rate]);
    }

    public function verifyCode($code,$id=null){
        $rate=Rate::where('code', $code)->get();

        if(is_null($id)) {
            $rate=Rate::where('code', $code)->get();
        }else{
            $rate=Rate::where('code', $code)->where('id','!=',$id)->get();
        }
        if(!$rate->isEmpty()){
            $response=array('status'=>'error','message'=>'El código "'.$code.'" se encuentra registrado en el sistema. Por favor, ingrese un código valido.');
        }else{
            $response=array('status'=>'success','message'=>'No registrado.');
        }
        return response()->json($response);
    }


    //manager de module
    public function manager(){
        return view('modules.rates.module.manage');
    }


    //view register
    public function create() {
        return view('modules.rates.module.register');
    }


    //save
    public function store(Request $request) {
        $rate = new Rate();
        $rate->code = strtoupper($request->input('code'));
        $rate->name = strtoupper($request->input('name'));
        $rate->type = $request->input('type');
        $rate->cant_tax_unit = $request->input('cant_tax_unit');
        $rate->status = $request->input('status');
        $rate->save();
        return response()->json(['status'=>'success','message'=>'La tasa se ha registrado con éxito.']);
    }



    public function details($id) {
        $rate = Rate::find($id);
        return view('modules.rates.module.details', ['rate' => $rate]);

    }

    public function update(Request $request) {
        $id = $request->input('id');
        $rate = Rate::find($id);
        $rate->code = $request->input('code');
        $rate->name = $request->input('name');
        $rate->type = $request->input('type');
        $rate->cant_tax_unit = $request->input('cant_tax_unit');
        $rate->status = $request->input('status');
        $rate->update();
        return response()->json(['status'=>'success','message'=>'La tasa se ha actualiza con éxito.']);
    }

    public function destroy($id) {
        $rate = Rate::find($id);
        $rate->delete();
        return response()->json(['status'=>'success','message'=>'La tasa se ha eliminado con éxito.']);
    }

    /* taxpayers*/
    public function menuTaxPayers(){
        return view('modules.rates.taxpayers.menu');
    }

    public function  registerTaxPayers(){
        $rate = Rate::all();
        return view('modules.rates.taxpayers.register',['rates'=>$rate]);
    }


    //Buscar empresa o usuario;
    public function findTaxPayers($type_document,$document){
        if($type_document=='V'||$type_document=='E'){
            $user=User::where('ci', $type_document.$document)->get();
            if($user->isEmpty()){
                $user=CedulaVE::get($type_document,$document,false);

                $data=['status'=>'success','type'=>'not-user','user'=>$user];

            }else{
                $data=['status'=>'success','type'=>'user','user'=>$user[0]];
            }
        }else{
            $company=Company::where('RIF', $type_document.$document)->get();

            if($company->isEmpty()){
                $data=['status'=>'success','type'=>'not-company','company'=>null];
            }else{
                $data=['status'=>'success','type'=>'company','company'=>$company[0]];
            }

        }
        return response()->json($data);
    }




    public function registerCompanyUsers(Request $request){
        $type=$request->input('type');
        $name=$request->input('name');
        $surname=$request->input('surname');
        $type_document=$request->input('type_document');
        $document=$request->input('document');
        $address=$request->input('address');

        if($type=='user'){
            $user=new User();
            $user->name=$name;
            $user->surname=$surname;
            $user->ci=$type_document.$document;
            $user->status_account='waiting';
            $user->address=$address;
            $user->role_id=3;
            $user->save();
            $id=$user->id;
        }else{
            $company=new Company();
            $company->name=$name;
            $company->RIF=$type_document.$document;
            $company->status='waiting';
            $company->address=$address;
            $company->save();
            $id=$company->id;
        }

        return response(['status'=>'success','id'=>$id,'type'=>$type]);

    }


    public function saveTaxPayers(Request $request){
        $type=$request->input('type');
        $id=$request->input('id');
        $rate_id=$request->input('rate_id');

        $person_id=null;
        $company_id=null;

        if($type=='user'){
            $person_id=$id;
        }else{
            $company_id=$id;
        }



        $taxe = new Taxe();
        $taxe->code = TaxesNumber::generateNumberTaxes('TEM');
        $taxe->status='temporal';
        $taxe->type='daily';
        $taxe->fiscal_period=date('Y-m-d');
        $taxe->branch='TasasyCert';
        $taxe->save();
        $id = $taxe->id;

        $tributo=Tributo::orderBy('id','desc')->first();


        for ($i=0;$i<count($rate_id);$i++){
            $rate=Rate::find($rate_id[$i]);
            $taxe->rateTaxes()->attach(['taxe_id'=>$id],
                [    'rate_id'=>$rate_id[$i],
                    'company_id'=>$company_id,
                    'person_id'=>$person_id,
                    'user_id'=>\Auth::user()->id,
                    'cant_tax_unit'=>$rate->cant_tax_unit,
                    'tax_unit'=>$tributo->value,
                ]);
        }




        return response()->json(['status'=>'success','taxe_id'=>$id]);
    }









}
