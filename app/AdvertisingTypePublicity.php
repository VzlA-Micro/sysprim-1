<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertisingTypePublicity extends Model
{
    protected $table = 'advertising_type_pubicity';

    // public function publicities() {
    // 	return $this->belongsToMany('App\Publicity','publicity')
    //         ->withPivot('publicity_id');
    // }

    // public function advertisingTypes() {
    // 	return $this->belongsToMany('App\AdvertisingType','advertising_type')
    //         ->withPivot('advertising_type_id');
    // }
}
