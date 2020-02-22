<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Val_cat_const_inmu extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table='val_cat_const_inmu';

    public function buildingValue() {
        return $this->belongsTo('App\CatastralConstruccion', 'value_catas_const_id');
//            ->withPivot('property_id', 'value_catas_const_id');
    }
}
