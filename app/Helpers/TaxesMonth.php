<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Notification;
use Illuminate\Support\Carbon;
use App\Payments;


class TaxesMonth{
    static public $mounths=array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
    public  static function verify($id,$notification=true){
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $date = null;
        $company = Company::find($id);

        $dayMoraEspecial=20;//el dia de cobro para lo que tienen mora y son agente de retencion
        $dayMoraNormal=14;//el dia de cobro para lo que no son agente de retención
        $diffDayMora=0;

        $companyTaxes = $company->taxesCompanies()->orderByDesc('id')->take(1)->get();//busco el ultimo pago realizado por la empresa

        if ($companyTaxes->isEmpty()) {//si no tiene pagos

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
                $now->subMonth(1);
                $date =array(
                    'mount_pay' =>$mes.'-'.$now->format('Y'),
                    'fiscal_period'=>$now->format('Y-m-d'),
                    'mora'=>$mora,
                    'diffDayMora'=>$diffDayMora
                );
        } else {//si tiene datos
            $fiscal_period = Carbon::parse($companyTaxes[0]->fiscal_period);//utilizo el ultimo pago realido valido y lo tomo como refencia
            $now = Carbon::now();//fecha del computador


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


            if ($companyTaxes[0]->status!==null) {
                $now->subMonth(1);
                if ($companyTaxes[0]->status === 'verified' && $companyTaxes[0]->fiscal_period==$now->format('Y-m-d')) {
                    $date = null;
                    $mes=null;
                } else{
                    $mes=self::$mounths[($now->format('m'))-1];
                    $date = array(
                        'mount_pay' => $mes.'-'.$now->format('Y'),
                        'fiscal_period'=>$now->format('Y-m-d'),
                        'mora'=>$mora,
                        'diffDayMora'=>$diffDayMora);

                }
            }

        }

        if($notification){
            self::createNotification($company->name, $mes, $date);
        }else{
            return $date;
        }


    }


    public  static  function createNotification($name,$mes,$data){
        $notifications=Notification::where('type_notification','date-'.$mes)->where('title',$name)->get();
        if($data!=null&&($notifications->isEmpty()||$notifications[0]->title!=$name)){

        }

    }

    public static function convertFiscalPeriod($fiscal_period){
        $fiscal_period = Carbon::parse($fiscal_period);
        $fiscal_period_format=self::$mounths[($fiscal_period->format('m'))-1]."-".$fiscal_period->format('Y');
        return $fiscal_period_format;
    }

}