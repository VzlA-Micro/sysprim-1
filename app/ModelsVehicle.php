<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ModelsVehicle extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'models';

    public function brand()
    {
        return $this->belongsTo('App\Brand','brand_id');
    }


}
