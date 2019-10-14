<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Notification;
use Illuminate\Support\Carbon;
use App\PaymentTaxes;
class TaxesMonth{
    static public $mounths=array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
    public  static function verify($id,$notification=true){

        setlocale(LC_ALL, "es_ES");//establecer idioma local
        $date = null;
        $company = Company::find($id);


        $companyTaxes = $company->taxesCompanies()->orderByDesc('id')->take(1)->get();//busco el ultimo pago realizado por la empresa

        if ($companyTaxes->isEmpty()) {//si no tiene pagos


            $fiscal_period = Carbon::parse($company->created_at);//utilizo la fecha que se creo el registro como referencia si esta atrasado o no
            $now = Carbon::now();//fecha del computador
            $diffMount = $fiscal_period->diffInMonths($now);//veo la diferencia de meses

            if($diffMount>=1){
                $mes=self::$mounths[($fiscal_period->format('m'))-1];
                $date = array('mount_pay' =>$mes.'-'.$fiscal_period->format('Y'), 'mount_diff' => $diffMount,'fiscal_period'=>$fiscal_period->format('Y-m-d'));
            }else{
                $date=null;
                $mes=null;
            }


        } else {//si tiene datos

            $fiscal_period = Carbon::parse($companyTaxes[0]->fiscal_period);//utilizo el ultimo pago realido valido y lo tomo como refencia
            $now = Carbon::now();//fecha del computador
            $diffMount = $fiscal_period->diffInMonths($now);
            $payment = PaymentTaxes::where('taxe_id', $companyTaxes[0]->id)->get();//busco si el pago fue realizo

            if ($diffMount >= 1 || $payment->isEmpty()) {
                if (!$payment->isEmpty() && $payment[0]->status === 'verified' && $diffMount > 1) {
                    $diffMount--;//resto 1 a la diferencia de mes porque este utilimo esta pago
                    $fiscal_period->addMonth(1);//añado un mes para saber cual es el proximo a pagar
                    $mes=self::$mounths[($fiscal_period->format('m'))-1];
                    $date = array('mount_pay' => $mes.'-'.$fiscal_period->format('Y'), 'mount_diff' => $diffMount,'fiscal_period'=>$fiscal_period->format('Y-m-d'));

                } else if (!$payment->isEmpty() && $payment[0]->status === 'verified') {//si no esta vacio y el pago esta verificado,y no hay diferencia de mes, esta al dia.
                    $date = null;
                    $mes=null;
                } else {
                    $mes=self::$mounths[($fiscal_period->format('m'))-1];
                    $date = array('mount_pay' => $mes.'-'.$fiscal_period->format('Y'),
                        'mount_diff' => $diffMount,'fiscal_period'=>$fiscal_period->format('Y-m-d'));
                }
            }

        }

        if($notification){
            self::createNotification($company->name, $mes, $diffMount, $date);
        }else{
            return $date;
        }


    }


    public  static  function createNotification($name,$mes,$diffMount,$data){
        $notifications=Notification::where('type_notification','date-'.$mes)->where('title',$name)->get();
        if($data!=null&&($notifications->isEmpty()||$notifications[0]->title!=$name)){
            $notification=new Notification();
            $notification->type_notification='date-'.$mes;
            $notification->title=$name;
            if($diffMount==1){
                $notification->content="Estimado contribuyente, esta atrasado en sus pago por ". $diffMount ." mes,<br>por favor cancele el mes de ".$mes.".";
            }else{
                $notification->content="Estimado contribuyente, esta atrasado en sus pago por ". $diffMount ." meses,<br>por favor cancele el mes de ".$mes.".";
            }

            $notification->view=0;
            $notification->user_id=\Auth::user()->id;
            $notification->save();
        }

    }

    public static function convertFiscalPeriod($fiscal_period){
        $fiscal_period = Carbon::parse($fiscal_period);
        $fiscal_period_format=self::$mounths[($fiscal_period->format('m'))-1]."-".$fiscal_period->format('Y');
        return $fiscal_period_format;
    }

}