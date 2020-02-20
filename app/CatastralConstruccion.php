<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class CatastralConstruccion extends Model implements Auditable
{
 use \OwenIt\Auditing\Auditable;
   
    protected $table='value_catastral_construccion';

    public function property(){
        return $this->belongsToMany('App\Inmueble','val_cat_const_inmu')
            ->withPivot('property_id');
    }

    public function timelineValue() {
        return $this->hasMany('App\TimelineCatastralBuild', 'value_catastral_construccion_id');
    }
}
