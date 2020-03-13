<?php



namespace App\Helpers;
use App\Prologue;
use Carbon\Carbon;




class CheckCollectionDay{
    public static function  verify($branch=null,$fiscal_period=null)
    {
        /**
         * branch:Ramos del impuesto revisar tabla prologue para ver los ramos.
         * verify:Parametro que retorna la funcion si verify :
         * true:PAGO FUERA DE LAPSO.
         * false:Esta pagando en lapso correspondiente
         *
         */


        $verify = [];
        $band = false;


        if (!is_null($fiscal_period)) {
            $now = Carbon::now()->setMonth(1)->setDay(1);
            $fiscal_period = Carbon::parse($fiscal_period);
            if ($now->diffInYears($fiscal_period)>=1) {
                $verify['mora'] = true;
                $verify['diffDayMora'] = $fiscal_period->diffInDays($now);
            } else {
                $band = true;
            }
        }else{
            $band=true;
        }

        if($band){
            $now = Carbon::now();
            $prologue=Prologue::where('branch', $branch)->first();
            $date_limit=Carbon::parse($prologue->date_limit);

            if($now->gte($date_limit)&&$date_limit->diffInDays($now)>=1){
                $verify['mora']=true;
                $verify['diffDayMora']=$date_limit->diffInDays($now);
            }else{
                $verify['mora']=false;
                $verify['diffDayMora']=0;
            }
        }




        return $verify;
    }


    public static function  getNameBank($code){
            $name_bank='';
            if($code==44){
                return $name_bank="BOD";
            }else if($code==77){
                return $name_bank="BICENTENARIO";
            }else if ($code==99){
                return $name_bank="BNC";
            }else if($code==33){
                return $name_bank="100%BANCO";
            }else if($code==55){
                return  $name_bank="BANESCO";
            }else{
                return $name_bank="S/N";
            }
    }
}