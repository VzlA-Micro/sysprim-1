<?php

namespace App\Http\Controllers;

use App\CompanyBranch;
use App\CompanyRespaldo;
use App\GroupCiu;
use App\Helpers\CedulaVE;
use App\Helpers\TaxesNumber;
use App\Notification;
use App\Parish;
use App\User;
use Carbon\Carbon;
use function Complex\ln;
use Illuminate\Http\Request;
use App\Company;
use App\Ciu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\UserCompany;
use App\Payments;
use App\FindCompany;
use App\CiuCompany;
use Alert;
use Illuminate\Support\Facades\Mail;
class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $companies=UserCompany::where('user_id',\Auth::user()->id)->select('company_id')->get();
        $companies_find=Company::whereIn('id',$companies)->get();
        return view('modules.companies.menu',['companies'=>$companies_find]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(){
        $ciu=GroupCiu::all();
        $parish=Parish::all();
        return view('modules.companies.register',['ciu'=>$ciu,'parish'=>$parish]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $ciu = $request->input('ciu');
        $image = $request->file('image');
        $name = $request->input('name');
        $license = $request->input('license');
        $parish = $request->input('parish');
        $country_code = $request->input('country_code');
        $rif = $request->input('document_type').$request->input('RIF');
        $address = $request->input('address');
        $code_catastral = $request->input('code_catastral');
        $numberEmployees=$request->input('number_employees');
        $sector=$request->input('sector');
        $phone=$request->input('phone');
        $lat=$request->input('lat');
        $lng=$request->input('lng');



        $validate = $this->validate($request, [
            'name' => 'required',
            'RIF' => 'required|min:8',
            'address' => 'required',
            'parish' => 'required|integer',
            'sector' => 'required',
            'number_employees' => 'required',
            ]);

        $company = new Company();

        if ($image) {
            $image_path_name = time() . $image->getClientOriginalName();
            Storage::disk('companies')->put($image_path_name, File::get($image));
            $company->image = $image_path_name;
        } else {
            $company->image = null;
        }


        if(!$license){
            $license=TaxesNumber::generateNumberLicense();
        }

        $company->name = strtoupper($name);
        $company->address = strtoupper($address);
        $company->rif = $rif;
        $company->license = strtoupper($license);
        $company->lat = $lat;
        $company->lng = $lng;
        $company->code_catastral = strtoupper($code_catastral);
        $company->parish_id = $parish;
        $company->sector = $sector;
        $company->number_employees = $numberEmployees;
        $company->phone = $country_code.$phone;
        $company->save();
        $id = $company->id;

        $company->users()->attach(['company_id' => $id], ['user_id' => \Auth::user()->id]);

        if($ciu) {
            foreach ($ciu as $ciu) {
                $company->ciu()->attach(['company_id' => $id], ['ciu_id' => $ciu]);
            }
        }

        $company_rif=Company::where('RIF','=',$rif)->orderBy('id','asc')->take(1)->get();

        if(!$company_rif->isEmpty()){
            $company_id=$company_rif[0]->id;
            $companyBranch= new CompanyBranch();
            $companyBranch->company_id=$company_id;
            $companyBranch->branch_id=$id;
            $companyBranch->save();
        }



        $subject = "REGISTRO ÉXITOSO-SEMAT";
        $for = \Auth::user()->email;

        Mail::send('mails.company', ['id'=>$id], function ($msj) use ($subject, $for) {
            $msj->from("semat.alcaldia.iribarren@gmail.com", "SEMAT");
            $msj->subject($subject);
            $msj->to($for);
        });

        return response()->json(['status'=>'success','message'=>"Empresa registrada con éxito"]);
    }

    public function getImage($filename){
        $file=Storage::disk('companies')->get($filename);
        return new Response($file,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $company=Company::findOrFail($id);

    }






    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $company = Company::findOrFail($id);
        $ciu = Ciu::all();
        $parish=Parish::all();

        return view('modules.companies.edit',['ciu' => $ciu, 'company' => $company,'parish'=>$parish]);
    }

    public function update(Request $request){
        /*Falta:eliminar imagenes antigua una vez suba la nueva*/

        $ciu=$request->input('ciu');
        $parish=$request->input('parish');
        $rif=$request->input('rif');
        $name=$request->input('name');
        $address=$request->input('address');
        $code_catastral=$request->input('codeCadastral');
        $numberEmployees=$request->input('numberEmployees');
        $sector=$request->input('sector');
        $openig_date=$request->input('opening_date');
        $phone=$request->input('phone');
        $country_code=$request->input('countryCodeCompany');
        $license=$request->input('license');
        $id=$request->input('id');
        //$lat=$request->input('lat');
        //$lng=$request->input('lng');
        $image=$request->input('image');
        $company=Company::find($id);
        if($image){
            $image_path_name=time().$image->getClientOriginalName();
            Storage::disk('companies')->delete($company->image);
            $company->image=$image_path_name;
        }else{
            $company->image=null;
        }
        $company->address=strtoupper($address);
        //$company->lat=$lat;
        //$company->lng=$lng;
        $company->code_catastral=strtoupper($code_catastral);
        $company->parish_id=$parish;
        $company->sector = $sector;
        $company->RIF = $rif;
        $company->name = $name;
        $company->phone=$country_code.$phone;
        $company->number_employees = $numberEmployees;
        $company->license = $license;
        $company->opening_date=$openig_date;
        $company->update();
        //$company->ciu()->sync($ciu);
        $response=true;

        return response()->json($response);

    }

    public function details($id) {
        $company = Company::find($id);
        return view('modules.companies.details',['company' => $company]);
    }

    public function verifyTaxes($id){
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $date = null;
        $company = Company::find($id);


        $companyTaxes = $company->taxesCompanies()->orderByDesc('id')->take(1)->get();//busco el ultimo pago realizado por la empresa

        if ($companyTaxes->isEmpty()) {//si no tiene pagos


            $fiscal_period = Carbon::parse($company->created_at);//utilizo la fecha que se creo el registro como referencia si esta atrasado o no
            $now = Carbon::now();//fecha del computador
            $diffMount = $fiscal_period->diffInMonths($now);//veo la diferencia de meses
            if($diffMount>=1){
                $date = array('mount_pay' => $fiscal_period->format('F'), 'mount_diff' => $diffMount);
            }else{
                $date=null;
            }


        } else {//si tiene datos

            $fiscal_period = Carbon::parse($companyTaxes[0]->fiscal_period);//utilizo el ultimo pago realido valido y lo tomo como refencia
            $now = Carbon::now();//fecha del computador
            $diffMount = $fiscal_period->diffInMonths($now);
            $payment = Payments::where('taxe_id', $companyTaxes[0]->id)->get();//busco si el pago fue realizo

            if ($diffMount >= 1 || $payment->isEmpty()) {
                if (!$payment->isEmpty() && $payment[0]->status === 'verified' && $diffMount > 1) {
                    $diffMount--;//resto 1 a la diferencia de mes porque este utilimo esta pago
                    $fiscal_period->addMonth(1);//añado un mes para saber cual es el proximo a pagar
                    $date = array('mount_pay' => $fiscal_period->format('F'), 'mount_diff' => $diffMount);
                } else if (!$payment->isEmpty() && $payment[0]->status === 'verified') {//si no esta vacio y el pago esta verificado,y no hay diferencia de mes, esta al dia.
                    $date = null;
                } else {
                    $date = array('mount_pay' => $fiscal_period->format('F'),
                        'mount_diff' => $diffMount);
                }
            }

        }

        $this->createNotification($company->name, $fiscal_period->format('F'), $diffMount, $date);
        return $date;

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){


    }

    public function createNotification($name,$mes,$diffMount,$data){
        $notifications=Notification::where('type_notification','date-'.$mes)->where('title',$name)->get();
            if($data!=null&&($notifications->isEmpty()||$notifications[0]->title!=$name)){
                $notification=new Notification();
                $notification->type_notification='date-'.$mes;
                $notification->title=$name;
                $notification->content="Estimado empresario, esta atrasado en sus pago por ". $diffMount ." meses,por favor cancele el mes de ".$mes;
                $notification->view=0;
                $notification->user_id=\Auth::user()->id;
                $notification->save();
            }

    }


    public function changeStatus($id,$status){

        $company=Company::find($id);
        $company->status=$status;
        $company->update();
        return response()->json(['status'=>$status]);
    }

    public function verifyRif($rif){
        $company = Company::where('RIF',$rif)->with('users')->get();
        if(!$company->isEmpty()){
            if($company[0]->users->isEmpty()){
                $response=array('status'=>'registered','company'=>$company);
            }else{
                $response=array('status'=>'error','message'=>'El RIF '.$rif.' se encuentra registrado en el sistema. Por favor, ingrese un RIF valido.');
            }
        }
        // $company =Company::where('RIF',$rif)->with('users')->get();

        if(!$company->isEmpty()){
            $response=array('status'=>'error','company'=>$company);
        }else{
            $response=array('status'=>'success','message'=>'No registrado.');
        }
        return response()->json($response);
    }


    public function verifyLicense($license,$rif)
    {
        $company = Company::where('license', $license)->get();

        if (!$company->isEmpty()) {
            $response = array('status' => 'error', 'message' => 'La licencia ' . $license . ' se encuentra registrada en el sistema. Por favor, ingrese una licencia valida.');

            if ($company[0]->RIF === $rif) {
                $response = array('status' => 'error', 'message' => 'La Licencia ' . $license . ' ya esta en uso por la empresa ' . $company[0]->name . ' ,Ingrese una Licencia valida.');
            } else {
                $response = array('status' => 'error', 'message' => 'La Licencia ' . $license . ' ya esta en uso por la empresa ' . $company[0]->name . ' ,Ingrese una Licencia valida.');
            }


        } else {
            $response = array('status' => 'success', 'message' => 'No registrado.');
        }
        return response()->json($response);
    }


    public function findCompany($rif){
        $company_find_semat = FindCompany::where('rif',$rif)->get();
        $company_find_sysprim=CompanyRespaldo::where('rif',$rif)->get();

        if(!$company_find_sysprim->isEmpty()){
            $response=array('status'=>'registered','company'=>$company_find_sysprim[0]);
        }else if(!$company_find_semat->isEmpty()){

            $response=array('status'=>'success','company'=>$company_find_semat[0]);
        }else{
            $response=array('status'=>'error','message'=>'No encontrado');
        }
        return response()->json($response);
    }

    public function addCiiu(Request $request)
    {
        $company= new CiuCompany();
        $ciu=$request->input('ciu');
        $id=$request->input('id');
        foreach ($ciu as $value){
            $company->ciu_id=$value;
            $company->company_id=$id;
            $company->save();
        }

        return response()->json(true);

    }


    public function changeStatusCiiu($id_ciu,$company_id,$status){
        $company=Company::find($company_id);
        $ciuCompany=CiuCompany::where('ciu_id',$id_ciu)->where('company_id',$company_id)->get();

        if(!$ciuCompany->isEmpty()){
            $company=CiuCompany::find($ciuCompany[0]->id);
            $company->status=$status;
            $company->update();
        }
        return response()->json(['status'=>$status]);
    }


    public function updatedMap(Request $request){
        $id=$request->input('id');
        $lat=$request->input('lat');
        $lng=$request->input('lng');


        //update
        $company=Company::find($id);
        $company->lat=$lat;
        $company->lng=$lng;
        $company->update();


        return response()->json(['status'=>'success']);
    }


    public function getCarnet($id){
        $company = Company::findOrFail($id);
        $pdf = \PDF::loadView('modules.companies.carnet', ['company'=> $company]);
        return $pdf->stream();
    }


    //Cambia usuario

    public function changeUser($company_id,$ci){
        $user=User::where('ci',$ci)->where('status_account','!=','waiting')->first();
        if(is_object($user)){
            $company=Company::find($company_id);
            $company->users()->sync($user->id);
            $response=['status'=>'success','message'=>'Empresa actualizada con éxito'];
        }else{
            $response=['status'=>'error','message'=>'Usuario no encontrado'];
        }
        return $response;
    }


    public function test(){
        $license=TaxesNumber::generateNumberLicense();
        dd($license);
    }
}
