<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tributo;
class CiuTaxes extends Model
{
    protected $table = 'ciu_taxes';
    protected $appends = ['totalCiiu'];



    //

    public function getTotalCiiuAttribute(){
        $ciu=Ciu::find($this->ciu_id);
        if($this->base!=0){
            $this->totalCiiu=$this->base*$ciu->alicuota;
        }else{
            $unid_tribu=Tributo::orderBy('id', 'desc')->take(1)->get();
            $this->totalCiiu=$ciu->min_tribu_men*$unid_tribu[0]->value;
        }
        return $this->attributes['totalCiiu'];
    }



    public function ciu(){
        return $this->belongsTo('App\Ciu','ciu_id');
    }



}
