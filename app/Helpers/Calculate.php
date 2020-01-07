<?php
namespace App\Helpers;
use App\Taxe;
use App\CiuTaxes;
use App\Company;


class Calculate{
    public static function calculateTaxes($id){
        $amountInterest=0;//total de intereses
        $amountRecargo=0;//total de recargos
        $amountCiiu=0;//total de ciiu
        $amountDesc=0;//Descuento
        $amountTax=0;

        $withholding_sub=0;

        $credits_fiscal_sub=0;

        $deductions_sub=0;





        $taxes=Taxe::find($id);
        $companyTaxes=$taxes->companies()->get();
        $ciuTaxes=CiuTaxes::where('taxe_id',$id)->get();
        $company_find = Company::find($companyTaxes[0]->id);



        foreach ($ciuTaxes as $ciu){
            $amountInterest+=$ciu->interest;
            $amountRecargo=$ciu->recharge;
            $amountCiiu+=$ciu->totalCiiu+$ciu->recharge+$ciu->interest;


            /*
            if($company_find->TypeCompany==='R'){
                $amountCiiu+=$ciu->totalCiiu+$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits;
            }else{
                //$amountCiiu+=$ciu->totalCiiu-$ciu->withholding-$ciu->fiscal_credits-$ciu->dedutions;
            }
            */
        }




        foreach ($companyTaxes as $companyTax){

            if($company_find->TypeCompany==='R'){
                $withholding_sub=$amountCiiu+$companyTax->pivot->withholding;
                $credits_fiscal_sub= $withholding_sub-$companyTax->pivot->fiscal_credits;
                $deductions_sub=$credits_fiscal_sub-$companyTax->pivot->deductions;
                $amountTax+=$deductions_sub;
            }else{
                $withholding_sub=$amountCiiu-$companyTax->pivot->withholding;
                $credits_fiscal_sub= $withholding_sub-$companyTax->pivot->fiscal_credits;
                $deductions_sub=$credits_fiscal_sub-$companyTax->pivot->deductions;
                $amountTax+=$deductions_sub;
            }


        }




        if($amountTax<0){
            $amountTax=0;
        }


        //si tiene descuento
       /* if($company_find->desc){
            $employees = Employees::all();
            foreach ($employees as $employee){
                if ($company_find->number_employees >= $employee->min) {
                    if ($company_find->number_employees <= $employee->max) {
                        $amountDesc=$amountTaxes*$employee->value/100;

                    }
                }
            }


            $amountTaxes=round($amountTaxes-$amountDesc,2);//descuento
        }*/

        $amount= [
            'amountInterest'=>$amountInterest,
            'amountRecargo'=>$amountRecargo,
            'amountCiiu'=>$amountCiiu,
            'amountTotal'=>$amountTax,
            'amountDesc'=>$amountDesc,
            'credits_sub'=>$credits_fiscal_sub,
            'deductions_sub'=>$deductions_sub,
            'withholding_sub'=>$withholding_sub
        ];
        return $amount;
    }





}