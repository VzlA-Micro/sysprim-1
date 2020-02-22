<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Alicuota extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table='alicuota_inmueble';

    public function timelineValue() {
        return $this->hasMany('App\TimelineAlicuota', 'alicuota_inmueble_id');
    }
}
