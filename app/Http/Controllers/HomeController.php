<?php

namespace App\Http\Controllers;

use App\Helpers\TaxesNumber;
use App\Helpers\Verification;
use App\Prologue;
use App\Taxe;
use App\User;
use App\Images;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Helpers\TaxesMonth;
use App\Helpers\CedulaVE;
use Psy\Util\Json;
use  App\Helpers\Rif;
use App\Helpers\CheckCollectionDay;

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

    public function home(){
        if (Auth::guest()) {
            $animated = ['animate down','animate in','animate down','animate out'];
            $background = Images::where('status', 'enabled')->get();

            return view('auth.login', ['backgrounds'    => $background,
                             'animated'       =>  $animated  ]);
        } else {
            return view('home');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){

        if(\Auth::user()->status_account==='block'){
            Auth::logout();
            return redirect('/')->with('notification','Su usuario ha sido bloqueado, para poder desbloquearlo debe  dirigirse a la oficinas del semat.');
        }else if(\Auth::user()->confirmed!=0){
             $rute_serve="https://sysprim.com";
             $rute_now="https://".$_SERVER["SERVER_NAME"];
            if((\Auth::user()->role_id=='2'||\Auth::user()->role_id=='4'||\Auth::user()->role_id=='5')&&$rute_now==$rute_serve){
                $user=User::find(\Auth::user()->id);
                $user->status_account='block';
                $user->update();
                Auth::logout();
                return redirect('/')->with('notification','Su usuario ha sido bloqueado, para poder desbloquearlo debe  dirigirse a la oficinas del semat.');
            }else{
                return redirect('/');
            }
        }else{
            Auth::logout();
            return redirect('/')->with('notification','Verifica tu correo para entrar en el sistema');
        }
    }

    public function online(){
        return $datos=['status'=>200,'online'];
    }

    public function downloadPdf($pdf) {
        $file = storage_path() . "/app/public/" . $pdf;
        $headers = ['Content-Type' => 'application/pfd'];
        // dd($file);
        // return Storage::download($file, $pdf, $headers);
        return response()->download($file, $pdf, $headers);
    }


    public function test(){
        $verify=Verification::verifyDeudaFospuca('J002711442');
        dd($verify);
    }

    public function deleteTemp()
    {
        $taxes=Taxe::where('status','Temporal')
            ->where('status','temporal')
            ->delete();
        return response()->json(true);
    }

}
