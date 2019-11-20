<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Payments extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;

    protected $table='payments';

    public function taxes(){
       return  $this->belongsTo('App\Taxe','taxe_id');
    }


    //
}
