<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use App\User;
use App\Helpers\CedulaVE;
use App\Role;
use OwenIt\Auditing\Models\Audit;


class UserController extends Controller{

    public function index() {
        return view('modules.users.menu');
    }

    public function verify($code){
        $user = User::where('confirmed_code', $code)->first();

        if (!$user){
            return redirect('/');
        }
        $user->confirmed = true;
        $user->confirmed_code = null;
        $user->save();
        return redirect('/')->with('notification', 'El equipo de SEMAT - Iribarren ha verificado tu correo electrónico exitosamente. Por favor, inicia sesión.');
    }



    public function verifyCi($ci){
        $user=User::where('ci', $ci)->where('status_account','!=','waiting')->get();
        if(!$user->isEmpty()){
            $response=array('status'=>'error','message'=>'La cedula "'.$ci.'" se encuentra registrada en el sistema. Por favor, ingrese una cedula valida.');
        }else{
            $response=array('status'=>'success','message'=>'No registrado.');
        }
        return response()->json($response);
    }




    public function verifyEmail($email,$id=null){
        if(is_null($id)) {
            $user = User::where('email', $email)->where('status_account','!=','waiting')->get();
        }else{
            $user = User::where('email', $email)->where('status_account','!=','waiting')->where('id','!=',$id)->get();
        }
        if(!$user->isEmpty()){
            $response=array('status'=>'error','message'=>'El correo "'.$email.'" encuentra registrado en el sistema. Por favor, ingrese un correo valido.');
        }else{
            $response=array('status'=>'success','message'=>'No registrado.');
        }
        return response()->json($response);
    }

    public function findUser($nationality,$ci){
        $user=CedulaVE::get($nationality,$ci,false);
        return response()->json($user);
    }

    public function create()
    {   
        if(\Auth::User()->role_id == 6){
            $role = Role::where('id',2)->orWhere('id',4)->get();
        }
        else {
            $role = Role::all();
        }
        return view('modules.users.register',['Role'=>$role]);
    }

    public function store(Request $request)
    {
        $nacionality= $request->input('nationality');
        $ci= $request->input('ci');
        $name= strtoupper($request->input('name'));
        $surname= strtoupper($request->input('surname'));
        $phone= $request->input('phone');
        $country_code= $request->input('country_code');
        $role= $request->input('role');
        $email= $request->input('email');
        $password=Hash::make($request->input('password'));
        $user=User::where('ci', $nacionality . $ci)->where('status_account','=','waiting')->first();
        $address =$request->input('address');


        if(!is_null($user)){
            $user=User::find($user->id);
            $user->phone = $country_code . $phone;
            $user->confirmed = 1;
            $user->role_id = $role;
            $user->syncRoles($role);
            $user->email = $email;
            $user->password = $password;
            $user->status_account='authorized';
            $user->address=$address;
            $user->update();
        }else {
            $user = new User();
            $user->ci = $nacionality . $ci;
            $user->name = $name;
            $user->surname = $surname;
            $user->phone = $country_code . $phone;
            $user->confirmed = 1;
            $user->role_id = $role;
            $user->syncRoles($role);
            $user->email = $email;
            $user->password = $password;
            $user->address=$address;
            $user->save();
        }
    }

    public function show()
    {
        if(\Auth::User()->role_id == 6) {
            $user= User::where('role_id',2)->where('status_account','!=','waiting')->orWhere('role_id',3)->orWhere('role_id',4)->orderBy('id','desc')->get();
        }
        else{
            $user= User::where('status_account','!=','waiting')->orderBy('id','desc')->get();
        }



        return view('modules.users.read',array(
            'showUser' => $user
        ));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $role = Role::all();
        return view('modules.users.edit',array(
            'user'=>$user,
            'Role'=>$role
        ));
    }

