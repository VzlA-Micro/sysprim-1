<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TimelineTypeVehicle extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table='timeline_type_vehicle';

    public function type(){
        return $this->belongsTo('App\VehicleType','type_vehicle_id');
    }
}
