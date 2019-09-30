<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model{
    protected $table='company';

    public function users(){
        return $this->belongsToMany('App\User','users_company')
            ->withPivot('user_id');
    }

    public function ciu(){
        return $this->belongsToMany('App\Ciu','company_ciu')
            ->withPivot('ciu_id');
    }

}
