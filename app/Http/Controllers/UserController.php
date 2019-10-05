<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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

}
