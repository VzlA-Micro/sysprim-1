<?php


namespace App\Helpers;


/*Genera
los codigos de
de planilla de impuesto*/
use Illuminate\Support\Facades\DB;

class TaxesNumber{

    public static function generateNumberSecret($amount_taxes=null,$date_taxes=null,$code_bank=null,$code_taxes=null){

        //code
        $suma_code=0;
        $producto_code=0;
        $sumPro_code=0;
        $sp_code=0;
        $prod_code=1;
        $prod_code=0;
        $dat_code=0;
        $prod1_code=0;
        $sum1_code=0;

        //bank
        $suma_bank=0;
        $producto_bank=0;
        $sumPro_bank=0;
        $sp_bank=0;
        $prod_bank=1;
        $prod_bank=0;
        $dat_bank=0;
        $prod1_bank=0;
        $sum1_bank=0;


        //General

        $bank=$code_bank;
        $date=$date_taxes;
        $matriz = explode("-", $date);
        $date_format=$matriz[2].$matriz[1].$matriz[0];
        $amount=$amount_taxes;
        $numberTaxes=$code_taxes;

        //date
        $suma_date=0;
        $producto_date=0;
        $sumPro_date=0;
        $sp_date=0;
        $prod_date=1;
        $prod_date=0;
        $dat_date=0;
        $prod1_date=0;
        $sum1_date=0;

        //amount
        $suma_amount=0;
        $producto_amount=0;
        $sumPro_amount=0;
        $sp_amount=0;
        $prod_amount=1;
        $prod_amount=0;
        $dat_amount=0;
        $prod1_amount=0;
        $sum1_amount=0;



        for($i=0;$i<strlen($numberTaxes);$i++){
            $suma_code+=$numberTaxes[$i];
            $pos=$i+1;
            $producto_code+=$numberTaxes[$i]*$pos;
        }

        $sum1_code=$suma_code+$producto_code;





        $sp_code=$sum1_code;
        if($sum1_code<100){
            $sp_code=$sum1_code*100;
        }
        $prod1_code=$suma_code*$producto_code;



        if($prod1_code<100){
            $prod1_code=$prod1_code*100;
        }

        $dat_code=$sp_code+$prod1_code;





        for($i=0;$i<strlen($bank);$i++){
            $suma_bank+=$bank[$i];
            $pos=$i+1;
            $producto_bank+=$bank[$i]*$pos;
        }



        $sum1_bank=$suma_bank+$producto_bank;

        if($sum1_bank<100){
            $sp_bank=$sum1_bank*10;
        }
        $prod1_bank=$suma_bank*$producto_bank;


        if($prod1_bank<100){
                $prod1_bank=$prod1_bank*100;
        }

        $dat_bank=$dat_code+$sp_bank+$prod1_bank;




        for($i=0;$i<strlen($date_format);$i++){
            $suma_date+=$date_format[$i];
            $pos=$i+1;
            $producto_date+=$date_format[$i]*$pos;
        }

        $sum1_date=$suma_date+$producto_date;

        $sp_date=$sum1_date;
        if($sum1_date<100){
            $sp_date=$sum1_date*100;
        }


        $prod1_date=$suma_date*$producto_date;

        if($prod_date<100){
            $prod_date=$prod1_date*100;
        }


        $dat_date=$dat_bank+$sp_date+$prod1_date;


        $amount=$amount*100;


        $amount_format=str_pad($amount, 12,"0",  STR_PAD_LEFT);

        for($i=0;$i<strlen($amount_format);$i++){
                        $suma_amount+=$amount_format[$i];
                        $pos=$i+1;
                        $producto_amount+=$amount_format[$i]*$pos;
            }


        $sum1_amount=$suma_amount+$producto_amount;

        $sp_amount=$sum1_amount;

        if($sum1_amount<100){
            $sp_amount=$sum1_amount*100;
        }

        $prod1_amount=$suma_amount*$producto_amount;

        if($prod1_amount<100){
            $prod1_amount=$prod1_amount*100;
        }


        $dat_amount=$dat_date+$dat_bank+$dat_code+$sp_amount+$prod1_amount;


        $dat1=($dat_amount/11)+strlen($amount)+($matriz[1]*100+$matriz[2]*100);


        if($dat1>999){
            $dat1=round($dat1/10);

        }else if($dat1<100){
            $dat1=$dat1*10;
        }

        return $dat1;
    }


    public static function generateNumberTaxes($type_payments){
        $code=DB::table('taxes')->select('code')//->where('code','LIKE',"%".$type_payments."%")
                        ->orderByDesc('id')->take(1)->get();

        if($code->isEmpty()){
            $number_generated=strtoupper(str_pad(1, 8, '0', STR_PAD_LEFT));
            return $type_payments.$number_generated;
        }else{
            $correlative=substr($code[0]->code,5,13);
            $number_integer=(int)$correlative;//LOS COVIERTOS A UN ENTERO PARA PORDER SUMARLA 1 Y SEGUIR LA SECUENCIA
            $number_generated=strtoupper(str_pad($number_integer+1, 8, '0', STR_PAD_LEFT));
            return $type_payments.$number_generated;
        }
    }


    public static  function generateNumberPayment($type_payments){
        $code=DB::table('payments')->select('code')//->where('code','LIKE',"%".$type_payments."%")
                        ->orderByDesc('id')->take(1)->get();
        if($code->isEmpty()){
            $number_generated=strtoupper(str_pad(1, 8, '0', STR_PAD_LEFT));
            return $type_payments.$number_generated;
        }else{
            $correlative=substr($code[0]->code,5,13);
            $number_integer=(int)$correlative;//LOS COVIERTOS A UN ENTERO PARA PORDER SUMARLA 1 Y SEGUIR LA SECUENCIA
            $number_generated=strtoupper(str_pad($number_integer+1, 8, '0', STR_PAD_LEFT));
            return $type_payments.$number_generated;
        }
    }



}