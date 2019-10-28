<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatastralConstruccion extends Model
{
    //
    protected $table='value_catastral_construccion';

    public function property(){
        return $this->belongsToMany('App\Inmueble','val_cat_const_inmu')
            ->withPivot('inmueble_id');
    }
}
