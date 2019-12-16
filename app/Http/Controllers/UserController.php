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
        $user=User::where('ci', $ci)->get();
        if(!$user->isEmpty()){
            $response=array('status'=>'error','message'=>'La cedula "'.$ci.'" se encuentra registrada en el sistema. Por favor, ingrese una cedula valida.');
        }else{
            $response=array('status'=>'success','message'=>'No registrado.');
        }
        return response()->json($response);
    }


    public function verifyEmail($email){
        $user=User::where('email', $email)->get();
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
        $name= $request->input('name');
        $surname= $request->input('surname');
        $phone= $request->input('phone');
        $country_code= $request->input('country_code');
        $role= $request->input('role');
        $email= $request->input('email');
        $password=Hash::make($request->input('password'));

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
        $user->save();
    }

    public function show()
    {
        if(\Auth::User()->role_id == 6) {
            $user= User::where('role_id',2)->orWhere('role_id',3)->orWhere('role_id',4)->get();
        }
        else{
            $user= User::get();
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
        $phone= $request->input('phone');
        $role= $request->input('roles');
        $email= $request->input('emailEdit');
        $password=Hash::make($request->input('passwordEdit'));
        $user=User::find($id);
        $user->phone=$phone;
        $user->role_id=$role;
        $user->syncRoles($role);
        $user->email=$email;
        $user->password=$password;
        $user->update();
    }

    public function profile() {
        return view('modules.users.profile');
    }

    public function updateProfile(Request $request) {
        $id= $request->input('id');
        $phone= $request->input('phone');
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
        $users = User::where('role_id','=','3')->get();
        return view('modules.taxpayers.read', array(
            'users' => $users
        ));
    }

    public function detailsTaxpayer($id) {
        $user = User::find($id);

        return view('modules.taxpayers.details', array(
            'user' => $user
        ));
    }

    public function storeTaxpayer(Request $request) {
        $nacionality= $request->input('nationality');
        $ci= $request->input('ci');
        $name= $request->input('name');
        $surname= $request->input('surname');
        $phone= $request->input('phone');
        $country_code= $request->input('country_code');
        $role= $request->input('role');
        $email= $request->input('email');
        $fullCi = $nacionality.$ci;
        $password=Hash::make($fullCi);

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
        $user->save();
    }

    public function updateTaxpayer(Request $request) {
        $id= $request->input('id');
        $phone= $request->input('phone');
        $email= $request->input('email');
        $user=User::find($id);
        $user->phone=$phone;
        $user->email=$email;
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
}
