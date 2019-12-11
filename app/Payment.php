<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Payment extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;

    protected $table='payments';
    protected $appends = ['bankName'];



    public function taxes(){
        return $this->belongsToMany('App\Taxe','payments_taxes')
            ->withPivot('taxe_id');
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
        }
    }


    //
}
