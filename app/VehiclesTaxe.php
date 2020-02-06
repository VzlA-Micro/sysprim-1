<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehiclesTaxe extends Model
{
    protected $table = 'vehicles_taxes';

    public function taxes(){
        return $this->belongsTo('App\Taxe');
    }

}
