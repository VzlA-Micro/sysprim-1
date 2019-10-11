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
            'code'=>'352201',
            'name'=>'FABRICACION DE PRODUCTOS FARMACEUTICOS Y MEDICAMENTOS ',
            'alicuota'=>1,
            'min_tribu_men'=>6,
            'group_ciu_id'=>1,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);


        DB::table('ciu')->insert([
            'name'=>'MAYOR DE ARTICULOS DE FERRETERIA',
            'code'=>'610401',
            'alicuota'=>5,
            'min_tribu_men'=>6,
            'group_ciu_id'=>2,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);


        DB::table('ciu')->insert([
            'name'=>'MAYOR DE PINTURAS LACAS Y BARNICES',
            'code'=>'610402',
            'alicuota'=>5,
            'min_tribu_men'=>6,
            'group_ciu_id'=>2,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('ciu')->insert([
            'name'=>'MAYOR DE ARTICULOS Y MATERIALES ELECTRICOS',
            'code'=>'610403',
            'alicuota'=>5,
            'min_tribu_men'=>6,
            'group_ciu_id'=>2,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);


        DB::table('ciu')->insert([
            'name'=>'FARMACIAS, BOTICAS Y EXPENDIOS DE MEDICINAS',
            'code'=>'620201',
            'alicuota'=>3,
            'min_tribu_men'=>4,
            'group_ciu_id'=>3,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('ciu')->insert([
            'name'=>'PERFUMERIAS, COSMETICOS, ARTICULOS DE TOCADOR Y PREPARADOS AFINES NACIONALES E IMPORTADOS',
            'code'=>'620202',
            'alicuota'=>3,
            'min_tribu_men'=>9,
            'group_ciu_id'=>3,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);


        DB::table('ciu')->insert([
            'name'=>'OTROS PRODUCTOS DE VENTAS USUAL EN FARMACIA NO ESPECIFICADA EN OTRA PARTE',
            'code'=>'620203',
            'alicuota'=>3,
            'min_tribu_men'=>9,
            'group_ciu_id'=>3,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);



    }
}
