<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimelineCatastralBuild extends Model
{
    protected $table = "timeline_catastral_build";

    public function catastralBuild() {
        return $this->belongsTo('App\CatastralConstruccion', 'value_catastral_construccion_id');
    }
}
