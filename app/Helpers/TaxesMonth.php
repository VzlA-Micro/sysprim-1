<?php
namespace App\Helpers;
use App\Taxe;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Notification;
use Illuminate\Support\Carbon;
use App\Payments;


class TaxesMonth{
    static public $mounths=array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
    public  static function verify($id,$temporal=true){
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $date = null;
        $company = Company::find($id);
        $now_pay = Carbon::now();//fecha de pago
        $companyTaxes = $company->taxesCompanies()->where('type','actuated')->where('branch','Act.Eco')->whereYear('created_at',$now_pay->format('Y'))->orderByDesc('id')->get();//busco el ultimo pago realizado por la empresa
        $mount_pay=null;

        if (!$companyTaxes->isEmpty()){
            foreach ($companyTaxes as $tax){
                if($tax->status!=='cancel'){
                    if($tax->status=='process'&&$tax->created_at->format('Y-d-m')==$now_pay->format('Y-d-m')){
                        $mount_pay[$tax->fiscal_period]=$tax->statusName;
                    }
                }
            }
        }else{
           $mount_pay=null;
        }


        if($temporal){
            $companyTaxes = $company->taxesCompanies()->where('status','=','temporal')->get();//busco el ultimo pago realizado por la empresa
            $companyTaxes = $company->taxesCompanies()->where('status','=','temporal')->get();//busco el ultimo pago realizado por la empresa
            $mount_pay=null;
            if (!$companyTaxes->isEmpty()){
                foreach ($companyTaxes as $tax){
                    if($tax->status!=='cancel'){
                        $tax=Taxe::find($tax->id);
                        $tax->delete();
                    }
                }
            }else{
                $mount_pay=null;
            }
        }

        return $mount_pay;



        /*if ($companyTaxes->isEmpty()) {//si no tiene pagos

            $fiscal_period = Carbon::parse('2019-12-01');//utilizo la fecha que se creo el registro como referencia si esta atrasado o no

                $now = Carbon::now();//fecha del computador
                $mes=self::$mounths[($now->format('m')-1)-1];

                if($company->typeCompany==='R'){
                    if($now->format('d')<=$dayMoraEspecial){
                        $mora=false;
                    }else{
                        $mora=true;
                        $diffDayMora=$now->format('d')-$dayMoraEspecial;
                    }
                }else{
                    if($now->format('d')<=$dayMoraNormal){
                        $mora=false;
                    }else{
                        $diffDayMora=$now->format('d')-$dayMoraNormal;
                        $mora=true;
                    }
                }


                $date =array(
                    'fiscal_period'=>$now->format('Y-m-d'),
                    'mora'=>$mora,
                    'diffDayMora'=>$diffDayMora,
                    'status'=>'new_pay'

                );

        } else {//si tiene datos


            $fiscal_period = Carbon::parse($companyTaxes[0]->fiscal_period);//utilizo el ultimo pago realido valido y lo tomo como refencia
            $now_pay = Carbon::now();//fecha de pago
            $now_date=Carbon::now()->format('Y-m-d');

            if($company->typeCompany==='R'){
                if($fiscal_period->diffInDays($now_pay)<=$dayMoraEspecial){
                    $mora=false;
                }else{
                    $mora=true;
                    $diffDayMora=$fiscal_period->diffInDays($now_pay)-$dayMoraEspecial;
                }
            }else{
                if($fiscal_period->diffInDays($now_pay)<=$dayMoraNormal){
                    $mora=false;
                }else{
                    $diffDayMora=$fiscal_period->diffInDays($now_pay)-$dayMoraNormal;
                    $mora=true;
                }
            }

            if ($companyTaxes[0]->status!==null) {
                $now_pay->setDay(1);

                if ($companyTaxes[0]->status ==='verified' && $fiscal_period->format('m')===$now_pay->format('m')) {
                    $date = null;
                    $mes=null;
                }else{
                    $date_company=$companyTaxes[0]->created_at->format('Y-m-d');
                    if($companyTaxes[0]->status=='process'&&$date_company!==$now_date){
                        $mes=self::$mounths[($now_pay->format('m'))-1];
                        $date = array(
                            'mount_pay' => $mes.'-'.$now_pay->format('Y'),
                            'fiscal_period'=>$now_pay->format('Y-m-d'),
                            'mora'=>$mora,
                            'diffDayMora'=>$diffDayMora,
                            'status'=>'cancel'
                        );


                    }else if($companyTaxes[0]->status=='process'&&$date_company===$now_date){
                        $mes=self::$mounths[($now_pay->format('m'))-1];
                        $date = array(
                            'mount_pay' => $mes.'-'.$now_pay->format('Y'),
                            'fiscal_period'=>$now_pay->format('Y-m-d'),
                            'mora'=>$mora,
                            'diffDayMora'=>$diffDayMora,
                            'status'=>'process'
                        );
                    }else if($companyTaxes[0]->status ==='verified' && $fiscal_period->format('m')!=$now_pay->format('m')){
                        $mes=self::$mounths[($now_pay->format('m'))-1];
                        $date = array(
                            'mount_pay' => $mes.'-'.$now_pay->format('Y'),
                            'fiscal_period'=>$now_pay->format('Y-m-d'),
                            'mora'=>$mora,
                            'diffDayMora'=>$diffDayMora,
                            'status'=>'new_pay'
                        );
                    }else if($companyTaxes[0]->status==='temporal'){
                        $mes=self::$mounths[($now_pay->format('m'))-1];
                        $date = array(
                            'mount_pay' => $mes.'-'.$now_pay->format('Y'),
                            'fiscal_period'=>$now_pay->format('Y-m-d'),
                            'mora'=>$mora,
                            'diffDayMora'=>$diffDayMora,
                            'status'=>'new_pay'
                        );

                        $taxe_find=Taxe::find($companyTaxes[0]->id);
                        $taxe_find->delete();
                    }
                }


            }

        }

        if($notification){
            self::createNotification($company->name, $mes, $date);
        }else{
            return $date;
        }
        */

    }


