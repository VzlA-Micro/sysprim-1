<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table='vehicles';

    public function users(){
        return $this->belongsToMany('App\User','user_vehicle')
            ->withPivot('user_id');
    }

    public function type(){
        return $this->belongsTo('App\VehicleType','type_vehicle_id');
    }

    public function model(){
        return $this->belongsTo('App\ModelsVehicle');
    }

    public function taxesVehicle(){
        return $this->belongsToMany('App\Taxe','vehicles_taxes')
            ->withPivot('taxe_id');
    }
}
