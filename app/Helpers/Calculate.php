<?php
namespace App\Helpers;
use App\Taxe;
use App\CiuTaxes;
use App\Extras;
use App\Company;
use App\Employees;

class Calculate{
    public static function calculateTaxes($id){
        $amountInterest=0;//total de intereses
        $amountRecargo=0;//total de recargos
        $amountCiiu=0;//total de ciiu
        $amountDesc=0;//Descuento
        $amountTaxes=0;//total a de impuesto
        $amountTotal=0;


        $taxes=Taxe::find($id);


        $companyTaxe=$taxes->companies()->get();


        $ciuTaxes=CiuTaxes::where('taxe_id',$id)->get();

        $company_find = Company::find($companyTaxe[0]->id);
        $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
        $mora=Extras::orderBy('id', 'desc')->take(1)->get();
        $extra=['tasa'=>$mora[0]->tax_rate];

        foreach ($ciuTaxes as $ciu){
            $amountInterest+=$ciu->interest;
            $amountRecargo+=$ciu->tax_rate;

            if($company_find->TypeCompany==='R'){
                $amountCiiu+=$ciu->totalCiiu+$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits;
            }else{
                $amountCiiu+=$ciu->totalCiiu-$ciu->withholding-$ciu->fiscal_credits-$ciu->dedutions;
            }
        }

        $amountTaxes=$amountInterest+$amountRecargo+$amountCiiu;//Total



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

        $amount=['amountInterest'=>$amountInterest,
            'amountRecargo'=>$amountRecargo,
            'amountCiiu'=>$amountCiiu,
            'amountTotal'=>$amountTaxes,
            'amountDesc'=>$amountDesc
        ];

        return $amount;
    }





}