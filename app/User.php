<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MyResetPassword;
use App\Notifications\VerifyEmailNotification;
use App\Notifications\Payments;
use OwenIt\Auditing\Contracts\Auditable;
class User extends Authenticatable  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use Notifiable;

    protected $auditEvents = [
        'created',
        'updated',
        'deleted',
        'restored',
    ];
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

    protected $appends=['typeDocument','document','operator','numberPhone'];



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

    public function getTypeDocumentAttribute(){
        return $this->typeDocument=substr($this->ci,0,1);
    }

    public function getDocumentAttribute(){
        return $this->document=substr($this->ci,1,11);
    }


    public function getOperatorAttribute(){
        return $this->operator=substr($this->phone,0,6);
    }

    public function getNumberPhoneAttribute(){
        return $this->phone=substr($this->phone,6,11);
    }

}
