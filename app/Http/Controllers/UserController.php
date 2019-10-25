<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Helpers\CedulaVE;

class UserController extends Controller{

    public function verify($code){
        $user = User::where('confirmed_code', $code)->first();

        if (!$user){
            return redirect('/');
        }
        $user->confirmed = true;
        $user->confirmed_code = null;
        $user->save();
        return redirect('/')->with('notification', 'El equipo de SysPRIM ha verificado tu correo electrónico exitosamente. Por favor, inicia sesión.');
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
    public function create(){
        return view('modules.users.register');
    }
    public function findUser($nationality,$ci){
        $user=CedulaVE::get($nationality,$ci,false);
        return response()->json($user);
    }

}