    public static function verifyDefinitive($id){
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $date = null;
        $company = Company::find($id);
        $now_pay = Carbon::now();//fecha de pago
        $mount_pay=null;
        $range_mount=null;
        $status='';

        $companyTaxes = $company->taxesCompanies()->where('type','definitive')->where('branch','Act.Eco')->first();

        if(is_object($companyTaxes)){
            if($companyTaxes->status==='verified'){
                return $status='verified';
            }else if($companyTaxes->status==='temporal'){
                $companyTaxes->delete();
                return $status='new';
            }else if($companyTaxes->status==='ticket-office' && $companyTaxes->created_at->format('d-m-Y')===$now_pay->format('d-m-Y') ){
                return $status='process';
            } else if($companyTaxes->status==='process'&&$companyTaxes->created_at->format('d-m-Y')===$now_pay->format('d-m-Y')){
                return $status='process';
            }else{
                return $status='new';
            }
        }else{
            return $status='new';
        }



        return $status;
    }





    public  static  function createNotification($name,$mes,$data){
        $notifications=Notification::where('type_notification','date-'.$mes)->where('title',$name)->get();
        if($data!=null&&($notifications->isEmpty()||$notifications[0]->title!=$name)){
        }
    }



    public static  function  calculateDayMora($fiscal_period, $type_company){
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $dayMoraEspecial=5;//el dia de cobro para lo que tienen mora y son agente de retencion
        $dayMoraNormal=14;//el dia de cobro para lo que no son agente de retención
        $diffDayMora=0;
        $fiscal_period=Carbon::parse($fiscal_period);
        $now_pay = Carbon::now();//fecha de pago


        if($now_pay->diffInMonths($fiscal_period)<2){
            $now_pay->subMonth(1);
        }

        if($type_company==='R'){
            $day_payment=Carbon::now()->setDay(5);
            $nombre_dia=date('w', strtotime($day_payment));
            if($now_pay->diffInMonths($fiscal_period)<2) {
                if ($nombre_dia == 06) {
                    $dayMoraEspecial = $dayMoraEspecial + 2;
                } else if ($nombre_dia == 0) {
                    $dayMoraEspecial = $dayMoraEspecial + 1;
                }
            }
            $fiscal_period->setDay($dayMoraEspecial);

            if($fiscal_period->diffInDays($now_pay)<=$dayMoraEspecial){
                $mora=false;
            }else{
                $mora=true;
                $diffDayMora=$fiscal_period->diffInDays($now_pay);
            }
        }else{
            $day_payment=Carbon::now()->setDay(14);
            $nombre_dia=date('w', strtotime($day_payment));

            if($now_pay->diffInMonths($fiscal_period)<2){
                if($nombre_dia=="06"&&$now_pay->diffInMonths($fiscal_period)<2){
                    $dayMoraNormal=$dayMoraNormal+2;
                }else if($nombre_dia=="0"){
                    $dayMoraNormal=$dayMoraNormal+1;
                }
            }

            $fiscal_period->setDay($dayMoraNormal);
            if($fiscal_period<$now_pay){
                $diffDayMora=$fiscal_period->diffInDays($now_pay);
                $mora=true;
            }else{
                $diffDayMora=0;
                $mora=false;
            }



        }

        return array('mora'=>$mora,'diffDayMora'=>$diffDayMora);
    }

    public static function convertFiscalPeriod($fiscal_period){
        $fiscal_period = Carbon::parse($fiscal_period);
        $fiscal_period_format=self::$mounths[($fiscal_period->format('m'))-1]."-".$fiscal_period->format('Y');
        return $fiscal_period_format;
    }
}