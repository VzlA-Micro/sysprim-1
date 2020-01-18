<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table="rates";


    public function rateTaxes(){
        return $this->belongsToMany('App\Taxes','rate_taxes')
            ->withPivot(
                'company_id',
                'user_id',
                'tax_unit',
                'cant_tax_unit'
            );
    }

    public function users(){
        return $this->belongsToMany('App\User','rate_taxes')
            ->withPivot('user_id');
    }

    public function company(){
        return $this->belongsToMany('App\Company','rate_taxes')
            ->withPivot('company_id');
    }


}
