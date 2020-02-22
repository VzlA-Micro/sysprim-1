<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Taxe extends Model implements Auditable {
    protected $table="taxes";
    use \OwenIt\Auditing\Auditable;
    protected $appends = ['total', 'typePayment', 'bankName','statusName','typeTaxes','amountFormat','fiscalPeriodFormat'];

    public function taxesCiu(){
        return $this->belongsToMany('App\Ciu','ciu_taxes')
            ->withPivot('ciu_id',
                'taxable_minimum',
                'base',
                'tax_unit',
                'recharge',
                'interest',
                'base_anticipated'
            );
    }




    public function rateTaxes(){
        return $this->belongsToMany('App\Rate','rates_taxes')
            ->withPivot(
                'company_id',
                'user_id',
                'tax_unit',
                'cant_tax_unit',
                'person_id'
            );
    }

    public function VehicleTaxes(){
        return $this->belongsToMany('App\Vehicle','vehicles_taxes')
            ->withPivot(
                'vehicle_id',
                'fiscal_credits',
                'recharge',
                'recharge_mora',
                'base_imponible',
                'discount',
                'previous_debt',
                'type_payments'
            );
    }



    public function companies(){
        return $this->belongsToMany('App\Company','company_taxes')
            ->withPivot('company_id', 'fiscal_credits', 'withholding', 'deductions', 'day_mora');
    }



    public function companiesRate(){

    }


    public function properties() {
        return $this->belongsToMany('App\Property','property_taxes')
            ->withPivot('property_id', 'recharge',
                                'base_imponible', 'alicuota',
                                'interest', 'discount', 'fiscal_credit');
    }

    public function publicities() {
        return $this->belongsToMany('App\Publicity','publicity_taxes')
            ->withPivot('publicity_id','base_imponible', 'fiscal_credit', 'interest', 'increment');
    }




    public function vehicles(){
        return $this->belongsToMany('App\VehiclesTaxe','taxe_id');
    }


    public function payments(){
        return $this->belongsToMany('App\Payment','payments_taxes')
            ->withPivot('payment_id');
    }

    public function getTotalAttribute(){



    }


    public function getTypeTaxesAttribute(){
        if($this->type=='definitive'){
            return $this->typeTaxes='DEFINITIVA';
        }else{
            return $this->typeTaxes='ANTICIPADA';
        }
    }


    public function getStatusNameAttribute(){
        if($this->status=='process'){
            return $this->statusName="SIN CONCILIAR AÚN";
        }else if($this->status=='verified'){
            return $this->statusName="VERIFICADA";
        }else if ($this->status=='cancel'){
            return $this->statusName='CANCELADA';
        }else if($this->status=='ticket-office'){
            return $this->statusName='TAQUILLA/SIN PAGO ASOCIADO AÚN.';
        }else if($this->status=='verified-sysprim'){
            return $this->statusName="VERIFICADA/SYSPRIM";
        }

    }

    public function getTypePaymentAttribute()
    {
        $type = substr($this->code, 0, 3);


        if ($type == 'PPV') {
            return  $this->typePayment = "PUNTO DE VENTA";
        } else if ($type == "PPC") {
            return $this->typePayment = "DEPOSITO BANCARIO(CHEQUE)";
        }else if ($type == "PPE") {
            return $this->typePayment = "DEPOSITO BANCARIO(EFECTIVO)";
        } else if ($type == 'PPT') {
            return $this->typePayment = "TRASNFERENCIA BANCARIA";
        }else if($type=='PTS'){
            return $this->typePayment = "TAQUILLA SEMAT";
        }


    }

    public function getBankNameAttribute(){
        if($this->bank==44){
            return $this->bankName="BOD";
        }else if($this->bank==77){
            return $this->bankName="BICENTENARIO";
        }else if ($this->bank==99){
            return $this->bankName="BNC";
        }else if($this->bank==33){
             return $this->bankName="100%BANCO";
        }else if($this->bank==55){
           return  $this->bankName="BANESCO";
        }else{
            return $this->bankName="S/N";
        }


    }


    public function ciuTaxes(){
        return $this->hasMany('App\CiuTaxes','ciu_id');
    }

    public function getAmountFormatAttribute(){
        return  number_format($this->amount,2);
    }

    public function getFiscalPeriodFormatAttribute(){
        return Carbon::parse($this->fiscal_period)->format('d-m-Y');
    }



}
