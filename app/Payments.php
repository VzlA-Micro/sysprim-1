<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model{
    protected $table='payments';



    public function taxes(){
       return  $this->belongsTo('App\Taxe','taxe_id');
    }


    //
}
