<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'ci'=>['required','string', 'min:7','unique:users'],
            'phone'=>['required','string', 'min:7'],
            'nationality'=>['required','string'],
            'country_code'=>['required','string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data['confirmation_code'] = str_random(25);

        $user=User::where('ci',$data['nationality'] . $data['ci'] )->where('status_account','=','waiting')->first();



        if(!is_null($user)){
            $user=User::find($user->id);
            $user->phone = $data['country_code'] . $data['phone'];
            $user->confirmed = 0;
            $user->address = $data['address'];
            $user->role_id = 3;
            $user->email = $data['email'];
            $user->password =Hash::make($data['password']);
            $user->status_account='authorized';
            $user->confirmed_code= $data['confirmation_code'];
            $user->update();
        }else {
            $user = User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'address' => $data['address'],
                'password' => Hash::make($data['password']),
                'ci' => $data['nationality'] . $data['ci'],
                'phone' => $data['country_code'] . $data['phone'],
                'confirmed_code' => $data['confirmation_code'],
                'role_id' => 3,
            ]);
        }


        $id=$user->id;
        $user=User::find($id);
        $user->VerifyEmail($data['confirmation_code']);
        $user->syncRoles(3);
      return $user;

    }
}
