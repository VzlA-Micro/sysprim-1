<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    protected $table='property';

    public function user(){
        return $this->belongsToMany('App\User','user_property')
            ->withPivot('user_id');
    }

    public function catasConstruct(){
        return $this->belongsToMany('App\CatastralConstruccion','val_cat_const_inmu')
            ->withPivot('value_catas_const_id');
    }

    public function valueGround(){
        return $this->belongsTo('App\CatastralTerreno','value_cadastral_ground_id');
    }

    public function type(){
        return $this->belongsTo('App\Alicuota','type_inmueble_id');
    }

}
