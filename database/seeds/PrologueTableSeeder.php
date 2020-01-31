<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PrologueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('prologue')->insert([
            'name'=>'ACTIVIDAD ÉCONOMICA-ANTICIPADA',
            'branch'=>'Act.Eco.Anti',
            'date_limit'=>'2020-01-14',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);


        DB::table('prologue')->insert([
            'name'=>'ACTIVIDAD ÉCONOMICA-DEFINITIVA',
            'branch'=>'Act.Eco.Defi',
            'date_limit'=>'2020-01-31',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);


        DB::table('prologue')->insert([
            'name'=>'VEHICULO',
            'branch'=>'Pat.Veh',
            'date_limit'=>'2020-01-31',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);



        DB::table('prologue')->insert([
            'name'=>'INMUEBLE URBANOS',
            'branch'=>'Inm.Urbanos',
            'date_limit'=>'2020-03-31',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);


    }
}
