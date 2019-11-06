<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use App\Bank;
use App\Ciu;
use App\GroupCiiu;
use App\PropertyTmp;

class PaymentsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */


    public function collection(Collection $rows)
    {
        $last_id = null;
        foreach ($rows as $row) {
            //ESTO ES PARA IMPORTAR LOS CODIGOS CATASTRALES
            /*
            if ($row[3] !== null && !empty($row[3])) {
                $lon = strlen($row[1]);
                if ($lon < 11) {
                    $property = new PropertyTmp();
                    $property->documents = $row[1];
                    $property->name = $row[2];
                    $property->code_cadastral = $row[3];
                    $property->direction = $row[4];
                    $property->save();
                }
            }*/

            /*
             * ESTO ES PARA IMPORTAR LOS GRUPOS DE CODIGOS CIIU
             * if ($row[3] == null && $row[2] !== null) {
                $ciiuGroup=new GroupCiiu();
                $ciiuGroup->code=$row[1];
                $ciiuGroup->name=$row[2];
                $ciiuGroup->save();
                $last_id = DB::getPDO()->lastInsertId();
            }

            *ESTO ES PARA IMPORTAR LOS CODIGOS CIIU YA ENLAZADO CON SUS GRUPOS DE CIIU
            if ($row[2] !== null && $row[3] !== null) {

                $ciu= new Ciu();
                $ciu->code=$row[1];
                $ciu->name=$row[2];
                $ciu->alicuota=$row[3];
                $ciu->min_tribu_men=$row[4];
                $ciu->group_ciu_id=$last_id;
                $ciu->save();

            }*/
            /*
             * ESTO ES PARA IMPORTAR LOS ESTADOS DE CUENTAS
             * Bank::create([
                'ref' => $row[0],
                'bank' => $row[1],
                'amount'=> $row[2],
                'name_deposito'=> $row[3],
                'surname_deposito'=> $row[4],
                'cedula'=>$row[5]
            ]);*/
        }

    }

}
