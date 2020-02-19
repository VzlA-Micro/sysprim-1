<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimelineCiiu extends Model
{
    protected $table='timeline_ciu';

    public function ciiu(){
        return $this->belongsTo('App\Ciu','ciu_id');
    }

}
