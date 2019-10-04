<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Bank;
class PaymentsImport implements ToCollection
{
    /**
    * @param Collection $collection
    */


    public function collection(Collection $rows){
        foreach ($rows as $row) {


           if(!is_null($row[0])){
                Bank::create([
                    'ref' => $row[0],
                    'bank' => $row[1],
                ]);

            }

        }
    }
}
