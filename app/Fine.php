<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model{
    protected $table='fines';
    //

    public function company(){
        return $this->belongsToMany('App\Company','fines_company')
            ->withPivot('fine_id','unid_tribu_value');
    }

    public function fineCompany (){
        return $this->hasMany('App\FineCompany'); 
    }

    /*public function FineCompany (){
        return $this->hasMany('App\FineCompany','fine_id'); 
    }*/
}
