<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tributo;
class CiuTaxes extends Model{


    protected $table = 'ciu_taxes';
    protected $appends = ['totalCiiu','totalCiiuDefinitive'];



    public function getTotalCiiuAttribute(){
        $ciu=Ciu::find($this->ciu_id);
        $this->totalCiiu=$this->base*$ciu->alicuota;

        if($this->taxable_minimum!=0) {
            $this->totalCiiu=$this->taxable_minimum;
        }

        return $this->attributes['totalCiiu'];
    }

    public function getTotalCiiuDefinitiveAttribute(){
        $ciu=Ciu::find($this->ciu_id);

        $this->totalCiiuDefinitive=($this->base*$ciu->alicuota);
        if($this->taxable_minimum!=0){
            $this->totalCiiuDefinitive=$this->taxable_minimum;
        }

        return $this->attributes['totalCiiuDefinitive'];
    }



    public function ciu(){
        return $this->belongsTo('App\Ciu','ciu_id');
    }

    public function taxes(){
        return $this->belongsTo('App\Taxe','taxe_id');
    }



}
