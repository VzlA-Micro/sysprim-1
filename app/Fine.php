<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model{
    protected $table='fines';
    //

    public function Company(){
        return $this->belongsToMany('App\Company','fines_company')
            ->withPivot('company_id','fine_id','unid_tribu_value'); 
    }

    public function FineCompany (){
        return $this->hasMany('App\FineCompany'); 
    }

    /*public function FineCompany (){
        return $this->hasMany('App\FineCompany','fine_id'); 
    }*/
}
