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
    public  static function verify($id,$notification=true){
        date_default_timezone_set('America/Caracas');//Estableciendo hora local;
        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $date = null;
        $company = Company::find($id);

        $dayMoraEspecial=5;//el dia de cobro para lo que tienen mora y son agente de retencion
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
                $now->setDay(1);

                $date =array(
                    'mount_pay' =>$mes.'-'.$now->format('Y'),
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
                if($now_pay->format('d')<=$dayMoraEspecial){
                    $mora=false;
                }else{
                    $mora=true;
                    $diffDayMora=$now_pay->format('d')-$dayMoraEspecial;
                }
            }else{
                if($now_pay->format('d')<=$dayMoraNormal){
                    $mora=false;
                }else{
                    $diffDayMora=$now_pay->format('d')-$dayMoraNormal;
                    $mora=true;
                }
            }

            if ($companyTaxes[0]->status!==null) {
                $now_pay->subMonth(1);
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