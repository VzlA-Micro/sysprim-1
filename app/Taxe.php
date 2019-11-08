<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


class Taxe extends Model{
    protected $table="taxes";
    protected $appends = ['total'];
    public function taxesCiu(){
        return $this->belongsToMany('App\Ciu','ciu_taxes')
            ->withPivot('ciu_id','fiscal_credits','withholding','deductions','base','unid_tribu','mora','tax_rate','interest');
    }

    public function companies(){
        return $this->belongsToMany('App\Company','company_taxes')
            ->withPivot('company_id');
    }


    public function payments(){
        return $this->hasMany('App\Payments');
    }

    public function getTotalAttribute(){



    }

    public function ciuTaxes(){
        return $this->hasMany('App\CiuTaxes','ciu_id');
    }



}
