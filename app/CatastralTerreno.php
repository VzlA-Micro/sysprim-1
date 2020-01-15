<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatastralTerreno extends Model
{
    //
    protected $table='value_catastral_terreno';
    protected $fillable = ['parish_id', 'sector_nueva_nomenclatura','sector_catastral','name','value_terreno_construccion','value_terreno_vacio'];
}
