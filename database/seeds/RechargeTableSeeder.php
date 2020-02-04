<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class RechargeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){



        DB::table('recharges')->insert([
            'name'=>'RECARGO DE ACTIVIDAD ECONOMICA',
            'value'=>12,
            'branch'=>'Act.Eco',
            'since'=>'2019-01-01',
            'to'=>'2020-01-01',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);


        DB::table('recharges')->insert([
            'name'=>'RECARGO DE PATENTE DE VEHÍCULO',
            'value'=>20,
            'branch'=>'Pat.Vehiculo',
            'since'=>'2019-01-01',
            'to'=>'2020-01-01',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('recharges')->insert([
            'name'=>'RECARGO DE INMUEBLES URBANOS',
            'value'=>12,
            'branch'=>'Inm.Urbanos',
            'since'=>'2019-01-01',
            'to'=>'2020-01-01',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

    }
}