    public function editar($id)
    {
        $user = User::find($id);
        $roles=Role::all();
        $role = Role::where('id',$user->role_id)->get();
        return view('modules.users.edit',array(
            'user'=>$user,
            'role'=>$role,
            'roles'=>$roles
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id= $request->input('id');
        $phone= $request->input('country_code').$request->input('phone');
        $role= $request->input('role');
        $email= $request->input('email');
        $address =$request->input('address');
        $user=User::find($id);
        $user->phone=$phone;
        $user->role_id=$role;
        $user->syncRoles($role);
        $user->email=$email;
        $user->address=$address;

        $user->update();
    }

    public function profile() {
        return view('modules.users.profile');
    }

    public function updateProfile(Request $request) {
        $id= $request->input('id');
        $phone= $request->input('country_code').$request->input('phone');
        $email= $request->input('email');
        $user=User::find($id);
        $user->phone='+'.$phone;
        $user->email=$email;
        $user->update();
    }

    public function resetUserPassword(Request $request) {
        $id= $request->input('id');
        $user=User::find($id);
        $password = Hash::make($user->ci);
        $user->password = $password;
        $user->update();
    }

    public function showTaxpayer() {
        $users = User::where('role_id','=','3')->where('status_account','!=','waiting')->get();

        return view('modules.taxpayers.read', array(
            'users' => $users
        ));




    }

    public function detailsTaxpayer($id) {
        $user = User::find($id);
        $number_company=$user->companies()->count();
        $number_rate=$user->taxesRate()->count();

        $number_vehicle=$user->vehicles()->count();
        $number_property=$user->property()->count();


        return view('modules.taxpayers.details', array(
            'user' => $user,
            'number_company'=>$number_company,
            'number_rate'=>$number_rate,
            'number_vehicle'=>$number_vehicle,
            'number_property'=>$number_property
        ));

    }

    public function storeTaxpayer(Request $request) {
        $nacionality= $request->input('nationality');
        $ci= $request->input('ci');
        $name= strtoupper($request->input('name'));
        $surname= strtoupper($request->input('surname'));
        $phone= $request->input('phone');
        $country_code= $request->input('country_code');
        $role= $request->input('role');
        $email= $request->input('email');
        $address =$request->input('address');
        $fullCi = $nacionality.$ci;
        $password=Hash::make($fullCi);


        $user=User::where('ci', $nacionality . $ci)->where('status_account','=','waiting')->first();



        if(!is_null($user)) {
            $user=User::find($user->id);
            $user->ci=$nacionality.$ci;
            $user->name=$name;
            $user->surname=$surname;
            $user->phone=$country_code.$phone;
            $user->confirmed=1;
            $user->status_account='authorized';
            $user->role_id=$role;
            $user->syncRoles($role);
            $user->email=$email;
            $user->password=$password;
            $user->address=$address;
            $user->update();

        }else{
            $user=new User();
            $user->ci=$nacionality.$ci;
            $user->name=$name;
            $user->surname=$surname;
            $user->phone=$country_code.$phone;
            $user->confirmed=1;
            $user->role_id=$role;
            $user->syncRoles($role);
            $user->email=$email;
            $user->password=$password;
            $user->address=$address;
            $user->save();
        }



    }

    public function updateTaxpayer(Request $request) {
        $id= $request->input('id');
        $phone= $request->input('phone');
        $country_code= $request->input('country_code');
        $email= $request->input('email');
        $address= $request->input('address');

        $user=User::find($id);
        $user->phone=$country_code.$phone;
        $user->email=$email;
        $user->address=  $address;


        $user->update();
    }

    public function resetTaxpayerPassword(Request $request) {
        $id= $request->input('id');
        $user=User::find($id);
        $password = Hash::make($user->ci);
        $user->password = $password;
        $user->update();
    }

    public function getImage($filename){
        $file=Storage::disk('users')->get($filename);
        return new Response($file,200);
    }

    public function changeImage(Request $request) {
        $id = $request->input('id');
        $image = $request->file('image');
        $user=User::find($id);
        $old_image = $user->image;
        if($old_image == null){
            if($image) {
                $image_name = $user->ci . "." . $image->clientExtension(); // Nombre de la imagen
                Storage::disk('users')->put($image_name, File::get($image));
                $user->image = $image_name;
            }
            $user->update();
        }
        else{
            Storage::disk('users')->delete($old_image);
            if($image) {
                $image_name = $user->ci . "." . $image->clientExtension(); // Nombre de la imagen
                Storage::disk('users')->put($image_name, File::get($image));
                $user->image = $image_name;
            }
            $user->update();
        }
    }

    public function enableDisableAccount($id,$status){
        $user=User::find($id);
        if($status==='enabled'){
            $user->confirmed=1;
            $user->status_account='authorized';
        }else{
            $user->status_account='block';
        }


        $user->update();
        return response()->json(['status',$status]);
    }



    //Muestra lo vehiculos de este contribuyente
    public function detailsCompanyTaxPayers($id){
        $user = User::find($id);
        $companies=$user->companies()->get();
        return view('modules.ticket-office.companies.read', ['companies' => $companies]);
    }

    //Muestra los detalles de tasas

    public function detailsRatesTaxPayers($id){
        $user = User::find($id);
        $rates=$user->taxesRate()->get();
        return view('modules.rates.ticket-office.all-taxes',['taxes'=>$rates,'id'=>$id]);
    }

    //Muestra los de vehiculos de este contribuyente
    public function detailsVehicleTaxPayers($id){
        $user = User::find($id);
        $vehicle=$user->vehicles()->get();
        return view('modules.ticket-office.vehicle.modules.vehicle.read', array(
            'show' => $vehicle
        ));
    }


    //Muestra los inmuebles de este contribuyente
    public function detailsPropertyTaxPayers($id){
        $user = User::find($id);
        $properties=$user->property()->get();
        return view('modules.properties.module.read', ['properties'=>$properties]);
    }



    public function detailsSecurity($id){
        $audits = Audit::where('user_id',$id)->orderBy('id','desc')->get();
        return view('modules.security.audits', ['audits' => $audits]);
    }
}
