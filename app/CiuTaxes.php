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
        if($this->base!=0){
            $this->totalCiiuDefinitive=($this->base*$ciu->alicuota)-$this->base_anticipated;
        }else{
            $unid_tribu=Tributo::orderBy('id', 'desc')->take(1)->get();
            $this->totalCiiuDefinitive=$ciu->min_tribu_men*12*$unid_tribu[0]->value;
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
