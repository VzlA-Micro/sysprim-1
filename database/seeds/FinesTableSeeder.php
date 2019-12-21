<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;



class FinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fines')->insert([
            'name'=>'MULTA POR PAGO FUERA DE LAPSO.',
            'cant_unid_tribu'=>300,
            'branch'=>'Act.Economica',
            'description'=>'No pago en el plazo determinado',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);

    }




}
