<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CatastralTerreno extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table='value_catastral_terreno';
    protected $fillable = ['parish_id', 'sector_nueva_nomenclatura','sector_catastral','name'];

    public function timelineValue() {
        return $this->hasMany('App\TimelineCatastralTerrain', 'value_catastral_terreno_id');
    }
}
