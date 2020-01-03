<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;


class Company extends Model implements Auditable {
    use \OwenIt\Auditing\Auditable;

    protected $table='company';

    protected $appends=['desc','typeCompany','typeDocument',
                        'document',
                        'operator',
                        'numberPhone'];



    public function users(){
    return $this->belongsToMany('App\User','users_company')
        ->withPivot('user_id');
    }


    public function ciu(){
        return $this->belongsToMany('App\Ciu','company_ciu')
            ->withPivot('ciu_id','status');
    }
    public function taxesCompanies(){
        return $this->belongsToMany('App\Taxe','company_taxes')
            ->withPivot('taxe_id');
    }


    public function fineCompany(){
        return $this->belongsToMany('App\Fine','fines_company')
            ->withPivot('company_id','fine_id','unid_tribu_value','fiscal_period');
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

    public function getTypeCompanyAttribute(){
        return $this->typeCompany=substr($this->license,0,1);
    }

    public function getTypeDocumentAttribute(){
        return $this->typeDocument=substr($this->RIF,0,1);
    }

    public function getDocumentAttribute(){
        return $this->document=substr($this->RIF,1,11);
    }


    public function getOperatorAttribute(){
        return $this->operator=substr($this->phone,0,6);
    }

    public function getNumberPhoneAttribute(){
        return $this->phone=substr($this->phone,6,11);
    }

}
