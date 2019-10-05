<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxe extends Model{
    protected $table="taxes";

    public function taxesCiu(){
        return $this->belongsToMany('App\Ciu','ciu_taxes')
            ->withPivot('ciu_id','fiscal_credits','withholding','deductions','base');
    }

    public function companies(){
        return $this->belongsTo('App\Company','company_id');
    }


    public function payments(){
        return $this->hasMany('App\PaymentTaxes');
    }
}
