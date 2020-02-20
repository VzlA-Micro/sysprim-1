<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Tributo;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use App\TimelineCiiu;
class CiuTaxes extends Model implements Auditable

{

    use \OwenIt\Auditing\Auditable;
    protected $table = 'ciu_taxes';
    protected $appends = ['totalCiiu','totalCiiuDefinitive'];



    public function getTotalCiiuAttribute(){
        $fiscal_period=Carbon::parse($this->taxes->fiscal_period)->format('Y');


        $ciu=TimelineCiiu::where('ciu_id',$this->ciu_id)->whereYear('since','<=',$fiscal_period)->whereYear('to','>=',$fiscal_period)->first();

        if (is_null($ciu)) {
            $ciu = TimelineCiiu::where('ciu_id',$this->ciu_id)->orderBy('id', 'desc')->take(1)->first();
        }



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
