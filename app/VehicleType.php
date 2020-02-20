<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VehicleType extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table='vehicle_type';

    public function timeline(){
        return $this->hasMany('App\TimelineTypeVehicle','type_vehicle_id');
    }
}
