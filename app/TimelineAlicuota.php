<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimelineAlicuota extends Model
{
    protected $table = "timeline_alicuota";

    public function alicuota() {
        return $this->belongsTo('App\Alicuota', 'alicuota_inmueble_id');
    }
}
