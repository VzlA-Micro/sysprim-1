<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Helpers\CedulaVE;
use App\Role;

class UserController extends Controller{

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
            $response=array('status'=>'error','message'=>'Esta cedula ya existe en el sistema. Por favor, ingresa una cedula valida.');
        }else{
            $response=array('status'=>'success','message'=>'No registrado.');
        }
        return response()->json($response);
    }


    public function verifyEmail($email){
        $user=User::where('email', $email)->get();
        if(!$user->isEmpty()){
            $response=array('status'=>'error','message'=>'Esta correo ya existe en el sistema. Ingrese un correo valido.');
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
        $role=Role::all();
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
        $user->email=$email;
        $user->password=$password;

        $user->save();

    }

    public function show()
    {

        $user= User::get();
        return view('modules.users.read',array(
            'showUser' => $user
        ));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $role = Role::where('id',$user->role_id)->get();
        return view('modules.users.details',array(
            'user'=>$user,
            'role'=>$role
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
        $user->email=$email;
        $user->password=$password;

        $user->update();
    }


}
