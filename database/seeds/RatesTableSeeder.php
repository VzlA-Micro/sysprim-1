<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('rates')->insert([
            'code'=>'T400T002',
            'name'=>'COPIAS CERTIFICADA INMUEBLE',
            'type'=>'Act.Eco',
            'cant_tax_unit'=>50,
            'status'=>'active',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('rates')->insert([
            'code'=>'T500T002',
            'name'=>'COPIAS CERTIFICADA VEHICULO',
            'type'=>'Act.Eco',
            'cant_tax_unit'=>50,
            'status'=>'active',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

    }
}
