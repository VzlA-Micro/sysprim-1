<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CatastralConstruccionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('value_catastral_construccion')->insert([
            'name'=>'Vivienda Nivel Social',
            'regimen_propiedad'=>'horizontal',
            'value_edificacion'=>48.00,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
