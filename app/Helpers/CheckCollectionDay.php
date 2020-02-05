<?php



namespace App\Helpers;
use App\Prologue;
use Carbon\Carbon;




class CheckCollectionDay{
    public static function  verify($branch=null){
        /**
        branch:Ramos del impuesto revisar tabla prologue para ver los ramos.
        verify:Parametro que retorna la funcion si verify :
         * true:PAGO FUERA DE LAPSO.
         * false:Esta pagando en lapso correspondiente
         *
         */

        $now=Carbon::now();
        $verify=[];


        $prologue=Prologue::where('branch', $branch)->first();
        $date_limit=Carbon::parse($prologue->date_limit);


            if($now->gt($date_limit)){
                $verify['mora']=true;
                $verify['diffDayMora']=$date_limit->diffInDays($now);
            }else{
                $verify['mora']=false;
                $verify['diffDayMora']=0;
            }

        return $verify;
    }

}