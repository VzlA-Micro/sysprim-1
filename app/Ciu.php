<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Ciu extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;


    protected $table='ciu';
    protected $fillable = ['code', 'name','alicuota','min_tribu_men'];

    public function GroupCiiu (){
        return $this->belongsTo('App\Ciu','group_ciu_id');
    }
}
