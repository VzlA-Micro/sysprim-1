<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Publicity extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'publicity';

    public function users() {
    	return $this->belongsToMany('App\User','users_publicity')
            ->withPivot('user_id');
    }

    public function company() {
    	return $this->belongsToMany('App\Company','company_publicity')
            ->withPivot('company_id');
    }

    public function advertisingType() {
    	return $this->belongsTo('App\AdvertisingType','advertising_type_id');
            // ->withPivot('advertising_type_id');
    }



    public function publicityTaxes() {
        return $this->belongsToMany('App\Taxe','publicity_taxes')
            ->withPivot('taxe_id');
    }

    public function person(){
        return $this->belongsToMany('App\User','users_publicity')
            ->withPivot('person_id');
    }

}
