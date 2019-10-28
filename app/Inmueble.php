<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    protected $table='inmueble';

    public function user(){
        return $this->belongsToMany('App\User','user_inmueble')
            ->withPivot('user_id');
    }

    public function catasConstruct(){
        return $this->belongsToMany('App\CatastralConstruccion','val_cat_const_inmu')
            ->withPivot('value_catas_const_id');
    }

}
