<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimelineTypeVehicle extends Model
{
    //
    protected $table='timeline_type_vehicle';

    public function type(){
        return $this->belongsTo('App\VehicleType','type_vehicle_id');
    }
}
