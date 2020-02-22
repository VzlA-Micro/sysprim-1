<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tributo;
use OwenIt\Auditing\Contracts\Auditable;

class Rate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table="rates";
    protected $appends = ['totalRate'];

    public function rateTaxes(){
        return $this->belongsToMany('App\Taxes','rates_taxes')
            ->withPivot(
                'person_id',
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



    public function getTotalRateAttribute(){
        $tributo=Tributo::orderBy('id','desc')->first();

        $this->totalRate=$tributo->value*$this->cant_tax_unit;

        return $this->attributes['totalRate'];
    }


}
