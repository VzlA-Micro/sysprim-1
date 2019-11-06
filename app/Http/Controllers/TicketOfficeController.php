<?php

namespace App\Http\Controllers;

use App\Helpers\Calculate;
use App\Payments;
use App\Taxe;
use Illuminate\Http\Request;
use App\CiuTaxes;
use App\Parish;
use App\Company;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class TicketOfficeController extends Controller{



    public function QrTaxes($id){
        $id=Crypt::decrypt($id);
        $taxe=Taxe::with('companies')->where('id',$id)->get();
        $calculateTaxes=Calculate::calculateTaxes($id);
        $ciuTaxes=CiuTaxes::with('ciu')->where('taxe_id',$id)->get();
        return response()->json(['taxe'=>$taxe,'calculate'=>$calculateTaxes,'ciu'=>$ciuTaxes]);
    }

    public function cashier(){
        return view('modules.ticket-office.create');
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


    //comapanies
    public function registerCompany(){
        $parish=Parish::all();
        return view('modules.ticket-office.companies.register',['parish'=>$parish]);
    }


    public function storeCompany(Request $request){
        $ciu = $request->input('ciu');
        $nameCompany = $request->input('name_company');
        $license = $request->input('license');
        $parish = $request->input('parish');
        $openingDate = $request->input('opening_date');
        $rif = $request->input('document_type').$request->input('RIF');
        $address = $request->input('address');
        $code_catastral = $request->input('code_catastral');
        $numberEmployees=$request->input('number_employees');
        $sector=$request->input('sector');
        $phone=$request->input('phone_company');
        $country_code= $request->input('country_code_company');
        $lat=$request->input('lat');
        $lng=$request->input('lng');


        $validate = $this->validate($request, [
            'name_company' => 'required',
            'license' => 'required',
            'RIF' => 'required|min:8',
            'address' => 'required',
            'opening_date' => 'required',
            'parish' => 'required|integer',
            'code_catastral' => 'required',
            'sector' => 'required',
            'number_employees' => 'required',
        ]);

        $company = new Company();
        $company->name = strtoupper($nameCompany);
        $company->address = strtoupper($address);
        $company->rif = $rif;
        $company->license = strtoupper($license);
        $company->lat = $lat;
        $company->lng = $lng;
        $company->code_catastral = strtoupper($code_catastral);
        $company->parish_id = $parish;
        $company->opening_date = $openingDate;
        $company->sector = $sector;
        $company->number_employees = $numberEmployees;
        $company->phone =  $country_code.$phone;
        $company->created_at='2019-09-14';
        $company->save();



        $id_company = DB::getPdo()->lastInsertId();



        $nacionality=$request->input('nationality');
        $ci= $request->input('ci');
        $nameUser= $request->input('name_user');
        $surname= $request->input('surname');
        $phone= $request->input('phone_user');
        $country_code= $request->input('country_code_user');
        $email= $request->input('email');
        $password=Hash::make($nacionality.$ci);

        $user=new User();
        $user->ci=$nacionality.$ci;
        $user->name=$nameUser;
        $user->surname=$surname;
        $user->phone=$country_code.$phone;
        $user->confirmed=1;
        $user->role_id=3;
        $user->email=$email;
        $user->password=$password;
        $user->save();
        $id_user = DB::getPdo()->lastInsertId();

        $company->users()->attach(['company_id' => $id_company], ['user_id' => $id_user]);
        foreach ($ciu as $ciu) {
            $company->ciu()->attach(['company_id' => $id_company], ['ciu_id' => $ciu]);
        }



    }


    public function allCompanies(){
       $companies=Company::all();
        return view('modules.ticket-office.companies.read',['companies'=>$companies]);
    }



    public function detailsCompany($id){
        $company=Company::find($id);
        $parish=Parish::all();
        return view('modules.ticket-office.companies.details',['company'=>$company,'parish'=>$parish]);
    }



}
