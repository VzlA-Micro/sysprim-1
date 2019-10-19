<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Company extends Model{
    protected $table='company';
    protected $appends=['desc'];
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


    public function getDescAttribute(){
        $opening_date=Carbon::parse($this->opening_date);
        $date_now=Carbon::now();
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        if($opening_date->diffInYears($date_now)>4){
            return $this->desc=false;
        }else{
           return $this->desc=true;
        }
    }

}
