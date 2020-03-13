<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Images;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;



    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        if(\Auth::check()){
           \ Auth::logoutOtherDevices(request('password'));
        }
    }

    public function showLoginForm()
    {
        $animated = ['animate down','animate in','animate down','animate out'];
        $background = Images::where('status', 'enabled')->get();

        return view('auth.login', ['backgrounds'    => $background,
            'animated'       =>  $animated  ]);
    }

    protected function authenticated()
    {
        \Auth::logoutOtherDevices(request('password'));
    }
}
