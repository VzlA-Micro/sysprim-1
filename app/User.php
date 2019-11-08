<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MyResetPassword;
use App\Notifications\VerifyEmailNotification;
use App\Notifications\Payments;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','surname','image','phone','ci','confirmed_code','confirmed','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function companies(){
        return $this->belongsToMany('App\Company','users_company')
            ->withPivot('company_id');
    }

    public function property(){
        return $this->belongsToMany('App\Inmueble','user_property')
            ->withPivot('property_id');
    }



    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

    public function VerifyEmail ($token) {
        $this->notify(new VerifyEmailNotification($token));
    }
    public function ConfirmedPayments($user) {
        $this->notify(new Payments($user));
    }

}
