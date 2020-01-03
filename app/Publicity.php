<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publicity extends Model
{
    protected $table = 'publicity';

    public function users() {
    	return $this->belongsToMany('App\User','users_publicity')
            ->withPivot('user_id');
    }

    public function company() {
    	return $this->belongsToMany('App\Company','company_publicity')
            ->withPivot('company_id');
    }

    public function advertisingTypes() {
    	return $this->belongsToMany('App\AdvertisingTypePublicity','advertising_type_publicity')
            ->withPivot('advertising_type_id');
    }
}
