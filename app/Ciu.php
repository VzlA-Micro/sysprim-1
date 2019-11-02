<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciu extends Model{
    protected $table='ciu';
    protected $fillable = ['code', 'name','alicuota','min_tribu_men'];

    public function GroupCiiu (){
        return $this->belongsTo('App\Ciu','group_ciu_id');
    }
}
