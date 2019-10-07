<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use PHPUnit\Framework\Constraint\IsEmpty;

class UserController extends Controller{

    public function verify($code){
        $user = User::where('confirmed_code', $code)->first();

        if (!$user){
            return redirect('/');
        }
        $user->confirmed = true;
        $user->confirmed_code = null;
        $user->save();
        return redirect('/')->with('notification', 'Has confirmado correctamente tu correo.Ya puedes inciar Sesion');
    }



    public function verifyCi($ci){
        $user=User::where('ci', $ci)->get();
        if(!$user->isEmpty()){
            $response=array('status'=>'error','message'=>'Esta cedula ya esta registrado en sysprim, Ingrese una cedula valida.');
        }else{
            $response=array('status'=>'success','message'=>'No registrado.');
        }
        return response()->json($response);
    }


    public function verifyEmail($email){
        $user=User::where('email', $email)->get();
        if(!$user->isEmpty()){
            $response=array('status'=>'error','message'=>'Este correo ya esta registrado en sysprim, Ingrese un correo valido.');
        }else{
            $response=array('status'=>'success','message'=>'No registrado.');
        }
        return response()->json($response);
    }

}
