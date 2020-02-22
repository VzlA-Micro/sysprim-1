<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimelineCatastralTerrain extends Model
{
    protected $table = "timeline_catastral_terrain";

    public function catastralTerrain() {
        return $this->belongsTo('App\CatastralTerreno', 'value_catastral_terreno_id');
    }

    public function timelineValue() {
        return $this->hasMany('App\TimelineCatastralTerrain', 'value_catastral_terreno_id');
    }
}
