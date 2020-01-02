<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyTaxe extends Model
{
    //
    protected $table='company_taxes';

    public function company(){
        return $this->hasMany('App\Company');
    }

    public function taxes(){
        return $this->hasMany('App\Taxe');
    }
}
