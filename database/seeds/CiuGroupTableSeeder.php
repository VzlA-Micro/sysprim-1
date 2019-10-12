<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CiuGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('group_ciu')->insert([
            'name'=>'FABRICACION DE PRODUCTOS FARMACEUTICOS  Y MEDICAMENTOS',
            'code'=>'3522',
        ]);


        DB::table('group_ciu')->insert([
            'name'=>'ARTICULOS DE FERRETERÍA',
            'code'=>'6104',

        ]);

        DB::table('group_ciu')->insert([
            'name'=>'FARMACIAS, BOTICAS Y EXPENDIOS DE MEDICINAS',
            'code'=>'6202',
        ]);


    }
}
