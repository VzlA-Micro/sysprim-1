<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CiuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ciu')->insert([
            'code'=>'620501',
            'name'=>'FERRETERÍAS',
            'alicuota'=>6.5,
            'min_tribu_men'=>6,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);


        DB::table('ciu')->insert([
            'name'=>'MAYOR DE ARTICULOS DE FERRETERIA, ELECTRICOS Y DE TORNILLERIA NO ESPECIFICADOS',
            'code'=>'610409',
            'alicuota'=>5,
            'min_tribu_men'=>2,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('ciu')->insert([
            'name'=>'FARMACIAS, BOTICAS Y EXPENDIOS DE MEDICINAS ',
            'code'=>'620201',
            'alicuota'=>3,
            'min_tribu_men'=>4,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('ciu')->insert([
            'name'=>'SERVICIOS DE PROGRAMACION Y PROCESAMIENTO DE DATOS ',
            'code'=>'832202',
            'alicuota'=>2.6,
            'min_tribu_men'=>2,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);


        DB::table('ciu')->insert([
            'name'=>'HOSPITALES Y CLINICAS PARA ANIMALES',
            'code'=>'933201',
            'alicuota'=>2,
            'min_tribu_men'=>2,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);


        DB::table('ciu')->insert([
            'name'=>'HOTELES IV Y V ESTRELLAS',
            'code'=>'632001',
            'alicuota'=>10,
            'min_tribu_men'=>8,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);


    }
}
