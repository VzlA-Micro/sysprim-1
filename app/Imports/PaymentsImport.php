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
<<<<<<< HEAD
                    'amount'=> $row[2],
                    'name_deposito'=> $row[3],
                    'surname_deposito'=> $row[4],
                    'cedula'=>$row[5],
                    'date_transference'=> $row[6]
                ]);
=======
                    'amount'=>$row[2]
		]);
>>>>>>> 897ebd25b563318c3e7d8b1242d8a8bc915028b3

            }

        }
    }
}
