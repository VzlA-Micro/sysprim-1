<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use App\Bank;
use App\Ciu;
use App\GroupCiiu;
use App\PropertyTmp;
use App\CatastralTerreno;
use App\CatastralConstruccion;

class PaymentsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */


    public function collection(Collection $rows)
    {
        $last_id = null;
        foreach ($rows as $row) {

            $catastralConstruccion = new CatastralConstruccion();

            $catastralConstruccion->name = (string)$row[0];
            $catastralConstruccion->value_edificacion = (float)$row[1];
            $catastralConstruccion->regimen_horizontal = (boolean)$row[2];

            $catastralConstruccion->save();

            // ESTO ES PARA IMPORTAR LOS ESTADOS DE CUENTAS
            /*$catastralTerreno = new CatastralTerreno();


            if (is_null($row[0]) && Empty($row[0])) {
                $catastralTerreno->parish_id = (int)0;
                echo "es null";
                //die();
            } else {
                $catastralTerreno->parish_id = (int)$row[0];
                echo "no es null.".$row[0];
                //die();
            }
            if (is_null($row[1])) {
                $catastralTerreno->sector_nueva_nomenclatura = (int)0;
            } else {
                $catastralTerreno->sector_nueva_nomenclatura = (int)$row[1];
            }
            if (is_null($row[2])) {
                $catastralTerreno->sector_catastral = (int)0;
            } else {
                $catastralTerreno->sector_catastral = (int)$row[2];
            }
            if (is_null($row[3])) {
                $catastralTerreno->name = (string)"";
            } else {
                $catastralTerreno->name = (string)$row[3];
            }
            if (is_null($row[4])) {
                $catastralTerreno->value_terreno_construccion = (float)0;
            } else {
                $catastralTerreno->value_terreno_construccion = (float)$row[4];
            }
            if (is_null($row[5])) {
                $catastralTerreno->value_terreno_vacio = (float)0;
            } else {
                $catastralTerreno->value_terreno_vacio = (float)$row[5];
            }
            $catastralTerreno->save();
*/
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
