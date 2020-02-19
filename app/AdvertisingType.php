<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AdvertisingType extends Model implements Auditable
{
    protected $table="advertising_type";
    
    use \OwenIt\Auditing\Auditable;

    public function group()
    {
        return $this->belongsTo('App\GroupPublicity','group_publicity_id');
    }
}
