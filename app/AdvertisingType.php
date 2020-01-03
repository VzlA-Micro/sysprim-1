<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertisingType extends Model
{
    protected $table="advertising_type";

    public function publicities() {
    	return $this->belongsToMany('App\AdvertisingTypePublicity','advertising_type_publicity')
            ->withPivot('publicity_id');
    }
}
