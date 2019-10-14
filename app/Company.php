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
    public function taxesCompanies(){
        return $this->hasMany('App\Taxe','company_id');
    }

    public function fineCompany(){
        return $this->hasMany('App\FineCompany','company_id');
    }

}
