<?php

namespace App\Http\Controllers;

use App\Notification;
use App\User;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Company;
use App\Ciu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\UserCompany;
use App\PaymentTaxes;
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
        $ciu=Ciu::all();
        return view('modules.companies.register',['ciu'=>$ciu]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $ciu=$request->input('ciu');
        $image=$request->file('image');
        $name=$request->input('name');
        $license=$request->input('license');
        $openingDate=$request->input('opening_date');
        $rif=$request->input('RIF');
        $address=$request->input('address');
        $lat="23554454";
        $lng="265656577";


        $validate=$this->validate($request,[
            'name'=>'required',
            'license'=>'required',
            'RIF'=>'required|min:9',
            'address'=>'required',
            'opening_date'=>'required',
        ]);

        $company=new Company();
        if($image){
            $image_path_name=time().$image->getClientOriginalName();
            Storage::disk('companies')->put($image_path_name,File::get($image));
            $company->image=$image_path_name;
        }else{
            $company->image=null;
        }
        $company->name=$name;
        $company->address=$address;
        $company->rif=$rif;
        $company->license=$license;
        $company->lat="23554454";
        $company->lng="23554454";
        $company->opening_date=$openingDate;
        $company->save();
        $id=DB::getPdo()->lastInsertId();
        $company->users()->attach(['company_id'=>$id],['user_id'=>\Auth::user()->id]);
        foreach ($ciu as $ciu){
            $company->ciu()->attach(['company_id'=>$id],['ciu_id'=>$ciu]);
        }
        return redirect('companies/my-business')->with(['message'=>'Empresa registrada con éxito']);
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
        return view('modules.companies.edit',['ciu' => $ciu, 'company' => $company]);
    }

    public function update(Request $request){
        /*Falta:eliminar imagenes antigua una vez suba la nueva, */

        $ciu=$request->input('ciu');
        $image=$request->file('image');
        $name=$request->input('name');
        $license=$request->input('license');
        $openingDate=$request->input('opening_date');
        $rif=$request->input('RIF');
        $address=$request->input('address');
        $id=$request->input('id');
        $lat="23554454";
        $lng="265656577";


        $validate=$this->validate($request,[
            'name'=>'required',
            'license'=>'required',
            'RIF'=>'required|min:9',
            'address'=>'required',
            'opening_date'=>'required',
        ]);

        $company=Company::find($id);
        if($image){
            $image_path_name=time().$image->getClientOriginalName();
            Storage::disk('companies')->delete($company->image);
            $company->image=$image_path_name;
        }else{
            $company->image=null;
        }
        $company->name=$name;
        $company->address=$address;
        $company->rif=$rif;
        $company->license=$license;
        $company->lat="23554454";
        $company->lng="23554454";
        $company->opening_date=$openingDate;
        $company->update();
        $company->ciu()->sync($ciu);

        return redirect('company/edit/'.$id)->with(['message'=>'Empresa actualizada con éxito']);

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
            $payment = PaymentTaxes::where('taxe_id', $companyTaxes[0]->id)->get();//busco si el pago fue realizo

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
}
