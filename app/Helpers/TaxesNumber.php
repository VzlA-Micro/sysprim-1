<?php


namespace App\Helpers;


/*Genera
los codigos de
de planilla de impuesto*/
use Illuminate\Support\Facades\DB;

class TaxesNumber{

    public static function generateNumber(){
        $code=DB::table('taxes')->select('code')->orderByDesc('id')->take(1)->get();

        if($code->isEmpty()){
            $number_generated=strtoupper(date('M')."-".str_pad(1, 6, '0', STR_PAD_LEFT));
            return $number_generated;
        }else{
            $code[strlen($code)-1]="";//QUITO LA ULTIMA LETRA DE LA CADENA
            $number=explode('-',$code);//LUEGO SOLO BUSCO LO NUMEROS
            $number_integer=(int)$number[1];//LOS COVIERTOS A UN ENTERO PARA PORDER SUMARLA 1 Y SEGUIR LA SECUENCIA
            $number_generated=strtoupper(date('M')."-".str_pad($number_integer+1, 6, '0', STR_PAD_LEFT));
            return $number_generated;
        }
    }

}