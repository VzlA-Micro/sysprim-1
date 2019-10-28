<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CatastralTerrenoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('value_catastral_terreno')->insert([
            'sector_nueva_nomenclatura'=>0,
            'sector_catastral'=>101,
            'name'=>'Urb Gil Fortoul',
            'value_terreno_construccion'=>3.125,
            'value_terreno_vacio'=>3.125,
            'parish_id'=>1,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
