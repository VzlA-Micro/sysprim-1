<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Taxe extends Model implements Auditable {
    protected $table="taxes";
    use \OwenIt\Auditing\Auditable;
    protected $appends = ['total', 'typePayment', 'bankName','statusName'];

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

    public function getStatusNameAttribute(){
        if($this->status=='process'){

            return $this->statusName="SIN CONCILIAR AÚN";

        }else if($this->status=='verified'){

            return $this->statusName="VERIFICADA";

        }else if ($this->status=='cancel'){
            return $this->statusName='CANCELADA';
        }

    }

    public function getTypePaymentAttribute()
    {
        $type = substr($this->code, 0, 3);


        if ($type == 'PPV') {
            return  $this->typePayment = "PUNTO DE VENTA";
        } else if ($type == "PPB") {
            return $this->typePayment = "DEPOSITO BANCARIO";
        } else if ($type == 'PPT') {
            return $this->typePayment = "TRASNFERENCIA BANCARIA";
        }


    }

    public function getBankNameAttribute(){
        if($this->bank==44){
            return $this->bankName="BOD";
        }else if($this->bank==77){
            return $this->bankName="BINCENTENARIO";
        }else if ($this->bank==99){
            return $this->bankName="BNC";
        }else if($this->bank==33){
             return $this->bankName="100%BANCO";
        }else if($this->bank==55){
           return  $this->bankName="BANESCO";
        }


    }


    public function ciuTaxes(){
        return $this->hasMany('App\CiuTaxes','ciu_id');
    }



}
