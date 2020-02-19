<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CompanyTaxe extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;
   
    protected $table='company_taxes';

    public function company(){
        return $this->hasMany('App\Company');
    }

    public function taxes(){
        return $this->hasMany('App\Taxe');
    }
}
