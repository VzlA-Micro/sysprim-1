<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MyResetPassword;
use App\Notifications\VerifyEmailNotification;
use App\Notifications\Payments;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use Notifiable, HasRoles;

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
        'name', 'email', 'password', 'surname', 'address' ,'image', 'phone', 'ci', 'confirmed_code', 'confirmed', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['typeDocument', 'document', 'operator', 'numberPhone', 'statusName', 'statusEmail'];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function companies()
    {
        return $this->belongsToMany('App\Company', 'users_company')
            ->withPivot('company_id');
    }

    public function property()
    {
        return $this->belongsToMany('App\Property', 'user_property')
            ->withPivot('property_id');
    }

    public function publicities() {
        return $this->belongsToMany('App\Publicity', 'users_publicity')
            ->withPivot('publicity_id');
    }

    public function vehicles()
    {
        return $this->belongsToMany('App\Vehicle', 'user_vehicle')
            ->withPivot('vehicle_id');
    }

    public function role() {
        return $this->belongsTo('App\Role', 'role_id');
    }



    public function taxesRate(){
        return $this->belongsToMany('App\Taxe', 'rates_taxes')
            ->withPivot('taxe_id');
    }

    /*public function taxesProperty(){
        return $this->belongsToMany('App\Taxe', 'property_taxes')
            ->withPivot('taxe_id','user_id');
    }*/

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

    public function VerifyEmail($token)
    {
        $this->notify(new VerifyEmailNotification($token));
    }

    public function ConfirmedPayments($user)
    {
        $this->notify(new Payments($user));
    }

    public function getTypeDocumentAttribute()
    {
        return $this->typeDocument = substr($this->ci, 0, 1);
    }

    public function getDocumentAttribute(){
        return $this->document = substr($this->ci, 1, 11);
    }


    public function getOperatorAttribute()
    {
        return $this->operator = substr($this->phone, 0, 3);
    }

    public function getNumberPhoneAttribute()
    {
        return $this->phone = substr($this->phone, 6, 11);
    }



    public function getstatusNameAttribute(){
        if($this->status_account=="authorized"){

            return $this->statusName="Autorizado";
        }else if($this->status_account=='block'){
            return $this->statusName="Bloqueado.";
        }
    }


    public function getstatusEmailAttribute(){
        if($this->confirmed){
            return $this->statusEmail='Confirmado.';
        }else{
            return $this->statusEmail='Sin Confirmar.';
        }
    }

}