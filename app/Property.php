<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Property extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'property';

    public function users() {
        return $this->belongsToMany('App\User','user_property')
            ->withPivot(
                'user_id',
                'person_id',
                'company_id',
                'status');
    }



    public function person(){
        return $this->belongsTo('App\User','person_id');
    }




    public function catastralConstruction() {
        return $this->hasMany('App\CatastralConstruccion','val_cat_const_inmu', 'value_catas_const_id');
//            ->withPivot('value_catas_const_id');
    }
/*
    public function catasConstruct(){
        return $this->belongsToMany('App\CatastralConstruccion','val_cat_const_inmu')
            ->withPivot('value_catas_const_id');
    }*/




    public function parish(){
        return $this->belongsTo('App\Parish','parish_id');
    }
    public function valueGround(){
        return $this->belongsTo('App\CatastralTerreno','value_cadastral_ground_id');
    }

    public function valueBuild(){
        return $this->belongsTo('App\CatastralConstruccion','value_cadastral_build_id');
    }

    public function type(){
        return $this->belongsTo('App\Alicuota','type_inmueble_id');
    }

    public function propertyTaxes() {
        return $this->belongsToMany('App\Taxe','property_taxes')
            ->withPivot('taxe_id');
    }
}
