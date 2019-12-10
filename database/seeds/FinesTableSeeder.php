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
            'name'=>'MULTA POR PAGO FUERA DE LAPSO ACT/ECO.',
            'cant_unid_tribu'=>300,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);

    }




}
