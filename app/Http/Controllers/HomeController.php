<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Helpers\TaxesMonth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){

        if(\Auth::user()->confirmed!=0){
            if(!session()->has('notifications')){
                $user=User::find(Auth::user()->id);
                foreach ($user->companies as $company){
                    TaxesMonth::verify($company->id);
                }

                $notifications= DB::table('notification')->where('user_id','=',\Auth::user()->id)->get();
                session(['notifications' => $notifications]);
            }
            return view('home');
        }else{
            Auth::logout();
            return redirect('/')->with('notification','Verifica tu correo para entrar en el sistema');
        }
    }
}
