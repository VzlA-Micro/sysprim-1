<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VehiclesTaxe extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'vehicles_taxes';

    public function taxes(){
        return $this->belongsTo('App\Taxe');
    }

}
