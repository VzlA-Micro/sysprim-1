<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Payment extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;

    protected $table='payments';
    protected $appends = ['statusName','nameBank'];



    public function taxes(){
        return $this->belongsToMany('App\Taxe','payments_taxes')
            ->withPivot('taxe_id');
    }



    public function getNameBankAttribute(){
        if($this->bank==44){
            return $this->nameBank="BOD";
        }else if($this->bank==77){
            return $this->nameBank="BICENTENARIO";
        }else if ($this->bank==99){
            return $this->nameBank="BNC";
        }else if($this->bank==33){
            return $this->nameBank="100%BANCO";
        }else if($this->bank==55){
            return  $this->nameBank="BANESCO";
        }
    }


    public function getStatusNameAttribute(){
        if($this->status=='process'){
            return $this->statusName="EN PROCESO";
        }else if($this->status=='verified'){
            return $this->statusName="VERIFICADO";
        }else if ($this->status=='cancel'){
            return $this->statusName='CANCELADO';
        }
    }




    //
}
