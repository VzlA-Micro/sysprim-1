<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelsVehicle extends Model
{
    protected $table = 'models';

    public function brand()
    {
        return $this->belongsTo('App\Brand','brand_id');
    }


}
